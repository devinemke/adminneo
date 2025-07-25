<?php

namespace AdminNeo;

$USER = $_GET["user"];
$privileges = ["" => ["All privileges" => ""]];
foreach (get_rows("SHOW PRIVILEGES") as $row) {
	foreach (explode(",", ($row["Privilege"] == "Grant option" ? "" : $row["Context"])) as $context) {
		$privileges[$context][$row["Privilege"]] = $row["Comment"];
	}
}
$privileges["Server Admin"] += $privileges["File access on server"];
$privileges["Databases"]["Create routine"] = $privileges["Procedures"]["Create routine"]; // MySQL bug #30305
unset($privileges["Procedures"]["Create routine"]);
$privileges["Columns"] = [];
foreach (["Select", "Insert", "Update", "References"] as $val) {
	$privileges["Columns"][$val] = $privileges["Tables"][$val];
}
unset($privileges["Server Admin"]["Usage"]);
foreach ($privileges["Tables"] as $key => $val) {
	unset($privileges["Databases"][$key]);
}

$new_grants = [];
if ($_POST) {
	foreach ($_POST["objects"] as $key => $val) {
		$new_grants[$val] = (array) $new_grants[$val] + (array) $_POST["grants"][$key];
	}
}
$grants = [];
$old_pass = "";

if (isset($_GET["host"]) && ($result = Connection::get()->query("SHOW GRANTS FOR " . q($USER) . "@" . q($_GET["host"])))) { //! use information_schema for MySQL 5 - column names in column privileges are not escaped
	while ($row = $result->fetchRow()) {
		if (preg_match('~GRANT (.*) ON (.*) TO ~', $row[0], $match) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $match[1], $matches, PREG_SET_ORDER)) { //! escape the part between ON and TO
			foreach ($matches as $val) {
				if ($val[1] != "USAGE") {
					$grants["$match[2]$val[2]"][$val[1]] = true;
				}
				if (preg_match('~ WITH GRANT OPTION~', $row[0])) { //! don't check inside strings and identifiers
					$grants["$match[2]$val[2]"]["GRANT OPTION"] = true;
				}
			}
		}
		if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $row[0], $match)) {
			$old_pass = $match[1];
		}
	}
}

if ($_POST) {
	$old_user = (isset($_GET["host"]) ? q($USER) . "@" . q($_GET["host"]) : "''");
	if ($_POST["drop"]) {
		query_redirect("DROP USER $old_user", ME . "privileges=", lang('User has been dropped.'));
	} else {
		$new_user = q($_POST["user"]) . "@" . q($_POST["host"]); // if $_GET["host"] is not set then $new_user is always different
		$pass = $_POST["pass"];
		if ($pass != '' && !$_POST["hashed"] && !Connection::get()->isMinVersion("8")) {
			// compute hash in a separate query so that plain text password is not saved to history
			$pass = Connection::get()->getValue("SELECT PASSWORD(" . q($pass) . ")");
			$error = !$pass;
		} else {
			$error = false;
		}

		$created = false;
		if (!$error) {
			if ($old_user != $new_user) {
				$created = queries((Connection::get()->isMinVersion("5") ? "CREATE USER" : "GRANT USAGE ON *.* TO") . " $new_user IDENTIFIED BY " . (Connection::get()->isMinVersion("8") ? "" : "PASSWORD ") . q($pass));
				$error = !$created;
			} elseif ($pass != $old_pass) {
				queries("SET PASSWORD FOR $new_user = " . q($pass));
			}
		}

		if (!$error) {
			$revoke = [];
			foreach ($new_grants as $object => $grant) {
				if (isset($_GET["grant"])) {
					$grant = array_filter($grant);
				}
				$grant = array_keys($grant);
				if (isset($_GET["grant"])) {
					// no rights to mysql.user table
					$revoke = array_diff(array_keys(array_filter($new_grants[$object], 'strlen')), $grant);
				} elseif ($old_user == $new_user) {
					$old_grant = array_keys((array) $grants[$object]);
					$revoke = array_diff($old_grant, $grant);
					$grant = array_diff($grant, $old_grant);
					unset($grants[$object]);
				}
				if (preg_match('~^(.+)\s*(\(.*\))?$~U', $object, $match) && (
					!grant(false, $revoke, $match[2], $match[1], $new_user) //! SQL injection
					|| !grant(true, $grant, $match[2], $match[1], $new_user)
				)) {
					$error = true;
					break;
				}
			}
		}

		if (!$error && isset($_GET["host"])) {
			if ($old_user != $new_user) {
				queries("DROP USER $old_user");
			} elseif (!isset($_GET["grant"])) {
				foreach ($grants as $object => $revoke) {
					if (preg_match('~^(.+)(\(.*\))?$~U', $object, $match)) {
						grant(false, array_keys($revoke), $match[2], $match[1], $new_user);
					}
				}
			}
		}

		queries_redirect(ME . "privileges=", (isset($_GET["host"]) ? lang('User has been altered.') : lang('User has been created.')), !$error);

		if ($created) {
			// delete new user in case of an error
			Connection::get()->query("DROP USER $new_user");
		}
	}
}

