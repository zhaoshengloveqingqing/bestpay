//var data = [{
//	itemId: 1,
//	img: '/images/list1.jpg',
//	name: 'Meet and greet with Bill Murray',
//	desc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
//	price: 19.95,
//	number: 1
//},{
//	itemId: 2,
//	img: '/images/list2.jpeg',
//	name: 'Meet and greet with Bill Murray',
//	desc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
//	price: 19.95,
//	number: 1
//}];
//
//data = JSON.stringify(data);
var confirmCart = {};
confirmCart.totalPrice = 0;

function calcProductPrice(productPrice, number) {
	return parseFloat(( parseFloat(productPrice) * parseFloat(number) ).toFixed(2));
}

function setTotalPrice(price) {
	var price = Math.abs(price.toFixed(2));
	$('#order').find('.cart-totals .cart-totals-value .price').text(price);
	$('#order').find('.total input[name=total]').val(price);
}

function setListTotalPrice(list) {
	$(list.sel).find('.total .cart-totals-value .price').text(parseFloat(list.totalPrice).toFixed(2));
}

function calcSinglePrice($currentListItem) {
	return  parseFloat($currentListItem.data('price'));
}

function calcNumber($currentListItem) {
	return parseInt($currentListItem.data('number'));
}

function setSpinnerPlugin(list,onRemoveCallback) {
	var items = list.items;
	if(items.length > 0) {
		$(items).each(function(k, v){
			var $currentListItem = v.value;
			var itemData = $currentListItem.data('itemData');
			var $spinner = $currentListItem.find('.spinner');
			var $productSinglePrice = $currentListItem.find('[control=cart-product-single-price] .price');
			var singlePrice = calcSinglePrice($currentListItem);
			$spinner.spinner({min: 1})
					.spinner('delay', 0)
					.spinner('changed', function(e, newVal, oldVal) {
						if(newVal == 0) {
							confirmCart.totalPrice = confirmCart.totalPrice - singlePrice;
							list.totalPrice = list.totalPrice - singlePrice;
							setListTotalPrice(list);
							setTotalPrice(confirmCart.totalPrice);
							list.removeProduct(v.key);
							if($.isFunction(onRemoveCallback)) {
								onRemoveCallback();
							}
						}
						else {
							var currentPrice = calcProductPrice(singlePrice, newVal);
							$currentListItem.data('currentPrice', currentPrice);
							if(newVal > oldVal) {
								confirmCart.totalPrice = confirmCart.totalPrice + singlePrice;
								list.totalPrice = list.totalPrice + singlePrice;
							}
							else {
								confirmCart.totalPrice = confirmCart.totalPrice - singlePrice;
								list.totalPrice = list.totalPrice - singlePrice;
							}
							setListTotalPrice(list);
							setTotalPrice(confirmCart.totalPrice);
							$currentListItem.find('[control=cart-product-total-price] .price').text(currentPrice);
						}
					})
		});
	}
}

function setRemovePlugin(list, callback) {
	var items = list.items;
	if(items.length > 0) {
		$(items).each(function(k, v){
			var $currentListItem = v.value;
			var itemData = $currentListItem.data('itemData');
			$currentListItem.find('.cart-product-remove').on('click', function(e){
				var r=confirm("是否确定删除？");
				if(r==false){
					return;
				}
				var currentPrice = $currentListItem.data('currentPrice');
				list.removeProduct(v.key, function(){
					if($.isFunction(callback)) {
						callback($currentListItem);
					}
				});
				confirmCart.totalPrice = confirmCart.totalPrice - currentPrice;
				list.totalPrice = list.totalPrice - currentPrice;
				setListTotalPrice(list);
				setTotalPrice(confirmCart.totalPrice);
			});
		});
	}
}

