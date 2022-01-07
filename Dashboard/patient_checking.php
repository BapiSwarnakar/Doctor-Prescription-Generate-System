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
if(isset($_GET['id']) && empty($_GET['id']))
{
  echo "<script>window.history.go(-1);</script>";
}
?>
<style type="text/css">
  #display_visitor_patient{
    background-color: white;
    color: black;
  }
.card-body.card-responsive.cd-on { padding: 8px;}
.card.d-flx-cd {
    margin-bottom: 0px !important;
    padding-bottom: 0px;
    height: 100vh;
}

@media (max-width: 768px){
    .btn{    padding: 5px 5px; }
    .advice-txt { position: absolute; }
        
        
}


/*.modal-dialog.modal-dialog-centered.bhz {*/
/*    margin: 0px auto !important;*/
/*    margin-top: 0px;*/
/*} */




</style>


    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: none;">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Display Visitor Patient & Prescription List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="javascript:void(0)" onclick="window.history.go(-1); ">All Visit Patient</a></li>
              <li class="breadcrumb-item active">Display Visitor Patient List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content main-cont-sec">
      <div class="container-fluid">
        <div class="row f-row">
          <!-- left column -->
          <div class="col-md-12 l-col-fw">
            <!-- jquery validation -->
            <div class="card d-flx-cd">
              <!-- <div class="card-header">
                <h3 class="card-title">
                  <label>Select Patient</label>
                  <select name="name" class="form-control" onchange="location = this.value;" required>
                    <option value="">Select</option>
                    <?php
                     echo $server->All_Active_Patient();
                    ?>
                  </select>
                </h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body card-responsive cd-on">
                <div class="row text-center bg-danger cd-row-vh">
                  <div class="col-md-1 col-3">
                    Digis
                  </div>
                  <div class="col-md-1 col-3">
                    Digis
                  </div>
                  <div class="col-md-7 col-4">
                    Presciption
                  </div>
                  
                  <div class="col-md-1 col-3">
                    Tablet
                  </div>
                  <div class="col-md-1 col-3">
                    Syrup
                  </div>
                  <div class="col-md-1 col-3">
                    Others
                  </div>
                </div>
               <div class="row inr-cd-row-vh">

                  <div class="col-md-1 col-6 bg-dark ov-y" style="height: calc(100vh - 40px); overflow-y: scroll; scroll-behavior: smooth;">
                      <?php
                       echo $server->All_Menu1_Digis();
                      ?>
                  </div>
                  <div class="col-md-1 col-6 bg-dark ov-y" style="height: calc(100vh - 40px); overflow-y: scroll; scroll-behavior: smooth;">
                     <?php
                       echo $server->All_Menu2_Digis();
                      ?>
                  </div>
                  
                  <div class="col-md-7 col-12 bg-dark">
                    <iframe name="Frame1" id="Frame1" src="prescription_print.php?id=<?php echo $_GET['id']; ?>" style="width: 100%; height: calc(100vh - 180px);">
                      
                    </iframe>

                    <iframe name="Frame2" id="Frame2" src="preview_prescription.php?id=<?php echo $_GET['id']; ?>" style="width: 100%;height: 100%; display: none;">
                      
                    </iframe>
                    <div class="p-abso-br">    
                    <div class="row">
                        <div class="col-md-12 col-12 bg-dark ov-x" style="width: 100em; overflow-x: auto;white-space: nowrap; bottom: 0; padding: 8px;">
                          <!-- All TEST HERE SHOW -->
                            <?php
                             echo $server->All_Test();
                            ?>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-2  row-btns-sec">
                                 <div class="d-flex justify-content-center col-md-11 col-12">
                                    <a href="dashboard.php" class="btn btn-danger">Home</a>&nbsp;&nbsp;&nbsp;
                                    <a href="javascript:void(0)" onclick="window.history.go(-1); " class="btn btn-warning">Back</a>&nbsp;&nbsp;&nbsp;
                                    <a href="display_visitor_patient.php" class="btn btn-secondary">P. List</a>&nbsp;&nbsp;&nbsp;
                                    <form id="Print_Prescription_form_">
                                      <input type="hidden" name="id_user" id="id_user" value="<?php echo $_GET['id']; ?>">
                                      <input type="hidden" name="page" value="Print_Prescription_form">
                                       <input type="hidden" name="action" value="Print_Prescription_form">
                                      <input type="submit" name="print" id="print" class="btn btn-success" value="Save & Print">&nbsp;&nbsp;&nbsp;
                                      <a href="preview_prescription.php?id=<?php echo $_GET['id']; ?>" class="btn btn-info">Preview</a>
                                    </form>
                                 </div>
                               </div>
                        </div>
                        
                        
                        
                   </div>
                  </div>
                  </div>
                  <div class="col-md-1 col-4 bg-dark">
                    <div class="row-md-6 col-md-12 ov-y" style="height: calc(100vh - 245px); overflow-y: scroll; scroll-behavior: smooth;">
                      <?php
                        echo $server->All_Tablet();
                      ?>
                    </div>
                    <label class="bg-danger col-md-1 advice-txt">Advice</label><br>
                    <div class="row-md-6 col-md-12 ov-y" style="height: 175px;overflow-y: scroll; scroll-behavior: smooth;">
                      
                      <?php
                        echo $server->All_Advice();
                      ?>
                    </div>
                     
                  </div>
                  <div class="col-md-1 col-4 bg-dark ov-y" style="height: calc(100vh - 40px); overflow-y: scroll; scroll-behavior: smooth;">
                     <?php
                      echo $server->All_Syrup();
                     ?>
                  </div>
                  <div class="col-md-1 col-4 bg-dark ov-y" style="height: calc(100vh - 40px); overflow-y: scroll; scroll-behavior: smooth;">
                     <?php
                      echo $server->All_Others();
                     ?>
                  </div>

               </div>
              
             
               
              </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
            
               
      </div><!-- /.container-fluid -->
    </section>


