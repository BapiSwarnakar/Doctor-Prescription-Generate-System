<script type="text/javascript">
	$(document).ready(function(){
		current_date = (new Date()).toISOString().split('T')[0];
		Display_All_Payment(current_date,current_date,'');
		  function Display_All_Payment(from_date,to_date,search_val)
		  {
		      $.ajax({
		        url : "../action-page/admin_ajax_action.php",
		        type : "POST",
		        data : {
		          page : "Display_All_Payment",
		          action :"Display_All_Payment",
		          from_date : from_date,
		          to_date : to_date,
		          search_val : search_val
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
	      Display_All_Payment($('#from_date').val(),$('#to_date').val(),'');
	    }
	    event.preventDefault();
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
	      //alert(id);
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
	         Display_All_Payment($('#from_date').val(),$('#to_date').val(),Search_val);
	       }
	    });

	});
</script>