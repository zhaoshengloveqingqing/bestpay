{extends file='admin-layout.tpl'}
	{block name="head"}
		{div id="header"}
			{h1}{picture src="logo.png" medias=[1440=>100, 640=>100,320=>50]}{/h1}
		{/div}
		{div id="nav"}
			{ul class="nav nav-classify"}
				{li role="presentation"}
					{a uri="admin/user/coupon"}{lang}Check Coupon{/lang}{/a}
				{/li}
				{li role="presentation" }
					{a  uri="admin/user/coupon_status"}{lang}Customers Management{/lang}{/a}
				{/li}
				{li role="presentation"}
					{a uri="admin/user/coupon_record"}{lang}My Shop{/lang}{/a}
				{/li}
			{/ul}
		{/div}
	{/block}
	{block name="main"}
		{container}
			{ul class="nav nav-pills nav-classify"}
				{li role="presentation"}
					{a uri="admin/user/coupon"}{lang}Check Coupon{/lang}{/a}
				{/li}
				{li role="presentation"}
				{a uri="admin/user/coupon_status"}{lang}Coupon Voucher Status{/lang}{/a}
					{/li}
				{li role="presentation" class="active"}
					{a uri="admin/user/coupon_record"}{lang}Checked Coupon Record{/lang}{/a}
				{/li}
			{/ul}
			{row layout=[6,12] layout-lg=[12]}
				{form name="admin/coupon_record"}
					{row layout=[12] layout-lg=[12]}
						{field field="group_purchase" label-class="col-xs-12 col-lg-2" input-class="col-xs-12  col-lg-8"}
							{select prepend=$prepend options=$products label-field="name" value-field="id"}{/select}
						{/field}
					{/row}
					{row clsss="time" layout=[12,12] layout-lg=[4,3,1,1,1,1]}
						{field field="start_time" id="start_time" label-class="col-xs-12 col-lg-6" input-class="col-xs-12 col-lg-6"}{/field}
						{field field="end_time" label-class="col-xs-12 col-lg-1" input-class="col-xs-12 col-lg-9"}{/field}
						{a class="time" data-date-time="clearAll" uri=""}{lang}Clean{/lang}{/a}
						{a class="time" data-date-time="yesterday" uri=""}{lang}Yesterday{/lang}{/a}
						{a class="time" data-date-time="oneWeekBeforeNow" uri=""}{lang}Latest 7 days{/lang}{/a}
						{a class="time" data-date-time="oneMonthBeforeNow" uri=""}{lang}Latest 30 days{/lang}{/a}
					{/row}
					{row class="action"}
						{submit value="Search" id="search-btn"}
					{/row}
				{/form}
			{/row}
			{row}
				{datatable name="admin_coupon_record"}
			{/row}
		{/container}
	{/block}
	{block name="foot"}		
		{div class="copyright"}
			©Copyright Pinet Technology Solutions 2014
		{/div}
	{/block}