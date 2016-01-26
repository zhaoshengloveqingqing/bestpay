{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="breadcrumb pinet-breadcrumb"}
					{li}
					{a uri="#"}{lang}首页{/lang}{/a}
					{/li}
					{li}
						{a uri="user/bestpay_coupon"}{lang}我的翼百{/lang}{/a}
					{/li}
					{li class="active"}
						{lang}我的优惠券{/lang}
					{/li}
				{/ul}
				{div class="left-meau"}
					{ul class="meau"}
						{li class="titles"}
							{span}{lang}我的翼百{/lang}{/span}
						{/li}
						{li}
							{span}{lang}团购订单{/lang}{/span}
							{ul class="sub-meau"}
								{li}{a uri="user/orders"}{lang}我的订单{/lang}{/a}{/li}
								{li}{a uri="user/my_address"}{lang}收货地址{/lang}{/a}{/li}
								{li}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
								{li class="active"}{a uri="user/my_coupon"}{lang}我的优惠券{/lang}{/a}{/li}
							{/ul}
						{/li}
						{li}
							{span}{lang}我的账户{/lang}{/span}
							{ul class="sub-meau"}
								{li}{a uri="user/user_info"}{lang}个人信息{/lang}{/a}{/li}
								{li}{a uri="user/account"}{lang}账户设置{/lang}{/a}{/li}
							{/ul}
						{/li}
					{/ul}
				{/div}
				{div id="coupon" role="tabpanel"}
				{ul  class="nav nav-tabs" role="tablist" id="myTab"  activeindex=""}
					{if {$status}=='cash_coupon'}
						{li role="presentation" class="active" id="cash_coupon" status="cash_coupon"}
							{a uri="/user/my_coupon/cash_coupon" role="tab" aria-controls="cash_coupon"}{lang}代金券{/lang}{/a}
						{/li}
					{else}
						{li role="presentation" class="" id="cash_coupon" status="cash_coupon"}
							{a uri="/user/my_coupon/cash_coupon" role="tab" aria-controls="cash_coupon" }{lang}代金券{/lang}{/a}
						{/li}
					{/if}
					{if {$status}=='discount_coupon'}
						{li role="presentation" class="active" id="discount_coupon" status="discount_coupon"}
							{a uri="/user/my_coupon/discount_coupon" role="tab"  aria-controls="discount_coupon"}{lang}折扣券{/lang}{/a}
						{/li}
					{else}
						{li role="presentation" class="" id="discount_coupon" status="discount_coupon"}
							{a uri="/user/my_coupon/discount_coupon" role="tab"  aria-controls="discount_coupon"}{lang}折扣券{/lang}{/a}
						{/li}
					{/if}
					{if {$status}=='general_coupon'}
						{li role="presentation"  class="active" id="general_coupon" status="general_coupon"}
							{a uri="/user/my_coupon/general_coupon" role="tab"  aria-controls="general_coupon"}{lang}通用券{/lang}{/a}
						{/li}
					{else}
						{li role="presentation"  class="" id="general_coupon" status="general_coupon"}
							{a uri="/user/my_coupon/general_coupon" role="tab"  aria-controls="general_coupon"}{lang}通用券{/lang}{/a}
						{/li}
					{/if}
				{/ul}
				{div class="tab-content"}
						{row id="{$status}"  class="tab-pane active" role="tabpanel"}
							{listview id="mycoupon_index" name='mycoupon_index'}
								{foreach from=$cash_coupons item=foo}
									{li class="item listview_item_template"}
										{a}
											{div class="shop-coupon"}
											{if {$status}=="cash_coupon"}
												{p}￥{span}{$foo->discount_price}{/span}元代金券{/p}
											{/if}
											{if {$status}=="discount_coupon"}
												{p}{span}5{/span}折优惠{/p}
											{/if}
											{if {$status}=="general_coupon"}
												{p}￥{span}{$foo->discount_price}{/span}全场通用{/p}
											{/if}
											{div class="coupon--info"}
												{span}{lang}商家商城：{$foo->merchant_name}{/lang}{/span}
												{span}{lang}使用条件：{$foo->note}{/lang}{/span}
												{span}{lang}有效期：{$foo->create_date}-{$foo->expire_date}{/lang}{/span}
											{/div}
											{/div}
										{/a}
									{/li}
								{/foreach}
							{/listview}
						{/row}
						{div id="pages"}
							{$pagestr}
						{/div}
					{/div}
				{/div}
			{/block}