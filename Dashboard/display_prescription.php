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
  #display_prescription{
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
         <!--  <div class="col-sm-6">
            <h1>Display Prescription List</h1>
          </div> -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Display Prescription List</li>
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
                <h3 class="card-title">Display Prescription</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <!--  <div class="spinner-border text-primary" role="status" id="load">
                  <span class="sr-only">Loading...</span>
                </div> -->
                <form id="filter_form">
                <div  class="form-row">

                  <div class="form-group">
                    <label>From
                    <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"  value="<?php echo date("Y-m-d"); ?>"></label>
                  </div>&nbsp;
                  <div class="form-group">
                    <label>To
                    <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"  value="<?php echo date("Y-m-d"); ?>"></label>
                  </div>&nbsp;
                  <div class="form-group">
                    <label>Status
                      <select class="form-control form-control-sm" name="status" id="status">
                        <option value="All">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Success</option>
                      </select>
                    </label>
                  </div>&nbsp;
                  <div class="form-group">
                    <br/>
                    <input type="submit" name="filter" id="filter" value="Filter" class="btn btn-info btn-sm">
                    <input type="reset" name="reset" id="reset" value="Reset" class="btn btn-danger btn-sm" onclick="location.reload()">
                  </div>&nbsp;&nbsp;
                  <div class="form-group">
                    <br/>
                    <!-- <input type="button" name="excel_downlode_btn" id="excel_downlode_btn" class="btn btn-success btn-sm" value="Export for Excel"> -->
                  </div>
                    
                </div>
                </form>
                <div>
                  <input type="search" name="myInput1" id="myInput1" class="form-control form-control-sm" placeholder="Search Name or Mobile No..">
                </div>
                <br/>
               <table id="table" class="table table-sm table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><input type="checkbox" name="select_all" id="select_all"><label for="select_all">All</label></th>
                    <th>Sl. No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="data_success">
                  
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <input type="hidden" id="page" value="Display_All_Order">
 <?php
 require_once("footer.php");
 require_once("script/search_master.php");
 ?>