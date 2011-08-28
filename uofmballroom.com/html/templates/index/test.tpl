<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="UMBDT, university of michigan ballroom team, Ballroom, University of Michigan, Team, Collegiate, Sport, Dance lesson" />


<title>University of Michigan Ballroom Dance Team -- {if $thirdTierTag}{$thirdThierTag}{else}{$SecondTier}{/if}</title> 

<link rel="stylesheet" type="text/css" href="/htdocs/css/indexClass.css">


</head>
<body>


<div id="headerImg">
	<div id="firstLable">
	<span id="university"><span style="color:#003366;">U</span>niversity of <span style="color:#003366;">M</span>ichgian</span>
    <span id="team"><span style="color:yellow;">B</span>allroom <span style="color:yellow;">D</span>ance <span style="color:yellow;">T</span>eam</span>
   	</div>
    <div id="secondLable">
    <span id="announcements"><span style="font-size:20pt;">A</span>nnouncements</span>
    <span id="eventsTitle">EVENTS</span>
    </div>
</div>

<div id="contentImg">





	<div id="contentAnnouncements">
    {get_post_element user_id=1 object="post" category="IndexWelcomeAnnouncement" tag='Index' assign=welcomeAnnon liveOnly="true" limit=1}
    
			{if $welcomeAnnon|@count >0}
			{assign var=announcement value=$welcomeAnnon|@current}
    		{$announcement->getTeaser(400)}
            {/if}
    </div>




	{get_post_element user_id=1 object="post" category="IndexWelcomeEvent" tag='Index' assign=welcomeEvent liveOnly="true" limit=1}
    
    

	{counter start=0 print=0}
	<div id="contentEvents">
		{foreach from=$welcomeEvent item=post name=Posts key=Key}
			{counter assign=counterValue}
		
			{include file='clubpost/lib/welcomeEvents.tpl' post=$post key=Key counter=$counterValue}


		{/foreach}
		
    </div>

<div id="enter">
    <a href="{geturl controller='index' action='index'}">ENTER</a>
    </div>
</div>

<div id="footerImg">
 
 	<ul><li><a href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=New Members">New Commers</a></li>
    <li><a href="{geturl action='competition' username='uofmballroom' route='clubpost'}">Competition</a></li>
    <li><a href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Scholarships">Scholarships</a></li>
    <li><a href="{geturl action='contact' controller='about'}">Contact Us</a></li>
    </ul>
         
    
</div>



</body>
</html>