function keyRestrict(e, validchars){
	var key='', keychar='';
	key = getKeyCode(e);
	if (key == null) return true;
		keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	validchars = validchars.toLowerCase();
	if (validchars.indexOf(keychar) != -1)
		return true;
	if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
		return true;
	return false;
}
function getKeyCode(e){
	if (window.event)
		return window.event.keyCode;
	else if (e)
		return e.which;
	else
		return null;
}
function trimString (str){
  str = this != window? this : str;
  return str.replace(/^\s+/g, '').replace(/\s+$/g, '');
}
function focusFirst(idVal){	
	if(trimString(idVal.value)=='First Name'){
		idVal.value='';
		idVal.style.color='#005279';
	}
}
function focusMiddle(idVal){
	if(trimString(idVal.value)=='Middle Name'){
		idVal.value='';
		idVal.style.color='#005279';
	}
}
function focusLast(idVal){
	if(trimString(idVal.value)=='Last Name'){
		idVal.value='';
		idVal.style.color='#005279';
	}
}
function blurFirst(idVal){
	if (trimString(idVal.value)=='' || trimString(idVal.value)=='First Name'){
		idVal.value='First Name'; 
		idVal.style.color='#A2A2A2';
	}
}
function blurMiddle(idVal){
	if (trimString(idVal.value)=='' || trimString(idVal.value)=='Middle Name'){
		idVal.value='Middle Name'; 
		idVal.style.color='#A2A2A2';
	}
}
function blurLast(idVal){
	if (trimString(idVal.value)=='' || trimString(idVal.value)=='Last Name'){
		idVal.value='Last Name'; 
		idVal.style.color='#A2A2A2';
	}
}
function textCounter(field,entr,remr,maxlimit){
	if (field.value.length > maxlimit) // if too long...trim it!			
		field.value = field.value.substring(0, maxlimit);
		document.getElementById(entr).innerHTML=field.value.length;							
		document.getElementById(remr).innerHTML=maxlimit - field.value.length;			
}

function stateShare(field){
	var val=(((0.25)*parseFloat(field))/0.75);
	return val.toFixed(2);
}
function parseDate(input){
  var parts = input.match(/(\d+)/g);
  return new Date(parts[0], parts[1]-1, parts[2]);
}


function createdate(dateval){
			// dateval must be in dd/mm/yyyy format	
			var x=dateval.split("-");
			var jvsdateval=new Date(x[2],parseInt(x[1]-1),parseInt(x[0]));
			return jvsdateval;
		}
		var DateDiff = {
			inDays: function(d1, d2) {
				var t2 = d2.getTime();
				var t1 = d1.getTime();
				return parseInt((t2-t1)/(24*3600*1000));
			},
			inWeeks: function(d1, d2) {
				var t2 = d2.getTime();
				var t1 = d1.getTime();
				return parseInt((t2-t1)/(24*3600*1000*7));
			},
			inMonths: function(d1, d2) {
				var d1Y = d1.getFullYear();
				var d2Y = d2.getFullYear();
				var d1M = d1.getMonth();
				var d2M = d2.getMonth();
				return (d2M+12*d2Y)-(d1M+12*d1Y);
			},
			inYears: function(d1, d2) {
				return d2.getFullYear()-d1.getFullYear();
			}
		}


		
