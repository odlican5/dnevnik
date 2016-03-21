<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>Skolska administracija</title>
        <!-- stilovi START::-->
        {!! HTML::style('css/templejtBackEnd.css') !!}
        {!! HTML::style('css/bootstrap.min.css') !!}
        {!! HTML::style('css/fontello.css') !!}
        {!! HTML::style('css/animation.css') !!}
        {!! HTML::style('css/datepicker.css') !!}
        {!! HTML::style('css/bootstrap-select.css') !!}
        <!-- stilovi END::-->

        <!-- skripte START::-->
        {!! HTML::script('js/jquery-3.0.js') !!}
        {!! HTML::script('js/funkcije.js') !!}
        {!! HTML::script('tinymce/tinymce.min.js') !!}
        {!! HTML::script('js/datepicker.js') !!}
        {!! HTML::script('js/bootstrap-select.js') !!}
        <!-- stilovi END::-->
        <style>h1,h2,p{text-align: center}</style>
    </head>
    <body style="background: url(/img/bg_login.jpg) no-repeat center center fixed; background-size:cover">

        
        <div class="container" style="width: 98%">
            @yield('content')
        </div>

        @yield('body')
        <script>$(function(){$('[data-toggle=tooltip]').tooltip()})</script>
        {!! HTML::script('js/bootstrap.min.js') !!}
    </body>
</html>
