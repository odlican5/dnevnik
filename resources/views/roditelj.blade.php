<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>Roditeljska strana</title>
        <!-- stilovi START::-->
        {!! HTML::style('css/templejtBackEnd.css') !!}
        {!! HTML::style('css/bootstrap.min.css') !!}
        {!! HTML::style('css/fontello.css') !!}
        {!! HTML::style('css/animation.css') !!}
        {!! HTML::style('css/datepicker.css') !!}
        {!! HTML::style('css/responsive-calendar.css') !!}


        {!! HTML::script('js/jquery-3.0.js') !!}
       
        {!! HTML::script('js/jquery.minicolors.js') !!}
        {!! HTML::style('js/jquery.minicolors.css') !!}
        {!! HTML::script('js/jquery.easing.js') !!}
        {!! HTML::script('js/jquery.color.js') !!}
        {!! HTML::script('js/jquery-ui.min.js') !!}
        {!! HTML::script('js/funkcije.js') !!}
        {!! HTML::script('tinymce/tinymce.min.js') !!}
        {!! HTML::script('js/datepicker.js') !!}
        {!! HTML::script('js/Chart.Core.js') !!}
         {!! HTML::script('js/Chart.Doughnut.js') !!}
         {!! HTML::script('js/responsive-calendar.js') !!}
        <!-- stilovi END::-->
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
        <style>h1,h2,p{text-align: center}
            #dashboard {
                width: 220px;
                background-color: #26c1d6;
                padding: 20px 20px 0 20px;
                position: absolute;
                left: -200px;
                z-index: 100;
            }
            #dashboard img {
                margin-bottom: 20px;
                border: 1px solid rgb(0,0,0);
            }
            #myPannel, .tbbl{
                background-color : transparent; 
            }
            #myTab  li a{
            background-color : transparent; 
            }
            #img_primljene{
                width:124px;
                height: 102px;
            }
            #img_poslate{
                width:124px;
                height: 102px;
            }
            #img_primljene:hover{
                width:124px;
                height: 102px;
                content:url("/img/email-receive-icon.png");
            }
            #img_poslate:hover{
                width:124px;
                height: 102px;
                content:url("/img/email-send-icon.png");
            }

        </style>

 
    </head>
    <body style="width:100%; padding-top: 5px;  height:100%; background: url(/img/bg2.jpg) no-repeat center center fixed;">
        
        <div class="container" style="width: 98%;">
            <div id="dashboard" style=" height:100%; border-radius:5px;">
                <div id="menu-arrow" style="position:absolute;right:-25px;z-index: 1000"> 
                    <button style="color:#3C577A;" type="button" class="btn btn-default" aria-label="Left Align">
                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </button>
                </div>
                <div id="dMenija" class="">
                    @if(\App\Security::autentifikacijaTest(2,'min'))
                    <ul  class="nav navbar-nav navbar-right pull-left">
                        <li style="border-bottom:1px solid white;"><a href="/administracija/roditelj/pregled" ><i class="glyphicon glyphicon-book"></i>&nbsp Pregled ocena</a></li>
                        <li style="border-bottom:1px solid white;"><a href="/administracija/poruke/roditelji"><i class="glyphicon glyphicon-envelope"></i>&nbsp Poruke<span class="badge badge-danger pull-right">Novih: {{App\Metode::number_unread_messages()}}</span></a></li>
                        <li style="border-bottom:1px solid white;"><a href="/administracija/roditelj/izostanci"><i class="glyphicon glyphicon-equalizer"></i>&nbsp Izostanci</a></li> 
                        <li style="border-bottom:1px solid white;"><a href="/administracija/dogadjaji"><i class="glyphicon glyphicon-calendar"></i>&nbsp Dogadjaji</a></li>
                        <li style="border-bottom:1px solid white;"><a href="/administracija/raspored/odeljenja"><i class="glyphicon glyphicon-list-alt"></i>&nbsp Raspored</a></li>
                        <li><a href="/administracija/logout"><i class="glyphicon glyphicon-off"></i>&nbsp Odjava</a></li>
                    </ul>
                    @endif
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#dMenija ul li a').css('color','white');
                    $('#dMenija ul li a').hover(function() {
                        $(this).css({'color':'#3C577A','background':'#26C1D6'});
                    },
                        function() {
                        $(this).css('color','white');
                    }
                    );
                  $('#dashboard').hover(
                     function() {
                        $(this).stop().animate(
                        {
                            left: '0',
                            backgroundColor: '#26c1d6'
                        },
                        500, 'easeInSine'
                        ); // end animate
                        $('#menu-arrow').html("<button style='color:#3C577A;' type='button' class='btn btn-default' aria-label='Left Align'><span class='glyphicon glyphicon-menu-left' aria-hidden='true'></span></button>");
                        $('#radni-prostor').stop().animate(
                        {
                            left: '+200px',
                            //backgroundColor: '#26c1d6'
                        },
                        500, 'easeInSine'
                        ); // end animate
                     }, 
                     function() {
                         $(this).stop().animate(
                        {
                            left: '-200px',
                            backgroundColor: '#269cd3;'
                        },
                        1500,
                        'easeOutBounce'
                        ); // end animate 
                         $('#menu-arrow').html("<button style='color:#3C577A;' type='button' class='btn btn-default' aria-label='Left Align'><span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span></button>");
                         $('#radni-prostor').stop().animate(
                        {
                            left: '0',
                            //backgroundColor: '#269cd3;'
                        },
                        1500,
                        'easeOutBounce'
                        ); // end animate 
                     }
                  ); // end hover
                }); // end ready
            </script>
            <div class="col-sm-12" id="radni-prostor">
                @yield('content')
            </div>         
        </div>

        @yield('body')
        <script>$(function(){$('[data-toggle=tooltip]').tooltip()})</script>
        {!! HTML::script('js/bootstrap.min.js') !!}
    </body>
</html>
