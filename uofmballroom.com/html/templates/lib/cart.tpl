{if $products|@count>0}
	<div class="box">
		<h3>Cart Summary</h3>
		<table class="shoppingcart">
			<tr class="title">
				<td>Name:</td>
				<td>Price:</td>
				<td>Quantity:</td>
			</tr>

				{foreach from=$products item=product}
				<tr class="row">
					<td>
					
					{$product->product_name}</td>
					
					<td>{$product->unit_cost}</td>
					<td>{$product->quantity}</td>
					
				</tr>
				{/foreach}
			
			
			<tr class="total">
				<td colspan="2">Total:</td>
		
				<td>${$total}</td>
			</tr>
			
		</table>
	
		<br/>
		<a href="{geturl controller='checkout'}" class="cartButtonRight">Check Out</a>
		<a href="{geturl controller='shoppingcart' action='index'}" class="cartButtonRight">Review Cart</a>
		
	</div>
{/if}