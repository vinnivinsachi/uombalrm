		
		{if $toplink}
		<br/>
			{include file="alphabet.tpl" }
		{/if}
		
	
	</div>
<div id="left-container" class="column">

	<div class="box" id="login">
		{if !$authenticated}
					<form method="post" action="{geturl action='login' controller='account'}">

					<table>
						<tr>
							<td>Username</td>
						</tr>
					
						<tr>
							<td>
								<input type='text' name="username" value="" />
							</td>
							
							
						</tr>
						
						<tr>
							<td>Password</td>
						</tr>
						
						<tr>
							<td>
								<input type="password" name="password" value="" AUTOCOMPLETE="off"/>
							</td>
						</tr>
						
						<tr>
							<td>
								<a href="{geturl controller="account" action="fetchpassword"}" >Forgot your password?</a>
							</td>
							<td>	
							<input type="submit" value="login" name="login" style="float:right;"/>
							</td>
						</tr>
						
					</table>
					</form>
					
				{else}
			<!--
					<div style="padding-left: 100px;">
					Logged in as
					<span class="textcolor2" style="font-weight:bold;">{$identity->first_name|escape},{$identity->last_name|escape}</span>
				
					<p class="textcolor2" style="font-size:9px">{$identity->profile->public_club_name}</p>
				
					{if $identity->status =='D'}
					<a href="{geturl controller='account' action='details'}" class="textcolor2" style="color:white">Send Live</a> | 
					{/if}
					<a href="{geturl controller='account' action='logout'}" class="textcolor2" style="color:white">Log out</a>
					</div>
				-->
				{/if}
				
	</div>


	
	
	{if isset($leftcolumn) && $leftcolumn|strlen>0}
		{include file=$leftcolumn}
	{/if}
	
	{include file='lib/cart.tpl' products=$products}
	
</div>

<div id="right-container" class="column">
	{if $messages|@count>0}
		<div id="messages" class="messageBox">
			{if $messages|@count==1}
				<strong>Status Message:</strong>
				{$messages.0|escape}
			{else}
				<strong>Status Messages:</strong>
				<ul>
					{foreach from=$messages item=row}
						<li>{$row|escape}</li>
					{/foreach}
				</ul>
			{/if}
		</div>
		
	{else}
		<div id="messages" class="box" style="display:none"></div>
	{/if}
	
	
	
	
	<div class="box">
		{if $authenticated}
			Account Settings:<br/>
			
			<a href="{geturl controller='account' action='details'}">Update Account Settings</a>.
		{else}
			You are not logged in.
			<a href="{geturl controller='account' action='login'}">Log in</a> or
			<a href="{geturl controller='account' action='registermember'}">Register</a> now.
		{/if}
		
	</div>

	
	{if $hint =='noPaypalEmail'}
	<div class="box" style="background:gray; color:white;">
		**hint**<br/>
		You must have a paypal account to set prices to sellable products.
	</div>
	{/if}
	
	<br/>
	<br/>
	
{get_tag_summary user_id=13 object="event" assign=summary}

{if $summary|@count>0}
<div class="category" style="margin-left:10px;">
		<h2 class="categoryh2">Promotions</h2>
		<ul>
			{foreach from=$summary item=tag}
			
			<li>
				<a href="{geturl route='clubeventtagspace' username='vedancewear' tag=$tag.tag}">
				{$tag.tag|escape}
				</a>
				
				({$tag.count}{if $tag.count != 1}{/if})
			</li>
			<br/>
			{/foreach}
		</ul>
</div>
{/if}


	<div style="float:right; margin-right:40px;">
	<script type="text/javascript"><!--
google_ad_client = "pub-6224044201548007";
/* 120x600, created 2/4/09 */
google_ad_slot = "8954323084";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>


		
	{if isset($rightcolumn) && $rightcolumn|strlen>0}
		{include file=$rightcolumn}
	{/if}
	
</div>

<div id="footer">
	&copy; JV Connections, 2008 |
	<a href="{geturl controller='index' action='terms'}">Terms</a> |
	<a href="{geturl controller='account' action='login'}">Admin</a> |
	<a href="{geturl controller='index' action='dancenatrual'}">Dance Natural</a>
</div>
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7286321-1");
pageTracker._trackPageview();
} catch(err) {}
</script>
{/literal}
</body>

</html>