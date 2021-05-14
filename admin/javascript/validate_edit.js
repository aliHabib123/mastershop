$(document).ready(function(){
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
				nameInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				nameInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'gender' : function() {
		$('body').append('<div id="genderInfo" class="info" ></div>');
		
		var genderInfo = $('#genderInfo');
		var ele = $('#gender');
		var pos = ele.offset();
		
		genderInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+10
		});
		if((ele.val() == "" )) {
			jVal.errors = true;
				genderInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
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
				birthDateInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				eleY.removeClass('normal').addClass('wrong');
		} else {
				birthDateInfo.removeClass('error').addClass('correct').html('&radic;').show();
				eleY.removeClass('wrong').addClass('normal');
		}
	},
	
	'city' : function() {
		$('body').append('<div id="cityInfo" class="info" ></div>');
		
		var cityInfo = $('#cityInfo');
		var ele = $('#city');
		var pos = ele.offset();
		
		cityInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+20
		});
		if(ele.val() == "" ) {
			jVal.errors = true;
				cityInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');
		} else {
				cityInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'nb' : function() {
		$('body').append('<div id="nbInfo" class="info" ></div>');
		
		var nbInfo = $('#nbInfo');
		var ele = $('#nb');
		var pos = ele.offset();
		
		nbInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+20
		});
		if(ele.val() == "" ) {
			jVal.errors = true;
				nbInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');
		} else {
				nbInfo.removeClass('error').addClass('correct').html('&radic;').show();
				ele.removeClass('wrong').addClass('normal');
		}
	},
	
	'address' : function() {
		$('body').append('<div id="addressInfo" class="info" ></div>');
		
		var addressInfo = $('#addressInfo');
		var ele = $('#address_1');
		var pos = ele.offset();
		
		addressInfo.css({
			top: pos.top-0,
			left: pos.left+ele.width()+20
		});
		if(ele.val() == "" ) {
			jVal.errors = true;
				addressInfo.removeClass('correct').addClass('error').html('&larr;All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');
		} else {
				addressInfo.removeClass('error').addClass('correct').html('&radic;').show();
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
				phoneInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				phoneInfo.removeClass('error').addClass('correct').html('&radic;').show();
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
				emailInfo.removeClass('correct').addClass('error').html('&larr; All Fields Are Required').show();
				ele.removeClass('normal').addClass('wrong');				
		} else {
				emailInfo.removeClass('error').addClass('correct').html('&radic;').show();
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
		jVal.city();
		jVal.nb();
		jVal.address();
		jVal.phone();
		jVal.email();
		
		
		jVal.sendIt();
	});
	return false;
});

$('#fName').change(jVal.fullName);
$('#lName').change(jVal.fullName);
$('#gender').change(jVal.gender);
$('#month').change(jVal.birthDate);
$('#day').change(jVal.birthDate);
$('#year').change(jVal.birthDate);
$('#city').change(jVal.city);
$('#nb').change(jVal.nb);
$('#address_1').change(jVal.address);
$('#phone').change(jVal.phone);
$('#email').change(jVal.email);






// ====================================================== //
});