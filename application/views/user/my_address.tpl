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
						{lang}收货地址{/lang}
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
							{li class="active"}{a uri="user/my_address"}{lang}收货地址{/lang}{/a}{/li}
							{li}{a uri="user/bestpay_coupon"}{lang}我的翼百券{/lang}{/a}{/li}
							{li}{a uri="user/my_coupon"}{lang}我的优惠券{/lang}{/a}{/li}
							{/ul}
						{/li}
						{li}
							{span}{lang}我的账户{/lang}{/span}
							{ul class="sub-meau"}
								{li}{a uri="user/user_info"}{lang}个人信息{/lang}{/a}{/li}
								{li}{a uri="user/account"}{lang}账户设置{/lang}{/a}{/li}
							{/ul}
						{/li}
					{/ul}
				{/div}
				{div id="address_info" role="tabpanel"}
					{ul  class="nav nav-tabs" role="tablist" id="myTab"}
						{li role="presentation" class="active"}
							{a href="#info" role="tab" aria-controls="info" data-toggle="tab"}{lang}收货地址{/lang}{/a}
						{/li}
					{/ul}
					{div class="tab-content"}
						{row id="info"  class="tab-pane active" role="tabpanel"}
							{div id="dizhi" class="default"}
								{foreach from=$address item=foo}
								{p class="default_address"}
									{span}{$foo->place}{$foo->delivery_address}
									{$foo->consignee}  {$foo->mobile}{/span}
									{span class="status"}
										{if {$foo->default_address}==null}
											{a class="address_default" mit="{$foo->default_address}" addid="{$foo->id}"}设为默认{/a}
										{else}
											<font color="#FF0000">默认地址</font>
										{/if}
										{a class="edit"  mt="{$foo->default_address}" addid="{$foo->id}" address="{$foo->delivery_address}" consignee="{$foo->consignee}" mobile="{$foo->mobile}"}修改{/a}
										{a class="delete" cid="{$foo->id}"}删除{/a}
									{/span}
								{/p}
								{/foreach}
							{/div}
							{div class="address"}
								{form name="user/my_address"}
									{h4}{lang}添加新地址{/lang}{/h4}
									{row class="select" layout=[5,2,2]}
										{field label-class="col-lg-2" input-class="col-lg-4" field="province"}
											{select options=$province label-field="name" value-field="id"}
										{/select}
										{/field}
										{field field="city" label-class="col-lg-1" input-class="col-lg-6" layout="false"}
											{select label-field="name" value-field="id"}{/select}
										{/field}
										{field field="area" label-class="col-lg-1" input-class="col-lg-6" layout="false"}
											{select label-field="name" value-field="id"}{/select}
										{/field}
									{/row}
									{row class="info"}
										{field field="delivery_address" label-class="col-lg-2" input-class="col-lg-6"}{/field}
									{/row}
									{row  class="info"}
										{field field="consignee" label-class="col-lg-2" input-class="col-lg-6"}{/field}
									{/row}
									{row  class="info"}
									{field field="mobile" label-class="col-lg-2" input-class="col-lg-6"}{/field}
									{/row}

									<input type="text" name="default_address" id="default_address" style="display:none">
									<input type="text" name="id" id="id" value="{$cid}" style="display:none">
									{row class="checkbox"}
										{label}
											{if $checkbox!=null}
											{input type="checkbox" name="checkbox" id="checkbox" checked="checked"}设置为默认收货地址
											{else}
												{input type="checkbox" name="checkbox" id="checkbox" value="checked"}设置为默认收货地址
											{/if}
										{/label}
										{submit type="button" value="保存" id="preserve"}
									{/row}
								{/form}
							{/div}
						{/row}
					{/div}
				{/div}
			{/block}
