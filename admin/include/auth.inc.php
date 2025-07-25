<?php

namespace AdminNeo;

$permanent = [];
if ($_COOKIE["neo_permanent"]) {
	foreach (explode(" ", $_COOKIE["neo_permanent"]) as $val) {
		list($key) = explode(":", $val);
		$permanent[$key] = $val;
	}
}

/**
 * @throws \Random\RandomException
 */
function validate_server_input(array &$permanent): void
{
	if (SERVER == "") {
		return;
	}

	$parts = parse_url(SERVER);
	if (!$parts) {
		auth_error($permanent);
	}

	// Check proper URL parts.
	if (isset($parts['user']) || isset($parts['pass']) || isset($parts['query']) || isset($parts['fragment'])) {
		auth_error($permanent);
	}

	// Allow only HTTP/S scheme.
	if (isset($parts['scheme']) && !preg_match('~^(https?)$~i', $parts['scheme'])) {
		auth_error($permanent);
	}

	// Note that "localhost" and IP address without a scheme is parsed as a path.
	$hostPath = ($parts['host'] ?? '') . ($parts['path'] ?? '');

	// Validate host.
	if (!is_server_host_valid($hostPath)) {
		auth_error($permanent);
	}

	// Check privileged ports.
	if (isset($parts['port']) && ($parts['port'] < 1024 || $parts['port'] > 65535)) {
		auth_error($permanent, lang('Connecting to privileged ports is not allowed.'));
	}
}

if (!function_exists('AdminNeo\is_server_host_valid')) {
	/**
	 * @param string $hostPath
	 * @return bool
	 */
	function is_server_host_valid($hostPath)
	{
		return strpos($hostPath, '/') === false;
	}
}

function build_http_url(string $server, string $username, string $password, string $defaultServer, ?int $defaultPort = null): ?string
{
	if (!preg_match('~^(https?://)?([^:]*)(:\d+)?$~', rtrim($server, '/'), $matches)) {
		return null;
	}

	return ($matches[1] ?: "http://") .
		($username !== "" || $password !== "" ? "$username:$password@" : "") .
		($matches[2] !== "" ? $matches[2] : $defaultServer) .
		($matches[3] ?? ($defaultPort ? ":$defaultPort" : ""));
}

function add_invalid_login() {
	$base_name = get_temp_dir() . "/adminneo.invalid";
	// adminer.invalid may not be writable by us, try the files with random suffixes
	$file = null;
	foreach (glob("$base_name*") ?: [$base_name] as $filename) {
		$file = open_file_with_lock($filename);
		if ($file) {
			break;
		}
	}

	if (!$file) {
		$file = open_file_with_lock("$base_name-" . get_random_string());
		if (!$file) {
			return;
		}
	}

	$invalids = unserialize(stream_get_contents($file));
	$time = time();
	if ($invalids) {
		foreach ($invalids as $ip => $val) {
			if ($val[0] < $time) {
				unset($invalids[$ip]);
			}
		}
	}
	$invalid = &$invalids[Admin::get()->getBruteForceKey()];
	if (!$invalid) {
		$invalid = [$time + 30*60, 0]; // active for 30 minutes
	}
	$invalid[1]++;
	write_and_unlock_file($file, serialize($invalids));
}

/**
 * @throws \Random\RandomException
 */
function check_invalid_login(array &$permanent): void
{
	$base_name = get_temp_dir() . "/adminneo.invalid";

	$invalids = [];
	foreach (glob("$base_name*") as $filename) {
		$file = open_file_with_lock($filename);
		if ($file) {
			$invalids = unserialize(stream_get_contents($file));
			unlock_file($file);
			break;
		}
	}

	$invalid = ($invalids ? $invalids[Admin::get()->getBruteForceKey()] : []);

	$next_attempt = ($invalid && $invalid[1] > 29 ? $invalid[0] - time() : 0); // allow 30 invalid attempts
	if ($next_attempt > 0) { //! do the same with permanent login
		auth_error($permanent, lang('Too many unsuccessful logins, try again in %d minute(s).', ceil($next_attempt / 60)));
	}
}

/**
 * @throws \Random\RandomException
 */
