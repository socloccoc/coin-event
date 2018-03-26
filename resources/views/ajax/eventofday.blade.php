<div class="content-day">
    <div class="header">
        <div style="margin-left: 20px">
            <div class="dayOfWeek">{{ isset($dayOfWeek) ? $dayOfWeek : '' }}</div>
            <div class="dayOfMonth">{{ isset($currentDay) ? $currentDay : '' }}</div>
        </div>
    </div><!--End Header-->
    <div class="content">
        @forelse($listEventToday as $index=>$event)
            <div data-toggle="popover-x" data-target="#myPopover{{ $index }}" data-placement="right"
                 class="col-lg-1 calendar-item hvr-box-shadow-outset">
                {{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}{{ isset($event['content_event']) ? $event['content_event'] : '' }}
            </div>
            <div id="myPopover{{ $index }}" class="popover popover-x popover-default">
                <div class="arrow"></div>
                <h3 class="popover-header popover-title"><span class="close pull-right" data-dismiss="popover-x">&times;</span>{{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}</h3>
                <div class="popover-body popover-content">
                    <p>{{ isset($event['content_event']) ? $event['content_event'] : '' }}</p>
                </div>
            </div>
        @empty
            {{ 'Not Found' }}
        @endforelse

    </div>
</div>