<?php

/*

Provide registration form,
	clear and destroy session

*/

session_start();
session_regenerate_id(True);

unset($_POST);

$_SESSION = array();
session_unset();
session_destroy();
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
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<a class="navbar-brand" href="." rel="noopener noreferrer">
				<img src="favicon.ico" width="30" height="30">
				Course Tracker
			</a>
		</nav>

		<div class="container">
			<form class="register" method="post" action="transit_to/to_register.php">
				<h1 class="text-center display-2">Register</h1>

				<br>

				<!-- Student ID -->
				<label for="username">Student ID <span>(Ex: 21167)</span></label>
				<input id="username" class="form-control" name="username" placeholder="Student ID" title="Example: 21167" required autofocus>

				<!-- Student ID Confirm -->
				<label for="username_confirm" class="sr-only">Confirm Student ID</label>
				<input id="username_confirm" class="form-control" name="username_confirm" placeholder="Confirm Student ID" title="Example: 21167" required>

				<br>

				<!-- Date of Birth -->
				<label for="password">Date of Birth <b>(mmddyyyy)</b> <span title="For March 7, 2003">(Ex: 03072003 for March 7, 2003)</span></label>
				<input id="password" type="password" class="form-control" name="password" placeholder="Date of Birth" title="Example: 03072003" required>

				<!-- Date of Birth Confirm -->
				<label for="password_confirm" class="sr-only">Date of Birth</label>
				<input id="password_confirm" type="password" class="form-control" name="password_confirm" placeholder="Confirm Date of Birth" title="Example: 03072003" required>

				<br>

				<!-- First Name -->
				<label for="fname">First Name <span>(Ex: John)</span></label>
				<input id="fname" class="form-control input-solo" name="fname" placeholder="First Name" title="Example: John" required>

				<br>

				<!-- Last Name -->
				<label for="lname">Last Name <span>(Ex: Doe)</span></label>
				<input id="lname" class="form-control input-solo" name="lname" placeholder="Last Name" title="Example: Doe" required>

				<br>

				<!-- Graduation Date -->
				<label for="grad_date">Graduation Year <span>(Ex: 2021)</span></label>
				<input id="grad_date" class="form-control input-solo" name="grad_date" placeholder="Graduation Year" title="Example: 2021" required>

				<br>

				<!-- Nickname -->
				<label for="nickname">Preferred Name <b>(OPTIONAL)</b> <span> (Ex: JD)</span></label>
				<input id="nickname" class="form-control input-solo" name="nickname" placeholder="Preferred Name" title="Example: JD">

				<p class="text-center"><small>Enter a preferred name if you don't go by your legal name.</small></p>

				<!-- Submit -->
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="register">Register</button>
			</form>
		</div>
	</body>
</html>

