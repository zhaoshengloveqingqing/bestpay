{extends file="locallife-layout.tpl"}
			{block name="main-content"}
				{row class="channel"}
					{resimg data-image="lanmu.png"}
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
						{span}{lang}更多{/lang}{/span}
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
				{row class="list"}
					{lang}Developing{/lang}
				{/row}
			{/block}