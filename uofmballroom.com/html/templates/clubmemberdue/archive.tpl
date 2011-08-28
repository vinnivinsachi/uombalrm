{include file='header.tpl'}
{include file='navprofile.tpl' section='memberships'}

	{if $posts|@count ==0}
		<p>
			No blog posts were found for this month.
		</p>
	{else}
		{foreach from=$posts item=post name=posts}
			{include file='clubmemberdue/lib/blog-post-summary.tpl' post=$post}
		{/foreach}
	{/if}
	
	{include file='footer.tpl' leftcolumn='clubmemberdue/lib/left-column.tpl' products=$cartObject}