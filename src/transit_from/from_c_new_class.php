<?php

/*

Create new class

*/

function c_new_class($class_name, $required, $required_id, $hs_terms,
	$college_credits, $area, $college_class, $ap_class) {
	session_regenerate_id(True);

	$class_name = trim($class_name);

	require_once __DIR__ . "/../tools/isInt.php";
	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	if(!isset($_SESSION['enum_areas']) || $_SESSION['enum_areas'] === Null) {
		require_once __DIR__ . "/../tools/session_c_enum_areas.php";
		session_c_enum_areas();
	}

	$_SESSION['c_new_class'] = "";

	if(empty($class_name)) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: Class must have a name</p>';
	} else if($required !== "y" && $required !== "n") {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: "Required" must be Yes or No</p>';
	} else if(!isInt($hs_terms)) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: HS Credits must be an integer</p>';
	} else if($hs_terms < 0) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: HS Credits must greater than or equal to zero</p>';
	} else if(!isInt($college_credits)) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: College Credits must be an integer</p>';
	} else if($college_credits < 0) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: College Credits must be greater than or equal to zero</p>';
	} else if(array_search($area, $_SESSION['enum_areas']) === False) {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: Core Area chosen was not an option</p>';
	} else if($college_class !== "y" && $college_class !== "n") {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: "College Class" must be Yes or No</p>';
	} else if($ap_class !== "y" && $ap_class !== "n") {
		$_SESSION['c_new_class'] .= '<p class="danger">Error: "AP Class" must be Yes or No</p>';
	} else {
		if(empty($required_id) && $required_id !== "0") $required_id = Null;
		sql("INSERT INTO classes (class_id, class_name, required, required_id, hs_terms, college_credits, area, college_class, ap_class, archived) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, 'n')", "ssiiisss", True, False, False, $class_name, $required, $required_id, $hs_terms, $college_credits, $area, $college_class, $ap_class);
		$_SESSION['c_new_class'] .= '<p class="success"><b>Class Added Successfully</b></p>';
	}
}

