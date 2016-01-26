{extends file='admin-layout.tpl'}
	{block name="main"}
		{container}
			{row}
				{form name="admin/user_create"}
					{row layout=[6, 6] layout-lg=[4, 8]}
						{field field="username"}{/field}
						{field field="password"}{password}{/field}
					{/row}
					{row class="action"}
						{submit}
					{/row}
				{/form}
			{/row}
		{/container}
	{/block}
