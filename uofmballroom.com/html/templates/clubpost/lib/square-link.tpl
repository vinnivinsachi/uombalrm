

	
	
	{if $SquareLink|@count>0}
	
		{if ($SquareLink|@count ==4) && $SecondTier!='Home' && $SecondTier!='Competition'}
		
		<div id="squareLink4">
		{elseif (($SquareLink|@count ==3) || ($SquareLink|@count ==6) ||($SquareLink|@count ==9)) && $SecondTier!='Home'}
		
		<div id="squareLink3">
		
		{elseif ($SquareLink|@count ==2) && $SecondTier!='Home'}
		
		<div id="squareLink2">
		{else}
		<div id="squareLink">
		{/if}
		
		
			<ul>
					{foreach from=$SquareLink item=post name=Posts}
							<li>
							
								{if $authenticated==1}
				
								<div class="edit_pen2">

									<a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
                                    {$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}

								</div>
								{/if}
						{if $post->images|@count >0}
							{assign var=image value=$post->images|@current}
							
							{if ($SquareLink|@count ==4) && $SecondTier!='Home' && $SecondTier!='Competition'}
		
							<a href="{$post->profile->title_link}">
							<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W207_mainFrontFour.jpg" />
							</a>
							
							{elseif (($SquareLink|@count ==3) || ($SquareLink|@count ==6) ||($SquareLink|@count ==9)) && $SecondTier!='Home'}
							<a href="{$post->profile->title_link}">
							<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W263_mainFrontThree.jpg" />
							</a>
							
							{elseif ($SquareLink|@count ==2) && $SecondTier!='Home'}

							<a href="{$post->profile->title_link}">
							<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W403_mainFrontTwo.jpg" />
							</a>
							
							{else}
							<a href="{$post->profile->title_link}">
							<img src="/data/tmp/thumbnails/uofmballroom/post/{$image->getId()}.W150_homeFrontFour.jpg" />
							</a>
							{/if}
							
						
						{/if}	
						
							<div class="Link1"><a href="{$post->profile->title_link}">{$post->profile->title}</a></div>
							</li>
					{/foreach}
			</ul>
		</div>
	{/if}