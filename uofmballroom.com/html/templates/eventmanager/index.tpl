{if $isXmlHttpRequest}
		{if $tagPosts}
			{include file='eventmanager/lib/tag-preview.tpl posts=$tagPosts}
		{elseif $month}
		
			{include file='eventmanager/lib/month-preview.tpl month=$month posts=$recentPosts}
		{/if}
{else}

{include file='header.tpl' section='eventmanager'}
<div id="leftContainer">

{if $totalPosts ==1}
	<p>
		There is currently <strong class="style1">1</strong> registration in your blog.
	</p>
{else}
	<p>
		There are currenlty <strong class="style1">{$totalPosts}</strong> registrations. 
	</p>
{/if}
	
<form action="/eventmanager/edit" method="get">
	<div class="submit">
	<input type="submit" value="Create a new registration" />
	</div>
</form>


<div id="month-preview">
	{if $tagPosts}
		{include file='eventmanager/lib/tag-preview.tpl posts=$tagPosts}
	{elseif $month}
		{include file='eventmanager/lib/month-preview.tpl month=$monthPost posts=$recentPosts}
	{else}
		<span class="contentTip">Please select from your categories and archives to view exisitng registrations</span>
	{/if}
		
</div>

</div>

<div id="rightContainer">

{include file='eventmanager/lib/left-column.tpl'}
</div>

{include file='footer.tpl' }
{/if}