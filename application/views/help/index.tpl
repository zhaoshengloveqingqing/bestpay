{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{div id="help"}
					{row}
						{h1 class="text-center"}
							{lang}Bestpay{/lang}
						{/h1}
					{/row}
					{row}
						{ul class="text-center"}
							{li}
								{a class="thumbnail__link" uri="help/introduction"}
									{resimg data-image="login_pic_v2.png"}
									{h3}{lang}Bestpay Introduction{/lang}{/h3}
									{p}{lang}Learn About Bestpay{/lang}{/p}
								{/a}
							{/li}
							{li}
								{a}
									{resimg data-image="login_pic_v2.png"}
									{h3}{lang}Frequently Questions{/lang}{/h3}
									{p}{lang}Questions Details{/lang}{/p}
								{/a}
							{/li}
						{/ul}
					{/row}
				{/div}
			{/block}
