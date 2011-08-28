{if $dues|@count>0}
{include file='header.tpl'}
{include file='navprofile.tpl' section='individualDue'}

<h1>viewing your dues from {$user->profile->public_club_name} </h1>

	<table class="shoppingcart">
		<tr class="title">
			<td>Name of due</td>
			<td>Due amount</td>
			<td>Due Details</td>
			<td>Payment Status</td>
			<td>Action</td>
		</tr>
				
			
		{foreach from=$dues item=due name=due}
		
			{include file='clubmemberdue/lib/due-summary.tpl' post=$due}
		
		{/foreach}
	</table>
{else}
	{include file='header.tpl' section='membershipmanager'}
	{include file='navprofile.tpl' section='individualDue'}

		You currently do not have any dues from this club. 
{/if}
	


{include file='footer.tpl' leftcolumn='clubmemberdue/lib/left-column.tpl' products=$cartObject}