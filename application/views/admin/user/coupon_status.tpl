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
				{li role="presentation"   class="active"}
					{a uri="admin/user/coupon_status"}{lang}Coupon Voucher Status{/lang}{/a}
				{/li}
				{li role="presentation"}
					{a uri="admin/user/coupon_record"}{lang}Checked Coupon Record{/lang}{/a}
				{/li}
			{/ul}
			{row layout=[10] layout-lg=[6]}
				{form name="admin/user_coupon_status"}				
					{row layout=[12] layout-lg=[12]}
						{field field="coupon_code"}{/field}
					{/row}
					{row class="action"}
	                    {submit type="button" value="Search" id="search-btn"}
					{/row}
				{/form}			
			{/row}			
		{/container}
	{/block}
	{block name="foot"}		
		{div class="copyright"}
			©Copyright Pinet Technology Solutions 2014
		{/div}
	{/block}