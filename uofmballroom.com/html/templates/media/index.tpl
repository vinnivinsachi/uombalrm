{include file='header.tpl' lightbox=true}

<div id="photoAlbum">

	
	<div id='albumTitle' class='albumBox'>
    	{foreach from=$crumbs item=crumbs name=Crumbs}
        
        
        	&nbsp; &gt; &nbsp;
    		<a href="{geturl controller='media' action='index'}?path={$crumbs.path}">{$crumbs.name}</a>
            
            
    	{/foreach}
    </div>
    
    
    {if $closeup}
    <div id='albumCloseup' class='albumBox'>
    
    	<img src="/data/media/{$path}" />
        
        
    </div>
     {/if}
     

    
    
    {if $subdirs|@count>0}
    <div id='albumFolders' class="albumBox">
    Current Folders<br/> 
    	{foreach from=$subdirs item=subdirs name=Subdirs}
        
        	<a href="{geturl controller='media' action='index'}?path={$path}{$subdirs}/">{$subdirs}</a><br/>
        
        {/foreach}
    
    </div>
    {/if}
    
    <div id="albumSlides">
    
    </div>
    
    <div id="albumImages" class="albumImages">
    
  		{foreach from=$imgs item=imgs name=Imgs}
    	<div class='albumImage_title'>
        	<a href="{geturl controller='media' action='index'}?path={$path}{$imgs}.jpg"><img src="/data/media/{$path}{$imgs}.thumb.jpg" /></a>
        
        </div>
        
        {/foreach}
    </div>
   
    
    
</div>

{include file='footer.tpl'}