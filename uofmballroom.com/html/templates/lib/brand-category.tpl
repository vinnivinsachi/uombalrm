<div class="nav-round-corner-top">
<p class="nav-title">Brand Category</p>

</div>
<div class="category">
		<ul>
			{foreach from=$brand_cats item=tag}
				<li>
					<a href="{geturl route='clubproducttagspace' username=vedancewear tag=$tag.cat}" style="margin-right:10px;">
					{$tag.cat|escape}
					</a>
				  
					
				</li>
				{/foreach}
		</ul>
</div>
<div class="nav-round-corner-bottom">
</div>