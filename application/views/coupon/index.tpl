{extends file="locallife-layout.tpl"}
			{block name="main-content"}
				{row class="channel"}
					{resimg data-image="/coupon/lanmu.png"}
				{/row}
				{row class="category"}
					{div class="row filter"}
						{p class="column"}{lang}Category{/lang} {/p}
						{ul id="l2" data-level="2" class="layer"}
							{template}
								{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}
							{/template}
						{/ul}
					{/div}
					{div class="row filter"}
						{p class="column"}{lang}Breed{/lang} {/p}
						{ul id="l3" data-level="3" class="layer"}
							{template}
								{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}
							{/template}
						{/ul}
					{/div}
					{div class="row filter"}
						{p class="column"}{lang}Brand{/lang} {/p}
						{ul id="l4" data-level="4" class="layer"}
							{template}
								{li data-id="_(path)"}{a href="javascript:void(0)"}_(name){/a}{/li}
							{/template}
						{/ul}
					{/div}
				{/row}
				{row}
					{ul class="nav nav-pills nav-title"}
						{li role="presentation" class="nav-classify__title"}
							{div class="media"}
								{div class="media-body"}
									{h3}{lang}推荐商品{/lang}{span}HOTBRAND{/span}{/h3}
								{/div}
							{/div}
						{/li}
						{li role="presentation"}
							{action}{lang}销量{/lang}{/action}
						{/li}
						{li role="presentation"}
							{action}{lang}价格{/lang}{/action}
						{/li}
						{li role="presentation"}
							{a}{lang}时间{/lang}{/a}
						{/li}
					{/ul}
				{/row}
				{row class="list"}
					{listview id="coupon_index"  name='coupon_index'}
						{li class="item listview_item_template"}
							{div class="thumbnail product-thumbnail"}
								{a class="thumbnail__link" uri="product/show/_(products_id)"}
									{resimg data-image="_(product_photos_path)"}
								{/a}
								{div class="caption"}
									{p}{span class="price"}￥_(products_discount_price){/span}{span class="yuanprice"}￥_(products_price){/span}{/p}
									{a uri="product/show/_(products_id)"}
										{p class="product_name"}_(products_name){/p}
									{/a}
									{p}没有数据没有数据没有数据没有数据没有数据没有数据没有数据没有数据没有数据没有数据没有数据没有数据{/p}
								{/div}
							{/div}
						{/li}
						{p class='listview-no-result'}
							没有数据
						{/p}
					{/listview}
					{resimg data-image="/mall/lanmu.png"}
				{/row}
			{/block}