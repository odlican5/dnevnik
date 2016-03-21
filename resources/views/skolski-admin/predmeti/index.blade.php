@extends('admin-skolski')
@section('content')
    <h2 style="text-align: left" id="proizvodi"><i class="glyphicon glyphicon-user"></i> Predmeti
        <button id="dugmeNovi" class="btn btn-primary" onClick="noviPredmet()" data-toggle="tooltip" title="Dodaj novi predmet"><i class="glyphicon glyphicon-plus"></i></button>
        <button id="dugmeUcitaj" class="btn btn-primary" onClick="ucitajPredmete()" data-toggle="tooltip" title="Prikaži predmete" style="display:none"><i class="glyphicon glyphicon-user"></i></button>
        <div class="form-inline" style="float: right">
            <button class="btn btn-sm btn-default" style="padding: 1.5px 10px" data-toggle="tooltip" title="Prikaži sve predmete" onclick="ucitajPredmete()"><i class="icon-users-1"></i></button>
            <div class="form-group">{!!Form::text('pretraga_proizvod',null,['class'=>'form-control','id'=>'pretraga_proizvod'])!!}</div>
            <button class="btn btn-sm btn-default" style="padding: 3px 10px" data-toggle="tooltip" title="Pronađi predmete" onclick="pretrazi()"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </h2>

    {!! HTML::style('/dragdrop/css/fileinput.css') !!}
    {!! HTML::script('/dragdrop/js/fileinput.min.js') !!}
    <script>
        $(function(){ucitajPredmete()})
        function noviPredmet(predmet){
            $('#dugmeNovi').hide();
            $('#dugmeUcitaj').fadeIn();

            $('#work-place').hide();
            $('#work-place').html('' +
            '<style>.fontResize *{font-size: 14px}</style>'+
            '<hr><div id="hide" class="form-horizontal fontResize"style="margin-top: 50px">'+
                '<div class="col-sm-5">'+
                    '<input type="text" name="prava_pristupa_id" value="4" hidden="hidden">'+
                    '{!!Form::hidden("_token",csrf_token())!!}' +
                    (predmet?'<input id="id_predmeta" name="id" value="'+predmet['id']+'" hidden="hidden">':'')+
                    '<div class="form-group">' +
                        '<label class="col-sm-4">Naziv predmeta</label>' +
                        '<div class="col-sm-8"><input name="naziv" value="'+(predmet?predmet['naziv']:'')+'" class="form-control"></div>' +
                    '</div>' +
                '</div>'+
                '<div class="col-sm-offset-1 col-sm-6">'+
                    '<div class="form-group">' +
                        '<label class="col-sm-4"></label>' +
                        '<div class="col-sm-8">' +
                            '{!!Form::button("<i class=\'glyphicon glyphicon-floppy-disk\'></i> Sačuvaj",["class"=>"btn btn-primary","onclick"=>"sacuvajPodatke()"])!!}' +
                            '{!!Form::button("<i class=\'glyphicon glyphicon-trash\'></i> Otkaži",["class"=>"btn btn-danger","data-dismiss"=>"modal","onClick"=>"ucitajPredmete()"])!!}' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'+
            '<div id="wait" style="display:none"><center><i class="icon-spin6 animate-spin" style="font-size: 200%"></i></center></div>' +
            '<div id="poruka" style="display: none"></div>');
            $('#work-place').fadeIn();
        }
        function ucitajPredmete(pretraga){
            $('#dugmeUcitaj').hide();
            $('#dugmeNovi').fadeIn();
            $('#work-place').html('<center><i class="icon-spin6 animate-spin" style="font-size: 200%;margin-top:80px"></i></center>');
            $.post('/administracija/predmeti/ucitaj',
                    {
                        _token:'{{csrf_token()}}',
                        pretraga:pretraga
                    },
                    function(data){
                        var predmeti=JSON.parse(data);
                        if(predmeti.length<1){
                            $('#work-place').html('<h3>Ne postoji ni jedan predmet u evidenciji.');
                            return;
                        }
                        var ispis='' +
                                '<div class="table-responsive">' +
                                '<table class="table table-condensed">' +
                                '<thead>' +
                                '<tr><th>Naziv predmeta</th><th>Naziv skole</th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                        for(var i=0;i<predmeti.length;i++){
                            ispis+='<tr>' +
                            '<td>'+predmeti[i]['predmeti']+'</td>' +
                            '<td>'+predmeti[i]['skole']+'</td>' +
                            '<td>' +
                                '<a href="#" class="btn btn-sm btn-info"  data-toggle="tooltip" title="Ažuriraj" onclick="editPredmeta('+predmeti[i]['id']+')"><span class="glyphicon glyphicon-pencil"></span></a>' +
                            '</td>' +
                            '</tr>';
                        }
                        $('#work-place').html(ispis+'</tbody></table></div>');
                        $('[data-toggle=tooltip]').tooltip();
                    });
        }
        function editPredmeta(predmet){
            $('#dugmeNovi').hide();
            $('#dugmeUcitaj').fadeIn();
            $('#work-place').html('<center><i class="icon-spin6 animate-spin" style="font-size: 200%;margin-top:80px"></i></center>');
            $.post('/administracija/predmeti/edit-ucitaj',
                    {
                        _token: '{{csrf_token()}}',
                        id: predmet
                    }, function (data) {
                        noviPredmet(JSON.parse(data))
                    });
        }
        function pretrazi(){
            ucitajPredmete($('#pretraga_proizvod').val());
        }
        function sacuvajPodatke(){
            if(SubmitForm.check('hide'))
                Komunikacija.posalji("/administracija/predmeti/azuriraj","hide","poruka","wait","hide");
        }
    </script>

    <div id="work-place"></div>
    <i class='icon-spin6 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
@endsection