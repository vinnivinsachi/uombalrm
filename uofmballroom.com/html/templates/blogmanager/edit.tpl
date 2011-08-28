{include file='header.tpl' section='blogmanager'}

<div id="leftContainer">

<form method="post" action="{geturl action='edit'}?id={$fp->post->getId()}">
	
	{if $fp->hasError()}
		<div class="error">
			An error has occured in the form below. Please check the highlighted fields and resubmit the form.
		</div>
	{/if}
	
	<fieldset>
		<legend>Blog Post Details</legend>
		
		<div class="row" id="form_title_container">
			<label for="form_title">Title:</label>
			<input type="text" id="form_title" name="username" value="{$fp->title|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('title')}
		</div>
		
		<div class="row" id="form_title_link">
			<label for="form_title">Title Link:</label>
			
			<select name="title_link">
			<option value="#">None</option>
			<option value="http://www.visachidesign.com">---- Home ----</option>
			<option value="#">News</option>
			<option value="#">Calender</option>
			<option value="/clubpost/uofmballroom/secondtier?value=New Members" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=New Members"}selected="selected"{/if}>---- New Members ----</option>
			<option value="/clubpost/uofmballroom/cat?category=New Members&tags=Practice Information" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=Practice Information"}selected="selected"{/if}>Practice Information</option>
        	<option value="/clubpost/uofmballroom/cat?category=New Members&tags=Events" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=Events"}selected="selected"{/if}>Social Events</option>
			<option value="/clubpost/uofmballroom/cat?category=New Members&tags=Dances" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=Dances" }selected="selected"{/if}>Dances</option>

			
			<option value="/clubpost/uofmballroom/cat?category=New Members&tags=Competitions" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=Competitions"}selected="selected"{/if}>Competitions for newcomer</option>
<option value="/clubpost/uofmballroom/cat?category=New Members&tags=Team Structure" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=Team Structure"}selected="selected"{/if}>Team Structure</option> 
			<option value="/clubpost/uofmballroom/cat?category=New Members&tags=FAQ" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=New Members&tags=FAQ"}selected="selected"{/if}>FAQ</option>
            <option value="/registration">Register</option>

			<option value="/clubpost/uofmballroom/secondtier?value=Competition" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=Competition"}selected="selected"{/if}>---- Competition ----</option>
         
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=MichComp Home" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=MichComp Home" }selected="selected"{/if}>&nbsp;&nbsp;==Michigan Competition</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=MichComp Home" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=MichComp Home" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--MichComp Home</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Michigan Difference" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Michigan Difference" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Michigan Difference</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Spectator Tickets" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Spectator Tickets" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Spectator Tickets</option>
             <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Workshops Registration" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Workshops Registration" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Workshops Registration</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout Out" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout Out" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Shout Out</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Venue" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Venue" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Venue</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Housing" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Housing" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Housing</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Our Sponsors" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Our Sponsors" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Our Sponsors</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Judges" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Judges" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Judges</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Directions" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Directions" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Directions</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Fees" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Fees" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Fees</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Rules" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Rules" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--Rules</option>
            <option value="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=The Board" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Umichcompetition&tags=The Board" }selected="selected"{/if}>&nbsp;&nbsp;&nbsp;&nbsp;--The Board</option>
            
			<option value="/clubpost/uofmballroom/cat?category=Competition&tags=Away Competition" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Competition&tags=Away Competition"}selected="selected"{/if}>Away Competition</option>
			<option value="/competition/results" {if $fp->title_link=="/competition/results"}selected="selected"{/if}>Competition Results</option>
			<option value="/clubpost/uofmballroom/cat?category=Competition&tags=Competition Media" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Competition&tags=Competition Media"}selected="selected"{/if}>Competition Media</option>
			<option value="/clubpost/uofmballroom/cat?category=Competition&tags=Competition FAQ" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Competition&tags=Competition FAQ"}selected="selected"{/if}>Competition FAQ</option>
			<option value="/clubpost/uofmballroom/secondtier?value=Media" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=Media"}selected="selected"{/if}>---- Media ----</option>
			<option value="/media/video" {if $fp->title_link=="/media/video" }selected="selected"{/if}>Videos</option>
			<option value="/media/album" {if $fp->title_link=="/media/album"}selected="selected"{/if}>Photographs</option>

			<option value="/clubpost/uofmballroom/secondtier?value=Fundraising" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=Fundraising"}selected="selected"{/if}>---- Fundraising ----</option>
			<option value="/clubproduct/uofmballroom?category=Fundraising&tags=Team Apparel" {if $fp->title_link=="/clubproduct/uofmballroom?category=Fundraising&tags=Team Apparel"}selected="selected"{/if}>Team Apparel</option>
			
			<option value="/clubpost/uofmballroom/cat?category=Fundraising&tags=Donate To The Team" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Fundraising&tags=Donate To The Team" }selected="selected"{/if}>Donate To The Team</option>
