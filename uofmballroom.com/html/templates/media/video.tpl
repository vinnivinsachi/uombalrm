{include file='header.tpl' lightbox=true}

You may search for any videos here in this section. 
<form id='videoQueryForm' name='videoQueryForm' action="{geturl controller='media' action='video'}" method="get">
		 <span class="uploaderName">Currently Video Account: {$uploader}</span><br/>
	Uploaders:
    <select id="uploader" name="uploader">
    	<option value="">UMBDT</option>
        <option value="TheUMBDT">testing</option>
        <option value="DancingDusenberry" {if $uploader=='DancingDusenberry'}selected="selected"{/if}>DancingDusenberry</option>
        <!--<option value="RachelC813" {if $uploader=='RachelC813'}selected="selected"{/if}>RachelC813</option>    -->
    </select>
   <br/>
	Year:
	<select id='year' name="year">
    	<option value="">All</option>
        <option value="2009" {if $year=='2009'}selected="selected"{/if}>2009</option>
        <option value="2008" {if $year=='2008'}selected="selected"{/if}>2008</option>
        <option value="2007" {if $year=='2007'}selected="selected"{/if}>2007</option>
    </select>
    Event
    <select id="event" name="event">
    	<option value="">All</option>
        <option value="competition" {if $event=='competition'}selected="selected"{/if}>Competition</option>
        <option value="showcase" {if $event=='showcase'}selected="selected"{/if}>Showcase</option>
        <option value="socialevent" {if $event=='socialevent'}selected="selected"{/if}>Social event</option>
        <option value="tryouts" {if $event=='tryouts'}selected="selected"{/if}>Tryouts</option>
	</select>
    
    Location:
    <select id="location" name="location">
    	
        <option value="">All</option>
        <option value="purdue" {if $location=='purdue'}selected="selected"{/if}>Purdue</option>
        <option value="osb" {if $location=='osb'}selected="selected"{/if}>OSB</option>
        <option value="arnold" {if $location=='arnold'}selected="selected"{/if}>Arnold</option>
        <option value="michigan" {if $location=='michigan'}selected="selected"{/if}>Michigan</option>
        <option value="northwestern" {if $location=='northwestern'}selected="selected"{/if}>Northwestern</option>
        <option value="notredame" {if $location=='notredame'}selected="selected"{/if}>Notre Dame</option>
    </select>
    
    Level:
    
	<select id="level" name="level">
    	<option value="">All</option>
        <option value="newcomer" {if $level=='newcomer'}selected="selected"{/if}>Newcomer</option>
        <option value="bronze" {if $level=='bronze'}selected="selected"{/if}>Bronze</option>
        <option value="silver" {if $level=='silver'}selected="selected"{/if}>Silver</option>
        <option value="gold" {if $level=='gold'}selected="selected"{/if}>Gold</option>
        <option value="novice" {if $level=='novice'}selected="selected"{/if}>Novice</option>
        <option value="prechamp" {if $level=='prechamp'}selected="selected"{/if}>Pre champ</option>
        <option value="champ" {if $level=='champ'}selected="selected"{/if}>Champ</option>
    </select>
    
    Style: 
    <select id="style" name="style">
    
    	<option value="">All</option>
        <option value="amwaltz" {if $style=='amwaltz'}selected="selected"{/if}>Am - Waltz</option>
        <option value="amfoxtrot" {if $style=='amfoxtrot'}selected="selected"{/if}>Am - Foxtrot</option>
        <option value="amtango" {if $style=='amtango'}selected="selected"{/if}>Am - Tango</option>
        <option value="vietwaltz" {if $style=='vietwaltz'}selected="selected"{/if}>Viet - waltz</option>
        <option value="amrumba" {if $style=='amrumba'}selected="selected"{/if}>Am-Rumba</option>
        <option value="amchacha" {if $style=='amchacha'}selected="selected"{/if}>Am-Cha-cha</option>
        <option value="swing" {if $style=='swing'}selected="selected"{/if}>Swing</option>
        <option value="intwaltz" {if $style=='intwaltz'}selected="selected"{/if}>Int-Waltz</option>
        <option value="intfoxtrot" {if $style=='intfoxtrot'}selected="selected"{/if}>Int-Foxtrot</option>
        <option value="inttango" {if $style=='inttango'}selected="selected"{/if}>Int-tango</option>
        <option value="quickstep" {if $style=='quickstep'}selected="selected"{/if}>Quickstep</option>
        <option value="intrumba" {if $style=='intrumba'}selected="selected"{/if}>Int-Rumba</option>
        <option value="intchacha"{if $style=='intchacha'}selected="selected"{/if}>Int-chacha</option>
        <option value="samba" {if $style=='samba'}selected="selected"{/if}>Samba</option>
        <option value="jive" {if $style=='jive'}selected="selected"{/if}>Jive</option>
        <option value="paso" {if $style=='paso'}selected="selected"{/if}>Paso doble</option>
    </select>
 
 	<input id="counter" name="counter" type="hidden" value="" />    
    <input type="submit" value="Search" />
</form>

<div id="paginationLink">
<input type="button" id="previousLink" value="previous" />
<input type="hidden" id="previousValue" value="{$previousLink}" />
<input type="hidden" id="nextValue" value="{$nextLink}"/>
<input type="button" id="nextLink" value="next"/>
 
</div>

<div id="videoAlbum">
{if $video|@count ==1}
	<div class="videoAlbumEntree">

    		<a class="lightwindow page-options" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false"href="{$video[0].FlashPlayerUrl}" title="{$video[0].title}"><img src="{$video[0].clipUrl}" /></a>
            <div class="videoAlbumDescription">
           	 	<a class="lightwindow page-options" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false"href="{$video[0].FlashPlayerUrl}" title="{$video[0].title}"><div class="videoTitle">{$video[0].title}</div></a>
                Description: {$video[0].Description}<br/>
                Views: {$video[0].Viewcount}<br/>
            </div>
        </div>
{else}
	{foreach from=$video item=clip name=clip}
    	<div class="videoAlbumEntree">

    		<a class="lightwindow page-options" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false"href="{$clip.FlashPlayerUrl}" title="{$clip.title}"><img src="{$clip.clipUrl}" /></a>
            <div class="videoAlbumDescription">
           	 	<a class="lightwindow page-options" params="lightwindow_width=480,lightwindow_height=385,lightwindow_loading_animation=false"href="{$clip.FlashPlayerUrl}" title="{$clip.title}"><div class="videoTitle">{$clip.title}</div></a>
                Description: {$clip.Description}<br/>
                Views: {$clip.Viewcount}<br/>
            </div>
        </div>
    {/foreach}
{/if}
</div>

<!--<a class="lightwindow page-options" title="YouTube: 300 Preview" params="lightwindow_width=425,lightwindow_height=340,lightwindow_loading_animation=false" href="http://www.youtube.com/v/uhi5x7V3WXE" rel="">
blahb labh </a>-->


{include file='footer.tpl'}