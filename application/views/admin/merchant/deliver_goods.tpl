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
								{a uri="admin/merchant/orders"}{lang}我的订单{/lang}{/a}
							{/li}
						{/ul}
					{/div}
					{div id="distribute_info" role="tabpanel"}
						{ul  class="nav nav-tabs" role="tablist" id="myTab"}
							{li role="presentation" class="active"}
								{a href="#all-orders" role="tab" aria-controls="all-orders"}{lang}分配单详情{/lang}{/a}
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
									{td}{div}{$order_details[$i]->totalprice}{/div}{/td}
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
										{for $foo=1 to 1}
											{td}分配明细{/td}
										{/for}
									{/thead}
									{tbody}
										{tr}
											{for $foo=1 to 1}
												{td}
													{div}
														{form name="admin/merchant/deliver_goods"}
															{row layout=[5,5,2]}
																{field label-class="col-lg-5" input-class="col-lg-7" field="distribution_company"}

																{/field}
																{field label-class="col-lg-5" input-class="col-lg-7" field="distribution_phone"}

																{/field}
																{submit value="Delivery" id="Delivery"}
																<input type="text" id="id" name="id" style="display:none" value="{$orders->id}">
															{/row}
														{field field="order_id" state="hidden"}{/field}
														{/form}
													{/div}
												{/td}
											{/for}
										{/tr}
									{/tbody}
								{/table}
							{/row}
						{/div}
					{/div}
				{/row}
			{/div}
		{/div}


		{*{row class="content"}*}
			{*{div class="panel"}*}
				{*{div class="panel-title"}*}
					{*{h4}发货单详情{/h4}*}
				{*{/div}*}
				{*{div class="panel-body"}*}
					{*{div class="info"}*}
						{*{p}订单号：{$order_details->order_number}{/p}*}
						{*{p}订购人：hzy{/p}*}
						{*{p}电话：15962143194{/p}*}
						{*{p}地址：江苏苏州市市辖区123{/p}*}
						{*{p}总数：{$order_details->amount}{/p}*}
						{*{p}总价：{$order_details->totalPrice}{/p}*}
					{*{/div}*}
					{*{table}*}
						{*{tbody}*}
							{*{tr}*}
								{*{td}名称{/td}*}
								{*{td}尺寸{/td}*}
								{*{td}颜色{/td}*}
								{*{td}数量{/td}*}
								{*{td}单价（元）{/td}*}
								{*{td}总价{/td}*}
							{*{/tr}*}
							{*{tr}*}
								{*{td}{$order_details->name}{/td}*}
								{*{td}hzy{/td}*}
								{*{td}15962143194{/td}*}
								{*{td}{$order_details->amount}{/td}*}
								{*{td}{$order_details->price}{/td}*}
								{*{td}{$order_details->totalPrice}{/td}*}
							{*{/tr}*}
						{*{/tbody}*}
					{*{/table}*}
				{*{/div}*}
				{*{div}*}
					{*{form name="admin/merchant/deliver_goods"}*}
						{*<input type="hidden" name="id" value="{$order_details->id}"/>*}
						{*{row class="action"}*}
						{*{submit value="Delivery"}*}
						{*{/row}*}
					{*{/form}*}
				{*{/div}*}
			{*{/div}*}
		{*{/row}*}
	{/block}


