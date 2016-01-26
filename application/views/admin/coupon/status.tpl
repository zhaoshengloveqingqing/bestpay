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
			{row layout=[10] layout-lg=[6]}
				{form name="admin/coupon/status"}
					{row}
						{field field="coupon_code"}{/field}
					{/row}
					{row class="action"}
	                    {submit type="button" value="Search" id="search-btn"}
					{/row}
				{/form}			
			{/row}			
		{/container}
	{/block}