{include file='header.tpl' toplink='true'}
{include file='navprofile.tpl' section='posts'}

	{if $posts|@count ==0}
		<p>
			No blog posts were found for this month.
		</p>
	{else}
		{foreach from=$posts item=post name=posts}
			{include file='clubpost/lib/blog-post-summary.tpl' post=$post}
		{/foreach}
	{/if}
	
	{include file='footer.tpl' leftcolumn='clubpost/lib/left-column.tpl' products=$cartObject}