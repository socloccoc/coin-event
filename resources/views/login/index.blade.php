<!DOCTYPE html>
<html>
<head>
    <title>CoinEvent</title>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/uikit.min.css"/>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/uikit.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="js/uikit-icons.min.js"></script>
    <style>
        .uk-card-default {
            -webkit-box-shadow: 10px 10px 18px -6px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 10px 10px 18px -6px rgba(0, 0, 0, 0.75);
            box-shadow: 10px 10px 18px -6px rgba(0, 0, 0, 0.75);
            margin-top: 20px;
            border: 1px solid #cccccc;
        }
    </style>
</head>
<body>
<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky uk-active"
     style="position: fixed; top: 0px; width: 1903px;">
    <div class="uk-container uk-container-expand">
        <nav uk-navbar>
            <div class="uk-navbar-left">
                <a href="#" class="uk-navbar-item uk-logo">
                    Coin Event
                </a>
            </div>
        </nav>
    </div>
</div>
<div class="content-background">
    <div class="uk-container uk-container-large">
        <div uk-grid class="uk-child-width-1-1@s uk-child-width-2-3@l">
            <div class="uk-width-1-1@s uk-width-1-3@l uk-width-1-3@xl"></div>
            <div class="uk-width-1-1@s uk-width-1-3@l uk-width-1-3@xl">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-body">
                        <center>
                            <h2>CoinEvent</h2><br/>
                        </center>
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{ $err }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('messages'))
                            <div style="color: red" class="alert alert-danger">
                                {{ session('messages') }}
                            </div>
                        @endif
                        <form method="POST" action="login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <fieldset class="uk-fieldset">

                                <div class="uk-margin">
                                    <div class="uk-position-relative">
                                        <span class="uk-form-icon ion-locked"></span>
                                        <input name="password" class="uk-input" type="password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="uk-margin uk-text-right">
                                    <button type="submit" class="uk-button uk-button-primary">
                                        <span class="ion-forward"></span>&nbsp; Login
                                    </button>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert-danger').hide();
        }, 3000);
    });
</script>
</body>
</html>
