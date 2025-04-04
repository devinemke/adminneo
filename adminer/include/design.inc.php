<?php
if (!ob_get_level()) {
	ob_start(null, 4096);
}

/** Print HTML header
* @param string used in title, breadcrumb and heading, should be HTML escaped
* @param string
* @param mixed ["key" => "link", "key2" => ["link", "desc"]], null for nothing, false for driver only, true for driver and server
* @param string used after colon in title and heading, should be HTML escaped
* @return null
*/
function page_header($title, $error = "", $breadcrumb = [], $title2 = "") {
	global $LANG, $VERSION, $adminer, $drivers, $jush;
	page_headers();
	if (is_ajax() && $error) {
		page_messages($error);
		exit;
	}

	$service_title = strip_tags($adminer->name());
	$title_all = strip_tags($title . ($title2 != "" ? ": $title2" : ""));

	$title_page = $title_all . (SERVER != "" ? h(" - " . SERVER) : "") . " - " . ($service_title != "" ? $service_title : "AdminNeo");

	// Load Adminer version from file if cookie is missing.
	$filename = get_temp_dir() . "/adminer.version";
	if (!$_COOKIE["adminer_version"] && file_exists($filename) && ($lifetime = filemtime($filename) + 86400 - time()) > 0) { // 86400 - 1 day in seconds
		$data = unserialize(file_get_contents($filename));

		$_COOKIE["adminer_version"] = $data["version"];
		cookie("adminer_version", $data["version"], $lifetime); // Sync expiration with the file.
	}
	?>
<!DOCTYPE html>
<html lang="<?php echo $LANG; ?>" dir="<?php echo lang('ltr'); ?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title_page; ?></title>
<link rel="stylesheet" type="text/css" href="../adminer/static/default.css?<?php echo filemtime("../adminer/static/default.css"); ?>">
<?php echo script_src("../adminer/static/functions.js?" . filemtime("../adminer/static/functions.js")); ?>
<?php echo script_src("static/editing.js?" . filemtime("../adminer/static/editing.js")); ?>
<?php if ($adminer->head()) { ?>
<link rel="shortcut icon" type="image/x-icon" href="../adminer/static/favicon.ico">
<link rel="apple-touch-icon" href="../adminer/static/favicon.ico">
<?php foreach ($adminer->css() as $css) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo h($css); ?>">
<?php } ?>
<?php } ?>

<body class="<?php echo lang('ltr'); ?> nojs">
<script<?php echo nonce(); ?>>
	const body = document.body;

	body.onkeydown = bodyKeydown;
	body.onclick = bodyClick;
	body.classList.remove("nojs");
	body.classList.add("js");

	var offlineMessage = '<?php echo js_escape(lang('You are offline.')); ?>';
	var thousandsSeparator = '<?php echo js_escape(lang(',')); ?>';
</script>

<div id="help" class="jush-<?php echo $jush; ?> jsonly hidden"></div>
<?php echo script("initHelpPopup();"); ?>

<div id="content">
<?php
	if ($breadcrumb !== null) {
		echo '<p id="breadcrumb">';

		echo '<a href="' . h(HOME_URL) . '">' . lang('Home') . '</a> » ';

		$server = "";
		if ($breadcrumb === false) {
			$server .= h($drivers[DRIVER]) . ": ";
		}

		$server_name = $adminer->serverName(SERVER);
		$server .= $server_name != "" ? h($server_name) : lang('Server');

		if ($breadcrumb === false) {
			echo h($server), "\n";
		} else {
			$link = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
			echo "<a href='" . h($link) . "' accesskey='1' title='Alt+Shift+1'>$server</a> » ";

			if ($_GET["ns"] != "" || (DB != "" && is_array($breadcrumb))) {
				echo '<a href="' . h($link . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a> » ';
			}

			if (is_array($breadcrumb)) {
				if ($_GET["ns"] != "") {
					echo '<a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a> » ';
				}

				foreach ($breadcrumb as $key => $val) {
					$desc = (is_array($val) ? $val[1] : h($val));
					if ($desc != "") {
						echo "<a href='" . h(ME . "$key=") . urlencode(is_array($val) ? $val[0] : $val) . "'>$desc</a> » ";
					}
				}
			}

			echo "$title\n";
		}
	}

	echo "<h2>$title_all</h2>\n";
	echo "<div id='ajaxstatus' class='jsonly hidden'></div>\n";
	restart_session();
	page_messages($error);
	$databases = &get_session("dbs");
	if (DB != "" && $databases && !in_array(DB, $databases, true)) {
		$databases = null;
	}
	stop_session();
	define("PAGE_HEADER", 1);
}

/** Send HTTP headers
* @return null
*/
function page_headers() {
	global $adminer;
	header("Content-Type: text/html; charset=utf-8");
	header("Cache-Control: no-cache");
	header("X-Frame-Options: deny"); // ClickJacking protection in IE8, Safari 4, Chrome 2, Firefox 3.6.9
	header("X-XSS-Protection: 0"); // prevents introducing XSS in IE8 by removing safe parts of the page
	header("X-Content-Type-Options: nosniff");
	header("Referrer-Policy: origin-when-cross-origin");
	foreach ($adminer->csp() as $csp) {
		$header = array();
		foreach ($csp as $key => $val) {
			$header[] = "$key $val";
		}
		header("Content-Security-Policy: " . implode("; ", $header));
	}
	$adminer->headers();
}

/**
 * Gets Content Security Policy headers.
 *
 * @return array of arrays with directive name in key, allowed sources in value
 * @throws \Random\RandomException
 */
function csp() {
	return [
		[
			// 'self' is a fallback for browsers not supporting 'strict-dynamic', 'unsafe-inline' is a fallback for browsers not supporting 'nonce-'
			"script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'",
			"connect-src" => "'self' https://api.github.com/repos/adminneo-org/adminneo/releases/latest",
			"frame-src" => "'self'",
			"object-src" => "'none'",
			"base-uri" => "'none'",
			"form-action" => "'self'",
		],
	];
}

/**
 * Gets a CSP nonce.
 *
 * @return string Base64 value.
 * @throws \Random\RandomException
 */
function get_nonce()
{
	static $nonce;

	if (!$nonce) {
		$nonce = base64_encode(get_random_string(true));
	}

	return $nonce;
}

/** Print flash and error messages
* @param string
* @return null
*/
function page_messages($error) {
	$uri = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
	$messages = $_SESSION["messages"][$uri];
	if ($messages) {
		echo "<div class='message'>" . implode("</div>\n<div class='message'>", $messages) . "</div>" . script("messagesPrint();");
		unset($_SESSION["messages"][$uri]);
	}
	if ($error) {
		echo "<div class='error'>$error</div>\n";
	}
}

/**
 * Prints HTML footer.
 *
 * @param ?string $missing "auth", "db", "ns"
 */
function page_footer($missing = null)
{
	global $adminer, $token;

	echo "</div>"; // #content

	echo "<div id='footer'>\n";
	language_select();

	if ($missing != "auth") {
?>

	<div class="logout">
		<form action="" method="post">
			<?php echo h($_GET["username"]); ?>
			<input type="submit" name="logout" value="<?php echo lang('Logout'); ?>" id="logout">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
		</form>
	</div>

<?php
	}
	echo "</div>\n";

	echo "<div id='menu'>\n";
	$adminer->navigation($missing);
	echo "</div>\n";

	echo script("setupSubmitHighlight(document);");
}
