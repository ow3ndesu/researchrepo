<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<?php include_once("includes/admin.head.include.php"); ?>
		<title>RRS Admin - Researches</title>
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
						<h1 class="h3 mb-2 text-gray-800">Researches</h1>

						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3 d-flex">
								<h6 class="m-0 font-weight-bold text-primary">
									Available Researches
								</h6>
								<button type="button" class="btn btn-primary ml-auto" id="addResearchModalBtn" data-bs-toggle="modal" data-bs-target="#addResearchModal">Add Research</button>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered text-center" id="researchestable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>Research ID</th>
												<th>Title</th>
												<th>Author</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="researchesTableBody">

										</tbody>
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
		<div class="modal fade" id="addResearchModal" tabindex="-1" role="dialog" aria-labelledby="addResearchModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addResearchModalLabel">Add Research</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="addResearchForm" action="javascript:void(0);" method="POST">
						<div class="modal-body">
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="image">Image</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="file" class="form-control" id="image" accept="image/*" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="copy">Soft Copy</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="file" class="form-control" id="copy" accept="application/pdf" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="research_id">Research ID.</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="research_id" value="Automatically Assigned" disabled>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="title">Title</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="title" minlength="2" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="author">Author</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="author" minlength="4" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="description">Description</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<textarea class="form-control" id="description" minlength="8" required></textarea>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="status">Status</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<!-- <input type="text" class="form-control" id="status"> -->
									<select class="form-control" name="status" id="status" required>
										<option value="ACTIVE">Active</option>
										<option value="INACTIVE">Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Add Research</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="updateResearchModal" tabindex="-1" role="dialog" aria-labelledby="updateResearchModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="updateResearchModalLabel">Edit Research</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="updateResearchForm" action="javascript:void(0);" method="POST">
						<div class="modal-body">
							<div class="row my-2">
								<div class="col-md-12 text-center" id="research_image">
									<img src="../assets/uploaded/images/RESEARCH000NMXZ37-kjbsakjbdkabv.jpg" width="relative" height="100px" alt="research">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-12 text-center" id="viewSoftCopyViewer">
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newresearch_id">Research ID.</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newresearch_id" readonly>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newtitle">Title</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newtitle" minlength="2" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newauthor">Author</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control" id="newauthor" minlength="4" required>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newdescription">Description</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<textarea class="form-control" id="newdescription" minlength="8" required></textarea>
								</div>
							</div>
							<div class="row my-2">
								<div class="col-md-4 pt-1 pl-lg-4 pr-0">
									<label for="newstatus">Status</label>
									<label class="float-right">:</label>
								</div>
								<div class="col-md-8">
									<!-- <input type="text" class="form-control" id="status"> -->
									<select class="form-control" name="status" id="newstatus" required>
										<option value="ACTIVE">Active</option>
										<option value="INACTIVE">Inactive</option>
									</select>
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

		<div class="modal fade" id="viewResearchModal" tabindex="-1" role="dialog" aria-labelledby="modalResearchTitle" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="modalResearchTitle"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<iframe frameborder="0" width="100%" height="480px"></iframe>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<?php include_once("includes/admin.scripts.include.php"); ?>
		
		<!-- Page level custom scripts -->
		<script src="assets/js/researches.js"></script>
	</body>

	</html>


<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>