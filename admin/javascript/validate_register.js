$(document).ready(function(){
// ====================================================== //

var jVal = {
	'fullName' : function() {
	
		$('body').append('<div id="nameInfo" class="info" ></div>');
		
		var nameInfo = $('#nameInfo');
		var ele = $('#fName');
		var eleLName = $('#lName');
		var pos = ele.offset();
		
		nameInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+120
		});
		
		if( ele.val().length == 0  || ele.val() == "First Name" || eleLName.val() == "Last Name" || eleLName.val().length == "") {
			jVal.errors = true;
				nameInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				nameInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'gender' : function (){
		
		$('body').append('<div id="genderInfo" class="info"></div>');
	
		var genderInfo = $('#genderInfo');
		var ele = $('#male');
		var pos = ele.offset();
		
		genderInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+90
		});
		
		if($('input[name="gender"]:checked').length === 0) {
			jVal.errors = true;
				genderInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');		
		} else {
				genderInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}	
	},
	
	'birthDate' : function() {
		$('body').append('<div id="birthDateInfo" class="info" ></div>');
		
		var birthDateInfo = $('#birthDateInfo');
		var eleY = $('#year');
		var eleD = $('#day');
		var eleM = $('#month');
		var pos = eleY.offset();
		
		birthDateInfo.css({
			top: pos.top-0,
			left: pos.left+eleY.width()+10
		});
		if((eleY.val() == "" )|| (eleD.val() == "") || (eleM.val() == "")) {
			jVal.errors = true;
				birthDateInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				eleY.removeClass('normal').addClass('wrong');
		} else {
				birthDateInfo.removeClass('error').addClass('correct').html('&radic;').show();
				eleY.removeClass('wrong').addClass('normal');
		}
	},
	
	'country' : function() {
		$('body').append('<div id="countryInfo" class="info" ></div>');
		
		var countryInfo = $('#countryInfo');
		var ele = $('#country');
		var pos = ele.offset();
		
		countryInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+20
		});
		if(ele.val() == "" ) {
			jVal.errors = true;
				countryInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');
		} else {
				countryInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'phone' : function() {
	
		$('body').append('<div id="phoneInfo" class="info" ></div>');
		
		var phoneInfo = $('#phoneInfo');
		var ele = $('#phone');
		var pos = ele.offset();
		
		phoneInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length <= 0) {
			jVal.errors = true;
				phoneInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				phoneInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	
	'username' : function() {
	
		$('body').append('<div id="usernameInfo" class="info" ></div>');
		
		var usernameInfo = $('#usernameInfo');
		var ele = $('#username');
		var pos = ele.offset();
		
		usernameInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length == 0) {
			jVal.errors = true;
				usernameInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				usernameInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'email' : function() {
	
		$('body').append('<div id="emailInfo" class="info" ></div>');
		
		var emailInfo = $('#emailInfo');
		var ele = $('#email');
		var pos = ele.offset();
		
		emailInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length == 0) {
			jVal.errors = true;
				emailInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				emailInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'password' : function() {
	
		$('body').append('<div id="passwordInfo" class="info" ></div>');
		
		var passwordInfo = $('#passwordInfo');
		var ele = $('#password');
		var pos = ele.offset();
		
		passwordInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length == 0) {
			jVal.errors = true;
				passwordInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				passwordInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	
	
	'retypePassword' : function() {
	
		$('body').append('<div id="retypePasswordInfo" class="info" ></div>');
		
		var retypePasswordInfo = $('#retypePasswordInfo');
		var ele = $('#retypePassword');
		var pos = ele.offset();
		
		retypePasswordInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length == 0) {
			jVal.errors = true;
				retypePasswordInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				retypePasswordInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'captchaCode' : function() {
	
		$('body').append('<div id="captchaCodeInfo" class="info" ></div>');
		
		var captchaCodeInfo = $('#captchaCodeInfo');
		var ele = $('#captchaCode');
		var pos = ele.offset();
		
		captchaCodeInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		
		if(ele.val().length == 0) {
			jVal.errors = true;
				captchaCodeInfo.removeClass('correct').addClass('error').html('&larr; Required field.').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				captchaCodeInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'sendIt' : function (){
		if(!jVal.errors) {
			$('#jform').submit();
		}
	}
};

// ====================================================== //

$('#send').click(function (){
$(window).scrollTop(0) ;
	var obj = $.browser.webkit ? $('body') : $('html');
	obj.animate({ scrollTop: $('#jform').offset().top-100 }, 750, function (){
		jVal.errors = false;
		jVal.fullName();
		jVal.gender();
		jVal.birthDate();
		jVal.country();
		jVal.phone();
		jVal.username();
		jVal.email();
		jVal.password();
		jVal.retypePassword();
		jVal.captchaCode();
		
		jVal.sendIt();
	});
	return false;
});

$('#fName').change(jVal.fullName);
$('#lName').change(jVal.fullName);
$('input[name="gender"]').change(jVal.gender);
$('#month').change(jVal.birthDate);
$('#day').change(jVal.birthDate);
$('#year').change(jVal.birthDate);
$('#country').change(jVal.country);
$('#phone').change(jVal.phone);
$('#username').change(jVal.username);
$('#email').change(jVal.email);
$('#password').change(jVal.password);
$('#retypePassword').change(jVal.retypePassword);
$('#captchaCode').change(jVal.captchaCode);





// ====================================================== //
});