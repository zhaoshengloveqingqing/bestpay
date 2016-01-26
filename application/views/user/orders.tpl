    {extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="breadcrumb pinet-breadcrumb"}
					{li}
						{a uri="home/index"}{lang}首页{/lang}{/a}
					{/li}
					{li}
						{a uri="user/bestpay_coupon"}{lang}我的翼百{/lang}{/a}
					{/li}
					{li class="active"}
						{a uri="user/orders"}{lang}我的订单{/lang}{/a}
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
								{li class="active"}{a uri="user/orders"}{lang}我的订单{/lang}{/a}{/li}
								{li}{a uri="user/my_address"}{lang}收货地址{/lang}{/a}{/li}
								{li}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
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
				{div id="bestpay_coupon" role="tabpanel"}
					{ul class="nav nav-tabs" role="tablist" id="myTab"}
						{if {$status}=='all'}
							{li role="presentation" class="active" id="ALL"  status="ALL"}
							{a uri="/user/orders/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class="" id="ALL"  status="ALL"}
							{a uri="/user/orders/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='nopay'}
							{li role="presentation" class='active' id="NOPAY" status="NOPAY"}
							{a uri="/user/orders/nopay" role="tab"  aria-controls="pending-charges"}{lang}待付款{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class='' id="NOPAY" status="NOPAY"}
							{a uri="/user/orders/nopay" role="tab"  aria-controls="pending-charges"}{lang}待付款{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='Assigned'}
							{li role="presentation" class="active" id="Assigned" status="Assigned"}
							{a uri="/user/orders/Assigned" role="tab"  aria-controls="to-shipped"}{lang}待收货{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class="" id="Assigned" status="Assigned"}
							{a uri="/user/orders/Assigned" role="tab"  aria-controls="to-shipped"}{lang}待收货{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='received'}
							{li role="presentation" class="active" id="Received" status="Received"}
							{a uri="/user/orders/received" role="tab"  aria-controls="confirm-goods"}{lang}已收货{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class="" id="Received" status="Received"}
							{a uri="/user/orders/received" role="tab"  aria-controls="confirm-goods"}{lang}已收货{/lang}{/a}
							{/li}
						{/if}
					{/ul}
					{div class="tab-content"}
						{row id="all-orders"  class="tab-pane active" role="tabpanel"}
							{ul class="title"}
								{li class="name"}{a}商品名称{/a}{/li}
								{li}{a}单价(元){/a}{/li}
								{li}{a}数量{/a}{/li}
								{li}{a}总价(元){/a}{/li}
								{li}{a}订单状态{/a}{/li}
								{li}{a}操作{/a}{/li}
							{/ul}
							{div id="orders_list"}
							{for $i=0;$i<count($merchants);$i++}
								{if count($orders[$merchants[$i]])>1 }
									{table class="list"}
										{tbody}
											{tr}
												{td class="title" colspan="7"}
													{div class="panel-header"}
														{span}订单编号：{$orders[$merchants[$i]][0]->order_number} {/span}
														{span}成交时间：{$orders[$merchants[$i]][0]->timestamp}{/span}{span}{$merchant_names[$i]['merchant_name']}{/span}
														{if {$orders[$merchants[$i]][0]->status}=="PAY" ||{$orders[$merchants[$i]][0]->status}=="Assigned" ||{$orders[$merchants[$i]][0]->status}=="Distributed" ||{$orders[$merchants[$i]][0]->status}=="Assigned"}

														{else}
															{a class="delete" value="{$orders[$merchants[$i]][0]->order_id}"}{lang}删除 {/lang}{/a}
														{/if}
													{/div}
												{/td}
											{/tr}
											{for $s=0;$s<count($orders[$merchants[$i]])-1;$s++}
												{if count($orders[$merchants[$i]])>1}
												{tr class="order-info"}
													{td class="name"}
														{a uri="product/show/{$orders[$merchants[$i]][$s]->product_id}"}{resimg data-image="{$orders[$merchants[$i]][$s]->path[0]}"}{/a}
														{div class="info"}
															{a uri="product/show/{$orders[$merchants[$i]][$s]->product_id}"}{$orders[$merchants[$i]][$s]->name}{/a}
														{/div}
													{/td}
													{td}{div class="line"}￥{$orders[$merchants[$i]][$s]->price}{/div}{/td}
													{td}{div class="line"}{$orders[$merchants[$i]][$s]->amount}{/div}{/td}
													{if $s<1}
														{td class="totle_price" rowspan=count($orders[$merchants[$i]])-1}{div class="line"}{a}￥{$orders[$merchants[$i]]['total_price']} {/a}{/div}{/td}
														{td class="status" rowspan=count($orders[$merchants[$i]])-1}
															{div class="line"}
																{a}{lang}{$orders[$merchants[$i]][$s]->status}{/lang}{/a}
																{a uri="user/order_details/{$orders[$merchants[$i]][0]->order_id}"} 订单详情{/a}
															{/div}
														{/td}
														{td class="pay"  rowspan=count($orders[$merchants[$i]])-1}
															{if {$orders[$merchants[$i]][$s]->status}=='NOPAY'}

																{div}{a class="status" uri="order/pay/{$orders[$merchants[$i]][$s]->order_id}"}付款{/a}
																	{a class="cancel" value="{$orders[$merchants[$i]][$s]->order_id}"}取消订单{/a}
																{/div}

															{/if}
														{if {$orders[$merchants[$i]][$s]->status}=='Assigned'}
															{div}{a class="confirm status" ht="{$orders[$merchants[$i]][$s]->order_id}"}确认收货{/a}
															{*{a class="cancel" value="{$orders[$merchants[$i]][$s]->order_id}"}取消订单{/a}*}
															{/div}
														{/if}
															{if {$orders[$merchants[$i]][$s]->status}=='PAY'}

																{div}{a class=""}{/a}
																{/div}
															{/if}

														{/td}
													{/if}
												{/tr}
												{else}
													{tr class="order-info"}
														{td class="name"}
															{a}{resimg data-image="{$orders[$merchants[$i]][$i]->path[1]}"}{/a}
															{div class="info"}
																{a}{$orders[$merchants[$i]][$i]->name}{/a}
															{/div}
														{/td}
														{td}
															{div class="line"}￥{$orders[$merchants[$i]][$i]->price}{/div}
														{/td}
														{td}{div class="line"}{$orders[$merchants[$i]][$i]->amount}{/div}{/td}
													{/tr}
												{/if}
											{/for}
										{/tbody}
									{/table}
									{else}
									{table class="list"}
										{tbody}
											{tr}
												{td class="title" colspan="6"}
													{div class="panel-header"}
														{span}订单编号：{$orders[$merchants[$i]][0]->order_number}{/span}{span} 成交时间：{$orders[$merchants[$i]][0]->create_date}{/span}{span}{$merchant_names[$i]->merchant_name}{/span}
														{if ({$orders[$merchants[$i]][0]->status}!='DISTRIBUTED')}
															{a class="delete" value="{$orders[$merchants[$i]][0]->order_id}"}{lang}删除{/lang}{/a}
														{/if}
													{/div}
												{/td}
											{/tr}
											{tr class="order-info"}
												{td class="name"}
													{a}{resimg data-image="{$orders[$merchants[$i]][0]->path[1]}"}{/a}
													{div class="info"}
													{a}{$orders[$merchants[$i]][0]->name}{/a}
													{/div}
												{/td}
												{td}{div class="line"}￥{$orders[$merchants[$i]][0]->price}{/div}{/td}
												{td}{div class="line"}{$orders[$merchants[$i]][0]->amount}{/div}{/td}
												{td class="totle_price"}{div class="line"}{a}￥{$orders[$merchants[$i]][0]->price}{/a}{/div}{/td}
												{td class="status"}
													{div class="line"}
														{a}{lang}{$orders[$merchants[$i]][0]->status}{/lang}{/a}
														{a uri="user/order_details/{$orders[$merchants[$i]][0]->order_id}"}订单详情{/a}
													{/div}
												{/td}
												{td class="pay"}
													{if ({$orders[$merchants[$i]][0]->status} != 'UserCancelled' && {$orders[$merchants[$i]][0]->status}!='DISTRIBUTED' && {$orders[$merchants[$i]][0]->status}!='RECEIVED')}
													{div}{a class="status" uri="order/pay/{$orders[$merchants[$i]][0]->order_id}"}付款{/a}{/div}
													{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}
													{/if}
												{/td}
											{/tr}
										{/tbody}
									{/table}
								{/if}
							{/for}
							{/div}
							{div id="pages"}
								{$pagestr}
							{/div}
						{/row}
					{/div}
				{/div}
				{div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
					{div class="modal-dialog"}
						{div class="modal-content"}
							{div class="modal-body"}
								{button type="button" class="close" data-dismiss="modal" aria-label="Close"}{span aria-hidden="true"}&times;{/span}{/button}
								{form name="user/order" action="{$form_action}"}
									{row}
										{field field="reason" label-class="col-lg-5" input-class="col-lg-4"}
											{select options=$cancel_reason label-field="name" value-field="id"}{/select}
										{/field}
									{/row}
									{row}
										{field field="instruction" label-class="col-lg-5" input-class="col-lg-4" layout="flase"}{textarea}{/textarea}{/field}
									{/row}
									<input type="test" name="id" id="id" style="display:none">
									<input type="test" name="status" id="status" style="display:none">
									{p}
										{submit value="确定" id="ok"}
										{submit value="关闭" id="close"}
									{/p}
								{/form}
							{/div}
						{/div}
					{/div}
				{/div}
			{/block}
