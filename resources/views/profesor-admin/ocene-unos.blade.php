@extends('profesor-admin')



@section('content')
           {{-- <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                     <div class="alert alert-info alert-autocloseable-info">
                        <a href="/administracija/poruke">Imate {{App\Metode::number_unread_messages()}} novih poruka.</a>
                     </div>
                </div>
           </div>--}}
    <br><hr>
    <div class="col-sm-3">    
       {{-- {{$ocene_predmeti['ocene']['0']['ime']}}
        &nbsp
        {{$ocene_predmeti['ocene']['0']['prezime']}}--}}
        <div class="row">
            <div class="form-group">
                <div class="col-xs-12">
                    <label style="color:#6b6868" >Разред/одељење:</label>
                </div>
                <div class="col-xs-12">
                    {!!Form::select("razred",$razred_odeljenje,null, ["placeholder" => "Izaberite razred", "id"=>"sel","class"=>"form-control"])!!}
                </div>
            </div>
        </div>
        <div class="row">
            <div id="left-djaci"></div>
            <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
        </div>

</div>
    <script>
    $('.alert-autocloseable-info').hide();
    $( document ).ready(function() { 
     if ({{App\Metode::number_unread_messages()}}!=0) {
        $('.alert-autocloseable-info').delay(3000).fadeIn();
        $('.alert-autocloseable-info').delay(5000).fadeOut();
     }
       
    });

        $('#sel').click( function() 
        {
            var data = {
                'id': $("#sel :selected").val()
            };
            $('#left-djaci').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
            $.post('/administracija/ocene/ucitaj-djake',
                    {
                        _token: '{{csrf_token()}}',
                        id: data
                    },
                    function(data){
                        var djaci=JSON.parse(data);
                        if(djaci.length<1){
                            $('#left-djaci').html('<h3>Нема ученика у евиденцији!</h3>');
                            return;
                        }
                        var ispis='<ul style="list-style-type:none;">';
                        for(var i=0;i<djaci.length;i++){    
                             ispis+='<li>'+
                             '<a href="#" style="width:75%" class="btn3d btn btn-sm btn-info " data-toggle="tooltip" onclick="ucitajFormu('+djaci[i]['id']+')">'+djaci[i]['ime']+' '+djaci[i]['prezime']+'</a>' +
                           '<li>';

                        }
                        $('#left-djaci').html(ispis+'</ul>');
                    }
            );
        });

    function ucitajFormu(djak){
    $('#work-place').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
    $.post('/administracija/ocene/ucitaj-form',
            {
                _token: '{{csrf_token()}}',
                id: djak
            }, function (data) {
                //console.log(data);
                printForm(JSON.parse(data))
            });
    }
    function printForm(djak){
        console.log(djak);
            $('#work-place, #info-place').hide();
           // $('#info-place').hide();
            $('#work-place').html('' +
            '<style>.fontResize *{font-size: 16px;}  #radioBtn .notActive{color: #3276b1;background-color: #fff;}</style>'+
            '<div id="poruka1" style="display: none"></div>'+
            '<div id="hide1" class="form-horizontal fontResize"style="margin-top: 50px">'+
                '<div class="col-sm-12">'+
                    '{!!Form::hidden("_token",csrf_token())!!}' +
                    '{!!Form::hidden("update_id",false)!!}' +
                    '{!!Form::hidden("ocene_id",false)!!}' +
                   '<input id="id_djaka" name="id" value="'+djak['djaci']['id']+'" hidden="hidden">' +
                    '<div class="col-md-12">'+
                        '<button id="dugme" class="btn btn-info ribbon">'+djak['djaci']['ime']+'  '+djak['djaci']['prezime']+'</button>'+
                    '</div>'+
                    '<br/><br/>'+
                    '<h3>Закључна I-полугодиште: '+djak['zakljucna_polugodiste'][0]['ocene']+' </h3> <h3>Закључна kraj: '+djak['zakljucna_kraj'][0]['ocene']+'<img style="width:50px" src="/img/badge-icon.png"></h3>'+
                    '<div id="docena" class="form-group has-feedback">' +
                        '<label class="col-sm-2">Оцена:</label>' +
                        '<div class="col-sm-2">' +
                            '<input name="ocena" class="form-control" >' +
                            '<span id="socena" class="glyphicon form-control-feedback"></span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-sm-2">Запажање:</label>' +
                        '<div class="col-sm-10"><textarea id="zap" name="zapazanje" class="form-control"></textarea></div>' +
                    '</div><br>' +
                    '<div class="col-md-12">'+
                        '<div class="input-group">'+
                           '<div id="radioBtn" class="btn-group">'+
                                '<a class="btn3d btn btn-info btn-sm active" data-toggle="fun" data-title="0">Оцена</a>'+
                                '<a class="btn3d btn btn-info btn-sm notActive" data-toggle="fun" data-title="1">Закључна I-полугодиште</a>'+
                                '<a class="btn3d btn btn-info btn-sm notActive" data-toggle="fun" data-title="2">Закључна-крај</a>'+
                            '</div>'+
                            '<input type="hidden" name="zakljucna" id="fun">'+
                            '{!!Form::button("<i class=\'glyphicon glyphicon-floppy-disk\'></i> Sačuvaj",["id"=>"btn_sacuvaj","class"=>"btn3d btn btn-info","onclick"=>"sacuvajPodatke()"])!!}' +
                        '</div>'+
                    '</div>'+//co12
                    '<div class="col-md-12">' +
                            
                    '</div>' +//12
                    '<div class="col-md-12">' +
                            '<a class="btn btn-default btn3d" href="/administracija/raspored/pdf" role="button">Сведочанство</a>'+
                    '</div>' +
                '</div>' +//col12
            '</div>'+ //hide1  
            '<div id="wait1" style="display:none"><center><i class="icon-spin4 animate-spin" style="font-size: 100%"></i></center></div>');

            $('#radioBtn a').on('click', function(){
                var sel = $(this).data('title');
                var tog = $(this).data('toggle');
                $('#'+tog).prop('value', sel);
                
                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
            });
            ///info-place

            var ispisi=''+
                '<div class="col-sm-12">'+
                      '<table style="background-color : transparent; "  class="table table-condensed">';
                     console.log(djak['ocene']);
               for(var i=0;i<djak['ocene'].length;i++){
                console.log(djak['ocene'][i]['zapazanje']);
                            ispisi+='<tr id="row-'+djak['ocene'][i]['id']+'">' +
                            '<td><button style="color:#7FDDE9; " type="button" class="btn btn-default "data-toggle="tooltip" title='+djak['ocene'][i]['created_at']+'><span class="glyphicon glyphicon-time"></span></button></td>' +
                            '<td ><input style="width:50px;" value="'+djak['ocene'][i]['ocene']+'" type="text" disabled></td>' +
                            '<td ><textarea id="ocena-'+djak['ocene'][i]['id']+'"  disabled>'+djak['ocene'][i]['zapazanje']+'</textarea></td>' +
                            '<td>' +
                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" onclick="editZapis('+djak['ocene'][i]['ocene']+','+djak['ocene'][i]['id']+','+djak['ocene'][i]['zakljucna']+')" title="Ažuriraj" ><span class="glyphicon glyphicon-edit"></span></a>' +
                                '<a href="#" class="btn3d btn btn-xs btn-danger" onclick="brisiPodatke('+djak['ocene'][i]['id']+')" data-toggle="tooltip" title="Obriši" ><span class="glyphicon glyphicon-remove"></span></a>' +
                            '</td>' +
                            '</tr>';
                        }
                        $('#info-place').html(ispisi+'</table></div>');
                        $('[data-toggle=tooltip]').tooltip();


            $('#work-place').fadeIn();
            $('#info-place').fadeIn();
        

        //prikaz dugmeta za mail roditelju
        $('#mail-place').hide();
        $('#mail-place').html('<br>' +
                        '<a href="#" id="idmod" class="btn3d col-md-12 btn btn-md btn-info pull-left" data-toggle="modal" data-target="#myModal" title="Kontaktiraj roditelja" data-iddjaka='+djak['djaci']['id']+'> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp Пошаљи поруку родитељу</a>');

            $('#myModal').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget); // prosledjivanje iddjaka modalu
              var recipient = button.data('iddjaka') ;
              var modal = $(this);
              modal.find('input[name=iddjaka]').val(recipient);     
            });
        //kraj - prikaz dugmeta za mail roditelju
       
        //prikaz Odsustvo sa časa
        $('#odsustvo-place').html('<br><br>' +
                '<div id="ods">'+
                 '{!!Form::hidden("_token",csrf_token())!!}' +
                 '<input id="djak_id" name="djak_id" value="'+djak['djaci']['id']+'" hidden="hidden">' +
                '<div class="panel panel-default">'+
                    '<div class="panel-heading">Одсуство са часа:</div>'+
                    '<div class="panel-body">'+
                       '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<label>Број часова:</label>' +
                            '</div>' +
                        '</div>' +
                        '<div class="row">' +
                            '<div class="col-xs-5">' +
                                '<input name="brojcasova" class="form-control" >' +
                            '</div>' +
                        '</div>' +
                        '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<label>Дана:</label>' +
                            '</div>' +
                        '</div>' +
                        '<div class="input-group date" data-provide="datepicker">'+
                            '<input name="datum" type="text" class="form-control">'+
                            '<div class="input-group-addon">'+
                                '<span class="glyphicon glyphicon-th"></span>'+
                            '</div>'+
                        '</div>'+
                        '<div class="row">' +
                            '<div class="col-xs-6">' +
                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" onclick="unesiOdsutnost()" title="Unesi" ><span class="glyphicon glyphicon-send"></span>&nbsp &nbspUnesi odsutnost djaka</a>'+  
                            '</div>' +
                        '</div>'+
                    '</div>'+
                '</div></div>'+
                        '<div id="waitods" style="display:none"><center><i class="icon-spin4 animate-spin" style="font-size: 100%"></i></center></div>'+
        '<div id="poruka2" style="display: none"></div>');
       
         $('.datepicker').datepicker();
        //kraj - Odsustvo sa časa

    //pocetak - Krofna chart
        var context = $('#chart').get(0).getContext('2d');
        // And for a doughnut chart
        var chart = new Chart(context).Doughnut([
           //data
            {
                value: djak['neopravdano'],
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Neopravdani"
            },
            {
                value: djak['opravdano'],
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Opravdani"
            },
            {
                value: djak['nereseno'],
                color: "#FDB45C",
                highlight: "#FFC870",
                label: "Nerešeni"
            }
        ]//kraj data
        ,{//pocetak ocije
                tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",       
                onAnimationComplete: function()
                {
                    this.showTooltip(this.segments, true);
                }, 
                 tooltipEvents: ["mousemove", "touchstart", "touchmove"],
                showTooltips: true
            });   //kraj opcije