<!-- Modal -->
<div class="modal fade" id="generate_modal"  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered bhz" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
         <form id="prescription_suggest_form"> 


        </form>
            
         
      </div>
    </div>
  </div>
</div>

 <?php
 require_once("footer.php");
 require_once("script/admin_jquery.php");
 require_once("script/search_master.php");
 ?>
 <script type="text/javascript">
   $(document).ready(function(){
    
    $('#close_sidebar').click();
    $('#sidebar').css('display','none');
    $('#topbar').css('display','none');

     $(document).on('click','.Click_Button_for_Presc',function(event){
       var id = $(this).data('id');
       var type = $(this).data('type');
       var name = $(this).data('name');
       var user_id = '<?php echo $_GET['id']; ?>';
        if(id !='')
        {
          var form = '';
          switch (type) {
           case 'digis':
             form ='<div class="form-group col-md-12"> <label>'+name+'</label> <input type="text" name="suggest" class="form-control" id="suggest" placeholder="Suggest Now"> <br> </div> <div class="form-group d-flex justify-content-center"> <input type="hidden" name="id" id="id" value="'+id+'"><input type="hidden" name="user_id" id="user_id" value="'+user_id+'"> <input type="hidden" name="type" id="type" value="'+type+'"><input type="hidden" name="page" value="Suggest_Submit_form"> <input type="hidden" name="action" value="Suggest_Submit_form"> <input type="submit" class="btn btn-primary btn-sm" id="submit"> </div>'; 
             break;
           case 'advice':
             form ='<div class="form-group col-md-12"> <label>'+name+'</label> <input type="text" name="suggest" class="form-control" id="suggest" placeholder="Suggest Now"> <br> </div> <div class="form-group d-flex justify-content-center"> <input type="hidden" name="id" id="id" value="'+id+'"> <input type="hidden" name="user_id" id="user_id" value="'+user_id+'"><input type="hidden" name="type" id="type" value="'+type+'"><input type="hidden" name="page" value="Suggest_Submit_form"> <input type="hidden" name="action" value="Suggest_Submit_form"> <input type="submit" class="btn btn-primary btn-sm" id="submit"> </div>'; 
             break;
           case 'medicine':
              form ='<div class="row"> <div class="form-group col-md-6"> <label>'+name+'</label> <input type="text" name="medicine" class="form-control" id="medicine" placeholder="Medicine Quantity" required> </div> <div class="form-group col-md-6"> <label>Day</label> <input type="text" name="day" class="form-control"  id="day" placeholder="Day" required> <br> </div> <div class="form-group col-md-12 d-flex justify-content-center"> <input type="hidden" name="id" id="id" value="'+id+'"><input type="hidden" name="user_id" id="user_id" value="'+user_id+'"><input type="hidden" name="type" id="type" value="'+type+'"> <input type="hidden" name="page" value="Suggest_Submit_form"> <input type="hidden" name="action" value="Suggest_Submit_form"> <input type="submit" class="btn btn-primary btn-sm" id="submit"> </div> </div>';
            break;
           case 'test':
             form ='<div class="form-group col-md-12"> <label>'+name+'</label> <input type="text" name="suggest" class="form-control"  id="suggest" placeholder="Suggest Now"> <br> </div> <div class="form-group d-flex justify-content-center"> <input type="hidden" name="id" id="id" value="'+id+'"><input type="hidden" name="user_id" id="user_id" value="'+user_id+'"><input type="hidden" name="type" id="type" value="'+type+'"> <input type="hidden" name="page" value="Suggest_Submit_form"> <input type="hidden" name="action" value="Suggest_Submit_form"> <input type="submit" class="btn btn-primary btn-sm" id="submit"> </div>'; 
             break;

           default:
             form ='<h1>Invalid. Not Found..!</h1>';
             break;
         } 
         $('#prescription_suggest_form').html(form);
         $('#generate_modal').modal('show');

        }
       
     });


    $('#prescription_suggest_form').parsley();
    $('#prescription_suggest_form').parsley();
    $('#prescription_suggest_form').on('submit',function(event){
    if($('#prescription_suggest_form').parsley().validate())
    {
      $.ajax({
            url:"../action-page/admin_ajax_action.php",
            method:"POST",
            enctype : "multipart/form-data",
            data: new FormData(this),
            dataType:"json",
            contentType: false,
            cache: false,
            processData:false, 
            //contentType: false,
            //cache: false,
            // processData:false,        
            beforeSend:function()
            {
              $('#submit').val('Please wait..');
              $('#submit').attr('disabled',true);
              window.frames["Frame1"].location.reload();
              window.frames["Frame2"].location.reload();
            },
            success:function(data)
            {
              if(data.success)
              {
                $('#generate_modal').modal('hide');
                //$('#').contentDocument.location.reload(true);
                window.frames["Frame1"].location.reload();
                window.frames["Frame2"].location.reload();
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
    }
   event.preventDefault();
  });


setInterval(function(){ window.frames["Frame2"].location.reload(); }, 3000);
  $('#Print_Prescription_form_').on('submit',function(event){
    
    //  window.frames["Frame2"].location.reload(); 
     $.ajax({
            url:"../action-page/admin_ajax_action.php",
            method:"POST",
            enctype : "multipart/form-data",
            data: new FormData(this),
            dataType:"json",
            contentType: false,
            cache: false,
            processData:false, 
            //contentType: false,
            //cache: false,
            // processData:false,        
            beforeSend:function()
            {
              $('#print').val('Please wait..');
              $('#print').attr('disabled',true);
              
            },
            success:function(data)
            {
              if(data.success)
              {
                // window.frames["Frame1"].document.body.style.marginTop = "30%";
                 
                window.frames["Frame2"].window.focus();
                window.frames["Frame2"].window.print();
                $('#print').val('Save & Print');
                $('#print').attr('disabled',false); 
                //window.frames["Frame2"].document.body.style.marginTop = "auto";
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
                  $('#print').val('Save & Print');
                  $('#print').attr('disabled',false);
               }
              
             }
           });
      
      
      event.preventDefault();
     });


   });

 </script>