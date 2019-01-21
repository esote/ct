<?php

/*

Print JavaScript required for home dashboard pages

Variables needed:
	$credits_complete
	$credits_total
	$reqs_complete
	$reqs_total
	$core_areas

*/

if(!isset($credits_complete,
	$credits_total,
	$reqs_complete,
	$reqs_total,
	$core_areas)) {
	require_once __DIR__ . "/kill.php";
	kill("Error: Unable to find required variables.");
	die();
}

require_once __DIR__ . "/hsc.php";

echo '<script src="style/pgresscore.js"></script>
<script src="style/pgressbuilder.js"></script>
<script>', "\n";

if(!isset($_SESSION['counselor']) || $_SESSION['counselor'] !== True) {
	echo 'window.onload=function(){window.location.hash||(window.location=window.location+"#top",window.location.reload())};';
}

echo 'Circle(credits, "#aaa", "#333", "', $hsc($credits_complete), '", "', $hsc($credits_total), '", "credits");
Circle(reqs, "#3399ff", "#003366", "', $hsc($reqs_complete), '", "', $hsc($reqs_total), '", "required classes");', "\n";

foreach($core_areas as $i) {
	echo 'Bar(', $hsc(str_replace(' ', '', strtolower($i['area']))), ', "', $i['hexcolor'], '", ', $hsc($i['credits']), ', ', $hsc($i['total_req']), ");\n";
}

echo '</script>';

