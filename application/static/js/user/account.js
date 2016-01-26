//$('.edit').on('click', function(e){
//	alert(1)
//	var id=$(this).attr('cid');
//	alert(id)
//	if (confirm("确定要删除吗？")){
//		if(true) {
//			$.ajax({
//				type: "POST",
//				url: Clips.siteUrl('order/address_delete/'+id),
//				dataType: "json",
//				success : function(data){
//					if(data.success){
//						alert(data.msg);
//						var self = $(e.currentTarget);
//						self.parent().parent().remove();
//					}else{
//						alert(data.msg);
//					}
//				}
//			});
//		}
//	}else{
//		return false;
//	}
//});


$('.email_edit').on('click', function(e){
	var id=$(this).attr('id');
	document.getElementById('field_email').value
	e.preventDefault();
	$('#myemail').modal('show');
	//$.ajax({
	//	type: "POST",
	//	url: Clips.siteUrl('user/account_edit'),
	//	dataType: "json",
	//	data: { id: id,
	//		email: $('#field_email').val()
	//	},
	//	success : function(data){
	//		if(data.success){
	//			alert(data.msg);
	//			document.location.reload();
	//		}else{
	//			alert(data.msg);
	//		}
	//	}
	//});

});

function
checkEmail(str){
	var re = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
	if(re.test(str)){
		return true;
	}else{
		return false
	}
}

$('#preserve').on('click', function(e){
	var id=$(this).attr('cid');
	var email=document.getElementById('field_email').value;
	e.preventDefault();
	$('#myemail').modal('show');
	if(checkEmail(email)) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/account_edit'),
			dataType: "json",
			data: {
				id: id,
				email: $('#field_email').val()
			},
			success: function (data) {
				if (data.success) {
					alert(data.msg);
					document.location.reload();
				} else {
					alert(data.msg);
				}
			}
		});
	}else{
		showAlertTip('请输入正确的邮箱');
	}

})


$('.phone_edit').on('click', function(e){
	//var id=$(this).attr('mt');
	//alert(id)
	e.preventDefault();
	$('#myphone').modal('show');
});







var handle = null;
var timeout = null;
var counter = 0;


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
		$("#code").removeAttr("disabled").text("重新发送");
		counter = 60;
		return;
	}

	$("#code").text("倒计时 " + counter);
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

$(function(){
	if($('#code').length > 0) {
		var $mobile = $('#field_mobile');
		var $code = $('#field_validation');
		var $send = $('#code');

		$send.click(function(){
			var $mobileval = $mobile.val();
			if(isMobileValid($mobileval)) {
				showAlertTip('激活码发送成功，60秒内未收到请重新获取');
				counter = 60;
				$send.attr('disabled', "disabled");
				count_down();
				console.log($send.attr("sendsmsurl"));
				$.ajax({
					type: "POST",
					url: $send.attr("sendsmsurl"),
					data: { mobile: $mobileval },
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
		});
		$code.on('keyup', function(e){
			var self = $(this);
			if($code.data('code') && $code.data('code') != '') {
				if($code.data('code') == self.val()) {
					$('#validationsubmit').removeAttr('disabled');
				}
			}
		});
	}
});
