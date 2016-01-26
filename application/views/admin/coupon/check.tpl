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
			{row  layout=[6,12] layout-lg=[12]}
				{form name="admin/coupon/check"}
					{row}
						{field field="coupon_code"}{/field}
					{/row}
					{row class="action"}
						{submit type="button" value="Validate" id="validate-btn"}
					{/row}
				{/form}
			{/row}
		{/container}
	{/block}