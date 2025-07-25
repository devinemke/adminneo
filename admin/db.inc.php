<?php

namespace AdminNeo;

$tables_views = array_merge((array) $_POST["tables"], (array) $_POST["views"]);

if ($tables_views && !$_POST["search"]) {
	$result = true;
	$message = "";
	if (DIALECT == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) {
		queries("SET foreign_key_checks = 0"); // allows to truncate or drop several tables at once
	}

	if ($_POST["truncate"]) {
		if ($_POST["tables"]) {
			$result = truncate_tables($_POST["tables"]);
		}
		$message = lang('Tables have been truncated.');
	} elseif ($_POST["move"]) {
		$result = move_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang('Tables have been moved.');
	} elseif ($_POST["copy"]) {
		$result = copy_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang('Tables have been copied.');
	} elseif ($_POST["drop"]) {
		if ($_POST["views"]) {
			$result = drop_views($_POST["views"]);
		}
		if ($result && $_POST["tables"]) {
			$result = drop_tables($_POST["tables"]);
		}
		$message = lang('Tables have been dropped.');
	} elseif (DIALECT == "sqlite" && $_POST["check"]) {
		foreach ((array) $_POST["tables"] as $table) {
			foreach (get_rows("PRAGMA integrity_check(" . q($table) . ")") as $row) {
				$message .= "<b>" . h($table) . "</b>: " . h($row["integrity_check"]) . "<br>";
			}
		}
	} elseif (DIALECT != "sql") {
		$result = (DIALECT == "sqlite"
			? queries("VACUUM")
			: apply_queries("VACUUM" . ($_POST["optimize"] ? "" : " ANALYZE"), $_POST["tables"])
		);
		$message = lang('Tables have been optimized.');
	} elseif (!$_POST["tables"]) {
		$message = lang('No tables.');
	} elseif ($result = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('AdminNeo\idf_escape', $_POST["tables"])))) {
		while ($row = $result->fetchAssoc()) {
			$message .= "<b>" . h($row["Table"]) . "</b>: " . h($row["Msg_text"]) . "<br>";
		}
	}

	queries_redirect(substr(ME, 0, -1), $message, $result);
}

if ($_GET["ns"] == "") {
	page_header(lang('Database') . ": " . h(DB), true);
} else {
	page_header(lang('Schema') . ": " . h($_GET["ns"]), true);
}

Admin::get()->printDatabaseMenu();

