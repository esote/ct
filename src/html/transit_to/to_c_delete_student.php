<?php

/*

Delete student

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_c_delete_student.php";

c_delete_student($_SESSION['user_id']);

unset($_POST);

header("Location: https://example.com/counselor/c_students.php");
die();