function passwordStrengthCheck(password1, password2, passwordsInfo,passwordsInfoText)
{
	//Must contain 5 characters or more
	//var WeakPass = /(?=.{5,}).*/; 
	var WeakPass = /(?=.{8,}).*/;
	var OnlyLower = /^(?=\S*?[a-z])\S{8,}$/; 
	var OnlyUpper = /^(?=\S*?[A-Z])\S{8,}$/; 
	var OnlyDigit = /^(?=\S*?[0-9])\S{8,}$/; 
	//Must contain atleast one lower case letters.
	var LittleWeakPass = /^(?=\S*?[a-z])\S{8,}$/; 
	//Must contain lower case letters and at least one digit.
	//var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/; 
	var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/; 
	//Must contain at least one upper case letter, one lower case letter and one digit.
	//var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/; 
	var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/; 
	//Must contain at least one upper case letter, one lower case letter and one digit.
	//var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/; 	
	var VryStrongPass = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$%*?&_#\^])[A-Za-z\d@$%*?&_#\^]{8,}$/;
	
	$(password1).on('keyup', function(e) {
		$('#pass_chk').val('no');
		if(VryStrongPass.test(password1.val()) && password1.val().length > 7)
		{
			//passwordsInfo.removeClass().addClass('vrystrongpass').html("Strong!");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 100%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Strong</div>');
			$('#pass_chk').val('yes');
		}	
		else if(StrongPass.test(password1.val()))
		{
			//passwordsInfo.removeClass().addClass('strongpass').html("Very Good!Use minimum 8 digit for strong");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 80%;"></div></div>');
			//passwordsInfoText.html('<div style="font-weight:bold;">Very Good!Use minimum 8 digit for strong</div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Very Good!Use atleast one special character for strong</div>');
			$('#pass_chk').val('no');
			
		}	
		else if(MediumPass.test(password1.val()))
		{
			//passwordsInfo.removeClass().addClass('goodpass').html("Good!Enter uppercase letter to make strong");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 60%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Good!Enter uppercase letter to make strong</div>');
			$('#pass_chk').val('no');
		}
		else if(LittleWeakPass.test(password1.val()))
    	{
			//passwordsInfo.removeClass().addClass('stillweakpass').html("Still Weak! Enter digits to make good password");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-yellow" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 40%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Still Weak! Good!Enter digit to make strong</div>');
			$('#pass_chk').val('no');
    	}
		else if(!OnlyLower.test(password1.val()) && password1.val().length > 7)
    	{
			//passwordsInfo.removeClass().addClass('stillweakpass').html("Still Weak! Enter digits to make good password");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-yellow" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 40%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Still Weak! Enter atleast one lower case character</div>');
			$('#pass_chk').val('no');
    	}
		else if(!OnlyUpper.test(password1.val()) && password1.val().length > 7)
    	{
			//passwordsInfo.removeClass().addClass('stillweakpass').html("Still Weak! Enter digits to make good password");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-yellow" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 40%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Still Weak! Enter atleast one UPPER case character</div>');
			$('#pass_chk').val('no');
    	}
		else if(!OnlyDigit.test(password1.val()) && password1.val().length > 7)
    	{
			//passwordsInfo.removeClass().addClass('stillweakpass').html("Still Weak! Enter digits to make good password");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-yellow" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 40%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Still Weak! Enter atleast one digit</div>');
			$('#pass_chk').val('no');
    	}
		else if(WeakPass.test(password1.val()))
    	{
			//passwordsInfo.removeClass().addClass('stillweakpass').html("Still Weak! Enter digits to make good password");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-yellow" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 40%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Still Weak! Enter password as per password policy</div>');
			$('#pass_chk').val('no');
    	}
		else
		{
			//passwordsInfo.removeClass().addClass('weakpass').html("Very Weak!(Must be 8 or more chars)");
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-red" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 100%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Very Weak! Password Length should be minimum 8 character long. Enter password as per password policy</div>');
		}
	});
	
	$(password2).on('keyup', function(e) {
		
		if(password1.val() !== password2.val())
		{
			//passwordsInfo.removeClass().addClass('weakpass').html("Passwords do not match!");	
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-red" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 100%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Passwords not matched!</div>');
		}else{
			//passwordsInfo.removeClass().addClass('goodpass').html("Passwords match!");	
			passwordsInfo.html('<div class="progress progress_sm"><div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 100%;"></div></div>');
			passwordsInfoText.html('<div style="font-weight:bold;">Passwords matched!</div>');
		}
			
	});
}	


function encode(str,num){
	for(var i=0;i<num;i++){
		str=reverseString(Base64.encode(str));
	}
	return str;
}

function reverseString(str) {
    return str.split( '' ).reverse( ).join( '' );
}