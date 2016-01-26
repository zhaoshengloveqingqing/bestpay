{extends file='base-layout.tpl'}
	{block name="head"}
		{row id="header"}
			{div class="top_navbar"}
				{div class="top_navbar_content"}
					{ul class="nav navbar-nav top_navbar_left" items=$actions index="i"}
						{literal}
							{li}
							{action id="action-$i" action=$item}{/action}
							{/li}
						{/literal}
					{/ul}
					{ul class="top_navbar_right"}
						{li class="dropdown"}
							{a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"}
								{lang}My Bestpay{/lang}
								{span class="caret"}{/span}
							{/a}
							{div class="dropdown-menu" role="menu" aria-labelledby="dLabel"}
								{ul class="nav navbar-nav top_navbar_left" items=$my_bestpay index="i"}
									{literal}
										{li}
											{action id="action-$i" action=$item}{/action}
										{/li}
									{/literal}
								{/ul}
							{/div}
						{/li}
						{li}
							{a uri="help/index"}{lang}Know Bestpay{/lang}{/a}
						{/li}
						{li}
							{a uri="merchant/login"}{lang}Business Center{/lang}{/a}
						{/li}
						{li}
							{a}{lang}Contact Us{/lang}{/a}
						{/li}
					{/ul}
				{/div}
			{/div}
		{/row}
	{/block}
	{block name="main"}
		{sect name="main"}
			{block name="silder"}
			{/block}
			{div id="main-content"}
				{block name="main-content"}{** The main content of the layout **}{/block}
			{/div}
		{/sect}
	{/block}
	{div id="foot"}
		{block name="foot"}
			{row class="foot"}
				{div class="content"}
					{div class="foot_left"}
						{ul}
							{li}
								{resimg data-image="qr.png"}
							{/li}
							{li}
								扫描二维码，订阅翼支付官方微信<br><br>

								我们会在每个环节做到为您所需，
								为您提供最高品质的服务。
							{/li}
							{li}
								{resimg data-image="phone1.png"}
							{/li}
						{/ul}
					{/div}
					{div class="foot_right"}
						{ul}
							{li}
								{h3}关于翼百{/h3}
								{a}品牌故事{/a}
								{a}媒体报导{/a}
								{a}品牌合作{/a}
								{a}联系我们{/a}
							{/li}
							{li}
								{h3}售后服务{/h3}
								{a}订单查询{/a}
								{a}售后无忧{/a}
								{a}发票说明{/a}
								{a}留言建议{/a}
							{/li}
							{li}
								{h3}特别服务{/h3}
								{a}配送服务{/a}
								{a}全程冷链{/a}
								{a}渠道服务{/a}
								{a}加入我们{/a}
							{/li}
						{/ul}
					{/div}
				{/div}
			{/row}
			{row id="copyright"}
				{div class="copyright"} ©Copyright Pinet Technology Solutions 2014{/div}
			{/row}
		{/block}
	{/div}
