{include file='header.tpl' lightbox=true}

<div id="leftContainer">

<div class="post-title">
	{$post->profile->name}
</div>

			{if $post->profile->price>0 && $post->ts_end > $currentTime}

	<a href="{geturl username=$user->username producttype='event'  action ='addproduct' route='shoppingcart'}/?productID={$post->getId()}&cartID={$cartID}" class="addToCart">Add ticket to cart</a>
{/if}

<div class="post-date">
	Start Time: {$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}<br/>
	End Time: {$post->ts_end|date_format:'%b %e,%Y %l:%M %p'}<br/>
	Location: 
	
</div>
<div class="preview-location">
	{$post->profile->location}
</div>

<div class="post-price">
	$ {$post->profile->price}
</div>

{foreach from=$post->images item=image}
	<div class="post-image">
		<a href="{imagefilename id=$image->getId() username=$user->username}" rel="lightbox[{$title|escape}]" >
			<img src="{imagefilename id=$image->getId() w=100 username=$user->username}" />
		</a>
	</div>
{/foreach}

<div class="post-content">
	{$post->profile->content}
</div>

</div>

<div id="rightContainer">
{include file='clubevent/lib/left-column.tpl'}
</div>

{include file='footer.tpl' leftcolumn='clubevent/lib/left-column.tpl' products=$cartObject}