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
?>
<style type="text/css">
  #add_medicine{
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
            <h1>Add Medicine Details</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Medicine</li>
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
                <h3 class="card-title">Add Medicine</h3>
                <label class="float-sm-right"><a href="display_medicine.php" class="btn btn-warning btn-sm">View Medicine</a><br></label>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label>Medicine Name*</label>
                    <input type="text" name="name" required placeholder="Medicine Name"
                    class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Medicine Code*</label>
                    <input type="text" name="code" id="code" required placeholder="Code" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Nature*</label>
                    <select name="nature" id="nature" required class="form-control form-control-sm">
                      <option value="" selected>Select</option>
                      <?php echo $server->All_Nature_Medicine_Type();  ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Direction*</label>
                    <select name="direction" id="direction" required class="form-control form-control-sm">
                      <option value="" selected>Select</option>
                      <?php echo $server->All_Dosage_Type();  ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Menu Bar*</label>
                    <select name="menu" id="menu" required class="form-control form-control-sm">
                      <option value="" selected>Select</option>
                      <option value="Menu-1">Tablet</option>
                      <option value="Menu-2">Liquid</option>
                      <option value="Menu-3">Others</option>

                    </select>
                  </div>

                 
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="page" value="Add_Medicine">
                    <input type="hidden" name="action" value="Add_Medicine">
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