<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include_once("includes/admin.head.include.php"); ?>
		<title>RRS Admin - Faculties</title>
	</head>

	<body id="page-top">
		<!-- Page Wrapper -->
		<div id="wrapper">
			<?php include_once("includes/admin.sidebar.include.php"); ?>

			<!-- Content Wrapper -->
			<div id="content-wrapper" class="d-flex flex-column">
				<!-- Main Content -->
				<div id="content">
					<!-- Topbar -->
					<?php include_once("includes/admin.topbar.include.php"); ?>
					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid">
						<!-- Page Heading -->
						<h1 class="h3 mb-2 text-gray-800">Faculties</h1>

						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3 d-flex">
								<h6 class="m-0 font-weight-bold text-primary">
									Registered Faculties
								</h6>
								<button type="button" class="btn btn-primary ml-auto" id="addFacultyModalBtn" data-bs-toggle="modal" data-bs-target="#addFacultyModal">Add Faculty</button>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered text-center" id="facultiestable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>Faculty ID</th>
												<th>Firstname</th>
												<th>Middlename</th>
												<th>Lastname</th>
												<th>Contact No.</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="facultiesTableBody">

										</tbody>
										<!-- <tfoot>
                      <tr>
                        <th>Faculty ID</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                      </tr>
                    </tfoot> -->
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</div>
				<!-- End of Main Content -->

				<!-- Footer -->
				<footer class="sticky-footer bg-white">
					<?php include_once("includes/admin.footer.include.php"); ?>
				</footer>
				<!-- End of Footer -->
			</div>
			<!-- End of Content Wrapper -->
		</div>
		<!-- End of Page Wrapper -->

		<div class="modal fade" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addFacultyModalLabel">Add Faculty</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="addFacultyForm" action="javascript:void(0);" method="POST">
						<div class="modal-body">
							<div class="row">
								<div class="col-md">
									<div class="row">
										<div class="col-md d-flex justify-content-center">
											User Account 
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="username">Username</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" id="username" minlength="5" required>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="email">Email</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="email" class="form-control" id="email" minlength="5" required>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="password">Password</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="password" class="form-control" id="password" minlength="8" required>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="confirm">Confirm</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="password" class="form-control" id="confirm" minlength="8" required>
										</div>
									</div>
									<div class="row">
										<div class="col-md d-flex justify-content-center text-danger">
											<small>Please make sure that email is correct. It will be use for recovering this account.</small>
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="row">
										<div class="col-md d-flex justify-content-center">
											Faculty Information
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="firstname">Firstname</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" id="firstname" minlength="2" required>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="middlename">Middlename</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" id="middlename" minlength="1">
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="lastname">Lastname</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" id="lastname" minlength="2" required>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="address">Address</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<textarea class="form-control" id="address" minlength="8" required></textarea>
										</div>
									</div>
									<div class="row my-2">
										<div class="col-md-4 pt-1 pl-lg-4 pr-0">
											<label for="contact_no">Contact No</label>
											<label class="float-right">:</label>
										</div>
										<div class="col-md-8">
											<input type="text" class="form-control" id="contact_no" minlength="11" required>
										</div>
									</div>
									<div class="row">
										<div class="col-md d-flex justify-content-center text-danger">
											<small>Faculty ID will be automatically generated.</small>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" id="addfacultybtn">Add Faculty</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="updateFacultyModal" tabindex="-1" role="dialog" aria-labelledby="updateFacultyModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="updateFacultyModalLabel">Edit Faculty</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="updateFacultyForm" action="javascript:void(0);" method="POST">
						<div class="modal-body">
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newfaculty_id">Faculty ID.</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newfaculty_id" readonly>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newfirstname">Firstname</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newfirstname" minlength="2">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newmiddlename">Middlename</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newmiddlename" minlength="1">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newlastname">Lastname</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newlastname" minlength="2">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newaddress">Address</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<textarea class="form-control" id="newaddress" minlength="8"></textarea>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newcontact_no">Contact No</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="number" class="form-control" id="newcontact_no" minlength="11">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="date">Date</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="date" readonly>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save Changes</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php include_once("includes/admin.scripts.include.php"); ?>


		<!-- Page level custom scripts -->
		<script src="assets/js/faculties.js"></script>
	</body>

	</html>


<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>