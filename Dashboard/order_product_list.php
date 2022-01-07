<?php
require_once("header.php");
?>
<style type="text/css">
  #display_unit{
    background-color: white;
    color: black;
  }
  body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}





























</style>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Display Unit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="display_order.php">Display Order</a></li>
              <li class="breadcrumb-item active">Display Unit</li>
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
                <h3 class="card-title">View Unit List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="load"></div>
              
              
               <table id="table" class="table table-bordered table-striped">
                  <thead>

                  <tr>
                    <th>Sl. No</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price x Qty</th>
                    <th>Total</th>

                  </tr>
                  </thead>
                  <tbody>
                   <?php
                     if(!empty($_GET['id']))
                      {

                        $sql = "SELECT `Payment_Id`,`order_id`,tbl_payment.H_Id, `Amount`, `User_Id`,tbl_category.C_Image,tbl_product.P_Name,order_footer.Qty,tbl_product.P_Selling_Price,(order_footer.Qty*tbl_product.P_Selling_Price)total FROM `tbl_payment` INNER JOIN order_footer ON tbl_payment.H_Id=order_footer.H_Id INNER JOIN tbl_product ON tbl_product.P_Id=order_footer.P_Id INNER JOIN tbl_category ON tbl_category.C_Id=tbl_product.C_Id WHERE tbl_payment.Payment_Id='$_GET[id]'";
                        if($server->All_Record($sql))
                        {
                          $count =1;
                          $total=0;
                          foreach ($server->View_details as $value) {
                                ?> 
                                 
                                 <tr>
                                    <td><?php echo  $count; ?></td>
                                    <td><img src="../../image/<?php echo  $value['C_Image']; ?>" width="60px"></td>
                                    <td><?php echo  $value['P_Name']; ?></td>
                                    <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<?php echo  $value['P_Selling_Price']; ?>&nbsp;x&nbsp;<?php echo  $value['Qty']; ?></td>
                                    <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<?php echo  $value['total']; ?></td>
                                  </tr>
 
                                <?php
                            $count++;
                            $total += $value['P_Selling_Price']*$value['Qty'];
                            }
                          ?>
                            <tr>
                              <td colspan="5">Total Price : <i class="fa fa-inr" aria-hidden="true"></i>&nbsp;<?php echo  $total; ?></td>
                            </tr>
                          <?php
                        }
                      }
                      else
                      {
                        echo "<script>window.location='display_unit.php'</script>";
                      }
                     ?>
                    </tbody>
                </table>
                <br>
                <input type="submit" id="print" name="print" value=" Order Reciept Download" data-id="<?php echo $_GET['id']; ?>" class="btn btn-info">
              </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-12" id="reciept_hide">
                <div class="page-content container">
    <div class="page-header text-blue-d2">
        <h1 class="page-title text-secondary-d1">
            Order
            <small class="page-info">
                <i class="fa fa-angle-double-right text-80"></i>
                ID: <?php echo $value['order_id']; ?>
            </small>
        </h1>

        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95" href="javascript:void(0)" data-title="Print" onclick="Generate();">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                <!-- -->
            </div>
        </div>
    </div>

    <div class="container px-0" id="reciept">

      <!--  -->
        

        <!--  -->
    </div>




</div>
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
  <input type="hidden" id="display" value="Display_Unit_All">
  <input type="hidden" id="delete_" value="Delete_Unit_">
  <input type="hidden" id="export_brand" value="export_unit.php">
 <?php
 require_once("footer.php");
 ?>
 <script type="text/javascript">
  $(document).ready(function(){
    
    $('#reciept_hide').hide();
    $('#print').on('click',function(event) {
      
      $.ajax({
            url : "../../action-page/admin_ajax_action.php",
            type : "POST",
            data : {
              page : "Order_reciept",
              action :"Order_reciept",
              id : $(this).data('id')
            },
            success : function(data){
              $('#reciept').html(data);
              $('#reciept_hide').show();
            }
        });

     event.preventDefault();
    });


  });
   
 </script>


<script src="../../assets/plugins/html2pdf/html2pdf.bundle.min.js"></script>
<script>
 function Generate() {
    var element = document.getElementById('reciept');
    html2pdf(element, {
      margin:       10,
      filename:     'generate_order.pdf',
      image:        { type: 'jpeg', quality: 0.99 },
      html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
      jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    });
 }
 
</script>
