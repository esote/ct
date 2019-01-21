<?php

/*

Provide database connection

*/

declare(strict_types = 1);

$conn = mysqli_init();

$db_config = parse_ini_file(__DIR__ . '/db-config.ini');

if($conn !== False && $db_config !== False
	&& (mysqli_real_connect($conn, $db_config['servername'], $db_config['username'], $db_config['password'], $db_config['dbname'], 3306) !== False)) {

	unset($db_config);

	mysqli_set_charset($conn, "utf8");
} else {
	session_regenerate_id(True);

	unset($db_config, $conn);

	$_SESSION = array();
	session_unset();

	session_destroy();

	sleep(1);

	header("Location: https://example.com/");
	die("Error: Could not connect to database");
}

