<?php

/*

Get list of areas

*/

function session_c_enum_areas() {
	require_once __DIR__ . "/kill.php";

	if(!isset($_SESSION['counselor']) || $_SESSION['counselor'] !== True) {
		kill("Error: Credentials not sent.");
		die();
	}

	require_once __DIR__ . "/sql.php";

	$_SESSION['enum_areas'] = array_map(
		function($a) {
			return str_replace("'", '', $a);
		}, str_getcsv(substr(sql("SHOW FIELDS FROM classes LIKE 'area'", '', False, True, False)['Type'], 5, -1))
	);

	sort($_SESSION['enum_areas']);
}

