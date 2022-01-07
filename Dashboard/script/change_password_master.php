<script type="text/javascript">
	$(document).ready(function(){
		$('#Change_password_form').parsley();


		$('#Change_password_form').on('submit',function(event){
		if($('#Change_password_form').parsley().validate())
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
                $('#Change_password_form')[0].reset();
                $('#submit').val('Forget Password');
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
                  $('#submit').val('Forget Password');
                  $('#submit').attr('disabled',false);
               }
              
             }
           });
		}
	 event.preventDefault();
	});


});
</script>