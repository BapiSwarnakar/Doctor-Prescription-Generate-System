<?php
require_once("header.php");
?>
<style type="text/css">
  #add_agent{
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
         <!--  <div class="col-sm-6">
            <h1>Add Agent</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Agent</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid col-md-8">
        <div class="row">
          <!-- left column -->
          <div class="col-md-1"></div>
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Agent</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label>Agent Name*</label>
                    <input type="text" name="name" required placeholder="Name"
                    class="form-control">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Gender*</label>
                    <select name="gender" required class="form-control">
                      <option value="">Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Date of birth*</label>
                    <input type="date" name="dob" required class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label>E-mail*</label>
                    <input type="email" name="email" placeholder="E-mail" required class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Contact No*</label>
                    <input type="text" name="mobile" placeholder="Mobile No" required class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Aadhar No*</label>
                    <input type="text" name="aadhar" placeholder="Aadhar No" required class="form-control">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Address*</label>
                    <textarea required class="form-control form-control-sm" placeholder="Address" name="address"></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Password*</label>
                    <input type="text" id="pass" class="form-control" required placeholder="Password">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Confirm Password*</label>
                    <input type="password" data-parsley-equalto="#pass" name="password" class="form-control" required placeholder="Password">
                  </div>
                  

                 
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="page" value="Add_Agent">
                    <input type="hidden" name="action" value="Add_Agent">
                    <input type="submit" id="submit" class="btn btn-primary btn-sm" value="Submit">
                  </div>
                </div>
                <!-- /.card-body -->
              
     </form>
  </div>
            <!-- /.card -->
</div>
          <!--/.col (left) -->
          <!-- right column -->
          
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
 require_once("script/admin_jquery.php");
 ?>