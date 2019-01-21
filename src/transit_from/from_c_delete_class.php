<?php

/*

Delete class

*/

function c_delete_class($class_id, $class_name) {
	session_regenerate_id(True);

	require_once __DIR__ . "/../tools/sql.php";
	require_once __DIR__ . "/../tools/hsc.php";

	sql("DELETE FROM classes WHERE class_id=?", "i", True, False, False, $class_id);
	sql("DELETE FROM relation WHERE class_id=?", "i", True, False, False, $class_id);

	$_SESSION['c_delete_class'] = '<p class="success">Class <b>' . $hsc($class_name) . '</b> successfully deleted</p>';
}

