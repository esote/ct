<?php

/*

Create new class

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_c_new_class.php";

c_new_class($_POST['class_name'],
	$_POST['required'],
	$_POST['required_id'],
	$_POST['hs_terms'],
	$_POST['college_credits'],
	$_POST['area'],
	$_POST['college_class'],
	$_POST['ap_class']
);

unset($_POST);

header("Location: https://example.com/counselor/c_classes.php");
die();

