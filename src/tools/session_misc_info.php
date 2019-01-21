<?php

/*

Get miscellaneous information

*/

function session_misc_info() {
	require_once __DIR__ . "/sql.php";

	$_SESSION['misc_info'] = sql("SELECT name, value FROM misc_info", '', False, True, True);
}

