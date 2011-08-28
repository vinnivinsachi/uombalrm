{get_tag_summary user_id=13 object="product_cat" assign=summary}

{if $summary|@count>0}
<div class="nav-round-corner-top">
<p class="nav-title">Brand</p>
</div>
<div class="category">
		<ul>
			{foreach from=$summary item=tag}
			<li>
				<a href="/clubproduct/vedancewear/cat/?cat={$tag.tag}">
				{$tag.tag|escape}
				</a>
			
			</li>
		
			{/foreach}
		</ul>
	</div>
	<div class="nav-round-corner-bottom">
</div>
{/if}

{get_tag_summary user_id=13 object="product" assign=summary}

{if $summary|@count>0}
<!--<div class="nav-round-corner-top">
<p class="nav-title">Category</p>

</div>
<div class="category">
		<ul>
			{foreach from=$summary item=tag}
			
			<li>
				<a href="{geturl route='clubproducttagspace' username='vedancewear' tag=$tag.tag}">
				{$tag.tag|escape}
				</a>
				
				
			</li>
		
			{/foreach}
		</ul>
</div>
<div class="nav-round-corner-bottom">
</div>-->
{/if}








