<tr class="row">
	<td>
		
		<div style="font-size: 1.2em; color:#0099CC">{if $profile->orderAttribute->inv_id ==''}{$profile->product_name}{else}{$profile->product_name}(inventory){/if}
		</div>
		
{if $profile->orderAttribute->size != ''}
		
			Size: {$profile->orderAttribute->size}
		
		{/if}
		<br/>
	</td>
	
	<td>
		{$profile->product_type}
			
	</td>
	<td>
		{$profile->quantity}
	
	</td>
	<td>
		{$profile->unit_cost}
		
	</td>


	{if $orderType=='seller'}
	<td>
		<form method="get" action="{geturl action='productstat' controller='ordermanager'}"><input type="hidden" name="ID" value="{$profile->product_id}" /><input type="hidden" name="type" value="{$profile->product_type}" /><input type="hidden" name="name" value="{$profile->product_name}" /><input type="submit" value="View Product Statistics" />
		</form>
	</td>
	{/if}
	
</tr>


	