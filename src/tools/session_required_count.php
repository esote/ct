<?php

/*

Get total number of classes required

*/

function session_required_count() {
	require_once __DIR__ . "/sql.php";

	$_SESSION['required_count'] = sql("SELECT COUNT(DISTINCT required_id) FROM classes WHERE required='y' AND archived='n'", '', False, True, False)['COUNT(DISTINCT required_id)'];
}