<option value="/clubpost/uofmballroom/cat?category=Fundraising&tags=Advertise With Us" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Fundraising&tags=Advertise With Us"}selected="selected"{/if}>Advertise With Us</option>
			
			<option value="/clubpost/uofmballroom/secondtier?value=Community Outreach" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=Community Outreach"}selected="selected"{/if}>---- Community Outreach ----</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=CharityBall2010" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=CharityBall2010"}selected="selected"{/if}>-- Charity ball 2010</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Why Make-A-Wish" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Why Make-A-Wish"}selected="selected"{/if}>- Make a wish</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Ticket info" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Ticket info"}selected="selected"{/if}>- Ticket info</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Program Events" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Program Events"}selected="selected"{/if}>- Program Events</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Our Sponsors" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Our Sponsors"}selected="selected"{/if}>- Our Sponsors</option>
            <option value="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Make a Donation" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=CharityBall2010&tags=Make a Donation"}selected="selected"{/if}>- Make a Donation</option>
		<option value="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Showcases/performances" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Showcases/performances" }selected="selected"{/if}>Showcases/Performances</option>
			<option value="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Workshops" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Workshops"}selected="selected"{/if}>Workshops</option>
			<option value="/clubpost/uofmballroom/cat?category=Community Outreach&tags=High Schools" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Community Outreach&tags=High Schools"}selected="selected"{/if}>High Schools</option>
			
			<option value="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Community Service" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Community Outreach&tags=Community Service"}selected="selected"{/if}>Community Service</option>
			<option value="/clubpost/uofmballroom/secondtier?value=Scholarships" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=Scholarships"}selected="selected"{/if}>---- Scholarships ----</option>
			
			<option value="/clubpost/uofmballroom/cat?category=Scholarships&tags=Team Scholarships" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Scholarships&tags=Team Scholarships"}selected="selected"{/if}>Team Scholarships</option>
			<option value="/clubpost/uofmballroom/cat?category=Scholarships&tags=Competition Scholarships" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Scholarships&tags=Competition Scholarships" }selected="selected"{/if}>Competition Scholarships</option>
            <option value="/clubpost/uofmballroom/cat?category=Scholarships&tags=Club Scholarships" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=Scholarships&tags=Club Scholarships" }selected="selected"{/if}>Club Scholarships</option>
			<option value="/clubpost/uofmballroom/secondtier?value=About Us" {if $fp->title_link=="/clubpost/uofmballroom/secondtier?value=About Us"}selected="selected"{/if}>---- About Us ----</option>
			<option value="/clubpost/uofmballroom/cat?category=About Us&tags=Board Members" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=About Us&tags=Board Members"}selected="selected"{/if}>Board Members</option>
			
			<option value="/clubpost/uofmballroom/cat?category=About Us&tags=Affiliates" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=About Us&tags=Affiliates"}selected="selected"{/if}>Affiliates</option>
			<option value="/clubpost/uofmballroom/cat?category=About Us&tags=Constitution" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=About Us&tags=Constitution" }selected="selected"{/if}>Constitution</option>
			<option value="/clubpost/uofmballroom/cat?category=About Us&tags=Contact Us" {if $fp->title_link=="/clubpost/uofmballroom/cat?category=About Us&tags=Contact Us"}selected="selected"{/if}>Contact Us</option> 
						
			</select>
		</div> 
        
        <div class="row" id="form_location_conatiner">
        
        	<label for="form_location">Event Location:</label>
            <input type="text" id="form_location" name="location" value="{$fp->location|escape}"/>
			{include file='lib/error.tpl' error=$fp->getError('location')}
        </div>
        
        <div class="row" id="form_location_url_container">
        	<label for="form_location_url">Event Google Map URL:</label>
            <input type="text" id="form_location_url" name="location_url" value="{$fp->locationURL|escape}"/> 
        </div>
        
        <div class="row" id="form_facebook_url_container">
        	<label for="form_facebook_url">Facebook URL:</label>
            <input type="text" id="form_facebook_url" name="facebook_url" value="{$fp->facebookURL|escape}"/>
        </div>
        
		
		<div class="row" id="form_date_container">
			<label for="form_date">Date of Entry:</label>
			{html_select_date prefix='ts_created' 
							  time=$fp->ts_created
							  start_year=-5
							  end_year=+5}
			
			{html_select_time prefix='ts_created'
							  time=$fp->ts_created
							  display_seconds = false
							  use_24_hours=false}
			
			{include file='lib/error.tpl' error=$fp->getError('date')}
		</div>
		
        <div class="row" id="form_startdate_container">
			<label for="form_startdate">Event Start Time:</label>
			{html_select_date prefix='ev_created' 
							  time=$fp->ts_created
							  start_year=-2
							  end_year=+2}
			
			{html_select_time prefix='ev_created'
							  time=$fp->ts_created
							  display_seconds = false
							  use_24_hours=false}
			
		</div>
		
		<div class="row" id="form_enddate_container">
			<label for="form_enddate">Event End Time:</label>
			{html_select_date prefix='ev_ended' 
							  time=$fp->ts_end

							  start_year=-2
							  end_year=+2}
			
			{html_select_time prefix='ev_ended'
							  time=$fp->ts_end
							  display_seconds = false
							  use_24_hours=false}
		</div>
        
		<div class="wysiwyg">
			{wysiwyg name='content' value=$fp->content}
			{include file='lib/error.tpl' error=$fp->getError('content')}
		</div>
		
	</fieldset>
	
	<div class="submit">
		{if $fp->post->isLive()}
			{assign var='label' value='Save Changes'}
		{elseif $fp->post->isSaved()}
			{assign var='label' value='Save Changes and Send Live'}
		{else}
			{assign var='label' value='Create and Send Live'}
		{/if}
		
		<input type="submit" value="{$label|escape}"/>
		{if $fp->post->isLive()}
					<input type="submit" name="preview" value="Preview This Post"/>

		{/if}
		
		{if !$fp->post->isLive()}
			<input type="submit" name="preview" value="Preview This Post"/>
		{/if}
	</div>
	
</form>

</div>

<div id="rightContainer">

{include file="blogmanager/lib/left-column.tpl"}
</div>

{include file='footer.tpl' leftcolumn='blogmanager/lib/left-column.tpl'}