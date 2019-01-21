<?php

/*

Show links to c_students, c_classes, and c_other

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

$_SESSION['user_id'] = Null;
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
		<link href="style/font-awesome/css/font-awesome.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
			<a class="navbar-brand" href="counselor/c_home.php" rel="noopener noreferrer">
				<img src="favicon.ico" width="30" height="30" class="d-inline-block align-top">
				Course Tracker
			</a>
			<div class="btn-group" role="group">
				<a href="transit_to/to_logout.php" rel="noopener noreferrer" class="btn btn-outline-success">Logout</a>
			</div>
		</nav>

		<div class="container">
			<div class="alert alert-info counselor-alert text-center" role="alert">
				You are currently logged in as a <b>counselor</b>.
			</div>

			<div class="floatUp text-center">
				<div class="alert alert-dark" role="alert">
					<a href="counselor/c_students.php" rel="noopener noreferrer">
						<h1 class="display-4">Students <i class="fa fa-graduation-cap"></i></h1>
						<p class="mb-0">Modify &amp;<wbr> Check Student Progress.</p>
					</a>
				</div>
			</div>

			<div class="floatUp text-center">
				<div class="alert alert-dark" role="alert">
					<a href="counselor/c_classes.php" rel="noopener noreferrer">
						<h1 class="display-4">Classes <i class="fa fa-book"></i></h1>
						<p class="mb-0">Add, Modify, &amp;<wbr> Remove Classes</p>
					</a>
				</div>
			</div>

			<div class="floatUp text-center">
				<div class="alert alert-dark" role="alert">
					<a href="counselor/c_other.php" rel="noopener noreferrer">
						<h1 class="display-4">Other <i class="fa fa-cog"></i></h1>
						<p class="mb-0">Modify Requirements &amp;<wbr> Other Settings</p>
					</a>
				</div>
			</div>

		</div>
	</body>
</html>

