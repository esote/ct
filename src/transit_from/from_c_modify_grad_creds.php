<?php

/*

Modify graduation credits

*/

function c_modify_grad_creds($credits) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/isInt.php";
	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	$_SESSION['c_modify_grad_creds'] = "";

	if(!isInt($credits)) {
		$_SESSION['c_modify_grad_creds'] .= '<p class="danger">Error: Graduation credits must be an integer</p>';
	} else if($credits < 1) {
		$_SESSION['c_modify_grad_creds'] .= '<p class="danger">Error: Graduation credits must be greater than or equal to 1</p>';
	} else {
		sql("UPDATE credit_reqs SET total_req=? WHERE area='Total'", "i", True, False, False, $credits);
		$_SESSION['c_modify_grad_creds'] .= '<p class="success">Graduation credits successfully changed to <b>' . $hsc($credits) . '</b></p>';
	}
}

