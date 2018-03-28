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
            <?php
                $count = 1;
                $check = true;
            ?>
            @forelse($listEventToday as $index=>$event)
                <div data-toggle="popover-x" data-target="#myPopover{{ $index }}" data-placement="{{ $check ? 'right' : 'left' }}"
                     class="col-lg-1 col-md-2 col-sm-3 calendar-item hvr-box-shadow-outset">
                    <div>
                        {{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}{{ isset($event['content_event']) ? $event['content_event'] : '' }}
                    </div>
                </div>
                <div id="myPopover{{ $index }}" class="popover popover-x popover-default">
                    <div class="arrow"></div>
                    <h3 class="popover-header popover-title"><span class="close pull-right"
                                                                   data-dismiss="popover-x">&times;</span>{{ isset($event['coin_name']) ? '【'.$event['coin_name'].'】' : '' }}
                    </h3>
                    <div class="popover-body popover-content">
                        <p>{{ isset($event['content_event']) ? $event['content_event'] : '' }}</p>
                        <p>First Stratis Verified ICO（GLUON）のトークンは3月27日以降販売されます。</p>
                        <p><i style="margin-right: 20px" class="fa fa-clock-o" aria-hidden="true"></i>{{ isset($event['date']) ? $event['date'] : '' }}</p>
                        <hr style="margin-top: 5px; margin-bottom: 5px">
                        <div style="padding-bottom: 10px" class="col-lg-6">
                            <i style="margin-right: 5px" class="fa fa-image"></i>Proof
                        </div>
                        <div class="col-lg-6">
                            <i style="margin-right: 5px" class="fa fa-external-link"></i>Source
                        </div>
                    </div>
                </div>
                <?php
                        $count++;
                        if($count % 6 == 0) $check = !$check;
                    ?>
            @empty
                {{ 'Not Found' }}
            @endforelse

        </div>
    </div>

@stop
