<?php

/*

Print HTML required for courselist pages

Variables needed:
	$classes

*/

if(!isset($classes)) {
	require_once __DIR__ . "/kill.php";
	kill("Error: Unable to find required variables.");
	die();
}

require_once __DIR__ . "/hsc.php";

echo '<div class="datatable-container">
<table id="datatable" class="table table-sm courselist table-bordered table-hover">
	<thead>
		<tr>
			<th>Class Name</th>
			<th>Required</th>
			<th>Required ID</th>
			<th>HS Credits</th>
			<th>College Credits</th>
			<th>Core Area</th>
			<th>College Class</th>
			<th>AP Class</th>
		</tr>
	</thead>
	<tbody>';

foreach($classes as $i) {
	$i['required'] = ($i['required'] === "y") ? "Yes" : Null;

	if($i['hs_terms'] === 0) $i['hs_terms'] = Null;

	if($i['college_credits'] === 0) $i['college_credits'] = Null;

	$i['college_class'] = ($i['college_class'] === "y") ? "Yes" : Null;

	$i['ap_class'] = ($i['ap_class'] === "y") ? "Yes" : Null;

	echo <<<EOT

		<tr>
			<td>{$hsc($i['class_name'])}</td>
			<td>{$hsc($i['required'])}</td>
			<td>{$hsc($i['required_id'])}</td>
			<td>{$hsc($i['hs_terms'])}</td>
			<td>{$hsc($i['college_credits'])}</td>
			<td>{$hsc($i['area'])}</td>
			<td>{$hsc($i['college_class'])}</td>
			<td>{$hsc($i['ap_class'])}</td>
		</tr>
EOT;
}

echo '</tbody></table></div><br>';

