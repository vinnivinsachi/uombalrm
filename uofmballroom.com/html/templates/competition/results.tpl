{include file='header.tpl' lightbox=true}

<br />
<br />
<br />
<strong style="font-size:14px;">Please select a competition</strong><br />
<br />


<form method="get" action="/competition/results">
	<select name="competition">
    	<option value="ncc">USA Dance National Collegiate Dancesport Challenge</option>
        <option value="pbc">Purdue Ballroom Classic</option>
        <option value="chi">Chicago Dancesport Challenge</option>
        <option value="usa">USA Dance National DanceSport Championships</option>
   	</select>
    <select name="year">
       	<option value="12">2012</option>
    	<option value="11">2011</option>
    	<option value="10">2010</option>
    	<option value="09">2009</option>
        <option value="08">2008</option>
        <option value="07">2007</option>
   	</select>
    
    <input type="submit" name="submit" value="Find Results" />	
</form>

{if $error!=''}
{$error}
{/if}
{if $comp!=''}
<iframe src="http://www.o2cm.com/Results/event3.asp?event={$comp}" width="700px;" height="900px" style="border:none;">
</iframe>
{/if}

{include file='footer.tpl'}