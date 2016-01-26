{extends file='locallife-layout.tpl'}
			{block name="main-content" append}
				{row class="list"}
					{ul class="breadcrumb pinet-breadcrumb"}
						{li}
							{a uri="home/index"}{lang}Home{/lang}{/a}
						{/li}
						{li}
							{a uri="merchant/details"}{lang}Merchant{/lang}{/a}
						{/li}
						{li class="active"}
							{lang}{$merchant->name}{/lang}
						{/li}
					{/ul}
				{/row}
				{row class="merchant-details list" layout=[12, 12] layout-lg=[6, 6]}
					{a class="thumbnail__link" href="#"}
						{resimg data-image="lvyinge/merchant_info.jpg"}
					{/a}
					{div class="merchant-info"}
						{row}
							{span}{lang}Merchant Name{/lang}{/span}
							{strong}{$merchant->name}{/strong}
						{/row}
						{row}
							{span}{lang}Address{/lang}{/span}
							{strong}{lang}Address{/lang}{/strong}
						{/row}
						{row}
							{span}{lang}Phone{/lang}{/span}
							{strong}1225655566{/strong}
						{/row}
						{row}
							{span}{lang}Store Service{/lang}{/span}
							{strong}{lang}Support WIFI{/lang}{/strong}
						{/row}
						{row}
							{span}{lang}Store Introduction{/lang}{/span}
							{strong}{$merchant->description}{/strong}
						{/row}
					{/div}
				{/row}
				{div id="coupon-list" class="panel pinet-panel list"}
					{div class="panel-body"}
						{listview name='merchant_detail'}
							{li class="item listview_item_template"}
								{div class="thumbnail product-thumbnail"}
									{a class="thumbnail__link" uri="product/show/_(products_id)"}
										{resimg data-image="_(product_photos_path)"}
									{/a}
									{div class="caption"}
										{h3 class="product-thumbnail__title"}
											{a class="link" uri="product/show/_(products_id)"}
												{span class="title"}_(products_name){/span}
											{/a}
										{/h3}
									{/div}
								{/div}
							{/li}
						{/listview}
					{/div}
				{/div}
			{/block}