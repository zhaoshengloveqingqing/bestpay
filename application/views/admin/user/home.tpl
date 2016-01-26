{extends file='admin-layout.tpl'}
	{block name="main"}
		{container}
			{row id="toolbar"}
				{a class="btn btn-default" uri="admin/user/create"}
					{lang}Add{/lang}
				{/a}
			{/row}
			{row}
				{datatable name="admin_user_home"}
			{/row}
		{/container}
	{/block}
