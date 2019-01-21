<?php

/*

Get list of classes

*/

function session_classes($sort = True, $get_archived = True) {
	require_once __DIR__ . "/sql.php";

	$_SESSION['classes'] = sql("SELECT class_id, class_name, required, required_id, hs_terms, college_credits, area, college_class, ap_class, archived FROM classes WHERE archived='n'", '', False, True, True);

	if($get_archived === True) {
		$_SESSION['classes_archived'] = sql("SELECT class_id, class_name, required, required_id, hs_terms, college_credits, area, college_class, ap_class, archived FROM classes WHERE archived='y'", '', False, True, True);
	}

	if($sort === True) {
		usort($_SESSION['classes'], function($a, $b) {
			return strcasecmp($a['class_name'], $b['class_name']);
		});

		if($get_archived === True) {
			usort($_SESSION['classes_archived'], function($a, $b) {
				return strcasecmp($a['class_name'], $b['class_name']);
			});
		}
	}
}

