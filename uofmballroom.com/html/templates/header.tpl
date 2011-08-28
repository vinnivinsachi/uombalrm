<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="UMBDT, university of michigan ballroom team, Ballroom, University of Michigan, Team, Collegiate, Sport, Dance lesson, uofm ballroom competition, university of michigan ballroom dancesport competition, michigan competition, michigan roseball, uofmballroom, univeristy of michigan ballroom competition, ballroom competition, competition ballroom, dancesport michigan competition, michigan charity ball" />


<title>University of Michigan Ballroom Dance Team -- {if $thirdTierTag}{$thirdThierTag}{else}{$SecondTier}{/if}</title> 

<link rel="stylesheet" type="text/css" href="/htdocs/css/style2.css">

<link rel="stylesheet" type="text/css" href="/htdocs/css/class2.css">
<link rel='stylesheet' type='text/css' href='/htdocs/css/quickmenu_styles.css'/>
<link rel="stylesheet" href="/htdocs/css/lightwindow.css" type="text/css" media="screen" />

<script type='text/javascript' src='/htdocs/javascripts/quickmenu.js'></script>
<script type='text/javascript' src='/htdocs/javascripts/prototype.js'></script>
<script type="text/javascript" src="/htdocs/javascripts/scriptaculous.js"></script>
<script type="text/javascript" src="/htdocs/javascripts/lightwindow.js"></script>


<script type="text/javascript" src="/htdocs/js_plugin/fckeditor/fckeditor.js"></script>
<Script type="text/javascript" src="/htdocs/js_plugin/fckeditorHelper.js"></script>
<script type="text/javascript" src="/htdocs/global.js"></script>

<script type="text/javascript" src="/htdocs/js_plugin/bannerSlide.js"></script>

<link rel="stylesheet" type="text/css" href="/htdocs/css/album.css">

<script type="text/javascript" src="/htdocs/js_plugin/lightwindowHelper.js"></script>



</head>

<body>

{if $SecondTier == 'Home'  && $Banner == 'true'} 
	<div id="header">

		<a href="/index">	<img src="/data/images/HeaderBanner3.png" /></a>

	</div>
{/if}
<!--	<div id="bannerTop">
	</div>
	
		-->


<div id="nav">

<ul id="qm0" class="qmmc">

	<li><a class="qmparent" href="{geturl action='index' controller='index'}"><img  class="qm-is qm-ih qm-ia" src="http://www.uofmballroom.com/data/images/homeButton.png" width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=News&tags=Home">News</a></li>
		<li><a href="{geturl controller='index' action='calendar'}">Calendar</a></li>
		<li><a href="http://www.uofmballroom.com/wordpress/">Team Blog</a></li>

		</ul></li>
		
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=New Members"> <img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'New Members'}src="http://www.uofmballroom.com/data/images/NewMemberButton_active.png"{else}src="http://www.uofmballroom.com/data/images/NewMemberButton.png"{/if}width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Practice Information">Practice Information</a></li>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Events">Events</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Dances">Dances</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Competitions">Competitions</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Team Structure">Team Structure</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=FAQ">FAQ</a></li>
        		<li><a href="{geturl controller='registration' action='index'}">Become a Member Now!</a></li>
		</ul></li>

	<li><a class="qmparent" href="{geturl action='competition' username='uofmballroom' route='clubpost'}"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Competition'}src="http://www.uofmballroom.com/data/images/CompetitionButton_active.png" {else}src="http://www.uofmballroom.com/data/images/CompetitionButton.png"{/if}width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=MichComp Home"><strong>Michigan Competition &nbsp;&nbsp;&nbsp;&gt;</strong></a>
        	<ul>
            	<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=MichComp Home">MichComp Home</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Michigan Difference">Michigan Difference</a></li>
                <li><a href="http://www.dance.zsconcepts.com/competition/registration-main.cgi?comp_id=136">Competitor Registration</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Spectator Tickets">Spectator Tickets</a></li>
                 <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Workshops Registration">Workshops Registration</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Shout Out">Shout - Out </a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Venue">Venue</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Housing">Housing</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Our Sponsors">Our Sponsors</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Judges">Judges</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Directions">Directions</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Fees">Fees</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=Rules">Rules</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Umichcompetition&tags=The Board">The Board</a></li>
                <li><a href="{geturl controller='index' action='index'}">Team Home Page</a></li>
            </ul></li>
		<li><a href="{geturl route='clubevent' action='index'}?cat=Away Competition">Away Competitions</a></li>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Competition&tags=Competition Media">Competition Media</a></li>

		<li><a href="{geturl controller='competition' action='results'}">Competition Results</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Competition&tags=Competition FAQ">Competition FAQ</a></li>

		
		</ul>
		
		
		
