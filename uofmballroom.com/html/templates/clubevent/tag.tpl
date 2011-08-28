{include file='header.tpl'}

<div id="leftContainer">


	{get_post_element user_id=1 object="post" category='Competition' order='asc' tag=$cat assign=thirdTierPost liveOnly="true"}
    
    {foreach from=$thirdTierPost item=post name=Posts}

		{include file='clubpost/lib/blog-post-summary.tpl' post=$post}
			
			{if $smarty.foreach.posts.last}
				{assign var=date value=$post->ts_created}
			{/if}
	{/foreach}

	{if $posts|@count ==0}
		<p>
			No Registration were found for this category.
		</p>
	{else}
		{foreach from=$posts item=post name=posts}
			{include file='clubevent/lib/blog-post-summary.tpl' post=$post}
			
			{if $smarty.foreach.posts.last}
				{assign var=date value=$post->ts_created}
			{/if}
			
		{/foreach}
	{/if}
	
</div>

<div id="rightContainer">
{include file='clubevent/lib/left-column.tpl'}
</div>
	
{include file='footer.tpl' leftcolumn='clubevent/lib/left-column.tpl' products=$cartObject}