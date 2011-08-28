{include file="header.tpl" section='inv' lightbox='true'}

	<table class="shoppingcart">
			<tr class="title">
			
				<td>CartKey:</td>
				<td>ProductName: </td>
				<td>TS_created:</td>
			</tr>
	{foreach from=$profiles item=profiles}
		<tr class="row">
			<td>
				{$profiles->cart_key}
			</td>
			<td>
				{$profiles->product_name}
			</td>
			<td>
				{$profiles->ts_created|date_format:"%A, %B %e, %Y ---- %H:%M:%S"}
			</td>
		</tr>
	{/foreach}
	</table>
	
	<br/>
	<br/>
	<br/>
	<br/>
	<a href="{geturl controller='inventory' action='clearcarts'}">Clear cart</a>
	

{include file='footer.tpl' }