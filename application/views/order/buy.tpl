{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{row class="filter"}
					{div id="mycoupon"}
						{if $product->id !=null}
						{form name="order/buy" action="$form_action"}
							{ul class="pinet-list-group listview_title"}
								{li class="pinet-list-group__item pinet-list-group__item--picture"}{lang}Goods Picture{/lang}{/li}
								{li class="pinet-list-group__item pinet-list-group__item--info"}{lang}Purchase Name{/lang}{/li}
								{li class="pinet-list-group__item  pinet-list-group__item--price"}{lang}Price{/lang}{/li}
								{li class="pinet-list-group__item  pinet-list-group__item--number"}{lang}Number{/lang}{/li}
								{li class="pinet-list-group__item pinet-list-group__item--totalprice"}{lang}Totle Price{/lang}{/li}
							{/ul}
							{ul class="pinet-list-group list_info"}
								{li class="pinet-list-group__item pinet-list-group__item--picture"}
									{div class="pinet-card"}
										{div class="pinet-card__media"}
											{a href="#"}
												{resimg data-image="{$product->path}"}
											{/a}
										{/div}
									{/div}
								{/li}
								{li class="pinet-list-group__item pinet-list-group__item--info"}
									{div class="pinet-card"}
										{div class="pinet-card__body"}
											{h3}{$product->name}{/h3}
											{p}{$product->create_date}{/p}
										{/div}
									{/div}
								{/li}
								{li class="pinet-list-group__item  pinet-list-group__item--price"}
									￥{span id="price"}{$product->discount_price}{/span}
								{/li}
								{li id="number1" class="pinet-list-group__item pinet-list-group__item--number"}
									{div id="tab" class="input-group"}
										{span type="button" class="input-group-addon min"}-{/span}
										{input class="text_box form-control" id="number" name="number" type="text" value="{$product->number}" }
										{span type="button" class="input-group-addon add"}+{/span}
									{/div}
								{/li}
								{li class="pinet-list-group__item pinet-list-group__item--totalprice"}
									￥{span id="total_Price"}{/span}
								{/li}
							{/ul}
							{ul class="totalPrice text-right"}
								{li class="pinet-list-group__item pinet-list-group__item--totalPrice"}
									{lang}Totle Price{/lang}: ￥{span id="totalPrice"}{/span}
								{/li}
							{/ul}
							{field field="id" state="hidden"}
							{/field}
							{field field="name" state="hidden"}
							{/field}
							{field field="discount_price" state="hidden"}
							{/field}
							{ul class="text-right"}
								{li class="pinet-list-group__item pinet-list-group__item--submit"}
									{submit value="Submit Orders"}
								{/li}
							{/ul}
						{/form}
						{else}
							{form name="order/buy" action="$form_action"}
								{foreach $productByCart as $k=>$v}
									{ul class="pinet-list-group listview_title"}
									{li class="pinet-list-group__item pinet-list-group__item--picture"}{lang}Goods Picture{/lang}{/li}
									{li class="pinet-list-group__item pinet-list-group__item--info"}{lang}Purchase Name{/lang}{/li}
									{li class="pinet-list-group__item  pinet-list-group__item--price"}{lang}Price{/lang}{/li}
									{li class="pinet-list-group__item  pinet-list-group__item--number"}{lang}Number{/lang}{/li}
									{li class="pinet-list-group__item pinet-list-group__item--totalprice"}{lang}Totle Price{/lang}{/li}

									{/ul}
									{ul class="pinet-list-group list_info"}
									{li class="pinet-list-group__item pinet-list-group__item--picture"}
									{div class="pinet-card"}
									{div class="pinet-card__media"}
									{a href="#"}
									{resimg data-image="{$v->path}"}
									{/a}
									{/div}
									{/div}
									{/li}
									{li class="pinet-list-group__item pinet-list-group__item--info"}
									{div class="pinet-card"}
									{div class="pinet-card__body"}
									{h3}{$v->name}{/h3}
									{p}{$v->create_date}{/p}
									{/div}
									{/div}
									{/li}
									{li class="pinet-list-group__item  pinet-list-group__item--price"}
										￥{span id="price"}{$v->discount_price}{/span}
									{/li}
									{li id="number1" class="pinet-list-group__item pinet-list-group__item--number"}
									{div id="tab" class="input-group"}
									{span type="button" class="input-group-addon min"}-{/span}
									{input class="text_box form-control" id="number" name="number" type="text" value="{$v->amount}" }
									{span type="button" class="input-group-addon add"}+{/span}
									{/div}
									{/li}
									{li class="pinet-list-group__item pinet-list-group__item--totalprice"}
										￥{span id="total_Price"}{/span}
									{/li}
									{/ul}
									{ul class="totalPrice text-right"}
									{li class="pinet-list-group__item pinet-list-group__item--totalPrice"}
									{lang}Totle Price{/lang}: ￥{span id="totalPrice"}{/span}
									{/li}
									{/ul}
									{field field="id" state="hidden"}
									{/field}
									{field field="name" state="hidden"}
									{/field}
									{field field="discount_price" state="hidden"}
									{/field}
								{/foreach}
							{ul class="text-right"}
							{li class="pinet-list-group__item pinet-list-group__item--submit"}
							{submit value="Submit Orders"}
							{/li}
							{/ul}
							{/form}
						{/if}
					{/div}
				{/row}
			{/block}