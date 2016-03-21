@extends('profesor-admin')

@section('content')
<div class="container">
@if($errors->any())
	<div class="alert alert-success alert-autocloseable-success">
        <h4>{{$errors->first()}}</h4>
	</div>
	<script>
		$(".alert-autocloseable-success").fadeTo(2000, 500).slideUp(500, function(){
		    $(".alert-autocloseable-success").alert('close');
		});
	</script>
@endif

    <div class="row">
        <div class="col-xs-12">
            <div id="myPannel"   class="panel with-nav-tabs">
                <div class="panel-heading">
                    <ul id="myTab" class="myPannel nav nav-tabs">
                    	<li ><a href="#tab0info" data-toggle="tab"><img id="img_roditelji" src="/img/parents-icon.png"></a></li>
                    	<li ><a   href="#tab1info" data-toggle="tab"><img id="img_djaci" src="/img/student-icon.png"></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                    	<div class="tab-pane fade" id="tab1info">{{--Tab djaci--}}
                        	<div  class="form-group has-feedback">
                    			{!!Form::open(['url'=>'/administracija/unos-djaka/novidjak','class'=>'form-horizontal'])!!}
                    			{!!Form::hidden("update_djak",false)!!}
                    			{!!Form::hidden("djak_id",false)!!}	
						        <div class="form-group">
							        {!!Form::label('ldjak','Ђак:',['class'=>'control-label col-sm-1'])!!}
							        <div class="col-sm-3">
							            {!!Form::text('djak_ime',null,['class'=>'form-control','placeholder'=>'Име','id'=>'djak_ime'])!!}
							            <span id="sdjakime" class="glyphicon form-control-feedback"></span>
							        </div>
							        <div class="col-sm-3">
							            {!!Form::text('djak_prezime',null,['class'=>'form-control','placeholder'=>'Презиме','id'=>'djak_prezime'])!!}
							            <span id="sdjakprezime" class="glyphicon form-control-feedback"></span>
							        </div>
							        <div class="col-sm-2">
							        	{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Унеси ђака', ['id'=>'button_unesi','class'=>'btn3d btn btn-sm btn-info ','type'=>'submit'])!!}
							        </div>
							    </div>
							    <div class="form-group">
									{!! Form::label('lroditelji','Изаберите родитеља:',['class'=>'control-label col-sm-3']) !!}
									<div class="col-sm-4">
										{!!Form::select('roditelji',$roditelji_lista,null,['class'=>'form-control'])!!}
									</div>
								</div>
						    	{!!Form::close()!!}
						    </div>
						    <div id="lista_djaka"></div>
                        </div>
                    	<div class="tab-pane fade in active" id="tab0info">{{--Tab roditelji--}}
                    		<div  class="form-group has-feedback">
                    			{!!Form::open(['url'=>'/administracija/unos-djaka/noviroditelj','class'=>'form-horizontal'])!!}
	                    			{!!Form::hidden("update_roditelj",false)!!}
	                    			{!!Form::hidden("roditelj_id",false)!!}	
							        <div class="form-group">
								        {!!Form::label('lnastavnik','Родитељ:',['class'=>'control-label col-sm-3'])!!}
								        <div class="col-sm-3">
								            {!!Form::text('roditelj_ime',null,['class'=>'form-control','placeholder'=>'Име','id'=>'roditelj_ime'])!!}
								            <span id="roditeljime" class="glyphicon form-control-feedback"></span>
								        </div>
								        <div class="col-sm-3">
								            {!!Form::text('roditelj_prezime',null,['class'=>'form-control','placeholder'=>'Презиме','id'=>'roditelj_prezime'])!!}
								            <span id="sroditeljprezime" class="glyphicon form-control-feedback"></span>
								        </div>
								    </div>
								    <div class="form-group">
								        {!!Form::label('lusername','Корисничко име:',['class'=>'control-label col-sm-3'])!!}
								        <div class="col-sm-4">
								            {!!Form::text('korisnicko_ime',null,['class'=>'form-control','placeholder'=>'Корисничко име','id'=>'korisnicko_ime'])!!}
								            <span id="lkorisnickoime" class="glyphicon form-control-feedback"></span>
								        </div>
								        <div class="col-sm-2">
								        	{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Додај родитеља', ['id'=>'button_unesi_roditelja','class'=>'btn3d btn btn-sm btn-info ','type'=>'submit'])!!}
								        </div>
								    </div>
						    	{!!Form::close()!!}
						    </div>
						    <div id="lista_roditelja"></div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<script>
        		$(function(){ucitajDjake();ucitajRoditelje()})
        		function ucitajRoditelje(){
        			$('#lista_roditelja').hide();
        			$('#lista_roditelja').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
					$.post('/administracija/unos-djaka/ucitajroditelje',
                    {
                        _token:'{{csrf_token()}}'
                    },
                    function(data){
                        var roditelji=JSON.parse(data);
                        console.log(roditelji);
                        if(roditelji.length<1){
                            $('#lista_roditelja').html('<h3>Не постоји roditelj у евиденцији!.');
                            return;
                        }
                        var ispis='' +
                                '<table class="table table-condensed">' +
                                '<thead>' +
                                '<tr><th>Ђак</th><th>Родитељ</th><th></th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                        for(var i=0;i<roditelji.length;i++){
                        	if (!roditelji[i]['ime']) {
                        		roditelji[i]['ime']="<div style='background-color:#ed7417'>Nije unešeno</div>";
                        		roditelji[i]['prezime']='';
                        	};
                            ispis+='<tr >' +
                            '<td style="" id="roditelj-'+roditelji[i]['id']+'">'+roditelji[i]['ime']+' '+roditelji[i]['prezime']+'</td>' +
                            '<td style="">'+roditelji[i]['ime_roditelja']+' '+roditelji[i]['prezime_roditelja']+'</td>' +
                            '<td>' +
                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ажурирај" onclick="editRoditelja(\''+roditelji[i]['id']+'\',\''+roditelji[i]['ime_roditelja']+'\',\''+roditelji[i]['prezime_roditelja']+'\')"><span style="font-size: 18px;" class="glyphicon glyphicon-pencil"></span></a> &nbsp' +
                                '<a data-href="/administracija/unos-djaka/obrisiroditelja/'+roditelji[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip"><span style="" class="glyphicon glyphicon-trash"></span></a>' +
                            '</td>' +
                            '</tr>';
							

                        }
                        $('#lista_roditelja').html(ispis+'</tbody></table>');
                        $('#lista_roditelja').fadeIn();
                        $('[data-togglee=tooltip]').tooltip();
						$('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});
						
                    
                    });
        		}
        		function ucitajDjake(){
        			$('#lista_djaka').hide();
        			$('#lista_djaka').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        			$.post('/administracija/unos-djaka/ucitajdjake',
                    {
                        _token:'{{csrf_token()}}'
                    },
                    function(data){
                        var djaci=JSON.parse(data);
                        console.log(djaci);
                        if(djaci.length<1){
                            $('#lista_djaka').html('<h3>Не постоји ђак у евиденцији!.');
                            return;
                        }
                        var ispis='' +
                                '<table class="table table-condensed">' +
                                '<thead>' +
                                '<tr><th>Ђак</th><th>Родитељ</th><th></th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                        for(var i=0;i<djaci.length;i++){
                        	if (!djaci[i]['ime_roditelja']) {
                        		djaci[i]['ime_roditelja']="<div style='background-color:#ed7417'>Nije unešeno</div>";
                        		djaci[i]['prezime_roditelja']='';
                        	};
                            ispis+='<tr >' +
                            '<td style="" id="djak-'+djaci[i]['id']+'">'+djaci[i]['ime']+' '+djaci[i]['prezime']+'</td>' +
                            '<td style="">'+djaci[i]['ime_roditelja']+' '+djaci[i]['prezime_roditelja']+'</td>' +
                            '<td>' +
                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ажурирај" onclick="editDjaka(\''+djaci[i]['id']+'\',\''+djaci[i]['ime']+'\',\''+djaci[i]['prezime']+'\')"><span style="font-size: 18px;" class="glyphicon glyphicon-pencil"></span></a> &nbsp' +
                                '<a data-href="/administracija/unos-djaka/obrisidjaka/'+djaci[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip"><span style="" class="glyphicon glyphicon-trash"></span></a>' +
                            '</td>' +
                            '</tr>';
							

                        }
                        $('#lista_djaka').html(ispis+'</tbody></table>');
                        $('#lista_djaka').fadeIn();
                        $('[data-togglee=tooltip]').tooltip();
						$('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});
						
                    
                    });
				}
				function editRoditelja(id,ime,prezime){
					$('#roditelj_ime').val(ime);
					$('#roditelj_prezime').val(prezime);
					$('input[name=update_roditelj]').val(1);
					$('input[name=roditelj_id]').val(id);
					$("#button_unesi_roditelja").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај податке");
					$('[data-toggle=tooltip]').tooltip();
				}
				function editDjaka(id,ime,prezime){
					$('#djak_ime').val(ime);
					$('#djak_prezime').val(prezime);
					$('input[name=update_djak]').val(1);
					$('input[name=djak_id]').val(id);
					$("#button_unesi").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај податке");
					$('[data-toggle=tooltip]').tooltip();
				}
</script>
        	<script>
        	//script za zadržavanje aktivnog taba
			   $(function() { 
				    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
				    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				        // save the latest tab; use cookies if you like 'em better:
				        localStorage.setItem('lastTab', $(this).attr('href'));
				    });

				    // go to the latest tab, if it exists:
				    var lastTab = localStorage.getItem('lastTab');
				    if (lastTab) {
				        $('[href="' + lastTab + '"]').tab('show');
				    }
				});
			</script>
@endsection