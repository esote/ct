<?php

/*

Print HTML required for classes pages

Variables needed:
	$years
	$credits_per_year
	$classes
	$users_classes

*/

if(!isset($years,
	$credits_per_year,
	$classes,
	$users_classes)) {
	require_once __DIR__ . "/kill.php";
	kill("Error: Unable to find required variables.");
	die();
}

require_once __DIR__ . "/hsc.php";

echo '<div class="row justify-content-center">
	<div class="col-md-10">
		<h2 class="text-center">Help &amp; Suggestions</h2>

		<br>

		<ul class="help-text">
			<li>Search with <code>I</code> instead of <code>1</code>: <code>Art I</code> instead of <code>Art 1</code></li>
			<li>Search partial terms: <code>Gov</code>, <code>Politics</code> instead of "<code>AP U.S. Government &amp; Politics</code>"</li>
			<li>To search by area, type <code>[<var>Area</var>]</code>: <code>[Science]</code> or <code>[PE]</code></li>
			<li>To search by number of credits, type <code>[<var>Creds</var>]</code>: <code>[1]</code> or <code>[4]</code></li>
			<li>Classes labelled <code>[Archived]</code> can still be clicked</li>
			<li>Classes taken before freshman year (<b>that count for HS credit</b>) can be put with your freshmen year classes</li>
			<li>Dropped a class? Select "<code>(Empty) Dropped Credit [<i>Area</i>]</code>" for each <b>completed</b> credit. Be sure to choose the correct class area in brackets</li>
			<li>Cannot find a class? Taken a class outside of the school district? Choose the closest class with the <b>same number of credits, and the same core area,</b> or use the "<code>Dropped Credit</code>" classes</li>
			<li>If you have sports or School-to-Work in your senior year, and know you do not have to take PE senior year, select the class "<code>PE Exempt Senior Year (1 extra PE credit)</code>"
		</ul>

		<br>
	</div>
</div>

<div class="row justify-content-center">
	<div class="col-md-12">
		<form id="sendClasses" method="post" action="transit_to/to_s_classes.php">
		<nav class="nav nav-pills nav-justified" id="tabs" role="tablist">';

for($i = 0; $i < $years; ++$i) {
	$active = (($i === 0) ? "active" : "");

	switch($i) {
		case 0: $yname = "Freshman"; break;
		case 1: $yname = "Sophomore"; break;
		case 2: $yname = "Junior"; break;
		case 3: $yname = "Senior"; break;
		default: $yname = "Year " . ($i + 1);
	}

	echo '<a rel="noopener noreferrer" class="nav-item nav-link ', $hsc($active), '" data-toggle="tab" id="nav-', $hsc($i), '-tab" href="#nav-', $hsc($i), '" role="tab">', $hsc($yname), '</a>', "\n";
}

echo '</nav><div class="tab-content">';

for($i = 0; $i < $years; ++$i) {
	$active = (($i === 0) ? "show active" : "");

	switch($i) {
		case 0: $yname = "Freshmen"; break;
		case 1: $yname = "Sophomore"; break;
		case 2: $yname = "Junior"; break;
		case 3: $yname = "Senior"; break;
		default: $yname = "Year " . ($i + 1);
	}

	echo <<<EOT

			<div class="tab-pane fade {$hsc($active)}" id="nav-{$hsc($i)}" role="tabpanel">
				<div class="classes-success alert alert-success" role="alert"><b>Classes successfully changed!</b></div>
				<h2 class="text-center">{$hsc($yname)} Year</h2>
				<table class="table text-center f-70 table-bordered table-hover">
					<thead>
						<tr>
							<th>Class Name [Credits] [Area]</th>
							<th>HS Credits</th>
						</tr>
						<tr>
							<th>Total {$hsc($yname)} Credits</th>
							<th id="{$hsc($i)}"></th>
						</tr>
					</thead>
					<tbody>
EOT;

	for($j = 0; $j < $credits_per_year; ++$j) {
		$already_selected = False;

		echo '<tr><td><select name="class[]" data-placeholder="Class..." class="chosen-select">
							<option value=""></option>';

		foreach($classes as $k) {
			$selected = "";

			if(isset($users_classes[0]) && $already_selected !== True && ($users_classes[0]['class_id'] === $k['class_id']) && ($users_classes[0]['year'] === $i)) {
				$selected = "selected";
				$already_selected = True;
				array_shift($users_classes);
			}

			$archived = ($k['archived'] === 'y') ? "[Archived] " : "";
			$archived_disable = ($k['archived'] === 'y') ? " class='archived' " : "";

			echo <<<EOT

							<option {$hsc($archived_disable)} value="{$hsc($i)},{$hsc($k['class_id'])}" {$hsc($selected)}>{$hsc($archived)}{$hsc($k['class_name'])} [{$hsc($k['hs_terms'])}] [{$hsc($k['area'])}]</option>
EOT;
		}

		echo '</select></td><td></td></tr>';
	}

	echo '</tbody></table><br></div>';

}

echo '</div></form></div></div>';

