{include file='header.tpl' lightbox=true}

	<div id="leftContainer">
    




	{get_post_element user_id=1 object="post" category="Second Tier" order='asc' tag='Competition' assign=secondTierHomePost liveOnly="true"}
    
    {foreach from=$secondTierHomePost item=post name=Posts}
			{capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}

        <div class="bucketPanel">
            <div class="inside">
                                            {if $authenticated==1}

                <div class="panel_top_right">
                
                        <div class="edit_pen">
                        
                                    <!--	{$post->ts_created|date_format:'%b %e,%Y %l:%M %p'}-->
        
                                <a href="{geturl controller='blogmanager' action='edit'}?id={$post->getId()}"><img src="/data/images/edit_pen.png" /></a>
                        </div>
                
                </div>
                                                {/if}

                
                <div class="panel_content">
                
                    {if $post->images|@count >0}
                    {assign var=image value=$post->images|@current}
                    <div class="teaser-image">
                        <a href="{imagefilename id=$image->getId() username='uofmballroom'}" rel="lightbox[{$title|escape}]" title="{$post->profile->title}" >
                        <img src="{imagefilename id=$image->getId() w=100 username='uofmballroom'}" />
                    </a>
                    </div>
                    {/if}	
                    
        
                                
                    {$post->profile->content}
                
                
                
                </div>
                
                
                <div class="panel_bottom_center">
                
            
                
                    <div class="bucket-bottom-row">
                
                        
                        
                        
                    </div>
                
                </div>	
        
            </div>
        </div>

		{/foreach}
	
    
    {if $posts|@count ==0}
		<p>
			No posts were found for this club. 
		</p>
	{else}
	
	
		{foreach from=$posts item=post name=Posts}
			{include file='index/lib/blog-post-summary.tpl' post=$post}
		{/foreach}

		
	{/if}
	

	{get_square_link user_id=1 object="post" assign=SquareLink liveOnly="true" order='yes' page='Competition'}

	{include file="clubpost/lib/square-link.tpl"}
    
    	
	</div>
	
    
    	<div id="rightContainer">
        
        
  <!--    <a class="lightwindow page-options" title="Daisy Vincent Rumba Showcase" href="http://www.youtube.com/v/3RimMiUF8Rs&f=videos&app=youtube_gdata" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false">
<img src="http://i.ytimg.com/vi/3RimMiUF8Rs/default.jpg" width="230"/>
</a> -->
        
         
        
        <div class="Link2">

        <a href="https://listserver.itd.umich.edu/cgi-bin/lyris.pl?join=umbdt-disc">Join our email list</a>
 </div><br/><br />




		
		{include file="index/lib/calender.tpl"}<br/><br /><br />

		{include file="index/lib/shoutbox.tpl"}
        
        {include file="sideCart.tpl" cartObject=$cartObject}
	</div>


{include file='footer.tpl'}