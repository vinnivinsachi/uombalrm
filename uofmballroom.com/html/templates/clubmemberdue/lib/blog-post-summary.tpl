{capture assign='url'}{geturl memberusername=$user->username url=$post->url route='clubmemberdueview'}{/capture}

<div class="bucketPanel">
	<div class="inside">
	
		<div class="panel_top_left">
		</div>
		
		<div class="panel_top_mid">
		
				<div class="title text5">
				<a href="{$url|escape}" class="entry-title" rel="bookmark">
				{$post->profile->name}
				</a>
				
				<span class="bucketDate">{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}</span>

				</div>
				
				{if $authenticated==1}
				
				<div class="edit_pen">
						<a href="{geturl controller='membershipmanager' action='edituniversaldue'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /><!--<img src="/data/images/button_design_examples.jpg" />--></a>
				</div>
				{/if}
		</div>
		
		<div class="panel_top_right">
		</div>
		
		<div class="panel_content">
	
	
	
		{if $post->profile->price>0}

		<a href="{geturl username=$user->username producttype='due'  action ='addproduct' route='shoppingcart'}/?productID={$post->getId()}&cartID={$cartID}" class="addToCart">purchase club due</a>
		{elseif $post->profile->price==0}

		{/if}

	


		<br/>
		<div class="teaser-price">
			Due:  {if $post->profile->price==0}FREE{else} ${$post->profile->price}{/if}
		</div>
	
	
		{if $post->images|@count >0}
			{assign var=image value=$post->images|@current}
			<div class="teaser-image">
				<a href="{$url|escape}">
					<img src="{imagefilename id=$image->getId() w=100 username=$user->username}" align=""  />
				</a>
			</div>
		{/if}
	

			<div class="teaser-content summary">
				{$post->getTeaser(150)}
			</div>
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
