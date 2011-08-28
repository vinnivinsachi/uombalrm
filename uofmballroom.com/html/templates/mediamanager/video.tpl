{include file='header.tpl' lightbox=true}


{if $needToLogin=='true'}
	Please login to your YOUTUBE account <a style="font-size:18px;" href="https://www.google.com/accounts/AuthSubRequest?next=http%3A%2F%2Fwww.visachidesign.com%2Fmediamanager%2Fvideo&scope=http://gdata.youtube.com&secure=&session=1">here</a>!<br/>
    
    If you do not plan to upload your videos throug our website<br/> 
    You may use the following tags to make your videos can be accessible through our website. <br/>
    
    Your tags MUST BE IDENTICAL to the ones described below. Tag as many as appropriate <br/>
    
    <br/><br />

    
    <table>

	<tr>

   	 
    	<td>
        	Year
        </td>
        <td>
        	Event
        </td>
        <td>
        	Location
        </td>
        <td>
        	Level
        </td>
        <td>
        	Style
        </td>
    </tr>
    
    <tr>
        <td>
        	2010<br />
        	2009<br/>
            2008<br/>
            2007<br/>
            2006<br />
		</td>

        <td>
        	competition<br />
			showcase<br />
			socialevent<br />
			tryouts
        </td>


        <td>
       	 	purdue<br />
            osb<br/>
            arnold<br />
            michigan<br />
            northwestern<br />
            notredame<br />
        </td>

        <td>
            newcomer<br />
            bronze<br />
            silver<br />
            gold<br />
            novice<br />
            prechamp<br />
            champ<br />

        </td>

        <td>
            amfoxtrot<br />
            amtango<br />
            vietwaltz<br />
            amrumba<br />
            amchacha<br />
            swing<br />
            intwaltz<br />
            inttango<br />
            quickstep<br />
            intrumba<br />
            intchacha<br />
            jive<br />
            paso<br />
        
        </td>
    </tr>
</table>


{else}


	{if $error|@count >0}
Here is a reference to all the available tags. 

<table>

	<tr>

   	 
    	<td>
        	Year
        </td>
        <td>
        	2010<br />
        	2009<br/>
            2008<br/>
            2007<br/>
            2006<br />

    	<td>
        	Events
        </td>
        <td>
        	competition<br />
			showcase<br />
			socialevent<br />
			tryouts
        </td>

    	<td>
        	location
        </td>
        <td>
       		purdue<br />
			osb<br/>
			arnold<br />
			michigan<br />
			northwestern<br />
			notredame<br />

        </td>

    	<td>
        	level
        </td>
        <td>
        newcomer<br />
        bronze<br />
        silver<br />
        gold<br />
        novice<br />
        prechamp<br />
        champ<br />

        </td>

    	<td>
        	style
        </td>
        <td>
        amfoxtrot<br />
        amtango<br />
        vietwaltz<br />
        amrumba<br />
        amchacha<br />
        swing<br />
        intwaltz<br />
        inttango<br />
        quickstep<br />
        intrumba<br />
        intchacha<br />
        jive<br />
        paso<br />
        
        </td>
    </tr>
</table>


<form action="{geturl controller='mediamanager' action='video'}" method="get">
	Title: <input type="text" name="videoTitle" value="{$videoTitle}"/><br />
    {if $error.videoTitle!=''}<div class='errorMessage'>{$error.videoTitle}</div>{/if}
    Description: <textarea cols="20" rows="3" name="videoDescription" value="{$videoDescription}"></textarea><br/>
    
    {if $error.videoDescription!=''}<div class='errorMessage'>{$error.videoDescription}</div>{/if}
	Year:
	<select id='year' name="year">
    	<option value="">Not applicable</option>
        <option value="2009" {if $year=='2009'}selected="selected"{/if}>2009</option>
        <option value="2008" {if $year=='2008'}selected="selected"{/if}>2008</option>
        <option value="2007" {if $year=='2007'}selected="selected"{/if}>2007</option>
    </select>
    Event
    <select id="event" name="event">
    	<option value="">Not applicable</option>
        <option value="competition" {if $event=='competition'}selected="selected"{/if}>Competition</option>
        <option value="showcase" {if $event=='showcase'}selected="selected"{/if}>Showcase</option>
        <option value="socialevent" {if $event=='socialevent'}selected="selected"{/if}>Social event</option>
        <option value="tryouts" {if $event=='tryouts'}selected="selected"{/if}>Tryouts</option>
	</select>
    
    Location:
    <select id="location" name="location">
    	
        <option value="">Not applicable</option>
        <option value="purdue" {if $location=='purdue'}selected="selected"{/if}>Purdue</option>
        <option value="osb" {if $location=='osb'}selected="selected"{/if}>OSB</option>
        <option value="arnold" {if $location=='arnold'}selected="selected"{/if}>Arnold</option>
        <option value="michigan" {if $location=='michigan'}selected="selected"{/if}>Michigan</option>
        <option value="northwestern" {if $location=='northwestern'}selected="selected"{/if}>Northwestern</option>
        <option value="notredame" {if $location=='notredame'}selected="selected"{/if}>Notre Dame</option>
    </select>
    
    Level:
    
	<select id="level" name="level">
    	<option value="">Not applicable</option>
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
    
    	<option value="">Not applicable</option>
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
        <option value="jive" {if $style=='jive'}selected="selected"{/if}>Jive</option>
        <option value="paso" {if $style=='paso'}selected="selected"{/if}>Paso doble</option>
    </select>
    <br />
    
    <input type="submit" value="Next" />Make sure that all your information is correct before you proceed
</form>
{else}

Thank you for your information, 
please upload your videos:




<form name='videoSubmitForm' action="{$postUrl}?nexturl={$nextUrl}" method="post" enctype="multipart/form-data">
					<input name="file" type="file"/>
					<input name="token" type="hidden" value="{$tokenValue}"/>
					<input id='videoSubmitForm' value="Upload Video File" type="button" />
</form>


<div id="albumBackdrop" class="hidden">
	<div id="albumBackdropLoading">Video is Uploading... please be patient. <br/>You will be redirected after it is finished. Thank you! :0)<br/><br />
    Video uploaded will take about 5-10 mins for youtube to process. <br/>
    During this time your movie will temporarily be unable for display on our website.<br/>
    If you have any problems uploading videos please contact our Tech Chair at vinnivinsachi@gmail.com. <br/>
</div>
</div>

{/if}


{/if}

{include file='footer.tpl'}