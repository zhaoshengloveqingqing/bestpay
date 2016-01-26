{extends file="locallife-layout.tpl"}
	{block name="main-content"}
		{row class="place"}
			{ul class="breadcrumb pinet-breadcrumb"}
				{li}
					{a uri="#"}{lang}Home{/lang}{/a}
				{/li}
				{li class="active"}
					{lang}我的购物车{/lang}
				{/li}
			{/ul}
		{/row}
		{row class="content"}
			{p}您的购物车还是空的，<br/>
			赶紧行动吧!{/p}
			{p}
				{a uri="home/index"}{button type="button" class="btn btn-default"}马上去购物{img uri="responsive/size/40/cart/shopping_btn_bg.png"}{/button}{/a}
			{/p}
		{/row}
	{/block}