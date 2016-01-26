{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				<form name="order/confirm" method="POST" action="{$form_action}">
				<div class="shopping-cart">
					<ol id="shopping-cart-list" class="ui-list shoping-cart-list">
						<script id="cart-list-template" type="text/x-handlebars-template">
						<h4 class="product-name">商家：{literal}{{merchant_name}}{/literal}</h4>
							<li id="shopping-cart--list-item{literal}{{itemId}}{/literal}" class="_grid shopping-cart--list-item">
								<div class="_column product-image">
									<img class="product-image--img" src="{literal}{{'/pinet-bestpay/lvyinge/goodlifeleft.png'}}{/literal}" alt="Item image" />
								</div>
								<div class="_column product-info">
									<h4 class="product-name">{literal}{{name}}{/literal}</h4>
									<p class="product-desc">{literal}{{ori_price}}{/literal}</p>
									<div class="price product-single-price">  <div class="unit">￥</div> <div class="price">{literal}{{price}}{/literal}</div></div>
								</div>
								<div class="_column product-modifiers" data-product-price="{literal}{{price}}{/literal}">
									<div id="spinner" class="_grid spinner" data-trigger="spinner">
										<button class="_btn _column product-subtract" data-spin="down">&minus;</button>
										<input class="_column product-qty" type="text" name="number[]" value="{literal}{{number}}{/literal}" data-rule="quantity">
										<button class="_btn _column product-plus" data-spin="up">&plus;</button>
									</div>
									<button class="_btn entypo-trash product-remove">Remove</button>
									<div class="price product-total-price"> <div class="unit">￥</div> <div class="price">0.00</div></div>
								</div>
								<input name="product_id[]" value="{literal}{{product_id}}{/literal}">
								<input name="name[]" value="{literal}{{name}}{/literal}">
								<input name="discount_price[]" value="{literal}{{discount_price}}{/literal}">
							</li>
						</script>
					</ol>
					<div class="_grid cart-totals">

						<div id="subtotalCtr" class="_column subtotal">
						</div>
						<div id="shippingCtr" class="_column shipping">
						</div>
						<div id="taxesCtr" class="_column taxes">
						</div>
						<div id="totalCtr" class="_column total">
							<div class="cart-totals-key">Total</div>
							<div class="cart-totals-value"> <div class="unit">￥</div> <div class="price">0.00</div></div>
							<input name="total" style="display:none">
						</div>
						<div class="_column checkout">
							<button class="_btn checkout-btn entypo-forward">{lang}Submit Orders{/lang}</button>
						</div>

					</div>
				</div>
				</form>
			{/block}