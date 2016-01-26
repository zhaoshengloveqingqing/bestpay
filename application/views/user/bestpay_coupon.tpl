{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="breadcrumb pinet-breadcrumb"}
					{li}
						{a uri="#"}{lang}首页{/lang}{/a}
					{/li}
					{li}
						{a uri="mall/index"}{lang}我的翼百{/lang}{/a}
					{/li}
					{li class="active"}
						{lang}我的翼百券{/lang}
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
								{li class="active"}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
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
					{ul  class="nav nav-tabs" role="tablist" id="myTab"  activeindex=""}
						{if {$status}=='all'}
							{li role="presentation" class="active" id="ALL"  status="ALL"}
							{a uri="/user/bestpay_coupon/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class=""  id="ALL"  status="ALL"}
							{a uri="/user/bestpay_coupon/all" role="tab" aria-controls="all-orders"}{lang}全部订单{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='nopay'}
							{li role="presentation" class='active' id="NOPAY" status="NOPAY"}
							{a uri="/user/bestpay_coupon/nopay" role="tab"  aria-controls="pending-charges"}{lang}未付款{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class='' id="NOPAY" status="NOPAY"}
							{a uri="/user/bestpay_coupon/nopay" role="tab"  aria-controls="pending-charges"}{lang}未付款{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='pay'}
							{li role="presentation" class='active' id="NOUSE" status="NOUSE"}
							{a uri="/user/bestpay_coupon/pay" role="tab"  aria-controls="pending-charges"}{lang}未使用{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class='' id="NOUSE" status="NOUSE"}
							{a uri="/user/bestpay_coupon/pay" role="tab"  aria-controls="pending-charges"}{lang}未使用{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='use'}
							{li role="presentation" class='active' id="USE" status="USE"}
							{a uri="/user/bestpay_coupon/use" role="tab"  aria-controls="pending-charges"}{lang}已使用{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class='' id="USE" status="USE"}
							{a uri="/user/bestpay_coupon/use" role="tab"  aria-controls="pending-charges"}{lang}已使用{/lang}{/a}
							{/li}
						{/if}
						{if {$status}=='expired'}
							{li role="presentation" class='active' id="EXPIRED" status="EXPIRED"}
							{a uri="/user/bestpay_coupon/expired" role="tab"  aria-controls="pending-charges"}{lang}已过期{/lang}{/a}
							{/li}
						{else}
							{li role="presentation" class='' id="EXPIRED" status="EXPIRED"}
							{a uri="/user/bestpay_coupon/expired" role="tab"  aria-controls="pending-charges"}{lang}已过期{/lang}{/a}
							{/li}
						{/if}

					{/ul}
					{div class="tab-content"}
						{row id="non-payment"  class="tab-pane active" role="tabpanel"}
							{ul class="title"}
								{li class="name"}{a}商品信息{/a}{/li}
								{li}{a}单价(元){/a}{/li}
								{li}{a}数量{/a}{/li}
								{li}{a}总价(元){/a}{/li}
								{li}{a}订单状态{/a}{/li}
								{li}{a}操作{/a}{/li}
							{/ul}
							{*{listview id="bestpay_coupon_index" name='bestpay_coupon_index'}*}
								{*{li class="item listview_item_template"}*}
						{for $i=0;$i<count($merchants);$i++}
							{if count($orders[$merchants[$i]])>1}
								{table class="list"}
									{tbody}
										{tr}
											{td class="title" colspan="6"}
												{div class="panel-header"}
													{span}订单编号：{$orders[$merchants[$i]][0]->order_number} {/span}
													{span} 成交时间：{$orders[$merchants[$i]][0]->timestamp}{/span}
													{span}{$merchant_names[$i]->merchant_name}{/span}
													{if {$orders[$merchants[$i]][0]->c_status}!='PAY'}
														{a class="c_delete" value="{$orders[$merchants[$i]][0]->order_id}"}{lang}删除{/lang}{/a}
													{/if}

												{/div}
											{/td}
										{/tr}
										{for $s=0;$s<count($orders[$merchants[$i]])-1;$s++}
											{if count($orders[$merchants[$s]])>1}
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
														{td class="totle_price" rowspan=count($orders[$merchants[$i]])-1}{div class="line"}{a}￥{$orders[$merchants[$i]]['total_price']} {/a}{/div}{/td}
														{td class="status" rowspan=count($orders[$merchants[$i]])-1}
															{div class="line"}
																{if {$orders[$merchants[$i]][$s]->c_status}=='PAY'}
																	{a}{lang}NOUSE{/lang}{/a}
																{else}
																	{a}{lang}{$orders[$merchants[$i]][$s]->c_status}{/lang}{/a}
																{/if}
																{a uri="user/bestpay_coupon_details/{$orders[$merchants[$i]][$s]->order_id}"}订单详情{/a}
															{/div}
														{/td}
														{td class="pay"  rowspan=count($orders[$merchants[$i]])-1}
															{if {$orders[$merchants[$i]][$s]->c_status}=='NOPAY'}
																{div}{a class="status" uri="order/pay/{$orders[$merchants[$i]][$s]->order_id}"}付款{/a}
																	{a class="cancel" value="{$orders[$merchants[$i]][$s]->order_id}"}取消订单{/a}
																{/div}
															{/if}
															{if {$orders[$merchants[$i]][$s]->c_status}=='PAY'}
																{div}{a class="status" uri="user/bestpay_coupon_details/{$orders[$merchants[$i]][$s]->order_id}"}查看验券码{/a}
																{/div}
															{/if}
														{/td}
													{/if}
												{/tr}
												{else}
												{tr class="order-info"}
													{td class="name"}
														{a}{resimg data-image="{$orders[$merchants[$i]][$s]->path[1]}"}{/a}
														{div class="info"}
															{a}{$orders[$merchants[$i]][$s]->name}{/a}
														{/div}
													{/td}
													{td}
															{div class="line"}￥{$orders[$merchants[$i]][$s]->price}{/div}
													{/td}
													{td}{div class="line"}{$orders[$merchants[$i]][$s]->amount}{/div}{/td}
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
													{if ({$orders[$merchants[$i]][0]->c_status} != 'USE' )}
													{a class="c_delete" value="{$orders[$merchants[$i]][0]->order_id}"}{lang}删除{/lang}{/a}
													{/if}
												{/div}
											{/td}
										{/tr}
											{tr class="order-info"}
												{td class="name"}
													{a}{resimg data-image="{$orders[$merchants[$i]][0]->path[0]}"}{/a}
													{div class="info"}
														{a}{$orders[$merchants[$i]][0]->name}{/a}
													{/div}
												{/td}
												{td}{div class="line"}￥{$orders[$merchants[$i]][0]->price}{/div}{/td}
												{td}{div class="line"}{$orders[$merchants[$i]][0]->amount}{/div}{/td}
												{td class="totle_price"}{div class="line"}{a}￥{$orders[$merchants[$i]][0]->price}{/a}{/div}{/td}
												{td class="status"}
													{div class="line"}
														{a}{lang}{$orders[$merchants[$i]][0]->c_status}{/lang}{/a}
														{a uri="user/bestpay_coupon_details/{$orders[$merchants[$i]][0]->order_id}"}订单详情{/a}
													{/div}
												{/td}
												{td class="pay"}
												{if ({$orders[$merchants[$i]][0]->c_status} == 'NOPAY' )}
													{div}{a class="status"  uri="order/pay/{$orders[$merchants[$i]][0]->order_id}"}付款{/a}{/div}
													{a class="cancel" value="{$orders[$merchants[$i]][0]->order_id}"}取消订单{/a}
												{/if}
												{/td}
											{/tr}
									{/tbody}
								{/table}
							{/if}
						{/for}
						{/row}
						{div id="pages"}
							{$pagestr}
						{/div}
					{/div}
				{/div}
				{div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
					{div class="modal-dialog"}
						{div class="modal-content"}
							{div class="modal-body"}
								{button type="button" class="close" data-dismiss="modal" aria-label="Close"}{span aria-hidden="true"}&times;{/span}{/button}
								{form name="user/bestpay_coupon" action="{$form_action}"}
									{row}
										{field field="reason" label-class="col-lg-5" input-class="col-lg-4"}
											{select options=$cancel_reason label-field="name" value-field="id"}{/select}
										{/field}
									{/row}
									{row}
										{field field="instruction" label-class="col-lg-5" input-class="col-lg-4" layout="flase"}{textarea}{/textarea}{/field}
									{/row}
									<input type="test" name="id" id="id" style="display:none">
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