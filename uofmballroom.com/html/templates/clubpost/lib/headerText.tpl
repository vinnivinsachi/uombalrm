			{capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}


<div class="bucketPanel">
	<div class="inside">
	{if $authenticated==1}
		<div class="panel_top_right">
		
				<div class="edit_pen">
				
							{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}
						

						<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
				</div>
		
		</div>
        						{/if}

		
		<div class="panel_content">
		
			{if $post->images|@count >0}
			{assign var=image value=$post->images|@current}
			<div class="teaser-image">
				<a href="{imagefilename id=$image->getId() username='uofmballroom'}" rel="lightbox[{$title|escape}]" title="{$post->profile->title}" >
				<img src="{imagefilename id=$image->getId() w=100 username='uofmballroom'}" />
			</a>
			</div>
			{/if}	
			

						
			{$post->profile->content}
		
		
		
		</div>
		
		
		<div class="panel_bottom_center">
		
	
		
			<div class="bucket-bottom-row">
		
				
				
				
			</div>
		
		</div>	

	</div>
</div>