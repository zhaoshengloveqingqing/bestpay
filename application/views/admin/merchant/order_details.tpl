{extends file='admin-layout.tpl'}
			{block name="main"}
				{div class="panel pinet-panel"}
					{div class="panel-body"}
						{row}
							{div class="order_status"}
								{p}{lang}The current order status{/lang}:{strong}{lang}{$order_details->status}{/lang}{/strong}{/p}
									{if $order_details->p_amount eq '0'}
									{p}{lang}Group purchase have been sold{/lang}{/p}
									{/if}
							{/div}
							{div class="left-meau"}
								{ul class="meau"}
									{li class="titles"}
										{span}{lang}订单管理{/lang}{/span}
									{/li}
									{li}
										{a uri="admin/merchant/orders"}{lang}我的订单{/lang}{/a}
									{/li}
								{/ul}
							{/div}
							{div id="details_info" role="tabpanel"}
								{ul  class="nav nav-tabs" role="tablist" id="myTab"}
									{li role="presentation" class="active"}
										{a href="#all-orders" role="tab" aria-controls="all-orders"}{lang}订单详情{/lang}{/a}
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
														{td}{div} {/div}{/td}
														{if $order_details[$i]->category_id=="1"}
															{td}{div}{$order_details[$i]->totalprice}{/div}{/td}
														{/if}
														{if $order_details[$i]->category_id=="2"}
															{td}{div}{$order_details[$i]->code}{/div}{/td}
														{/if}
														{td}{div}{$order_details[$i]->expire_date}{/div}{/td}
													{/tr}
												{/for}
											{/tbody}
										{/table}
										{div class="total"}
											{h4}
												实付款：{span}￥{$totalPrice}{/span}
											{/h4}
										{/div}
										{table class="info"}
											{thead}
												{td}收货信息{/td}
												{td}商家及物流{/td}
											{/thead}
											{tbody}
												{tr}
													{td}
														{div}收货人姓名：{$orders->consignee_name} 联系电话:{$orders->consignee_mobile}{/div}
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
									{/row}
								{/div}
							{/div}
						{/row}
					{/div}
				{/div}
				{*{div class="panel pinet-panel list"}*}
					{*{div class="panel-body"}*}
						{*{row layout=[12,12] layout-lg=[3,9]}*}
							{*{column}*}
								{*{ul class="nav nav-pills nav-stacked"}*}
									{*{li role="presentation"}{a uri="admin/merchant/orders"}{lang}My Order{/lang}{/a}{/li}*}
								{*{/ul}*}
							{*{/column}*}
							{*{column id="order_details"}*}
								{*{h3}{lang}Order Details{/lang}{/h3}*}
								{*{div class="order_status"}*}
									{*{p}{lang}The current order status{/lang}:{strong}{lang}{$order_details->status}{/lang}{/strong}{/p}*}
									{*{if $order_details->p_amount eq '0'}*}
										{*{p}{lang}Group purchase have been sold{/lang}{/p}*}
									{*{/if}*}
								{*{/div}*}
								{*{dl class="order_coupon"}*}
									{*{if $order_details->category_id eq '2'}*}
										{*{dt}{lang}Coupon{/lang}{/dt}*}
										{*{dd}*}
											{*{div class="order_coupon_status"}*}
												{*{p}*}
													{*{lang}Tip{/lang}:*}
													{*{lang}Write down or take the US group coupon code to businesses to produce to the consumer{/lang},*}
													{*{lang}without waiting for an SMS{/lang}*}
												{*{/p}*}
												{*{p}*}
													{*{lang}Coupon password{/lang}:*}
													{*{strong}{lang}{$order_details->code}{/lang}{/strong}*}
													{*{lang}{/lang}*}
												{*{/p}*}
											{*{/div}*}
										{*{/dd}*}
									{*{/if}*}
										{*{dt}{lang}Order information{/lang}{/dt}*}
									{*{dd}*}
										{*{ul class="list-inline order-info"}*}
											{*{li}{lang}Order number{/lang}{/li}*}
											{*{li}{lang}Place an order time{/lang}{/li}*}
											{*{li}{lang}Payment method{/lang}{/li}*}
											{*{li}{lang}Time of payment{/lang}{/li}*}
										{*{/ul}*}
										{*{ul class="list-inline order-info"}*}
											{*{li}{$order_details->order_number}{/li}*}
											{*{li}{$order_details->create_date}{/li}*}
											{*{li}{$order_details->payment_name}{/li}*}
											{*{li}{$order_details->timestamp}{/li}*}
										{*{/ul}*}
									{*{/dd}*}
									{*{dt}{lang}Group purchase information{/lang}{/dt}*}
									{*{dd}*}
										{*{ul class="list-inline info"}*}
											{*{li}{lang}Purchase Name{/lang}{/li}*}
											{*{li}{lang}Price{/lang}{/li}*}
											{*{li}{lang}Number{/lang}{/li}*}
											{*{li}{lang}Total Price{/lang}{/li}*}
											{*{li}{lang}Expire Date{/lang}{/li}*}
										{*{/ul}*}
										{*{ul class="list-inline info"}*}
											{*{li}{$order_details->name}{/li}*}
											{*{li}￥{$order_details->price}{/li}*}
											{*{li}{$order_details->amount}{/li}*}
											{*{li}￥{$order_details->totalPrice}{/li}*}
											{*{li}{$order_details->expire_date}{/li}*}
										{*{/ul}*}
									{*{/dd}*}
								{*{/dl}*}
							{*{/column}*}
						{*{/row}*}
					{*{/div}*}
				{*{/div}*}
			{/block}
