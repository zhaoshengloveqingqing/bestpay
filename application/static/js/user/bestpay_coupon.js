//$('.delete').on('click', function(e){
//		$(this).parent().parent().remove();
//});

$(function(){

	if($("#myTab").length > 0) {
		var activeindex = $("#myTab").attr("activeindex");

		$('#tab0').on('click', function(e){
			var dts=$(this).attr('dts');
			$('#myTab li').eq(0).addClass('active');
		});
		$('#tab1').on('click', function(e){
			var dts=$(this).attr('dts');
			$('#myTab li').eq(1).addClass('active');
		});
		$('#tab2').on('click', function(e){
			var dts=$(this).attr('dts');
			$('#myTab li').eq(2).addClass('active');


		});
		$('#tab3').on('click', function(e){
			var dts=$(this).attr('dts');
			$('#myTab li').eq(3).addClass('active');

		});
		console.log(activeindex);
		//$('#myTab li').eq(3).addClass('active');

	}
	//$('a[id="tab"]').click(function(){
	//	$("#myTab").attr('activeindex',$(this).attr('dts'));
	//
	//})
});


$('.cancel').on('click', function(e){
	var id=$(this).attr('value');
	document.getElementById('id').value=id
	if (confirm("确定要取消此订单吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('user/orders/'+id),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						var self = $(e.currentTarget);
						self.parent().parent().remove();
						alert('订单取消成功');
					}else{
						alert(data.msg);
					}
				}
			});
		}
	}else{
		return false;
	}
	//alert(document.getElementById("cancel").getAttribute("value"))
	e.preventDefault();
	$('#dialog').modal('show');
});


$('.c_delete').on('click', function(e){
	var id=$(this).attr('value');
	if (confirm("确定要删除吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('order/deleteOrder/'+id+'/coupon'),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						document.location.reload();
						//var self = $(e.currentTarget);
						//self.parent().parent().parent().parent().remove();
					}else{
						alert(data.msg);
					}
				}
			});
		}
	}else{
		return false;
	}

});



$('.code').on('click', function(e){
	var code=$(this).attr('code');
	alert(code);
});


$('#ALL').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupon?status='+status),
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


$('#NOPAY').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupon?status='+status),
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

$('#NOUSE').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupon?status='+status),
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

$('#USE').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupon?status='+status),
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

$('#EXPIRED').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_coupon?status='+status),
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

$('.cancel').on('click', function(e){
	var id=$(this).attr('value');
	document.getElementById('id').value=id
	if (confirm("确定取消此订单吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('user/orders/'+id),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						var self = $(e.currentTarget);
						self.parent().parent().remove();
						alert('订单取消成功');
					}else{
						alert(data.msg);
					}
				}
			});
		}
	}else{
		return false;
	}
	//alert(document.getElementById("cancel").getAttribute("value"))
	e.preventDefault();
	$('#dialog').modal('show');
});

$('#close').on('click', function(e){
	e.preventDefault();
	$('#dialog').modal('hide');
});