<?php
require_once("header.php");
if($server->Check_Admin_Status())
{
  ?>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script type="text/javascript">
   $(document).ready(function(){
      swal("Error", "Not Access This Page !", "error");
   });
  </script>

  <?php
  exit();
}
if(!empty($_GET['id']))
{

 // $sql = "SELECT `U_Id`, `U_Name` FROM `tbl_unit` WHERE U_Id='$_GET[id]'";
    $sql="SELECT `Test_Id`, `Test_Name`, `Test_Code` FROM `tbl_test` WHERE Test_Id='$_GET[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
      # code...
    }
  }
}
else
{
  echo "<script>window.location='display_test.php'</script>";
}
?>
<style type="text/css">
  #display_test{
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
            <h1>View Test</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="display_test.php">All Test</a></li>
              <li class="breadcrumb-item active">View Test </li>
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
          <div class="col-md-1"></div>
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">View Test</h3>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                <!--  -->

                  <div class="form-group col-md-12">
                    <label>Test Name*</label>
                    <input type="text" name="name" required placeholder="Test Name"
                    class="form-control form-control-sm" value="<?php echo $value['Test_Name']; ?>">
                  </div>
                
                  <div class="form-group col-md-12">
                    <label>Code*</label>
                    <input type="text" name="code" id="code" required placeholder="Code"
                    class="form-control form-control-sm" value="<?php echo $value['Test_Code']; ?>">
                  </div>
                
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $value['Test_Id']; ?>">
                    <input type="hidden" name="page" value="Edit_Test">
                    <input type="hidden" name="action" value="Edit_Test">
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
 