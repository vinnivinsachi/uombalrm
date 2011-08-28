{include file='header.tpl' section='login' }


<div id="leftContainer">
<form method="post" action="{geturl action='login' controller='account'}">

<fieldset>
	<input type="hidden" name="redirect" value="{$redirect|escape}" />
	
	<legend>Log in to your account</legend>
	<div class="row" id="form_username_container">
		<label for="form_username">Username:</label>
		<input type="text" id="form_username" name="username" value="{$username|escape}"/>
		{include file='lib/error.tpl' error=$errors.username}
	</div>
	
	<div class="row" id="form_password_container">
		<label for="form_password">Password:</label>
		<input type="password" id="form_password" name="password" value="{$password|escape}" AUTOCOMPLETE="off"/>
		{include file='lib/error.tpl' error=$errors.password}
	</div>
	
	<a href="/account/fetchpassword">Forgot your password?</a>
	
	
	
	<div class="submit">
		<input type="submit" value="Login" name="login"/>

		<!--<input type="submit" value="Register" name="register" />-->
		
		
		{if $cartObject|@count>0}
		<input type="submit" value="Guest sign in (no promotion)" name="guest" />
		{/if}
	</div>
</fieldset>

</form>
</div>

{include file='footer.tpl' leftcolumn='lib/productList.tpl' products=$cartObject}