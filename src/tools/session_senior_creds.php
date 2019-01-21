<?php

/*

Get total number of credits for senior year (3)

*/

function session_senior_creds($user_id) {
	require_once __DIR__ . "/sql.php";

	$_SESSION['senior_creds'] = sql("SELECT SUM(classes.hs_terms)
		FROM classes
		INNER JOIN relation
		ON relation.class_id = classes.class_id
		WHERE relation.user_id = ?
		AND relation.year = '3'", 'i', True, True, False, $user_id)['SUM(classes.hs_terms)'];
}

