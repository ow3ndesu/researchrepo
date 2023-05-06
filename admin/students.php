<?php
session_start();

if (isset($_SESSION["admin-auth"])) {

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include_once("includes/admin.head.include.php"); ?>
    <title>RRS Admin - Students</title>
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
        <?php include_once("includes/admin.sidebar.include.php"); ?>
      <!-- End of Sidebar -->

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
            <h1 class="h3 mb-2 text-gray-800">Students</h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                  Registered Students
                </h6>
                <button type="button" class="btn btn-primary ml-auto" id="addStudentModalBtn" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-center" id="studentstable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Student ID</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Contact No.</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="studentsTableBody">

                    </tbody>
                    <!-- <tfoot>
                      <tr>
                        <th>Student ID</th>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Contact No.</th>
                        <th>Action</th>
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
    <div class="modal fade bd-example-modal-lg" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered text-center" id="userstable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>Username</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="usersTableBody">

              </tbody>
              <!-- <tfoot>
                <tr>
                  <th>User ID</th>
                  <th>Username</th>
                  <th class="text-center">Action</th>
                </tr>
              </tfoot> -->
              <tbody></tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Exit</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="updateStudentModal" tabindex="-1" role="dialog" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateStudentModalLabel">Edit Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="updateStudentForm" action="javascript:void(0);" method="POST">
            <div class="modal-body">
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newstudent_id">Student ID.</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="newstudent_id" readonly>
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newfirstname">Firstname</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="newfirstname" minlength="2">
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newmiddlename">Middlename</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="newmiddlename" minlength="1">
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newlastname">Lastname</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="newlastname" minlength="2">
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newaddress">Address</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <textarea class="form-control" id="newaddress" minlength="8"></textarea>
                </div>
              </div>
              <div class="row my-2">
                <div class="col-md-4 pt-1 pl-lg-4 pr-0">
                  <label for="newcontact_no">Contact No</label>
                  <label class="float-right">:</label>
                </div>
                <div class="col-md-8">
                  <input type="number" class="form-control" id="newcontact_no" minlength="11">
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

    <?php include_once("includes/admin.scripts.include.php"); ?>
    
    <!-- Page level custom scripts -->
    <script src="assets/js/students.js"></script>
  </body>

  </html>


<?php } else { ?>

  <?php include_once("../pages/restricted.page.php"); ?>

<?php } ?>