<?php
require_once("header.php");
if(!empty($_GET['id']))
{

  $sql = "SELECT `Patient_Id`, `Patient_Name`, `Patient_Age`, `Patient_Gender`, `Patient_Height`, `Patient_Weight`, `Patient_Address`, `Patient_Contact` FROM `tbl_patient_details` WHERE  Patient_Id ='$_GET[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
     
      $explode = explode('-',$value['Patient_Age']);
    }
  }
  
}
else
{
  echo "<script>window.location='display_patient.php'</script>";
}
?>
<style type="text/css">
  #display_patient{
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
            <h1>View Patient Details</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="display_patient.php">All Patient</a></li>
              <li class="breadcrumb-item active">View Patient</li>
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
                <h3 class="card-title">View Patient Details</h3>
                
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">

                  <div class="form-group col-md-3">
                    <label>Patient Name*</label>
                    <input type="text" name="name" required placeholder="Patient Name"
                    class="form-control form-control-sm" value="<?php echo $value['Patient_Name']; ?>">
                  </div>
                  <div class="form-group col-md-1">
                    <label>Year*</label>
                    <input type="text" name="year"
                    class="form-control form-control-sm" placeholder=" Year" value="<?php echo $explode[0]; ?>">
                   
                  </div>
                  <div class="form-group col-md-1">
                    <label>Month*</label>
                    <input type="text" name="month"
                    class="form-control form-control-sm" placeholder="Month" value="<?php echo $explode[1]; ?>">
                   
                  </div>
                  <div class="form-group col-md-1">
                    <label>Day*</label>
                    <input type="text" name="day"
                    class="form-control form-control-sm"  placeholder="Day" value="<?php echo $explode[2]; ?>">
                   
                  </div>
                  <div class="form-group col-md-3">
                    <label>Gender*</label>
                    <select name="gender" required  class="form-control form-control-sm">
                      <?php
                       $male ='';
                       $female ='';
                       $default .='';
                       switch ($value['Patient_Gender']) {
                          case 'Male':
                            $male .='selected';
                            break;
                          case 'Female':
                            $female .='selected';
                            break;
                          
                          default:
                            $default .= 'selected';
                            break;
                        } 
                      ?>
                      <option value="" <?php echo $default; ?>>Select</option>
                      <option value="Male" <?php echo $male; ?>>Male</option>
                      <option value="Female" <?php echo $female; ?>>Female</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Height*</label>
                    <input type="text" name="height" required placeholder="Height"
                    class="form-control form-control-sm" value="<?php echo $value['Patient_Height']; ?>">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Weight*</label>
                    <input type="text" name="weight" required placeholder="Weight"
                    class="form-control form-control-sm" value="<?php echo $value['Patient_Weight']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Address*</label>
                    <input type="text" name="address" required placeholder="Address"
                    class="form-control form-control-sm" value="<?php echo $value['Patient_Address']; ?>">
                  </div>
                  <div class="form-group col-md-3">
                    <label>Contact No*</label>
                    <input type="text" name="contact" required placeholder="Valid Contact No"
                    class="form-control form-control-sm" value="<?php echo $value['Patient_Contact']; ?>">
                  </div>
                  
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $value['Patient_Id']; ?>">
                    <input type="hidden" name="page" value="Edit_Patient">
                    <input type="hidden" name="action" value="Edit_Patient">
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