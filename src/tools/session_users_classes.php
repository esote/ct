<?php

/*

Get a student's classes

*/

function session_users_classes($user_id) {
	require_once __DIR__ . "/sql.php";

	$_SESSION['users_classes'] = sql("SELECT classes.class_id,
		classes.class_name,
		classes.required,
		classes.required_id,
		classes.hs_terms,
		classes.college_credits,
		classes.area,
		classes.college_class,
		classes.ap_class,
		relation.user_id,
		relation.class_id,
		relation.year
		FROM classes
		INNER JOIN relation
		ON relation.class_id = classes.class_id
		AND relation.user_id = ?", 'i', True, True, True, $user_id);
}

