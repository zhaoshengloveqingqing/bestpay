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
										{img uri="responsive/size/21/order/stepbar-current-bg.png"}{span}2.付款完成{/span}
									{/li}
								{/ul}
							{/div}
						{/div}
					{/div}
				{/div}
			{/block}
			{block name="main-content" append}
				{row}
					{div id="success" class="panel pinet-panel"}
						{div class="panel-header"}
							{h3}
								{resimg data-image="/order/pay_success_bg.png"}
							{/h3}
						{/div}
						{div  class="panel-body"}
							{div class="media success-info"}

								{div class="media-left"}
								{for $i=0;$i<count($order_details);$i++}
									{if count($order_details[$i])>1}
										{for $s=0;$s<count($order_details[$i]);$s++}
										{h4}
											{lang}商品名称：{/lang}
											{a uri="product/show/{$order_details[$i][$s]->product_id}"}{b}{$order_details[$i][$s]->name}{/b}{/a}
										{/h4}
										{h4 class="media-heading"}
											{lang}付款金额：{/lang}
											{b}{$order_details[$i][$s]->total_price}{/b}{lang}Yuan{/lang}
										{/h4}
										{/for}
									{else}
										{h4}
											{lang}商品名称：{/lang}
											{a uri="product/show/{$order_details[$i][$i]->product_id}"}{b}{$order_details[$i][$i]->name}{/b}{/a}
										{/h4}
										{h4 class="media-heading"}
											{lang}付款金额：{/lang}
											{b}{$order_details[$i][$i]->total_price}{/b}{lang}Yuan{/lang}
										{/h4}
									{/if}

								{/for}
									{p}
										{a uri="user/orders"}
											{lang}返回我的翼百{/lang}
										{/a}
									{/p}
								{/div}

							{/div}
						{/div}
					{/div}
				{/row}
			{/block}
