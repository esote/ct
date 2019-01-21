<?php

/*

Modify credits per year

*/

function c_modify_creds_per_year($credits_per_year) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/isInt.php";
	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	$_SESSION['c_modify_creds_per_year'] = "";

	if(!isInt($credits_per_year)) {
		$_SESSION['c_modify_creds_per_year'] .= '<p class="danger">Error: Credits per Year must be an integer</p>';
	} else if($credits_per_year < 1) {
		$_SESSION['c_modify_creds_per_year'] .= '<p class="danger">Error: Credits per Year must be greater than or equal to 1</p>';
	} else {
		sql("UPDATE misc_info SET value=? WHERE name='credits_per_year'", "i", True, False, False, $credits_per_year);
		$_SESSION['c_modify_creds_per_year'] .= '<p class="success">Credits per Year successfully changed to <b>' . $hsc($credits_per_year) . '</b></p>';
	}
}

