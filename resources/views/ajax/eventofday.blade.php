<div class="content-day">
    <div class="header">
        <div style="margin-left: 20px">
            <div class="dayOfWeek">{{ isset($dayOfWeek) ? $dayOfWeek : '' }}</div>
            <div class="dayOfMonth">{{ isset($currentDay) ? $currentDay : '' }}</div>
        </div>
    </div><!--End Header-->
    <div class="content">
        @forelse($listEventToday as $event)
            <div class="col-lg-1 calendar-item hvr-box-shadow-outset">
                {{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}{{ isset($event['content_event']) ? $event['content_event'] : '' }}
            </div>
        @empty
            {{ 'Not Found' }}
        @endforelse

    </div>
</div>