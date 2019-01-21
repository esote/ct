<?php

/*

Login

*/

session_start();
session_regenerate_id(True);

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_POST['submit'])) {
	kill("Error: Form submitted incorrectly.");
	die();
}

if(empty($_POST['token'])) {
	kill("Error: Missing CSRF token.");
	die();
} else if(!hash_equals($_SESSION['token'], $_POST['token'])) {
	kill("Error: Incorrect CSRF token.");
	die();
} else {
	unset($_SESSION['token']);
}

require_once __DIR__ . "/../../transit_from/from_login.php";

login($_POST['username'], $_POST['password']);

unset($_POST);

if(!isset($_SESSION['login']) || $_SESSION['login'] !== True) {
	kill("Error: Not redirected correctly.");
	die();
}

if(isset($_SESSION['counselor']) && $_SESSION['counselor'] === True) {
	header('Location: https://example.com/counselor/c_home.php');
	die();
} else {
	header('Location: https://example.com/student/s_home.php');
	die();
}

