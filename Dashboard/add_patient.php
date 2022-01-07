<?php
require_once("header.php");
?>
<style type="text/css">
	#add_patient{
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
            <h1>Add Patient Details</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Patient</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid col-md-10">
        <div class="row">
          <!-- left column -->
          <div class="col-md-1"></div>
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Patient Details</h3>
                <label class="float-sm-right"><a href="display_patient.php" class="btn btn-warning btn-sm">View Patient</a></label>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">

                  <div class="form-group col-md-3">
                    <label>Patient Name*</label>
                    <input type="text" name="name" required placeholder="Patient Name"
                    class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-1">
                    <label>Year*</label>
                    <input type="text" name="year"
                    class="form-control form-control-sm"  placeholder="Year">
                   
                  </div>
                  <div class="form-group col-md-1">
                    <label>Month*</label>
                    <input type="text" name="month"
                    class="form-control form-control-sm"  placeholder="Month">
                   
                  </div>
                  <div class="form-group col-md-1">
                    <label>Day*</label>
                    <input type="text" name="day"
                    class="form-control form-control-sm"  placeholder="Day">
                   
                  </div>

                  <div class="form-group col-md-3">
                    <label>Gender*</label>
                    <select name="gender"  class="form-control form-control-sm">
                      <option value="" selected>Select</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Height*</label>
                    <input type="text" name="height" placeholder="Height"
                    class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Weight*</label>
                    <input type="text" name="weight" placeholder="Weight"
                    class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Address*</label>
                    <input type="text" name="address" placeholder="Address"
                    class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Contact No*</label>
                    <input type="text" name="contact" required placeholder="Valid Contact No"
                    class="form-control form-control-sm">
                  </div>
                  
                  

                 
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="page" value="Add_Patient">
                    <input type="hidden" name="action" value="Add_Patient">
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