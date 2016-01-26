{extends file='locallife-layout.tpl'}
			{block name="main-content" append}
				{container}
					{row id="toolbar"}
					{/row}
					{row}
						{datatable name="user_product"}
					{/row}
				{/container}
			{/block}
