{include file='header.tpl' section='blogmanager'}
<script type="text/javascript" src="/htdocs/js_plugin/blogPreview.js"></script>
<script type="text/javascript" src="/htdocs/js_plugin/BlogImageManager.class.js"></script>

<div id="leftContainer">

<form method="post" action="{geturl controller='blogmanager' action='setstatus'}" id="status-form">

<div class="preview-status">
	<input type="hidden" name="id" value="{$post->getId()}"/>
	
	{if $post->isLive()}
		<div class="status live">
			This post IS published. To unpublish it click the <strong>Unpublish Post</strong> button below.
			<div>
				<input type="submit" value="Unpublish post" name="unpublish" id="status-unpublish">
				<input type="submit" value="Edit post" name="edit" id="status-edit">
				<input type="submit" value="Delete post" name="delete" id="status-delete">
			</div>
		</div>
	{else}
		<div class="status draft">
			This post is NOT published. To publish it on your blog, click the button below.
			<div>
				<input type="submit" value="Publish post" name="publish" id="status-publish">
				<input type="submit" value="Edit post" name="edit" id="status-edit">
				<input type="submit" value="Delete post" name="delete" id="status-delete">
			</div>
		</div>
	{/if}
	
</div>

</form>

<form method="get" action="{geturl action='edit'}">
	<div class="submit">
		<input type="submit" value="Create new blog posts"/>
	</div>
</form>

Title: {$post->profile->title}

<fieldset id="preview-categories">
	<legend>Categories</legend>
	
	<ul>
	
		{foreach from=$categories item=cat}
			<li>
	
				<form method="post" action="{geturl action='categories'}">
				<div>
					<span style="color: black;">{$cat|escape}</span>
					<input type="hidden" name="id" value="{$post->getId()}" />
					<input type="hidden" name="category" value="{$cat|escape}" />
					<input type="submit" name="delete" value="delete" />
				</div>
				</form>
			</li>
		{foreachelse} 
			No categories for this post
		{/foreach}
	</ul>
	
	<br/>
	
	<form method="post" action="{geturl action ='categories'}">
		<div>
			<input type="hidden" name="id" value="{$post->getId()}" />
					<select name="category">
					<option value="">None</option>
					<option value="News">**** News ****</option>
					<option value="Banner">**** Banner ****</option>
					<option value="Second Tier">**** Header Text ****</option>
					<option value="Square Link">**** Square Link ****</option>
                    <option value="RightPanelLink">****Right Panel Link****</option>
                    <option value="IndexWelcomeAnnouncement">****IndexWelcomeAnnouncement****</option>
                    <option value="IndexWelcomeEvent">****IndexWelcomeEvent****</option>
                    
                    <option value="">~~~~~~~~~~For Third Tier Only~~~~~~~~</option>
					<option value="Home">---- Home ----</option>
					
					<option value="New Members">---- New Members ----</option>
				
					<option value="Competition">---- Competition ----</option>
                    <option value="Umichcompetition">----Umich Competition</option>
					
					<option value="Media">---- Media ----</option>
					
					<option value="Fundraising">---- Fundraising ----</option>
					
					<option value="Community Outreach">---- Community Outreach ----</option>
					<option value="CharityBall2010">---- Charity Ball 2010 ----</option>
					<option value="Scholarships">---- Scholarships ----</option>
					
					<option value="About Us">---- About Us ----</option>
								
					</select>
			<input type="submit" name="add" value="Add To Category" />
		</div>
	</form>
	
</fieldset>

