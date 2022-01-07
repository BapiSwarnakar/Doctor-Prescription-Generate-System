<?php
require_once("header.php");
if($_GET['id'] !="")
{
  $sql = "SELECT `Agent_Id`,`Agent_Name`, `Agent_Gender`, `Agent_Dob`, `Agent_Email`, `Agent_Contact`, `Agent_Aadhar`, `Agent_Address`,`Agent_Password` FROM `tbl_agent` WHERE Agent_Id='$_GET[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
      # code...
    }
  }
  else
  {
    echo "<script>window.location='display_agent.php'</script>";
  }
}
else
{
  echo "<script>window.location='display_agent.php'</script>";
}
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
          <!-- <div class="col-sm-6">
            <h1>View Agent</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="display_agent.php">Display Agent</a></li>
              <li class="breadcrumb-item active">View Agent</li>
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
                <h3 class="card-title">View Agent</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label>Agent Name*</label>
                    <input type="text" name="name" required placeholder="Name"
                    class="form-control" value="<?php echo $value['Agent_Name'] ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Gender*</label>
                    <select name="gender" required class="form-control">
                      <option value="">Select</option>
                      <?php
                       if ($value['Agent_Gender'] !='Female' && $value['User_Gender'] !='Other') {
                          ?>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                          <?php
                        } 
                       elseif ($value['User_Gender'] !='Male' && $value['User_Gender'] !='Other') {
                         ?>
                          <option value="Male">Male</option>
                          <option value="Female" selected>Female</option>
                          <option value="Other">Other</option>
                         <?php
                       }
                       else
                       {
                         ?>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Other" selected>Other</option>
                         <?php
                       }
                      ?>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Date of birth*</label>
                    <input type="date" name="dob" required class="form-control" value="<?php echo $value['Agent_Dob']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>E-mail*</label>
                    <input type="email" name="email" placeholder="E-mail" required class="form-control" value="<?php echo $value['Agent_Email']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Contact No*</label>
                    <input type="text" name="mobile" placeholder="Mobile No" required class="form-control" value="<?php echo $value['Agent_Contact']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Aadhar No*</label>
                    <input type="text" name="aadhar" placeholder="Aadhar No" required class="form-control" value="<?php echo $value['Agent_Aadhar']; ?>">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Address*</label>
                    <textarea required class="form-control form-control-sm" placeholder="Address" name="address"><?php echo $value['Agent_Address']; ?></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Password*</label>
                    <input type="password" id="pass" class="form-control" required placeholder="Password" readonly value="<?php echo $value['Agent_Password']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Confirm Password*</label>
                    <input type="password" data-parsley-equalto="#pass" name="password" class="form-control" required placeholder="Password" readonly value="<?php echo $value['Agent_Password']; ?>">
                  </div>
                  

                 
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $value['Agent_Id']; ?>">
                    <input type="hidden" name="page" value="Edit_Agent">
                    <input type="hidden" name="action" value="Edit_Agent">
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