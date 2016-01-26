{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{ul class="breadcrumb pinet-breadcrumb"}
					{li}
						{a uri="home/index"}{lang}首页{/lang}{/a}
					{/li}
					{li}
						{a uri="user/bestpay_coupon"}{lang}我的翼百{/lang}{/a}
					{/li}
					{li class="active"}
						{lang}个人信息{/lang}
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
								{li}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
								{li}{a uri="user/my_coupon"}{lang}我的优惠券{/lang}{/a}{/li}
							{/ul}
						{/li}
						{li}
							{span}{lang}我的账户{/lang}{/span}
							{ul class="sub-meau"}
								{li class="active"}{a uri="user/user_info"}{lang}个人信息{/lang}{/a}{/li}
								{li}{a uri="user/account"}{lang}账户设置{/lang}{/a}{/li}
							{/ul}
						{/li}
					{/ul}
				{/div}
				{div id="user_info" role="tabpanel"}
					{ul  class="nav nav-tabs" role="tablist" id="myTab"}
						{li role="presentation" class="active"}
							{a href="#info" role="tab" aria-controls="info" data-toggle="tab"}{lang}个人信息{/lang}{/a}
						{/li}
					{/ul}
					{div class="tab-content"}
						{row id="info"  class="tab-pane active" role="tabpanel"}
							{form name="user/user_info"}
								{row}
									{field field="username" label-class="col-lg-1" input-class="col-lg-3"}{/field}
								{/row}
								{row}
									{label class="sex"}性别：{/label}
									{div class="radio"}
										{label}
											{if {$user_infos->sex}=='m'}
												<input type="radio" name="optionsRadios" id="radio1" value="option1" checked >
											{else}
												<input type="radio" name="optionsRadios" id="radio1" value="option1" >
											{/if}
											男
										{/label}
									{/div}
									{div class="radio"}
										{label}
											{if {$user_infos->sex}=='f'}
												<input type="radio" name="optionsRadios" id="radio2" value="option2" checked>
											{else}
												<input type="radio" name="optionsRadios" id="radio2" value="option2">
											{/if}
											女
										{/label}
									{/div}
								{/row}
								{row}
									{label class="brithday"}{lang}生日：{/lang}{/label}
									<select name="year1" id="year"></select>
									<select name="month1" id="month"></select>
									<select name="day1" id="day"></select>
								{/row}
								{row class="action"}
									{submit type="button" value="保存" id="preserve"}
								{/row}
							{field field="id" }{/field}
							{field field="uid" }{/field}
								<input type="text" name="year" id="my_year" value="{$birthday[0]}" style="display:none">
								<input type="text" name="month" id="my_month" value="{$birthday[1]}" style="display:none">
								<input type="text" name="day" id="my_day" value="{$birthday[2]}" style="display:none">
							{/form}
						{/row}
					{/div}
				{/div}
			{/block}