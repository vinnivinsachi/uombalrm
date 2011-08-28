

	
	
	{if $Banner|@count>0}
    
    <div id="bannerBox">
	
		<div id="banner" class="hidden">

		
		
		
			<ul>
					{foreach from=$Banner item=post name=Posts}
							<li>
						{if $post->images|@count >0}
							{if $authenticated==1}
				
								<div class="edit_pen2">
									<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
								</div>
								{/if}
							
                            <div id="bannerImageSlide">
                            {foreach from=$post->images item=image name=Image}

							<!--<a href="{imagefilename id=$image->getId() username='uofmballroom'}" rel="lightbox[{$title|escape}]" title="{$post->profile->content}" >-->
							<img width="910" src="/data/uploaded-files/uofmballroom/post/{$image->getId()}.jpg" />
							<!--</a>-->
							 {/foreach}
                            </div> 
						 
						{/if}	
							</li>
					{/foreach}
			</ul>
		</div>
      </div>
	{/if}