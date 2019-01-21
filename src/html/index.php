<?php

/*

Provide login form,
	clear and destroy session,
	show error messages,
	Show success message from registration

*/

session_start();
session_regenerate_id(True);

unset($_POST);

$_SESSION['login'] = False;

if(isset($_SESSION['error_die'])) {
	$error_die = $_SESSION['error_die'];

	if(isset($_SESSION['error_die_good'])) {
		$error_die_good = $_SESSION['error_die_good'];
	}
}

$_SESSION = array();
session_unset();
session_destroy();

session_start();

if(empty($_SESSION['token'])) {
	$_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Course Tracker for tracking student's progress towards graduation">
		<meta name="author" content="Esote">

		<base href="https://example.com/">

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<title>Couse Tracker</title>

		<link href="style/main.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<span class="navbar-brand mb-0 h1">
				<img src="favicon.ico" width="30" height="30">
				Course Tracker
			</span>
		</nav>

		<div class="container">
<?php
	if(isset($error_die)) {
		echo '<div class="error alert alert-', ((isset($error_die_good) && $error_die_good === True) ? 'success' : 'danger'), '" role="alert"><b>', $error_die, '</b></div><br>';
	}
	unset($error_die, $error_die_good);
?>
			<p class="lead text-center">New to the site? Click "<a rel="noopener noreferrer nofollow" href="register.php">Register</a>" down below.</p>

			<form class="login" method="post" action="transit_to/to_login.php" autocomplete="off">
				<noscript>
					<p class="lead text-center">This site requires JavaScript.</p>
					<br>
				</noscript>

				<h1 class="text-center display-2">Login</h1>

				<br>

				<label for="username" class="sr-only">Student ID</label>
				<input id="username" class="form-control" name="username" placeholder="Student ID" title="Example: 21167" required autofocus autocomplete="off">

				<label for="password" class="sr-only">Date of Birth</label>
				<input type="password" id="password" class="form-control" name="password" placeholder="Date of Birth (mmddyyyy)" title="Example: 03072003" required autocomplete="off">

				<br>

				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="login">Login</button>
				<input type="hidden" name="token" value="<?php echo $token ?>" readonly autocomplete="off" required>
			</form>

			<p class="lead text-center no-margin">&mdash; or &mdash;</p>

			<div class="login">
				<a rel="noopener noreferrer nofollow" href="register.php" class="btn btn-lg btn-danger btn-block">Register</a>
			</div>

			<br>

			<p class="lead text-center">This site requires cookies.</p>
		</div>
	</body>
</html>

