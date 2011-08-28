{include file='header.tpl' lightbox=true}

    <div align="left">

        </div>

          <blockquote>

            <p align="left" class="style3">Help out the Ballroom Dance Team at the University of Michigan!</p>

            <p align="left" class="style3">Your money will help go towards sending our members to competitions all across the midwest, renting dance practice facilities, and other costs that the team must account for in order to remain a successfull ballroom organization in our region.</p>

            <p align="left" class="style3">If you prefer to send a donation via postal mail, we are able to accept checks and money orders made payable to &quot;Ballroom Dance Team&quot; at the following mailing address:</p>

            <p align="left" class="style3">Ballroom Dance Team<br>

            PO Box 4595<br>

            Ann Arbor, MI 48106</p>

            <p align="left" class="style3">Alternately, you can make a donation via PayPal right now - please click on the button below.</p>

            <p align="left" class="style3">Thank you for helping support the University of Michigan Ballroom Dance Team!</p>

        </blockquote>
        
        <form method="post" action="{geturl action='donate' controller='fundraising'}">
        <fieldset>
        <legend>Donation Form</legend>
        	Please select from the drop down
        	<select name="donateAmount">
            	<option value="0" {if $fp->donateAmount==0}selected="selected"{/if}>Please select an amount</option>
                <option value="50" {if $fp->donateAmount==50}selected="selected"{/if}>$50</option>
                <option value="100" {if $fp->donateAmount==100}selected="selected"{/if}>$100</option>
                <option value="250" {if $fp->donateAmount==250}selected="selected"{/if}>$250</option>
                <option value="500" {if $fp->donateAmount==500}selected="selected"{/if}>$500</option>
                <option value="750" {if $fp->donateAmount==750}selected="selected"{/if}>$750</option>
                <option value="1000" {if $fp->donateAmount==1000}selected="selected"{/if}>$1000</option>
            </select>
            
            <strong>or</strong>&nbsp;please input your donate amount&nbsp;<input name="inputDonateAmount" type="text"/><br />
            {include file='lib/error.tpl' error=$fp->getError('donateAmount')}
            
           	First Name:
			<input type="text" id="form_first_name" name="first_name" value="{$fp->first_name|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('first_name')}
		
			Last Name:
			<input type="text" id="form_last_name" name="last_name" value="{$fp->last_name|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('last_name')}
		
			Email Address:
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}"/><br />
			{include file='lib/error.tpl' error=$fp->getError('email')}
		
			Phone:
			<input type="text" id="phone" name="phone" value="{$fp->phone|escape}"/><br />
			{include file='lib/error.tpl' error=$fp->getError('phone')}
		
			Address:
			<input type="text" id="form_address" name="address" value="{$fp->address|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('address')}
		
			Zip:
			<input type="text" id="form_address" name="zip" value="{$fp->zip|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('zip')}
		
			City:
			<input type="text" id="form_city" name="city" value="{$fp->city|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('city')}
		
		<div class="row" id="form_states">
			States:
			<input type="text" id="form_states" name="states" value="{$fp->state|escape}" />
			{include file='lib/error.tpl' error=$fp->getError('states')}
		</div>
        
		
		<div class="submit">
			<input type="submit" value="Proceed to donation" />
		</div>
        
        
          	</fieldset>
            
            
        </form>
{include file='footer.tpl'}