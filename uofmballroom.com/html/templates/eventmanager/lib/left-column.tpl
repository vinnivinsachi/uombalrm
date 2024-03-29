{if $messages|@count>0}
		<div id="messages" class="messageBox">
			{if $messages|@count==1}
				<strong>Status Message:</strong>
				{$messages.0|escape}
			{else}
				<strong>Status Messages:</strong>
				<ul>
					{foreach from=$messages item=row}
						<li>{$row|escape}</li>
					{/foreach}
				</ul>
			{/if}
		</div>
		
	{else}
		<div id="messages" class="box" style="display:none"></div>
	{/if}
	

{get_tag_summary user_id=$identity->getId() object="event" assign=summary}

{if $summary|@count>0}
	<div id="preview-tags2" class="box">
		<h3>Your registration Categories</h3>
		<ul>
			{foreach from=$summary item=tag}
			<li>
				<a href="{geturl controller='eventmanager'}?tag={$tag.tag}">
				{$tag.tag|escape}
				</a>
				
				({$tag.count} registration{if $tag.count != 1}s{/if})
			</li>
			{/foreach}
		</ul>
	</div>
	
<script type="text/javascript" src="/htdocs/js_plugin/BlogTagSummary.class.js"></script>
<script type="text/javascript">new BlogTagSummary('month-preview', 'preview-tags2');</script>
	
{/if}


{get_monthly_blogs_summary user_id=$identity->getId() object="event" assign=summary}

{if $summary|@count >0}
	<div id="preview-months" class="box">
		<h3>Your Registrations Archives</h3>
		<ul>
			{foreach from=$summary key=month item=numPosts}
				<li>
					<a href="{geturl controller='eventmanager'}?month={$month}">
						{$month|date_format:'%B %Y'}
					</a>
					({$numPosts} registration{if $numPosts!=1}s{/if})
				</li>
			{/foreach}
		</ul>
	</div>
	
<script type="text/javascript" src="/htdocs/js_plugin/BlogTagSummary.class.js"></script>
<script type="text/javascript">new BlogTagSummary('month-preview', 'preview-months');</script>
{/if}