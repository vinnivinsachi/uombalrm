<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="UMBDT, university of michigan ballroom team, Ballroom, University of Michigan, Team, Collegiate, Sport, Dance lesson" />


<title>University of Michigan Ballroom Dance Team -- {if $thirdTierTag}{$thirdThierTag}{else}{$SecondTier}{/if}</title> 

<link rel="stylesheet" type="text/css" href="/htdocs/jquery/jquery_lib/jqueryFileTree/jqueryFileTree.css">
<link rel="stylesheet" type="text/css" href="/htdocs/css/style2.css">

<link rel="stylesheet" type="text/css" href="/htdocs/css/class2.css">
<link rel='stylesheet' type='text/css' href='/htdocs/css/quickmenu_styles.css'/>
<script src="/htdocs/jquery/jquery.js" type="text/javascript"></script>
<script src="/htdocs/jquery/jquery_lib/jqueryFileTree/jqueryFileTree.js" type="text/javascript"></script>
<script type="text/javascript" src="/htdocs/jquery/jquery_lib/gallery/jquery.galleria.min.js"></script>
<script type="text/javascript" src="/htdocs/jquery/jquery_lib/gallery/jquery.scroll.js"></script>
{literal}
<style>
body {
    background:white;
    text-align:center;
    background:black;
    color:#bba;
    font:80%/140% georgia,serif;
}
</style>
{/literal}
</head>
<body>



<div id="nav">

<ul id="qm0" class="qmmc">

	<li><a class="qmparent" href="{geturl action='index' controller='index'}"><img  class="qm-is qm-ih qm-ia" src="http://www.uofmballroom.com/data/images/homeButton.png" width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=News&tags=Home">News</a></li>
		<li><a href="{geturl controller='index' action='calender'}">Calendar</a></li>
		
		</ul></li>
		
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=New Members"> <img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'New Members'}src="http://www.uofmballroom.com/data/images/NewMemberButton_active.png"{else}src="http://www.uofmballroom.com/data/images/NewMemberButton.png"{/if}width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Practice Information">Practice Information</a></li>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Events">Events</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Dances">Dances</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Competitions">Competitions</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=Team Structure">Team Structure</a></li>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=New Members&tags=FAQ">FAQ</a></li>
        		<li><a href="{geturl route='clubeventtagspace' tag='2009 Early Registration'}">Become a Member Now!</a></li>
		</ul></li>


	<li><a class="qmparent" href="{geturl action='competition' username='uofmballroom' route='clubpost'}"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Competition'}src="http://www.uofmballroom.com/data/images/CompetitionButton_active.png" {else}src="http://www.uofmballroom.com/data/images/CompetitionButton.png"{/if}width="108" height="40"></a>

		<ul>
		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Competition&tags=Michigan Competition">Michigan Competition</a></li>
		<li><a href="{geturl route='clubeventtagspace' tag='Purdue Comp 2009'}">Away Competitions</a></li>
        		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Competition&tags=Competition Media">Competition Media</a></li>

		<li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Competition&tags=Competition Results">Competition Results</a></li>
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

		<li><a href="{geturl controller='media' action='album'}">Photographs</a></li>
		
		<!--<li><span class="qmdivider qmdividerx" ></span></li>
		<li><a href="javascript:void(0);">Media by dancer</a></li>
		</ul></li>-->

		</ul>
        </li> 

	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Fundraising"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Fundraising'} src="http://www.uofmballroom.com/data/images/Fundraising_active.png"{else}src="http://www.uofmballroom.com/data/images/Fundraising.png"{/if} width="108" height="40"></a>

		<ul>
		<li><a href="{geturl username='uofmballroom' route='clubproduct'}?category=Fundraising&tags=Team Apparel">Team Apparel</a></li>
        <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Fundraising&tags=Advertise With Us">Advertise With Us</a></li>
        <li><a href="{geturl action='cat' username='uofmballroom' route='clubpost'}?category=Fundraising&tags=Donate To The Team">Donate To The Team</a></li>


		
		
		</ul></li>
	
	<li><a class="qmparent" href="{geturl action='secondtier' username='uofmballroom' route='clubpost'}?value=Community Outreach"><img  class="qm-is qm-ih qm-ia" {if $SecondTier == 'Community Out Reach'} src="http://www.uofmballroom.com/data/images/CommunityOutReach_active.png"{else}src="http://www.uofmballroom.com/data/images/CommunityOutReach.png"{/if} width="108" height="40"></a>

		<ul>
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
		<li><a href="{geturl action='contact' controller='about'}">Contact Us</a></li> 
		
		</ul></li> 

<li class="qmclear">&nbsp;</li></ul>

<!-- Create Menu Settings: (Menu ID, Is Vertical, Show Timer, Hide Timer, On Click ('all', 'main' or 'lev2'), Right to Left, Horizontal Subs, Flush Left, Flush Top) -->
<script type="text/javascript">qm_create(0,false,1,500,false,false,false,false,false);</script>
</div>
<div id="marginFiller" style="width:100%; float:left; height:20px;"></div>

<div id="container_id" style="width:300px; float:left; text-align:left; font-size:16px; padding-left:20px;">
</div>

{literal}
<script type="text/javascript">
$(document).ready( function() {    
			

			$('#container_id').fileTree({ root: '/data/media/'}, function(file){
																		  //alert(file);
																		  var secondFile= file.replace(/ /g,"%20");
																		  //alert(secondFile);
																		  $('#album_content').load('/media/albumgallery/?file='+secondFile);
																		   }); 
			}
		);
</script>
{/literal}

<div id="album_content" style="width:780px; float:left;">
</div>

</body>
</html>