function connect_to_db(array &$permanent): Connection
{
	if (Admin::get()->getConfig()->hasServers() && !Admin::get()->getConfig()->getServer(SERVER)) {
		auth_error($permanent);
	}

	$connection = connect(true, $error);
	if (!$connection) {
		connection_error(h($error), $permanent);
	}

	return $connection;
}

/**
 * @throws \Random\RandomException
 */
function authenticate(array &$permanent): void
{
	// Note: Admin::get()->authenticate() method can use primary Database connection.
	// That's why authentication has to be called after successful connection to the database.

	$result = Admin::get()->authenticate($_GET["username"], get_password());
	if ($result !== true) {
		connection_error($result, $permanent);
	}
}

/**
 * @param string $error HTML-formatted error message.
 *
 * @throws \Random\RandomException
 */
function connection_error(string $error, array &$permanent): void
{
	$error = $error ?: lang('Invalid server or credentials.');

	if (preg_match('~^ +| +$~', get_password())) {
		$error .= "<br>" . lang('There is a space in the input password which might be the cause.');
	}

	auth_error($permanent, $error);
}

Admin::get()->init();

$auth = $_POST["auth"] ?? null;
if ($auth) {
	// Defense against session fixation.
	session_regenerate_id();

	$server = $auth["server"] ?? "";
	$server_obj = Admin::get()->getConfig()->getServer($server);

	$driver = $server_obj ? $server_obj->getDriver() : ($auth["driver"] ?? "");
	$server = $server_obj ? $server : trim($server);
	$username = $auth["username"] ?? "";
	$password = $auth["password"] ?? "";

	if ($server_obj && $server_obj->hasCredentials() && $username == "" && $password == "") {
		$username = $server_obj->getUsername();
		$password = $server_obj->getPassword();
	}

	$db = $server_obj ? $server_obj->getDatabase() : ($auth["db"] ?? "");

	save_login($driver, $server, $username, $password, $db);

	if ($auth["permanent"]) {
		$key = implode("-", array_map("base64_encode", [$driver, $server, $username, $db]));
		$private = Admin::get()->getPrivateKey(true);
		$encrypted_password = $private ? encrypt_string($password, $private) : false;
		$permanent[$key] = "$key:" . base64_encode($encrypted_password ?: "");
		cookie("neo_permanent", implode(" ", $permanent));
	}

	if (count($_POST) == 1 // 1 - auth
		|| DRIVER != $driver
		|| SERVER != $server
		|| $_GET["username"] !== $username // "0" == "00"
		|| DB != $db
	) {
		redirect(auth_url($driver, $server, $username, $db));
	}

} elseif ($_POST["logout"] && (!$_SESSION["token"] || verify_token())) {
	foreach (["pwds", "db", "dbs", "queries"] as $key) {
		set_session($key, null);
	}
	unset_permanent($permanent);
	redirect(SERVER_HOME_URL, lang('Logout successful.'));

} elseif ($permanent && !$_SESSION["pwds"]) {
	session_regenerate_id();
	$private = Admin::get()->getPrivateKey();

	foreach ($permanent as $key => $val) {
		list(, $cipher) = explode(":", $val);
		list($driver, $server, $username, $db) = array_map("base64_decode", explode("-", $key));
		$password = $private ? decrypt_string(base64_decode($cipher), $private) : false;

		save_login($driver, $server, $username, $password, $db);
	}
}

/**
 * @param string|false $password False in case of an encryption error.
 */
function save_login(string $driver, string $server, string $username, $password, string $db = ""): void
{
	set_password($driver, $server, $username, $password);
	$_SESSION["db"][$driver][$server][$username][$db] = true;
}

function unset_permanent(array &$permanent): void
{
	foreach ($permanent as $key => $val) {
		list($driver, $server, $username, $db) = array_map("base64_decode", explode("-", $key));

		if ($driver == DRIVER && $server == SERVER && $username == $_GET["username"] && $db == DB) {
			unset($permanent[$key]);
		}
	}

	cookie("neo_permanent", implode(" ", $permanent));
}

/**
 * Renders an error message and a login form.
 *
 * @param ?string $error HTML-formatted error message, null for the default error.
 *
 * @throws \Random\RandomException
 */
