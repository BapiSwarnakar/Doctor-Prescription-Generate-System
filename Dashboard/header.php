<?php
require_once("../db_connect/db_connect.php");
require_once("../class/class.php");
$server= new Main_Classes;
$server->admin_session_private();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Dashboard</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css ">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Multi Step Form css -->
 <!--   <link rel="stylesheet" href="dist/css/multiform.css"> -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <!-- Select2 -->
  <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
   <!-- daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- Notepad View -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Multirecord select Plugin -->
    <link rel="stylesheet" type="text/css" href="../assets/multirecord_plug/css/datatable.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/multirecord_plug/css/datatable.checkbox.min.css">
  <!-- parsley validation -->
  <link rel="stylesheet" href="../assets/plugins/parsley-folder/parsley.css">
  <!-- Toast -->
  <link rel="stylesheet" href="../assets/plugins/Toast/toastr.min.css">
  <!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
  <style>
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}




::-webkit-scrollbar { width: 3px;}
::-webkit-scrollbar-thumb { background: #cc0033; }
::-webkit-scrollbar-track { background: #072d5a; }
.col-md-1.col-4.bg-dark { padding: 0px;}
.row-md-6.col-md-12.ov-y { padding: 0px;}
.col-md-1.col-6.bg-dark.ov-y { padding: 0px;}


.advice-txt {
    text-align: center;
    position: fixed;
    width: 100%;
    height: auto;
    display: flex;
    background-color: #cc0033 !important;
    justify-content: center;
}
label.bg-danger.col-md-1.advice-txt { padding: 1px 56px;}

</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light shadow-lg" id="topbar" style="background-color: #0B166A;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-light" id="close_sidebar" data-widget="pushmenu" href="javascript:void(0)" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link text-light">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link text-light" data-toggle="dropdown" href="#">
          <i class="fas fa-sign-out-alt"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a class="nav-link " href="logout.php" role="button" title="Logout" onclick="return confirm('You are sure Logout Profile !');"><i class="fas fa-sign-out-alt"></i>Logout</a>
        <div class="dropdown-divider"></div>
        <a class="nav-link" href="change_password.php" role="button" title="Change Password"><i class="fas fa-lock-open"></i>Change Password</a>
      </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" id="sidebar">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link" style="background-color: #36afc6;">
      <img src="../assets/img/admin_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <!-- <img src="../../assets/img/admin_logo.png" alt="AdminLTE Logo" width="100%" height="150px" class="bg-light"> -->
      
      <span class="brand-text font-weight-light">ADMIN DASHBOARD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #06198b;">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="dashboard.php" class="d-block">Admin</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!--Exit Sub Category Master -->
        
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Patient Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_patient.php" class="nav-link" id="add_patient">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Patient</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_patient.php" class="nav-link" id="display_patient">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Patient</p>
                </a>
              </li>
            </ul>
          </li>
     <?php
       if($_SESSION['Admin_Status']!="SUB")
       {
         ?>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Doctor
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="waiting_list.php" class="nav-link" id="waiting_list">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Waiting List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_visitor_patient.php" class="nav-link" id="display_visitor_patient">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Today Visitor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_old_patient.php" class="nav-link" id="display_old_patient">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Old Presciption</p>
                </a>
              </li>
                 
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Medicine Type Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_medicine_type.php" class="nav-link" id="add_medicine_type">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Medicine</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_medicine_type.php" class="nav-link" id="display_medicine_type">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Medicine</p>
                </a>
              </li>

              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Dosage Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_dosage.php" class="nav-link" id="add_dosage">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Dosage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_dosage.php" class="nav-link" id="display_dosage">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Dosage</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Medicine Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_medicine.php" class="nav-link" id="add_medicine">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                      Add Medicine
                    </p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="display_medicine.php" class="nav-link" id="display_medicine">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                      View Medicine
                    </p>
                  </a>
              </li>
              
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Digis Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_digis.php" class="nav-link" id="add_digis">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Digis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_digis.php" class="nav-link" id="display_digis">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Digis</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Test Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_test.php" class="nav-link" id="add_test">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Test</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_test.php" class="nav-link" id="display_test">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Test</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                 Advice Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="add_advice.php" class="nav-link" id="add_advice">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Advice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="display_advice.php" class="nav-link" id="display_advice">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View Advice</p>
                </a>
              </li>
              
            </ul>
          </li>

         <?php
       }
      ?>
          
          
          

          
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Payment Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="display_payment.php" class="nav-link" id="display_payment">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Report</p>
                </a>
              </li>
              
            </ul>
          </li> -->

          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Return Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="display_return.php" class="nav-link" id="display_return">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Display Return</p>
                </a>
              </li>
              

              
            </ul>
          </li> -->
          <li class="nav-item has-treeview">
          

         

       
          

          <!-- <li class="nav-header">Help</li>
          <li class="nav-item">
            <a href="help_request.php" class="nav-link" id="help_request">
              <i class="nav-icon far fa-image"></i>
              <p>
                Help Queries
              </p>
            </a>
          </li> -->
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>