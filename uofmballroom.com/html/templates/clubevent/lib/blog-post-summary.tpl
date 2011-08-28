{capture assign='url'}{geturl username=$user->username url=$post->url route='clubeventview'}{/capture}

<div class="bucketPanel">
	<div class="inside">
	
		<div class="panel_top_left">
		</div>
		
		<div class="panel_top_mid">
		
				<div class="title text5">
				<a href="{$url|escape}" class="entry-title" rel="bookmark">
				{$post->profile->name}
				</a>
				
				<span class="bucketDate">Begin: {$post->ts_created|date_format:'%b %e,%Y'}</span>
				
				{if $post->ts_end > $currentTime}
				<span class="bucketDate">Ends: {$post->ts_end|date_format:'%b %e,%Y'}<br/></span>
				{else}
				<span class="status expired">Registration Ended</span>
				{/if}
				
				</div>
				
				{if $authenticated==1}
				
				<div class="edit_pen">
						<a href="{geturl controller='eventmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /><!--<img src="/data/images/button_design_examples.jpg" />--></a>
				</div>
				{/if}
		</div>
		
		<div class="panel_top_right">
		</div>
		
		<div class="panel_content">
	
			
		
		
			{if $post->images|@count >0}
				{assign var=image value=$post->images|@current}
				<div class="teaser-image">
					<a href="{$url|escape}">
						<img src="{imagefilename id=$image->getId() w=100 username=$user->username}" align=""  />
					</a>
				</div>
			{/if}
		
	
			<div class="teaser-content summary">
				{$post->profile->content}
			<!--	{$post->getTeaser(150)}-->
			</div>
			
			<br/>
			<div class="teaser-price">
				Dues:  {if $post->profile->price==0}FREE{else} ${$post->profile->price}{/if}
			</div>
			
			{if $post->profile->price>0 && $post->ts_end > $currentTime}
			
			<a href="{geturl username=$user->username producttype='event'  action ='addproduct' route='shoppingcart'}/?productID={$post->getId()}&cartID={$cartID}" class="addToCart">Register</a>
			{elseif $post->profile->price==0  && $post->ts_end > $currentTime}
			
			<a href="{geturl username=$user->username producttype='event'  action ='addproduct' route='shoppingcart'}/?productID={$post->getId()}&cartID={$cartID}" class="addToCart">Register for free</a>
			{else}
			
			{/if}

		</div>
	
		<div class="panel_bottom_left">
		</div>
		
		<div class="panel_bottom_center">
		
	
		
			<div class="bucket-bottom-row">
		
			
				<div class="teaser-links">
					<a href="{$url|escape}">More...<!--<img src="/data/images/button_design_examples.jpg" />--></a>
					
				</div>
				
				
				
			</div>
		
		</div>
		<div class="panel_bottom_right">
		</div>
	</div>
</div>
