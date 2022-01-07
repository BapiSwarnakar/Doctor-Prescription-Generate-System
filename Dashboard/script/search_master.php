<script type="text/javascript">
	$(document).ready(function(){

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
                $('#exampleModalCenter').modal('hide');
                Display_All_Payment(
					$('#from_date').val(),
					$('#to_date').val(),
					$('#myInput1').val(),
					$('#status').val()
					);
               
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


	$(document).on('click','.Payment_Now',function(event){
         
         $.ajax({
		        url : "../action-page/admin_ajax_action.php",
		        type : "POST",
		        data : {
		          page : "Payment_Amount",
		          action :"Payment_Amount",
		          id : $(this).data('id')
		        },
		        dataType: "json",
		        success : function(data){
		           $('#amount').val(data.amount);
		           $('#id').val(data.id);
		           $('#exampleModalCenter').modal('show');

		        }
		    });

		 event.preventDefault();
		});
		//current_date = (new Date()).toISOString().split('T')[0];
		Display_All_Payment(
			$('#from_date').val(),
			$('#to_date').val(),
			$('#myInput1').val(),
			$('#status').val()
			);

		  function Display_All_Payment(from_date,to_date,search_val,status)
		  {
		      $.ajax({
		        url : "../action-page/admin_ajax_action.php",
		        type : "POST",
		        data : {
		          page : $('#page').val(),
		          action :$('#page').val(),
		          from_date : from_date,
		          to_date : to_date,
		          search_val : search_val,
		          status : status
		        },
		        success : function(data){
		          $('#data_success').html(data);
		         //  $("#success_app").DataTable({
		         //    "responsive": true,
		         //    "autoWidth": false,
		         // });
		        }
		    });
		  }


     $('#filter_form').parsley();
	  $('#filter_form').on('submit',function(event){
	    if($('#filter_form').parsley().validate())
	    {
	      Display_All_Payment($('#from_date').val(),
			$('#to_date').val(),
			$('#myInput1').val(),
			$('#status').val()
			);
	    }
	    // event.preventDefault();
	  });

	  // Select All Checkbox
	   $('#select_all').change(function(event){
	     $('.select_record').prop("checked",$(this).prop("checked"));

	    event.preventDefault();
	   });
	   // $('#select_all').on('change',function(event){
	   //   $('.select_record').prop("checked",$(this).prop("checked"));
	   //   event.preventDefault();
	   // })

	   $('#excel_downlode_btn').click(function(){
	      var id = $('.select_record:checked').map(function(){
	         return $(this).val();
	      }).get().join(' ');
	      window.open('export_excel_all_payment_list.php?id='+id+'','_blank' );
	      
	   });

	   // Search All AppointMent
	    $("#myInput1").on("keyup", function() {
	      // var value = $(this).val().toLowerCase();
	      // $("#data_ tr").filter(function() {
	      //   $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	      // });
	       var Search_val = $(this).val();
	       if(Search_val !="")
	       {
	         Display_All_Payment(
	         	$('#from_date').val(),
				$('#to_date').val(),
				$('#myInput1').val(),
				$('#status').val()
				);
	       }
	    });

	});
</script>