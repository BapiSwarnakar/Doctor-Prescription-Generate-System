<?php
require_once("header.php");
?>

<!-- Button trigger modal -->
<div class="container mt-5 d-flex justify-content-center">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
  Upload Medicine Excel File
</button>
</div>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="Upload_Item_Excel_Form">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="staticBackdropLabel text-light">Upload Excel File</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
      </div>
      <div class="modal-body">
         <div class="row">
           <div class="form-group">
             <label>Upload Excel File*</label>
             <input type="file" name="file" id="uploadFile" class="form-control" required>
           </div>
         </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="page" value="Upload_Item_Excel_Form_submit">
        <input type="hidden" name="action" value="Upload_Item_Excel_Form_submit">
        <input type="submit" id="upload" class="btn btn-primary" value="Upload">
      </div>
     </form>
    </div>
  </div>
</div>
<?php
require_once("footer.php");
?>
 <script type="text/javascript">
  
  $(document).ready(function(){


  $('#uploadFile').change(function(event){
     var validExt = ". xls";
     var filePath= this.value;
     var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
     var pos = validExt.indexOf(getFileExt);
     if(pos < 0) {
       alert("Invalid File, Please Upload Only Valid Excel File..!");
       $(this).val('');
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
                  toastr["success"]("Upload Successfully", "Message");
     }
    event.preventDefault();
  })
    $('#Upload_Item_Excel_Form').parsley();
    $('#Upload_Item_Excel_Form').on('submit',function(event){
      if($('#Upload_Item_Excel_Form').parsley().validate())
      {
        $.ajax({
              url:"action-page/admin_ajax_action.php",
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
                $('#upload').val('Please wait..');
                $('#upload').attr('disabled',true);
              },
              success:function(data)
              {
                if(data.success)
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
                  toastr["success"](data.success, "Message");
                  $('#Upload_Item_Excel_Form')[0].reset();
                  $('#upload').val('Submit');
                  $('#upload').attr('disabled',false);
                  $('#staticBackdrop').modal('hide');
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
                    $('#upload').val('Submit');
                    $('#upload').attr('disabled',false);
                 }
                
               }
             });
      }
    event.preventDefault();
    });


});
 </script>