<?php

/*

Show overview and credit totals,
	redirect to counselor home if logged in as a counselor

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || $_SESSION['login'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

if(isset($_SESSION['counselor']) && $_SESSION['counselor'] === True) {
	header("Location: https://example.com/counselor/c_home.php");
	die();
}

require __DIR__ . "/../../tools/gen_begin_home.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<base href="https://example.com/">

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<title>Couse Tracker</title>

		<link href="style/main.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
			<a class="navbar-brand" href="student/s_home.php" rel="noopener noreferrer">
				<img src="favicon.ico" width="30" height="30" class="d-inline-block align-top">
				Course Tracker
			</a>
			<div class="btn-group right" role="group">
				<a rel="noopener noreferrer" class="btn btn-secondary btn-sm active" href="student/s_home.php">Home <span class="sr-only">(current)</span></a>
				<a rel="noopener noreferrer" class="btn btn-secondary btn-sm" href="student/s_classes.php">Classes</a>
				<a rel="noopener noreferrer" class="btn btn-secondary btn-sm" href="student/s_courselist.php">Course List</a>
			</div>
			<div class="btn-group" role="group">
				<a href="transit_to/to_logout.php" rel="noopener noreferrer" class="btn btn-outline-success">Logout</a>
			</div>
		</nav>

		<div class="container">

		<?php
		require __DIR__ . "/../../tools/gen_middle_home.php";
		?>

			<br>
		</div>

		<?php
		require __DIR__ . "/../../tools/gen_end_home.php";
		?>

	</body>
</html>

