<?php
session_start();

if (isset($_SESSION["authenticated"])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>

		<?php include_once("../includes/pages.head.include.php"); ?>
		<title>RRS - Profile</title>
	</head>

	<body>

		<?php include_once("../includes/pages.preloader.include.php"); ?>

		<!-- ***** Header Area Start ***** -->
		<header class="header-area header-sticky">
			<?php include_once("../includes/pages.header.include.php"); ?>
		</header>
		<!-- ***** Header Area End ***** -->

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="page-content">

						<!-- ***** Banner Start ***** -->
						<div class="row">
							<div class="col-lg-12">
								<div class="main-profile ">
									<div class="row">
										<div class="col-lg-4">
											<img src="../assets/img/signin-image.png" alt="" style="border-radius: 23px;">
										</div>
										<div class="col-lg-4 align-self-center">
											<div class="main-info header-text">
												<span>Online</span>
												<h4 id="profileIdentity">Loading...</h4>
												<p id="profileRemarks">You Haven't Completed Your Account yet. Go Complete It By Clicking The Button Below.</p>
												<div class="main-border-button" id="profileActionButton">
													<a href="#" onclick="openCompleteProfileModal()">Complete Profile</a>
												</div>
											</div>
										</div>
										<div class="col-lg-4 align-self-center">
											<ul>
												<li>Profile Status <span id="status">Incomplete</span></li>
												<li>Can View <span id="eligible">No</span></li>
											</ul>
										</div>
									</div>

								</div>
							</div>
						</div>

						<!-- Modal -->
						<div class="modal fade" id="completeProfileModal" tabindex="-1" aria-labelledby="completeProfileModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="completeProfileModalLabel">Complete Profile</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form id="completeProfileForm" action="javascript:void(0)" method="post">
										<div class="modal-body">
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="student_id">Student ID.</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" id="student_id" readonly>
												</div>
											</div>
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="firstname">Firstname</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control uppercase" id="firstname" minlength="2" required>
												</div>
											</div>
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="middlename">Middlename</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control uppercase" id="middlename">
												</div>
											</div>
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="lastname">Lastname</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control uppercase" id="lastname" minlength="4" required>
												</div>
											</div>
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="address">Address</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control uppercase" id="address" minlength="4" required>
												</div>
											</div>
											<div class="row my-2">
												<div class="col-md-4 pt-1 pl-lg-4 pr-0">
													<label for="contact_no">Contact No</label>
													<label class="float-right">:</label>
												</div>
												<div class="col-md-8">
													<input type="tel" class="form-control" id="contact_no" placeholder="09xxxxxxxxx" pattern="[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}" minlength="11" required>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Save changes</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer>
			<?php include_once("../includes/pages.footer.include.php"); ?>
		</footer>

		<?php include_once("../includes/pages.scripts.include.php"); ?>

		<!-- Page level custom scripts -->
		<script src="../assets/js/profile.js"></script>
	</body>

	</html>

<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>