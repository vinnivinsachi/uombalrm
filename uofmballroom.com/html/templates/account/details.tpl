{include file='header.tpl' section='account'}
<script type="text/javascript" src="/htdocs/js_plugin/blogPreview.js"></script>
<script type="text/javascript" src="/htdocs/js_plugin/BlogImageManager.class.js"></script>



<!--
<fieldset id="preview-images">
	<legend>Images</legend>
	
	{if $user->images|@count>0}
		<ul id="post_images">
			{foreach from=$user->images item=image}
				<li id="image_{$image->getId()}">
				
					<img src="{imagefilename id=$image->getId() w=200 h=65}" alt="{$image->filename|escape}" />
					
					<form method="post" action="{geturl action='images'}">
						<div>
							<input type="hidden" name="id" value="{$fp->user->getID()}" />
							<input type="hidden" name="image" value="{$image->getId()}" />
							<input type="submit" name="delete" value="delete" />
						</div>
					</form>
					
				</li>
			{/foreach}
		</ul>
	{/if}
	
	
	<form method="post" action="{geturl action='images'}" enctype="multipart/form-data">
		<div>
			<input type="hidden" name="id" value="{$fp->user->getID()}" />
			
			<div class="row" id="form_image_container">
				<label for="image">Club Images: </label>
				<input type="file" name="image" />
				<input type="submit" value="Upload Image" name="upload" />	
			</div>
		</div>
	</form>
</fieldset>

-->

<div id="leftContainer">

