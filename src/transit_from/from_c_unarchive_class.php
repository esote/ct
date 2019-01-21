<?php

/*

Unarchive class

*/

function c_unarchive_class($class_id, $class_name) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	sql("UPDATE classes SET archived='n' WHERE class_id=?", "i", True, False, False, $class_id);

	$_SESSION['c_unarchive_class'] = '<p class="success">Class <b>' . $hsc($class_name) . '</b> successfully unarchived</p>';
}

