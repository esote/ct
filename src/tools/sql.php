<?php

/*

Execute an escaped, customizable SQL query

*/

declare(strict_types = 1);

function sql(string $query, string $type_bind, bool $bind, bool $return, bool $fetch_all, & ... $vars) : ?array {
	require __DIR__ . "/../connect.php";
	require_once __DIR__ . "/kill.php";

	$stmt = mysqli_prepare($conn, $query);

	if($stmt === False) {
		kill("Error: SQL prepare failed.");
		die();
	}

	if($bind === True && mysqli_stmt_bind_param($stmt, $type_bind, ... $vars) === False) {
		kill("Error: Binding parameters failed.");
		die();
	}

	if(mysqli_stmt_execute($stmt) === False) {
		kill("Error: SQL execute failed.");
		die();
	}

	if($return === True) {
		$result = mysqli_stmt_get_result($stmt);
		if($fetch_all === True) {
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);

	return ($return === True) ? $row : Null;
}

