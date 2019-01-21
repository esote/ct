<?php

/*

Modify number of years

*/

function c_modify_years($years) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/isInt.php";
	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	$_SESSION['c_modify_years'] = "";

	if(!isInt($years)) {
		$_SESSION['c_modify_years'] .= '<p class="danger">Error: Years must be an integer</p>';
	} else if($years < 4) {
		$_SESSION['c_modify_years'] .= '<p class="danger">Error: Years must be greater than or equal to 4</p>';
	} else {
		sql("UPDATE misc_info SET value=? WHERE name='years'", "i", True, False, False, $years);
		$_SESSION['c_modify_years'] .= '<p class="success">Years successfully changed to <b>' . $hsc($years) . '</b></p>';
	}
}

