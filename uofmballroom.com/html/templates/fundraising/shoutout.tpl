{include file='header.tpl' lightbox=true}

    <div align="left">

        Shout Out Form
        <form method="post" action="{geturl action='shoutout' controller='fundraising'}">
        <fieldset style="width:600px; font-family:Calibri;">
        <legend>Your Basic Information</legend>
                    
           	Your Name:
			<input type="text" id="form_first_name" name="your_name" value="{$fp->your_name|escape}" /><br />
			{include file='lib/error.tpl' error=$fp->getError('your_name')}
		
			Email Address:
			<input type="text" id="form_email" name="email" value="{$fp->email|escape}"/><br />
			{include file='lib/error.tpl' error=$fp->getError('email')}
            
           	Phone Number:
			<input type="text" id="phone" name="phone" value="{$fp->phone|escape}"/><br />
			{include file='lib/error.tpl' error=$fp->getError('phone')}
		</fieldset>
        
        <fieldset style="width:600px; font-family:Calibri;">
        
        <legend>Shout out information</legend>
       

		"Shout-Out" Options<br />	
        Please select the "Shout-Out" you would like to include in our program. **Keep in mind** The less text you include, the larger it will be printed in the space that you purchase. <br />
        <select name="type">
        	<option value="oneline">$20 - Basic (150 character limit)</option>
            <option value="quarterPage">$50 - Quarter-Page (300 character limit, plus photo option)</option>
            <option value="halfPage">$100 - Half-Page (500 character limit, plus photo option)</option>
        </select><br />
        
        "Shout-Out" Text<br />
        please include all text you would like to "Shout-Out". Remeber to include the name of the invidual or group you are shouting out to!<br />
        <textarea name="text" rows="5" cols="40"></textarea><br />
		{include file='lib/error.tpl' error=$fp->getError('text')}

		
		<div class="submit">
			<input type="submit" value="Next" />
		</div>
          	</fieldset>
        </form>
   
   
   </div>
        
       
{include file='footer.tpl'}