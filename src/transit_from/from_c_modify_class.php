<?php

/*

Modify class

*/

function c_modify_class($class_id, $class_name, $required, $required_id,
	$hs_terms, $college_credits, $area, $college_class, $ap_class) {
	session_regenerate_id(True);

	$class_name = trim($class_name);

	require_once __DIR__ . "/../tools/isInt.php";
	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	if(!isset($_SESSION['enum_areas']) || $_SESSION['enum_areas'] === Null) {
		require_once __DIR__ . "/../tools/session_c_enum_areas.php";
		session_c_enum_areas();
	}

	$_SESSION['c_modify_class'] = "";

	if(!isInt($class_id)) {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: Class ID was not an integer</p>';
		return;
	} else if(!sql("SELECT EXISTS(SELECT 1 FROM classes WHERE class_id=? LIMIT 1)", "i", True, True, False, $class_id)) {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: Class ID does not exist in database</p>';
		return;
	}

	if(!empty($class_name)) {
		sql("UPDATE classes SET class_name=? WHERE class_id=?", "si", True, False, False, $class_name, $class_id);
		$_SESSION['c_modify_class'] .= '<p class="success">Class name successfully changed to: <b>' . $hsc($class_name) . '</b></p>';
	}

	if($required !== "y" && $required !== "n") {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: "Required" was neither "Yes" nor "No"</p>';
	} else if(sql("SELECT required FROM classes WHERE class_id=?", "i", True, True, False, $class_id)['required'] !== $required) {
		sql("UPDATE classes SET required=? WHERE class_id=?", "si", True, False, False, $required, $class_id);
		$_SESSION['c_modify_class'] .= '<p class="success">"Required" successfully changed to: <b>' . $hsc((($required === "y") ? "Yes" : "No")) . '</b></p>';
	}

	if(!empty($required_id) || $required_id === "0") {
		if(!isInt($required_id) && $required_id !== "-" && $required_id !== "0") {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: Required ID was not an integer</p>';
		} else if($required_id < 0) {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: Required ID must be greater than or equal to zero</p>';
		} else {
			if($required_id === "-") {
				sql("UPDATE classes SET required_id=NULL WHERE class_id=?", "i", True, False, False, $class_id);
				$_SESSION['c_modify_class'] .= '<p class="success">Required ID successfully removed</p>';
			} else {
				sql("UPDATE classes SET required_id=? WHERE class_id=?", "ii", True, False, False, $required_id, $class_id);
				$_SESSION['c_modify_class'] .= '<p class="success">Required ID successfully changed to: <b>' . $hsc($required_id) . '</b></p>';
			}
		}
	}

	if(!empty($hs_terms) || $hs_terms === "0") {
		if(!isInt($hs_terms)) {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: High School Terms were not an integer</p>';
		} else if($hs_terms < 0) {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: High School Terms must be greater than or equal to zero</p>';
		} else {
			sql("UPDATE classes SET hs_terms=? WHERE class_id=?", "ii", True, False, False, $hs_terms, $class_id);
			$_SESSION['c_modify_class'] .= '<p class="success">High School Terms successfully changed to: <b>' . $hsc($hs_terms) . '</b></p>';
		}
	}

	if(!empty($college_credits) || $college_credits === "0") {
		if(!isInt($college_credits)) {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: College Credits were not an integer</p>';
		} else if($college_credits < 0) {
			$_SESSION['c_modify_class'] .= '<p class="danger">Error: College Credits must be greater than or equal to zero</p>';
		} else {
			sql("UPDATE classes SET college_credits=? WHERE class_id=?", "ii", True, False, False, $college_credits, $class_id);
			$_SESSION['c_modify_class'] .= '<p class="success">College Credits successfully changed to: <b>' . $hsc($college_credits) . '</b></p>';
		}
	}

	if(array_search($area, $_SESSION['enum_areas']) === False) {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: Core Area chosen was not an option</p>';
	} else if(sql("SELECT area FROM classes WHERE class_id=?", "i", True, True, False, $class_id)['area'] !== $area) {
		sql("UPDATE classes SET area=? WHERE class_id=?", "si", True, False, False, $area, $class_id);
		$_SESSION['c_modify_class'] .= '<p class="success">Core Area successfully changed to: <b>' . $hsc($area) . '</b></p>';
	}

	if($college_class !== "y" && $college_class !== "n") {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: "College Class" was neither "Yes" nor "No"</p>';
	} else if(sql("SELECT college_class FROM classes WHERE class_id=?", "i", True, True, False, $class_id)['college_class'] !== $college_class) {
		sql("UPDATE classes SET college_class=? WHERE class_id=?", "si", True, False, False, $college_class, $class_id);
		$_SESSION['c_modify_class'] .= '<p class="success">"College Class" successfully changed to: <b>' . $hsc((($college_class === "y") ? "Yes" : "No")) . '</b></p>';
	}

	if($ap_class !== "y" && $ap_class !== "n") {
		$_SESSION['c_modify_class'] .= '<p class="danger">Error: "AP Class" was neither "Yes" nor "No"</p>';
	} else if(sql("SELECT ap_class FROM classes WHERE class_id=?", "i", True, True, False, $class_id)['ap_class'] !== $ap_class) {
		sql("UPDATE classes SET ap_class=? WHERE class_id=?", "si", True, False, False, $ap_class, $class_id);
		$_SESSION['c_modify_class'] .= '<p class="success">"AP Class" successfully changed to: <b>' . $hsc((($ap_class === "y") ? "Yes" : "No")) . '</b></p>';
	}
}

