{capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}

<div id="secTier">

	<div class="bucketSectier">
	<!--	
		<div class="bucketTopLeft">
		</div>
		-->
		
	<!--	<div class="secondTierTitle">
				<a href="{$url|escape}" class="entry-title" rel="bookmark">
				{$post->profile->title}
				</a>
		</div>-->
	
    
    	{if $authenticated==1}
		<div class="panel_top_right">
		
				<div class="edit_pen">
				
							<!--	{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}-->
						

						<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
				</div>
		
		</div>
        {/if}

		
		<div class="post-content">
			{$post->profile->content}
			</div>
		
		
		
		
	</div>
	
	
	
</div>
