{include file='header.tpl' section='events'}
<div id="leftContainer">

<form method="post" action="{geturl controller='eventmanager' action='edit'}/?id={$fp->event->getId()}">
	
	{if $fp->hasError()}
		<div class="error">
			An error has occured in the form below. Please check the highlighted fields and resubmit the form.
		</div>
	{/if}

	
	<fieldset>
		<legend>Registration Details</legend>
		
		<div class="row" id="form_title_container">
			<label for="form_title">Title:</label>
			<input type="text" id="form_title" name="title" value="{$fp->name}"/>
			{include file='lib/error.tpl' error=$fp->getError('title')}

		</div>
		
		<div class="row" id="form_startdate_container">
			<label for="form_startdate">Start Time:</label>
			{html_select_date prefix='ts_created' 
							  time=$fp->ts_created
							  start_year=-2
							  end_year=+2}
			
			{html_select_time prefix='ts_created'
							  time=$fp->ts_created
							  display_seconds = false
							  use_24_hours=false}
			
		</div>
		
		<div class="row" id="form_enddate_container">
			<label for="form_enddate">End Time:</label>
			{html_select_date prefix='ts_end' 
							  time=$fp->ts_end

							  start_year=-2
							  end_year=+2}
			
			{html_select_time prefix='ts_end'
							  time=$fp->ts_end
							  display_seconds = false
							  use_24_hours=false}
		</div>
		
		<!--<div class="row" id="form_location">
		
			<label for="form_loaction">Location: </label>
			
			<input type="text" id="form_location" name="location" value="{$fp->location}" />
			{include file='lib/error.tpl' error=$fp->getError('location')}
		</div>-->
		
		
		
		
		
		<div class="row" id="form_ticket_price">
			<label for="form_ticket_price">Registration Price:</label>
			
			{if $clubManager->profile->paypalEmail==""}
			<input type="text" id="form_ticket_price" name="ticket_price" value="FREE" disabled="disabled" />
			{else}
			<input type="text" id="form_ticket_price" name="ticket_price" value="{if $fp->event->profile->price==0}FREE{else} {$fp->event->profile->price} {/if}" />
			{/if}
			
			{include file='lib/error.tpl' error=$fp->getError('ticket_price')}
		</div>
		
		
		
		<div class="wysiwyg">
			{wysiwyg name='content' value=$fp->content}
			{include file='lib/error.tpl' error=$fp->getError('content')}
		</div>
		
	</fieldset>
	
	<div class="submit">
	
		
		{if $fp->event->isLive()}
			{assign var='label' value='Save Changes'}
		{elseif $fp->event->isSaved()}
			{assign var='label' value='Save Changes and Send Live'}
		{else}
			{assign var='label' value='Create and Send Live'}
		{/if}
		
		<input type="submit" value="{$label|escape}"/>
		{if !$fp->event->isLive()}
			<input type="submit" name="preview" value="Preview This Event"/>
		{/if}
	</div>
	
</form>

</div>

<div id="rightContainer">
{if $identity->profile->paypalEmail ==''}
{include file='eventmanager/lib/left-column.tpl' hint='noPaypalEmail'}
{else}
{include file='eventmanager/lib/left-column.tpl'}
{/if}
</div>


{include file='footer.tpl' }