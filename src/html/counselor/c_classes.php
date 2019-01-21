<?php

/*

Allow counselor to create new classes, edit classes, archive and unarchive classes, and delete classes

*/

session_start();

require_once __DIR__ . "/../../tools/kill.php";

if(!isset($_SESSION['login']) || !isset($_SESSION['counselor']) || $_SESSION['login'] !== True || $_SESSION['counselor'] !== True) {
	kill("Error: Credentials not sent.");
	die();
}

require_once __DIR__ . "/../../tools/session_classes.php";
session_classes();

require_once __DIR__ . "/../../tools/session_c_enum_areas.php";
session_c_enum_areas();

$classes = $_SESSION['classes'];
$archived_classes = $_SESSION['classes_archived'];

$enum_areas = $_SESSION['enum_areas'];

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
		<link href="style/datatables.css" rel="stylesheet">
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

		<div class="container-fluid">
			<?php

			if(isset($_SESSION['c_modify_class'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Class Changes Summary</h3>', $_SESSION['c_modify_class'], '</div>';
				unset($_SESSION['c_modify_class']);
			}

			if(isset($_SESSION['c_new_class'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>New Classes Summary</h3>', $_SESSION['c_new_class'], '</div>';
				unset($_SESSION['c_new_class']);
			}

			if(isset($_SESSION['c_archive_class'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Class Changes Summary</h3>', $_SESSION['c_archive_class'], '</div>';
				unset($_SESSION['c_archive_class']);
			}

			if(isset($_SESSION['c_unarchive_class'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Class Changes Summary</h3>', $_SESSION['c_unarchive_class'], '</div>';
				unset($_SESSION['c_unarchive_class']);
			}

			if(isset($_SESSION['c_delete_class'])) {
				echo '<div class="error transit-message alert alert-light" role="alert"><h3>Class Changes Summary</h3>', $_SESSION['c_delete_class'], '</div>';
				unset($_SESSION['c_delete_class']);
			}

			?>
			<h1 class="text-center display-4">Classes</h1>

			<p class="text-center">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalnew"><i class="fa fa-plus"></i> New Class</button>
			</p>

			<!-- New Class -->
			<div class="modal fade" id="modalnew" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_new_class.php">
							<div class="modal-header">
								<h1 class="modal-title display-5">New Class</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body modal-compare">
								<br>

								<table class="table table-sm">
									<caption class="text-center">Leave "Required ID" blank for no Required ID</caption>
									<tr>
										<td>Class Name</td>
										<td>:</td>
										<td><input required class="form-control" name="class_name" placeholder="AP Computer Science"/></td>
									</tr>
									<tr>
										<td>Required</td>
										<td>:</td>
										<td>
											<select required class="form-control" name="required">
												<option selected value="n">No</option>
												<option value="y">Yes</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Required ID</td>
										<td>:</td>
										<td><input class="form-control" name="required_id"/></td>
									</tr>
									<tr>
										<td>HS Credits</td>
										<td>:</td>
										<td><input class="form-control" type="number" min="0" name="hs_terms" value="1" /></td>
									</tr>
									<tr>
										<td>College Credits</td>
										<td>:</td>
										<td><input class="form-control" type="number" min="0" name="college_credits" value="0" /></td>
									</tr>
									<tr>
										<td>Core Area</td>
										<td>:</td>
										<td>
											<select required class="form-control" name="area">
										<?php
										foreach($enum_areas as $j) {
											$area_selected = ($j === "Other") ? "selected" : "";
											echo '<option ', $hsc($area_selected), ' value="', $hsc($j), '">', $hsc($j), '</option>';
										}
										?>
											</select>
										</td>
									</tr>
									<tr>
										<td>College Class</td>
										<td>:</td>
										<td>
											<select required class="form-control" name="college_class">
												<option selected value="n">No</option>
												<option value="y">Yes</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>AP Class</td>
										<td>:</td>
										<td>
											<select required class="form-control" name="ap_class">
												<option selected value="n">No</option>
												<option value="y">Yes</option>
											</select>
										</td>
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
			<!-- New Class End -->

			<div class="datatable-container">
			<table class="datatable table table-sm counselor-classes table-bordered table-hover">
				<thead>
					<tr>
						<th>Edit</th>
						<th>Class Name</th>
						<th>Required</th>
						<th>Required ID</th>
						<th>HS Credits</th>
						<th>College Credits</th>
						<th>Core Area</th>
						<th>College Class</th>
						<th>AP Class</th>
						<th>Archive</th>
					</tr>
				</thead>
				<tbody><?php
					foreach($classes as $i) {
						$i['required'] = ($i['required'] === "y") ? "Yes" : Null;

						if($i['hs_terms'] === 0) $i['hs_terms'] = Null;

						if($i['college_credits'] === 0) $i['college_credits'] = Null;

						$i['college_class'] = ($i['college_class'] === "y") ? "Yes" : Null;

						$i['ap_class'] = ($i['ap_class'] === "y") ? "Yes" : Null;

						echo <<<EOT

					<tr>
						<td><button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modaledit-{$hsc($i['class_id'])}"><i class="fa fa-pencil"></i></button></td>
						<td>{$hsc($i['class_name'])}</td>
						<td>{$hsc($i['required'])}</td>
						<td>{$hsc($i['required_id'])}</td>
						<td>{$hsc($i['hs_terms'])}</td>
						<td>{$hsc($i['college_credits'])}</td>
						<td>{$hsc($i['area'])}</td>
						<td>{$hsc($i['college_class'])}</td>
						<td>{$hsc($i['ap_class'])}</td>
						<td><button type="button" class="bnt btn-secondary btn-sm" data-toggle="modal" data-target="#modalarchive-{$hsc($i['class_id'])}"><i class="fa fa-archive"></i></button></td>
					</tr>
EOT;
					}?>
				</tbody>
			</table>
			</div>

			<?php
				foreach($classes as $i) {
					$required = ($i['required'] === "y") ? "Yes" : "No";
					$required_y = ($i['required'] === "y") ? "selected" : "";

					$college_class = ($i['college_class'] === "y") ? "Yes" : "No";
					$college_class_y = ($i['college_class'] === "y") ? "selected" : "";

					$ap_class = ($i['ap_class'] === "y") ? "Yes" : "No";
					$ap_class_y = ($i['ap_class'] === "y") ? "selected" : "";

					echo <<<EOT

			<!-- Edit -->
			<div class="modal fade" id="modaledit-{$hsc($i['class_id'])}" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_modify_class.php">
							<input required readonly="readonly" type="hidden" class="d-none" name="class_id" value="{$hsc($i['class_id'])}">
							<div class="modal-header">
								<h1 class="modal-title display-5">Edit Class</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body modal-compare">
								<p class="text-center">Leave fields blank to remain unchanged</p>

								<br>

								<h4 class="display-5">Class Name</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($i['class_name'])}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td><input class="form-control" name="class_name" placeholder="{$hsc($i['class_name'])}"/></td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">Required</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($required)}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td>
											<select class="form-control" name="required">
												<option value="n">No</option>
												<option {$hsc($required_y)} value="y">Yes</option>
											</select>
										</td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">Required ID</h4>
								<table class="table table-sm">
									<caption class="text-center">To remove the Required ID, <span class="caption-line">enter a single dash: " <span class="caption-chars">-</span> "</span></caption>
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($i['required_id'])}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td><input class="form-control" name="required_id" placeholder="{$hsc($i['required_id'])}"/></td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">HS Credits</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($i['hs_terms'])}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td><input class="form-control" type="number" min="0" name="hs_terms" placeholder="{$hsc($i['hs_terms'])}"/></td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">College Credits</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($i['college_credits'])}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td><input class="form-control" type="number" min="0" name="college_credits" placeholder="{$hsc($i['college_credits'])}"/></td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">Core Area</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($i['area'])}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td><select class="form-control" name="area">
EOT;

						foreach($enum_areas as $j) {
							$area_selected = ($j === $i["area"]) ? "selected" : "";
							echo '<option ', $hsc($area_selected), ' value="', $hsc($j), '">', $hsc($j), '</option>';
						}

						echo <<<EOT

										</select></td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">College Class</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($college_class)}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td>
											<select class="form-control" name="college_class">
												<option value="n">No</option>
												<option {$hsc($college_class_y)} value="y">Yes</option>
											</select>
										</td>
									</tr>
								</table>

								<br>

								<h4 class="display-5">AP Class</h4>
								<table class="table table-sm">
									<tr>
										<td>Old</td>
										<td>:</td>
										<td>{$hsc($ap_class)}</td>
									</tr>
									<tr>
										<td>New</td>
										<td>:</td>
										<td>
											<select class="form-control" name="ap_class">
												<option value="n">No</option>
												<option {$hsc($ap_class_y)} value="y">Yes</option>
											</select>
										</td>
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
			<!-- Edit End -->

			<!-- Modal Archive -->
			<div class="modal fade" id="modalarchive-{$hsc($i['class_id'])}" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_archive_class.php">
							<input required readonly="readonly" type="hidden" class="d-none" name="class_id" value="{$hsc($i['class_id'])}">
							<input required readonly="readonly" type="hidden" class="d-none" name="class_name" value="{$hsc($i['class_name'])}">
							<div class="modal-header">
								<h1 class="modal-title display-5">Archive Class</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body modal-compare">
								<p class="lead text-center">Are you sure you want to archive this class?</p>

								<table class="table table-sm">
									<tr>
										<td>Class Name</td>
										<td>:</td>
										<td>{$hsc($i['class_name'])}</td>
									</tr>
									<tr>
										<td>Required</td>
										<td>:</td>
										<td>{$hsc($required)}</td>
									</tr>
									<tr>
										<td>Required ID</td>
										<td>:</td>
										<td>{$hsc($i['required_id'])}</td>
									</tr>
									<tr>
										<td>High School Terms</td>
										<td>:</td>
										<td>{$hsc($i['hs_terms'])}</td>
									</tr>
									<tr>
										<td>College Credits</td>
										<td>:</td>
										<td>{$hsc($i['college_credits'])}</td>
									</tr>
									<tr>
										<td>Core Area</td>
										<td>:</td>
										<td>{$hsc($i['area'])}</td>
									</tr>
									<tr>
										<td>College Class</td>
										<td>:</td>
										<td>{$hsc($college_class)}</td>
									</tr>
									<tr>
										<td>AP Class</td>
										<td>:</td>
										<td>{$hsc($ap_class)}</td>
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
			<!-- Archive End -->
EOT;
				}
			?>
			<br>

			<hr class="hr-wide">

			<br>

			<h1 class="display-4">Archived Classes</h1>

			<div class="datatable-container">
			<table class="datatable table table-sm counselor-classes table-bordered table-hover">
				<thead>
					<tr>
						<th>Unarchive</th>
						<th>Class Name</th>
						<th>Required</th>
						<th>Required ID</th>
						<th>HS Credits</th>
						<th>College Credits</th>
						<th>Core Area</th>
						<th>College Class</th>
						<th>AP Class</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody><?php
					foreach($archived_classes as $i) {
						$i['required'] = ($i['required'] === "y") ? "Yes" : Null;

						if($i['hs_terms'] === 0) $i['hs_terms'] = Null;

						if($i['college_credits'] === 0) $i['college_credits'] = Null;

						$i['college_class'] = ($i['college_class'] === "y") ? "Yes" : Null;

						$i['ap_class'] = ($i['ap_class'] === "y") ? "Yes" : Null;

						echo <<<EOT

					<tr>
						<td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalunarchive-{$hsc($i['class_id'])}"><i class="fa fa-archive"></i></button></td>
						<td>{$hsc($i['class_name'])}</td>
						<td>{$hsc($i['required'])}</td>
						<td>{$hsc($i['required_id'])}</td>
						<td>{$hsc($i['hs_terms'])}</td>
						<td>{$hsc($i['college_credits'])}</td>
						<td>{$hsc($i['area'])}</td>
						<td>{$hsc($i['college_class'])}</td>
						<td>{$hsc($i['ap_class'])}</td>
						<td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modaldelete-{$hsc($i['class_id'])}"><i class="fa fa-trash"></i></button></td>
					</tr>
EOT;
					}?>
				</tbody>
			</table>
			</div>
			<br>
		</div>

		<!-- Modal Unarchive -->
		<?php
		foreach($archived_classes as $i) {
			$required = ($i['required'] === "y") ? "Yes" : "No";
			$college_class = ($i['college_class'] === "y") ? "Yes" : "No";
			$ap_class = ($i['ap_class'] === "y") ? "Yes" : "No";

			echo <<<EOT

		<!-- Unarchive -->
		<div class="modal fade" id="modalunarchive-{$hsc($i['class_id'])}" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_unarchive_class.php">
							<input required readonly="readonly" type="hidden" class="d-none" name="class_id" value="{$hsc($i['class_id'])}">
							<input required readonly="readonly" type="hidden" class="d-none" name="class_name" value="{$hsc($i['class_name'])}">
							<div class="modal-header">
								<h1 class="modal-title display-5">Unarchive Class</h1>
								<button type="button" class="close" data-dismiss="modal">
									<span>&times;</span>
								</button>
							</div>
							<div class="modal-body modal-compare">
								<p class="lead text-center">Are you sure you want to <u>un</u>archive this class?</p>

								<table class="table table-sm">
									<tr>
										<td>Class Name</td>
										<td>:</td>
										<td>{$hsc($i['class_name'])}</td>
									</tr>
									<tr>
										<td>Required</td>
										<td>:</td>
										<td>{$hsc($required)}</td>
									</tr>
									<tr>
										<td>Required ID</td>
										<td>:</td>
										<td>{$hsc($i['required_id'])}</td>
									</tr>
									<tr>
										<td>High School Terms</td>
										<td>:</td>
										<td>{$hsc($i['hs_terms'])}</td>
									</tr>
									<tr>
										<td>College Credits</td>
										<td>:</td>
										<td>{$hsc($i['college_credits'])}</td>
									</tr>
									<tr>
										<td>Core Area</td>
										<td>:</td>
										<td>{$hsc($i['area'])}</td>
									</tr>
									<tr>
										<td>College Class</td>
										<td>:</td>
										<td>{$hsc($college_class)}</td>
									</tr>
									<tr>
										<td>AP Class</td>
										<td>:</td>
										<td>{$hsc($ap_class)}</td>
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
			<!-- Unarchive End -->

			<!-- Delete -->
			<div class="modal fade" id="modaldelete-{$hsc($i['class_id'])}" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="transit_to/to_c_delete_class.php">
						<input required readonly="readonly" type="hidden" class="d-none" name="class_id" value="{$hsc($i['class_id'])}">
						<input required readonly="readonly" type="hidden" class="d-none" name="class_name" value="{$hsc($i['class_name'])}">
						<div class="modal-header">
							<h1 class="modal-title display-5">Delete Class</h1>
							<button type="button" class="close" data-dismiss="modal">
								<span>&times;</span>
							</button>
						</div>
						<div class="modal-body modal-compare">
							<p class="lead text-center modal-warning">Are you sure you want to delete this class?</p>

							<p class="text-center">Deleting this class will remove it for <i>every</i> student!</p>

							<table class="table table-sm">
								<tr>
									<td>Class Name</td>
									<td>:</td>
									<td>{$hsc($i['class_name'])}</td>
								</tr>
								<tr>
									<td>Required</td>
									<td>:</td>
									<td>{$hsc($required)}</td>
								</tr>
								<tr>
									<td>Required ID</td>
									<td>:</td>
									<td>{$hsc($i['required_id'])}</td>
								</tr>
								<tr>
									<td>High School Terms</td>
									<td>:</td>
									<td>{$hsc($i['hs_terms'])}</td>
								</tr>
								<tr>
									<td>College Credits</td>
									<td>:</td>
									<td>{$hsc($i['college_credits'])}</td>
								</tr>
								<tr>
									<td>Core Area</td>
									<td>:</td>
									<td>{$hsc($i['area'])}</td>
								</tr>
								<tr>
									<td>College Class</td>
									<td>:</td>
									<td>{$hsc($college_class)}</td>
								</tr>
								<tr>
									<td>AP Class</td>
									<td>:</td>
									<td>{$hsc($ap_class)}</td>
								</tr>
							</table>
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
EOT;
		}
		?>

		<script src="style/jquery.js"></script>
		<script src="style/bootstrap.js"></script>
		<script src="style/datatables.js"></script>
		<script>
			$(document).ready(function(){
				$('.datatable').dataTable({
					"pageLength": 25,
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					"order": [6, "asc"],
					"columnDefs": [
						{"orderable": false, "targets": [0, 9]}
					]
				});
			});
		</script>
	</body>
</html>

