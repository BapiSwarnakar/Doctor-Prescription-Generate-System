<?php
require_once("header.php");
if($_GET['id'] !="")
{
  $sql = "SELECT `User_Id`,tbl_agent.Agent_Name,`User_Name`, `User_Gender`, `User_Dob`, `User_Email`, `User_Mobile`, tbl_agent.Agent_Id, `User_Address`,`User_Password` FROM `tbl_user`INNER JOIN tbl_agent ON tbl_user.Agent_Id=tbl_agent.Agent_Id WHERE User_Id='$_GET[id]'";
  if($server->All_Record($sql))
  {
    foreach ($server->View_details as $value) {
      # code...
    }
  }
  else
  {
    echo "<script>window.location='display_user.php'</script>";
  }
}
else
{
  echo "<script>window.location='display_user.php'</script>";
}
?>
<style type="text/css">
  #display_user{
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
          <div class="col-sm-6">
            <h1>View User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="display_user.php">Display User</a></li>
              <li class="breadcrumb-item active">View User</li>
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
                <h3 class="card-title">View User/Retailer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="admin_data_form">
                <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label>Retailer Name*</label>
                    <input type="text" name="name" required placeholder="Name"
                    class="form-control" value="<?php echo $value['User_Name']; ?>">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Gender*</label>
                    <select name="gender" required class="form-control">
                      <option value="">Select</option>
                      <?php
                       if ($value['User_Gender'] !='Female' && $value['User_Gender'] !='Other') {
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
                    <input type="date" name="dob" required class="form-control" value="<?php echo $value['User_Dob']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>E-mail*</label>
                    <input type="email" name="email" placeholder="E-mail" required class="form-control" readonly value="<?php echo $value['User_Email']; ?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Contact No*</label>
                    <input type="text" name="mobile" placeholder="Mobile No" required class="form-control" value="<?php echo $value['User_Mobile'];?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Agent Name*</label>
                    <select name="agent" required class="form-control" disabled>
                      <option value="1">Select</option>
                      <option value="<?php echo $value['Agent_Id'] ?>" selected><?php echo $value['Agent_Name']; ?></option>

                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label>Address*</label>
                    <textarea required class="form-control form-control-sm" placeholder="Address" name="address"><?php echo $value['User_Address']; ?></textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Password*</label>
                    <input type="password" id="pass" class="form-control" required placeholder="Password" value="<?php echo $value['User_Password']; ?>" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Confirm Password*</label>
                    <input type="password" data-parsley-equalto="#pass" name="password" value="<?php echo $value['User_Password']; ?>" class="form-control" readonly required placeholder="Password">
                  </div>

                  

                 
                  
                </div>
              </div>
              <div class="card-footer">
                 <div class="form-group d-flex justify-content-center">
                    <input type="hidden" name="id" value="<?php echo $value['User_Id']; ?>">
                    <input type="hidden" name="page" value="Edit_User">
                    <input type="hidden" name="action" value="Edit_User">
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