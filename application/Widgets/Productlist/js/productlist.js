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

function calcProductPrice(productPrice, number) {
	return parseFloat(( parseFloat(productPrice) * parseFloat(number) ).toFixed(2));
}

function setTotalPrice(price) {
	var price = Math.abs(price.toFixed(2));
	$('.shopping-cart').find('.total .cart-totals-value .price').text(price);
	$('.shopping-cart').find('.total input[name=total]').val(price);
}

function setSpinnerPlugin(list) {
	var items = list.items;
	items.forEach(function(value, key, map){
		var $currentListItem = value;
		var itemData = $currentListItem.data('itemData');
		var $spinner = $currentListItem.find('.spinner');
		var $productSinglePrice = $currentListItem.find('.product-single-price .price');
		var singlePrice = parseFloat( (parseFloat(itemData.price) /  parseFloat(itemData.number)).toFixed(2) );
		$spinner.spinner({min: 1})
			.spinner('delay', 0)
			.spinner('changed', function(e, newVal, oldVal) {
				if(newVal == 0) {
					list.totalPrice = list.totalPrice - singlePrice;
					setTotalPrice(list.totalPrice);
					list.removeProduct(key);
				}
				else {
					var currentPrice = calcProductPrice(singlePrice, newVal);
					$productSinglePrice.text( currentPrice );
					$currentListItem.data('currentPrice', currentPrice);
					if(newVal > oldVal) {
						list.totalPrice = list.totalPrice + singlePrice;
					}
					else {
						list.totalPrice = list.totalPrice - singlePrice;
					}
					setTotalPrice(list.totalPrice);
					$currentListItem.find('.product-total-price .price').text(currentPrice);
				}
			})
	})
}

function setRemovePlugin(list, callback) {
	var items = list.items;
	items.forEach(function(value, key, map){
		var $currentListItem = value;
		var itemData = $currentListItem.data('itemData');
		$currentListItem.find('.product-remove').on('click', function(e){
			var currentPrice = $currentListItem.data('currentPrice');
			list.removeProduct(key);
			list.totalPrice = list.totalPrice - currentPrice;
			setTotalPrice(list.totalPrice);
			if($.isFunction(callback)) {
				callback();
			}
		});
	})
}

function setTotalPricePlugin(list) {
	var items = list.items;
	items.forEach(function(value, key, map){
		var $currentListItem = value;
		var itemData = $currentListItem.data('itemData');
		$currentListItem.data('currentPrice', itemData.price);
		list.totalPrice = parseFloat(list.totalPrice) +  parseFloat(itemData.price);
		$currentListItem.find('.product-total-price .price').text(itemData.price);
	});
	setTotalPrice(list.totalPrice);
}

var ProductList = function ProductList(sel) {
	this.sel = sel;
	this.source = $(this.sel).find('[type="text/x-handlebars-template"]').html();
	this.items = new Map();
	this.init();
};

ProductList.prototype.init = function () {
	var self = this;
	self.template = Handlebars.compile(self.source);
	self.totalPrice = 0;
};

ProductList.prototype.render = function(data) {
	var self = this;
	if($.isArray(data)) {
		$.each(data, function(i, item){
			var html = self.template(item);
			$(self.sel).append(html);
			$currentListItem = $(self.sel).find('#shopping-cart--list-item'+item.itemId);
			$currentListItem.data('itemData', item);
			self.items.set(item.itemId, $currentListItem);
		});
		self.data = data;
		return Promise.resolve(self);
	}
};

ProductList.prototype.removeProduct = function (itemId) {
	var self = this;
	self.items.delete(itemId);
	$(self.sel).find('#shopping-cart--list-item'+itemId).remove();
};

