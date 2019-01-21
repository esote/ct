<?php

/*

Get list of students

*/

function session_c_students() {
	require_once __DIR__ . "/kill.php";

	if(!isset($_SESSION['counselor']) || $_SESSION['counselor'] !== True) {
		kill("Error: Credentials not sent.");
		die();
	}

	require_once __DIR__ . "/sql.php";

	$_SESSION['students'] = sql("SELECT user_id, username, fname, lname, nickname, grad_date, last_login, first_login FROM users WHERE counselor='n'", '', False, True, True);
}

