{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="nav nav-pills nav-classify"}
					{li role="presentation" class="nav-classify__title"}
						{div class="media"}
							{div class="media-left"}
							{/div}
							{div class="media-body"}
								{h3}{lang}Popular Discount{/lang}{/h3}
							{/div}
						{/div}
					{/li}
					{li role="presentation" class="active"}
						{action action=$all}{/action}
					{/li}
					{li role="presentation"}
						{action action=$food}{/action}
					{/li}
					{li role="presentation"}
						{action action=$beauty}{/action}
					{/li}
					{li role="presentation"}
						{action action=$recreation}{/action}
					{/li}
				{/ul}
				{div id="coupon-list" class="panel pinet-panel"}
					{div class="panel-body"}
						{listview name='home_index'}
							{li style="" class="item listview_item_template"}
								{div class="thumbnail product-thumbnail"}
									{a class="thumbnail__link" uri="product/show/_(products_id)"}
										{resimg data-image="_(product_photos_path)"}
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
											{div class="amount"}
											{span}{lang}Price{/lang}{b}_(products_price){/b}{/span}
											{span}{lang}Discount Price{/lang}{b}_(products_discount_price){/b}{/span}
											{span}{lang}Inventory{/lang}{b}_(products_amount){/b}{/span}
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

