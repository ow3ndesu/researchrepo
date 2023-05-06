<?php
session_start();

if (isset($_SESSION["authenticated"])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include_once("../includes/pages.head.include.php");?>
        <title>RRS - Home</title>
    </head>

    <body>
        
        <?php include_once("../includes/pages.preloader.include.php");?>

        <!-- ***** Header Area Start ***** -->
        <header class="header-area header-sticky">
            <?php include_once("../includes/pages.header.include.php");?>
        </header>
        <!-- ***** Header Area End ***** -->

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-content">

                        <!-- ***** Banner Start ***** -->
                        <div class="main-banner">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="header-text">
                                        <h6>Welcome To Research Repo System</h6>
                                        <h4><em>Browse</em> Our Repository of Research Study Here</h4>
                                        <div class="main-button">
                                            <a href="browse.page.php">Browse Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ***** Banner End ***** -->
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <?php include_once("../includes/pages.footer.include.php");?>
        </footer>

        <?php include_once("../includes/pages.scripts.include.php");?>
        <?php 
            if ($_SESSION['isCompleted'] != 1) {
                echo '<script>
                    Swal.fire({
                        title: \'Let us take a moment and complete your profile.\',
                        text: "Please proceed to profile.",
                        icon: \'info\',
                        confirmButtonColor: \'#3085d6\',
                        confirmButtonText: \'Okay\',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = \'profile.page.php\';
                        }
                    })
                </script>';
            }
        ?>
    </body>

    </html>

<?php } else { ?>

    <?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>