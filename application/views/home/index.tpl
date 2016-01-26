{extends file="locallife-layout.tpl"}
			{block name="silder" append}
				{div id="banner"}
					{slider id="slider1_container" class='pinet-full-slider'}
						{slides items=$items}
							{literal}
								{div}
									{img u="image" uri=$item->url}
								{/div}
							{/literal}
						{/slides}
						{div u="navigator"}
							{div u="prototype"}{/div}
						{/div}
					{/slider}
				{/div}
			{/block}
			{block name="main-content" append}
				{row id="coupon-list-0"}
					{column class="col-xs-4"}
						{div class="panel"}
							{div class="panel-header"}
								{h2}{lang}New Product{/lang}{/h2}
								{div class="color"}{/div}<hr>
							{/div}
							{div class="panel-body"}
								{slider class='new_product' id="news"}
									{slides items=$left_one}
										{literal}
											{div}
												{a class="link"}
													{img u="image" uri=$item->url}
												{/a}
											{/div}
										{/literal}
									{/slides}
										{div u="navigator"}
										{div u="prototype"}{/div}
										{/div}
								{/slider}
							{/div}
						{/div}
					{/column}
					{column class="col-xs-4"}
						{div class="panel"}
							{div class="panel-header"}
								{h2}{lang}Waiting{/lang}{/h2}
								{div class="color"}{/div}<hr>
							{/div}
							{div class="panel-body"}
								{ul}
									{li}
										{i class="type"}{lang}秒杀{/lang}{/i}
										{a class="link" uri="product/show/{$news->id}"}
											{resimg data-image=$news->path}
											{p}
												{span class="title"}{$news->name}{/span}
												{span class="price"}￥{$news->discount_price}{/span}
											{/p}
										{/a}
									{/li}
									{li}
										{i class="type"}{lang}推荐{/lang}{/i}
										{a class="link" uri="product/show/{$rec->id}"}
											{resimg data-image=$rec->path}
											{p}
												{span class="title"}{$rec->name}{/span}
												{span class="price"}￥{$rec->discount_price}{/span}
											{/p}
										{/a}
									{/li}
									{li}
										{i class="type"}{lang}低价{/lang}{/i}
										{a class="link" uri="product/show/{$low_price->id}"}
											{resimg data-image=$low_price->path}
											{p}
												{span class="title"}{$low_price->name}{/span}
												{span class="price"}￥{$low_price->discount_price}{/span}
											{/p}
										{/a}
									{/li}
									{li}
										{i class="type"}{lang}众筹{/lang}{/i}
										{a class="link" uri="product/show/{$congregation->id}"}
											{resimg data-image=$congregation->path}
											{p}
												{span class="title"}{$congregation->name}{/span}
												{span class="price"}￥{$congregation->discount_price}{/span}
											{/p}
										{/a}
									{/li}
								{/ul}

							{/div}
						{/div}
					{/column}
					{column class="col-xs-4"}
						{div class="panel"}
							{div class="panel-header"}
								{h2}{lang}Service{/lang}{/h2}
									{a uri="people/index" class="text-right"}{lang}More{/lang}&raquo;{/a}
								{div class="color"}{/div}<hr>
							{/div}
							{div class="panel-body"}
								{ul class="service"}
									{jdatagrid class="service" items=$servicetop}
										{literal}
											{li}
												{a class="link"}
												{/a}
											{/li}
										{/literal}
									{/jdatagrid}
								{/ul}
							{/div}
						{/div}
					{/column}
				{/row}
				{row id="coupon-list-1"}
					{div class="panel pinet-panel"}
						{div class="panel-header"}
							{h2}{img uri="responsive/size/40/perferential_icon.png"}{lang}Preferential Life{/lang}{/h2}
								{a uri="mall/index" class="text-right"}{lang}More{/lang}&raquo;{/a}
							{div class="color"}{/div}<hr>
						{/div}
						{div class="panel-body"}
							{column class='col-xs-6 scroll'}
								{slider class='list_product' id="perferential"}
									{slides items=$left_two}
										{literal}
											{div}
												{a class="link"}
													{img u="image" uri=$item->url}
												{/a}
											{/div}
										{/literal}
									{/slides}
									{div u="navigator"}
										{div u="prototype"}{/div}
									{/div}
								{/slider}
							{/column}
							{column class='col-xs-6 product'}
								{ul items=$benefit}
									{literal}
										{li}
											{div class="thumbnail product-thumbnail"}
												{a class="link" uri="product/show/{$item->id}"}
													{resimg data-image=$item->path}
												{/a}
												{div class="caption"}
													{a class="link" uri="product/show/{$item->id}"}{span class="title"}{$item->name}{/span}{/a}
													{span class="price"}￥{$item->discount_price}{/span}
												{/div}
											{/div}
										{/li}
									{/literal}
								{/ul}
							{/column}
						{/div}
					{/div}
				{/row}
				{row id="coupon-list-2"}
					{div class="panel pinet-panel"}
						{div class="panel-header"}
							{h2}{img uri="responsive/size/40/card.png"}{lang}Coupons Life{/lang}{/h2}
								{a uri="coupon/index" class="text-right"}{lang}More{/lang}&raquo;{/a}
							{div class="color"}{/div}<hr>
						{/div}
						{div class="panel-body"}
							{column class='col-xs-6 scroll'}
								{slider class='list_product' id="card"}
									{slides items=$left_three}
										{literal}
											{div}
												{a class="link"}
													{img u="image" uri=$item->url}
												{/a}
											{/div}
										{/literal}
									{/slides}
									{div u="navigator"}
										{div u="prototype"}{/div}
									{/div}
								{/slider}
							{/column}
							{column class='col-xs-6  product'}
								{ul items=$coupon}
									{literal}
										{li}
											{div class="thumbnail product-thumbnail"}
												{a class="link" uri="product/show/{$item->id}"}
													{resimg data-image=$item->path}
												{/a}
												{div class="caption"}
													{a class="link" uri="product/show/{$item->id}"}{span class="title"}{$item->name}{/span}{/a}
													{span class="price"}￥{$item->discount_price}{/span}
												{/div}
											{/div}
										{/li}
									{/literal}
								{/ul}
							{/column}
						{/div}
					{/div}
				{/row}
				{row id="coupon-list-1"}
					{div class="panel pinet-panel"}
						{div class="panel-header"}
							{h2}{img uri="responsive/size/40/car.png"}{lang}Car Life{/lang}{/h2}
								{a uri="car/index" class="text-right"}{lang}More{/lang}&raquo;{/a}
							{div class="color"}{/div}<hr>
						{/div}
						{div class="panel-body"}
							{column class='col-xs-6 scroll'}
								{slider class='list_product' id="car"}
									{slides items=$left_four}
										{literal}
											{div}
												{a class="link"}
													{img u="image" uri=$item->url}
												{/a}
											{/div}
										{/literal}
									{/slides}
									{div u="navigator"}
										{div u="prototype"}{/div}
									{/div}
								{/slider}
							{/column}
							{column class='col-xs-6  product'}
								{ul items=$car}
									{literal}
										{li}
											{div class="thumbnail product-thumbnail"}
												{a class="link" uri=""}
													{resimg data-image=$item->path}
												{/a}
												{div class="caption"}
													{a class="link" uri="car/index/{$item->id}"}{span class="title"}{$item->intro}{/span}{/a}
													{span class="price"}{$item->price}{/span}
												{/div}
											{/div}
										{/li}
									{/literal}
								{/ul}
							{/column}
						{/div}
					{/div}
				{/row}
				{row id="coupon-list-4"}
					{div class="panel pinet-panel"}
						{div class="panel-header"}
							{h2}{img uri="responsive/size/40/home.png"}{lang}Home life{/lang}{/h2}
							{a uri="people/index" class="text-right"}{lang}More{/lang}&raquo;{/a}
							{div class="color"}{/div}<hr>
						{/div}
						{div class="panel-body"}
							{column class='col-xs-6 scroll'}
								{slider class='list_product' id="home"}
									{slides items=$left_five}
										{literal}
											{div}
												{a class="link"}
													{img u="image" uri=$item->url}
												{/a}
											{/div}
										{/literal}
									{/slides}
									{div u="navigator"}
										{div u="prototype"}{/div}
									{/div}
								{/slider}
							{/column}
							{column class='col-xs-6  product'}
								{ul}
									{jdatagrid class="service" items=$service}
										{literal}
											{li class="item"}
												{a class="link"}
												{/a}
											{/li}
										{/literal}
									{/jdatagrid}
								{/ul}
							{/column}
						{/div}
					{/div}
				{/row}
			{/block}
