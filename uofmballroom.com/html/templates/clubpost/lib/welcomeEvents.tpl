			{capture assign='url'}{geturl username=uofmballroom url=$post->url route='clubpostview'}{/capture}

{if $counter=='1'}
<div class="event1Detail">
            <div class="greenDates">
                <div class="date">
			{$post->ev_created|date_format:'%b %e'}
                </div>
                <div class="location">
                    {$post->profile->location}
                </div>
                <div class="time">
                    {$post->ev_created|date_format:'%l %p'}-{$post->ev_ended|date_format:'%l %p'}
                </div>
            </div>
            <div class="eventGreen">
               <span class="title">{$post->profile->title}</span>

                <span class="description">{$post->getTeaser(100)}</span>
                
                <span class="more">more</span>
            </div>
</div>
{elseif $counter=='2'}

<div class="event2Detail">
            <div class="brownDates">
            
            	<div class="date">
			{$post->ev_created|date_format:'%b %e'}
                </div>
                <div class="location">
                    {$post->profile->location}
                </div>
                <div class="time">
                    {$post->ev_created|date_format:'%l %p'}-{$post->ev_ended|date_format:'%l %p'}
                </div>
            </div>
            <div class="eventBrown">
            
            	<span class="title">{$post->profile->title}</span>

                <span class="description">{$post->getTeaser(100)}</span>
                
                <span class="more">more</span>
            </div>
        </div>
 {elseif $counter=='3'}
        <div class="event3Detail">
                 <div class="orangeDates">
                
                    <div class="date">
			{$post->ev_created|date_format:'%b %e'}
                    </div>
                    <div class="location">
                    {$post->profile->location}
                    </div>
                    <div class="time">
                    {$post->ev_created|date_format:'%l %p'}-{$post->ev_ended|date_format:'%l %p'}
                    </div>
                </div>
                <div class="eventOrange">
                
                    <span class="title">{$post->profile->title}</span>
    
                    <span class="description">{$post->getTeaser(100)}</span>
                    
                    <span class="more">more</span>
                </div>
        </div>
       
 {elseif $counter=='4'}
        <div class="event4Detail">
                 <div class="redDates">
                
                    <div class="date">
			{$post->ev_created|date_format:'%b %e'}
                    </div>
                    <div class="location">
                    {$post->profile->location}
                    </div>
                    <div class="time">
                    {$post->ev_created|date_format:'%l %p'}-{$post->ev_ended|date_format:'%l %p'}
                    </div>
                </div>
                <div class="eventRed">
                
                    <span class="title">{$post->profile->title}</span>
    
                    <span class="description">{$post->getTeaser(100)}</span>
                    
                    <span class="more">more</span>
                </div>
        </div>
							
{/if}