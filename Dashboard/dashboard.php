<?php
require_once("header.php");
date_default_timezone_set("Asia/Kolkata");
$current_date = date('Y-m-d');
$date=date_create($current_date);
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <!-- Small boxes (Stat box) -->
        <div class="row">

        
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><i class="fas fa-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Patient_Id` FROM `tbl_patient_details`"); ?></h3>

                <p>Total Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="display_patient.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <?php
        if($_SESSION['Admin_Status']!="SUB")
         {
         ?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `MT_Id` FROM `tbl_medicine_type`"); ?></h3>

                <p>Total Medicine Type</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_medicine_type.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Dosage_Id`  FROM `tbl_dosage_type`"); ?></h3>

                <p>Total Dosage</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="display_dosage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `M_Id` FROM `tbl_medicine_master`"); ?></h3>

                <p>Total Medicine</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_medicine.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Digis_Id` FROM `tbl_digis`"); ?></h3>

                <p>Total Digis</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_digis.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Test_Id` FROM `tbl_test`"); ?></h3>

                <p>Total Test</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_test.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><i class="fa fa-th" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Advice_Id` FROM `tbl_advice`"); ?></h3>

                <p>Total Advice</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_advice.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><i class="fas fa-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $server->All_Client("SELECT `Patient_Id` FROM `tbl_patient_details` WHERE `Patient_Status` !='0'"); ?></h3>

                <p>Total Checking Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="display_visitor_patient.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <?php
           }
          ?>
         
          <!-- ./col -->
            
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
      </div>
      <!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="" target="blank">Personal Site</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<?php
require_once("footer.php");
?>

