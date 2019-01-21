<?php

/*

Configure variables for home dashboard pages

*/

require_once __DIR__ . "/session_credit_reqs.php";
session_credit_reqs();

require_once __DIR__ . "/session_required_count.php";
session_required_count();

require_once __DIR__ . "/session_users_classes.php";
session_users_classes($_SESSION['user_id']);

require_once __DIR__ . "/session_senior_creds.php";
session_senior_creds($_SESSION['user_id']);

require_once __DIR__ . "/session_misc_info.php";
session_misc_info();

$core_areas = array();

foreach($_SESSION['credit_reqs'] as $i) {
	if($i['area'] === "Total") {
		continue;
	} else {
		$core_areas[] = array(
			"area" => $i['area'],
			"total_req" => $i['total_req'],
			"hexcolor" => $i['hexcolor'],
			"credits" => 0
		);
	}
}

$key = array_search('Total', array_column($_SESSION['credit_reqs'], 'area'));
$credits_total = $_SESSION['credit_reqs'][$key]['total_req'];
$credits_complete = 0;

$req_uniques = array();
$reqs_total = $_SESSION['required_count'];
$reqs_complete = 0;

foreach($_SESSION['users_classes'] as $i) {
	if(($key = array_search($i['area'], array_column($core_areas, 'area'))) !== False) {
		$core_areas[$key]['credits'] += $i['hs_terms'];
		$credits_complete += $i['hs_terms'];
	} else if(($key = array_search('Electives', array_column($core_areas, 'area'))) !== False) {
		$core_areas[$key]['credits'] += $i['hs_terms'];
		$credits_complete += $i['hs_terms'];
	}

	if($i['required'] === "y" && array_search($i['required_id'], $req_uniques) === False) {
		$req_uniques[] = $i['required_id'];
		$reqs_complete++;
	}
}

$elective_bonus = 0;

foreach($core_areas as $i) {
	if($i['area'] === "Total" || $i['area'] === "Electives") {
		continue;
	} else if($i['credits'] > $i['total_req']) {
		$elective_bonus += $i['credits'] - $i['total_req'];
	}
}

if($elective_bonus !== 0 && ($key = array_search('Electives', array_column($core_areas, 'area'))) !== False) {
	$core_areas[$key]['credits'] += $elective_bonus;
}

$full_senior_year = ($_SESSION['senior_creds'] >= $_SESSION['misc_info'][0]['value']);

if($full_senior_year === True && ($key = array_search('PE', array_column($core_areas, 'area'))) !== False) {
	$core_areas[$key]['total_req']--;
}

unset($req_uniques, $key);