$title = isset($_GET["host"]) ? lang('Username') . ": " . h("$USER@$_GET[host]") : lang('Create user');
$title2 = isset($_GET["host"]) ? h($USER) : lang('Create user');
page_header($title, ["privileges" => ['', lang('Privileges')], $title2]);

if ($_POST) {
	$row = $_POST;
	$grants = $new_grants;
} else {
	$row = $_GET + ["host" =>  Connection::get()->getValue("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)")]; // create user on the same domain by default
	$row["pass"] = $old_pass;
	if ($old_pass != "") {
		$row["hashed"] = true;
	}

	if ($grants) {
		$grants[".*"] = [];
	} elseif (DB != "") {
		$grants[idf_escape(addcslashes(DB, "%_\\")) . ".*"] = [];
	} else {
		$grants["*.* "] = []; // Space is added to force editing mode.
	}
}

?>
<form action="" method="post">
<table class="box">
<tr><th><?php echo lang('Server'); ?><td><input class="input" name="host" data-maxlength="60" value="<?php echo h($row["host"]); ?>" autocapitalize="off">
<tr><th><?php echo lang('Username'); ?><td><input class="input" name="user" data-maxlength="80" value="<?php echo h($row["user"]); ?>" autocapitalize="off">
<tr><th><?php echo lang('Password'); ?><td><input class="input" name="pass" id="pass" value="<?php echo h($row["pass"]); ?>" autocomplete="new-password">
<?php if (!$row["hashed"]) { echo script("typePassword(gid('pass'));"); } ?>
<?php echo (Connection::get()->isMinVersion("8") ? "" : checkbox("hashed", 1, $row["hashed"], lang('Hashed'), "typePassword(this.form['pass'], this.checked);")); ?>
</table>

<?php
//! MAX_* limits, REQUIRE
echo "<div class='scrollable'><table class='checkable'>\n";

echo "<thead><tr><th colspan='2'>" . lang('Privileges') . doc_link(['sql' => "grant.html#priv_level"]) . "</th>";
$i = 0;
foreach ($grants as $object => $grant) {
	echo "<th>";
	//! separate db, table, columns, PROCEDURE|FUNCTION, routine
	if ($object == "*.*") {
		echo "<input type='hidden' name='objects[$i]' value='*.*' size='10'>*.*";
	} else {
		echo "<input class='input' name='objects[$i]' value='" . h(trim($object)) . "' size='10' autocapitalize='off'>";
	}
	echo "</th>";
	$i++;
}
echo "</tr></thead>\n";

foreach ([
	"" => "",
	"Server Admin" => lang('Server'),
	"Databases" => lang('Database'),
	"Tables" => lang('Table'),
	"Columns" => lang('Column'),
	"Procedures" => lang('Routine'),
 ] as $context => $desc) {
	foreach ((array) $privileges[$context] as $privilege => $comment) {
		echo "<tr>";
		if ($desc) {
			echo "<td>$desc</td>";
		}
		echo "<td" . (!$desc ? " colspan='2'" : "") . ' lang="en" title="' . h($comment) . '">' . h($privilege) . "</td>";

		$i = 0;

		foreach ($grants as $object => $grant) {
			$name = "'grants[$i][" . h(strtoupper($privilege)) . "]'";
			$value = $grant[strtoupper($privilege)];

			$proxiedUser = strpos($object, "@") !== false;
			$newObject = $object == ".*";
			$allPrivileges = $privilege == "All privileges";
			$grantOption = $privilege == "Grant option";

			if ($object == "*.*" && $privilege == "Proxy") {
				echo "<td></td>";
			} elseif ($proxiedUser && $privilege != "Proxy" && !$grantOption) {
				echo "<td></td>";
			} elseif ($context == "Server Admin" && $object != (isset($grants["*.*"]) ? "*.*" : ".*") && !(($proxiedUser || $newObject) && $privilege == "Proxy")) {
				echo "<td></td>";
			} elseif (isset($_GET["grant"])) {
				echo "<td><select name=$name>" .
					"<option></option>" .
					"<option value='1'" . ($value ? " selected" : "") . ">" . lang('Grant') . "</option>" .
					"<option value='0'" . ($value == "0" ? " selected" : "") . ">" . lang('Revoke') . "</option>" .
					"</select></td>";
			} else {
				echo "<td class='center'><label class='block'>";
				echo "<input type='checkbox' name=$name value='1'" .
					($value ? " checked" : "") .
					($allPrivileges ? " id='grants-$i-all'" : (!$grantOption ? " class='grants-$i'" : "")) .
					">";

				if ($allPrivileges) {
					echo script("qsl('input').onclick = function () { if (this.checked) formUncheckAll('.grants-$i'); };");
				} elseif (!$grantOption) {
					echo script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$i-all'); };");
				}
				echo "</label>";
			}

			$i++;
		}

		echo "</tr>";
	}
}

echo "</table></div>\n";
?>
<p>
<input type="submit" class="button default" value="<?php echo lang('Save'); ?>">
<?php if (isset($_GET["host"])) { ?><input type="submit" class="button" name="drop" value="<?php echo lang('Drop'); ?>"><?php echo confirm(lang('Drop %s?', "$USER@$_GET[host]")); ?><?php } ?>
<input type="hidden" name="token" value="<?php echo get_token(); ?>">
</form>
