{include file='header.tpl'}

	{if $posts|@count ==0}
		<p>
			No blog posts were found for this user. 
		</p>
	{else}
		{foreach from=$posts item=post name=Posts}
			{include file='club/lib/blog-post-summary.tpl' post=$post}
		{/foreach}
	{/if}
	
{include file='footer.tpl' leftcolumn='club/lib/left-column.tpl' rightcolumn='club/lib/right-column.tpl products=$cartObject}