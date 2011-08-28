{include file='header.tpl'}

<form method="post" action="{geturl action='index' controller='checkout'}" id="registration-form">
<div>
	<fieldset>
		<legend>PROMOTION CODE:</legend>
		<h2 style="text-align:center;">Organization: {$club->profile->public_club_name}</h2>
		
		<div class="row" id="form_promotion">
			<label for="form_promotion">Promotion Code:</label> 
				<input type="text" name="promotion" />
				<br/>
				<br/>
				<br/>
				
				<center>(if you are eligible for a promotion, you can find it under your account page)</center>
				
		</div>
		
		
		{if $error!=''}
		<div class="error">
			{$error}
		</div>
		{/if}
		
		<div class="submit">
			<input type="submit" value="Recalculate cart" />
			<a href="{geturl action='member'}" style="color:#006600">No promotion code</a>
		</div>
		

	</fieldset>
</div>
</form>

<br/>
<br/>
<br/>






{include file='footer.tpl' products=$cartObject leftcolumn='lib/ProductList.tpl'}