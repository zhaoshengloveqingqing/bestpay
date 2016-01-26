{extends file="pay-layout.tpl"}

{block name="head" append}
		{div class="logo-section"}
			{div class="top_logo"}
				{div class="navbar"}
					{div class="navbar__brand nav"}
						{a uri="/"}{resimg data-image="/order/logo.png"}{/a}
					{/div}
					{div class="navbar__section navbar__action"}
						{ul class="nav navbar-nav top_navbar_left"}
							{li}
								{span}1.确认订单信息并付款{/span}
							{/li}
							{li class="active stepbar-current"}
								{img uri="responsive/size/24/order/stepbar-current-green-bg.png"}
								{span}2.付款完成{/span}
							{/li}
						{/ul}
					{/div}
				{/div}
			{/div}
		{/div}
	{/block}
	{block name="main-content" append}
		{form name="order/confirm" id="order" method="POST" action="{$form_action}"}
			{div id="address"}
				{div class="panel-header"}
					{h4}{lang}选择收货地址{/lang}{/h4}
					{div class="color"}{/div}<hr>
				{/div}
				{*<script>*}
					{*function Cmd(v, k){*}
						{*if(v.checked){*}
							{*if(k == "B") //假设B是正确答案*}
								{*alert("答对啦");*}
							{*else*}
								{*alert("答错啦");*}
						{*}*}
					{*}*}

			{*</script>*}
			{*<input type="radio" name="rd1" onclick="Cmd(this, 'A')" />A*}
			{*<input type="radio" name="rd1" onclick="Cmd(this, 'B')" />B*}
			{*<input type="radio" name="rd1" onclick="Cmd(this, 'C')" />C*}
			{*<input type="radio" name="rd1" onclick="Cmd(this, 'D')" />D*}
			{div class="address_info"}
				{ul id="dizhi" items=$address}
					{if count($address)==null}
						{p }{/p}
					{else}
					{literal}
						{li}
							{input id="radio" pro="{$item->province_children}" city="{$item->city_children}" area="{$item->area_children}" consignee="{$item->consignee}" mobile="{$item->mobile}"  name="radio" class="radio" type="radio" address="{$item->delivery_address}" name="radio"  kid="{$item->default_address}" value="{$item->id}" rid="{$item->default_address}" }
							{div id="ads"}
								{i}{$item->province_children}{/i}{i}{$item->city_children}{/i}{i}{$item->area_children}{/i}{i}{$item->delivery_address}{/i} {i}{$item->consignee}{/i}{i}{$item->mobile}{/i}
							{/div}
							{div class="tip" id="count" kl="{$item->count}"}
								{if {$item->default_address}!=null}
									{i class="default"}
										默认地址
									{/i}
								{else}
									{i class="address_default" mid="{$item->id}"}
										设置默认
									{/i}
								{/if}
								{i  id="ad" cid="{$item->id}" province = {$item->province} city = {$item->city} area = {$item->area} mt="{$item->id}" address="{$item->delivery_address}"  checkbox="{$item->default_address}" consignee="{$item->consignee}"  class="edit"}编辑{/i}
								{i class="delete"  delete="{$item->id}"  checkbox="{$item->default_address}"}删除{/i}
							{/div}
						{/li}
					{/literal}
					{/if}
				{/ul}
				{a class="myaddress" id="add_new"}{i class="glyphicon glyphicon-plus"}{/i}使用新地址{/a}
			{/div}
		{/div}

			{div id="orders"}
				{div class="panel-header"}
					{h4}{lang}确认订单信息{/lang}{/h4}
					{div class="color"}{/div}<hr>
				{/div}
				{div class="orders-info"}
					{div class="title"}
						{lang}全部商品
						{span}
							{if {$user_infos->product_count}}
								{$user_infos->product_count}
							{else}
								{$CartCount}
							{/if}
						{/span}件
						{/lang}
						{ul}
							{li class="product_info"}{lang}商品信息{/lang}{/li}
							{li}{lang}单价{/lang}{/li}
							{li}{lang}数量{/lang}{/li}
							{li}{lang}小计{/lang}{/li}
							{li}{lang}操作{/lang}{/li}
						{/ul}
					{/div}
						{foreach from=$merchants key="mykey" item=foo}
							{if $display}
							<div id="order-list{$mykey}" control="each" class="order-list">
								{h4 class="product-name"}商家：{$foo}{/h4}
								<div class="list">
									{li class="title"}
										{h4 class="product-name"}店铺优惠活动{/h4}
										{span class="total"}
											{div class="_grid cart-total"}
												{div id="totalCtr" class="_column total"}
													{div class="cart-totals-value"}
														{div class="unit"}￥{/div}
														{div class="price"}0.00{/div}
													{/div}
												{/div}
											{/div}
										{/span}
									{/li}
									{template}
										<li id="shopping-cart--list-item{literal}{{itemId}}{/literal}" class="_grid confirmCart-list-item" iscoupon="{literal}{{category_id}}{/literal}" data-price="{literal}{{discount_price}}{/literal}" data-number="{literal}{{number}}{/literal}" amount-number="{literal}{{amount}}{/literal}">
											<div class="_column cart-product-image">
												<img class="cart-product-image--img" src="{literal}{{path}}{/literal}" alt="Item image" />
												<h4 class="cart-product-name">{literal}{{name}}{/literal}</h4>
											</div>
											<div class="_column cart-product-info">
												<div control="" class="price cart-product-single-price">  <div class="unit">￥</div> <div class="price">{literal}{{discount_price}}{/literal}</div>
												</div>
											</div>
											<div class="_column cart-product-modifiers" data-cart-product-price="">
												<div id="spinner" class="_grid spinner" data-trigger="spinner">
													<button type="button" class="_btn _column cart-product-subtract" data-spin="down">-</button>
													<input class="_column cart-product-qty" type="text" id="number" name="number[]" value="{literal}{{number}}{/literal}" data-rule="quantity">
													<button type="button" class="_btn _column cart-product-plus" data-spin="up">+</button>
												</div>
											</div>
											{div class="_column"}
											{div control="cart-product-total-price" class="price cart-product-total-price"}
												{div class="unit"}￥{/div}
													{div class="price"}0.00{/div}
													{/div}
												{/div}
											{div class="_column"}
												{button type="button" class="_btn entypo-trash cart-product-remove"}删除{/button}
											{/div}
											<input type="hidden" name="product_id[]" value="{literal}{{product_id}}{/literal}">
											{*<input type="hidden" name="number[]" value="{literal}{{number}}{/literal}">*}
											<input type="hidden" name="name[]" value="{literal}{{name}}{/literal}">
											<input type="hidden" name="discount_price[]" value="{literal}{{discount_price}}{/literal}">
										</li>
									{/template}
								</div>
							</div>
							{/if}
						{/foreach}
						{div id="deliver"}
							{field field="distribution_way" label-class="col-lg-2" input-class="col-lg-8"}
							{select options=$children_merchants}
							{/select}
							{/field}
						{/div}
						{div id="coupon-list" class="panel pinet-panel"}
							{div class="panel-body"}
								<!-- / Nav tabs -->
								{div class="tab-content"}
									{div role="tabpanel" class="tab-pane active" id="home"}
										{div id="pay-listview" class="panel pinet-panel"}
											{span}{lang}支付方式{/lang}{/span}
											{ul class="listview"}
												{li class="item"}
													{field field="payment_id" state="hidden"}
													{/field}
													{field field="bestpay"}
														{label class="pay-radio"}
															{input class="pay-radio__input" checked="true"}
															{div class="pay-radio__info"}
																{resimg data-image="/order/yizhifu.png"}
															{/div}
														{/label}
													{/field}
												{/li}
											{/ul}
										{/div}
									{/div}
								{/div}
								<!-- / Tab panes -->
							{/div}
						{/div}
						{div class="_grid cart-totals"}
							{div id="totalCtr" class="_column total"}
								{div class="cart-totals-key"}{lang}Total{/lang}:{/div}
								{div class="cart-totals-value"}
									{div class="unit"}￥{/div}
									{div class="price"}0.00{/div}
								{/div}
								{input name="total" style="display:none"}
							{/div}
							{div class="_column checkout"}
								{button class="_btn checkout-btn entypo-forward" id="submit" default="{$default}" amount=$product_amount}{lang}Checkout{/lang}{/button}
							{/div}
						{/div}
						{div class="info" }
							{p }{strong}寄送至：{/strong}{span id="get_address"}{$place} {$default_address->delivery_address}{/span}{/p}
							{p}{strong}收货人：{/strong}{span id="consignee"}{$default_address->consignee} {$default_address->mobile}{/span}{/p}
						{/div}

				{/div}
			{/div}
		{/form}
		<!-- Modal -->
		{div class="modal fade" id="myAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
			{div class="modal-dialog"}
				{div class="modal-content"}
					{div class="modal-header"}
						{button type="button" class="close" data-dismiss="modal" aria-label="Close"}
							{span aria-hidden="true"}&times;{/span}
						{/button}

							{h4 class="modal-title"}{lang}<span id="hello"></span>{/lang}{/h4}

					{/div}
					{div class="modal-body"}
						{*<iframe id="myiframe" src="" frameborder="0" style="width: 100%; height:270px;"></iframe>*}
						{form id="myform" name="order/confirm" action="$jump_url" id="form1"}
							{*{h4}{lang}Add new address{/lang}{/h4}*}
							{row class="select"}
								{field field="province" label-class="col-lg-4" input-class="col-lg-7"}
									{select options=$province label-field="name" value-field="id"}{/select}
								{/field}
								{field field="city" label-class="col-lg-4" input-class="col-lg-7"}
									{select label-field="name" value-field="id"}{/select}
								{/field}
								{field field="area" label-class="col-lg-4" input-class="col-lg-7"}
									{select label-field="name" value-field="id"}{/select}
								{/field}
							{/row}
							{row}
								{field field="delivery_address" label-class="col-lg-4" input-class="col-lg-7" value=""}
									{textarea}{/textarea}
								{/field}
							{/row}
							{row}
								{field field="consignee" label-class="col-lg-4" input-class="col-lg-7"}{/field}
							{/row}
   							{row}
								{field field="mobile" class="phone" label-class="col-lg-4" input-class="col-lg-7"}{/field}
							{/row}
							{row class="checkbox"}
								{label}
									<input type="checkbox" name="default_address" id="default_address">
									{lang}Sets the address for the default{/lang}
								{/label}
							{/row}
							<input type="text" id="mobile" style="display:none" value="{$user_infos->mobile}">
							<input type="text" name="checkbox" id="checkbox" style="display:none">
							{row class="action"}
								{submit id="confirm"}
							{/row}
							{field field="id" label-class="col-lg-4" input-class="col-lg-7"}{/field}
						{/form}
					{/div}
				{/div}
			{/div}
		{/div}
	{/block}