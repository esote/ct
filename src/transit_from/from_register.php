<?php

/*

Register

*/

declare(strict_types = 1);

function register(string $username, string $username_confirm, string $password,
	string $password_confirm, string $fname, string $lname, string $nickname,
	string $grad_date) : void {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/kill.php";

	$data_missing = array();

	$username = trim($username);
	$username_confirm = trim($username_confirm);
	$password = trim($password);
	$password_confirm = trim($password_confirm);
	$fname = trim($fname);
	$lname = trim($lname);
	$nickname = trim($nickname);
	$grad_date = trim($grad_date);

	if(empty($username)) $data_missing[] = "username";
	if(empty($username_confirm)) $data_missing[] = "username_confirm";
	if(empty($password)) $data_missing[] = "password";
	if(empty($password_confirm)) $data_missing[] = "password_confirm";
	if(empty($fname)) $data_missing[] = "fname";
	if(empty($lname)) $data_missing[] = "lname";
	// nickname can be empty
	if(empty($grad_date)) $data_missing[] = "grad_date";

	if(!empty($data_missing)) {
		kill("Error: All fields were not filled in.");
		die();
	}

	if($username !== $username_confirm) {
		kill("Error: Student ID did not match confirmation.");
		die();
	}

	unset($username_confirm);

	if($password !== $password_confirm) {
		kill("Error: Date of Birth entered did not match confirmation.");
		die();
	}

	unset($password_confirm);

	$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

	require_once __DIR__ . "/../tools/sql.php";

	// username already exists
	$row = sql("SELECT username FROM users WHERE username=?", "s", True, True, False, $username);

	if($username === $row['username']) {
		kill("Error: Student already exists with that Student ID.");
		die();
	}

	sql("INSERT INTO users (user_id, username, password, fname, lname, nickname, grad_date, counselor, last_login, first_login) VALUES (NULL, ?, ?, ?, ?, ?, ?, 'n', NOW(), NOW())", "ssssss", True, False, False,
		$username, $password, $fname, $lname, $nickname, $grad_date);

	$_SESSION['error_die_good'] = True;
	kill("Account created!<br>Login to access the Course Tracker.");
	die();
}

