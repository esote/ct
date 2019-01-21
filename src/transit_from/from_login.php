<?php

/*

Login

*/

declare(strict_types = 1);

function login(string $username, string $password) : void {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/kill.php";

	$data_missing = array();

	$username = trim($username);
	$password = trim($password);

	if(empty($username)) $data_missing[] = "username";
	if(empty($password)) $data_missing[] = "password";

	if(!empty($data_missing)) {
		kill("Error: Not all fields were filled in.");
		die();
	}

	require_once __DIR__ . "/../tools/sql.php";

	$row = sql("SELECT user_id, username, password, grad_date, counselor FROM users WHERE username=?", "s", True, True, False, $username);

	if($row['password'] === Null || !password_verify($password, $row['password'])) {
		kill("Error: Login unsuccessful, incorrect credentials.");
		die();
	}

	$_SESSION['login'] = True;
	$_SESSION['username'] = $row['username'];
	$_SESSION['grad_date'] = $row['grad_date'];

	if($row['counselor'] === "y") {
		$_SESSION['user_id'] = Null;
		$_SESSION['counselor'] = True;
	} else {
		$_SESSION['user_id'] = $row['user_id'];
	}

	// Update last_login
	sql("UPDATE users SET last_login=CURRENT_TIMESTAMP WHERE username=?", "s",
		True, False, False, $row['username']);

	unset($row);
}

