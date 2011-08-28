{include file='header.tpl'  lightbox=true section='post'}

{if $SecondTier !='Umichcompetition'}

        <div id="leftContainer">
        {get_post_element user_id=1 object="post" category="Second Tier" order='asc' tag=$SecondTier assign=secondTierHomePost liveOnly="true"}
            
            {foreach from=$secondTierHomePost item=post name=Posts}
                    {capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}
                    {include file='clubpost/lib/headerText.tpl' post=$post}
            {/foreach}
                
                
                
            {if $thirdTierTag !='Home'}
            {get_post_element user_id=1 object="post" category=$SecondTier order='asc' tag=$thirdTierTag assign=thirdTierPost liveOnly="true"}
            
            {foreach from=$thirdTierPost item=post name=Posts}
        
                {include file='clubpost/lib/blog-post-summary.tpl' post=$post}
                    
                    {if $smarty.foreach.posts.last}
                        {assign var=date value=$post->ts_created}
                    {/if}
            {/foreach}
            {else}
            {foreach from=$objects item=objects name=objects}
                    {include file='clubpost/lib/blog-post-summary.tpl' post=$objects}
                    
                    {if $smarty.foreach.posts.last}
                        {assign var=date value=$post->ts_created}
                    {/if}
                    
            {/foreach}
            {/if}
        </div>
        
        <div id="rightContainer">
        
        {get_post_element user_id=1 object="post" category="RightPanelLink" order='asc' tag=$styleView assign=RightPanelLink liveOnly="true"}
        <div id="rightPanelLinkContainer">
        {include file="clubpost/lib/right-panel-link.tpl"}
        
         <div style="margin-left:7px; float:left; margin-top:3px;">
                    <div class="Link3Left">
                    </div>
                    <div class="Link3">
                        <a href="http://www.uofmballroom.com/registration" style="padding-top:15px;">Become a member now!</a>
                    </div>
                    <div class="Link3Right">
                    </div>
        
                </div>
        </div>
        
        </div>
{else}
<div id="rightContainer" style="float:left; width:180px;">

<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=MichComp Home">MichComp Home</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Michigan Difference">Michigan Difference</a></div>
<div class="compLink">
<a href="http://www.dance.zsconcepts.com/competition/registration-main.cgi?comp_id=136">Competitor Registration</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Spectator Tickets">Spectator Tickets</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Workshops Registration">Workshops Registration</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Shout Out">&quot;Shout-Out&quot;</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Our Sponsors">Our Sponsors</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Venue">Venue</a></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Housing">Housing</a></div>

<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Judges">Judges</a><br /></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Directions">Directions</a><br /></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Fees">Fees</a><br /></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Rules">Rules</a><br /></div>
<div class="compLink">
<a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=The Board">The Board</a><br /></div>
<div class="compLink">
<a href="{geturl controller='index' action='index'}">Team Home Page</a><br /></div>
</div>

<div id="leftContainer" style="float:right;">
{get_post_element user_id=1 object="post" category="Second Tier" order='asc' tag=$SecondTier assign=secondTierHomePost liveOnly="true"}
            
            {foreach from=$secondTierHomePost item=post name=Posts}
                    {capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}
        
                    {include file='clubpost/lib/headerText.tpl' post=$post}
        
                {/foreach}
                
                
                
            {if $thirdTierTag !='Home'}
            {get_post_element user_id=1 object="post" category=$SecondTier order='asc' tag=$thirdTierTag assign=thirdTierPost liveOnly="true"}
            
            {foreach from=$thirdTierPost item=post name=Posts}
        
                {include file='clubpost/lib/blog-post-summary.tpl' post=$post}
                    
                    {if $smarty.foreach.posts.last}
                        {assign var=date value=$post->ts_created}
                    {/if}
            {/foreach}
            {else}
            {foreach from=$objects item=objects name=objects}
                    {include file='clubpost/lib/blog-post-summary.tpl' post=$objects}
                    
                    {if $smarty.foreach.posts.last}
                        {assign var=date value=$post->ts_created}
                    {/if}
                    
            {/foreach}
            {/if}
</div>




{/if}
	
	
	
{include file='footer.tpl'  products=$cartObject}