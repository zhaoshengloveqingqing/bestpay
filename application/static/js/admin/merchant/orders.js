$('.listview.clips-listview').on('list.beforeDraw', function(e, list, data){
	$.each(data.data, function(i, item){
		var d = new Date(new Date().getTime());
		var time = d.getFullYear()+"-0"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();

		item.itemId = item.orders_id;

		var message = {
			orders_status: 'yi fu kuang'
		};

		if(Clips.lang) {
			$.each(message, function(k, v){
				message[k] = Clips.lang.message(v);
			});
		}

		if(item.orders_status=='ACTIVE'){
			item.orders_status = message.orders_status;
			item.delete='<a href="###" list-for="delete" >' + Clips.lang.message("Delete") + '</a>';
			item.continue_pay = '';
			item.refund='';
			item.coupon ='';
		}
		if(item.orders_status=='DELETE'){
			item.orders_status="已删除";
			item.delete="";
			item.continue_pay = '';
			item.refund='';
			item.coupon ='';
		}

		if(item.orders_status =='PAY' && item.products_category_id=='2' && item.customer_products_status=="USED"){
			item.orders_status="已使用";
			item.continue_pay = '';
			item.coupon = '<a class="code" list-for="coupon">' + Clips.lang.message("CouponNumber") + '</a>';
			item.refund = '';
			item.delete='';
		}

		if(item.orders_status =='PAY'  && item.products_category_id=='1'){
			item.deliver='<a href="../merchant/deliver_goods/'+item.orders_id+'">' +Clips.lang.message("Deliver") + '</a>';
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution='<a href="../merchant/order_distribute/'+item.orders_id+'">' +Clips.lang.message("Distribution") + '</a>';
			item.merchantcancel="";
			item.orders_status = Clips.lang.message("PAY");
			item.coupon = '';
			item.continue_pay = '';
			item.refund = "";
			item.delete='<a href="###" list-for="delete" >' + Clips.lang.message("Delete") + '</a>';
		}

		if(item.orders_status =='PAY'  && item.products_category_id=='2'){
			item.deliver='<a href="../merchant/deliver_goods/'+item.orders_id+'">' +Clips.lang.message("Deliver") + '</a>';
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution='<a href="###" >' +Clips.lang.message("Distribution") + '</a>';
			item.merchantcancel="";
			item.orders_status = Clips.lang.message("PAY");
			item.continue_pay = '';
			item.coupon = '<a class="code" list-for="coupon">' + Clips.lang.message("CouponNumber") + '</a>';
			item.refund = '';
			item.delete = ""
		}

		if(item.orders_status=='USED' && item.products_category_id=='2'){
			item.refund = "";
			item.coupon = "";
			item.delete='<a href="###" >' +Clips.lang.message("Delete") + '</a>';
		}

		if(item.orders_status=='NOPAY'){
			item.orders_status = Clips.lang.message("NOPAY");
			item.deliver='';
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			//item.merchantcancel='<a href="../merchant/merchant_cancel/'+item.orders_id+'">' +Clips.lang.message("MerCancel") + '</a>';
			item.merchantcancel='<a href="###" list-for="merchantcancel" >' + Clips.lang.message("MerCancel") + '</a>';
			item.coupon = '';
			item.refund = '';
			item.distribution="";
		}
		if(item.orders_status=='Assigned'){
			item.orders_status = Clips.lang.message("Assigned");
			item.deliver="";
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.merchantcancel="";
			item.distribution='';
			item.coupon = '';
			item.refund = '';
		}
		if(item.orders_status=='Received'){
			item.orders_status = Clips.lang.message("Received");
			item.deliver="";
			item.merchantcancel="";
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution='';
			item.coupon = '';
			item.refund = '';
		}
		if(item.orders_status=='UserCancelled'){
			item.orders_status = Clips.lang.message("UserCancelled");
			item.merchantcancel="";
			item.deliver="";
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution="";
			item.coupon = '';
			item.refund = '';
		}

		if(item.orders_status=='MerCancelled'){
			item.orders_status = Clips.lang.message("MerCancelled");
			item.deliver="";
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution='';
			item.coupon = '';
			item.refund = '';
			item.merchantcancel="";
		}

		if(item.orders_status=='Distributed' && item.orders_mid!=null){
			item.orders_status = Clips.lang.message("Distributed");
			item.deliver='<a href="../merchant/deliver_goods/'+item.orders_id+'">' +Clips.lang.message("Deliver") + '</a>';
			item.details = '<a href="../../admin/merchant/order_details/' + item.orders_id+ '">' +Clips.lang.message("Details") + '</a>';
			item.distribution='';
			item.coupon = '';
			item.refund = '';
			item.merchantcancel="";
		}

	});
});

