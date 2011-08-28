{include file='header.tpl' section='register'}

<form method="post" action="{geturl action='registerclub'}" id="registration-form">

<div class="error" {if !$fp->hasError()} style="display: none"{/if}>
			An error has occured inteh form below. Please check the highlighted fields and resubmit the form. 
</div>
	<fieldset>
		<legend>University</legend>
		<div class="row" id="form_university">
			<label for="form_university">Select An University:</label>
				<select name="university">
				<option value="0">Select an University</option>
				{foreach from=$fp->universities item=university}
				<option value="{$university.university_id}" {if $fp->university_id==$university.university_id} selected="selected"{/if}>{$university.university_name}</option>
				{/foreach}
				</select>
				
				{include file='lib/error.tpl' error=$fp->getError('university')}

		</div>
	</fieldset>


	<fieldset>
		<legend>Club Profile</legend>
		
		<div class="row" id="form_type">
			<label for="form_type">Select a Club Type:</label>
				<select name="types">
				<option value="0">Select a Club Type</option>
				{foreach from=$fp->club_types item=university}
				<option value="{$university.type_id}" {if $fp->type_id==$university.type_id} selected="selected"{/if}>{$university.type_description}</option>
				{/foreach}
				</select>
				
				{include file='lib/error.tpl' error=$fp->getError('types')}

		</div>
		
		
		
		
		
		{foreach from=$fp->publicProfile key='key' item='label'}
			<div class="row" id="form_{$key}_container">
				<label for="form_{$key}">{$label|escape}:</label>
				
				<input type="text" id="form_{$key}" maxlength="255" name="{$key}" value="{$fp->$key|escape}" />
				{include file='lib/error.tpl' error=$fp->getError($key)}
			</div>
		{/foreach}
		
		
			
			
	</fieldset>

	<fieldset>
		<legend>Admin Info </legend>
		
		
		
		<div class="row" id="form_username_container">
			<label for="form_username">Username:</label>
			<input type="text" id="form_username" name="username" value="{$fp->username|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('username')}
		</div>
		
		<div class="row" id="form_email_container">
			<label for="form_email">Email Address:</label>
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('email')}
		</div>
		
		<div class="row" id="form_first_name_container">
			<label for="form_first_name">First Name:</label>
			<input type="text" id="form_first_name" name="first_name" value="{$fp->first_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		</div>
		
		<div class="row" id="form_last_name_container">
			<label for="form_last_name">Last Name:</label>
			<input type="text" id="form_last_name" name="last_name" value="{$fp->last_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		</div>
		
		<div class="captcha">
			<img src="../utility/captcha" alt="CAPTCHA image" />
		</div>
		
		<div class="row" id="form_captcha_container">
			<label for="form_captcha">Enter Above Phrase:</label>
			<input type="text" id="form_captcha" name="captcha" value="{$fp->captcha|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('captcha')}
		</div>
		
		<div class="submit">
			<input type="hidden" name="clubAdmin" value="clubAdmin" />

			<input type="submit" value="Register" />
		</div>
	</fieldset>
</form>


<!--
<script type="text/javascript" src="/htdocs/js_plugin/UserRegistrationForm.class.js"></script>
<script type="text/javascript">
	new UserRegistrationForm('registration-form');
</script>

-->

{include file='footer.tpl' leftcolumn='lib/university-list.tpl' products=$cartObject}