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
					{form class="search-form"}
						{div class="input-group"}
							{input type="text" class="form-control" placeholder="Search"}
							{span class="input-group-btn"}
								{button class="btn btn-default" type="button"}{lang}Search{/lang}{/button}
							{/span}
						{/div}
					{/form}
				{/div}
			{/div}
			{div class="top_logo"}
				{div class="navbar"}
					{div class="navbar__brand"}
						{resimg data-image="logo.png"}
					{/div}
					{div class="navbar__section navbar__action"}
						{resimg data-image="phone.png"}
					{/div}
				{/div}
			{/div}
			{navigation class="navbar-nav" actions=$navi}{/navigation}
		{/row}
	{/block}
	{block name="main"}
	{/block}
	{block name="foot"}
		{button class="back_btn"}ddd{/button}
		{button class="login_block_btn"}ddd{/button}
		{button class="back_block_btn"}ddd{/button}
		{button class="add_btn"}ddd{/button}
		{button class="gray_btn"}ddd{/button}
		{button class="green_btn"}ddd{/button}
		{button class="orange_btn"}ddd{/button}
		{footer}
			{ul}
				{li}{a}{i class="top"}{/i}返回顶部{/a}{/li}
				{li}{a}{i class="bestpay"}{/i}我的翼百{/a}{/li}
				{li}{a}{span class="shop_num"}0{/span}{i class="shopping"}{/i}购物车{/a}{/li}
			{/ul}
		{/footer}
	{/block}
