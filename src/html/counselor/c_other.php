<?php

/*

Allow counselor to change graudation credits, elective credits, years, and credits per year

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../tools/session_credit_reqs.php";
session_credit_reqs();

require_once __DIR__ . "/../../tools/session_misc_info.php";
session_misc_info();

$key = array_search('Total', array_column($_SESSION['credit_reqs'], 'area'));
$credits_total = $_SESSION['credit_reqs'][$key]['total_req'];

$key = array_search('Electives', array_column($_SESSION['credit_reqs'], 'area'));
$credits_elective = $_SESSION['credit_reqs'][$key]['total_req'];

$key = array_search('years', array_column($_SESSION['misc_info'], 'name'));
$years = $_SESSION['misc_info'][$key]['value'];

$key = array_search('credits_per_year', array_column($_SESSION['misc_info'], 'name'));
$credits_per_year = $_SESSION['misc_info'][$key]['value'];

unset($key);

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
		<link href="style/font-awesome/css/font-awesome.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
			<a class="navbar-brand" href="counselor/c_home.php" rel="noopener noreferrer">
				<img src="favicon.ico" width="30" height="30" class="d-inline-block align-top">
				Course Tracker
			</a>
			<div class="btn-group" role="group">
				<a href="counselor/c_home.php" rel="noopener noreferrer" class="btn btn-outline-warning">Home</a>
			</div>
		</nav>

		<div class="container">

			<?php

			if(isset($_SESSION['c_modify_grad_creds'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Graduation Credits Change Summary</h3>', $_SESSION['c_modify_grad_creds'], '</div>';
				unset($_SESSION['c_modify_grad_creds']);
			}

			if(isset($_SESSION['c_modify_elective_creds'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Elective Credits Change Summary</h3>', $_SESSION['c_modify_elective_creds'], '</div>';
				unset($_SESSION['c_modify_elective_creds']);
			}

			if(isset($_SESSION['c_modify_years'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Year Change Summary</h3>', $_SESSION['c_modify_years'], '</div>';
				unset($_SESSION['c_modify_years']);
			}

			if(isset($_SESSION['c_modify_creds_per_year'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Credits per Year Change Summary</h3>', $_SESSION['c_modify_creds_per_year'], '</div>';
				unset($_SESSION['c_modify_creds_per_year']);
			}

			?>


			<h1 class="text-center display-4">Other</h1>

			<p class="lead text-center warning">Warning: Changes made on this page will affect ALL students on this site.</p>

			<div class="row justify-content-center">
				<div class="col-md-8">
					<table class="table table-bordered table-hover">
						<tbody>
							<tr>
								<td>
									<p class="lead">Graduation Credits</p>
									<p>Edit the <b>total</b> number of credits required to graduate.</p>
								</td>
								<td>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalgraduationcredits"><i class="fa fa-pencil"></i> Edit</button>
								</td>
							</tr>
							<tr>
								<td>
									<p class="lead">Elective Credits</p>
									<p>Edit the number of <b>elective</b> credits required to graduate.</p>
								</td>
								<td>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalelectivecredits"><i class="fa fa-pencil"></i> Edit</button>
								</td>
							</tr>
							<tr>
								<td>
									<p class="lead">Years</p>
									<p>Edit the number of years used when choosing classes.</p>
								</td>
								<td>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalyears"><i class="fa fa-pencil"></i> Edit</button>
								</td>
							</tr>
							<tr>
								<td>
									<p class="lead">Credits Per Year</p>
									<p>Edit the number of credits required per year.</p>
								</td>
								<td>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalcreditsperyear"><i class="fa fa-pencil"></i> Edit</button>
								</td>
							</tr>
						</tbody>
					</table>

					<!--Modal Graduation Credits -->
					<div class="modal fade" id="modalgraduationcredits" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form method="post" action="transit_to/to_c_modify_grad_creds.php">
									<div class="modal-header">
										<h1 class="modal-title display-5">Graduation Credits</h1>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body modal-compare">
										<p class="text-center">Edit the <b>total</b> number of credits required to graduate.</p>

										<table class="table table-sm">
											<tr>
												<td>Previous Value</td>
												<td>:</td>
												<td><?php echo $hsc($credits_total); ?></td>
											</tr>
											<tr>
												<td>New Value</td>
												<td>:</td>
												<td><input class="form-control" name="credits" type="number" min="1" placeholder="<?php echo $hsc($credits_total); ?>"></td>
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

					<!--Modal Elective Credits -->
					<div class="modal fade" id="modalelectivecredits" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form method="post" action="transit_to/to_c_modify_elective_creds.php">
									<div class="modal-header">
										<h1 class="modal-title display-5">Elective Credits</h1>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body modal-compare">
										<p class="text-center">Edit the number of <b>elective</b> credits required to graduate.</p>

										<table class="table table-sm">
											<tr>
												<td>Previous Value</td>
												<td>:</td>
												<td><?php echo $hsc($credits_elective); ?></td>
											</tr>
											<tr>
												<td>New Value</td>
												<td>:</td>
												<td><input class="form-control" name="credits" type="number" min="1" placeholder="<?php echo $hsc($credits_elective); ?>"></td>
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

					<!--Modal Years -->
					<div class="modal fade" id="modalyears" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form method="post" action="transit_to/to_c_modify_years.php">
									<div class="modal-header">
										<h1 class="modal-title display-5">Years</h1>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body modal-compare">
										<p class="text-center">Edit the number of years used when choosing classes (minimum of 4 years).</p>

										<table class="table table-sm">
											<tr>
												<td>Previous Value</td>
												<td>:</td>
												<td><?php echo $hsc($years); ?></td>
											</tr>
											<tr>
												<td>New Value</td>
												<td>:</td>
												<td><input class="form-control" name="years" type="number" min="4" placeholder="<?php echo $hsc($years); ?>"></td>
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

					<!--Modal Credits Per Year -->
					<div class="modal fade" id="modalcreditsperyear" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form method="post" action="transit_to/to_c_modify_creds_per_year.php">
									<div class="modal-header">
										<h1 class="modal-title display-5">Credits Per Year</h1>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<div class="modal-body modal-compare">
										<p class="text-center">Edit the number of credits required per year.</p>

										<table class="table table-sm">
											<tr>
												<td>Previous Value</td>
												<td>:</td>
												<td><?php echo $hsc($credits_per_year); ?></td>
											</tr>
											<tr>
												<td>New Value</td>
												<td>:</td>
												<td><input class="form-control" name="credits" type="number" min="1" placeholder="<?php echo $hsc($credits_per_year); ?>"></td>
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
					<br>
				</div>
			</div>
		</div>

		<script src="style/jquery.js"></script>
		<script src="style/bootstrap.js"></script>
	</body>
</html>

