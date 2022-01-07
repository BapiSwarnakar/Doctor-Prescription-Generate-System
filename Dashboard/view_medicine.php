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
  $sql = "SELECT `M_Id`, `M_Name`, `M_Code`,tbl_medicine_type.MT_Id,tbl_medicine_type.MT_Type,tbl_dosage_type.Dosage_Name,tbl_dosage_type.Dosage_Id,`M_Menu` FROM `tbl_medicine_master` INNER JOIN tbl_dosage_type ON tbl_medicine_master.Dosage_Id=tbl_dosage_type.Dosage_Id INNER JOIN tbl_medicine_type ON tbl_medicine_type.MT_Id=tbl_medicine_master.MT_Id WHERE M_Id='$_GET[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
      # code...
    }
  }
}
else
{
  echo "<script>window.location='display_medicine.php'</script>";
}
?>
<style type="text/css">
  #display_medicine{
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
            <h1>View Medicine Details</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="display_medicine.php">All Medicine</a></li>
              <li class="breadcrumb-item active">View Medicine</li>
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
                <h3 class="card-title">View Medicine</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label>Medicine Name*</label>
                    <input type="text" name="name" required placeholder="Medicine Name"
                    class="form-control form-control-sm" value="<?php echo $value['M_Name']; ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Medicine Code*</label>
                    <input type="text" name="code" id="code" required placeholder="Code" class="form-control form-control-sm" value="<?php echo $value['M_Code']; ?>">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Nature*</label>
                    <select name="nature" id="nature" required class="form-control form-control-sm">
                      <option value="">Select</option>
                      <?php echo '<option value="'.$value['MT_Id'].'" selected>'.$value['MT_Type'].'</option>'; ?>
                      <?php echo $server->All_Nature_Medicine_Type();  ?>
                      
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Direction*</label>
                    <select name="direction" id="direction" required class="form-control form-control-sm">
                      <option value="">Select</option>
                      <?php echo '<option value="'.$value['Dosage_Id'].'" selected>'.$value['Dosage_Name'].'</option>'; ?>
                      <?php echo $server->All_Dosage_Type();  ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chose Menu Bar*</label>
                    <select name="menu" id="menu" required class="form-control form-control-sm">
                      <?php 
                       $m1 = '';
                       $m2 = '';
                       $m3 = '';
                       $d = '';
                       switch ($value['M_Menu']) {
                         case 'Menu-1':
                           $m1 .='selected';
                           break;
                          case 'Menu-2':
                           $m2 .='selected';
                           break;
                          case 'Menu-3':
                           $m3 .='selected';
                           break;
                         default:
                           $d .='selected';
                           break;
                       }
                      ?>
                      <option value="" <?php echo $d;?>>Select</option>
                      <option value="Menu-1" <?php echo $m1; ?>>Tablet</option>
                      <option value="Menu-2" <?php echo $m2; ?>>Liquid</option>
                      <option value="Menu-3" <?php echo $m3; ?>>Others</option>

                    </select>
                  </div>

                
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $value['M_Id']; ?>">
                    <input type="hidden" name="page" value="Edit_Medicine">
                    <input type="hidden" name="action" value="Edit_Medicine">
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