<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$title|escape}</title>

<meta name="description" content="VEdancewear" />
<meta name="keywords" content="dance, students, shoes, pants, dancewear, colleges, competitions" />

<meta name="verify-v1" content="IaRLc3A9ud3KYnHM2fXY2mX5mM9EY03Ge3O64xr2Pbg=" /> 

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="/htdocs/css/style3.css" type="text/css" media="all"/>
<link rel="stylesheet" href="/htdocs/css/class3.css" type="text/css" media="screen" />


{if $java}
<!--put prototype here-->
{/if}
<script type="text/javascript" src="/htdocs/javascripts/prototype.js"></script>
<script type="text/javascript" src="/htdocs/javascripts/scriptaculous.js"></script>
<script type="text/javascript" src="/htdocs/js_plugin/SearchSuggestor.class.js"></script>




{if $lightbox}
<script type="text/javascript" src="/htdocs/javascripts/lightbox.js"></script>
<link rel="stylesheet" href="/htdocs/css/lightbox.css" type="text/css" />
{/if}



<script type="text/javascript" src="/htdocs/global.js"></script>

 
</head> 

<body>
	{if $tooltip}
<script type="text/javascript" src="/htdocs/js_plugin/wz_tooltip.js"></script>
{/if}
		
		<div id="header">
			<div id="header-top">
		
				<div id="header-left">
					<!--<div id="headerTitle">
					<a href="{geturl controller='index'}" style="color:white; text-decoration:none">VEdancewear</a>
				
					</div>-->
					<!--<div id="headerPhrase">Collegiate Dancewear Provider</div>-->
				</div>
			
				<div id="header-right">
					<div id="search">
					Search VE: dancewear provider
					<form method="get" action="{geturl controller='search'}">
					<div>
						<input type="text" name="q" value="{$q|escape}" id="search-query" autocomplete="off"/>
						<input type="submit" value="search" />
					</div>
					</form>
					</div>
		
				</div>
			
			</div>
			
			<div id="header-bottom">
				<div id="nav">
					<ul>
						
						<li {if $section=='home'}class="active"{/if}><a href="{geturl controller='index'}">Home</a> </li>
						
						<li {if $section=='product'}class="active"{/if}><a href="{geturl controller='clubproduct'}">Product</a> </li>
						
						<li {if $section=='event'}class="active"{/if}><a href="{geturl controller='clubevent'}">Promotion</a> </li>
						
						{if !$authenticated}
						<li {if $section=='register'}class="active"{/if}><a href="{geturl controller='account' action='registermember'}">Register</a> </li>
												<li style="float:right">
							<div align="center">

<a href="http://www.google.com/talk/service/badge/Start?tk=z01q6amlq457qtuamgok3dk6quqjrgms8i9ep8md5abc9mnk3e293aonofgvkl438ebnf0u8tpld4hbmot430cnebfhvrbbk3f93h8d2se90qvde3pgl5p7dr561o9aaj3eslfppkun16emsm1nesodnnfa4ivcuutma3h2ps" target="_blank" title="Click here to chat with VEdancewear">VEdancewear</a>
<img style="float:right; border: medium none ; margin: 0pt; padding: 10pt 2px 0pt 0pt;" src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlq457qtuamgok3dk6quqjrgms8i9ep8md5abc9mnk3e293aonofgvkl438ebnf0u8tpld4hbmot430cnebfhvrbbk3f93h8d2se90qvde3pgl5p7dr561o9aaj3eslfppkun16emsm1nesodnnfa4ivcuutma3h2ps&amp;w=9&amp;h=9" alt="" width="9" height="9">
<img style="float:right;border: medium none ; margin: 0pt; padding: 10pt 2px 0pt 0pt;" src="http://www.google.com/talk/service/resources/chaticon.gif" alt="" width="16" height="14">


</div></li>
						{/if}
						
						{if $signInAsGuest=='true'}
						<li ><a href="{geturl controller='index' action='guestsignout'}">Sign out guest {$guest->first_name}, {$guest->last_name}</a></strong>
						{/if}
						
						
					
						{if $authenticated && $identity->user_type=='clubAdmin'}
						<li {if $section=='account'}class="active"{/if}><a href="{geturl controller='account' action='details'}">Acct M</a></li>
						<li {if $section=='productM'}class="active"{/if}><a href="{geturl controller='productmanager'}">Prod M</a> </li>
						<li {if $section=='eventmanager'}class="active"{/if}><a href="{geturl controller='eventmanager'}">Promo M</a> </li>
						
						<li {if $section=='order'}class="active"{/if}><a href="{geturl controller='ordermanager'}">Order M</a> </li>
						<li {if $section=='inv'} class="active"{/if}><a href="{geturl controller='inventory'}">Inv M</a></li>
						<li {if $section=='message'}class="active"{/if}><a href="{geturl controller='Message'}">Messages</a></li>
						
						{elseif $authenticated && $identity->user_type=='member'}
						
						
						<li {if $section=='account'}class="active"{/if}><a href="{geturl controller='account' action='details'}">Account</a></li>
						<!--<li {if $section=='home'}class="active"{/if}><a href="#">Cart</a></li>-->
						<li {if $section=='order'}class="active"{/if}><a href="{geturl controller='ordermanager'}">Order history</a></li>
						<li {if $section=='message'}class="active"{/if}><a href="{geturl controller='message'}">Messages</a></li>
												<li style="float:right">
							<div align="center">

<a href="http://www.google.com/talk/service/badge/Start?tk=z01q6amlq457qtuamgok3dk6quqjrgms8i9ep8md5abc9mnk3e293aonofgvkl438ebnf0u8tpld4hbmot430cnebfhvrbbk3f93h8d2se90qvde3pgl5p7dr561o9aaj3eslfppkun16emsm1nesodnnfa4ivcuutma3h2ps" target="_blank" title="Click here to chat with VEdancewear">VEdancewear</a>
<img style="float:right; border: medium none ; margin: 0pt; padding: 10pt 2px 0pt 0pt;" src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlq457qtuamgok3dk6quqjrgms8i9ep8md5abc9mnk3e293aonofgvkl438ebnf0u8tpld4hbmot430cnebfhvrbbk3f93h8d2se90qvde3pgl5p7dr561o9aaj3eslfppkun16emsm1nesodnnfa4ivcuutma3h2ps&amp;w=9&amp;h=9" alt="" width="9" height="9">
<img style="float:right;border: medium none ; margin: 0pt; padding: 10pt 2px 0pt 0pt;" src="http://www.google.com/talk/service/resources/chaticon.gif" alt="" width="16" height="14">


</div></li>
						{/if}
					
						{if $authenticated}
					
							<li style="float:right"><a href="{geturl action='logout' controller='account'}">Log out</a></li>
						{/if}
						

					</ul>
				</div>
			</div>
	</div>
		<div id="content-container" class="column">
			<div id="breadcrumbs">
				{breadcrumbs trail=$breadcrumbs->getTrail()}
			</div>
			
		{if $toplink}
			{include file="alphabet.tpl" }
		{/if}
		
		{if $toplink2}
			{include file="alphabet2.tpl"}
		{/if}
		
			<!--<h1 id="clubName"> {$user->profile->public_club_name}</h1>-->
			