//kraj - Krofna chart
        
        $('#mail-place').fadeIn(); 
    }
    function unesiOdsutnost(){
        Komunikacija.posalji("/administracija/ocene/odsutnost","ods","poruka2","waitods","ods");
    }
    function editZapis(ocena,id,zakljucna){
       var text=$('#ocena-'+id).text();
        console.log(ocena);
        $("#btn_sacuvaj").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај оцену");
        $('#work-place').hide();
        $('input[name=ocena]').val(ocena);
        $('#zap').text(text);
        $('input[name=update_id]').val(1);
        $('input[name=ocene_id]').val(id);

                var sel = zakljucna;
                var tog = 'fun';
                $('#'+tog).prop('value', sel);
                
                $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
                $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

        $('#work-place').fadeIn();
    }

    function sacuvajPodatke(){
            if(SubmitForm.check('hide'))
                var ocena=$('input[name=update_id]').val();
                console.log(ocena);
                if($('input[name=update_id]').val()!==false){

                    //$('#work-place').hide();

                    var id=$('input[name=ocene_id]').val();
                    $ocena=$('input[name=ocena]').val();
                    $zapazanje=$('#zap').val();
                    $('#ocena-'+id).val($zapazanje);

                    $('#work-place').hide();
                    $('#work-place').fadeIn();
                    $('#spin').fadeOut();


                }
                if($('input[name=update_id]').val()==false){
                     $ocena=$('input[name=ocena]').val();
                    $zapazanje=$('#zap').val();
                    var currentdate = new Date(); 
                    var datetime = currentdate.getDate() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getFullYear() + "  "  
                    + currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();
                    var red='<tr> ';
                    red+='<td><button style="color:#7FDDE9; " type="button" class="btn btn-default "data-toggle="tooltip" title='+datetime+'><span class="glyphicon glyphicon-time"></span></button></td>' +
                    '<td><input style="width:50px;" type="text" disabled  value="'+$ocena+'"></td>'+
                    '<td ><textarea disabled>'+$zapazanje+'</textarea></td>' +
                    '</tr>';
                    $(".table").append(red);  
                }
                Komunikacija.posalji("/administracija/ocene/sacuvaj","hide1","poruka1","wait1","hide");
        }
        function brisiPodatke(id){       
                $('#row-'+id).hide();
                $('#work-place').hide();
                    $('#work-place').fadeIn();
                    $('#spin').fadeOut();
                $('input[name=ocene_id]').val(id);
               Komunikacija.posalji("/administracija/ocene/brisi","hide1","poruka1","wait1","hide");
        }
    </script>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div style="width:100%; border-top:5px solid #269ABC;opacity: 0.85; background: url(/img/bg2.jpg) no-repeat center center fixed;" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove"></span></button>
        <h4 class="modal-title" id="myModalLabel">Контактирајте родитеља!</h4>
      </div>
      <div class="modal-body">
        <div id="vrti" style="display:none"><center><i class='icon-spin4 animate-spin' style="font-size: 200%"></i></center></div>
        <div id="poruka" style="display:none"></div>
        <div id="forma" class="form-horizontal">
            {!!Form::hidden('_token',csrf_token())!!}
            {!!Form::hidden('iddjaka',false)!!}
            {!!Form::hidden('svi',false)!!}
            <textarea name="poruka" style="width:100%"></textarea>
             {!!Form::label('Пошаљи свим родитељима')!!}
            <input class="bootstrap-switch-handle-off bootstrap-switch-default" type="checkbox" name="svi_roditelji" >
            <script>
            $("[name='svi_roditelji']").bootstrapSwitch();
            $("[name='svi_roditelji']").on('switchChange.bootstrapSwitch', function(event, state) {
              $("[name='svi']").val(state);
            });
            </script>
        </div>
      </div>
      <div class="modal-footer">
        {!! Form::button('<span class="glyphicon glyphicon-remove"></span>&nbsp Otkaži',['class'=>'btn3d btn btn-sm btn-warning','data-dismiss'=>'modal']) !!}
        {!! Form::button('<span class="glyphicon glyphicon-ok"></span>&nbsp Pošalji',['class'=>'btn3d btn btn-sm btn-success','onclick'=>'Komunikacija.posalji("/administracija/ocene/posaljimail",\'forma\',\'poruka\',\'vrti\',\'forma\')' ]) !!}
      </div>
    </div>
  </div>
