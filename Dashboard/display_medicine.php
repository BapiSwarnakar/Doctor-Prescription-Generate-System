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
  #display_category{
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
            <h1>Display Medicine</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Display Medicine</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View Medicine List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="load"></div>
                
              <div class="m-3">
                <button onclick="location.href='add_medicine.php'" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>&nbsp;
                <button name="delete" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>&nbsp;
                <form action="" method="POST" id="export_form" style="display: inline-table;">
                 <button type="submit" name="export" id="export" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;Export Excel</button>
                 <input type="hidden" name="id" id="id">
                </form>
              </div>
              
               <table id="table" class="table table-sm table-bordered table-striped">
                  <thead>

                  <tr>

                    <th><input type="checkbox" name="select_all" id="select_all"><label for="select_all">All</label></th>
                    <th>Sl. No</th>
                    <th>Code</th>
                    <th>Medicine</th>
                    <th>Type</th>
                    <th>Menubar</th>
                    <th>Direction</th>
                    <th>Date</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody id="data">
                       <tr id="load">
                          <td colspan="9" class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></td>
                        </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Display Value -->
  <input type="hidden" id="display" value="Display_Medicine_All">
  <input type="hidden" id="delete_" value="Delete_Medicine_">
  <input type="hidden" id="export_brand" value="export_medicine.php">
 <?php
 require_once("footer.php");
 require_once("script/admin_jquery.php");
 ?>
