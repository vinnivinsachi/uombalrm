{include file='header.tpl' lightbox=true section='post'}


	
{foreach from=$objects item=objects name=objects}
			{include file='clubpost/lib/second-tier-blog-post-summary.tpl' post=$objects}
			
			{if $smarty.foreach.posts.last}
				{assign var=date value=$post->ts_created}
			{/if}
{/foreach}

{get_square_link user_id=1 object="post" page=$SecondTier liveOnly="true" order="p.ts_created asc" assign=SquareLink }

{include file="clubpost/lib/square-link.tpl"}
	
	
{include file='footer.tpl'  products=$cartObject}