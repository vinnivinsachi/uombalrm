{include file='header.tpl' section='register'}

<div id="leftContainer">

<form method="post" action="{geturl action='registermember'}" id="registration-form">
<div class="error" {if !$fp->hasError()} style="display: none"{/if}>
			An error has occured in the form below. Please check the highlighted fields and resubmit the form. 
		</div>
	


	<fieldset>
		<legend>University</legend>
		<div class="row" id="form_university">
			<label for="form_university">Current University:</label>
				<select name="university">
				
				<option value="University of Michigan">University of Michigan</option>
				</select>
		</div>
		<br/>
				<!--if you did not find your university, <span id="addUniversity"><a >click to add university</a></span>
		<div class="row" id="form_newUniversity">
			<label for="form_university">Enter your University:</label>
			<input type="text" id="form_newUnversity" name="newUniversity" value="" />
			
		</div>-->
		{include file='lib/error.tpl' error=$fp->getError('university')}
		
	</fieldset>



	<fieldset>
		<legend> Create an Account </legend>
		
		
		
		<div class="row" id="form_username_container">
			<label for="form_username"><strong style="color:#003366; font-size:1.7em;">*</strong>Username:</label>
			<input type="text" id="form_username" name="username" value="{$fp->username|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('username')}
		</div>
		
		<div class="row" id="form_password_container">
			<label for="form_password"><strong style="color:#003366; font-size:1.7em;">*</strong>Password:</label>
			<input {if $edit=='false'}disabled="disabled"{/if}  type="password" id="form_password" name="password"/>
			{include file='lib/error.tpl' error=$fp->getError('password')}
		</div>
		
		<div class="row" id="form_confirm_password_contrainer">
			<label for="form_confirm_password"><strong style="color:#003366; font-size:1.7em;">*</strong>Retype Password: </label>
			<input {if $edit=='false'}disabled="disabled"{/if} type="password" id="form_confirm_password" name="confirm_password" />
			{include file='lib/error.tpl' error=$fp->getError('confirm_password')}
		</div>
		
		<div class="row" id="form_email_container">
			<label for="form_email"><strong style="color:#003366; font-size:1.7em;">*</strong>Email Address:</label>
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('email')}
		</div>
		
		<div class="row" id="form_first_name_container">
			<label for="form_first_name"><strong style="color:#003366; font-size:1.7em;">*</strong>First Name:</label>
			<input type="text" id="form_first_name" name="first_name" value="{$fp->first_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		</div>
		
		<div class="row" id="form_last_name_container">
			<label for="form_last_name"><strong style="color:#003366; font-size:1.7em;">*</strong>Last Name:</label>
			<input type="text" id="form_last_name" name="last_name" value="{$fp->last_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		</div>
		
		<div class="row" id="form_address">
			<label for="form_address"><strong style="color:#003366; font-size:1.7em;">*</strong>Address: </label>
			<input type="text" id="form_address" name="address" value="{$fp->address|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('address')}
		</div>
		
		<div class="row" id="form_zip">
			<label for="form_zip"><strong style="color:#003366; font-size:1.7em;">*</strong>Zip: </label>
			<input type="text" id="form_address" name="zip" value="{$fp->zip|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('zip')}
		</div>
		
		<div class="row" id="form_city">
			<label for="form_city"><strong style="color:#003366; font-size:1.7em;">*</strong>City:</label>
			<input type="text" id="form_city" name="city" value="{$fp->city|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('city')}
		</div>
		
		<div class="row" id="form_states">
			<label for="form_states"><strong style="color:#003366; font-size:1.7em;">*</strong>States:</label>
			<input type="text" id="form_states" name="states" value="{$fp->state|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('states')}
		</div>
		
		
		<div class="captcha">
			<img src="../utility/captcha" alt="CAPTCHA image" />
		</div>
		
		<div class="row" id="form_captcha_container">
			<label for="form_captcha"><strong style="color:#003366; font-size:1.7em;">*</strong>Enter Above Phrase:</label>
			<input type="text" id="form_captcha" name="captcha" value="{$fp->captcha|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('captcha')}
		</div>
		
		<div class="submit">
			<input type="submit" value="Register" />
		</div>
	</fieldset>
</form>

</div>
<!--
<script type="text/javascript" src="/htdocs/js_plugin/UserRegistrationForm.class.js"></script>
<script type="text/javascript">
	new UserRegistrationForm('registration-form');
</script>
-->

{include file='footer.tpl' leftcolumn='lib/ProductList.tpl' products=$cartObject}