function setTotalPricePlugin(list) {
	var items = list.items;
	list.totalPrice = 0;
	if(items.length > 0 ) {
		$(items).each(function(k, v){
			var $currentListItem = v.value;
			var itemData = $currentListItem.data('itemData');
			var productPrice = calcProductPrice(calcSinglePrice($currentListItem), calcNumber($currentListItem));
			$currentListItem.data('currentPrice', productPrice);
			list.totalPrice += productPrice;
			confirmCart.totalPrice += productPrice;
			$currentListItem.find('[control=cart-product-total-price] .price').text(productPrice);
		});
	}
	setListTotalPrice(list);
	setTotalPrice(confirmCart.totalPrice);
}

var ProductList = function ProductList(sel) {
	this.sel = sel;
	this.source = $(this.sel).find('[type="text/x-handlebars-template"]').html();
	this.items = [];
	this.init();
};

ProductList.prototype.init = function () {
	var self = this;
	self.template = Handlebars.compile(self.source);
	self.totalPrice = 0;
};

ProductList.prototype.render = function(data, callback) {
	var self = this;
	if($.isArray(data)) {
		$.each(data, function(i, item){
			var html = self.template(item);
			$(self.sel).append(html);
			$currentListItem = $(self.sel).find('#shopping-cart--list-item'+item.itemId);
			$currentListItem.data('itemData', item);
			self.items.push({key: item.itemId, value: $currentListItem});
		});
		self.data = data;
		callback(self);
	}
};

ProductList.prototype.removeProduct = function (itemId, callback) {
	var self = this;
	if($.isFunction(callback)) {
		callback();
	}
	if(self.items.length > 0) {
		$(self.items).each(function(k, v){
			if(v.key == itemId) {
				self.items.splice(k, 1);
			}
		});
	}

	$(self.sel).find('#shopping-cart--list-item'+itemId).remove();
};


$('#dizhi').on('click', 'li input', function(e){
	var self = $(e.currentTarget);
	$('#dizhi > li').removeClass('active');
	self.parent().addClass('active');
});

