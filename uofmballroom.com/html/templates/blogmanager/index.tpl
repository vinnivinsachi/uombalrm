{if $isXmlHttpRequest}
		{if $tagPosts}
			{include file='blogmanager/lib/tag-preview.tpl posts=$tagPosts}
		{elseif $month}
		
			{include file='blogmanager/lib/month-preview.tpl month=$month posts=$recentPosts}
		{/if}
{else}

	{include file='header.tpl' section='blogmanager'}
	
	
	<div id="leftContainer">
	{if $totalPosts ==1}
		<p>
			There is currently <strong class="style1">1</strong> post in your blog.
		</p>
	{else}
		<p>
			There are currenlty <strong class="style1">{$totalPosts}</strong> posts. 
		</p>
	{/if}
	
	
	<form method="get" action="{geturl action='edit'}">
		<div class="submit">
			<input type="submit" value="Create new blog posts"/>
		</div>
	</form>
	
	<div id="month-preview">
		{if $tagPosts}
			{include file='blogmanager/lib/tag-preview.tpl posts=$tagPosts}
		{elseif $month}
			{include file='blogmanager/lib/month-preview.tpl month=$monthPost posts=$recentPosts}
		{else}
			<span class="contentTip">Please select from your categories and archives to view exisitng posts</span>
		{/if}
	</div>
	
	
	</div>
	
	<div id="rightContainer">
		{include file='blogmanager/lib/left-column.tpl'}
	
	</div>
	
	
	
	
	{include file='footer.tpl' }
{/if}