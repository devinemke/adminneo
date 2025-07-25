<?php

/**
 * AdminNeo - Powerful database manager in a single PHP file
 * !compile: version
 *
 * !compile: parameters
 *
 * @link https://www.adminneo.org/
 *
 * @author Peter Knut
 * @author Jakub Vrana (https://www.vrana.cz/)
 *
 * @copyright 2007-2025 Jakub Vrána
 * @copyright 2024-2025 Peter Knut
 *
 * @license Apache License, Version 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @license GNU General Public License, version 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 */

namespace AdminNeo;

include "core/Plugin.php";
include "core/Origin.php";
include "core/Pluginer.php";
include "core/Admin.php";
include "core/TmpFile.php";

include "include/editing.inc.php";
include "include/bootstrap.inc.php";
include "include/connect.inc.php";

if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
	$_GET["edit"] = $_GET["select"];
}
if (isset($_GET["callf"])) {
	$_GET["call"] = $_GET["callf"];
}
if (isset($_GET["function"])) {
	$_GET["procedure"] = $_GET["function"];
}

if (isset($_GET["download"])) {
	include "download.inc.php";
} elseif (isset($_GET["table"])) {
	include "table.inc.php";
} elseif (isset($_GET["schema"])) {
	include "schema.inc.php";
} elseif (isset($_GET["dump"])) {
	include "dump.inc.php";
} elseif (isset($_GET["privileges"])) {
	include "privileges.inc.php";
} elseif (isset($_GET["sql"])) {
	include "sql.inc.php";
} elseif (isset($_GET["edit"])) {
	include "edit.inc.php";
} elseif (isset($_GET["create"])) {
	include "create.inc.php";
} elseif (isset($_GET["indexes"])) {
	include "indexes.inc.php";
} elseif (isset($_GET["database"])) {
	include "database.inc.php";
} elseif (isset($_GET["scheme"])) {
	include "scheme.inc.php";
} elseif (isset($_GET["call"])) {
	include "call.inc.php";
} elseif (isset($_GET["foreign"])) {
	include "foreign.inc.php";
} elseif (isset($_GET["view"])) {
	include "view.inc.php";
} elseif (isset($_GET["event"])) {
	include "event.inc.php";
} elseif (isset($_GET["procedure"])) {
	include "procedure.inc.php";
} elseif (isset($_GET["sequence"])) {
	include "sequence.inc.php";
} elseif (isset($_GET["type"])) {
	include "type.inc.php";
} elseif (isset($_GET["check"])) {
	include "check.inc.php";
} elseif (isset($_GET["trigger"])) {
	include "trigger.inc.php";
} elseif (isset($_GET["user"])) {
	include "user.inc.php";
} elseif (isset($_GET["processlist"])) {
	include "processlist.inc.php";
} elseif (isset($_GET["select"])) {
	include "select.inc.php";
} elseif (isset($_GET["variables"])) {
	include "variables.inc.php";
} elseif (isset($_GET["script"])) {
	include "script.inc.php";
} else {
	include "db.inc.php";
}

// each page calls its own page_header(), if the footer should not be called then the page exits
page_footer();
