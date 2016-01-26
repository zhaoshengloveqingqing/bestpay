{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{div id="coupon-list" class="panel pinet-panel"}
					{div class="panel-body"}
						{listview name='admin_coupon_index'}
							{li style="" class="item listview_item_template"}
								{div class="thumbnail product-thumbnail"}
									{a class="thumbnail__link" uri="product/show/_(products_id)"}
										{picture src="deli/home/cheese-1_large.jpeg"}
									{/a}
									{div class="caption"}
										{h3 class="product-thumbnail__title"}
											{a class="link" uri="product/show/_(products_id)"}
												{span class="title"}_(products_name){/span}
												{span class="introduction"}_(products_note){/span}
											{/a}
										{/h3}
										{p class="product-thumbnail__detail"}{/p}
										{div class="product-thumbnail__footer"}
											{div class="coupon-info"}
												{div class="validity"}
													{span}
														{lang}Effective Date{/lang}{strong}_(products_expire_date){/strong}
													{/span}
												{/div}
											{/div}
										{/div}
									{/div}
								{/div}
							{/li}
						{/listview}
					{/div}
				{/div}
			{/block}

