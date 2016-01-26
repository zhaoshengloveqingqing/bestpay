$('#cash_coupon').on('click',function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupons?status='+status),
			dataType: "json",
			success : function(data){
				if(data.success){
					//alert(data.msg);
					document.location.reload();
				}else{
					alert(data.msg);
				}
			}
		});
	}
});

$('#discount_coupon').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupons?status='+status),
			dataType: "json",
			success : function(data){
				if(data.success){
					//alert(data.msg);
					document.location.reload();
				}else{
					alert(data.msg);
				}
			}
		});
	}
});

$('#general_coupon').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupons?status='+status),
			dataType: "json",
			success : function(data){
				if(data.success){
					//alert(data.msg);
					document.location.reload();
				}else{
					alert(data.msg);
				}
			}
		});
	}
});