{extends file='locallife-layout.tpl'}
			{block name="main-content" append}
				{container}
					{row}
						{form name="merchant/show" action="$form_action"}
							<input type="hidden" name="id" value="{$id}"/>
							{row layout=[6, 6] layout-lg=[4, 8]}
								{field field="name"}{/field}
								{field field="description"}{/field}
							{/row}
							{row layout=[6, 6] layout-lg=[4, 8]}
								{field field="location"}{/field}
								{field field="logo_url"}{/field}
							{/row}
							{row class="action"}
								{submit value="Go Back"}
							{/row}
						{/form}
					{/row}
				{/container}
			{/block}
