{include file='header.tpl' lightbox=true}

<div id="rightContainer" style="float:left; width:180px;">

<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='info'}">MichComp Home</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='difference'}">Michigan Difference</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='registration'}">Competitor Registration</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='tickets'}">Spectator Tickets</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='venue'}">Venue</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='housing'}">Housing</a></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='sponsorship'}">Our Sponsors</a><br /></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='officialjudges'}">Judges</a><br /></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='directions'}">Directions</a><br /></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='fees'}">Fees</a><br /></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='rules'}">Rules</a><br /></div>
<div class="compLink">
<a href="{geturl route='umichcompetition' year='2010' info='theboard'}">The Board</a><br /></div>
<div class="compLink">
<a href="{geturl controller='index' action='index'}">Team Home Page</a><br /></div>
</div>

<div id="leftContainer" style="float:right;">
{include file="umichcompetition/$year/$info.tpl"}

</div>



{include file='footer.tpl'}