{include file='header.tpl' tooltip='true'}

<div id="leftContainer">

	<fieldset>
		<legend>View Shopping Cart</legend>
		<h2 style="text-align:center;">Organization: {$club->profile->public_club_name}</h2>
		
		<table class="shoppingcart">
			<tr class="title">
				<td>Name:</td>
				
				
				<td>Quantity:</td>
				<td>Total: </td>
				<td>Action:</td>
			</tr>
			
			<!--
			---product profile is available for display on each product by using java
			---on mouse over tool tip is available
			-->
		
				{foreach from=$productsProfile item=profile}
					
					{include file='shoppingcart/lib/cart-details.tpl'}
		
				{/foreach}

			
			<tr class="total">
				<td colspan="3">Total:</td>
		
				<td>$ {$total}</td>
			</tr>
			
			
			
			
		</table>

		<br/>
		<a href="{geturl username=$club->username route='clubproduct'}" class="buttonLeft">Buy our Apparel</a>
		<a href="{geturl controller='account' action='guest'}" class="buttonRight2">Become a member now!</a>
		<a href="{geturl controller='shoppingcart' action='emptycart'}/?cartID={$cartID}" class="buttonRight2">Empty Cart</a>
		

	</fieldset>


</div>

<div id="rightContainer">
{include file="shoppingcart/lib/left-column.tpl"}
</div>

{include file='footer.tpl'  leftcolumn='lib/ProductList.tpl' products=$cartObject}