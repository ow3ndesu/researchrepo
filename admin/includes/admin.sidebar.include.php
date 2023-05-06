<?php 
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
	$obj = explode('/', $_SERVER['REQUEST_URI']);
	$end = end($obj);
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
				<!-- Sidebar - Brand -->
				<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.PHP">
					<div class="sidebar-brand-icon rotate-n-15">
						<img src="../assets/img/logo-darker.svg" alt="" width="40" height="40" />
					</div>
					<div class="sidebar-brand-text mx-3">RRS Admin</div>
				</a>

				<!-- Divider -->
				<hr class="sidebar-divider my-0" />

				<!-- Nav Item - Dashboard -->
				<li class="nav-item <?php (($end == 'index.php') ? print('active') : null); ?>">
					<a class="nav-link" href="index.php">
						<i class="fas fa-fw fa-tachometer-alt"></i>
						<span>Dashboard</span></a>
				</li>

				<!-- Divider -->
				<hr class="sidebar-divider" />

				<!-- Heading -->
				<div class="sidebar-heading">Major</div>

				<!-- Nav Item - Borrowals -->
				<li class="nav-item <?php (($end == 'researches.php') ? print('active') : null); ?>">
					<a class="nav-link" href="researches.php">
						<i class="fas fa-fw fa-book-bookmark"></i>
						<span>Researches</span></a>
				</li>

				<!-- Nav Item - Returns -->
				<!-- <li class="nav-item <?php (($end == 'dashboard.php') ? print('active') : null); ?>">
					<a class="nav-link" href="returns.php">
						<i class="fas fa-fw fa-file-invoice"></i>
						<span>Returns</span></a>
				</li> -->

				<!-- Nav Item - Messages -->
				<!-- <li class="nav-item <?php (($end == 'dashboard.php') ? print('active') : null); ?>">
					<a class="nav-link" href="messages.php">
						<i class="fas fa-fw fa-message"></i>
						<span>Messages</span></a>
				</li> -->

				<!-- Heading -->
				<?php if ($_SESSION["user_type"] != 'FACULTY') { ?>
				<div class="sidebar-heading">Minor</div>

				<!-- Nav Item - Tables -->
				<!-- <li class="nav-item <?php (($end == 'dashboard.php') ? print('active') : null); ?>">
					<a class="nav-link" href="books.php">
						<i class="fas fa-fw fa-book"></i>
						<span>Books</span></a>
				</li> -->

				<li class="nav-item <?php (($end == 'faculties.php') ? print('active') : null); ?>">
					<a class="nav-link" href="faculties.php">
						<i class="fas fa-fw fa-graduation-cap"></i>
						<span>Faculties</span></a>
				</li>

				
				<li class="nav-item <?php (($end == 'students.php') ? print('active') : null); ?>">
					<a class="nav-link" href="students.php">
						<i class="fas fa-fw fa-graduation-cap"></i>
						<span>Students</span></a>
				</li>

				<!-- Nav Item - Users -->
				<li class="nav-item <?php (($end == 'users.php') ? print('active') : null); ?>">
					<a class="nav-link" href="users.php">
						<i class="fas fa-fw fa-user"></i>
						<span>Users</span></a>
				</li>

				<?php } ?>

				<!-- Divider -->
				<hr class="sidebar-divider d-none d-md-block" />

				<!-- Sidebar Toggler (Sidebar) -->
				<div class="text-center d-none d-md-inline">
					<button class="rounded-circle border-0" id="sidebarToggle"></button>
				</div>
			</ul>
			<!-- End of Sidebar -->