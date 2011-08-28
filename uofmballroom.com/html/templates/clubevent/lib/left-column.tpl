{if $noUser != 'TRUE'}
{get_tag_summary user_id=$user->getId() assign=summary object='event'}

{if $summary|@count>0}
	<div class="box">
		<h3>Registration Categories</h3>
		<ul>
			{foreach from=$summary item=tag}
			<li>
				<a href="{geturl route='clubeventtagspace' username=$user->username tag=$tag.tag}">
				{$tag.tag|escape}
				</a>
				
				({$tag.count} registration{if $tag.count != 1}s{/if})
			</li>
			{/foreach}
		</ul>
	</div>
{/if}


{get_monthly_blogs_summary user_id=$user->getId() assign=summary liveOnly=true object='event'}

{if $summary|@count>0}
	<div id="preview-months" class="box">
		<h3>Registration Archive</h3>
		<ul>
			
			{foreach from=$summary key=month item=numPosts}
				<li>
					<a href="{geturl username=$user->username route='clubeventarchive' year=$month|date_format:'%Y' month=$month|date_format:'%m'}">{$month|date_format:'%B %Y'}
					</a>
					({$numPosts} registration{if $numPosts!=1}s {/if})
					
				</li>
			{/foreach}
			
		</ul>
		
	</div>
{else}
	<div id="preview-months" class="box">
		<h3>{$user->profile->public_club_name|escape}'s product Archive</h3>
		There are currently no posts.
	</div>
{/if}

{/if}