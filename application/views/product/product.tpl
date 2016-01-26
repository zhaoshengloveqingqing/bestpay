{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
				<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
				<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
				{row class="place"}
					{ul class="breadcrumb pinet-breadcrumb"}
						{li}
							{a uri="#"}{lang}Home{/lang}{/a}
						{/li}

							{a uri="mall/index"}
								/&nbsp{$parent_tagName}
							{/a}
							{foreach from=$chiled_tagNames key="mykey" item=foo}
								/&nbsp&nbsp{$foo}
							{/foreach}

						{li class="active"}
							/&nbsp&nbsp{lang}{$product->name}{/lang}
						{/li}
					{/ul}
				{/row}
				{row class="product-coupon"}
					{div class="product_details"}
						{a class="thumbnail__link"}
						{slider id="product_images" class='pinet-full-slider'}
							{slides items=$items}
								{literal}
									{div class='product'}
									{img u="image" uri=$item->url}
									{img u="thumb" uri=$item->url}
									{/div}
								{/literal}
							{/slides}
							<!-- thumbnail navigator container -->
							{div u="thumbnavigator" class="thumb"}
								<!-- Thumbnail Item Skin Begin -->
								{div u="slides"}
									{div u="prototype" class="p"}
										{div class="w"}
											{div u="thumbnailtemplate" class="t c"}{/div}
										{/div}
									{/div}
								{/div}
								<!-- Thumbnail Item Skin End -->
							{/div}
						{/slider}
						{/a}
						{div class="product-coupon-info"}
							{form name="product/product" action="$form_action"}
								{row class="product_name"}
									{strong}{$product->name}{/strong}
								{/row}
								{row class="price"}
									{div}
										{label}{lang}翼支付价{/lang}{/label}
										{strong}￥{$product->discount_price}{/strong}
									{/div}
									{div}
										{label}{lang}销售价{/lang}{/label}
										{strong}￥{$product->price}{/strong}
									{/div}
								{/row}
								{row class="service"}
									{label}{lang}服务{/lang}{/label}
									{strong }由厂家发货并提供售后服务{/strong}
								{/row}
								{row layout=[3] layout-lg=[3]}
									{qrcode}{$product->url}{/qrcode}
								{/row}
								{row class="num" layout=[2,2,3] layout-lg=[2,2,3]}
									{label}{lang}Number{/lang}{/label}
									{div id="tab" class="input-group"}
										{span type="button" class="input-group-addon min"}-{/span}
										{input class="text_box form-control" id="number" name="number" type="text" value="1"}
										{span type="button" class="input-group-addon add"}+{/span}
									{/div}
									{if $product->amount<'1'}
										{label}{lang}<font color=#dd0000 >库存不足</font>{/lang}{/label}
									{/if}
								{/row}
								{field field="id" state="hidden"}
								{/field}
								{field field="name" state="hidden"}
								{/field}
								{field field="discount_price" state="hidden"}
								{/field}
								{field field="note" state="hidden"}
								{/field}
								{field field="create_date"  state="hidden"}
								{/field}
								<input id="product" name="product" style="display:none" value="submit">
								{if $user_id ==null}
										{row class="action"}
											{submit id="submit-btn" }
											{submit type="button" value="Add to cart" id="car-btn" class="cart_btn" }
										{/row}
								{else}
									{if  $product->amount=='0' }
										{row class="action"}
										{submit id="submit-btn" class="disabled"}
										{submit type="button" value="Add to cart" id="car-btn" class="cart_btn" class="disabled"}
										{/row}
									{else}
										{row class="action"}
											{submit class="submit" kt="{$product->amount}" }
											{submit type="button" value="Add to cart" ks="{$product->amount}" amount="{$cartamount}" id="car-btn"}
										{/row}
									{/if}
								{/if}
							{/form}
						{/div}
					{/div}
				{/row}
				{row id="detail"}
					{div id="myTabwrapper" class="navbar-wrapper"}
						{ul class="nav nav-pills nav-sub"  id="myTab"}
							{li role="presentation" class="menuItem active"}
								{a href="#business_location"}{lang}Product Details{/lang}{/a}
							{/li}
							{li role="presentation" class="menuItem"}
								{a href="#group_purchase_detail"}{lang}Product Introduction{/lang}{/a}
							{/li}
							{li role="presentation" class="menuItem"}
								{a href="#business_information"}{lang}Pruchase notes{/lang}{/a}
							{/li}
							{li role="presentation" class="menuItem"}
								{a href="#purchase_note"}{lang}Business Information{/lang}{/a}
							{/li}
						{/ul}
					{/div}
					{div id="business_location" tat="section"}
						{div class="title"}
							{h3}{lang}商品详情 Product Details{/lang}{/h3}
							{div class="info"}
								{resimg data-image="/product/chanpin.png"}
							{/div}
						{/div}
					{/div}
					{div id="group_purchase_detail" tat="section"}
						{div class="title"}
							{h3}{lang}商品规格 Product Introduction{/lang}{/h3}
							{div class="info"}
								{dl}
									{dt}有效期{/dt}
									{dd}{$product->create_date}至{$product->expire_date}（周末、法定节假日通用）{/dd}
								{/dl}
								{dl}
									{dt}使用时间{/dt}
									{dd}10:00-14:00，17:00-21:00{/dd}
								{/dl}
								{dl}
									{dt}商家服务{/dt}
									{dd}包邮{/dd}
								{/dl}
							{/div}
						{/div}
					{/div}
					{div id="business_information" tat="section"}
						{div class="title"}
							{h3}{lang}购买须知 Pruchase notes{/lang}{/h3}
							{div class="info"}
								{p}{$product->note}{/p}
							{/div}
						{/div}
					{/div}
					{div id="purchase_note" tat="section"}
						{div class="title"}
							{h3}{lang}商家信息 Business Information{/lang}{/h3}
							{div class="info local"}
								{div id="allmap" longitude="{$product->longitude}" latitude="{$product->latitude}" location="{$product->location}"}{/div}
								{div class="location"}
									{div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"}
										{listview id="merchant_information" name='merchant_information'}
											{li class="item listview_item_template"}
												{div class="panel panel-default"}
													{div class="panel-heading" role="tab"}
														{h4 class="panel-title"}
															{a data-toggle="collapse" data-parent="#accordion" aria-expanded="true"}
																_(products_name)
															{/a}
															{i class="glyphicon-menu-down"}{/i}
														{/h4}
													{/div}
													{div class="panel-collapse in" role="tabpanel"}
														{div id="result" class="panel-body"}
															{p class="address"}{span}地址:{/span}
															{if $product->location!=null}
																_(merchants_location)
															{else}
																暂无地址
															{/if}
																<input id="longitude"  value="_(merchants_longitude)" type="text" style="display:none;width:100px; margin-right:10px;" />
																<input id="latitude" value="_(merchants_latitude)" type="text" style="display:none;width:100px; margin-right:10px;" />
																{p}{a onclick="theLocation(_(merchants_longitude),_(merchants_latitude))"}查看地图公交/驾车去这里{/a}{/p}
															{/p}
														{p}
														{/p}
														{p class="phone"}{span}电话:{/span} 0551-65952856{/p}
														{/div}
													{/div}
												{/div}
											{/li}
										{/listview}
									{/div}
								{/div}
							{/div}
						{/div}
					{/div}
				{/row}
				<!-- Modal -->
				{div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
					{form class="form-horizontal" role="form" novalidate="" accept-charset="utf-8" method="post" action="http://user.pinet.co/api/login"}
						{div class="modal-dialog"}
							{div class="modal-content"}
								{div class="modal-header"}
									{button type="button" class="close" data-dismiss="modal" aria-label="Close"}{span aria-hidden="true"}&times;{/span}{/button}
									{h4 class="modal-title" id="myModalLabel"}{lang}用户登录{/lang}{/h4}
								{/div}
								{div class="modal-body"}
									{div class="control-group form-group"}
										{div class="input-group mobile-phone"}
				                            {span class="input-group-addon"}
					                            {img uri="application/static/img/phone-number-icon.png"}
				                            {/span}
											{input type="text" name="mobile" value="" class="form-control" id="field_mobile" placeholder="电话号码"}
										{/div}
									{/div}
									{div class="control-group form-group"}
										{div class="input-group code"}
				                            {span class="input-group-addon"}
					                            {img uri="application/static/img/verify-code-icon.png"}
				                            {/span}
											{input type="text" name="validation_code" value="" class=" form-control" id="field_validation_code" placeholder="输入验证码"}
										{/div}
										{div id="send" class="btn"}
											获取验证码
										{/div}
									{/div}
								{/div}
								{div class="modal-footer"}
									{p}
										{input id="submit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" type="button" value="登录"}
										{a href="http://user.pinet.co/oauth/session/qq/4000" class="qq_button"}QQ登录{/a}
										{a href="http://user.pinet.co/oauth/session/weibo/4000" class="weibo_button"}微博登录{/a}
									{/p}
								{/div}
							{/div}
						{/div}
					{/form}
				{/div}
			{/block}
