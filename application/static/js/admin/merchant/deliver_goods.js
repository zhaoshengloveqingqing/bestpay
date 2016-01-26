$('#Distribution').on('click',function(e){
	var select = document.getElementById('field_merchant_name').value;
	if(select=='=请选择要分配的商家='){
		alert(select);
		return false;
	}
	return true;

});

$('#Delivery').on('click',function(e){
	var mobile = document.getElementById('field_distribution_phone').value;
	var distribution_company = document.getElementById('field_distribution_company').value;
	if(distribution_company=="配送公司/快递员"){
		alert('请输入配送公司/快递员信息！');
		return false;
	}
	if(checkMobile(mobile)){
		return true;
	}else{
		alert('手机号不正确');
		return false;
	}
});

function checkMobile(mobile) {
	if(mobile.length==0) {
		return false;
	}
	if(mobile.length!=11) {
		return false;
	}
	return !!mobile.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/);
};

