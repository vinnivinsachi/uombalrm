{include file='header.tpl' lightbox=true}

    <div align="left">

        
        <form method="post" action="{geturl action='spectatorticket' controller='registration'}">
        <fieldset style="width:600px; font-family:Calibri;">
        <legend>Spectator Ticket Form</legend>
        	
            # of (ADULT) FULL DAY PASS $10 -- All day
            <select name="adultFullDayPass">
            	<option value="0" {if $fp->adultFullDayPass==0}selected="selected"{/if}>0</option>
                <option value="1" {if $fp->adultFullDayPass==1}selected="selected"{/if}>1</option>
                <option value="2" {if $fp->adultFullDayPass==2}selected="selected"{/if}>2</option>
                <option value="3" {if $fp->adultFullDayPass==3}selected="selected"{/if}>3</option>
                <option value="4" {if $fp->adultFullDayPass==4}selected="selected"{/if}>4</option>
                <option value="5" {if $fp->adultFullDayPass==5}selected="selected"{/if}>5</option>
                <option value="6" {if $fp->adultFullDayPass==6}selected="selected"{/if}>6</option>
                <option value="7" {if $fp->adultFullDayPass==7}selected="selected"{/if}>7</option>
                <option value="8" {if $fp->adultFullDayPass==8}selected="selected"{/if}>8</option>
                <option value="9" {if $fp->adultFullDayPass==9}selected="selected"{/if}>9</option>
                <option value="10" {if $fp->adultFullDayPass==10}selected="selected"{/if}>10</option>
            </select><br />
            # of (ADULT) NIGHT PASS $8 -- Starts 7:00pm (Main Event) 
            <select name="adultNightPass">
            	<option value="0" {if $fp->adultNightPass==0}selected="selected"{/if}>0</option>
                <option value="1" {if $fp->adultNightPass==1}selected="selected"{/if}>1</option>
                <option value="2" {if $fp->adultNightPass==2}selected="selected"{/if}>2</option>
                <option value="3" {if $fp->adultNightPass==3}selected="selected"{/if}>3</option>
                <option value="4" {if $fp->adultNightPass==4}selected="selected"{/if}>4</option>
                <option value="5" {if $fp->adultNightPass==5}selected="selected"{/if}>5</option>
                <option value="6" {if $fp->adultNightPass==6}selected="selected"{/if}>6</option>
                <option value="7" {if $fp->adultNightPass==7}selected="selected"{/if}>7</option>
                <option value="8" {if $fp->adultNightPass==8}selected="selected"{/if}>8</option>
                <option value="9" {if $fp->adultNightPass==9}selected="selected"{/if}>9</option>
                <option value="10"{if $fp->adultNightPass==10}selected="selected"{/if}>10</option>
            </select><br />
            
            # of (STUDENT) PASS $5 -- All day
            <select name="studentPass">
            	<option value="0" {if $fp->studentPass==0}selected="selected"{/if}>0</option>
                <option value="1" {if $fp->studentPass==1}selected="selected"{/if}>1</option>
                <option value="2" {if $fp->studentPass==2}selected="selected"{/if}>2</option>
                <option value="3" {if $fp->studentPass==3}selected="selected"{/if}>3</option>
                <option value="4" {if $fp->studentPass==4}selected="selected"{/if}>4</option>
                <option value="5" {if $fp->studentPass==5}selected="selected"{/if}>5</option>
                <option value="6" {if $fp->studentPass==6}selected="selected"{/if}>6</option>
                <option value="7" {if $fp->studentPass==7}selected="selected"{/if}>7</option>
                <option value="8" {if $fp->studentPass==8}selected="selected"{/if}>8</option>
                <option value="9" {if $fp->studentPass==9}selected="selected"{/if}>9</option>
                <option value="10"{if $fp->studentPass==10}selected="selected"{/if}>10</option>
            </select><br />
            
            {include file='lib/error.tpl' error=$fp->getError('passError')}
            
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
			<input type="submit" value="Proceed to purchase" />
		</div>
        
        
          	</fieldset>
            
            
        </form>
{include file='footer.tpl'}