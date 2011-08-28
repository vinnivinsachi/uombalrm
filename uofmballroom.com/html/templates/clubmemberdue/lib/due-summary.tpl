


	<tr class="row">
		<td {if $post->payment_status=='unpaid'}class="draft"{else}class="live"{/if}>
			
				{$post->profile->name}
		
		</td>
		
		<td>
			{$post->profile->price}
		</td>
		<td>
			{$post->profile->content}
		</td>
		<td>
			{$post->payment_status}
		</td>
		
		<td>
			{if $post->payment_status=="paid"}
			
			<input type="button" value="paid" disabled="disabled" />
			{else}
			<a href="{geturl username=$user->username producttype='individualDue'  action ='addproduct' route='shoppingcart'}/?productID={$post->getId()}&cartID={$cartID}" class="addToCart">pay your due</a>
			{/if}
		</td>
			
	</tr>
