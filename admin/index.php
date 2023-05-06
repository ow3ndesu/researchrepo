<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include_once("includes/admin.head.include.php"); ?>
		<title>RRS Admin - Dashboard</title>
		<style>
			.notification.card-body {
				padding: 0.5rem;
			}
		</style>
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
						<div class="d-sm-flex align-items-center justify-content-between mb-4">
							<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
							<!-- <a href="report.php" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate
								Report</a> -->
						</div>

						<!-- Content Row -->
						<div class="row">
							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-primary shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
													Researches
												</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800" id="researches">

												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-book fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-success shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
													Faculties
												</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800" id="faculties">

												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-user-tie fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-info shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-info text-uppercase mb-1">
													Students
												</div>
												<div class="row no-gutters align-items-center">
													<div class="col-auto">
														<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="students">

														</div>
													</div>
												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-users-line fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-3 col-md-6 mb-4">
								<div class="card border-left-warning shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
													Users
												</div>
												<div class="h5 mb-0 font-weight-bold text-gray-800" id="users">

												</div>
											</div>
											<div class="col-auto">
												<i class="fas fa-users fa-2x text-gray-300"></i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="d-sm-flex align-items-center justify-content-between mb-2">
							<h3 class="h5 mb-0 text-gray-800">Notifications</h3>
						</div>

						<div id="notifications">
							<!-- <div class="row">
                <div class="col mb-4">
                  <div class="card border-left-warning shadow h-100">
                    <div class="notification card-body">
                      <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                          <div class="text-xs font-weight-bold text-warning text-uppercase">
                            Students
                          </div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-bell text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
						</div>
						<audio id="audioNotification">
							<source src="assets/audio/ding-36029.mp3" type="audio/mpeg">
							<!-- Your browser does not support the audio element. -->
						</audio>

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

		<?php include_once("includes/admin.scripts.include.php"); ?>

		<script src="assets/js/profile.js"></script>
		<script src="assets/js/index.js"></script>
	</body>

	</html>

<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>