<!DOCTYPE html>
<html>
<head>
    <title>Coin Event</title>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/uikit.min.css"/>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/hover-min.css"/>
    <link rel="stylesheet" href="css/day-style.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"></script>

    <script src="js/uikit.min.js"></script>
    <script src="js/bootstrap-popover-x.js"></script>
    <script src="js/uikit-icons.min.js"></script>
</head>
<body>

@include('layout.header')

@include('widget.sidebar')

<div class="content-padder content-background">
    @yield('content')
</div>

</div>


<!-- Load More Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.min.js"></script>
<!-- Required Overall Script -->
<script src="js/script.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function () {

        var datePicker = $('#miniMonth');

        datePicker.datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,

        });

        var currentDate = new Date().toISOString().substring(0, 10);
        // set default nextDay and preDay
        setNextAndPreDate(currentDate);
        setCurrentMonthAndYear(currentDate.split('-')[1],currentDate.split('-')[0]);

        $('#miniMonth').on('changeDate', function (event) {
            setCurrentMonthAndYear(event.format('m'), event.format('yyyy'));
            setNextAndPreDate(event.format('yyyy-mm-dd'));
            var dateSelect = event.format();
            setEventOfDay(dateSelect);
        });

        $('.date-today').on('click',function () {
            var currentDate = $(this).attr('date-today');
            setEventOfDay(currentDate);
            setDatePicker(currentDate);
        });

        $('.fa-angle-left,.fa-angle-right').on('click',function () {
            var day = $(this).attr('date');
            setEventOfDay(day);
            setNextAndPreDate(day);
            setCurrentMonthAndYear(day.split('-')[1],day.split('-')[0]);
            setDatePicker(day);
        });
        

//        $('.calendar-item').each(function () {
//            $(this).on('click', function () {
//                console.log($(this).text());
//            });
//        });









        function setEventOfDay(date) {
            var url = "/ajax/getEventOfDay";
            $.ajax({
                url: url,
                type: "GET",
                cache: false,
                data: {"dateSelect": date},
                beforeSend: function () {
                },
                success: function (data) {
                    $('.content-padder').html(data);
                    $('.calendar-item').each(function () {
                        $(this).on('click', function () {
                            console.log($(this).text());
                        });
                    });
                },
                complete: function () {
                    $.getScript("/js/bootstrap-popover-x.js", function() {
                       // alert('loaded script and content');
                    });
                }
            });
        }
        
        function setDatePicker(date) {
            $('#miniMonth').datepicker("setDate", date);
        }
        
        function setCurrentMonthAndYear(month, year) {
            $('.current-month').html(month);
            $('.current-year').html(year);
        }
        
//        function subtractDays(date, days) {
//            var d = new Date(date);
//            date = new Date(d.setDate(d.getDate() + days));
//            return date.toISOString().substring(0, 10);
//        }

        function setNextAndPreDate(date) {
            var d1 = new Date(date);
            var d2 = new Date(date);
            var nextDay = new Date(d1.setDate(d1.getDate() + 1));
            var preDay = new Date(d2.setDate(d2.getDate() - 1));
            $('.fa-angle-left').attr('date', preDay.toISOString().substring(0, 10));
            $('.fa-angle-right').attr('date', nextDay.toISOString().substring(0, 10));

        }


    })
</script>

@yield('script_footer')

</body>
</html>
