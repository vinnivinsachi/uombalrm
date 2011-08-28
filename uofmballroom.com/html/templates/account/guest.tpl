{include file='header.tpl' section='register'}

<div id="leftContainer">

<form method="post" action="{geturl action='guest'}" id="registration-form">
<div class="error" {if !$fp->hasError()} style="display: none"{/if}>
			An error has occured in the form below. Please check the highlighted fields and resubmit the form. 
		</div>



	<fieldset>
		<legend> Please provide your student information</legend>
		<div class="row" id="form_first_name_container">
			<label for="form_first_name"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>First Name:</label>
			<input type="text" id="form_first_name" name="first_name" value="{$fp->first_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		</div>
		
		<div class="row" id="form_last_name_container">
			<label for="form_last_name"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Last Name:</label>
			<input type="text" id="form_last_name" name="last_name" value="{$fp->last_name|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		</div>
		
		<div class="row" id="form_email_container">
			<label for="form_email"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Email Address:</label>
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('email')}
		</div>
		
		<div class="row" id="form_email_container">
			<label for="phone"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Phone:</label>
			<input type="text" id="phone" name="phone" value="{$fp->phone|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('phone')}
		</div>
		
		
		
		<div class="row" id="form_address">
			<label for="form_address"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Address: </label>
			<input type="text" id="form_address" name="address" value="{$fp->address|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('address')}
		</div>
		
		<div class="row" id="form_zip">
			<label for="form_zip"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Zip: </label>
			<input type="text" id="form_address" name="zip" value="{$fp->zip|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('zip')}
		</div>
		
		<div class="row" id="form_city">
			<label for="form_city"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>City:</label>
			<input type="text" id="form_city" name="city" value="{$fp->city|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('city')}
		</div>
		
		<div class="row" id="form_states">
			<label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>States:</label>
			<input type="text" id="form_states" name="states" value="{$fp->state|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('states')}
		</div>
        
        <div class="row" id="form_car">
            <label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Do you have a car? :</label>
            
            <select name="car"/>
            <option value="">Please make a selection</option>
       		<option value="no" {if $fp->car=='no'}selected="selected"{/if}>No</option>

            <option value="yes" {if $fp->car=='yes'}selected="selected"{/if}>Yes</option>
            </select>
            {include file='lib/error.tpl' error=$fp->getError('car')}
		</div>

        <div class="row" id="form_boombox">
            <label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Do you have a boom box? :</label>
            
            <select name="boombox"/>
                        <option value="">Please make a selection</option>

       		<option value="no" {if $fp->boombox=='no'}selected="selected"{/if}>No</option>

            <option value="yes" {if $fp->boombox=='yes'}selected="selected"{/if}>Yes</option>
            </select>
            {include file='lib/error.tpl' error=$fp->getError('boombox')}
		</div> 
      
        <div class="row" id="form_ethnicity">
            <label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>What is your ethnicity? :</label>
            <select name="ethnicity"/>
                        <option value="">Please make a selection</option>

       		<option value="Caucasian" {if $fp->ethnicity=='Caucasian'}selected="selected"{/if}>Caucasian</option>

            <option value="AfricanAmerican" {if $fp->ethnicity=='AfricanAmerican'}selected="selected"{/if}>African American</option>
                        <option value="Asian" {if $fp->ethnicity=='Asian'}selected="selected"{/if}>Asian</option>

            <option value="Hispanic" {if $fp->ethnicity=='Hispanic'}selected="selected"{/if}>Hispanic</option>
            <option value="MiddleEastern" {if $fp->ethnicity=='MiddleEastern'}selected="selected"{/if}>Middle Eastern</option>
   			<option value="Other" {if $fp->ethnicity=='Other'}selected="selected"{/if}>Other</option>

            </select>
            {include file='lib/error.tpl' error=$fp->getError('ethnicity')}
		</div>
 
        <div class="row" id="form_hear_about_us">
            <label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>How did you hear about us? :</label>
            <select name="hear_about_us"/>
                        <option value="">Please make a selection</option>

       		<option value="Flyer" {if $fp->hear_about_us=='Flyer'}selected="selected"{/if}>Flyer/rip tag</option>

            <option value="Website" {if $fp->hear_about_us=='Website'}selected="selected"{/if}>Website</option>
                        <option value="Friends" {if $fp->hear_about_us=='Friends'}selected="selected"{/if}>Friends</option>

            <option value="WelcomeWeek" {if $fp->hear_about_us=='WelcomeWeek'}selected="selected"{/if}>Welcome Week</option>
            <option value="Festfall" {if $fp->hear_about_us=='Festfall'}selected="selected"{/if}>Festfall, northfest or winterfest</option>


            </select>
           
            {include file='lib/error.tpl' error=$fp->getError('hear_about_us')}
		</div>
               
        
        <div class="row" id="form_school">
            <label for="form_states"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>What is your school of concentration? :</label>
            <input type="text" id="form_school" name="school" value="{$fp->school|escape}" />
            {include file='lib/error.tpl' error=$fp->getError('school')}
		</div>
        
        
        
        
        
        
		
		
		<div class="captcha">
			<img src="../utility/captcha" alt="CAPTCHA image" />
		</div>
		
		<div class="row" id="form_captcha_container">
			<label for="form_captcha"><strong style="color:#FFFF00; font-size:1.7em;">*</strong>Enter Above Phrase:</label>
			<input type="text" id="form_captcha" name="captcha" value="{$fp->captcha|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('captcha')}
		</div>
		
		<div class="submit">
			<input type="submit" value="Next" />
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