<?php

/*

Print HTML required for home dashboard pages

Variables needed:
	$core_areas
	$elective_bonus
	$full_senior_year

*/

if(!isset($core_areas,
	$elective_bonus,
	$full_senior_year)) {
	require_once __DIR__ . "/kill.php";
	kill("Error: Unable to find required variables.");
	die();
}

require_once __DIR__ . "/hsc.php";

echo '<div class="row align-items-start">
<div class="col-md-6 bottom"><div id="credits" class="pgress-circle"></div></div>
<div class="col-md-6 bottom"><div id="reqs" class="pgress-circle"></div></div>
<div class="col-md-12"><h2 class="text-center">Required Credits</h2><br></div>';

foreach($core_areas as $i) {
	echo '<div class="col-md-6 bottom">
	<h3 class="text-center">', $hsc($i['area']), '</h3>
	<div id="', $hsc(str_replace(' ', '', strtolower($i['area']))), '" class="pgress-bar"></div>';

	if($i['area'] === "PE" && $full_senior_year === True) {
		echo '<br><p class="text-center golden">Reduced total: <span>full senior year</span></b></p>';
	}

	if($i['area'] === "Electives" && $elective_bonus !== 0) {
		echo '<br><p class="text-center golden"><span>+', $hsc($elective_bonus), '</span> credits for extra core credits</p>';
	}

	echo '</div>', "\n";
}

echo '</div>';

