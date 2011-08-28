{include file='header.tpl' section='eventmanager'}
<script type="text/javascript" src="/htdocs/js_plugin/blogPreview.js"></script>
<script type="text/javascript" src="/htdocs/js_plugin/BlogImageManager.class.js"></script>
<div id="leftContainer">
<form method="post" action="{geturl controller='eventmanager' action='setstatus'}" id="status-form">

<div class="preview-status">
	<input type="hidden" name="id" value="{$event->getId()}"/>
	
	{if $event->isLive()}
		<div class="status live">
			This event IS published. To unpublish it click the <strong>Unpublish Event</strong> button below.
			<div>
				<input type="submit" value="Unpublish post" name="unpublish" id="status-unpublish">
				<input type="submit" value="Edit post" name="edit" id="status-edit">
				<input type="submit" value="Delete post" name="delete" id="status-delete">
			</div>
		</div>
	{else}
		<div class="status draft">
			This event is NOT published. To publish it on your blog, click the button below.
			<div>
				<input type="submit" value="Publish post" name="publish" id="status-publish">
				<input type="submit" value="Edit post" name="edit" id="status-edit">
				<input type="submit" value="Delete post" name="delete" id="status-delete">
			</div>
		</div>
	{/if}
</div>
</form>


<fieldset id="preview-tags">
	<legend>Categories</legend>
	
	<ul>
		{foreach from=$tags item=tag}
		
			<li>
				<form method="post" action="{geturl action='tags'}">
					<div>
						{$tag|escape}
						<input type="hidden" name="id" value="{$event->getId()}" />
						<input type="hidden" name="tag" value="{$tag|escape}" />
						<input type="submit" value="delete" name="delete" />
					</div>
				</form>
			</li>
		{foreachelse}
			<li> No tags found</li>
		{/foreach}
	</ul>
	<br/>
	<form method="post" action="{geturl action='tags'}">
		<div>
			<input type="hidden" name="id" value="{$event->getId()}" />
			<input type="text" name="tag" />
			<input type="submit" value="Add To Category" name="add" />
		</div>
	</form>
</fieldset>

<fieldset id="preview-images">

	<legend>Images</legend>
	
	
	{if $event->images|@count>0}
		<ul id="post_images">
			{foreach from=$event->images item=image}
				<li id="image_{$image->getId()}">
					<img src="{imagefilename id=$image->getId() w=200 h=65}" alt="{$image->filename|escape}" />
					
					<form method="post" action="{geturl action='images'}">
						<div>
							<input type="hidden" name="id" value="{$event->getId()}" />
							<input type="hidden" name="image" value="{$image->getId()}" />
							<input type="submit" name="delete" value="delete" />
						</div>
					</form>
				</li>
			{/foreach}
		</ul>
	{/if}
	
	
	
	<form method="post" action="{geturl action='images'}" enctype="multipart/form-data">
		<div>
			<input type="hidden" name="id" value="{$event->getId()}" />
			<input type="file" name="image" />
			<input type="submit" value="Upload Image" name="upload" />
		</div>
	</form>
</fieldset>






<div class="preview-date">
	Start Time: {$event->ts_created|date_format:'%x %X'}<br/>
	End	  Time: {$event->ts_end|date_format:'%x %X'} <br/>
	Location: 
</div>

<div class="preview-location">
	{$event->profile->location}

</div>

<div class="product-price">
{if $event->profile->price ==0}
FREE
{else}
${$event->profile->price}
{/if}
</div>


<div class="preview-content">
	<h3>Description:</h3>
	{$event->profile->content}<br/>
	<br/>
	<br/>
	<br/>
	<br/>

	
	
</div>

</div>


<div id="rightContainer">
{include file='eventmanager/lib/left-column.tpl'}
</div>

			

{include file='footer.tpl' }