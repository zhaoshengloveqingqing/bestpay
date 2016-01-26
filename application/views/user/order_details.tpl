{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="breadcrumb pinet-breadcrumb"}
					{li}
						{a uri="#"}{lang}首页{/lang}{/a}
					{/li}
					{li}
						{a uri="mall/index"}{lang}我的翼百{/lang}{/a}
					{/li}
					{li}
						{a uri="user/orders"}{lang}我的订单{/lang}{/a}
					{/li}
					{li class="active"}
						{lang}订单详情{/lang}
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
								{if ($type=='product') }
									{li class="active"}{a uri="user/orders"}{lang}我的订单{/lang}{/a}{/li}
								{else}
									{li}{a uri="user/orders"}{lang}我的订单{/lang}{/a}{/li}
								{/if}
								{li}{a uri="user/my_address"}{lang}收货地址{/lang}{/a}{/li}
								{if ($type=='bestpay_coupon') }
									{li class="active"}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
								{else}
									{li}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
								{/if}
								{li}{a uri="user/my_coupon"}{lang}我的优惠券{/lang}{/a}{/li}
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
				{div id="details_info" role="tabpanel"}
					{ul  class="nav nav-tabs" role="tablist" id="myTab"}
						{li role="presentation" class="active"}
							{a href="#info" role="tab" aria-controls="info" data-toggle="tab"}{lang}订单详情{/lang}{/a}
						{/li}
					{/ul}
					{div class="tab-content"}
						{row id="info"  class="tab-pane active" role="tabpanel"}
							{table class="order-status"}
								{thead}
									{for $i=0;$i<count($top_menus);$i++}
										{td}{$top_menus[$i]}{/td}
									{/for}
								{/thead}
								{tbody}
									{tr}
										{td}{div}{$orders->order_number}{/div}{/td}
										{td}{div}{$orders->create_date}{/div}{/td}
										{td}{div}翼支付{/div}{/td}
										{td}{div}{$orders->timestamp}{/div}{/td}
										{td}{div}{lang}{$orders->status}{/lang}{/div}{/td}
									{/tr}
								{/tbody}
							{/table}
						{/row}
						{row id="info"  class="tab-pane active" role="tabpanel"}
							{table class="order-info"}
								{thead}
									{for $i=0;$i<count($menus);$i++}
										{td}{$menus[$i]}{/td}
									{/for}
								{/thead}
								{tbody}
								{for $i=0;$i<count($order_details);$i++}
									{tr}
										{td}{div}{$order_details[$i]->name}{/div}{/td}
										{td}{div}{resimg data-image="{$order_details[$i]->path[0]}"}{/div}{/td}
										{td}{div}{$order_details[$i]->price}{/div}{/td}
										{td}{div}{$order_details[$i]->amount}{/div}{/td}
										{td}{div}{/div}{/td}
										{if $order_details[$i]->category_id=="1"}
											{td}{div}{$order_details[$i]->totalprice}{/div}{/td}
										{/if}
										{if $order_details[$i]->category_id=="2"}
											{td}{div}{$order_details[$i]->code}{/div}{/td}
										{/if}
											{td}{div}{$order_details[$i]->expire_date}{/div}{/td}
										{if $type=="bestpay_coupon"}
											{td}{div}{lang}{$order_details[$i]->status}{/lang}{/div}{/td}
										{/if}
									{/tr}
								{/for}
								{/tbody}
							{/table}
							{div class="total"}
								{h4}
									实付款：{span}￥{$totalPrice}{/span}
								{/h4}
							{/div}
							{if $order_details[0]->category_id=='2'}
								{table class="info"}

									{tbody}
										{tr}
											{td}

											{/td}
											{td}

											{/td}
										{/tr}
									{/tbody}
								{/table}
							{/if}
							{if $order_details[0]->category_id=='1'}
								{table class="info"}
									{thead}
										{td}收货信息{/td}
										{td}商家及物流{/td}
									{/thead}
									{tbody}
										{tr}
											{td}
												{div}收货人姓名：{$orders->consignee_name} {/div}
												{div}联系电话:{$orders->consignee_mobile}{/div}
												{div}收货地址:{$place}{$orders->consignee_address}{/div}
											{/td}
											{td}
												{div}配送：{$orders->distribution_company} {/div}
												{div}联系电话:{$orders->distribution_phone}{/div}
												{div}运送方式:{$orders->distribution_way}{/div}
											{/td}
										{/tr}
									{/tbody}
								{/table}
							{/if}
						{/row}
					{/div}
				{/div}
			{/block}
