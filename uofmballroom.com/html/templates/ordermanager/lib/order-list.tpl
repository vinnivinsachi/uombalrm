<tr class="row">

	<td >
		{if $orderType =='seller'}
			{$order->buyer->first_name} {$order->buyer->last_name}
		{else}
			Uofmballroom
		{/if}
	</td>

	<td>
			{$order->ts_created|date_format:'%b %e,%Y %l:%M %p'} 
	</td>
	
	<td>
			${$order->total_after_p}
			
	</td>
	<td>
		<form method="post" action="{geturl action='view' controller='ordermanager'}"><input type="hidden" name="ID" value="{$order->url}" /><input type="hidden" name="orderType" value="{$orderType}" /> <input type="submit" value="Details" /></form>
	</td>
	<td>
		<form action="#"> <input type="submit" value="Send Feedback" /></form>
	</td>
	
	<td>
		{if $orderType =='seller'}
			{if $order->status=='pending'}
				<form> <input type="submit" value="Need to Verify" disabled="disabled" /></form>
			{elseif $order->status =='complete'}
				<form> <input type="button" value="Completed" disabled="disabled"/></form>
			{/if}
		{else}
			{if $order->status=='pending'}
				<form> <input type="button" value="Pending" disabled="disabled" /></form>
			{elseif $order->status=='complete'}
				<form> <input type="button" value="Completed" disabled="disabled" /></form>
			{/if}
		
		{/if}
		
	</td>
</tr>