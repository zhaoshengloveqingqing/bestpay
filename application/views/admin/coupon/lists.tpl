{extends file='admin-layout.tpl'}
	{block name="main"}
		{container}
			{ul class="nav nav-tabs" items=$actions}
			{literal}
				{li}
				{action action=$item}{/action}
				{/li}
			{/literal}
			{/ul}
			{*{row class="act"}*}
				{*{submit value="返回" id="search-btn" uri='/admin/coupon/record'}*}
			{*{/row}*}
			{row}
				{datatable name="admin_coupon_lists"}
			{/row}
		{/container}
	{/block}