<?php

/*

Modify student

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_c_modify_student.php";

c_modify_student($_SESSION['user_id'],
	$_POST['username'],
	$_POST['username_confirm'],
	$_POST['password'],
	$_POST['password_confirm'],
	$_POST['fname'],
	$_POST['lname'],
	$_POST['nickname'],
	$_POST['grad_date']
);

unset($_POST);

$_SESSION['counselor-choose-student-override'] = $_SESSION['user_id'];
header("Location: https://example.com/counselor/c_students.php");
die();

