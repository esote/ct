<?php

/*

Modify student

*/

function c_modify_student($user_id, $username, $username_confirm,
	$password, $password_confirm, $fname, $lname, $nickname, $grad_date) {
	session_regenerate_id(True);

	$username = trim($username);
	$username_confirm = trim($username_confirm);
	$password = trim($password);
	$password_confirm = ($password_confirm);
	$fname = trim($fname);
	$lname = trim($lname);
	$nickname = trim($nickname);
	$grad_date = trim($grad_date);

	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	$_SESSION['c_modify_student'] = "";

	if(!empty($username) && !empty($username_confirm)
		&& $username === $username_confirm) {
		// username already exists
		$row = sql("SELECT username FROM users WHERE username=?", "s", True, True, False, $username);

		if($username === $row['username']) {
			$_SESSION['c_modify_student'] .= '<p class="danger">Error: Username already exists</p>';
		} else {
			sql("UPDATE users SET username=? WHERE user_id=?", "si", True, False, False, $username, $user_id);
			$_SESSION['c_modify_student'] .= '<p class="success">Username successfully changed to: <b>' . $hsc($username) . '</b></p>';
		}
	} else if($username !== $username_confirm) {
		$_SESSION['c_modify_student'] .= '<p class="danger">Error: Username confirmation failed</p>';
	}

	if(!empty($password) && !empty($password_confirm)
		&& $password === $password_confirm) {
		$password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
		sql("UPDATE users SET password=? WHERE user_id=?", "si", True, False, False, $password, $user_id);
		$_SESSION['c_modify_student'] .= '<p class="success">Password successfully changed</p>';
	} else if($password !== $password_confirm) {
		$_SESSION['c_modify_student'] .= '<p class="danger">Error: Password confirmation failed</p>';
	}

	if(!empty($fname)) {
		sql("UPDATE users SET fname=? WHERE user_id=?", "si", True, False, False, $fname, $user_id);
		$_SESSION['c_modify_student'] .= '<p class="success">First Name successfully changed to: <b>' . $hsc($fname) . '</b></p>';
	}

	if(!empty($lname)) {
		sql("UPDATE users SET lname=? WHERE user_id=?", "si", True, False, False, $lname, $user_id);
		$_SESSION['c_modify_student'] .= '<p class="success">Last Name successfully changed to: <b>' . $hsc($lname) . '</b></p>';
	}

	if(!empty($nickname)) {
		if($nickname === "-") $nickname = "";
		sql("UPDATE users SET nickname=? WHERE user_id=?", "si", True, False, False, $nickname, $user_id);
		$_SESSION['c_modify_student'] .= (($nickname === "") ? '<p class="success">Nickname successfully removed</p>' : '<p class="success">Nickname successfully changed to: <b>' . $hsc($nickname) . '</b></p>');
	}

	if(!empty($grad_date)) {
		sql("UPDATE users SET grad_date=? WHERE user_id=?", "si", True, False, False, $grad_date, $user_id);
		$_SESSION['c_modify_student'] .= '<p class="success">Graduation Date successfully changed to: <b>' . $hsc($grad_date) . '</b></p>';
	}

}

