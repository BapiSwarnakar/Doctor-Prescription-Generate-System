$(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

$(".next").click(function(){

id = $(this).attr('id');
switch(id) {
  case "personal_details":
    if($('[name=name]').val() !="" && $('[name=Degree]').val() !="" && $('[name=License]').val() !="" && $('[name=Mobile]').val() !="" && $('[name=Email]').val() !="")
	{
			$.ajax({
            url:"../../action-page/admin_ajax_action.php",
            method:"POST",
            enctype : "multipart/form-data",
            data:
            {
            	name : $('[name=name]').val(),
            	degree : $('[name=Degree]').val(),
            	license : $('[name=License]').val(),
            	mobile : $('[name=Mobile]').val(),
            	email : $('[name=Email]').val(),
            	page :"personal_details",
            	action : "personal_details"
            },
            dataType:"json",    
            beforeSend:function()
            {
              $('.next').val('Please wait..');
              $('.next').attr('disabled',true);
            },
            success:function(data)
            {
              if(data.success)
              {
                 
              }
               else
               {
                 alert("Please Fill Valid Information !");
               }
              
             }
        });
	}
	else
	{   
		alert("Please Fill All Details !");
	}
    break;
   case "education_details":
    if($('[name=Degree_]').val() !="" && $('[name=Passing_year]').val() !="")
	{
		$('#msform').on('submit',function(event){
			$.ajax({
            url:"../../action-page/admin_ajax_action.php",
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
              $('.next').val('Please wait..');
              $('.next').attr('disabled',true);
            },
            success:function(data)
            {
              if(data.success)
              {
                current_fs = $(this).parent();
		        next_fs = $(this).parent().next();
               }
               else
               {
                 alert("Please Fill Valid Information !");
               }
              
             }
           });
		
	 event.preventDefault();
	});
	}
	else
	{   
		alert("Please Fill All Details !");
	}
    break;
   case "specialization":
    if($('[name=special]').val() !="")
	{
		$('#msform').on('submit',function(event){
			$.ajax({
            url:"../../action-page/admin_ajax_action.php",
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
              $('.next').val('Please wait..');
              $('.next').attr('disabled',true);
            },
            success:function(data)
            {
              if(data.success)
              {
                current_fs = $(this).parent();
		        next_fs = $(this).parent().next();
               }
               else
               {
                 alert("Please Fill Valid Information !");
               }
              
             }
           });
		
	 event.preventDefault();
	});
	}
	else
	{   
		alert("Please Fill All Details !");
	}
    break;
   case "membership":
    if($('[name=members]').val() !="")
	{
	  $('#msform').on('submit',function(event){
			$.ajax({
            url:"../../action-page/admin_ajax_action.php",
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
              $('.next').val('Please wait..');
              $('.next').attr('disabled',true);
            },
            success:function(data)
            {
              if(data.success)
              {
                current_fs = $(this).parent();
		        next_fs = $(this).parent().next();
               }
               else
               {
                 alert("Please Fill Valid Information !");
               }
              
             }
           });
		
	 event.preventDefault();
	});
	
		
	}
	else
	{   
		alert("Please Fill All Details !");
	}
    break;
}

//  $($(this).parent()).validate({
//     onfocusout:true,
//     rules:{
//       name:"required",
//     }
    
// });
if(next)
{
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	next_fs.show();
}
else
{
	alert("error");
}

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 600
});
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});

$('.radio-group .radio').click(function(){
$(this).parent().find('.radio').removeClass('selected');
$(this).addClass('selected');
});

$(".submit").click(function(){
return false;
})

});