$('#dizhi').on('click', 'li .address_default', function (e) {
	var id=$(this).attr('mid');
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


$('.delete').on('click', function(e){
	var id=$(this).attr('delete');
	var checkbox =$(this).attr('checkbox');
	if(checkbox!=''){
		alert("默认地址不能删除");
	}else{
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
	}


});

$('#dizhi').on('click', 'li .edit', function (e) {
	var consignee = $(this).attr('consignee')
	var mobile = document.getElementById("mobile").value
	var id=$(this).attr('mt');
	var checkbox = $(this).attr('checkbox');
	var cid = $(this).attr('cid')
	$('#hello').html('修改收货地址')
	if(checkbox){
		document.getElementById("default_address").checked=true
	}
	var address = $(this).attr('address')
	//alert(document.getElementById('default_address').value)
	document.getElementById('field_delivery_address').value=address
	document.getElementById('field_id').value=id
	document.getElementById("field_mobile").value=mobile
	document.getElementById("field_consignee").value=consignee

	var province = $(this).attr('province')
	var city = $(this).attr('city')
	var area = $(this).attr('area')
	//alert(province)
	//alert(city)
	//alert(area)
	//$("#field_province option[value='1']").attr("selected","selected");
	var self = $(e.currentTarget);
	e.preventDefault();
	$('#myAddress').modal('show');
	$('#myAddress').on('shown.bs.modal', function(){
		$.linkselect.selectOptionWithIndex('#field_province', province);
		$('#field_city').on('selecthasdata', function(){
			$.linkselect.selectOptionWithIndex('#field_city', city);
		});
		$('#field_area').on('selecthasdata', function(){
			$.linkselect.selectOptionWithIndex('#field_area', area);
		});
	});
	if(area) {
		$.ajax({
			type: "POST",
			url: Clips.siteUrl('order/getCid'),
			dataType: "json",
			data: { id: cid,
				province: province,
				city: city,
				area: area,
				checkbox: checkbox,
				mobile: mobile
			},
			success : function(data){
				if(data.success){
					var self = $(e.currentTarget);
					e.preventDefault();
					$('#myAddress').modal('show');
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


var selectValue = 'checked';
$("li input[name='radio'][rid='"+selectValue+"']").attr("checked","checked");


//$('#dizhi').find('li:eq(0)').addClass('active');
//$('#dizhi > li.active input').prop('checked', true);
//$(":checkbox[value='"+selectValue+"']").attr('checked',true);
//$("input[type='checkbox'][name='default_address'][value="+selectValue+"]").attr("checked","checked");;
//document.getElementById("default_address").checked=true
$('#dizhi').on('click', 'li .radio', function (e) {
	var province =$(this).attr('pro');
	var city =$(this).attr('city');
	var area =$(this).attr('area');
	var consignee =$(this).attr('consignee');
	var mobile =$(this).attr('mobile');
	var id=$(this).attr('value');
	var check = $(this).attr('kid');
	var rko = $(this).attr('rko');
	var address=$(this).attr('address');
	$("#get_address").html(province.concat(city,area,address));
	$("#consignee").html(consignee.concat(mobile));


});



$('#address .myaddress').on('click', function(e){
	$('#hello').html('新增收货地址')
	var address=$(this).attr('id');
	if(address){
		document.getElementById('field_delivery_address').value=''
		document.getElementById('field_mobile').value=''
		document.getElementById('field_id').value=''
		document.getElementById('field_consignee').value=''
		$('#myAddress').on('shown.bs.modal', function(){
			$.linkselect.selectOptionWithIndex('#field_province', 16);
			$('#field_city').on('selecthasdata', function(){
				$.linkselect.selectOptionWithIndex('#field_city', 221);
			});
			$('#field_area').on('selecthasdata', function(){
				$.linkselect.selectOptionWithIndex('#field_area', 1853);
			});
		});
	}

	e.preventDefault();
	$('#myAddress').modal('show');
});


$(function(){
	linkSelect('#field_province', '#field_city', '#field_area');
});

$('#submit').on('click', function(e){
		var kucun = false;
		$('.confirmCart-list-item').each(function(v){
			$acount = $(this).attr('amount-number');
			$real_number = $(this).find('.cart-product-qty').val();
			if(parseInt($real_number)>parseInt($acount)) {
				kucun = true;
				return false;
			}
		});
	if(kucun) {
		alert('库存不足');
		return false;
	}
	//var amount= $(this).attr('amount');
	//var number =document.getElementById('number').value;
	//if(parseInt(amount)<parseInt(number)){
	//	alert('库存不足');
	//	return false;
	//}
	var field_distribution_way=document.getElementById('field_distribution_way').value;
	var temp = document.getElementsByName("radio");
	for(var i=0;i<temp.length;i++)
	{
		if(temp[i].checked)
			var intHot = temp[i].value;
	}

	var flag = 0;
	$('.confirmCart-list-item').each(function(){
		if($(this).attr('iscoupon')==1) {
			flag += 1;
		}
	});
	//alert(flag)
	if(flag>0) {//如果购物车中包含商品，则需填写地址和配送方式
		if($(this).attr('default')==''){

			if(field_distribution_way=='=请选择='){
				alert('请选择配送方式');
				return false;
			}else{
				if(intHot) {
					if(field_distribution_way=='=请选择='){
						alert('请选择配送方式');
						return false;
					}else{
						return true;
					}
				}
				else{
					alert("请选择收货地址");
					return false;
				}
			}

		}else{
			alert('请添加收货地址');
			return false;
		}
		//var radio =document.getElementById('radio').getAttribute("value");
		if(intHot) {
			if(field_deliver_way=='=请选择='){
				alert('请选择配送方式');
				return false;
			}else{
				return true;
			}
		}
		else{
			alert("请选择收货地址");
			return false;
		}

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
}
$('#confirm').on('click', function(e){
	var mobile = document.getElementById('field_mobile').value;
	if(checkMobile(mobile)){
		return true;
	}else{
		alert('手机号不正确');
		return false;
	}
});