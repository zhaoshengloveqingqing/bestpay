{extends file="locallife-layout.tpl"}
			{block name="main-content" append}
				{form name="user/register"}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="username"}{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="first_name"}{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="last_name"}{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" onkeyup="validate()" field="password"}{password}{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" onkeyup="validate()"  field="password_confirm"}{password}<span id="tishi"></span>{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="sex"}
							{select options=$sex}
							{/select}
						{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="mobile"}{/field}
					{/row}
					{row}
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="delivery_address"}{/field}
					{/row}
					{row }
						{field label-class="col-xs-2 col-lg-2" input-class="col-xs-10 col-lg-10" field="email"}{/field}
					{/row}
					{row}
						{div class="col-xs-offset-2 col-lg-offset-2 submit"}
							{submit value="Complete" id="submit" class="submit"}
						{/div}
						<input id="appid" name="appid" type="hidden" value="-1"/>
					{/row}
					{field field="uid"}{/field}
				{/form}
			{/block}
			{block name=foot append}
				<script>
					function validate() {
						var pw1 = document.getElementById("field_password").value;
						var pw2 = document.getElementById("field_password_confirm").value;
						if(pw1!='' && pw2==''){
							document.getElementById("tishi").innerHTML="<font color='green'>请输入确认密码</font>";
							document.getElementById("submit").disabled = false;
							return false;
						}
						if(pw1 == pw2) {
							document.getElementById("tishi").innerHTML="<font color='green'>两次密码相同</font>";
							document.getElementById("submit").disabled = false;
						}
						else {
							document.getElementById("tishi").innerHTML="<font color='red'>两次密码不相同</font>";
							document.getElementById("submit").disabled = true;
						}
					}
				</script>
			{/block}