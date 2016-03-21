@extends('super-admin.master')
@section('content')
    <h2 style="text-align: left" id="proizvodi"><i class="glyphicon glyphicon-user"></i> Korisnici
        <button id="dugmeNovi" class="btn btn-primary" onClick="noviKorisnik()" data-toggle="tooltip" title="Dodaj novog korisnika"><i class="glyphicon glyphicon-plus"></i></button>
        <button id="dugmeUcitaj" class="btn btn-primary" onClick="ucitajKorisnike()" data-toggle="tooltip" title="Prikaži korisnike" style="display:none"><i class="glyphicon glyphicon-user"></i></button>
        <div class="form-inline" style="float: right">
            <button class="btn btn-sm btn-default" style="padding: 1.5px 10px" data-toggle="tooltip" title="Prikaži sve korisnike" onclick="ucitajKorisnike()"><i class="icon-users-1"></i></button>
            <div class="form-group">{!!Form::text('pretraga_proizvod',null,['class'=>'form-control','id'=>'pretraga_proizvod'])!!}</div>
            <button class="btn btn-sm btn-default" style="padding: 3px 10px" data-toggle="tooltip" title="Pronađi korisnika" onclick="pretrazi()"><i class="glyphicon glyphicon-search"></i></button>
        </div>
    </h2>

    {!! HTML::style('/dragdrop/css/fileinput.css') !!}
    {!! HTML::script('/dragdrop/js/fileinput.min.js') !!}
    <script>
        $(function(){ucitajKorisnike()})
        function noviKorisnik(korisnik){
            $('#dugmeNovi').hide();
            $('#dugmeUcitaj').fadeIn();

            $('#work-place').hide();
            $('#work-place').html('' +
            '<style>.fontResize *{font-size: 14px}</style>'+
            '<hr><div id="hide" class="form-horizontal fontResize"style="margin-top: 50px">'+
                '<div class="col-sm-5">'+
                    '<input type="text" name="prava_pristupa_id" value="4" hidden="hidden">'+
                    '{!!Form::hidden("_token",csrf_token())!!}' +
                    (korisnik?'<input id="id_korisnika" name="id" value="'+korisnik['id']+'" hidden="hidden">':'')+
                    '<div id="dime" class="form-group has-feedback">' +
                        '<label class="col-sm-4">Ime</label>' +
                        '<div class="col-sm-8">' +
                            '<input name="ime" value="'+(korisnik?korisnik['ime']:'')+'" class="form-control" id="ime">' +
                            '<span id="sime" class="glyphicon form-control-feedback"></span>' +
                        '</div>' +
                    '</div>' +
                    '<div id="dprezime" class="form-group has-feedback">' +
                        '<label class="col-sm-4">Prezime</label>' +
                        '<div class="col-sm-8">' +
                            '<input name="prezime" value="'+(korisnik?korisnik['prezime']:'')+'" class="form-control" id="prezime">' +
                            '<span id="sprezime" class="glyphicon form-control-feedback"></span>' +
                        '</div>' +
                    '</div>' + 
                    '<div id="dusername" class="form-group has-feedback">' +
                        '<label class="col-sm-4">Username</label>' +
                        '<div class="col-sm-8">' +
                            '<input name="username" value="'+(korisnik?korisnik['username']:'')+'" class="form-control" id="username">' +
                            '<span id="susername" class="glyphicon form-control-feedback"></span>' +
                        '</div>' +
                    '</div>' +
                    '<div id="dpassword" class="form-group has-feedback">' +
                        '<label class="col-sm-4">Password</label>' +
                        '<div class="col-sm-8">' +
                            '<input type="password" name="password" class="form-control" id="password">' +
                            '<span id="susername" class="glyphicon form-control-feedback"></span>' +
                        '</div>' +
                    '</div>' +
                    
                '</div>'+
                '<div class="col-sm-offset-1 col-sm-6">'+
                    '<div class="form-group">' +
                        '<label class="col-sm-4">Email</label>' +
                        '<div class="col-sm-8"><input type="email" name="email" value="'+(korisnik?korisnik['email']:'')+'" class="form-control"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-sm-4">Telefon</label>' +
                        '<div class="col-sm-8"><input name="telefon" value="'+(korisnik?korisnik['telefon']:'')+'" class="form-control"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-sm-4"></label>' +
                        '<div class="col-sm-8">' +
                            '{!!Form::button("<i class=\'glyphicon glyphicon-floppy-disk\'></i> Sačuvaj",["class"=>"btn btn-primary","onclick"=>"sacuvajPodatke()"])!!}' +
                            '{!!Form::button("<i class=\'glyphicon glyphicon-trash\'></i> Otkaži",["class"=>"btn btn-danger","data-dismiss"=>"modal","onClick"=>"ucitajKorisnike()"])!!}' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'+
            '<div id="wait" style="display:none"><center><i class="icon-spin5 animate-spin" style="font-size: 200%"></i></center></div>' +
            '<div id="poruka" style="display: none"></div>');
            $('#work-place').fadeIn();
        }
        function ucitajKorisnike(pretraga){
            $('#dugmeUcitaj').hide();
            $('#dugmeNovi').fadeIn();
            $('#work-place').html('<center><i class="icon-spin5 animate-spin" style="font-size: 200%;margin-top:80px"></i></center>');
            $.post('/administracija/korisnici/ucitaj',
                    {
                        _token:'{{csrf_token()}}',
                        pretraga:pretraga
                    },
                    function(data){
                        var korisnici=JSON.parse(data);
                        if(korisnici.length<1){
                            $('#work-place').html('<h3>Ne postoji ni jedan korisnik u evidenciji.');
                            return;
                        }
                        var ispis='' +
                                '<table class="table table-condensed">' +
                                '<thead>' +
                                '<tr><th>Prezime i Ime</th><th>Email</th><th>Telefon</th><th>Naziv skole</th><th>Sedište</th><th>Aktivan</th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                        for(var i=0;i<korisnici.length;i++){
                            ispis+='<tr>' +
                            '<td>'+korisnici[i]['prezime']+' '+korisnici[i]['ime']+'</td>' +
                            '<td>'+korisnici[i]['email']+'</td>' +
                            '<td>'+korisnici[i]['telefon']+'</td>' +
                            '<td>'+korisnici[i]['naziv']+'</td>' +
                            '<td>'+korisnici[i]['sediste']+'</td>' +
                            '<td class="aktiv-'+korisnici[i]['id']+'" data-aktivan="'+korisnici[i]['aktivan']+'">'+(korisnici[i]['aktivan']?'<i class="glyphicon glyphicon-ok"></i>':'<i class="glyphicon glyphicon-remove"></i>')+'</td>' +
                            '<td>' +
                                '<a href="#" class="btn btn-sm btn-info" data-toggle="tooltip" title="Ažuriraj" onclick="editKorisnika('+korisnici[i]['id']+')"><span class="glyphicon glyphicon-pencil"></span></a>' +
                                '<a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Promena statusa (ne)aktivan" onclick="ststusKorisnika('+korisnici[i]['id']+')"><span class="glyphicon glyphicon-lock"></span></a>' +
                            '</td>' +
                            '</tr>';
                        }
                        $('#work-place').html(ispis+'</tbody></table>');
                        $('[data-toggle=tooltip]').tooltip();
                    });
        }
        function editKorisnika(korisnik){
            $('#dugmeNovi').hide();
            $('#dugmeUcitaj').fadeIn();
            $('#work-place').html('<center><i class="icon-spin5 animate-spin" style="font-size: 200%;margin-top:80px"></i></center>');
            $.post('/administracija/korisnici/edit-ucitaj',
                    {
                        _token: '{{csrf_token()}}',
                        id: korisnik
                    }, function (data) {
                        noviKorisnik(JSON.parse(data))
                    });
        }
        function ststusKorisnika(korisnik){
            console.log($('.aktiv-'+korisnik).data('aktivan'));
            $('.aktiv-'+korisnik).html('<i class="icon-spin5 animate-spin"></i>');
            $.post('/administracija/korisnici/deaktiviraj',
                    {
                        _token: '{{csrf_token()}}',
                        id: korisnik,
                        aktivan:$('.aktiv-'+korisnik).data('aktivan')
                    }, function (data) {console.log(data);
                        $('.aktiv-'+korisnik).html(data==1?'<i class="glyphicon glyphicon-ok"></i>':'<i class="glyphicon glyphicon-remove"></i>');
                        $('.aktiv-'+korisnik).data('aktivan', data);
                    });
        }
        function pretrazi(){
            ucitajKorisnike($('#pretraga_proizvod').val());
        }
        function sacuvajPodatke(){
            if(SubmitForm.check('hide'))
                Komunikacija.posalji("/administracija/korisnici/azuriraj","hide","poruka","wait","hide");
        }
        function uploadFoto(){
            $('#slikaKorisnika').fileinput('clear');
            $("#slikaKorisnika").fileinput();
            $("#slikaKorisnika").fileinput('refresh',{
                uploadExtraData: {
                    _token:'{{csrf_token()}}',
                    id:$('#id_korisnika').val()
                },
                uploadUrl: '/administracija/korisnici/upload-foto',
                uploadAsync: true,
                maxFileCount: 1,
                allowedFileTypes:['image'],
                msgFilesTooMany: 'Broj selektovanih fotografija ({n}) je veći od dozvoljenog ({m}). Pokušajte ponovo!',
                msgInvalidFileType: 'Neispravan tip fajla "{name}". Dozvoljene su samo fotografije.',
                removeLabel: 'Ukloni'
            });
            $('#uploadSlike').modal();

            $('#slikaKorisnika').on('fileuploaded', function(event, data, previewId, index) {
                var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;
                $('#imgKorisnik').hide();
                $('#imgKorisnik').attr('src','/'+response+'?'+new Date().getTime());
                $('#imgKorisnik').fadeIn();
                $('#imgSrc').val('/'+response);
                $('#uploadSlike').modal('hide');
            });
        }
    </script>

    <div id="work-place"></div>
    <i class='icon-spin5 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
@endsection