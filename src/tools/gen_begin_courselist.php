<?php

/*

Configure variables for courselist pages

*/

require_once __DIR__ . "/session_classes.php";
session_classes();

$classes = array_merge($_SESSION['classes'], $_SESSION['classes_archived']);

usort($classes, function($a, $b) {
	return strcasecmp($a['class_name'], $b['class_name']);
});