function auth_error(array &$permanent, ?string $error = null): void
{
	$session_name = session_name();

	if (isset($_GET["username"])) {
		header("HTTP/1.1 403 Forbidden"); // 401 requires sending WWW-Authenticate header

		if (($_COOKIE[$session_name] || $_GET[$session_name]) && !$_SESSION["token"]) {
			$error = lang('Session expired, please login again.');
		} else {
			restart_session();
			add_invalid_login();

			$password = get_password();
			if ($password !== null) {
				if ($password === false) {
					$error = lang('Invalid permanent login, please login again.');
				}
				set_password(DRIVER, SERVER, $_GET["username"], null);
			}

			unset_permanent($permanent);
		}
	}

	if (!$_COOKIE[$session_name] && $_GET[$session_name] && ini_bool("session.use_only_cookies")) {
		$error = lang('Session support must be enabled.');
	}

	if (!$error) {
		$error = lang('Invalid server or credentials.');
	}

	Admin::get()->addError($error);

	print_login_page();
}

function print_login_page(): void
{
	$params = session_get_cookie_params();
	cookie("neo_key", ($_COOKIE["neo_key"] ?: get_random_string()), $params["lifetime"]);

	page_header(lang('Login'), null);
	echo "<form action='' method='post'>\n";
	echo "<div>";
	if (hidden_fields($_POST, ["auth"])) { // expired session
		echo "<p class='message'>" . lang('The action will be performed after successful login with the same credentials.') . "\n";
	}
	echo "</div>\n";
	Admin::get()->printLoginForm();
	echo "</form>\n";
	page_footer("auth");
	exit;
}

if (isset($_GET["username"]) && !DRIVER) {
	Admin::get()->addError(lang('Database driver not found.'));

	page_header(lang('No driver'), false);
	page_footer("auth");
	exit;
}

if (isset($_GET["username"]) && !defined('AdminNeo\DRIVER_EXTENSION')) {
	Admin::get()->addError(lang('None of the supported PHP extensions (%s) are available.', implode(", ", Drivers::getExtensions(DRIVER))));

	unset($_SESSION["pwds"][DRIVER]);
	unset_permanent($permanent);

	page_header(lang('No extension'), false);
	page_footer("auth");
	exit;
}

if (!isset($_GET["username"]) || get_password() === null) {
	print_login_page();
}

validate_server_input($permanent);
check_invalid_login($permanent);

Admin::get()->getConfig()->applyServer(SERVER);

$connection = connect_to_db($permanent);
authenticate($permanent);
create_driver($connection);

if ($_POST["logout"] && $_SESSION["token"] && !verify_token()) {
	Admin::get()->addError(lang('Invalid CSRF token. Send the form again.'));

	page_header(lang('Logout'));
	page_footer("db");
	exit;
}

// Defense against cross-site request forgery.
if (!$_SESSION["token"]) {
	$_SESSION["token"] = rand(1, 1e6);
}
stop_session(true);

// Reset token after explicit login.
if ($auth && $_POST["token"]) {
	$_POST["token"] = get_token();
}

if ($_POST) {
	if (!verify_token()) {
		$ini = "max_input_vars";
		$max_vars = ini_get($ini);

		if (extension_loaded("suhosin")) {
			foreach (["suhosin.request.max_vars", "suhosin.post.max_vars"] as $key) {
				$val = ini_get($key);
				if ($val && (!$max_vars || $val < $max_vars)) {
					$ini = $key;
					$max_vars = $val;
				}
			}
		}

		if (!$_POST["token"] && $max_vars) {
			Admin::get()->addError(
				lang('Maximum number of allowed fields exceeded. Please increase %s.', "'$ini'")
			);
		} else {
			Admin::get()->addError(
				lang('Invalid CSRF token. Send the form again.') . ' ' .
				lang('If you did not send this request from AdminNeo then close this page.')
			);
		}

		$_POST = [];
	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Posted form with no data means that post_max_size exceeded because AdminNeo always sends token at least.
	$error = lang('Too big POST data. Reduce the data or increase the %s configuration directive.', "'post_max_size'");
	if (isset($_GET["sql"])) {
		$error .= ' ' . lang('You can upload a big SQL file via FTP and import it from server.');
	}

	Admin::get()->addError($error);
}
