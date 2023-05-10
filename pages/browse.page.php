<?php
include_once("../database/connection.php");
// session_start();

if (isset($_SESSION["authenticated"])) {

?>

	<!DOCTYPE html>
	<html lang="en">

	<head>

		<?php include_once("../includes/pages.head.include.php"); ?>
		<title>RRS - Browse</title>
		<style>
			.modal-xl {
				max-width: 95% !important;
			}

			.embed-cover {
				position: absolute;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;

				/* Just for demonstration, remove this part */
				/* opacity: 0.25;
				background-color: red; */
				width: 98%;
			}
		</style>
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

						<!-- ***** Featured Researches Start ***** -->
						<div class="row">
							<div class="col-lg-12">
								<div class="featured-games header-text">
									<div class="heading-section">
										<h4><em>Featured</em> Researches</h4>
									</div>
									<div class="owl-features owl-carousel" id="featured">
										<?php
										$database = new Database();
										$stmt = $database->conn->prepare("SELECT * FROM researches ORDER BY id DESC LIMIT 4");
										$stmt->execute();
										$result = $stmt->get_result();
										$stmt->close();

										while ($row = $result->fetch_assoc()) {
											$researches[] = $row;
										}

										foreach ($researches as $key => $value) {
										?>
											<div class="item">
												<div class="thumb">
													<?php echo '<img src="../assets/uploaded/images/' . (($value['image'] != "") ? $value['image'] : 'no-image.svg') . '"  alt="">' ?>
													<div class="hover-effect">
														<h6><?php echo substr($value['description'], 0, 15) . '...' ?></h6>
													</div>
												</div>
												<h4><?php echo substr($value['title'], 0, 15) . '...' ?><br><span><?php echo $value['author'] ?></span></h4>
												<ul>
													<!-- <li class="text-danger"><i class="fa fa-book text-danger"></i> <?php echo $value['id'] ?></li> -->
													<li class="text-primary"><i class="fa fa-calendar"></i> <?php echo $value['inserted_at'] ?></li>
												</ul>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<!-- ***** Featured Researches End ***** -->

						<!-- ***** All Researches Start ***** -->
						<div class="live-stream">
							<div class="col-lg-12">
								<div class="heading-section">
									<h4><em>All</em> Researches</h4>
								</div>
							</div>
							<div class="row" id="allresearches">
								<div class="col-lg-3 col-sm-6 text-center">
									Nothing to show in here!
								</div>
							</div>
						</div>
						<!-- ***** All Researches End ***** -->
						<div class="modal fade" id="viewResearchModal" tabindex="-1" role="dialog" aria-labelledby="modalResearchTitle" aria-hidden="true">
							<div class="modal-dialog modal-xl" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalResearchTitle"></h5>
										<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<iframe frameborder="0" width="100%" height="720px" id="viewer"></iframe>
										<div class="embed-cover"></div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
									</div>
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
		<script src="../assets/js/browse.js"></script>

	</body>

	</html>

<?php } else { ?>

	<?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>