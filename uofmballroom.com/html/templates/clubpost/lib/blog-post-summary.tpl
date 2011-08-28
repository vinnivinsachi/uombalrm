{capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}

<div class="bucketPanel">
	<div class="inside">
	

		
		<div class="panel_top_mid">
		
				<div class="title text5">
				{$post->profile->title}
				</a>
						

				</div>
				
				
			
				
	
</div>
		
		<div class="panel_top_right">
		
				<div class="edit_pen">
						{if $post->profile->facebookURL!=""}<a href="{$post->profile->facebookURL}" target="_blank"><img src="/data/images/facebook-logo.png" /></a>{/if}
                        {if $post->profile->locationURL!=""}
                        <a href="http://www.bing.com/maps/default.aspx?where1={$post->profile->locationURL}" target="_blank"><img src="/data/images/gmaps.png" /></a>{/if}
						{if $authenticated==1}
						{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}
						<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
						{/if}
                        
                      
				</div>
		
		</div>
		
		<div class="panel_content">
		
			{if $post->images|@count >0}
			{assign var=image value=$post->images|@current}
			<div class="teaser-image">
            
            
            <a class="lightwindow" title="image" href="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W403_mainFrontTwo.jpg">
			<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W140_postThumb.jpg" /> 			</a>
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
