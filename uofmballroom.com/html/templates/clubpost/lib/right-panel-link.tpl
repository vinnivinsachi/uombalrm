

	
	

		
			<ul>
					{foreach from=$RightPanelLink item=post name=Posts}
							<li>
							
								{if $authenticated==1}
				
								<div class="edit_pen2">
                                
									<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
                                    {$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}

								</div>
								{/if}
						{if $post->images|@count >0}
							{assign var=image value=$post->images|@current}
									
							<a href="{$post->profile->title_link}" class="rightPanelLinkImg">
							<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W205_sidePanelPic.jpg" />
							</a> 
							
						{/if}
						
							<div class="Link1"><a href="{$post->profile->title_link}">{$post->profile->title}</a></div>
							</li>
					{/foreach}
			</ul>
		