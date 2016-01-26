//$('.listview.clips-listview').on('list.beforeDraw', function(e, list, data){
//	$.each(data.data, function(i, item){
//		var d = new Date(new Date().getTime());
//		var time = d.getFullYear()+"-0"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
//
//		item.itemId = item.orders_id;
//
//		var message = {
//			orders_status: 'yi fu kuang'
//		};
//
//		if(Clips.lang) {
//			$.each(message, function(k, v){
//				message[k] = Clips.lang.message(v);
//			});
//		}
//
//		if(item.orders_status=='ACTIVE'){
//			item.orders_status = message.orders_status;
//			item.delete='<a href="###" list-for="delete" >' + Clips.lang.message("Delete") + '</a>';
//			item.continue_pay = '';
//			item.refund='';
//			item.coupon ='';
//		}
//		if(item.orders_status=='DELETE'){
//			item.orders_status="已删除";
//			item.delete="";
//			item.continue_pay = '';
//			item.refund='';
//			item.coupon ='';
//		}
//
//		if(item.orders_status =='PAY' && item.products_category_id=='2' && item.customer_products_status=="USED"){
//			item.orders_status="已使用";
//			item.continue_pay = '';
//			item.usercancel="";
//			item.receive = '';
//			item.coupon = '<a class="code" list-for="coupon">' + Clips.lang.message("CouponNumber") + '</a>';
//			item.details="";
//			item.refund = '';
//			item.delete='';
//		}
//
//		if(item.orders_status =='PAY'  && item.products_category_id=='1'){
//			item.orders_status = Clips.lang.message("PAY");
//			item.details="";
//			item.usercancel="";
//			item.coupon = '';
//			item.continue_pay = '';
//			item.refund = "";
//			item.delete='<a href="###" list-for="delete" >' + Clips.lang.message("Delete") + '</a>';
//			item.receive = '';
//
//		}
//
//		if(item.orders_status =='PAY'  && item.products_category_id=='2'){
//			item.orders_status = Clips.lang.message("PAY");
//			item.details="";
//			item.continue_pay = '';
//			item.usercancel="";
//			item.coupon = '<a class="code" list-for="coupon">' + Clips.lang.message("CouponNumber") + '</a>';
//			item.refund = '';
//			item.delete = ""
//			item.receive = '';
//		}
//
//		if(item.orders_status=='USED' && item.products_category_id=='2'){
//			item.details="";
//			item.refund = "";
//			item.coupon = "";
//			item.delete='<a href="###" >' +Clips.lang.message("Delete") + '</a>';
//		}
//
//		if(item.orders_status=='NOPAY'){
//			item.orders_status = Clips.lang.message("NOPAY");
//			item.details = Clips.lang.message("Details");
//			item.details="";
//			item.continue_pay = '<a href="../order/pay/' + item.orders_id+ '">' +Clips.lang.message("TOPAY") + '</a>';
//			item.delete='<a class="pay" list-for="delete" >' +Clips.lang.message("Delete") + '</a>';
//			//item.usercancel = '<a href="../order/user_cancel/'+item.orders_id+'" >' + Clips.lang.message("UserCancel") + '</a>';
//			item.usercancel='<a href="###" list-for="usercancel" >' + Clips.lang.message("UserCancel") + '</a>';
//			item.coupon = '';
//			item.refund = '';
//			item.receive = '';
//		}
//		if(item.orders_status=='Assigned'){
//			item.orders_status = Clips.lang.message("Assigned");
//			item.details="";
//			item.usercancel = "";
//			item.continue_pay = "";
//			item.delete="";
//			item.coupon = '';
//			item.refund = '';
//			item.receive= '<a href="../order/receive/' + item.orders_id+ '">' +Clips.lang.message("Receive") + '</a>';
//		}
//		if(item.orders_status=='Received'){
//			item.orders_status = Clips.lang.message("Received");
//			item.details="";
//			item.delete='<a class="pay" list-for="delete" >' +Clips.lang.message("Delete") + '</a>';
//			item.usercancel="";
//			item.continue_pay = "";
//			item.coupon = '';
//			item.refund = '';
//			item.receive= "";
//		}
//		if(item.orders_status=='UserCancelled'){
//			item.orders_status = Clips.lang.message("UserCancelled");
//			item.details="";
//			item.delete='<a class="pay" list-for="delete" >' +Clips.lang.message("Delete") + '</a>';
//			item.usercancel= "";
//			item.continue_pay = "";
//			item.coupon = '';
//			item.refund = '';
//			item.receive="";
//		}
//		if(item.orders_status=='MerCancelled'){
//			item.orders_status = Clips.lang.message("MerCancelled");
//			item.usercancel= Clips.lang.message("MerCancelled");
//			item.continue_pay = "";
//			item.delete="";
//			item.coupon = '';
//			item.refund = '';
//			item.receive="";
//			item.details="";
//		}
//		if(item.orders_status=='Distributed'){
//			item.orders_status = Clips.lang.message("Distributed");
//			item.details="";
//			item.usercancel="";
//			item.continue_pay = "";
//			item.delete="";
//			item.coupon = '';
//			item.refund = '';
//			item.receive="";
//		}
//	});
//});

