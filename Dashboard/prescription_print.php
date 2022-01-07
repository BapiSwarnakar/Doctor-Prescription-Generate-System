<?php
require_once("../db_connect/db_connect.php");
require_once("../class/class.php");
$server= new Main_Classes;
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
$server->admin_session_private();
 if (!empty($_GET['id'])) {
 	
 	$id = $_GET['id'];
 }
 else
 { 
 	echo "Invalid Patient Unic Id";
 	exit(0);
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Print Prescription</title>
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
 <link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
</head>
<body id="ht">
  <div class="container-fluid">
    <!-- <div class="card text-center">
      <div class="row">
        <div class="col-sm-6 col-lg-6 col-md-6">
           <div class="p-2">
             <h2 style="font-family: 'Playball', cursive;">Dr. M.R Ali</h2>
             <span style="font-size: 13px;">M.B.B.S (Kol). D.C.H (L.P.G.M.E & It.)</span><br>
             <span style="font-size: 15px; font-weight: bold;">CHILD SPECIALIST</span><br>
          </div>
        </div>
        <div class="col-sm-6 col-lg-6 col-md-6 ">
            <div class="p-2">
             <h5 style="font-family: 'Playball', cursive;">THE BLUE PRINT <span style="font-size: 12px;font-weight: bold;">(Chamber)</span></h5>
             <span style="font-size: 14px;">Dr. B.C Roy Sarani, Raiganj</span><br>
             <span>(<b>Sunday</b> Closed)</span>
          </div>
        </div>
      </div>
    </div> -->
    <table class="table table-bordered table-sm">
      <tr style="text-align: center;">
        <th class="text-center bg-info" colspan="2">
        <?php
            echo $server->All_Patient_Details($id);
          ?>
        </th>
      </tr>
      <tbody>
        <tr>
          <td>
            <b>Diagnosis</b>
            <ul>
             <?php 
                echo $server->All_Prescription_Diagnosis($id);
              ?>
          </ul>
          </td>
          <td>
            <b>Advice</b>
            <ul>
             <?php 
                echo $server->All_Prescription_Medicine($id);
              ?>
          </ul>
          </td>
          
        </tr>
        <tr>
          <td>
            <b>Test</b>
            <ul>
             <?php 
                echo $server->All_Prescription_Test($id);
              ?>
          </ul>
          </td>
          <td>
           
            <ul>
             <?php 
              echo $server->All_Prescription_Advice($id);
              ?>
          </ul>
          </td>
          
        </tr>
      </tbody>
    </table>
    <div style="width:90%; text-align: right; margin-top:60px;  font-style: italic; font-size: 14px; font-weight: bold;text-decoration: underline;">
    Signature
  </div>
    
  	 <!-- <div class="card">
  	 	<div class="card-title bg-light">
  	 		<p class="text-center" >Prescription</p>
  	 		<span style="font-size: 14px;">
  	 			<?php
                  echo $server->All_Patient_Details($id);
  	 			?>
  	 		
  	 		</span><br>
  	 		<span style="font-size: 14px; text-align: right; margin-right: 10px;">Date:&nbsp;<?php echo date('d-m-Y'); ?></span>
  	 		
  	 	</div>
  	 	<hr>
  	 	<div class="card-body">
  	 		<div class="row">
  	 			<div class="col-md-12 col-12">
  	 			   <div class="row">
  	 			   	<div class="col-md-12">
  	 			   	   <div class="card">
  	 			   	   	 <div class="card-titile bg-light">
  	 			   	   	 	<span class="text-dark">Diagnosis</span>
  	 			   	   	 </div>
                   <div class="card-body">
                      <ul>
                         <?php 
                          echo $server->All_Prescription_Diagnosis($id);
                         ?>
                      </ul>
                   </div>
  	 			   	   </div>
  	 			   	</div>
  	 			   	<div class="col-md-12">
  	 			   		<div class="card">
  	 			   	   	 <div class="card-title bg-light text-dark">
  	 			   	   	 	<span class="text-dark">Test</span>
  	 			   	   	 </div>
                   <div class="card-body">
                      <ul>
                         <?php 
                          echo $server->All_Prescription_Test($id);
                         ?>
                      </ul>
                   </div>
  	 			   	   </div>
  	 			   	</div>

  	 			   </div>
  	 			</div>
  	 			<div class="col-md-12 col-12">
  	 				<div class="row">
  	 					<div class="col-md-12">
  	 						<div class="card">
		  	 			   	   	<div class="card-title text-light bg-light">
		  	 			   	   	<span class="text-dark">Medicine</span>
		  	 			   	   	</div>
                      <div class="card-body">
                      <ul>
                         <?php 
                          echo $server->All_Prescription_Medicine($id);
                         ?>
                      </ul>
                   </div>
		  	 			   	 </div>
                   
  	 					</div>
  	 					<div class="col-md-12">
  	 						<div class="card">
		  	 			   	   	<div class="card-title text-light bg-light">
		  	 			   	   		<span class="text-dark">Advice</span>
		  	 			   	   	</div>
                      <div class="card-body">
                      <ul>
                         <?php 
                          echo $server->All_Prescription_Advice($id);
                         ?>
                      </ul>
                   </div>
		  	 			   	 </div>
                   
  	 					</div>
  	 				</div>
  	 			</div>

  	 		</div>
  	 	</div>
  	 </div> -->

  </div>
   
<?php
require_once("footer.php");
?>

<script type="text/javascript">
  
  $(document).ready(function(){
     $(document).on('click','.Delete_Prescription',function(event){

      var id = $(this).data('id');
      var type = $(this).data('type');
      $.ajax({
            url:"../action-page/admin_ajax_action.php",
            method:"POST",
            data:{
              page : 'Delete_Prescription_List',
              action : 'Delete_Prescription_List',
              id : id,
              type : type
            },
            dataType:"json", 
            success:function(data)
            {
              if(data.success)
              {
                location.reload();
               }
               else
               {
                  toastr.options = {
                    "closeButton": true,  // true or false
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,  // true or false
                    "rtl": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false, // true or false
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                  toastr["error"](data.error, "Message");
                  $('#submit').val('Submit');
                  $('#submit').attr('disabled',false);
               }
              
             }
           });

  });
  })
</script>
