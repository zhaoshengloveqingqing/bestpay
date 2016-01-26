{extends file='admin-layout.tpl'}
	{block name="head"}
		{div id="header"}		
			{h1}{picture src="logo.png" medias=[1440=>100, 640=>100,320=>50]}{/h1}
		{/div}
	{/block}	
	{block name="main"}
		{container}			
			{row class="login"  layout=[6,12] layout-lg=[6,6]}
				{h3}{picture src="login_pic_v2.png"}{/h3}
				{div}			
					{form name="admin/login"}
						{h3}{lang}Merchant Login{/lang}{/h3}
						{row layout=[10] layout-lg=[8]}
							{field field="username"}{/field}
						{/row}
						{row layout=[10] layout-lg=[8]}
							{field field="password"}{password}{/field}
						{/row}
						{row class="action"}
							{submit value="Login"}
						{/row}
					{/form}
				{/div}
			{/row}
		{/container}
	{/block}
	{block name="foot"}
		{div class="copyright"}
			©Copyright Pinet Technology Solutions 2014
		{/div}
	{/block}