<!--		<ul>
		<li><a href="javascript:void(0)">Michigan Competition</a></li>
		

		<li><span class="qmdivider qmdividerx" ></span></li>
		<li><a href="javascript:void(0)">Purdue</a></li>
		<li><a href="javascript:void(0);">OSB</a></li>
		<li><a href="javascript:void(0);">NorthWestern</a></li>
		<li><a href="javascript:void(0);">Arnold Dancesport</a></li>
		
		<li><span class="qmdivider qmdividerx" ></span></li>
		<li><a class="qmparent" href="javascript:void(0)">Results by Year</a>

			<ul>
			<li><a href="javascript:void(0)">2009</a></li>
			<li><a href="javascript:void(0)">2010</a></li>
			<li><a href="javascript:void(0)">2011</a></li>
			<li><a href="javascript:void(0)">2012</a></li>
			</ul></li>
		
		</ul>
		-->
	</li>

	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Media"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Media'}src="http://www.uofmballroom.com/data/images/MediaButton_active.png"{else}src="http://www.uofmballroom.com/data/images/MediaButton.png"{/if} width="108" height="40"></a>

		<ul>
        		<li><a href="{geturl controller='media' action='video'}">Videos</a></li>

		<li><a href="{geturl controller='media' action='albums'}">Photographs</a></li>
		
		<!--<li><span class="qmdivider qmdividerx" ></span></li>
		<li><a href="javascript:void(0);">Media by dancer</a></li>
		</ul></li>-->

		</ul>
        </li> 

	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Fundraising"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Fundraising'} src="http://www.uofmballroom.com/data/images/Fundraising_active.png"{else}src="http://www.uofmballroom.com/data/images/Fundraising.png"{/if} width="108" height="40"></a>

		<ul>
		<li><a href="{geturl username='uofmballroom' route='clubproduct'}?category=Fundraising&tags=Team Apparel">Team Apparel</a></li>
        <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Fundraising&tags=Advertise With Us">Advertise With Us</a></li>
        <li><a href="{geturl action='donate' controller='fundraising'}">Donate To The Team</a></li>
		</ul></li>
	
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Community Outreach"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Community Out Reach'} src="http://www.uofmballroom.com/data/images/CommunityOutReach_active.png"{else}src="http://www.uofmballroom.com/data/images/CommunityOutReach.png"{/if} width="108" height="40"></a>

		<ul>
       	 <li><a class="qmparent" href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=CharityBall2010"><strong>Charity Ball 2010&nbsp;&nbsp;&nbsp;&gt;</strong></a>
         	<ul>
            	<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Why Make-A-Wish">Why Make-A-Wish</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Ticket Info">Ticket Info</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Program of Events">Program of Events</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Our Sponsors">Our Sponsors</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Make a Donation">Make a Donation</a></li>
                <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=CharityBall2010&tags=Sponsorship Opportunities">Sponsorship Opportunities</a></li>
            </ul>
         </li>
        <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Community Outreach&tags=Showcases/performances">Showcases/performances</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Community Outreach&tags=Workshops">Workshops</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Community Outreach&tags=High Schools">High Schools</a></li>
		

		</ul></li>
	
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Scholarships"><img  class="qm-is qm-ih qm-ia"{if $SecondTier == 'Scholarships'}  src="http://www.uofmballroom.com/data/images/ScholarshipsButton_active.png"{else} src="http://www.uofmballroom.com/data/images/ScholarshipsButton.png"{/if} width="108" height="40"></a>

		<ul>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Scholarships&tags=Potential Team Scholarships">Team Scholarships</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Scholarships&tags=Team/Competition Subsidies">Competition Scholarships</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Scholarships&tags=Club Scholarships">Club Scholarships</a></li>
		

		</ul></li>
		
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=About Us"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'About Us'} src="http://www.uofmballroom.com/data/images/AboutUsButton_active.png"{else} src="http://www.uofmballroom.com/data/images/AboutUsButton.png"{/if} width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=About Us&tags=Board Members">Board Members</a></li>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=About Us&tags=Affiliates">Affiliates</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=About Us&tags=Constitution">Constitution</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=About Us&tags=Contact Us">Contact Us</a></li> 
		
		</ul></li> 

<li class="qmclear">&nbsp;</li></ul>

<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click ('all', 'main' or 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
<script type="text/javascript">qm_create(0,false,1,500,false,false,false,false,false);</script>
</div>

 			{if $authenticated==1}
			
			<div id="managementLink">
			<a href="{geturl controller='account' action='details'}">Account info</a> | 
			<a href="{geturl controller='blogmanager'}">Post Manager</a> |
			<a href="{geturl controller='productmanager'}">Product Manager</a> |
			<a href="{geturl controller='eventmanager'}">Registration manager</a> |
            <a href="{geturl controller='onlineregistrations'}">Online registrations |
			<a href="{geturl controller='mediamanager'}">Media manager</a> |
            <a href="{geturl controller='index' action='help'}">Help Manager</a> |
			<a href="{geturl controller='account' action='logout'}">Log out</a>			
			</div> 
			{/if}

{if $thirdTierTag}
{get_post_element user_id=1 object="post" tag=$thirdTierTag category="Banner" liveOnly="true" assign=Banner }

			{include file="clubpost/lib/banner.tpl"} 

{elseif $Banner=='true'}
{get_post_element user_id=1 object="post" tag=$SecondTier category="Banner" liveOnly="true" assign=Banner }

			{include file="clubpost/lib/banner.tpl"}
			
{/if}  
			

	<div id="content">
		
		<div id="wrapper"> 
		
		
			
	