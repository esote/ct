<?php

/*

Archive class

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_c_archive_class.php";

c_archive_class($_POST['class_id'], $_POST['class_name']);

unset($_POST);

header("Location: https://example.com/counselor/c_classes.php");
die();

