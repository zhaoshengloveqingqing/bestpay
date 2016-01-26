{extends file="locallife-layout.tpl"}
			{block name="main-content"}
				{*{row class="channel"}*}
					{*{resimg data-image="/car/lanmu.png"}*}
				{*{/row}*}
				{*{row class="category"}*}
					{*{div class="row filter"}*}
						{*{p class="column"}{lang}Category{/lang} {/p}*}
						{*{ul id="l2" data-level="2" class="layer"}*}
							{*{template}*}
								{*{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}*}
							{*{/template}*}
						{*{/ul}*}
					{*{/div}*}
					{*{div class="row filter"}*}
						{*{p class="column"}{lang}Breed{/lang} {/p}*}
						{*{ul id="l3" data-level="3" class="layer"}*}
						{*{template}*}
							{*{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}*}
						{*{/template}*}
						{*{/ul}*}
					{*{/div}*}
					{*{div class="row filter"}*}
						{*{p class="column"}{lang}Brand{/lang} {/p}*}
						{*{ul id="l4" data-level="4" class="layer"}*}
							{*{template}*}
								{*{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}*}
							{*{/template}*}
						{*{/ul}*}
					{*{/div}*}
				{*{/row}*}
				{row class="channel"}
					{resimg data-image="/mall/lanmu.png"}
				{/row}
				{row}
					{ul class="nav nav-pills nav-title"}
						{li role="presentation" class="nav-classify__title"}
							{div class="media"}
								{div class="media-body"}
									{h3}{lang}搜索结果{/lang}{span}HOTBRAND{/span}{/h3}
								{/div}
							{/div}
						{/li}
					{/ul}
				{/row}
				{row class="list"}
					{*{listview id="car_index"  name='car_index'}*}
					{div id="search_index"}
						{ul class="search_list"}
						{foreach from=$products key=k item=product}
							{li class="item listview_item_template"}
								{div class="thumbnail product-thumbnail"}
									{a class="thumbnail__link" uri="product/show/{$product->id}"}
										{resimg data-image="{$product->path}"}
									{/a}
									{div class="caption"}
										{p}{span class="price"}￥{$product->discount_price}{/span}{span class="yuanprice"}￥{$product->price}{/span}{/p}
										{a uri="product/show/{$product->id}" }
											{p class="product_name"}{$product->name}{/p}
										{/a}
										{p}{$product->note}{/p}
									{/div}
								{/div}
							{/li}
						{/foreach}
						{/ul}
						{if count($products)==''}
							{p class='no-result'}
								没有数据
							{/p}
						{/if}
					{/div}
					{*{/listview}*}
					{*{resimg data-image="/coupon/lanmu.png"}*}
				{/row}
			{/block}