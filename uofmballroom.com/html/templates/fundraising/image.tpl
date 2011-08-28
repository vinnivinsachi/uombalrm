{include file='header.tpl' lightbox=true}

    <div align="left">
    
    
    <fieldset>
    <label>Please upload your image for the shout-out</label>
    {if $post->images|@count>0}
		<ul id="post_images">
			{foreach from=$post->images item=image}
				<li id="image_{$image->getId()}">
					<img src="/data/tmp/thumbnails/uofmballroom/shoutout/{$image->getId()}.H65_editThumb.jpg" alt="{$image->filename|escape}" />
					
					<form method="post" action="{geturl action='image'}">
						<div>
							<input type="hidden" name="id" value="{$post->getId()}" />
							<input type="hidden" name="image" value="{$image->getId()}" />
							<input type="submit" name="delete" value="delete" />
						</div>
					</form>
				</li>
			{/foreach}
		</ul>
	{/if}
	
	<form method="post" action="{geturl action='image'}" enctype="multipart/form-data">
		<div>
			<input type="hidden" name="id" value="{$post->getId()}" />
			<input type="file" name="image" />
			<input type="submit" value="Upload Image and proceed to checkout" name="upload" />


			<input type="submit" value="Proceed without image" name="forceProceed" />
		</div>
	</form>
    
    </fieldset>
    </div>
{include file='footer.tpl'}