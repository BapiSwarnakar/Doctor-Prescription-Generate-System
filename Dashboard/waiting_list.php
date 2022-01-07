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
  #waiting_list{
    background-color: white;
    color: black;
  }
</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Display Visitor Patient List</h1>
          </div>
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Display Waiting List</li>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> Display Waiting List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body card-responsive">
               <!--  <div class="spinner-border text-primary" role="status" id="load">
                  <span class="sr-only">Loading...</span>
                </div> -->
                <form id="filter_form" method="GET" style="display: none;">
                <div  class="form-row">

                  <div class="form-group">
                    <label>From
                    <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"  value="<?php if(isset($_GET['from_date']) || empty($_GET['from_date'])){ echo $_GET['from_date']; }else{
                     echo date("Y-m-d"); }  ?>"></label>
                  </div>&nbsp;
                  <div class="form-group">
                    <label>To
                    <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"  value="<?php if(isset($_GET['to_date']) || empty($_GET['to_date'])){ echo $_GET['to_date']; }else{
                     echo date("Y-m-d"); } ?>"></label>
                  </div>&nbsp;
                  <div class="form-group" style="display: none;">
                    <label>Docor Checking
                      <select class="form-control form-control-sm" name="status" id="status">
                        <?php
                        $all ='';
                        $two ='';
                        $one ='';
                         if(isset($_GET['status']) && !empty($_GET['status'])){

                           if($_GET['status']=='All')
                           {
                             $all .='selected'; 
                           }
                           if($_GET['status']=='2')
                           {
                             $two .='selected'; 
                           }
                           if ($_GET['status']=='1') {
                             $one .='selected'; 
                           }
                         }
                         else
                         {
                           $all .='selected';
                         }
                        ?>
                        <option value="All" <?php echo $one; ?>>All</option>
                        <option value="1" <?php echo $all; ?>>Pending</option>
                        <option value="2" <?php echo $two; ?>>Success</option>
                        
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
              <div class="row">
                <div class="col-md-6">
                  <input type="search" name="myInput1" id="myInput1" class="form-control form-control-sm" placeholder="Search Name or Mobile No..">
                </div>
              
              <div class="col-md-6">

                <button onclick="location.href='add_patient.php'" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Add</button>&nbsp;
                <!-- <button name="delete" id="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Delete</button>&nbsp; -->
                <form action="" method="POST" id="export_form" style="display: inline-table;">
                 <button type="submit" name="export" id="export" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i>&nbsp;Export Excel</button>
                 <input type="hidden" name="id" id="id">
                </form>
              </div>
              </div>
               <table id="table" class="table table-sm table-bordered table-striped">
                  <thead>
                  <tr>
                    <th><input type="checkbox" name="select_all" id="select_all"><label for="select_all">All</label></th>
                    <th>Sl. No</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <!-- <th>For Visit</th>
                    <th>Doctor Check</th> -->
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="data_success">
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pay Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         
           <form id="admin_data_form">
             <div class="form-group col-md-12">
                <label><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;Amount*</label>
                <input type="text" name="amount" class="form-control" readonly id="amount">
             </div>
             <div class="form-group d-flex justify-content-center">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="page" value="Amount_Submit_form">
                <input type="hidden" name="action" value="Amount_Submit_form">
                <input type="submit" class="btn btn-info" id="amount">
             </div>
           </form>
            
         
      </div>
    </div>
  </div>
</div>
  <!-- /.content-wrapper -->
<!-- <input type="hidden" id="display" value="Display_Patient_Visited_All"> -->
<input type="hidden" id="status_update" value="Patient_Visited_Status_">
<input type="hidden" id="page" value="Display_Patient_waiting_All">
<input type="hidden" id="delete_" value="Delete_Patient_">
<input type="hidden" id="export_brand" value="export_patient_visited.php">
 <?php
 require_once("footer.php");
 require_once("script/admin_jquery.php");
 require_once("script/search_master.php");
 ?>