if ($_GET["ns"] === "") {
	echo "<h2 id='schemas'>" . lang('Schemas') . "</h2>\n";
	$schemas = Admin::get()->getSchemas();
	if (!$schemas) {
		echo "<p class='message'>" . lang('No schemas.') . "\n";
	} else {
		// TODO: Checkboxes for batch dropping of schemas.
		echo "<div class='scrollable'>\n",
			"<table class='nowrap'>\n",
			'<thead><tr class="wrap"><th>', lang('Schema'), "</th></tr></thead>";

		foreach ($schemas as $name) {
			echo "<tr><th><a href='", h(ME), "ns=" . urlencode($name), "' title='", lang('Show schema'), "'>" . h($name) . "</a></th></tr>";
		}

		echo '</table></div>';
	}

	echo '<p class="links"><a href="' . h(ME) . 'scheme=">' . icon("database-add") . lang('Create schema') . "</a>\n";
} else {
	echo "<h2 id='tables-views'>" . lang('Tables and views') . "</h2>\n";
	$tables_list = tables_list();
	if (!$tables_list) {
		echo "<p class='message'>" . lang('No tables.') . "\n";
	} else {
		echo "<form action='' method='post'>\n";
		echo "<div class='table-footer-parent'>\n";

		if (support("table")) {
			echo "<div class='field-sets'>\n";
			echo "<fieldset><legend>" . lang('Search data in tables') . " <span id='selected2'></span></legend><div class='fieldset-content'>";
			echo "<input type='search' class='input' name='query' value='" . h($_POST["query"]) . "'>";
			echo script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", "");
			echo " <input type='submit' class='button' name='search' value='" . lang('Search') . "'>\n";
			if (Admin::get()->getRegexpOperator()) {
				echo "<p><label><input type='checkbox' name='regexp' value='1'" . (empty($_POST['regexp']) ? '' : ' checked') . '>' . lang('as a regular expression') . '</label>';
				echo doc_link(['sql' => 'regexp.html', 'pgsql' => 'functions-matching.html#FUNCTIONS-POSIX-REGEXP', 'elastic' => "regexp-syntax.html"]) . "</p>\n";
			}
			echo "</div></fieldset>\n";
			echo "</div>\n";

			if ($_POST["search"] && $_POST["query"] != "") {
				$_GET["where"][0]["op"] = Admin::get()->getRegexpOperator() && !empty($_POST['regexp']) ? Admin::get()->getRegexpOperator() : Admin::get()->getLikeOperator();
				search_tables();
			}
		}

		echo "<div class='scrollable'>\n";
		echo "<table class='nowrap checkable'>\n";
		echo script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");

		echo '<thead><tr class="wrap">';
		echo '<td class="actions"><input id="check-all" type="checkbox" class="input jsonly">' . script("gid('check-all').onclick = partial(formCheck, /^(tables|views)\[/);", "");
		echo '<th>' . lang('Table');
		echo '<td>' . lang('Engine') . doc_link(['sql' => 'storage-engines.html']);
		echo '<td>' . lang('Collation') . doc_link(['sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/']);
		echo '<td>' . lang('Data Length') . doc_link(['sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT', 'oracle' => 'REFRN20286']);
		echo '<td>' . lang('Index Length') . doc_link(['sql' => 'show-table-status.html', 'pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT']);
		echo '<td>' . lang('Data Free') . doc_link(['sql' => 'show-table-status.html']);
		echo '<td>' . lang('Auto Increment') . doc_link(['sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/']);
		echo '<td>' . lang('Rows') . doc_link(['sql' => 'show-table-status.html', 'pgsql' => 'catalog-pg-class.html#CATALOG-PG-CLASS', 'oracle' => 'REFRN20286']);
		echo (support("comment") ? '<td>' . lang('Comment') . doc_link(['sql' => 'show-table-status.html', 'pgsql' => 'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE']) : '');
		echo "</thead>\n";

		$tables = 0;
		foreach ($tables_list as $name => $type) {
			$view = ($type !== null && !preg_match('~table|sequence~i', $type));
			$id = h("Table-" . $name);

			echo '<tr><td class="actions">' . checkbox(($view ? "views[]" : "tables[]"), $name, in_array($name, $tables_views, true), "", "", "", $id);

			if (!Admin::get()->getConfig()->isSelectionPreferred() && (support("table") || support("indexes"))) {
				$action = "table";
			} else {
				$action = "select";
			}
			echo "<th><a href='", h(ME), "$action=", urlencode($name), "' id='$id'>", h($name), "</a></th>";

			if ($view) {
				echo '<td colspan="6"><a href="' . h(ME) . "view=" . urlencode($name) . '" title="' . lang('Alter view') . '">' . (preg_match('~materialized~i', $type) ? lang('Materialized view') : lang('View')) . '</a>';
				echo '<td align="right"><a href="' . h(ME) . "select=" . urlencode($name) . '" title="' . lang('Select data') . '">?</a>';
			} else {
				foreach ([
					"Engine" => [],
					"Collation" => [],
					"Data_length" => ["create", lang('Alter table')],
					"Index_length" => ["indexes", lang('Alter indexes')],
					"Data_free" => ["edit", lang('New item')],
					"Auto_increment" => ["auto_increment=1&create", lang('Alter table')],
					"Rows" => ["select", lang('Select data')],
				] as $key => $link) {
					$id = " id='$key-" . h($name) . "'";
					echo ($link ? "<td align='right'>" . (support("table") || $key == "Rows" || (support("indexes") && $key != "Data_length")
						? "<a href='" . h(ME . "$link[0]=") . urlencode($name) . "'$id title='$link[1]'>?</a>"
						: "<span$id>?</span>"
					) : "<td id='$key-" . h($name) . "'>");
				}
				$tables++;
			}
			echo (support("comment") ? "<td id='Comment-" . h($name) . "'>" : "");
			echo "\n";
		}

		echo "<tfoot><tr>";
		echo "<td><th>" . lang('%d in total', count($tables_list));
		echo "<td>" . h(DIALECT == "sql" ? Connection::get()->getValue("SELECT @@default_storage_engine") : "");
		echo "<td>" . h(db_collation(DB, collations()));
		foreach (["Data_length", "Index_length", "Data_free"] as $key) {
			echo "<td align='right' id='sum-$key'>";
		}
		echo "<td></td><td></td>";
		if (support("comment")) {
			echo "<td></td>";
		}
		echo "</tr></tfoot>\n";

		echo "</table>\n";
		echo "</div>\n"; // scrollable

		if (Admin::get()->isDataEditAllowed()) {
			echo "<div class='table-footer'><div class='field-sets'>\n";
			$vacuum = "<input type='submit' class='button' value='" . lang('Vacuum') . "'> " . help_script("VACUUM");
			$optimize = "<input type='submit' class='button' name='optimize' value='" . lang('Optimize') . "'> " . help_script(DIALECT == "sql" ? "OPTIMIZE TABLE" : "VACUUM OPTIMIZE");
			echo "<fieldset><legend>" . lang('Selected') . " <span id='selected'></span></legend><div class='fieldset-content'>"
			. (DIALECT == "sqlite" ? $vacuum . "<input type='submit' class='button' name='check' value='" . lang('Check') . "'> " . help_script("PRAGMA integrity_check")
			: (DIALECT == "pgsql" ? $vacuum . $optimize
			: (DIALECT == "sql" ? "<input type='submit' class='button' value='" . lang('Analyze') . "'> " . help_script("ANALYZE TABLE")
				. $optimize
				. "<input type='submit' class='button' name='check' value='" . lang('Check') . "'> " . help_script("CHECK TABLE")
				. "<input type='submit' class='button' name='repair' value='" . lang('Repair') . "'> " . help_script("REPAIR TABLE")
			: "")))
			. "<input type='submit' class='button' name='truncate' value='" . lang('Truncate') . "'> " . help_script(DIALECT == "sqlite" ? "DELETE" : ("TRUNCATE" . (DIALECT == "pgsql" ? "" : " TABLE"))) . confirm()
			. "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . help_script("DROP TABLE") . confirm() . "\n";
			$databases = (support("scheme") ? Admin::get()->getSchemas() : Admin::get()->getDatabases());
			if (count($databases) != 1 && DIALECT != "sqlite") {
				$db = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
				echo "<p>" . lang('Move to other database') . ": ";
				echo ($databases ? html_select("target", $databases, $db) : '<input class="input" name="target" value="' . h($db) . '" autocapitalize="off">');
				echo " <input type='submit' class='button' name='move' value='" . lang('Move') . "'>";
				echo (support("copy") ? " <input type='submit' class='button' name='copy' value='" . lang('Copy') . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], lang('overwrite')) : "");
				echo "\n";
			}
			echo "<input type='hidden' name='all' value=''>"; // used by trCheck()
			echo script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));" . (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $tables);" : "") . " }");
			echo "<input type='hidden' name='token' value='", get_token(), "'>\n";
			echo "</div></fieldset>\n";
			echo "</div></div>\n";

			echo script("initTableFooter()");
		}

		echo "</div>\n"; // table-footer-parent
		echo "</form>\n";
		echo script("tableCheck();");
	}

	echo '<p class="links"><a href="', h(ME), 'create=">', icon("table-add"), lang('Create table'), "</a>\n";
	if (support("view")) {
		echo '<a href="', h(ME), 'view=">', icon("view-add"), lang('Create view'), "</a>\n";
	}

	if (support("routine")) {
		echo "<h2 id='routines'>" . lang('Routines') . "</h2>\n";

		$routines = routines();
		if ($routines) {
			$commentsSupported = $routines[0]["ROUTINE_COMMENT"] !== null;

			echo "<table>\n";
			echo '<thead><tr>',
				'<th>', lang('Name'), '</th><td>', lang('Type'), '</td><td>', lang('Return type'), "</td>";
				if ($commentsSupported) {
					echo "<td>", lang('Comment'), "</td>";
				}
			echo "<td></td>",
				"</tr></thead>\n";

			foreach ($routines as $row) {
				// not computed on the pages to be able to print the header first
				$name = ($row["SPECIFIC_NAME"] == $row["ROUTINE_NAME"] ? "" : "&name=" . urlencode($row["ROUTINE_NAME"]));

				echo '<tr>',
					'<th><a href="', h(ME . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($row["SPECIFIC_NAME"]) . $name), '">', h($row["ROUTINE_NAME"]), '</a></th>',
					'<td>', h($row["ROUTINE_TYPE"]), '</td>',
					'<td>', h($row["DTD_IDENTIFIER"]), '</td>';

				if ($commentsSupported) {
					echo '<td>', truncate_utf8(preg_replace('~\s{2,}~', " ", trim($row["ROUTINE_COMMENT"])), 50), '</td>';
				}

				echo '<td><a href="' . h(ME . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($row["SPECIFIC_NAME"]) . $name) . '">' . lang('Alter') . "</a></td>";
			}

			echo "</table>\n";
		}

		echo '<p class="links">';
		if (support("procedure")) {
			echo '<a href="', h(ME), 'procedure=">', icon("function-add"), lang('Create procedure'), "</a>";
		}
		echo '<a href="', h(ME), 'function=">', icon("function-add"), lang('Create function'), "</a>\n",
			"</p>\n";
	}

	if (support("sequence")) {
		echo "<h2 id='sequences'>" . lang('Sequences') . "</h2>\n";
		$sequences = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");
		if ($sequences) {
			echo "<table>\n",
				"<thead><tr><th>", lang('Name'), "</th><td></td></tr></thead>\n";

			foreach ($sequences as $val) {
				echo "<tr>",
					"<th>", h($val), "</th>",
					"<td><a href='", h(ME), "sequence=", urlencode($val), "'>", lang('Alter'), "</a></td>\n";
			}

			echo "</table>\n";
		}
		echo "<p class='links'><a href='", h(ME), "sequence='>", icon("add"), lang('Create sequence'), "</a></p>\n";
	}

	if (support("type")) {
		echo "<h2 id='user-types'>" . lang('User types') . "</h2>\n";
		$user_types = types();
		if ($user_types) {
			echo "<table>\n",
				"<thead><tr><th>", lang('Name'), "</th><td></td></tr></thead>\n";

			foreach ($user_types as $val) {
				echo "<tr>",
					"<th>", h($val), "</th>",
					"<td><a href='", h(ME), "type=", urlencode($val), "'>", lang('Alter'), "</a></td>\n";
			}

			echo "</table>\n";
		}
		echo "<p class='links'><a href='", h(ME), "type='>", icon("add"), lang('Create type'), "</a></p>\n";
	}

	if (support("event")) {
		echo "<h2 id='events'>" . lang('Events') . "</h2>\n";
		$rows = get_rows("SHOW EVENTS");
		if ($rows) {
			echo "<table>\n";
			echo "<thead><tr><th>" . lang('Name') . "<td>" . lang('Schedule') . "<td>" . lang('Start') . "<td>" . lang('End') . "<td></thead>\n";
			foreach ($rows as $row) {
				echo "<tr>";
				echo "<th>" . h($row["Name"]);
				echo "<td>" . ($row["Execute at"] ? lang('At given time') . "<td>" . $row["Execute at"] : lang('Every') . " " . $row["Interval value"] . " " . $row["Interval field"] . "<td>$row[Starts]");
				echo "<td>$row[Ends]";
				echo '<td><a href="' . h(ME) . 'event=' . urlencode($row["Name"]) . '">' . lang('Alter') . '</a>';
			}
			echo "</table>\n";
			$event_scheduler = Connection::get()->getValue("SELECT @@event_scheduler");
			if ($event_scheduler && $event_scheduler != "ON") {
				echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($event_scheduler) . "\n";
			}
		}
		echo '<p class="links"><a href="', h(ME), 'event=">', icon("event-add"), lang('Create event'), "</a></p>\n";
	}

	if ($tables_list) {
		echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
	}
}
