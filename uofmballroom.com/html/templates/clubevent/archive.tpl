{include file='header.tpl' toplink='true'}
<div id="leftContainer">
Registration Archive: {$archiveTime}

	{if $posts|@count ==0}
		<p>
			No registration were found for this month.
		</p>
	{else}
		{foreach from=$posts item=post name=posts}
			{include file='clubevent/lib/blog-post-summary.tpl' post=$post}
		{/foreach}
	{/if}
</div>
<div id="rightContainer">
{include file='clubevent/lib/left-column.tpl'}
</div>
{include file='footer.tpl' leftcolumn='clubevent/lib/left-column.tpl' products=$cartObject}