function validate() {
	var pw1 = document.getElementById("field_password").value;
	var pw2 = document.getElementById("field_password_confirm").value;
	if(pw1 == pw2) {
		document.getElementById("tishi").innerHTML="<font color='green'>两次密码相同</font>";
		document.getElementById("submit").disabled = false;
	}
	else {
		document.getElementById("tishi").innerHTML="<font color='red'>两次密码不相同</font>";
		document.getElementById("submit").disabled = true;
	}
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

$('.submit').on('click', function(e){
	var mobile = document.getElementById('field_mobile').value;
	if(isMobileValid(mobile)){
		return true;
	}else{
		alert('手机号不正确');
		return false;
	}
});

$('.submit').on('click', function(e){
	var username = document.getElementById('field_username').value;
	var mobile = document.getElementById('field_mobile').value;
	if(username=='用户名'){
		alert('用户名不能为空');
		return false;
	}

	$.ajax({
		type: "POST",
		url: 'http://user.pinet.co/api/account_exists',
		dataType: "jsonp",
		jsonp: "callbackparam",
		jsonpCallback:"success_jsonpCallback",
		data: { username: username,
				mobile: mobile
		},
		success : function(data){
			if(data.success){
				alert('用户名或者手机号已经存在');
				return false;
			}else{
				return true;
			}
		}
	});
})

$('#field_password,#field_password_confirm').val('');
//$('#field_username').on('click', function(e){
//	var code=document.getElementById("field_username").value;
//	alert(1)
//})


