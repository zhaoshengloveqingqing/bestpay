$('#Distribution').on('click',function(e){
	var select = document.getElementById('field_merchant_name').value;
	if(select=='=请选择要分配的商家='){
		alert(select);
		return false;
	}
	return true;

});