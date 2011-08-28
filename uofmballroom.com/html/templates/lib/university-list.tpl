
{if $universitylist|@count>0}
	<div class="box">
		<h3>Club-Nex Universities</h3>
		<ul>
			{foreach from=$universitylist item=university}
			<li>
				<a href="{geturl universityID=$university.university_id route='indexuniversity'}" {if $currentUniversityID== $university.university_id} class="universityCurrent"{/if}>
					{$university.university_name} ({$university.club_number})
				</a>
				
			</li>
			{/foreach}
		</ul>
	</div>
{/if}
