<?php

/*

Modify credits per year

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_c_modify_creds_per_year.php";

c_modify_creds_per_year($_POST['credits']);

unset($_POST);

header("Location: https://example.com/counselor/c_other.php");
die();

