{include file="header.tpl"}

<div id="leftContainer">

 
	

	{if $posts|@count ==0}
		<p>
			No products were found for this club. 
		</p>
	{else}
	
	
		{foreach from=$posts item=post name=Posts}
			{include file='clubpost/lib/blog-post-summary.tpl' post=$post}
		{/foreach}

		
	{/if}
	
</div>
{include file="footer.tpl"}