<fieldset id="preview-tags">
	<legend>Tags</legend>
	
	<ul>
	
		{foreach from=$tags item=tag}
			<li>
	
				<form method="post" action="{geturl action='tags'}">
				<div>
					<span style="color: black;">{$tag|escape}</span>
					<input type="hidden" name="id" value="{$post->getId()}" />
					<input type="hidden" name="tag" value="{$tag|escape}" />
					<input type="submit" name="delete" value="delete" />
				</div>
				</form>
			</li>
		{foreachelse} 
			No tags for this post
		{/foreach}
	</ul>
	
	<br/>
	
	<form method="post" action="{geturl action ='tags'}">
		<div>
			<input type="hidden" name="id" value="{$post->getId()}" />
					<select name="tag">
					<option value="">None</option>
                    <option value="Index">----Index(welcome page)----</option>
					<option value="Home">---- Home ----</option>
					<option value="News">News</option>
					<option value="Calender">Calender</option>
					<option value="New Members">---- New Members ----</option>
					<option value="Practice Information">Practice Information</option>
					<option value="Team Structure">Team Structure</option>
					<option value="Competitions">Competitions</option>
					<option value="Events">Events</option>
					<option value="FAQ">FAQ</option>
					<option value="Dances">Dances</option>
					<option value="Competition">---- Competition ----</option>
					<option value="Michigan Competition">&nbsp;&nbsp;==Michigan Competition</option>
                    <option value="MichComp Home">&nbsp;&nbsp;&nbsp;&nbsp;--MichComp Home</option>
                    <option value="Michigan Difference">&nbsp;&nbsp;&nbsp;&nbsp;--Michigan Difference</option>
                    <option value="Spectator Tickets">&nbsp;&nbsp;&nbsp;&nbsp;--Spectator Tickets</option>
                    <option value="Workshops Registration">&nbsp;&nbsp;&nbsp;&nbsp;--Workshops Registration</option>
                    <option value="Shout Out">&nbsp;&nbsp;&nbsp;&nbsp;--Shout Out</option>
                    <option value="Venue">&nbsp;&nbsp;&nbsp;&nbsp;--Venue</option>
                    <option value="Housing">&nbsp;&nbsp;&nbsp;&nbsp;--Housing</option>
                    <option value="Our Sponsors">&nbsp;&nbsp;&nbsp;&nbsp;--Our Sponsors</option>
                    <option value="Judges">&nbsp;&nbsp;&nbsp;&nbsp;--Judges</option>
                    <option value="Directions">&nbsp;&nbsp;&nbsp;&nbsp;--Directions</option>
                    <option value="Fees">&nbsp;&nbsp;&nbsp;&nbsp;--Fees</option>
                    <option value="Rules">&nbsp;&nbsp;&nbsp;&nbsp;--Rules</option>
                    <option value="The Board">&nbsp;&nbsp;&nbsp;&nbsp;--The Board</option>
					<option value="Away Competition">Away Competition</option>
					<option value="Competition Results">Competition Results</option>
					<option value="Competition Media">Competition Media</option>
					<option value="Competition FAQ">Competition FAQ</option>
					<option value="Media">---- Media ----</option>
					<option value="Pictures">Pictures</option>
					<option value="Video">Videos</option>
					<option value="Fundraising">---- Fundraising ----</option>
					<option value="Team Apparel">Team Apparel</option>
					<option value="Advertise With Us">Advertise With Us</option>
					<option value="Donate To The Team">Donate To The Team</option>
					<option value="Canvassing Home">Canvassing Home</option>
					<option value="Community Outreach">---- Community Outreach ----</option>
                    <option value="CharityBall2010">&nbsp;&nbsp; ==Charity ball 2010</option>
                    <option value="Why Make-A-Wish">&nbsp;&nbsp;&nbsp;&nbsp;-Why Make-A-Wish</option>
                    <option value="Ticket Info">&nbsp;&nbsp;&nbsp;&nbsp;Ticket Info</option>
					<option value="Program of Events">&nbsp;&nbsp;&nbsp;&nbsp;Program of Events</option>
                    <option value="Our Sponsors">&nbsp;&nbsp;&nbsp;&nbsp;Our Sponsors</option>
                    <option value="Make a Donation">&nbsp;&nbsp;&nbsp;&nbsp;Make a Donation</option>
                    <option value="Sponsorship Opportunities">&nbsp;&nbsp;&nbsp;&nbsp;Sponsorship Opprotunities</option>
					<option value="Workshops">Workshops</option>
					<option value="High Schools">High Schools</option>
					<option value="Showcases/performances">Showcases</option>
					<option value="Community Service">Community Service</option>
					<option value="Scholarships">---- Scholarships ----</option>
					<option value="Club Scholarships">Club Scholarships</option>
					<option value="Potential Team Scholarships">Potential Team Scholarships</option>
					<option value="Team/Competition Subsidies">Team/Competition Subsidies</option>
					<option value="Placement Awards">Placement Awards</option>
					<option value="About Us">---- About Us ----</option>
					<option value="Board Members">Board Members</option>
					<option value="Constitution">Constitution</option>
					<option value="Affiliates">Affiliates</option>
					<option value="Contact Us">Contact Us</option>
								
					</select>
					<input type="submit" name="add" value="Add To Tag" />
		</div>
	</form>
	
</fieldset>

<fieldset id="preview-images">
	<legend>Images</legend>
	
	{if $post->images|@count>0}
		<ul id="post_images">
			{foreach from=$post->images item=image}
				<li id="image_{$image->getId()}">
					<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.H65_editThumb.jpg" alt="{$image->filename|escape}" />
					
					<form method="post" action="{geturl action='images'}">
						<div>
							<input type="hidden" name="id" value="{$post->getId()}" />
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
			<input type="hidden" name="id" value="{$post->getId()}" />
			<input type="file" name="image" />
			<input type="submit" value="Upload Image" name="upload" />
		</div>
	</form>
</fieldset>

<div class="preview-date">
	Created: {$post->ts_created|date_format:'%x %X'}
</div>

<div class="preview-title-link">
	Link to: {$post->profile->title_link}
</div>

<div class="preview-content">
	{$post->profile->content}
</div>

</div>

<div id="rightContainer">
{include file="blogmanager/lib/left-column.tpl"}
</div>
			

{include file='footer.tpl'}