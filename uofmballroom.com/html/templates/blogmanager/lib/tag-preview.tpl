
<h2>Category: {$tag}</h2>


{if $tagPosts|@count==0}
	<p>
		No posts found currently.
	</p>
{else}
	<dl>
		{foreach from=$posts item=post}
		<dt>
			{$post->ts_created|date_format:'%a, %e %b'}:
			<a href="{geturl action='preview'}?id={$post->getId()}">
				{$post->profile->title|escape}
			</a>
			{if !$post->isLive()}
				.....<span class="status draft">not published</span>
			{/if}
			
		</dt>
		
		<dd>
			{$post->getTeaser(100)|escape}
		</dd>
		{/foreach}
	</dl>
{/if}