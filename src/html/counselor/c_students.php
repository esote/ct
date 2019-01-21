<?php

/*

Allow counselor to view list of students (not counselor users),
	allow counselor to select student to edit,
	view all student can see and do all students can do
	edit student information or delete student

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

if(isset($_SESSION['counselor-choose-student-override'])) {
	$_POST['counselor-choose-student'] = $_SESSION['counselor-choose-student-override'];
	unset($_SESSION['counselor-choose-student-override']);
}

$student_selected = isset($_POST['counselor-choose-student']);

$_SESSION['user_id'] = (($student_selected === True) ? (int)$_POST['counselor-choose-student'] : Null);

if($student_selected) {
	require __DIR__ . "/../../tools/gen_begin_home.php";
	require __DIR__ . "/../../tools/gen_begin_classes.php";
	require __DIR__ . "/../../tools/gen_begin_courselist.php";
	require_once __DIR__ . "/../../tools/session_c_selected_student.php";
	c_selected_student($_SESSION['user_id']);
} else {
	require_once __DIR__ . "/../../tools/session_c_students.php";
	session_c_students();
	$students = $_SESSION['students'];
}

require_once __DIR__ . "/../../tools/hsc.php";
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
		<?php
		if($student_selected === True) {
			echo '<link href="style/chosen/chosen.min.css" rel="stylesheet">', "\n";
		} ?>
		<link href="style/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="style/datatables.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
			<a class="navbar-brand" href="counselor/c_home.php" rel="noopener noreferrer">
				<img src="favicon.ico" width="30" height="30" class="d-inline-block align-top">
				Course Tracker
			</a>
			<div class="btn-group" role="group">
				<?php
				if($student_selected === True) {
					echo '<form method="post" action="counselor/c_students.php">
					<button type="submit" class="btn btn-outline-success btn-group-form" name="counselor-choose-student" value="', $hsc($_SESSION['selected_student']['user_id']), '">Refresh</button>
				</form>
				<a href="counselor/c_students.php" rel="noopener noreferrer" class="btn btn-outline-info">Go Back</a>
				<a href="counselor/c_home.php" rel="noopener noreferrer" class="btn btn-outline-warning">Home</a>', "\n";
				} else {
					echo '<a href="counselor/c_home.php" rel="noopener noreferrer" class="btn btn-outline-warning">Home</a>', "\n";
				}
				?>
			</div>
		</nav>

		<?php
		if($student_selected === True) {
			echo '<div class="container">';

			if(isset($_SESSION['c_modify_student'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Student Changes Summary</h3>', $_SESSION['c_modify_student'], '</div>';
				unset($_SESSION['c_modify_student']);
			}

			echo <<<EOT

			<div class="datatable-container">
				<table class="table table-sm table-bordered text-center">
					<thead>
						<tr>
							<th>Edit</th>
							<th>Student ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Graduation Date</th>
							<th>Nickname</th>
							<th>Last Login</th>
							<th>First Login</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></button></td>
							<td>{$hsc($_SESSION['selected_student']['username'])}</td>
							<td>{$hsc($_SESSION['selected_student']['fname'])}</td>
							<td>{$hsc($_SESSION['selected_student']['lname'])}</td>
							<td>{$hsc($_SESSION['selected_student']['grad_date'])}</td>
							<td>{$hsc($_SESSION['selected_student']['nickname'])}</td>
							<td><small>{$hsc($_SESSION['selected_student']['last_login'])}</small></td>
							<td><small>{$hsc($_SESSION['selected_student']['first_login'])}</small></td>
							<td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modaldelete"><i class="fa fa-trash"></i></button></td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Delete -->
			<div class="modal fade" id="modaldelete" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_delete_student.php">
							<div class="modal-header">
								<h1 class="modal-title display-5">Delete Student</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p class="lead text-center modal-warning">Are you sure you want to delete this student?</p>
								<p class="text-center">This action cannot be undone, and is entirely permanent!</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-danger">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Delete End -->

			<!-- Modify -->
			<div class="modal fade" id="modal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_modify_student.php">
							<div class="modal-header">
								<h1 class="modal-title display-5">Edit Student</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body modal-compare">
									<p class="text-center">Leave fields blank to remain unchanged</p>

									<br>

									<h4 class="display-5">Student ID</h4>
									<table class="table table-sm">
										<tr>
											<td>Old</td>
											<td>:</td>
											<td>{$hsc($_SESSION['selected_student']['username'])}</td>
										</tr>
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="username" placeholder="{$hsc($_SESSION['selected_student']['username'])}"/></td>
										</tr>
										<tr>
											<td>Confirm</td>
											<td>:</td>
											<td><input class="form-control" name="username_confirm"/></td>
										</tr>
									</table>

									<br>

									<h4 class="display-5">First Name</h4>
									<table class="table table-sm">
										<tr>
											<td>Old</td>
											<td>:</td>
											<td>{$hsc($_SESSION['selected_student']['fname'])}</td>
										</tr>
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="fname" placeholder="{$hsc($_SESSION['selected_student']['fname'])}"/></td>
										</tr>
									</table>

									<br>

									<h4 class="display-5">Last Name</h4>
									<table class="table table-sm">
										<tr>
											<td>Old</td>
											<td>:</td>
											<td>{$hsc($_SESSION['selected_student']['lname'])}</td>
										</tr>
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="lname" placeholder="{$hsc($_SESSION['selected_student']['lname'])}"/></td>
										</tr>
									</table>

									<br>

									<h4 class="display-5">Nickname</h4>
									<table class="table table-sm">
										<caption class="text-center">To remove the nickname, <span class="caption-line">enter a single dash: " <span class="caption-chars">-</span> "</span></caption>
										<tr>
											<td>Old</td>
											<td>:</td>
											<td>{$hsc($_SESSION['selected_student']['nickname'])}</td>
										</tr>
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="nickname" placeholder="{$hsc($_SESSION['selected_student']['nickname'])}"/></td>
										</tr>
									</table>

									<br>

									<h4 class="display-5">Graduation Date</h4>
									<table class="table table-sm">
										<tr>
											<td>Old</td>
											<td>:</td>
											<td>{$hsc($_SESSION['selected_student']['grad_date'])}</td>
										</tr>
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="grad_date" placeholder="{$hsc($_SESSION['selected_student']['grad_date'])}"/></td>
										</tr>
									</table>

									<br>

									<h4 class="display-5">Date of Birth (password)</h4>
									<table class="table table-sm">
										<tr>
											<td>New</td>
											<td>:</td>
											<td><input class="form-control" name="password" type="password"/></td>
										</tr>
										<tr>
											<td>Confirm</td>
											<td>:</td>
											<td><input class="form-control" name="password_confirm" type="password"/></td>
										</tr>
									</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Modify End -->
EOT;

			require __DIR__ . "/../../tools/gen_middle_home.php";

			echo '<br><hr class="hr-wide"><br>';

			require __DIR__ . "/../../tools/gen_middle_classes.php";

			echo '<br><hr class="hr-wide"><br>';

			require __DIR__ . "/../../tools/gen_middle_courselist.php";

			echo '</div>';
		} else {
			echo '<div class="container-fluid">
			<h1 class="text-center display-3">Select Student</h1>
			<br>';

			if(isset($_SESSION['c_delete_student'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Student Deletion Summary</h3>', $_SESSION['c_delete_student'], '</div>';
				unset($_SESSION['c_delete_student']);
			}

			echo '
			<form method="post" action="counselor/c_students.php">
				<div class="datatable-container">
					<table id="datatable" class="table table-sm table-bordered table-hover text-center">
						<thead>
							<tr>
								<th>Select</th>
								<th>Student ID</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Graduation Date</th>
								<th>Nickname</th>
								<th>Last Login</th>
								<th>First Login</th>
							</tr>
						</thead>
						<tbody>';

				foreach($students as $i) {
					if($i['nickname'] === '') $i['nickname'] = Null;
					$i['last_login'] = "<span class='d-none'>" . $hsc($i['last_login']) . "</span>" . date("j M Y, g A", strtotime($hsc($i['last_login'])));
					$i['first_login'] = "<span class='d-none'>" . $hsc($i['first_login']) . "</span>" . date("j M Y, g A", strtotime($hsc($i['first_login'])));
					echo <<<EOT

							<tr>
								<td>
									<button type="submit" class="btn btn-success btn-sm" name="counselor-choose-student" value="{$hsc($i['user_id'])}"><i class="fa fa-check"></i></button>
								</td>
								<td>{$hsc($i['username'])}</td>
								<td>{$hsc($i['fname'])}</td>
								<td>{$hsc($i['lname'])}</td>
								<td>{$hsc($i['grad_date'])}</td>
								<td>{$hsc($i['nickname'])}</td>
								<td><small>{$i['last_login']}</small></td>
								<td><small>{$i['first_login']}</small></td>
							</tr>
EOT;
				}

				echo '
						</tbody>
					</table>
				</div>
			</form>
		</div>';

			} ?>

		<script src="style/jquery.js"></script>
		<?php
		if($student_selected === True) {
			echo '<script src="style/bootstrap.js"></script>';
			require __DIR__ . "/../../tools/gen_end_home.php";
			require __DIR__ . "/../../tools/gen_end_courselist.php";
			require __DIR__ . "/../../tools/gen_end_classes.php";
		} else {
			echo '<script src="style/datatables.js"></script>
		<script>
			$(document).ready(function(){
				$("#datatable").dataTable({
					"pageLength": 50,
					"lengthMenu": [ [25, 50, 100, 500, -1], [25, 50, 100, 500, "All"] ],
					"order": [[ 4, "desc" ], [3, "asc"]],
					"columnDefs": [
						{ "orderable": false, "targets": 0 },
						{ "searchable": false, "targets": [0, 6, 7] }
					]
				});
			});
		</script>', "\n"; } ?>
	</body>
</html>

