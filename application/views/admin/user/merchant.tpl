{extends file='admin-layout.tpl'}
	{block name="main"}
		{container}
			{row id="toolbar"}
				{a class="btn btn-default" uri="admin/user/add_merchant"}
					{lang}Add{/lang}
				{/a}
			{/row}
			{row}
				{datatable name="admin_merchant"}
			{/row}
		{/container}
	{/block}
