{include file='header.tpl' section='register'}

	
<fieldset>
	<legend>Please choose an account type</legend>

		<form method="post" action="{geturl action='register'}" style="text-align:center;">
		
			<input type="submit" name="registermember" value="General Member" class="submit">
			
			<input type="submit" name="registerclub" value="Club Manager" class="submit">
		</form>
</fieldset>





{include file='footer.tpl'  products=$cartObject}