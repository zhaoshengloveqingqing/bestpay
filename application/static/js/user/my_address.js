$(function(){
	linkSelect('#field_province', '#field_city', '#field_area');
});

$('.address_default').on('click', function(e){
	var check=$(this).attr('mit');
	var id=$(this).attr('addid');
	if (confirm("确定要将此地址设置成默认地址吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('order/address_default/'+id),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						window.location.reload();
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


$('.edit').on('click', function(e){
	var check=$(this).attr('mit');
	var id=$(this).attr('addid');
	var kid = $(this).attr('mt');
	var mobile = $(this).attr('mobile');
	document.getElementById('checkbox').value=kid
	if(kid){
		document.getElementById("checkbox").checked=true
	}else{
		document.getElementById("checkbox").checked=false
	}

	var address = $(this).attr('address')
	var consignee = $(this).attr('consignee')
	//var mobile = $(this).attr('mobile')

	//alert(document.getElementById('default_address').value)
	document.getElementById('field_delivery_address').value=address
	document.getElementById('field_mobile').value=address
	document.getElementById('field_consignee').value=consignee
	//document.getElementById('field_mobile').value=mobile
	//document.getElementById('field_id').value=id
	document.getElementById('id').value=id
	var self = $(e.currentTarget);
	e.preventDefault();
	var province = document.getElementById("field_province").value
	var city = document.getElementById("field_city").value
	var area = document.getElementById("field_area").value
	document.getElementById("field_mobile").value =mobile

	$('#myAddress').modal('show');
	if(area) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/getCid'),
			dataType: "json",
			data: { id: $('#id').val(),
				province: province,
				city: city,
				area: area,
				checkbox: kid,
				mobile: mobile
			},
			success : function(data){
				if(data.success){
					document.location.reload();
					//alert(data.msg);
					//return false;

				}else{
					alert(data.msg);
				}

			}
		});
	}
});

$('#preserve').on('click', function(e){
	var kid =document.getElementById('checkbox').value
	if(kid){
		document.getElementById("checkbox").checked=true
	}else{
		document.getElementById("checkbox").checked=false
	}

	//alert($("#field_province option:selected").text());
	var province = document.getElementById("field_province").value
	var city = document.getElementById("field_city").value
	var area = document.getElementById("field_area").value
	if(province){
		var checkbox = 'checked';
	}else{
		var checkbox = '';
	}
	$.ajax({
		type: "POST",
		url: Clips.siteUrl('user/add_address'),
		dataType: "json",
		data: { id: $('#id').val(),
				default_address: $('#default_address').val(),
				consignee: $('#field_consignee').val(),
				mobile: $('#field_mobile').val(),
				delivery_address: $('#field_delivery_address').val(),
				province: province,
				city: city,
				area: area,
				checkbox: checkbox},
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

$('.delete').on('click', function(e){
	var id=$(this).attr('cid');
	if (confirm("确定要删除吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('order/address_delete/'+id),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						var self = $(e.currentTarget);
						self.parent().parent().remove();
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