</div>

<!-- kraj Modal -->

<div class="col-sm-6">{{-- --}}
    <div id="work-place">
        <div class="col-md-12">
            <button id="dugme" class="btn btn-info ribbon">Име и презиме</button>
        </div>
        <br/><br/>
        <h3 style="color:#6b6868">Закључна I-полугодиште: </h3> <h3 style="color:#6b6868">Закључна kraj:<img style="width:50px" src="/img/badge-icon.png"></h3>
        <div class="form-group has-feedback">
            <label style="color:#6b6868" class="col-sm-3">Оцена:</label>
            <div class="col-sm-3">
                <input name="ocena" class="form-control" >
                <span id="socena" class="glyphicon form-control-feedback"></span>
            </div>
        </div><br>
        <div class="form-group">
            <label style="color:#6b6868" class="col-sm-3">Запажање:</label>
            <div class="col-sm-9">
                <textarea class="form-control"></textarea>
            </div>
        </div><br>
        <div class="col-md-12">
            <div class="input-group">
               <div id="radioBtn" class="btn-group">
                    <a class="btn3d btn btn-info btn-sm active" data-toggle="fun" data-title="0">Оцена</a>
                    <a class="btn3d btn btn-info btn-sm notActive" data-toggle="fun" data-title="1">Закључна I-полугодиште</a>
                    <a class="btn3d btn btn-info btn-sm notActive" data-toggle="fun" data-title="2">Закључна-крај</a>
                </div>
                {!!Form::button("<i class=\'glyphicon glyphicon-floppy-disk\'></i> Sačuvaj",["id"=>"btn_sacuvaj","class"=>"btn3d btn btn-info","onclick"=>"sacuvajPodatke()"])!!}
            </div>
        </div>
    </div>
    <div id="info-place"></div>
    <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
</div>
<div class="col-sm-3">{{-- desna strana  izostanci, statistika --}}
    <div id="mail-place"></div>
    <div id="odsustvo-place"></div>

        <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
    <br><br>
{{--statistika --}}

       <div  id="chartContainer">
            
            <canvas id="chart"  style="width:300px; height:300px;"></canvas>
        </div>


</div>
@endsection
