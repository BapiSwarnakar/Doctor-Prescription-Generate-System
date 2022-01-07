<?php
require_once("header.php");
?>
<style type="text/css">
  #display_stock{
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
            <h1>Stock Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Stock Details</li>
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
                <h3 class="card-title">View Stock Details List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="load"></div>
                
              <div class="m-3">
                <!-- <button onclick="location.href='add_unit.php'" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>&nbsp;
                <button name="delete" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>&nbsp; -->
                <form action="" method="POST" id="export_form" style="display: inline-table;">
                 <button type="submit" name="export" id="export" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;Export Excel</button>
                 <input type="hidden" name="id" id="id">
                </form>
              </div>
              
               <table id="table" class="table table-bordered table-striped">
                  <thead>

                  <tr>

                    <th><input type="checkbox" name="select_all" id="select_all"><label for="select_all">All</label></th>
                    <th>Sl. No</th>
                    <th>Medicine</th>
                    <th>BatchNo</th>
                    <th>HSN Code</th>
                    <th>Purchase Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Date</th>
                    <th>Action</th>

                  </tr>
                  </thead>
                  <tbody id="data">
                  
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
  <input type="hidden" id="display" value="Display_Stock_All">
  <input type="hidden" id="delete_" value="Delete_Stock_">
  <input type="hidden" id="export_brand" value="export_stock.php">
 <?php
 require_once("footer.php");
 require_once("script/admin_jquery.php");
 ?>
