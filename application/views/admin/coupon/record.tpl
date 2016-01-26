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
			{row layout=[6,12] layout-lg=[12]}
				{form name="admin/coupon/record"}
					{row}
						{field field="branch"}
							{select prepend=$prepend options=$merchants label-field="name" value-field="id"}{/select}
						{/field}
					{/row}
					{row}
						{field field="group_purchase" layout="false"}
							{select prepend=$prepend label-field="name" value-field="id"}{/select}
						{/field}
					{/row}
					{row clsss="time"}
						{field field="start_time" id="start_time"}{/field}
						{field field="end_time" id="endtime"}{/field}
						{div class="list"}
							{a class="time" data-date-time="yesterday" uri=""}{lang}Yesterday{/lang}{/a}
							{a class="time" data-date-time="oneWeekBeforeNow" uri=""}{lang}Latest 7 days{/lang}{/a}
							{a class="time" data-date-time="oneMonthBeforeNow" uri=""}{lang}Latest 30 days{/lang}{/a}
						{/div}
					{/row}
					{row class="action"}
						{submit value="导出数据" id="search-btn"}
					{/row}
				{/form}
			{/row}
			{row}
				{datatable name="admin_coupon_record"}
			{/row}
		{/container}
	{/block}