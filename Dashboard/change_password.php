<?php
require_once("header.php");
?>
<style type="text/css">
	#add_brand{
		background-color: white;
		color: black;
	}
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Change Password</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Change password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid col-md-6">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Forget Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="Change_password_form">
                <div class="card-body">
                  <div class="form-group">
                    <label for="Password">New Password :*</label>
                    <input type="text" name="Password" class="form-control" id="Password" placeholder="New Password" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Confirm Password :*</label>
                    <input type="text" name="C_Password" class="form-control" id="C_Password" placeholder="Confirm Password" autocomplete="off" data-parsley-equalto="#Password" required>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-center">
                  <input type="hidden" name="page" value="Forget_Password_Page">
                  <input type="hidden" name="action" value="Forget_Password_Page">
                  <input type="submit" name="submit" id="submit" class="btn btn-danger" value="Update Password">
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php
 require_once("footer.php");
 require_once("script/change_password_master.php");
 ?>
