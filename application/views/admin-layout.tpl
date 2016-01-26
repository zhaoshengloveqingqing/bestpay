{html}
	{head}
		<!-- CSS -->
		{context key='css'}
		<!-- End Of CSS -->
		<!-- Header -->
		{block name="header"}{/block}
		<!-- End of Header -->
	{/head}
	{body}
		<!-- Head -->
		{block name="head"}
			{row id="header"}
				{div class="top_navbar"}
					{div class="top_navbar_content"}
						{ul class="nav navbar-nav top_navbar_left" items=$head index="i"}
							{literal}
								{li}
								{action id="action-$i" action=$item}{/action}
								{/li}
							{/literal}
						{/ul}
						{ul class="top_navbar_right"}
							{li}
								{a uri="help/index"}{lang}翼百网首页{/lang}{/a}
							{/li}
							{li class="management"}
								{a uri="merchant/login"}{lang}账号管理{/lang}{/a}
							{/li}
							{li}
								{a}{lang}帮助{/lang}{/a}
							{/li}
						{/ul}
					{/div}
				{/div}
				{div class="navbar"}
					{div class="navbar__brand"}
						{resimg data-image="admin/logo1.png"}
					{/div}
					{div class="navbar__company"}
						{lang}商家度假酒店分公司{/lang}
					{/div}
				{/div}
			{/row}
			{row id="menu"}
				{nav class="navbar"}
					{div class="container-fluid"}
						{div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"}
						{navigation class="navbar-nav" actions=$navi}{/navigation}
							{*{ul class="nav navbar-nav" items=$navi}*}
								{*{literal}*}
									{*{li}*}
										{*{action action=$item}{/action}*}
									{*{/li}*}
								{*{/literal}*}
							{*{/ul}*}
						{/div}
					{/div}
				{/nav}
			{/row}
		{/block}
		<!-- End Of Head -->
		<!-- Main -->
		{block name="main"}{/block}
		<!-- End Of Main -->
		<!-- Foot -->
		{block name="foot"}
			{row class="foot"}
				{div class="content"}
					{div class="foot_left"}
						{ul}
							{li}
								{resimg data-image="admin/phone.png"}
							{/li}
						{/ul}
					{/div}
					{div class="foot_right"}
						{ul}
						{li}
						{a}4000-123-456{/a}
						{a}4000-123-456{/a}
						{/li}
						{li}
						{a}4000-123-456{/a}
						{a}4000-123-456{/a}
						{/li}
						{li}
						{a}4000-123-456{/a}
						{a}4000-123-456{/a}
						{/li}
						{/ul}
					{/div}
				{/div}
			{/row}
			{div class="copyright"}
				©Copyright Pinet Technology Solutions 2014
			{/div}
		{/block}
		<!-- End Of Foot -->
		<!-- JS -->
		{js}
		<!-- End Of JS -->
	{/body}
{/html}
