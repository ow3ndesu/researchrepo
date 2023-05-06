<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include_once("includes/admin.head.include.php"); ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<title>RRS Admin - Users</title>
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
						<h1 class="h3 mb-2 text-gray-800">Users</h1>

						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">
									Registered Users
								</h6>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered text-center" id="userstable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>User ID</th>
												<th>Username</th>
												<th>Type</th>
												<th>Status</th>
												<th>Created at</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="usersTableBody">

										</tbody>
										<!-- <tfoot>
                      <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th class="text-center">Action</th>
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

		<!-- Modal -->
		<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row my-2">
							<div class="col-md-12 text-center" id="proof">
							</div>
						</div>
						<div class="row my-2">
							<div class="col-md-4 pt-1 pl-lg-4 pr-0">
								<label for="user_id">User ID.</label>
								<label class="float-right">:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" id="user_id" disabled>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-md-4 pt-1 pl-lg-4 pr-0">
								<label for="email">Username</label>
								<label class="float-right">:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" id="email" disabled>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-md-4 pt-1 pl-lg-4 pr-0">
								<label for="user_type">User Type</label>
								<label class="float-right">:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" id="user_type" disabled>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-md-4 pt-1 pl-lg-4 pr-0">
								<label for="status">Status</label>
								<label class="float-right">:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" id="status" disabled>
							</div>
						</div>
						<div class="row my-2">
							<div class="col-md-4 pt-1 pl-lg-4 pr-0">
								<label for="created_at">Created at</label>
								<label class="float-right">:</label>
							</div>
							<div class="col-md-8">
								<input type="text" class="form-control" id="created_at" disabled>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary mr-auto" id="enablebtn">Enable User</button>
						<button type="button" class="btn btn-secondary" id="disablebtn">Disable User</button>
					</div>
				</div>
			</div>
		</div>

		<?php include_once("includes/admin.scripts.include.php"); ?>

		<!-- Page level custom scripts -->
		<script src="assets/js/users.js"></script>
	</body>

	</html>


<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>