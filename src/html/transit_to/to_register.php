<?php

/*

Register

*/

session_start();
session_regenerate_id(True);

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_POST['submit'])) {
	kill("Error: Form submitted incorrectly.");
	die();
}

require_once __DIR__ . "/../../transit_from/from_register.php";

register(
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

