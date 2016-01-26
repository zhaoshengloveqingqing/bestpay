	var handle = null;
var timeout = null;
var counter = 0;
//
//function onMobileValid() {
//	alert('激活码发送成功，60秒内未收到请重新获取');

function showAlertTip(tip) {
	//clearTimeout(timeout);
	//$("#alert").text(tip);
	//$("#alert").show();
	//timeout = setTimeout(function(){
	//	$("#alert").text('').hide();
	//}, 2000);
	alert(tip);
}
//
//function hideAlertTip() {
//	clearTimeout(timeout);
//	$("#alert").text('').hide();
//}
//
function count_down() {
	clearTimeout(handle);
	if(counter-- == 1) {
		//$("#alert").hide();
		$("#send").removeAttr("disabled").text("重新发送");
		counter = 60;
		return;
	}

	$("#send").text("倒计时 " + counter);
	handle = setTimeout(count_down, 1000);
}


function isMobileValid(mobile) {
	if(mobile.length==0) {
		return false;
	}
	if(mobile.length!=11) {
		return false;
	}
	return !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
}


if($('#send').length > 0) {
	var $mobile = $('#mobile');
	var $code = $('#field_validation_code');
	var $send = $('#send');

	$send.click(function(){
		var $mobileval = $mobile.val();
		if(isMobileValid($mobileval)) {
			showAlertTip('激活码发送成功，60秒内未收到请重新获取');
			counter = 60;
			$send.attr('disabled', "disabled");
			count_down();
			$.ajax({
				type: "POST",
				url: $send.attr("sendsmsurl"),
				data: { mobile: $mobileval,
						callback:'http://www.hict.cc/user/register'
				},
				dataType: "jsonp",
				jsonp: "callbackparam",
				jsonpCallback:"success_jsonpCallback",
				success : function(data){
					console.log(data);
					if(data.success){
						$code.data('code', data.msg);
					}else{
						//showTip(data.msg);
						$send.removeAttr("disabled").text("重新发送");
						clearTimeout(handle);
					}
					$send.attr("disabled", "disabled");
				}
			});
		}
		else {
			showAlertTip('请输入正确的手机号');
		}
	})

	$code.on('keyup', function(e){
		var self = $(this);
		if($code.data('code') && $code.data('code') != '') {
			if($code.data('code') == self.val()) {
				$('#submit').removeAttr('disabled');
			}
		}
	});

	//$('#submit:not([disbaled])').on('click', function(){
	//	var mobile =document.getElementById("mobile").value;
	//	var code= document.getElementById("field_validation_code").value;
	//	console.log($("#sns_login_form"));
	//	$("#sns_login_form").submit();
	//});
}