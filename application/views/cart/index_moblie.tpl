{extends file="locallife-out.tpl"}
	{block name="main"}
		{row class="content"}
			{p}
				您的购物车还是空的,<br/>赶紧行动吧!
			{/p}
			{p}
				{a uri="home/index"}{button type="button" class="btn btn-default"}马上去购物{/button}{/a}
			{/p}
		{/row}
	{/block}