$('.listview.clips-listview').on('list.loaded', function(e, list, data){
	if(!list.refresh) {
		// get all listview item
		var items = list.children('.listview_item').not('.listview_item_template');
		var $modal = $("#myModal");
		var $couponmodal = $("#myModal1");
		var $mercancelmodal = $("#myModal2");

		items.each(function(i){
			var item = $(this);
			var listitemdata = item.data('itemdata');
			item.find('.refund').on('click', function(){
				alert('This is Developping');
			});

		});
		list.on('click', '[list-for="delete"]', function(e){
			e.preventDefault();
			var self = $(e.currentTarget);
			var item = self.parentsUntil('.item').parent();
			var itemdata = item.data('itemdata');
			var itemId = item.attr('itemid');

			var current_data = {
				type: 'delete',
				orders_id: itemdata.orders_id,
				orders_order_number: itemdata.orders_order_number
			};

			$modal.attr('itemid', itemId);
			$modal.data('current_data', current_data);
			$modal.modal('show');
		});

		list.on('click', '[list-for="merchantcancel"]', function(e){
			e.preventDefault();
			var self = $(e.currentTarget);
			var item = self.parentsUntil('.item').parent();
			var itemdata = item.data('itemdata');
			var itemId = item.attr('itemid');

			var current_data = {
				type: 'delete',
				orders_id: itemdata.orders_id,
				orders_order_number: itemdata.orders_order_number
			};

			$mercancelmodal.attr('itemid', itemId);
			$mercancelmodal.data('current_data', current_data);
			$mercancelmodal.modal('show');
		});

		list.on('click', '[list-for="coupon"]', function(e){
			var self = $(e.currentTarget);
			var item = self.parentsUntil('.item').parent();
			var itemdata = item.data('itemdata');
			var itemId = item.attr('itemid');

			var current_data = {
				type: 'coupon',
				orders_id: itemdata.orders_id,
				customer_products_code: itemdata.customer_products_code
			};

			$couponmodal.attr('itemid', itemId);
			$couponmodal.data('current_data', current_data);
			$couponmodal.modal('show');
		});

		// on modal show
		$modal.on('show.bs.modal', function(e){
			var self = $(this);
			var current_data = self.data('current_data');

			if(current_data.type == 'delete') {
				$modal.trigger('delete.bs.modal', [current_data]);
			}
		});

		$modal.on('show.bs.modal', function(e){
			var self = $(this);
			var current_data = self.data('current_data');

			if(current_data.type == 'coupon') {
				$modal.trigger('coupon.bs.modal', [current_data]);
			}
		});

		// on modal hidden
		$modal.on('hidden.bs.modal', function (e) {
			var self = $(this);
			var itemId = self.attr('itemid');
		});

		function deleteHandler(e) {
			var self = $(this);
			var data = $modal.data('current_data');
			var itemId = self.attr('itemid');
			if(data.orders_id && data.orders_id != '') {
				$.ajax({
					type: "POST",
					url: Clips.siteUrl('order/delete/' + data.orders_id),
					dataType: "json",
					success : function(data){
						$modal.modal('hide');
						list.data('api').refresh(list);
					}
				});
			}
		}

		$modal.find(".btn-confirm").on('click', deleteHandler);

		function mercancelHandler(e) {
			var self = $(this);
			var data = $mercancelmodal.data('current_data');
			var itemId = self.attr('itemid');
			if(data.orders_id && data.orders_id != '') {
				$.ajax({
					type: "POST",
					url: Clips.siteUrl('admin/merchant/merchant_cancel/' + data.orders_id),
					dataType: "json",
					success : function(data){
						$mercancelmodal.modal('hide');
						list.data('api').refresh(list);
					}
				});
			}
		}

		$mercancelmodal.find(".btn-mercancel").on('click', mercancelHandler);

		// couponmodal route
		$couponmodal.on('show.bs.modal', function(e){
			var self = $(this);
			var current_data = self.data('current_data');

			if(current_data.type == 'coupon') {
				$couponmodal.trigger('coupon.bs.modal', [current_data]);
			}
		});

		$couponmodal.on('coupon.bs.modal', function(e, data){
			var self = $(this);
			self.find('.modal-body').text(data.customer_products_code);
		});
	}
});


$('#close').on('click', function(e){
	e.preventDefault();
	$('#dialog').modal('hide');
});


$('#ALL').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#PAY').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#Assigned').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#Distributed').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#Received').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#UserCancelled').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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

$('#MerCancelled').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('admin/merchant/search_orders?status='+status),
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
	document.getElementById('status').value='MerCancelled'
	if (confirm("确定要取消此订单吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('admin/merchant/orders/'+id),
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


$('.delete').on('click', function(e){
	var id=$(this).attr('value');
	if (confirm("确定要删除吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('admin/merchant/deleteOrder/'+id),
				dataType: "json",
				success : function(data){
					if(data.success){
						alert(data.msg);
						var self = $(e.currentTarget);
						self.parent().parent().parent().parent().remove();
					}else{
						alert(data.msg);
					}
				}
			});
		}
	}else{
		return false;
	}

})