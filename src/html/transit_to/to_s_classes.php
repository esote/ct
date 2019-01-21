<?php

/*

Modify a student's classes

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(isset($_SESSION['login']) && $_SESSION['login'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

$_POST = array_filter($_POST['class']);

require_once __DIR__ . "/../../transit_from/from_s_classes.php";

session_write_close();

s_classes($_POST, $_SESSION['user_id']);

unset($_POST);

