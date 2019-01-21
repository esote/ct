<?php

/*

Get information for a student using ID

*/

function c_selected_student($user_id) {
	require_once __DIR__ . "/kill.php";

	if(!isset($_SESSION['counselor']) || $_SESSION['counselor'] !== True) {
		kill("Error: Credentials not sent.");
		die();
	}

	require_once __DIR__ . "/sql.php";
	$_SESSION['selected_student'] = sql("SELECT user_id, username, fname, lname, nickname, grad_date, last_login, first_login FROM users WHERE user_id = ?", "i", True, True, False, $user_id);
}

