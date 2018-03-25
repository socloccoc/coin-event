@extends('layout.index')
@section('content')
<div class="content-day">
    <div class="header">
        <div style="margin-left: 20px">
            <div class="dayOfWeek">{{ isset($dayOfWeek) ? $dayOfWeek : '' }}</div>
            <div class="dayOfMonth">{{ isset($currentDay) ? $currentDay : '' }}</div>
        </div>
    </div><!--End Header-->
    <div class="content">
        <a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a>
        @forelse($listEventToday as $event)
            <div data-toggle="popover" data-placement="left"
                 data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                 class="col-lg-1 calendar-item hvr-box-shadow-outset">
                {{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}{{ isset($event['content_event']) ? $event['content_event'] : '' }}
            </div>
        @empty
            {{ 'Not Found' }}
        @endforelse

    </div>
</div>
@stop