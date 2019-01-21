<?php

/*

Kill page and session, then redirect

*/

declare(strict_types = 1);

function kill(string $die_message, string $location = '') : void {
	session_regenerate_id(True);

	unset($_POST);

	if(isset($_SESSION['error_die_good'])) {
		$error_die_good = $_SESSION['error_die_good'];
	}

	$_SESSION = array();
	session_unset();

	$_SESSION['login'] = False;
	if(isset($die_message)) {
		$_SESSION['error_die'] = $die_message;

		if(isset($error_die_good)) {
			$_SESSION['error_die_good'] = $error_die_good;
		}
	}

	unset($error_die_good);

	session_write_close();

	sleep(1);

	header("Location: https://example.com/" . $location);
	die($die_message);
}

