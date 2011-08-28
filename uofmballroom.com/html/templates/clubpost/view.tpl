{include file='header.tpl' lightbox=true}
{include file='navprofile.tpl' section='posts'}


<div class="post-title">
	{$post->profile->title}
</div>

<div class="post-date">
	{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}
</div>


	<div class="post-image">

{foreach from=$post->images item=image}
		<a href="{imagefilename id=$image->getId() username=$user->username}" rel="lightbox[{$title|escape}]" >
			<img src="{imagefilename id=$image->getId() w=100 username=$user->username}" />
		</a>
{/foreach}
	</div>

<div class="post-content">
	{$post->profile->content}
</div>




{include file='footer.tpl' leftcolumn='clubpost/lib/left-column.tpl' products=$cartObject}