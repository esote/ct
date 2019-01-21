<?php

/*

Delete student

*/

function c_delete_student($user_id) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/sql.php";

	sql("DELETE FROM users WHERE user_id=?", "i", True, False, False, $user_id);
	sql("DELETE FROM relation WHERE user_id=?", "i", True, False, False, $user_id);

	$_SESSION['c_delete_student'] = '<p class="success">Student successfully deleted</p>';
}

