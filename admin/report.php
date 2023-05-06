<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>RRS Admin - Reports</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png" />
    <link rel="manifest" href="../assets/favicon/site.webmanifest" />

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet" />

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      @media print {
        .d-print-none {
          display: none!important;
        }
      }
    </style>
  </head>

  <body id="page-top">
    <div id="wrapper">
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" data-html2canvas-ignore="true">
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
              <div class="sidebar-brand-icon rotate-n-15">
                <img src="../assets/img/logo-darker.svg" alt="" width="40" height="40" />
              </div>
              <div class="sidebar-brand-text mx-3">Library Management System</div>
            </a>
            <ul class="navbar-nav ml-auto">
              <div class="topbar-divider d-none d-sm-block"></div>
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">Reports</span>
                </a>
              </li>
            </ul>
          </nav> -->
          <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
              <h1 class="h3 mb-0 text-gray-800">Summaries</h1>
              <a onclick="window.print();" class="d-print-none d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-html2canvas-ignore="true"><i class="fas fa-download fa-sm text-white-50"></i> Print Report</a>
            </div>

            <div class="row">
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                          Books
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="books">
                          
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
                          Borrowed
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="borrowed">
                          
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-book-bookmark fa-2x text-gray-300"></i>
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
                          Returned
                        </div>
                        <div class="row no-gutters align-items-center">
                          <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="returned">
                              
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
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
                          Students
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="students">
                          
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="html2pdf__page-break"></div> -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 beforeClass">
              <h1 class="h3 mb-0 text-gray-800">Books</h1>
            </div>

            <div class="row">
              <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex">
                    <h6 class="m-0 font-weight-bold text-primary">
                      List of Books
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center" id="bookstable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <!-- <th>Book ID</th> -->
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody id="booksTableBody">

                        </tbody>
                        <tfoot>
                          <tr>
                            <!-- <th>Book ID</th> -->
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Status</th>
                          </tr>
                        </tfoot>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="html2pdf__page-break"></div> -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 beforeClass">
              <h1 class="h3 mb-0 text-gray-800">Borrowed</h1>
            </div>

            <div class="row">
              <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex">
                    <h6 class="m-0 font-weight-bold text-primary">
                      Borrowed Books
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center" id="borrowalstable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <!-- <th>Borrow ID</th> -->
                            <th>Book</th>
                            <th>Student</th>
                            <th>Filed</th>
                            <th>Due</th>
                          </tr>
                        </thead>
                        <tbody id="borrowalsTableBody">

                        </tbody>
                        <tfoot>
                          <tr>
                            <!-- <th>Borrow ID</th> -->
                            <th>Book</th>
                            <th>Student</th>
                            <th>Filed</th>
                            <th>Due</th>
                          </tr>
                        </tfoot>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="html2pdf__page-break"></div> -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 beforeClass">
              <h1 class="h3 mb-0 text-gray-800">Returned</h1>
            </div>

            <div class="row">
              <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex">
                    <h6 class="m-0 font-weight-bold text-primary">
                      Returned Books
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center" id="returnstable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <!-- <th>Borrow ID</th> -->
                            <th>Book</th>
                            <th>Student</th>
                            <th>Filed</th>
                            <th>Due</th>
                          </tr>
                        </thead>
                        <tbody id="returnsTableBody">

                        </tbody>
                        <tfoot>
                          <tr>
                            <!-- <th>Borrow ID</th> -->
                            <th>Book</th>
                            <th>Student</th>
                            <th>Filed</th>
                            <th>Due</th>
                          </tr>
                        </tfoot>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="html2pdf__page-break"></div> -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2 beforeClass">
              <h1 class="h3 mb-0 text-gray-800">Students</h1>
            </div>

            <div class="row">
              <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow mb-4">
                  <div class="card-header py-3 d-flex">
                    <h6 class="m-0 font-weight-bold text-primary">
                      Registered Students
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center" id="studentstable" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <!-- <th>Student ID</th> -->
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
                            <th>Contact No.</th>
                          </tr>
                        </thead>
                        <tbody id="studentsTableBody">

                        </tbody>
                        <tfoot>
                          <tr>
                            <!-- <th>Student ID</th> -->
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
                            <th>Contact No.</th>
                          </tr>
                        </tfoot>
                        <tbody></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- All custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/auth.js"></script>
    <script src="assets/js/profile.js"></script>
    <script src="assets/js/report.js"></script>
  </body>

  </html>

<?php } else { ?>

  <?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>