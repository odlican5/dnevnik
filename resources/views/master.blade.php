<!DOCTYPE html>
<html lang="sr" class="no-skrollr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="google-translate-customization" content="63955273670ebbdc-a0af1b075be7ac02-g352fbbe38eded318-d">

    <title>@yield('title')</title>
    {!! HTML::style('css/templejt.css') !!}
    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::script('js/jquery-3.0.js') !!}
    <style>@yield('style')</style>
</head>

<body>
    {{--navigacija START::--}}
    <nav style="background:#26c1d6;" class="navbar navbar-default navbar-fixed-top">
        <div class="container">

            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" style="color:white;" class="navbar-brand scroll-link navbar-btn" data-id="">
                    <span class="glyphicon glyphicon-home"></span> IS Dnevnik
                </a>
            </div>
            <div  class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <img style="height:60px;" src="img/logo.png" >
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a style="color:white;" class="navbar-btn" href="/administracija"><i class="glyphicon glyphicon-cog"></i> O nama</a></li>
                    <li><a style="color:white;" class="navbar-btn" href="/administracija"><i class="glyphicon glyphicon-cog"></i> Kontakt</a></li>
                    <li><a style="color:white;" class="navbar-btn" href="/administracija"><i class="glyphicon glyphicon-cog"></i> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    {{--navigacija END::--}}
    <div class="container">
        @yield('content')
    </div>

    @yield('body')
    {!! HTML::script('js/skrollr.min.js') !!}
    <script type="text/javascript">
        skrollr.init({
            smoothScrolling: false,
            mobileDeceleration: 0.004
        });
    </script>

    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('js/funkcije.js') !!}
</body>
</html>