$('.listview.clips-listview').on('list.loaded', function(e, list, data){
	if(!list.refresh) {
		// get all listview item
		var items = list.children('.listview_item').not('.listview_item_template');
		var $modal = $("#myModal");
		var $couponmodal = $("#myModal1");
		var $usercancelmodal = $("#myModal2");

		items.each(function(i){
			var item = $(this);
			var listitemdata = item.data('itemdata');
			item.find('.refund').on('click', function(){
				alert('This is Developping');
			});

		});
		list.on('click', '[list-for="usercancel"]', function(e){
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

			$usercancelmodal.attr('itemid', itemId);
			$usercancelmodal.data('current_data', current_data);
			$usercancelmodal.modal('show');
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

		function usercancelHandler(e) {
			var self = $(this);
			var data = $usercancelmodal.data('current_data');
			var itemId = self.attr('itemid');
			if(data.orders_id && data.orders_id != '') {
				$.ajax({
					type: "POST",
					url: Clips.siteUrl('order/user_cancel/' + data.orders_id),
					dataType: "json",
					success : function(data){
						$usercancelmodal.modal('hide');
						list.data('api').refresh(list);
					}
				});
			}
		}

		$usercancelmodal.find(".btn-usercancel").on('click', usercancelHandler);

		// couponmodal route
		$couponmodal.on('show.bs.modal', function(e){
			var self = $(this);
			var current_data = self.data('current_data');
			close
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


$('.cancel').on('click', function(e){
	var id=$(this).attr('value');
	document.getElementById('id').value=id
	document.getElementById('status').value='UserCancelled'
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/cancel_order/'+id),
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
	//alert(document.getElementById("cancel").getAttribute("value"))
	e.preventDefault();
	$('#dialog').modal('show');
});

$('.confirm').on('click', function(e){
	var id=$(this).attr('ht');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/confirm_order/'+id),
			dataType: "json",
			data: { id: id
			},
			success : function(data){
				if(data.success){
					alert('订单确认成功');
					document.location.reload();
				}else{
					alert(data.msg);
				}
			}
		});
	}
});
$('#canceldown').on('click', function(e){
	//var id=$(this).attr('mt');
	//alert(id)
	e.preventDefault();
	$('#dialog').modal('show');
});

$('#close').on('click', function(e){
	e.preventDefault();
	$('#dialog').modal('hide');
});

//$('.delete').on('click', function(e){
//	$(this).parent().parent().parent().parent().parent().remove();
//})

$('.delete').on('click', function(e){
	var id=$(this).attr('value');
	if (confirm("确定要删除吗？")){
		if(true) {
			$.ajax({
				type: "POST",
				url: Clips.siteUrl('order/deleteOrder/'+id+'/product'),
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




$('#myTab').on('click', 'li', function(e){
	//alert(1);
	$(this).addClass("active").siblings().removeClass("active");
	//var self = $(e.currentTarget);
	//$('#dizhi > li').removeClass('active');
	//self.parent().addClass('active');


});

$('#ALL').on('click', function(e){
	var status=$(this).attr('status');
	if(true) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('user/search_orders?status='+status),
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
			url: Clips.siteUrl('user/search_orders?status='+status),
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
			url: Clips.siteUrl('user/search_orders?status='+status),
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
			url: Clips.siteUrl('user/search_orders?status='+status),
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
			url: Clips.siteUrl('user/search_orders?status='+status),
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


function getParameter(){
//拓展
laypage.demo = function(options){
	var view = $('#'+options.view), grunps = options.grunps;
	var table = view.children('table'), len = table.length, data = [];
	for(var i = 1; i <= table.length; i++){
		var item = Math.ceil(i/grunps)-1;
		typeof data[item] === 'undefined' ?
				data[item] = [table[i-1]] :
				data[item].push(table[i-1]);
		item = null;
	}
	return laypage({
		cont: options.cont,
		pages: Math.ceil(len/grunps),
		grunps: grunps,
		jump: function(obj){
			options.jump(data[obj.curr-1], view)
		}
	})
};

//调用
laypage.demo({
	view: 'orders_list',
	cont: 'pages',
	grunps: 1,
	jump: function(html, view){
		view.html(html);
	}
});

}
