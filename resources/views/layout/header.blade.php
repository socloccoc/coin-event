<div uk-sticky class="uk-navbar-container tm-navbar-container uk-active">
    <div class="uk-container uk-container-expand">
        <nav uk-navbar>
            <div class="uk-navbar-left">
                <a id="sidebar_toggle" class="uk-navbar-toggle" uk-navbar-toggle-icon></a>
                <a href="#" class="uk-navbar-item uk-logo">
                    Coin Event
                </a>
            </div>
            <div class="col-lg-4 col-lg-offset-1 tbn-today">
                <button date-today="{{ isset($currentDate) ? $currentDate : '' }}" class="btn btn-default date-today" data-toggle="tooltip" data-placement="bottom" title="Hôm nay">Hôm nay</button>
                <i date="" class="fa fa-angle-left changeDate"></i>
                <i date="" class="fa fa-angle-right changeDate"></i>
                <label class="current-datetime">Tháng <label class="current-month">5</label>,<label class="current-year">2018</label></label>
            </div>
            <div class="col-lg-2 col-lg-offset-3 search">
                <i class="fa fa-search"></i>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Ngày <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a style="float: left" href="#">Ngày</a></li>
                        <li><a href="#">Tuần</a></li>
                        <li><a href="#">Tháng</a></li>
                        <li><a href="#">Năm</a></li>
                    </ul>
                </div>
            </div>
            <div class="uk-navbar-right uk-light">
                <ul class="uk-navbar-nav">
                    <li class="uk-active">
                        <a style="font-size: 15px; color: #000000">Daidv &nbsp;<span class="ion-ios-arrow-down"></span></a>
                        <div uk-dropdown="pos: bottom-right; mode: click; offset: -17;">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="#" style="font-size: 12px">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</div>