
<?php 
	$obj = explode('/', $_SERVER['REQUEST_URI']);
	$end = end($obj);
?>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="main-nav">
                            <!-- ***** Logo Start ***** -->
                            <a href="home.page.php" class="logo">
                                <img src="../assets/img/logo.svg" alt="" ></img>
                            </a>
                            <!-- ***** Logo End ***** -->
                            <!-- ***** Search End ***** -->
                             
                            <!-- ***** Search End ***** -->
                            <!-- ***** Menu Start ***** -->
                            <ul class="nav">
                                <li><a href="home.page.php" class="<?php (($end == 'home.page.php') ? print('active') : null); ?>">Home</a></li>
                                <li><a href="browse.page.php" class="<?php (($end == 'browse.page.php') ? print('active') : null); ?>">Browse</a></li>
                                <li><a href="#" id="logoutbtn">Logout</a></li>
                                <li><a href="profile.page.php" class="<?php (($end == 'profile.page.php') ? print('active') : null); ?>">Profile <img src="../assets/images/profile-header.jpg" alt=""></a></li>
                            </ul>
                            <a class='menu-trigger'>
                                <span>Menu</span>
                            </a>
                            <!-- ***** Menu End ***** -->
                        </nav>
                    </div>
                </div>
            </div>
        