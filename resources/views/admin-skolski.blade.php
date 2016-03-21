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

        <!-- stilovi END::-->

        <!-- skripte START::-->
        {!! HTML::script('js/jquery-3.0.js') !!}
        {!! HTML::script('js/funkcije.js') !!}
        {!! HTML::script('tinymce/tinymce.min.js') !!}
        {!! HTML::script('js/datepicker.js') !!}

        <!-- stilovi END::-->
        <style>
        h1,h2,p{
            text-align: center
        }
            #myPannel, .tbbl{
                background-color : transparent; 
            }
            #img_predmeti{
                width:124px;
                height: 102px;
            }
            #img_predmeti:before {
              content: url('/img/folder-icon-predmeti-hover.png');
              width:0px;
              height: 0px;
              visibility:hidden;
            }
            #img_predmeti:hover{
                width:124px;
                height: 102px;
                content:url("/img/cience-class-icon.png");
            }
            #img_nastavnici{
                width:124px;
                height: 102px;
            }
            #img_nastavnici:hover{
                width:124px;
                height: 102px;
                content:url("/img/teacher-icon.png");
            }
            #img_razredni{
                width:124px;
                height: 102px;
            }
            #img_razredni:hover{
                width:124px;
                height: 102px;
                content:url("/img/classroom-icon.png");
            }
            #img_nast_od{
             width:124px;
                height: 102px;
            }
            #img_nast_od:hover{
                width:124px;
                height: 102px;
                content:url("/img/classroom-teacher.png");
            }
             #img_settings{
             width:124px;
                height: 102px;
            }
            #img_settings:hover{
                width:124px;
                height: 102px;
                content:url("/img/settings-icon.png");
            }
            #myTab >li.active>a, #myTab >li.active>a:focus, #myTab >li.active>a:hover {
                color: #555;
                cursor: default;
                background-color: rgba(1, 17, 19, 0.2);
                border: 1px solid #ddd;
                border-bottom-color: transparent;
            }
            #myTab  li a{
               border: 1px solid transparent;
                border-radius: 8px 8px 0 0;
            }
        </style>
    </head>
    <body style="  height:100%; background-color: #e8eaea;">
         <nav  style="background:#26c1d6;"  class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button style="background-color:white;" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    <a  style="color:white;padding-top:5px;" class="navbar-brand" href="{!! url('/') !!}"><img class="img-responsive" style="height:45px;" src="img/logo.png" ></a>
                    
                </div>
                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a style="color:white;" href="/administracija/logout"><i class="glyphicon glyphicon-off"></i> Odjava</a></li>
                    </ul>
                </div>
                
            </div>
        </nav>

        
        <div class="container" style="width: 98%">
            @yield('content')
        </div>

        @yield('body')
        <script>$(function(){$('[data-toggle=tooltip]').tooltip()})</script>
        {!! HTML::script('js/bootstrap.min.js') !!}
        {!! HTML::script('js/bootstrap-confirmation.js') !!}
    </body>
</html>