{if $fp->profile_type == 'clubAdmin'}
<form method="post" action="/account/details">	
<div class="error" {if !$fp->hasError()} style="display: none"{/if}>
			An error has occured inteh form below. Please check the highlighted fields and resubmit the form. 
		</div>
	<fieldset>
		<legend>Club Basics</legend>
		
		{foreach from=$fp->publicProfile key='key' item='label'}
			<div class="row" id="form_{$key}_container">
				<label for="form_{$key}">{$label|escape}:</label>
				
				<input type="text" id="form_{$key}" maxlength="255" name="{$key}" value="{$fp->$key|escape}" />
				{include file='lib/error.tpl' error=$fp->getError($key)}
			</div>
		{/foreach}
		
		<div class="background2">Once your paypal email is determined, it can not be changed. You may request a paypal change by contacting us directly.</div>
		<div class="row" id="form_email_container">
			<label for="form_paypalEmail">Paypal Email:</label>
			{if $fp->user->profile->paypalEmail==''}	
			<input type="text" id="form_paypalEmail" maxlength="255" name="paypalEmail" value="{$fp->paypalEmail|escape}" />
		{else}
			<input type="button" disabled="disabled" value="{$fp->user->profile->paypalEmail|escape}" />
		{/if}
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Club Description</legend>
		<div class="wysiwyg">
			<div class="row">
			<label for="club_description">Club Description: </label>
			</div>
			{wysiwyg name='club_description' value=$fp->club_description}
			{include file='lib/error.tpl' error=$fp->getError('club_description')}
		</div>
		
	</fieldset>


	
	<fieldset>
		<legend> Admin-info </legend>
		
		

		
		<div class="row" id="form_email_container">
			<label for="form_email">Email Address:</label>
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}" {if $edit=='false'}disabled="disabled"{/if}/>
			{include file='lib/error.tpl' error=$fp->getError('email')}
		</div>
		
		<div class="row" id="form_first_name_container">
			<label for="form_first_name">First Name:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_first_name" name="first_name" value="{$fp->first_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		</div>
		
		<div class="row" id="form_last_name_container">
			<label for="form_last_name">Last Name:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_last_name" name="last_name" value="{$fp->last_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		</div>
		
		<div class="row" id="form_address">
			<label for="form_address">Address: </label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_address" name="address" value="{$fp->address|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('address')}
		</div>
		
		<div class="row" id="form_zip">
			<label for="form_zip">Zip: </label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_address" name="zip" value="{$fp->zip|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('zip')}
		</div>
		
		<div class="row" id="form_city">
			<label for="form_city">City:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_city" name="city" value="{$fp->city|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('city')}
		</div>
		
		<div class="row" id="form_states">
			<label for="form_states">States:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_states" name="states" value="{$fp->state|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('states')}
		</div>
		
		<div class="background2">If you would like to change your password, please enter. else your password will be unchanged.</div>
		
		<div class="row" id="form_password_container">
			<label for="form_password">Password:</label>
			<input {if $edit=='false'}disabled="disabled"{/if}  type="password" id="form_password" name="password"/>
			{include file='lib/error.tpl' error=$fp->getError('password')}
		</div>
		
		<div class="row" id="form_confirm_password_contrainer">
			<label for="form_confirm_password">Retype Password: </label>
			<input {if $edit=='false'}disabled="disabled"{/if} type="password" id="form_confirm_password" name="confirm_password" />
			{include file='lib/error.tpl' error=$fp->getError('confirm_password')}
		</div>
	</fieldset>
	
	<!--<fieldset>
		<legend>Account Settings</legend>
	
			<dl>
		
				<dt>
					WOULD YOU LIKE TO MAKE YOUR CLUB LIVE?
				</dt>
				<dd>
					<select name="club_public">
						<option value="D"
						  {if $fp->club_public == 'D'} selected="selected"{/if}>No</option>
		
						<option value="L"
						  {if $fp->club_public == 'L'} selected="selected"{/if}>Yes</option>
					</select>
				</dd>
			</dl>
		</fieldset>-->
	
					
		<div class="submit">
		
			{if $edit=='false'}
			<a href="{geturl controller='account' action='details'}?edit=true" style="color:#006600;">Edit</a>
			{else}
			<input type="submit" value="Save New Details" />
			{/if}
		</div>
	
</form>

</div>

{else}

<div id="leftContainer">
<form method="post" action="/account/details">	


<div class="error" {if !$fp->hasError()} style="display: none"{/if}>
			An error has occured inteh form below. Please check the highlighted fields and resubmit the form. 
		</div>
	<fieldset>
		<legend> Admin-info </legend>
		
		
		
		
		<div class="row" id="form_email_container">
			<label for="form_email">Email Address:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_email" name="email" value="{$fp->email|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('email')}
		</div>
		
		<div class="row" id="form_first_name_container">
			<label for="form_first_name">First Name:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_first_name" name="first_name" value="{$fp->first_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		</div>
		
		<div class="row" id="form_last_name_container">
			<label for="form_last_name">Last Name:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_last_name" name="last_name" value="{$fp->last_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		</div>
		
		
		<div class="row" id="form_address">
			<label for="form_address">Address: </label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_address" name="address" value="{$fp->address|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('address')}
		</div>
		
		<div class="row" id="form_zip">
			<label for="form_zip">Zip: </label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_address" name="zip" value="{$fp->zip|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('zip')}
		</div>
		
		<div class="row" id="form_city">
			<label for="form_city">City:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_city" name="city" value="{$fp->city|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('city')}
		</div>
		
		<div class="row" id="form_states">
			<label for="form_states">States:</label>
			<input type="text" {if $edit=='false'}disabled="disabled"{/if} id="form_states" name="states" value="{$fp->state|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('states')}
		</div>
		
		<div class="background2">If you would like to change your password, please enter. else your password will be unchanged.</div>
		
		<div class="row" id="form_password_container">
			<label for="form_password">Password:</label>
			<input type="password" {if $edit=='false'}disabled="disabled"{/if} id="form_password" name="password"/>
			{include file='lib/error.tpl' error=$fp->getError('password')}
		</div>
		
		<div class="row" id="form_confirm_password_contrainer">
			<label for="form_confirm_password">Retype Password: </label>
			<input type="password" id="form_confirm_password" {if $edit=='false'}disabled="disabled"{/if} name="confirm_password" />
			{include file='lib/error.tpl' error=$fp->getError('confirm_password')}
		</div>
	</fieldset>
	
		<!--<fieldset>
		<legend>Account Settings</legend>
	
			<dl>
		
				<dt>
					WOULD YOU LIKE TO MAKE YOUR PROFILE LIVE?
				</dt>
				<dd>
					<select name="club_public">
						<option value="D"
						  {if $fp->club_public == 'D'} selected="selected"{/if}>No</option>
		
						<option value="L"
						  {if $fp->club_public == 'L'} selected="selected"{/if}>Yes</option>
					</select>
				</dd>
			</dl>
		</fieldset>-->
	
	
					
		<div class="submit">
		
			{if $edit=='false'}
		<a href="{geturl controller='account' action='details'}?edit=true" style="color:#006600;">Edit</a>
			{else}
			<input type="submit" value="Save New Details" />
			{/if}
		</div>
	
</form>

</div>
{/if}

{include file='footer.tpl' leftcolumn='lib/ProductList.tpl' products=$cartObject}