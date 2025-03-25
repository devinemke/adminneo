<?php

namespace AdminNeo;

class Admin extends AdminBase
{
	private $values = [];

	public function setOperators(?array $operators, ?string $likeOperator, ?string $regexpOperator): void
	{
		//
	}

	public function getOperators(): ?array
	{
		return ["<=", ">="];
	}

	public function getLikeOperator(): ?string
	{
		return null;
	}

	public function getRegexpOperator(): ?string
	{
		return null;
	}

	function name() {
		return "<a href='" . h(HOME_URL) . "'><svg role='img' class='logo' width='130' height='28'><desc>EditorNeo</desc><use href='" . link_files("logo.svg", ["images/logo.svg"]) . "#logo'/></svg></a>";
	}

	function connectSsl() {
	}

	function bruteForceKey() {
		return $_SERVER["REMOTE_ADDR"];
	}

	function database() {
		global $connection;
		if ($connection) {
			$databases = $this->databases(false);
			return (!$databases
				? $connection->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1)") // username without the database list
				: $databases[(information_schema($databases[0]) ? 1 : 0)] // first available database
			);
		}
	}

	function queryTimeout() {
		return 5;
	}

	function headers() {
	}

	function head() {
		return true;
	}

	function loginForm() {
		global $drivers;

		$driver = $this->getConfig()->getDefaultDriver($drivers);

		echo "<table class='box'>\n";
		echo $this->composeLoginFormRow('driver', '', '<input type="hidden" name="auth[driver]" value="' . h($driver) . '">');
		echo $this->composeLoginFormRow('username', lang('Username'), '<input class="input" name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">');
		echo $this->composeLoginFormRow('password', lang('Password'), '<input type="password" class="input" name="auth[password]" autocomplete="current-password">');
		echo "</table>\n";

		echo "<p>";
		echo "<input type='submit' class='button default' value='" . lang('Login') . "'>";
		echo checkbox("auth[permanent]", 1, $_COOKIE["neo_permanent"], lang('Permanent login'));
		echo "</p>\n";
	}

	function tableName($tableStatus) {
		return h($tableStatus["Comment"] != "" ? $tableStatus["Comment"] : $tableStatus["Name"]);
	}

	function fieldName($field, $order = 0) {
		return h(preg_replace('~\s+\[.*\]$~', '', ($field["comment"] != "" ? $field["comment"] : $field["field"])));
	}

	function selectLinks($tableStatus, $set = "") {
		$TABLE = $tableStatus["Name"];
		if ($set !== null) {
			echo '<p class="tabs"><a href="', h(ME . 'edit=' . urlencode($TABLE) . $set), '">', icon("item-add"), lang('New item'), "</a>\n";
		}
	}

	function backwardKeys($table, $tableName) {
		$return = [];
		foreach (get_rows("SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = " . q($this->database()) . "
AND REFERENCED_TABLE_SCHEMA = " . q($this->database()) . "
AND REFERENCED_TABLE_NAME = " . q($table) . "
ORDER BY ORDINAL_POSITION", null, "") as $row) { //! requires MySQL 5
			$return[$row["TABLE_NAME"]]["keys"][$row["CONSTRAINT_NAME"]][$row["COLUMN_NAME"]] = $row["REFERENCED_COLUMN_NAME"];
		}
		foreach ($return as $key => $val) {
			$name = $this->tableName(table_status($key, true));
			if ($name != "") {
				$search = preg_quote($tableName);
				$separator = "(:|\\s*-)?\\s+";
				$return[$key]["name"] = (preg_match("(^$search$separator(.+)|^(.+?)$separator$search\$)iu", $name, $match) ? $match[2] . $match[3] : $name);
			} else {
				unset($return[$key]);
			}
		}
		return $return;
	}

	function backwardKeysPrint($backwardKeys, $row) {
		foreach ($backwardKeys as $table => $backwardKey) {
			foreach ($backwardKey["keys"] as $cols) {
				$link = ME . 'select=' . urlencode($table);
				$i = 0;
				foreach ($cols as $column => $val) {
					$link .= where_link($i++, $column, $row[$val]);
				}
				echo "<a href='" . h($link) . "'>" . h($backwardKey["name"]) . "</a>";
				$link = ME . 'edit=' . urlencode($table);
				foreach ($cols as $column => $val) {
					$link .= "&set" . urlencode("[" . bracket_escape($column) . "]") . "=" . urlencode($row[$val]);
				}
				echo "<a href='" . h($link) . "' title='" . lang('New item') . "'>", icon_solo("add"), "</a> ";
			}
		}
	}

	function selectQuery($query, $start, $failed = false) {
		return "<!--\n" . str_replace("--", "--><!-- ", $query) . "\n(" . format_time($start) . ")\n-->\n";
	}

	public function sqlCommandQuery($query)
	{
	}

	function rowDescription($table) {
		// first varchar column
		foreach (fields($table) as $field) {
			if (preg_match("~varchar|character varying~", $field["type"])) {
				return idf_escape($field["field"]);
			}
		}
		return "";
	}

	function rowDescriptions($rows, $foreignKeys) {
		$return = $rows;
		foreach ($rows[0] as $key => $val) {
			if (list($table, $id, $name) = $this->foreignColumn($foreignKeys, $key)) {
				// find all used ids
				$ids = [];
				foreach ($rows as $row) {
					$ids[$row[$key]] = q($row[$key]);
				}
				// uses constant number of queries to get the descriptions, join would be complex, multiple queries would be slow
				$descriptions = $this->values[$table];
				if (!$descriptions) {
					$descriptions = get_key_vals("SELECT $id, $name FROM " . table($table) . " WHERE $id IN (" . implode(", ", $ids) . ")");
				}
				// use the descriptions
				foreach ($rows as $n => $row) {
					if (isset($row[$key])) {
						$return[$n][$key] = (string) $descriptions[$row[$key]];
					}
				}
			}
		}
		return $return;
	}

	function selectLink($val, $field) {
	}

	function selectVal($val, $link, $field, $original) {
		$return = $val;
		$link = h($link);
		if (preg_match('~blob|bytea~', $field["type"]) && !is_utf8($val)) {
			$return = lang('%d byte(s)', strlen($original));
			if (preg_match("~^(GIF|\xFF\xD8\xFF|\x89PNG\x0D\x0A\x1A\x0A)~", $original)) { // GIF|JPG|PNG, getimagetype() works with filename
				$return = "<img src='$link' alt='$return'>";
			}
		}
		if ($this->looksLikeBool($field) && $return != "") { // bool
			$return = (preg_match('~^(1|t|true|y|yes|on)$~i', $val) ? lang('yes') : lang('no'));
		}
		if ($link) {
			$return = "<a href='$link'" . (is_web_url($link) ? target_blank() : "") . ">$return</a>";
		}
		if (!$link && !$this->looksLikeBool($field) && preg_match(number_type(), $field["type"])) {
			$return = "<div class='number'>$return</div>"; // Firefox doesn't support <colgroup>
		} elseif (preg_match('~date~', $field["type"])) {
			$return = "<div class='datetime'>$return</div>";
		}
		return $return;
	}

	function editVal($val, $field) {
		if (preg_match('~date|timestamp~', $field["type"]) && $val !== null) {
			return preg_replace('~^(\d{2}(\d+))-(0?(\d+))-(0?(\d+))~', lang('$1-$3-$5'), $val);
		}
		return $val;
	}

	public function printTableStructure(array $fields): void
	{
	}

	public function tablePartitionsPrint($partition_info)
	{
	}

	public function tableIndexesPrint($indexes)
	{
	}

	function selectColumnsPrint(array $select, array $columns) {
		// can allow grouping functions by indexes
	}

	function selectSearchPrint(array $where, array $columns, array $indexes) {
		$where = (array) $_GET["where"];
		echo '<fieldset id="fieldset-search"><legend>' . lang('Search') . "</legend><div class='fieldset-content'>\n";
		$keys = [];
		foreach ($where as $key => $val) {
			$keys[$val["col"]] = $key;
		}
		$i = 0;
		$fields = fields($_GET["select"]);
		foreach ($columns as $name => $desc) {
			$field = $fields[$name];
			if (preg_match("~enum~", $field["type"]) || $this->looksLikeBool($field)) { //! set - uses 1 << $i and FIND_IN_SET()
				$key = $keys[$name];
				$i--;
				echo "<div>" . h($desc) . "<input type='hidden' name='where[$i][col]' value='" . h($name) . "'>:";
				echo ($this->looksLikeBool($field)
					? " <select name='where[$i][val]'>" . optionlist(["" => "", lang('no'), lang('yes')], $where[$key]["val"] ?? null, true) . "</select>"
					: enum_input("checkbox", " name='where[$i][val][]'", $field, (array) ($where[$key]["val"] ?? []), ($field["null"] ? 0 : null))
				);
				echo "</div>\n";
				unset($columns[$name]);
			} elseif (is_array($options = $this->foreignKeyOptions($_GET["select"], $name))) {
				if ($fields[$name]["null"]) {
					$options[0] = '(' . lang('empty') . ')';
				}
				$key = $keys[$name];
				$i--;
				echo "<div>" . h($desc) . "<input type='hidden' name='where[$i][col]' value='" . h($name) . "'><input type='hidden' name='where[$i][op]' value='='>: <select name='where[$i][val]'>" . optionlist($options, $where[$key]["val"] ?? null, true) . "</select></div>\n";
				unset($columns[$name]);
			}
		}
		$i = 0;
		foreach ($where as $val) {
			if (($val["col"] == "" || $columns[$val["col"]]) && "$val[col]$val[val]" != "") {
				echo "<div><select name='where[$i][col]'><option value=''>(" . lang('anywhere') . ")" . optionlist($columns, $val["col"], true) . "</select>";
				echo html_select("where[$i][op]", [-1 => ""] + $this->getOperators(), $val["op"]);
				echo "<input type='search' class='input' name='where[$i][val]' value='" . h($val["val"]) . "'>" . script("mixin(qsl('input'), {onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", "");
				echo " <button class='button light remove jsonly' title='" . h(lang('Remove')) . "'>", icon_solo("remove"), "</button>";
				echo script('qsl("#fieldset-search .remove").onclick = selectRemoveRow;', "");
				echo "</div>\n";
				$i++;
			}
		}
		echo "<div><select name='where[$i][col]'><option value=''>(" . lang('anywhere') . ")" . optionlist($columns, null, true) . "</select>";
		echo script("qsl('select').onchange = selectAddRow;", "");
		echo html_select("where[$i][op]", [-1 => ""] + $this->getOperators());
		echo "<input type='search' class='input' name='where[$i][val]'>";
		echo script("mixin(qsl('input'), {onchange: function () { this.parentNode.firstChild.onchange(); }, onsearch: selectSearchSearch});");
		echo " <button class='button light remove jsonly' title='" . h(lang('Remove')) . "'>", icon_solo("remove"), "</button>";
		echo script('qsl("#fieldset-search .remove").onclick = selectRemoveRow;', "");
		echo "</div>";
		echo "</div></fieldset>\n";
	}

	function selectOrderPrint(array $order, array $columns, array $indexes) {
		//! desc
		$orders = [];
		foreach ($indexes as $key => $index) {
			$order = [];
			foreach ($index["columns"] as $val) {
				$order[] = $columns[$val];
			}
			if (count(array_filter($order, 'strlen')) > 1 && $key != "PRIMARY") {
				$orders[$key] = implode(", ", $order);
			}
		}
		if ($orders) {
			echo '<fieldset><legend>' . lang('Sort') . "</legend><div class='fieldset-content'>";
			echo "<select name='index_order'>" . optionlist(["" => ""] + $orders, (($_GET["order"][0] ?? null) != "" ? "" : $_GET["index_order"]), true) . "</select>";
			echo "</div></fieldset>\n";
		}
		if ($_GET["order"]) {
			echo "<div style='display: none;'>" . hidden_fields([
				"order" => [1 => reset($_GET["order"])],
				"desc" => ($_GET["desc"] ? [1 => 1] : []),
				]) . "</div>\n";
		}
	}

	public function selectLimitPrint(?int $limit): void
	{
		echo "<fieldset><legend>" . lang('Limit') . "</legend><div class='fieldset-content'>",
			html_select("limit", ["", "50", "100"], (string)$limit),
			"</div></fieldset>\n";
	}

	function selectLengthPrint($text_length) {
	}

	function selectActionPrint($indexes) {
		echo "<fieldset><legend>" . lang('Action') . "</legend><div class='fieldset-content'>";
		echo "<input type='submit' class='button' value='" . lang('Select') . "'>";
		echo "</div></fieldset>\n";
	}

	function selectCommandPrint() {
		return true;
	}

	function selectImportPrint() {
		return true;
	}

	function selectEmailPrint($emailFields, $columns) {
		if (!$emailFields) {
			return;
		}

		print_fieldset_start("email", lang('E-mail'), "email", (bool)$_POST["email_append"]);

		echo script("qsl('div').onkeydown = partialArg(bodyKeydown, 'email');");
		echo "<p>" . lang('From') . ": <input class='input' name='email_from' value='" . h($_POST ? $_POST["email_from"] : $_COOKIE["neo_email"]) . "'>\n";
		echo lang('Subject') . ": <input class='input' name='email_subject' value='" . h($_POST["email_subject"]) . "'>\n";
		echo "<p><textarea name='email_message' rows='15' cols='75'>" . h($_POST["email_message"] . ($_POST["email_append"] ? '{$' . "$_POST[email_addition]}" : "")) . "</textarea>\n";
		echo "<p>" . script("qsl('p').onkeydown = partialArg(bodyKeydown, 'email_append');", "") . html_select("email_addition", $columns, $_POST["email_addition"]) . "<input type='submit' class='button' name='email_append' value='" . lang('Insert') . "'>\n"; //! JavaScript
		echo "<p>" . lang('Attachments') . ": <input type='file' name='email_files[]'>" . script("qsl('input').onchange = emailFileChange;");
		echo "<p>" . (count($emailFields) == 1 ? '<input type="hidden" name="email_field" value="' . h(key($emailFields)) . '">' : html_select("email_field", $emailFields));
		echo "<input type='submit' class='button' name='email' value='" . lang('Send') . "'>" . confirm();

		print_fieldset_end("email");
	}

	function selectColumnsProcess($columns, $indexes) {
		return [[], []];
	}

	function selectSearchProcess($fields, $indexes) {
		global $driver;

		$return = [];

		foreach ((array) $_GET["where"] as $key => $where) {
			$col = $where["col"];
			$op = $where["op"];
			$val = $where["val"];

			if (($key >= 0 && $col != "") || $val != "") {
				$conds = [];

				foreach (($col != "" ? [$col => $fields[$col]] : $fields) as $name => $field) {
					if ($col != "" || is_numeric($val) || !preg_match(number_type(), $field["type"])) {
						$name = idf_escape($name);

						if ($col != "" && $field["type"] == "enum") {
							$conds[] = (in_array(0, $val) ? "$name IS NULL OR " : "") . "$name IN (" . implode(", ", array_map('intval', $val)) . ")";
						} else {
							$text_type = preg_match('~char|text|enum|set~', $field["type"]);
							$value = $this->processInput($field, (!$op && $text_type && preg_match('~^[^%]+$~', $val) ? "%$val%" : $val));

							$conds[] = $driver->convertSearch($name, $where, $field) . ($value == "NULL" ? " IS" . ($op == ">=" ? " NOT" : "") . " $value"
								: (in_array($op, $this->getOperators()) || $op == "=" ? " $op $value"
								: ($text_type ? " LIKE $value"
								: " IN (" . str_replace(",", "', '", $value) . ")"
							)));

							if ($key < 0 && $val == "0") {
								$conds[] = "$name IS NULL";
							}
						}
					}
				}

				$return[] = ($conds ? "(" . implode(" OR ", $conds) . ")" : "1 = 0");
			}
		}

		return $return;
	}

	function selectOrderProcess($fields, $indexes) {
		$index_order = $_GET["index_order"];
		if ($index_order != "") {
			unset($_GET["order"][1]);
		}
		if ($_GET["order"]) {
			return [idf_escape(reset($_GET["order"])) . ($_GET["desc"] ? " DESC" : "")];
		}
		foreach (($index_order != "" ? [$indexes[$index_order]] : $indexes) as $index) {
			if ($index_order != "" || $index["type"] == "INDEX") {
				$has_desc = array_filter($index["descs"]);
				$desc = false;
				foreach ($index["columns"] as $val) {
					if (preg_match('~date|timestamp~', $fields[$val]["type"])) {
						$desc = true;
						break;
					}
				}
				$return = [];
				foreach ($index["columns"] as $key => $val) {
					$return[] = idf_escape($val) . (($has_desc ? $index["descs"][$key] : $desc) ? " DESC" : "");
				}
				return $return;
			}
		}
		return [];
	}

	function selectLengthProcess() {
		return "100";
	}

	function selectEmailProcess($where, $foreignKeys) {
		if ($_POST["email_append"]) {
			return true;
		}
		if ($_POST["email"]) {
			$sent = 0;
			if ($_POST["all"] || $_POST["check"]) {
				$field = idf_escape($_POST["email_field"]);
				$subject = $_POST["email_subject"];
				$message = $_POST["email_message"];
				preg_match_all('~\{\$([a-z0-9_]+)\}~i', "$subject.$message", $matches); // allows {$name} in subject or message
				$rows = get_rows("SELECT DISTINCT $field" . ($matches[1] ? ", " . implode(", ", array_map('AdminNeo\idf_escape', array_unique($matches[1]))) : "") . " FROM " . table($_GET["select"])
					. " WHERE $field IS NOT NULL AND $field != ''"
					. ($where ? " AND " . implode(" AND ", $where) : "")
					. ($_POST["all"] ? "" : " AND ((" . implode(") OR (", array_map('AdminNeo\where_check', (array) $_POST["check"])) . "))")
				);
				$fields = fields($_GET["select"]);
				foreach ($this->rowDescriptions($rows, $foreignKeys) as $row) {
					$replace = ['{\\' => '{']; // allow literal {$name}
					foreach ($matches[1] as $val) {
						$replace['{$' . "$val}"] = $this->editVal($row[$val], $fields[$val]);
					}
					$email = $row[$_POST["email_field"]];
					if (is_mail($email) && $this->sendEmail($email, strtr($subject, $replace), strtr($message, $replace), $_POST["email_from"], $_FILES["email_files"])) {
						$sent++;
					}
				}
			}
			cookie("neo_email", $_POST["email_from"]);
			redirect(remove_from_uri(), lang('%d e-mail(s) have been sent.', $sent));
		}
		return false;
	}

	function messageQuery($query, $time, $failed = false) {
		return " <span class='time'>" . @date("H:i:s") . "</span><!--\n" . str_replace("--", "--><!-- ", $query) . "\n" . ($time ? "($time)\n" : "") . "-->";
	}

	function editRowPrint($table, $fields, $row, $update) {
	}

	function editFunctions($field) {
		$return = [];
		if ($field["null"] && preg_match('~blob~', $field["type"])) {
			$return["NULL"] = lang('empty');
		}
		$return[""] = ($field["null"] || $field["auto_increment"] || $this->looksLikeBool($field) ? "" : "*");
		//! respect driver
		if (preg_match('~date|time~', $field["type"])) {
			$return["now"] = lang('now');
		}
		if (preg_match('~_(md5|sha1)$~i', $field["field"], $match)) {
			$return[] = strtolower($match[1]);
		}
		return $return;
	}

	function editInput($table, $field, $attrs, $value, $function) {
		if ($field["type"] == "enum") {
			return (isset($_GET["select"]) ? "<label><input type='radio'$attrs value='-1' checked><i>" . lang('original') . "</i></label> " : "")
				. enum_input("radio", $attrs, $field, ($value || isset($_GET["select"]) ? $value : 0), ($field["null"] ? "" : null))
			;
		}
		$options = $this->foreignKeyOptions($table, $field["field"], $value);
		if ($options !== null) {
			return (is_array($options)
				? "<select$attrs>" . optionlist($options, $value, true) . "</select>"
				: "<input value='" . h($value) . "'$attrs class='input hidden'>"
					. "<input value='" . h($options) . "' class='input jsonly'>"
					. "<div></div>"
					. script("qsl('input').oninput = partial(whisper, '" . ME . "script=complete&source=" . urlencode($table) . "&field=" . urlencode($field["field"]) . "&value=');
qsl('div').onclick = whisperClick;", "")
			);
		}
		if ($this->looksLikeBool($field)) {
			return '<input type="checkbox" value="1"' . (preg_match('~^(1|t|true|y|yes|on)$~i', $value) ? ' checked' : '') . "$attrs>";
		}
		$hint = "";
		if (preg_match('~time~', $field["type"])) {
			$hint = lang('HH:MM:SS');
		}
		if (preg_match('~date|timestamp~', $field["type"])) {
			$hint = lang('[yyyy]-mm-dd') . ($hint ? " [$hint]" : "");
		}
		if ($hint) {
			return "<input"
				. ($function != "now" ? " value='" . h($value) . "'" : " data-last-value='" . h($value) . "'")
				. "$attrs> ($hint)"; //! maxlength
		}
		if (preg_match('~_(md5|sha1)$~i', $field["field"])) {
			return "<input type='password' class='input' value='" . h($value) . "'$attrs>";
		}
		return '';
	}

	function editHint($table, $field, $value) {
		return (preg_match('~\s+(\[.*\])$~', ($field["comment"] != "" ? $field["comment"] : $field["field"]), $match) ? h(" $match[1]") : '');
	}

	function processInput(?array $field, $value, $function = "") {
		if (!$field) {
			return q($value);
		}
		if ($function == "now") {
			return "$function()";
		}
		$return = $value;
		if (preg_match('~date|timestamp~', $field["type"]) && preg_match('(^' . str_replace('\$1', '(?P<p1>\d*)', preg_replace('~(\\\\\\$([2-6]))~', '(?P<p\2>\d{1,2})', preg_quote(lang('$1-$3-$5')))) . '(.*))', $value, $match)) {
			$return = ($match["p1"] != "" ? $match["p1"] : ($match["p2"] != "" ? ($match["p2"] < 70 ? 20 : 19) . $match["p2"] : gmdate("Y"))) . "-$match[p3]$match[p4]-$match[p5]$match[p6]" . end($match);
		}
		$return = ($field["type"] == "bit" && preg_match('~^[0-9]+$~', $value) ? $return : q($return));
		if ($value == "" && $this->looksLikeBool($field)) {
			$return = "'0'";
		} elseif ($value == "" && ($field["null"] || !preg_match('~char|text~', $field["type"]))) {
			$return = "NULL";
		} elseif (preg_match('~^(md5|sha1)$~', $function)) {
			$return = "$function($return)";
		}
		return unconvert_field($field, $return);
	}

	public function getDumpOutputs(): array
	{
		return [];
	}

	public function getDumpFormats(): array
	{
		return ['csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV'];
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): string
	{
		header("Content-Type: text/csv; charset=utf-8");

		return "csv";
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): void
	{
		echo "\xef\xbb\xbf"; // UTF-8 byte order mark
	}

	public function dumpData(string $table, string $style, string $query): void
	{
		global $connection;

		$result = $connection->query($query, 1); // 1 - MYSQLI_USE_RESULT
		if (!$result) {
			return;
		}

		while ($row = $result->fetch_assoc()) {
			if ($style == "table") {
				dump_csv(array_keys($row));
				$style = "INSERT";
			}

			dump_csv($row);
		}
	}

	function importServerPath() {
		return null;
	}

	function homepage() {
		return true;
	}

	function navigation($missing) {
		global $VERSION;

		$last_version = $_COOKIE["neo_version"] ?? null;
?>

<div class="header">
	<?= $this->name(); ?>

	<?php if ($missing != "auth"): ?>
		<span class="version">
			<?= h($VERSION); ?>
			<a id="version" class="version-badge" href="https://github.com/adminneo-org/adminneo/releases"<?= target_blank(); ?> title="<?= h($last_version); ?>">
				<?= ($this->config->isVersionVerificationEnabled() && $last_version && version_compare($VERSION, $last_version) < 0 ? icon_solo("asterisk") : ""); ?>
			</a>
		</span>
		<?php
		if ($this->config->isVersionVerificationEnabled() && !$last_version) {
			echo script("verifyVersion('" . js_escape(ME) . "', '" . get_token() . "');");
		}
		?>
	<?php endif; ?>
</div>

<?php
		if ($missing == "auth") {
			$first = true;
			foreach ((array) $_SESSION["pwds"] as $vendor => $servers) {
				foreach ($servers[""] as $username => $password) {
					if ($password !== null) {
						if ($first) {
							echo "<nav id='logins'><menu>";
							$first = false;
						}
						echo "<li><a href='" . h(auth_url($vendor, "", $username)) . "' class='primary'>" . ($username != "" ? h($username) : "<i>" . lang('empty') . "</i>") . "</a></li>\n";
					}
				}
			}
			if (!$first) {
				echo "</menu></nav>\n";
			}
		} else {
			$this->databasesPrint($missing);
			if ($missing != "db" && $missing != "ns") {
				$table_status = table_status('', true);
				if (!$table_status) {
					echo "<p class='message'>" . lang('No tables.') . "</p>\n";
				} else {
					$this->printTablesFilter();
					$this->tablesPrint($table_status);
				}
			}
		}
	}

	function databasesPrint($missing) {
	}

	function tablesPrint(array $tables) {
		echo "<nav id='tables'><menu>";

		foreach ($tables as $row) {
			// Skip views and tables without a name.
			if (!isset($row["Engine"]) || ($name = $this->tableName($row)) == "") {
				continue;
			}

			$active = $_GET["select"] == $row["Name"] || $_GET["edit"] == $row["Name"];
			$selectUrl = h(ME) . 'select=' . urlencode($row["Name"]);

			echo "<li>";
			echo "<a href='$selectUrl'", bold($active, "primary"), " data-primary='true' title='$name'>$name</a>";
			echo "</li>\n";
		}

		echo "</menu></nav>\n";
	}

	public function foreignColumn($foreignKeys, $column): ?array {
		foreach ((array) $foreignKeys[$column] as $foreignKey) {
			if (count($foreignKey["source"]) == 1) {
				$name = $this->rowDescription($foreignKey["table"]);
				if ($name != "") {
					$id = idf_escape($foreignKey["target"][0]);
					return [$foreignKey["table"], $id, $name];
				}
			}
		}

		return null;
	}

	private function foreignKeyOptions($table, $column, $value = null) {
		global $connection;
		if (list($target, $id, $name) = $this->foreignColumn(column_foreign_keys($table), $column)) {
			$return = &$this->values[$target];
			if ($return === null) {
				$table_status = table_status($target);
				$return = ($table_status["Rows"] > 1000 ? "" : ["" => ""] + get_key_vals("SELECT $id, $name FROM " . table($target) . " ORDER BY 2"));
			}
			if (!$return && $value !== null) {
				return $connection->result("SELECT $name FROM " . table($target) . " WHERE $id = " . q($value));
			}
			return $return;
		}
	}

	/**
	 * Checks whether the column looks like boolean.
	 *
	 * @param array $field Single field returned from fields().
	 */
	protected function looksLikeBool(array $field): bool
	{
		return preg_match("~bool|(tinyint|bit)\\(1\\)~", $field["full_type"]);
	}

	/**
	 * Sends e-mail in UTF-8.
	 */
	protected function sendEmail(string $email, string $subject, string $message, string $from = "", array $files = []):bool
	{
		$eol = "\r\n";
		$message = str_replace("\n", $eol, wordwrap(str_replace("\r", "", "$message\n")));
		$boundary = uniqid("boundary");
		$attachments = "";

		foreach ((array) $files["error"] as $key => $val) {
			if ($val) {
				continue;
			}

			$attachments .= "--$boundary$eol"
				. "Content-Type: " . str_replace("\n", "", $files["type"][$key]) . $eol
				. "Content-Disposition: attachment; filename=\"" . preg_replace('~["\n]~', '', $files["name"][$key]) . "\"$eol"
				. "Content-Transfer-Encoding: base64$eol$eol"
				. chunk_split(base64_encode(file_get_contents($files["tmp_name"][$key])), 76, $eol) . $eol;
		}

		$beginning = "";
		$headers = "Content-Type: text/plain; charset=utf-8$eol" . "Content-Transfer-Encoding: 8bit";
		if ($attachments) {
			$attachments .= "--$boundary--$eol";
			$beginning = "--$boundary$eol$headers$eol$eol";
			$headers = "Content-Type: multipart/mixed; boundary=\"$boundary\"";
		}
		$headers .= $eol . "MIME-Version: 1.0$eol" . "X-Mailer: EditorNeo"
			. ($from ? $eol . "From: " . str_replace("\n", "", $from) : ""); //! should escape display name

		// iconv_mime_encode requires iconv, imap_8bit requires IMAP extension
		$subject = "=?UTF-8?B?" . base64_encode($subject) . "?="; //! split long lines

		return mail($email, $subject, $beginning . $message . $attachments, $headers);
	}
}
