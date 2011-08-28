{include file='header.tpl' lightbox=true}

	<div id="leftContainer">
    

	{get_post_element user_id=1 object="post" category="Second Tier" order='asc' tag='Home' assign=secondTierHomePost liveOnly="true"}
    
    {foreach from=$secondTierHomePost item=post name=Posts}

			{include file='clubpost/lib/headerText.tpl' post=$post}

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
	
  
 

	{get_square_link user_id=1 object="post" assign=SquareLink liveOnly="true" order='yes'}

	{include file="clubpost/lib/square-link.tpl"}
    
    	
	</div>
	
    
    	<div id="rightContainer">
        <div class="Link2">

        <a href="https://listserver.itd.umich.edu/cgi-bin/lyris.pl?join=umbdt-disc">Join our email list</a>
 </div><br/>
        
      <a class="lightwindow page-options" title="2009 Talent Showcase" href="http://www.youtube.com/v/2fEjNNJ3WFU&f=videos&app=youtube_gdata" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false">
<img src="http://i.ytimg.com/vi/2fEjNNJ3WFU/default.jpg" width="230" id="frontVideoImage"/>
</a> 
<div class='box'>
<h3>Shopping cart</h3>
<ul>
{foreach from=$cartObject item=cartItem}
	<li>{$cartItem->product_name}<br/> $
    	{$cartItem->unit_cost}<li>
{/foreach}

</ul>
<a>Checkout</a>

</div>
		{include file="index/lib/calender.tpl"}<br/>
        
        <div style="margin-left:14px; float:left; margin-top:3px;">
            <div class="Link3Left">
            </div>
            <div class="Link3">
                <a href="http://www.uofmballroom.com/registration" style="padding-top:15px;">Become a member now!</a>
            </div>
            <div class="Link3Right">
            </div>
        </div>
        
        
        <div>
        	<a href="/data/document/Final Draft copy4.pdf"><img src="/data/images/NewsletterThumbnail.jpg" /></a>
            <a href="/data/document/Final Draft copy4.pdf" target="_blank">Download Spring 2009 Newsletter</a>
        </div>
        
		{include file="index/lib/shoutbox.tpl"}
        
       
	</div>
    
    

{include file='footer.tpl'}