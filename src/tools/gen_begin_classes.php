<?php

/*

Configure variables for classes pages

*/

require_once __DIR__ . "/session_misc_info.php";
session_misc_info();

require_once __DIR__ . "/session_classes.php";
session_classes();

require_once __DIR__ . "/session_credit_reqs.php";
session_credit_reqs();

require_once __DIR__ . "/session_users_classes.php";
session_users_classes($_SESSION['user_id']);

$credits_per_year = $_SESSION['misc_info'][0]['value'];

$years = $_SESSION['misc_info'][1]['value'];

$classes = array_merge($_SESSION['classes'], $_SESSION['classes_archived']);

$credit_reqs = array();
foreach($_SESSION['credit_reqs'] as $i) {
	if($i['area'] === "Total") {
		continue;
	} else {
		$credit_reqs[] = array($i['area'], $i['total_req'], $i['hexcolor']);
	}
}

$users_classes = $_SESSION['users_classes'];

usort($users_classes, function($a, $b) {
	return strcasecmp($a['year'], $b['year']);
});

