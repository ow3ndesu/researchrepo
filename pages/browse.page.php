<?php
include_once("../database/connection.php");
// session_start();

if (isset($_SESSION["authenticated"])) {

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>

    <?php include_once("../includes/pages.head.include.php");?>
    <title>RRS - Browse</title>
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

            <!-- ***** Featured Books Start ***** -->
            <div class="row">
              <div class="col-lg-12">
                <div class="featured-games header-text">
                  <div class="heading-section">
                    <h4><em>Featured</em> Books</h4>
                  </div>
                  <div class="owl-features owl-carousel" id="featured">
                    <?php
                      $database = new Database();
                      $stmt = $database->conn->prepare("SELECT * FROM books ORDER BY quantity DESC LIMIT 4");
                      $stmt->execute();
                      $result = $stmt->get_result();
                      $stmt->close();

                      while ($row = $result->fetch_assoc()) {
                        $books[] = $row;
                      }

                      foreach ($books as $key => $value) {
                        ?>
                          <div class="item">
                            <div class="thumb">
                              <?php echo '<img src="../assets/uploaded/images/' . (($value['image'] != "") ? $value['image'] : 'no-image.svg') . '"  alt="">' ?>
                              <div class="hover-effect">
                                <h6><?php echo $value['description'] ?></h6>
                              </div>
                            </div>
                            <h4><?php echo $value['title'] ?><br><span><?php echo $value['author'] ?></span></h4>
                            <ul>
                              <li class="text-danger"><i class="fa fa-book text-danger"></i> <?php echo $value['quantity'] ?></li>
                              <li class="text-primary"><i class="fa fa-calendar"></i> <?php echo $value['inserted_at'] ?></li>
                            </ul>
                          </div>
                        <?php
                      }
                    ?>
                    <!-- <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-01.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>CS-GO<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div>
                    <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-02.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>Gamezer<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div>
                    <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-03.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>Island Rusty<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div>
                    <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-01.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>CS-GO<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div>
                    <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-02.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>Gamezer<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div>
                    <div class="item">
                      <div class="thumb">
                        <img src="../assets/images/featured-03.jpg" alt="">
                        <div class="hover-effect">
                          <h6>2.4K Streaming</h6>
                        </div>
                      </div>
                      <h4>Island Rusty<br><span>249K Downloads</span></h4>
                      <ul>
                        <li><i class="fa fa-star"></i> 4.8</li>
                        <li><i class="fa fa-download"></i> 2.3M</li>
                      </ul>
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- <div class="col-lg-4">
                <div class="top-downloaded">
                  <div class="heading-section">
                    <h4><em>Top</em> Borrowed</h4>
                  </div>
                  <ul>
                    <li>
                      <img src="../assets/images/game-01.jpg" alt="" class="templatemo-item">
                      <h4>Fortnite</h4>
                      <h6>Sandbox</h6>
                      <span><i class="fa fa-star" style="color: yellow;"></i> 4.9</span>
                      <span><i class="fa fa-download" style="color: #ec6090;"></i> 2.2M</span>
                      <div class="download">
                        <a href="#"><i class="fa fa-download"></i></a>
                      </div>
                    </li>
                    <li>
                      <img src="../assets/images/game-02.jpg" alt="" class="templatemo-item">
                      <h4>CS-GO</h4>
                      <h6>Legendary</h6>
                      <span><i class="fa fa-star" style="color: yellow;"></i> 4.9</span>
                      <span><i class="fa fa-download" style="color: #ec6090;"></i> 2.2M</span>
                      <div class="download">
                        <a href="#"><i class="fa fa-download"></i></a>
                      </div>
                    </li>
                    <li>
                      <img src="../assets/images/game-03.jpg" alt="" class="templatemo-item">
                      <h4>PugG</h4>
                      <h6>Battle Royale</h6>
                      <span><i class="fa fa-star" style="color: yellow;"></i> 4.9</span>
                      <span><i class="fa fa-download" style="color: #ec6090;"></i> 2.2M</span>
                      <div class="download">
                        <a href="#"><i class="fa fa-download"></i></a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div> -->
            </div>
            <!-- ***** Featured Books End ***** -->

            <!-- ***** All Books Start ***** -->
            <div class="live-stream">
              <div class="col-lg-12">
                <div class="heading-section">
                  <h4><em>All</em> Books</h4>
                </div>
              </div>
              <div class="row" id="allbooks">
                <div class="col-lg-3 col-sm-6 text-center">
                  Nothing to show in here!
                </div>
                <!-- <div class="col-lg-3 col-sm-6">
                  <div class="item">
                    <div class="thumb">
                      <img src="../assets/images/stream-01.jpg" alt="">
                      <div class="hover-effect">
                        <div class="content">
                          <div class="live">
                            <a href="#">Live</a>
                          </div>
                          <ul>
                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                            <li><a href="#"><i class="fa fa-gamepad"></i> CS-GO</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="down-content">
                      <div class="avatar">
                        <img src="../assets/images/avatar-01.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                      </div>
                      <span><i class="fa fa-check"></i> KenganC</span>
                      <h4>Just Talking With Fans</h4>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                  <div class="item">
                    <div class="thumb">
                      <img src="../assets/images/stream-02.jpg" alt="">
                      <div class="hover-effect">
                        <div class="content">
                          <div class="live">
                            <a href="#">Live</a>
                          </div>
                          <ul>
                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                            <li><a href="#"><i class="fa fa-gamepad"></i> CS-GO</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="down-content">
                      <div class="avatar">
                        <img src="../assets/images/avatar-02.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                      </div>
                      <span><i class="fa fa-check"></i> LunaMa</span>
                      <h4>CS-GO 36 Hours Live Stream</h4>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                  <div class="item">
                    <div class="thumb">
                      <img src="../assets/images/stream-03.jpg" alt="">
                      <div class="hover-effect">
                        <div class="content">
                          <div class="live">
                            <a href="#">Live</a>
                          </div>
                          <ul>
                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                            <li><a href="#"><i class="fa fa-gamepad"></i> CS-GO</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="down-content">
                      <div class="avatar">
                        <img src="../assets/images/avatar-03.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                      </div>
                      <span><i class="fa fa-check"></i> Areluwa</span>
                      <h4>Maybe Nathej Allnight Chillin'</h4>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                  <div class="item">
                    <div class="thumb">
                      <img src="../assets/images/stream-04.jpg" alt="">
                      <div class="hover-effect">
                        <div class="content">
                          <div class="live">
                            <a href="#">Live</a>
                          </div>
                          <ul>
                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                            <li><a href="#"><i class="fa fa-gamepad"></i> CS-GO</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="down-content">
                      <div class="avatar">
                        <img src="../assets/images/avatar-04.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                      </div>
                      <span><i class="fa fa-check"></i> GangTm</span>
                      <h4>Live Streaming Till Morning</h4>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                  <div class="item">
                    <div class="thumb">
                      <img src="../assets/images/stream-04.jpg" alt="">
                      <div class="hover-effect">
                        <div class="content">
                          <div class="live">
                            <a href="#">Live</a>
                          </div>
                          <ul>
                            <li><a href="#"><i class="fa fa-eye"></i> 1.2K</a></li>
                            <li><a href="#"><i class="fa fa-gamepad"></i> CS-GO</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="down-content">
                      <div class="avatar">
                        <img src="../assets/images/avatar-04.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                      </div>
                      <span><i class="fa fa-check"></i> GangTm</span>
                      <h4>Live Streaming Till Morning</h4>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
            <!-- ***** All Books End ***** -->

          </div>
        </div>
      </div>
    </div>

    <footer>
            <?php include_once("../includes/pages.footer.include.php");?>
        </footer>

        <?php include_once("../includes/pages.scripts.include.php");?>

    <!-- Page level custom scripts -->
    <script src="../assets/js/browse.js"></script>

  </body>

  </html>

<?php } else { ?>

  <?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>