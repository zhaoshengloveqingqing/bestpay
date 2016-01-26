$('#car-btn').on('click', function(e){
	var amount=$(this).attr('ks');
	var cart_amount=$(this).attr('amount');
	if(parseInt(amount)<parseInt(document.getElementById('number').value)||parseInt(cart_amount)>parseInt(amount)){
		alert('库存不足');
		return false;
	}
	$.ajax({
		type: "POST",
		url: Clips.siteUrl('cart/addCart'),
		dataType: "json",
		data: { product_id: $('#field_id').val(), number: $('#number').val()},
		success : function(data){
			if(data.success){
				alert(data.msg);
				document.location.reload();
			}else{
				alert(data.msg);
			}
		}
	});
})
