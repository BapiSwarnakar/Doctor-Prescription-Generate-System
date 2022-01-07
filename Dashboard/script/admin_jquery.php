<script type="text/javascript">
	$(document).ready(function(){
    
    resize();
    function resize() {
      if ($(window).width() < 700) {
         $("#table").addClass("table-responsive"); 
       }
    }
    $(function () {
        // Summernote
        $('.textarea').summernote()
      })

    $('.select2').select2();


    // 
    
		$('#admin_data_form').parsley();
		$('#admin_data_form').on('submit',function(event){
		if($('#admin_data_form').parsley().validate())
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
                $('#admin_data_form')[0].reset();
                $('#submit').val('Submit');
                $('#submit').attr('disabled',false);
                
               
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
        
        All_Display_Admin_Access_Data();
	      function All_Display_Admin_Access_Data()
	      {
	          $.ajax({
	            url : "../action-page/admin_ajax_action.php",
	            type : "POST",
	            data : {
	              page : $('#display').val(),
	              action : $('#display').val()
	            },
	            success : function(data){
	              $('#data').html(data);
	           //   $("#table").DataTable({
	           //     "responsive": true,
	           //     "autoWidth": false,
            //       dom: 'Bfrtip',
            //       buttons: [
            //           "copy","excel","csv","pdf","print"
            //       ]
	           //  });
                $('#load').hide();
	            }
	        });
	      }

  $(document).on('click','.Update_Status',function(event){

    var conn = confirm("Are You Sure Update Now !");
    if(conn != false)
    {
        $.ajax({
        url : "../action-page/admin_ajax_action.php",
        type : "POST",
        data:{
          page : $('#status_update').val(),
          action  : $('#status_update').val(),
          id : $(this).data('id'),
          value : $(this).data('value')
        },
        dataType : "json",
        success : function (data)
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
                  setTimeout(function(){
                    location.reload();
                  }, 1000);
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
               }
        }

      });
    }
    event.preventDefault();
  })



 
  // Select All Checkbox
     $('#select_all').change(function(event){
       $('.select_record').prop("checked",$(this).prop("checked"));

      event.preventDefault();
     });

     $('#delete').click(function(event){
        var id = $('.select_record:checked').map(function(){
           return $(this).val();
        }).get().join(',');
        if(id !='')
        {
           var conn = confirm("Are You Sure Delete !");
           if (conn != false) {

                $.ajax({
                      url : "../action-page/admin_ajax_action.php",
                      type : "POST",
                      data:{
                        page : $('#delete_').val(),
                        action  : $('#delete_').val(),
                        id : id
                      },
                      dataType : "json",
                      success : function (data)
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
                                setTimeout(function(){
                                  location.reload();
                                }, 500);

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
                             }
                      }

                    });
           }
        }
        else
        {
           alert("Please Select Minimun One Record !");
        }

      event.preventDefault();
        
     });


     $('#export').click(function(event){
        var id = $('.select_record:checked').map(function(){
           return $(this).val();
        }).get().join(',');
        if(id !='')
        {
          var page = $('#export_brand').val();
          $('#id').val(id);
          $('#export_form').attr('action',''+page+'');  
          //window.open(page+'?id='+id+'','_blank');
        }
        else
        {
          alert("Please Select Minimun One Record !");
          event.preventDefault();
        }
        
        //alert(id);

     });


	});


// Check Valid Image
  $(document).ready(function(){
//  MADHYAMIK DOC UPLOAD
     //$('#success').hide();

    $("#file").change(function () {
        if(fileExtValidate(this)) {
           if(fileSizeValidate(this)) {
            showImg(this);
           }   
        }    
      });
    // File extension validation, Add more extension you want to allow
    var validExt = ".jpg , .jpeg , .png";
    function fileExtValidate(fdata) {
     var filePath = fdata.value;
     var getFileExt = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
     var pos = validExt.indexOf(getFileExt);
     if(pos < 0) {
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
                  $('#file').val('');
                  toastr["error"]("This file is not allowed, please upload valid file.", "Message");
                  //$('#success').hide();
      //alert("This file is not allowed, please upload valid file.");
                
      return false;
      } else {
        return true;
      }
    }
    // file size validation
    function fileSizeValidate(file) {
        var FileSize = file.files[0].size/1024/1024;  //1024/1024; // in MB
        if (FileSize >2) {  /// 15 MB CHECK ALL FILE
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
                  $('#file').val('');
                  toastr["warning"]("File size exceeds 3 MB"+FileSize, "Message");
            //alert('File size exceeds 1 MB'+FileSize);
              //$('#success').hide();
              
              // $('#zip_img').attr('src','');
          return false;
           // $(file).val(''); //for clearing with Jquery
        } else {
            //alert('File size '+FileSize);
              return true;
          }
       }
     // display img preview before upload.
    function showImg(fdata) {
            if (fdata.files && fdata.files[0])
             {
                var reader = new FileReader();
              reader.onload = function (e) 
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
                  toastr["success"]("Image Upload Success", "Message");
                  // $('#zip_img').attr('src', e.target.result);
                  //$('#success').show();
                }
                reader.readAsDataURL(fdata.files[0]);
            }
        }

     });
</script>
