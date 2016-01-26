{extends file='admin-layout.tpl'}
			{block name="main"}
				{div class="panel pinet-panel"}
					{div class="panel-body"}
						{row}
							{div class="left-meau"}
								{ul class="meau"}
									{li class="titles"}
										{span}{lang}订单管理{/lang}{/span}
									{/li}
									{li}
										{a}{lang}我的订单{/lang}{/a}
									{/li}
								{/ul}
							{/div}
							{div id="order_info" role="tabpanel"}
								{ul  class="nav nav-tabs" role="tablist" id="myTab"}
									{if {$status}=='all'}
										{li role="presentation" class="active" id="ALL"  status="ALL"}
										{a uri="/admin/merchant/orders/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="ALL"  status="ALL"}
										{a uri="/admin/merchant/orders/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
										{/li}
									{/if}
									{if {$status}=='NOPAY'}
										{li role="presentation" class='active' id="NOPAY" status="NOPAY"}
										{a uri="/admin/merchant/orders/NOPAY" role="tab"  aria-controls="pending-charges"}{lang}新订单{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class='' id="NOPAY" status="NOPAY"}
										{a uri="/admin/merchant/orders/NOPAY"  role="tab"  aria-controls="pending-charges"}{lang}新订单{/lang}{/a}
										{/li}
									{/if}
									{if {$status}=='PAY'}
										{li role="presentation" class="active" id="PAY" status="PAY"}
										{a uri="/admin/merchant/orders/PAY" role="tab"  aria-controls="to-shipped"}{lang}已支付{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="PAY" status="PAY"}
										{a uri="/admin/merchant/orders/PAY" role="tab"  aria-controls="to-shipped"}{lang}已支付{/lang}{/a}
										{/li}
									{/if}
									{if {$status}=='Distributed'}
										{li role="presentation" class="active" id="Distributed" status="Distributed"}
										{a uri="/admin/merchant/orders/Distributed" role="tab"  aria-controls="confirm-goods"}{lang}已分配{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="Distributed" status="Distributed"}
										{a uri="/admin/merchant/orders/Distributed" role="tab"  aria-controls="confirm-goods"}{lang}已分配{/lang}{/a}
										{/li}
									{/if}
									{if {$status}=='Assigned'}
										{li role="presentation" class="active" id="Assigned" status="Assigned"}
										{a uri="/admin/merchant/orders/Assigned" role="tab"  aria-controls="for-goods"}{lang}已配送{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class=""  id="Assigned" status="Assigned"}
										{a uri="/admin/merchant/orders/Assigned" role="tab"  aria-controls="for-goods"}{lang}已配送{/lang}{/a}
										{/li}
									{/if}

									{if {$status}=='Received'}
										{li role="presentation" class="active" id="Received" status="Received"}
										{a uri="/admin/merchant/orders/Received" role="tab"  aria-controls="confirm-goods"}{lang}已收货{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="Received" status="Received"}
										{a uri="/admin/merchant/orders/Received" role="tab"  aria-controls="confirm-goods"}{lang}已收货{/lang}{/a}
										{/li}
									{/if}
									{if {$status}=='UserCancelled'}
										{li role="presentation" class="active" id="UserCancelled" status="UserCancelled"}
										{a uri="/admin/merchant/orders/UserCancelled" role="tab"  aria-controls="confirm-goods"}{lang}用户取消{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="UserCancelled" status="UserCancelled"}
										{a uri="/admin/merchant/orders/UserCancelled" role="tab"  aria-controls="confirm-goods"}{lang}用户取消{/lang}{/a}
										{/li}
									{/if}

									{if {$status}=='MerCancelled'}
										{li role="presentation" class="active" id="MerCancelled" status="MerCancelled"}
										{a uri="/admin/merchant/orders/MerCancelled" role="tab"  aria-controls="confirm-goods"}{lang}商户取消{/lang}{/a}
										{/li}
									{else}
										{li role="presentation" class="" id="MerCancelled" status="MerCancelled"}
										{a uri="/admin/merchant/orders/MerCancelled" role="tab"  aria-controls="confirm-goods"}{lang}商户取消{/lang}{/a}
										{/li}
									{/if}
								{/ul}
								{div class="tab-content"}
									{row id="info"  class="tab-pane active" role="tabpanel"}
										{ul class="title"}
											{li class="name"}{a}商品信息{/a}{/li}
											{li}{a}单价(元){/a}{/li}
											{li}{a}数量{/a}{/li}
											{li}{a}买家信息{/a}{/li}
											{li}{a}实付款{/a}{/li}
											{li}{a}订单状态{/a}{/li}
											{li}{a}操作{/a}{/li}
										{/ul}
									{for $i=0;$i<count($merchants);$i++}
										{if count($orders[$merchants[$i]])>1}
											{table class="list"}
												{tbody}
													{tr}
														{td class="title" colspan="7"}
															{div class="panel-header"}
																{span}订单编号：{$orders[$merchants[$i]][0]->order_number} {/span}{span} 成交时间：{$orders[$merchants[$i]][0]->timestamp}{/span}{span}{$merchant_names[$i]->merchant_name}{/span}
															{if {$orders[$merchants[$i]][0]->status}=="PAY" ||{$orders[$merchants[$i]][0]->status}=="Assigned" ||{$orders[$merchants[$i]][0]->status}=="Distributed" ||{$orders[$merchants[$i]][0]->status}=="Assigned"}

															{else}
																{*{a class="delete" value="{$orders[$merchants[$i]][0]->order_id}"}{lang}删除 {/lang}{/a}*}
															{/if}
															{/div}
														{/td}
													{/tr}
													{for $s=0;$s<count($orders[$merchants[$i]])-1;$s++}
														{if count($orders[$merchants[$i]])>1}
															{tr class="order-info"}
																{td class="name"}
																	{a}{resimg data-image="{$orders[$merchants[$i]][$s]->path[0]}"}{/a}
																	{div class="info"}
																		{a}{$orders[$merchants[$i]][$s]->name}{/a}
																	{/div}
																{/td}
																{td}{div class="line"}￥{$orders[$merchants[$i]][$s]->price}{/div}{/td}
																{td}{div class="line"}{$orders[$merchants[$i]][$s]->amount}{/div}{/td}

																{if $s < 1}
																	{td class="user_info" rowspan=count($orders[$merchants[$i]])-1}
																	{div class="line"}
																	{span}{$orders[$merchants[$i]][$s]->consignee_name}{/span}
																	{span}{$orders[$merchants[$i]][$s]->consignee_mobile}{/span}
																	{/div}
																	{/td}
																	{td class="totle_price" rowspan=count($orders[$merchants[$i]])-1}{div class="line"}{a}￥{$orders[$merchants[$i]]['total_price']} {/a}{/div}{/td}
																		{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																			{div class="line"}
																				{a}{lang}{$orders[$merchants[$i]][$s]->status}{/lang}{/a}
																				{a uri="admin/merchant/order_details/{$orders[$merchants[$i]][0]->order_id}"} 订单详情{/a}
																			{/div}
																		{/td}
																			{if {$orders[$merchants[$i]][$s]->status}=='NOPAY'}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																					{div}
																						{*{a class="status" uri="order/pay/{$orders[$merchants[$i]][$s]->order_id}"}付款{/a}*}
																						{a class="cancel" value="{$orders[$merchants[$i]][$s]->order_id}"}取消订单{/a}
																					{/div}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][$s]->status}=='PAY'&& $current_merchants->parent==null}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																					{div}{a class="status" uri="admin/merchant/order_distribute/{$orders[$merchants[$i]][0]->order_id}"}分配{/a}{/div}
																					{div}{a class="status" uri="admin/merchant/deliver_goods/{$orders[$merchants[$i]][0]->order_id}"}发货{/a}{/div}
																					{*{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}*}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][$s]->status}=='PAY'&& $current_merchants->parent!=null}
																				{td class="status" rowspan=count($orders[$merchants[$s]])-1}
																					{div}{a class="status" uri="admin/merchant/deliver_goods/{$orders[$merchants[$i]][0]->order_id}"}发货{/a}{/div}
																					{*{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}*}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][0]->status}=='Distributed' &&  $current_merchants->parent!=''}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																					{div}{a class="status" uri="admin/merchant/deliver_goods/{$orders[$merchants[$i]][0]->order_id}"}发货{/a}{/div}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][0]->status}=='MerCancelled'||{$orders[$merchants[$i]][0]->status}=='Assigned'||{$orders[$merchants[$i]][0]->status}=='UserCancelled'}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][0]->status}=='Distributed' &&  $current_merchants->parent==null}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][0]->status}=='USED'}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																				{/td}
																			{/if}
																			{if {$orders[$merchants[$i]][0]->status}=='received'}
																				{td class="status" rowspan=count($orders[$merchants[$i]])-1}
																				{/td}
																			{/if}

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
															{span}订单编号：{$orders[$merchants[$i]][0]->order_number}{/span}{span} 成交时间：{$orders[$merchants[$i]][0]->timestamp}{/span}{span}{$merchant_names[$i]->merchant_name}{/span}
															{if $orders[$merchants[$i]]=='NOPAY' || $orders[$merchants[$i]]=='USERCANCELLED' || $orders[$merchants[$i]]=='RECEIVED' || $orders[$merchants[$i]]=='MERCANCELLED'}
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
													{td class="totle_price"}{div class="line"}{a}￥{$orders[$merchants[$i]]['total_price']}{/a}{/div}{/td}
													{td class="status"}
														{div class="line"}
															{a}{lang}{$orders[$merchants[$i]][0]->status}{/lang}{/a}
															{a uri="admin/merchant/order_details/{$orders[$merchants[$i]][0]->order_id}"}订单详情{/a}
														{/div}
													{/td}
													{if {$orders[$merchants[$i]][0]->status}=='NOPAY'}
														{td class="pay"}{div}{a class="status" uri="order/pay/{$orders[$merchants[$i]][0]->order_id}"}付款{/a}{/div}
														{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}{/td}
													{/if}
													{if {$orders[$merchants[$i]][0]->status}=='PAY'}
														{td class="pay"}{div}{a class="status" uri="admin/merchant/order_distribute/{$orders[$merchants[$i]][0]->order_id}"}分配{/a}{/div}
														{*{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}*}{/td}
													{/if}
													{if {$orders[$merchants[$i]][0]->status}=='Distributed'}
														{td class="pay"}{div}{a class="status" uri="admin/merchant/deliver_goods/{$orders[$merchants[$i]][0]->order_id}"}发货{/a}{/div}
														{*{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}*}{/td}
													{/if}
													{if {$orders[$merchants[$i]][0]->status}=='MerCancelled'}
														{td class="pay"}{div}{a}{/a}{/div}
															{*{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}*}{/td}
													{/if}
												{/tr}
											{/tbody}
										{/table}
									{/if}
								{/for}
									{/row}
								{/div}
							{div id="pages"}
							{$pagestr}
							{/div}
							{/div}
							{div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
								{div class="modal-dialog"}
									{div class="modal-content"}
										{div class="modal-body"}
											{button type="button" class="close" data-dismiss="modal" aria-label="Close"}{span aria-hidden="true"}&times;{/span}{/button}
											{form name="admin/merchant/orders"}
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
						{/row}
					{/div}
				{/div}
			{/block}


