<?php

/*

Modify a student's classes

*/

function s_classes($classes, $user_id) {
	require_once __DIR__ . "/../tools/sql.php";

	sql("DELETE FROM relation WHERE user_id=?", "i", True, False, False, $user_id);

	if(count($classes) > 0) {
		$values_phdr = "(?,?,?)";
	} else {
		return;
	}

	$classes_args = array();
	$counter = 0;

	foreach($classes as $i) {
		if(($key = strpos($i, ",")) === False) continue;
		$year = (int)substr($i, 0, $key);
		$class_id = (int)substr($i, $key + 1);

		array_push($classes_args, $user_id, $class_id, $year);

		if($counter !== 0) {
			$values_phdr .= ",(?,?,?)";
		}

		$counter++;
	}

	$bind_vals = str_repeat("i", 3 * $counter);

	sql("INSERT INTO relation (user_id, class_id, year) VALUES " . $values_phdr,
		$bind_vals, True, False, False, ...$classes_args);
}

