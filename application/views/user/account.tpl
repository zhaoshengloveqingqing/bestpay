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
						{lang}账户设置{/lang}
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
								{li}{a uri="user/user_info"}{lang}个人信息{/lang}{/a}{/li}
								{li class="active"}{a  uri="user/account"}{lang}账户设置{/lang}{/a}{/li}
							{/ul}
						{/li}
					{/ul}
				{/div}
				{div id="account_info" role="tabpanel"}
					{ul  class="nav nav-tabs" role="tablist" id="myTab"}
						{li role="presentation" class="active"}
							{a href="#info" role="tab" aria-controls="info" data-toggle="tab"}{lang}账户设置{/lang}{/a}
						{/li}
					{/ul}
					{div class="tab-content"}
						{row id="info"  class="tab-pane active" role="tabpanel"}
							{row class="line"}
								{img uri="responsive/size/16/user/icon4.png"}
								{label}{lang}邮箱{/lang}{/label}
								{span}{lang}{$user_infos->email} {/lang}{/span}
								{a class="email_edit" id={$user_infos->id}}修改{/a}
							{/row}
							{row class="line"}
								{img uri="responsive/size/16/user/icon4.png"}
								{label}{lang}手机号{/lang}{/label}
								{span}{lang}{$user_infos->mobile} {/lang}{/span}
								{a class="phone_edit"}修改{/a}
							{/row}
						{/row}
					{/div}
				{/div}
				<!-- Modal -->
				{div class="modal fade" id="myemail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
					{div class="modal-dialog"}
						{div class="modal-content"}
							{div class="modal-header"}
								{button type="button" class="close" data-dismiss="modal" aria-label="Close"}
									{span aria-hidden="true"}&times;{/span}
								{/button}
								{h4 class="modal-title"}修改邮箱{/h4}
							{/div}
							{div class="modal-body body_email"}
								{form name="user/account"}
									{field field="email" label-class="col-lg-3" input-class="col-lg-9"}{/field}
									{submit id="preserve" cid="{$user_infos->id}" email="{$user_infos->email}"}
								{field field="id"}{/field}
								{/form}
							{/div}
						{/div}
					{/div}
				{/div}
				<!-- Modal -->
				{div class="modal fade" id="myphone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"}
					{div class="modal-dialog"}
						{div class="modal-content"}
							{div class="modal-header"}
								{button type="button" class="close" data-dismiss="modal" aria-label="Close"}
									{span aria-hidden="true"}&times;{/span}
								{/button}
								{h4 class="modal-title"}修改手机号{/h4}
							{/div}
							{div class="modal-body"}
							{form id="sns_login_form" name="user/account" method="post" action="account_submit"}
									{field field="mobile" label-class="col-lg-3" input-class="col-lg-9"}{/field}
									{div class="phonecode"}
										{field field="validation" label-class="col-lg-3" input-class="col-lg-5"}{/field}
										{a id="code" class="code"  sendsmsurl="{$url}"}{lang}获取验证码{/lang}{/a}
									{/div}
									{div class="preserve"}
									{input id="validationsubmit" type="submit" disabled="disabled" class="btn pinet-btn-cyan submit-button" value="确认"}
									{/div}
									<input type="hidden" name="callback" value="http://user.pinet.co/api/login_success">
									<input id="appid" name="appid" type="hidden" value="-1"/>
									<input id="token" name="token" type="hidden" value="{$token}"/>
								{/form}
							{/div}
						{/div}
					{/div}
				{/div}
			{/block}