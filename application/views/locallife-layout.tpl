{extends file='base-layout.tpl'}
	{block name="head"}
		{row id="header"}
			{div class="top_navbar"}
				{div class="top_navbar_content"}
					{ul class="nav navbar-nav top_navbar_left" items=$actions index="i"}
						{literal}
							{li}
								{action id="action-$i" action=$item}{/action}
							{/li}
						{/literal}
					{/ul}
					{ul class="top_navbar_right"}
						{li class="dropdown"}
							{a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"}
								{lang}My Bestpay{/lang}
								{span class="caret"}{/span}
							{/a}
							{div class="dropdown-menu" role="menu" aria-labelledby="dLabel"}
								{ul class="nav navbar-nav top_navbar_left" items=$my_bestpay index="i"}
									{literal}
										{li}
											{action id="action-$i" action=$item}{/action}
										{/li}
									{/literal}
								{/ul}
							{/div}
						{/li}
						{li}
							{a uri="help/index"}{lang}Know Bestpay{/lang}{/a}
						{/li}
						{li}
							{a uri="merchant/login"}{lang}Business Center{/lang}{/a}
						{/li}
						{li}
							{a}{lang}Contact Us{/lang}{/a}
						{/li}
					{/ul}
				{/div}
			{/div}
			{div class="logo-section"}
				{div class="top_logo"}
					{div class="navbar"}
						{div class="navbar__brand"}
							{a uri="/"}{resimg data-image="logo.png"}{/a}
						{/div}
						{div class="navbar__section navbar__icon"}
							{resimg data-image="top_icon.png"}
						{/div}
						{div class="navbar__section navbar__action"}
							{resimg data-image="phone.png"}
							{form class="search-form" action=$search_url name="search"}
								{div class="input-group"}
									{i class="glyphicon glyphicon-search"}{/i}
									{input type="text" class="form-control" name="key" id="search_input" value=$key }
									{span class="input-group-btn"}
										{button class="btn btn-default" type="submit" id="search"}{lang}Search{/lang}{/button}
									{/span}
								{/div}
							{/form}
						{/div}
					{/div}
				{/div}
			{/div}
			{block name="menu"}
				{row id="menu"}
					{nav class="navbar"}
						{div class="container-fluid"}
							<!-- Collect the nav links, forms, and other content for toggling -->
							{div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"}
								{navigation class="navbar-nav" actions=$navi}{/navigation}
								{div class="cart" data-role="cart"}
									{resimg data-image="cart.png"}
									{form  name="cart/buy" }
										{a href = {$cart->jump_url} class="info"}
										{if $productByCart != null}
											{lang}Cart{/lang}{span}({$cart->count}){/span}
										{else}
											{lang}Cart{/lang}{span}(0){/span}
										{/if}
										{span class="caret"}{/span}
										{/a}
										{if $cart->user_id}
											{a href = {$cart->jump_url} class="info" nologin="false"}
												{if $productByCart != null}
													{lang}Cart{/lang}{span}({$cart->count}){/span}
												{else}
													{lang}Cart{/lang}{span}(0){/span}
												{/if}
												{span class="caret"}{/span}
											{/a}
										{else}
											{a href = {$cart->jump_url} class="info" nologin="true"}
												{if $productByCart != null}
													{lang}Cart{/lang}{span}({$cart->count}){/span}
												{else}
													{lang}Cart{/lang}{span}(0){/span}
												{/if}
												{span class="caret"}{/span}
											{/a}
										{/if}
										{ul class="cartdown" items=$productByCart index="i"}
											{if $productByCart != null}
											{literal}
												{li}
													{a class="tu"}
														{resimg data-image={$item->path}}
													{/a}
													{div class="info"}
														{span class="title"}{$item->name}{/span}
														{span class="price"}{b}{$item->number}{/b}￥{$item->discount_price}{/span}
													{/div}
												{/li}
												<input type="text" name="name[]" value="{$item->name}" style="display:none;"/>
												<input type="text" name="is_cart" value="cart_buy" style="display:none;"/>
												{if $i eq {$item->cart_count}}
													{li class="action_btn"}
														{a uri="order/confirm?spm=16gtp" class="btn jie"}{lang}立即购买{/lang}{/a}
													{/li}
												{/if}
											{/literal}
											{else}
												{li class="noproduct"}
													{a uri="cart/index"}
														{lang}购物车中还没有商品，赶紧选购吧！{/lang}
													{/a}
												{/li}
											{/if}
										{/ul}
									{/form}
								{/div}
							{/div}<!-- /.navbar-collapse -->
						{/div}<!-- /.container-fluid -->
					{/nav}
				{/row}
			{/block}
			<!-- Modal -->
			{div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
			{form id="sns_login_form" class="form-horizontal" role="form" novalidate="" accept-charset="utf-8" method="post" action="http://user.pinet.co/api/login"}
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
												{input type="text" name="mobile" value="" class="form-control" id="mobile" placeholder="电话号码"}
											{/div}
										{/div}
											{div class="control-group form-group"}
											{div class="input-group code"}
												{span class="input-group-addon"}
													{img uri="application/static/img/verify-code-icon.png"}
												{/span}
											{input type="text" name="validation_code" value="" class=" form-control" id="field_validation_code" placeholder="输入验证码"}
										{/div}
										{div id="send" class="btn" sendsmsurl="{$url}"}
											获取验证码
										{/div}
									{/div}
								{/div}
								{div class="modal-footer"}
									{p}
										<input type="hidden" name="callback" value="http://user.pinet.co/api/login_success">
										<input id="appid" name="appid" type="hidden" value="-1"/>
										{input id="submit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" value="登录"}
										{a href="http://user.pinet.co/oauth/session/qq/4000" class="qq_button"}QQ登录{/a}
										{a href="http://user.pinet.co/oauth/session/weibo/4000" class="weibo_button"}微博登录{/a}
									{/p}
								{/div}
					{/div}
				{/div}
				{/form}
			{/div}
		{/row}
	{/block}
	{block name="main"}
		{sect name="main"}
			{block name="silder"}
			{/block}
			{div id="main-content"}
				{block name="main-content"}{** The main content of the layout **}{/block}
			{/div}
		{/sect}
	{/block}
	{div id="foot"}
		{block name="foot"}
			{row class="foot"}
				{div class="content"}
					{div class="foot_left"}
						{ul}
							{li}
							{resimg data-image="qr.png"}
								{/li}
							{li}
								扫描二维码，订阅翼支付官方微信<br><br>

								我们会在每个环节做到为您所需，
								为您提供最高品质的服务。
							{/li}
							{li}
								{resimg data-image="phone1.png"}
							{/li}
						{/ul}
					{/div}
					{div class="foot_right"}
						{ul}
							{li}
								{h3}关于翼百{/h3}
								{a}品牌故事{/a}
								{a}媒体报导{/a}
								{a}品牌合作{/a}
								{a}联系我们{/a}
							{/li}
							{li}
								{h3}售后服务{/h3}
								{a}订单查询{/a}
								{a}售后无忧{/a}
								{a}发票说明{/a}
								{a}留言建议{/a}
							{/li}
							{li}
								{h3}特别服务{/h3}
								{a}配送服务{/a}
								{a}全程冷链{/a}
								{a}渠道服务{/a}
								{a}加入我们{/a}
							{/li}
						{/ul}
					{/div}
				{/div}
			{/row}
			{row id="copyright"}
				{div class="copyright"} ©Copyright Pinet Technology Solutions 2014{/div}
			{/row}
		{/block}
	{/div}
