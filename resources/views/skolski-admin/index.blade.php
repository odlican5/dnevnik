@extends('admin-skolski')

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
</div>
    <div class="row">
        <div class="col-xs-12">
            <div id="myPannel" class="panel with-nav-tabs">
                <div class="panel-heading">
                    <ul id="myTab" class=" nav nav-tabs">
                    	<li class="pr"><a href="#tab0info" data-toggle="tab"><img id="img_predmeti" src="/img/cience-class-icon.png"></a></li>
                        <li class="nast" ><a href="#tab1info" data-toggle="tab"><img id="img_nastavnici" src="/img/teacher-icon.png"></a></li>
                        <li class="razredni"><a href="#tab4info" data-toggle="tab"><img id="img_razredni" src="/img/classroom-icon.png"></a></li>
                        <li  class="nast_od"><a href="#tab2info" data-toggle="tab"><img id="img_nast_od" src="/img/classroom-teacher.png"></a></li>
                        <li  class="nast_od"><a href="#tab3info" data-toggle="tab"><img id="img_settings" src="/img/settings-icon.png"></a></li>
                    </ul>
                </div>
                <div  class="panel-body">
                    <div class="tab-content">
                    	<div class="tab-pane fade in active" id="tab0info">{{--Tab predmeti--}}
                    		<div  class="form-group has-feedback">
                    			{!!Form::open(['url'=>'/administracija/nastavniciadmin/novipredmet','class'=>'form-horizontal'])!!}	
						        {!!Form::label('lnazivopredmeta','Предмет:',['class'=>'control-label col-sm-2'])!!}
						        <div class="col-sm-5">
						            {!!Form::text('predmet',null,['class'=>'form-control','placeholder'=>'Назив предмета','id'=>'predmet'])!!}
						            <span id="spredmet" class="glyphicon form-control-feedback"></span>
						        </div>
						        <div class="col-sm-2">
						        	{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Унеси', ['class'=>'btn3d btn btn-sm btn-info','type'=>'submit'])!!}
						        </div>
						    	{!!Form::close()!!}
						    </div>
						    <div id="lista_predmeta"></div>
                    	</div>
                        <div class="tab-pane fade" id="tab1info">{{--Tab nastavnici--}}
                        	<div  class="form-group has-feedback">
                    			{!!Form::open(['url'=>'/administracija/nastavniciadmin/novinastavnik','class'=>'form-horizontal'])!!}
                    			{!!Form::hidden("update_nastavnik",false)!!}
                    			{!!Form::hidden("nastavnik_id",false)!!}	
						        <div class="form-group">
							        {!!Form::label('lnastavnik','Наставник:',['class'=>'control-label col-sm-2'])!!}
							        <div class="col-sm-3">
							            {!!Form::text('nastavnik_ime',null,['class'=>'form-control','placeholder'=>'Име','id'=>'nastavnik_ime'])!!}
							            <span id="snastavnikime" class="glyphicon form-control-feedback"></span>
							        </div>
							        <div class="col-sm-3">
							            {!!Form::text('nastavnik_prezime',null,['class'=>'form-control','placeholder'=>'Презиме','id'=>'nastavnik_prezime'])!!}
							            <span id="snastavnikprezime" class="glyphicon form-control-feedback"></span>
							        </div>
							    </div>
							    <div class="form-group">
									{!! Form::label('maticni_broj','Корисничко име:',['class'=>'control-label col-sm-2']) !!}
									<div class="col-sm-3">
							            {!!Form::text('korisnicko_ime',null,['class'=>'form-control','placeholder'=>'Корисничко име','id'=>'korisnicko_ime'])!!}
							            <span id="sматицниброј" class="glyphicon form-control-feedback"></span>
							        </div>
									
								</div>
						        <div class="form-group">
									{!! Form::label('nalog','Предмет',['class'=>'control-label col-sm-2']) !!}
									<div class="col-sm-4">
										{!!Form::select('predmeti',$predmeti,null,['class'=>'form-control'])!!}
									</div>
									 <div class="col-sm-2">
							        	{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Додај наставника', ['id'=>'button_unesi','class'=>'btn3d btn btn-sm btn-info ','type'=>'submit'])!!}
							        </div>
								</div>
						       
						    	{!!Form::close()!!}
						    </div>
						    <div id="lista_nastavnika"></div>
                        </div>
                        <div class="tab-pane fade" id="tab4info">{{--Tab odeljenja razredni--}}
                        	<div class="panel panel-default tbbl">
							  	<div class="panel-body tbbl">
							    	<table style="background-color : transparent" class="table table-condensed tbbl">
		                                <thead>
		                                	<tr><th>Разред</th><th>Одељење</th><th>Изаберите разредног</th><th></th></tr>
		                                </thead>
		                                <tbody>
		                                	<tr>
		                                	{!!Form::open(['url'=>'/administracija/nastavniciadmin/dodaj-razrednog','class'=>'form-horizontal'])!!}	
		                                	{!!Form::hidden("update_id",false)!!}
		                                	{!!Form::hidden("odeljenje_id",false)!!}
		                                	<th>{!!Form::text('razred',null,['class'=>'form-control','placeholder'=>'Разред','id'=>'razred'])!!}</th>
		                                	<th>{!!Form::text('odeljenje',null,['class'=>'form-control','placeholder'=>'Одељење','id'=>'odeljenje'])!!}</th>
		                                	<th>
		                                		{!! Form::select('razredni',$nastavnici,null,['id'=>'razredni_s','class' => 'form-control'])!!}
		                                	</th>
		                                	<th>
		                                		{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Додај одељење и разредног', ['id'=>'button_od_raz','class'=>'btn3d btn btn-sm btn-info','type'=>'submit'])!!}
		                                	</th>
		                                	<th></th>
		                                	{!!Form::close()!!}
		                                	</tr>
		                                </tbody>
		                            </table>
							  	</div>
							</div>
							<div  id="lista_razrednih"></div>
                        </div>
                        <div class="tab-pane fade" id="tab2info">
                        	<div class="panel panel-default tbbl">
							  	<div class="panel-body">
							    	<table class="table table-condensed tbbl">
		                                <thead>
		                                	<tr><th>Разред/Одељење</th><th>Наставници по одељењима</th><th></th><th></th></tr>
		                                </thead>
		                                <tbody>
		                                	<tr>
		                                	{!!Form::open(['url'=>'/administracija/nastavniciadmin/nastavnicipoodeljenjima','class'=>'form-horizontal'])!!}	
		                                	<th>{!!Form::select('razredi',$razredi,null,['class'=>'form-control'])!!}</th>
		                                	<th>
		                                		{!! Form::select('nastavnici_po_odeljenjima[]',$nastavnici,null,['class' => 'form-control','multiple' => 'multiple'])!!}
		                                	</th>
		                                	<th>
		                                		{!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Додај наставнике и одељења', ['class'=>'btn3d btn btn-sm btn-info','type'=>'submit'])!!}
		                                	</th>
		                                	<th></th>
		                                	{!!Form::close()!!}
		                                	</tr>
		                                </tbody>
		                            </table>
							  	</div>
							  	
							</div>
							<div class="panel panel-default tbbl">
							  	<div class="panel-body">
							    	<div id="lista_nastavnici_po_odeljenjima"></div>
							  	</div>
							</div>
                        </div>
                        <div class="tab-pane fade" id="tab3info">
                        	<div class="panel panel-default tbbl">
							  	<div class="panel-body">
							    	<div class="about-section">
									   <div class="text-content">
									     <div class="span7 offset1">
									        @if(Session::has('success'))
									          <div class="alert-box success">
									          <h2>{!! Session::get('success') !!}</h2>
									          </div>
									        @endif
									        <div class="secure">Унеси слику</div>
									        {!! Form::open(array('url'=>'/administracija/nastavniciadmin/obavestenje','method'=>'POST', 'files'=>true)) !!}
										        {!!Form::hidden('_token',csrf_token())!!}
										        {!!Form::hidden('update_flag',false)!!}
										         <div class="control-group">
										          	<div class="controls">
											          	{!! Form::file('image') !!}
													  	<p class="errors">{!!$errors->first('image')!!}</p>
														@if(Session::has('error'))
															<p class="errors">{!! Session::get('error') !!}</p>
														@endif
										        	</div>
										        </div>
										        <div id="success"> </div>
										        <textarea id="id_obavestenje" name="obavestenje" style="width:100%"></textarea>
										        {!!Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Сачувај', ['id'=>'azuriraj_btn','class'=>'btn3d btn btn-sm btn-info','type'=>'submit'])!!}
									      	{!! Form::close() !!}
									      </div>
									   </div>
									</div>
							  	</div>
                        </div>
                        <div id="lista_obavestenja"></div>
                    </div>
                    <script type="text/javascript">
				        tinymce.init({
				            selector: "textarea",
				            theme: "modern",
				            plugins: [
				                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
				                "searchreplace wordcount visualblocks visualchars code fullscreen",
				                "insertdatetime media nonbreaking save table contextmenu directionality",
				                "emoticons template paste textcolor colorpicker textpattern"
				            ],
				            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				            toolbar2: "print preview media | forecolor backcolor emoticons",
				            image_advtab: true,
				            templates: [
				                {title: 'Test template 1', content: 'Test 1'},
				                {title: 'Test template 2', content: 'Test 2'}
				            ]
				        });
				    </script>
                </div>
            </div>
        </div>
	</div>
</div>
				<script>
        		$(function(){ucitajPredmete();ucitajNastavnike();ucitajRazredne(),ucitajNastavnikepoodeljenjima(),ucitajObavestenja()})
        		function ucitajObavestenja(){
        			$('#lista_obavestenja').hide();
        			$.post('/administracija/nastavniciadmin/ucitajobavestenja',{
        				_token:'{{csrf_token()}}'
        			},function(data){
        				var ob=JSON.parse(data);
        				console.log(ob);
        				if(ob<1){
                            $('#lista_obavestenja').html('<h3>Ne postoje obavestenja.');
                            return;
                        }
                        var ispis='';
                            for(var i=0;i<ob.length;i++){
	                            ispis+='<div class="row">'+
						        	'<div class="col-sm-3">'+
						        		'<img style="width: 100%;max-height: 200px;" class="img-responsive img-thumbnail" src="img_skole'+ob[i]['url']+'" alt="">'+
						        	'</div>'+
						        	'<div class="col-sm-7">'+
						    	    		'<p style="color: #26C1D6;" class=" pull-left"><span class="glyphicon glyphicon-time"></span> Објављено '+ob[i]['created_at']+'</p>'+
						    	        '<br><br>'+
						    	        '<p style="text-align: left;" >'+ob[i]['obavestenje']+'</p>'+
						            '</div>'+
						            '<div class="col-sm-2">'+
						        		'<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ажурирај" onclick="editObavestenja('+ob[i]['id']+')"><span style="font-size: 18px;" class="glyphicon glyphicon-pencil"></span></a> &nbsp' +
	                                	'<a data-href="/administracija/nastavniciadmin/obrisiobavestenje/'+ob[i]['id']+'"  class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip"><span style="" class="glyphicon glyphicon-trash"></span></a>' +
						        	'</div>'+
						        '</div><hr>';
								$('#lista_obavestenja').html(ispis);
                        		$('#lista_obavestenja').fadeIn();
                        		 $('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});
	                        }
        			});
        		}
        		function ucitajNastavnikepoodeljenjima(){
        			$('#lista_nastavnici_po_odeljenjima').hide();
        			$('#lista_nastavnici_po_odeljenjima').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        			$.post('/administracija/nastavniciadmin/ucitajnastpood',{
        				_token:'{{csrf_token()}}'
        			},function(data){
        				var nast_po_od=JSON.parse(data);
        				console.log(nast_po_od);
        				if(nast_po_od.length<1){
                            $('#lista_nastavnici_po_odeljenjima').html('<h3>Ne postoji ni jedan predmet u evidenciji.');
                            return;
                        }
                        var ispis='' +
                                '<table style="width:100%; ">' +
                                '<thead>' +
                                '<tr><th>Разред</th><th>Одељење</th><th>Наставник</th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                            for(var i=0;i<nast_po_od.length;i++){
	                            ispis+='<tr >' +
	                            '<td style="" id="predmet-'+nast_po_od[i]['id']+'">'+nast_po_od[i]['razred']+'</td>' +
	                            '<td style="">'+nast_po_od[i]['odeljenje']+'</td>' +
	                            '<td style="">'+nast_po_od[i]['ime_prezime']+'</td>' +
	                            '<td>' +
	                                '<a  data-href="/administracija/nastavniciadmin/obrisinastavnikepood/'+nast_po_od[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip"><span style="font-size:10px;" class="glyphicon glyphicon-trash"></span></a>' +
	                            '</td>' +
	                            '</tr>';
								$('#lista_nastavnici_po_odeljenjima').html(ispis+'</tbody></table>');
                        		$('#lista_nastavnici_po_odeljenjima').fadeIn();

	                        }
	                        $('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});

        			});

        		}
        		function editObavestenja(id){
        			//$('#id_obavestenje').text(obavestenje);
        			//$(tinymce.get('obavestenje').getBody()).html('<p>This is my new content!</p>');
        			
        			//tinyMCE.get('obavestenje').setContent(ob);
        			$('input[name=update_flag]').val(id);
        			$("#azuriraj_btn").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај податке");
        			$.post('/administracija/nastavniciadmin/editobavestenja', 
        			{
        				_token:'{{csrf_token()}}',
        				id:id
        			}, function(data){
        				var od=JSON.parse(data);
        				console.log(od);
        				tinyMCE.activeEditor.setContent(od[0]['obavestenje']);
        			});
        		}
        		function ucitajPredmete(){
        			$('#lista_predmeta').hide();
        			$('#lista_predmeta').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        			$.post('/administracija/nastavniciadmin/ucitaj',
                    {
                        _token:'{{csrf_token()}}'
                    },
                    function(data){
                        var korisnici=JSON.parse(data);
                        console.log(korisnici);
                        if(korisnici.korisnici.length<1){
                            $('#lista_predmeta').html('<h3>Ne postoji ni jedan predmet u evidenciji.');
                            return;
                        }
                        var ispis='' +
                                '<table class="table table-condensed ">' +
                                '<thead>' +
                                '<tr><th>Предмет</th><th>Наставник</th><th></th><th></th></tr>' +
                                '</thead>' +
                                '<tbody>';
                        for(var i=0;i<korisnici.korisnici.length;i++){
                        	if (!korisnici.korisnici[i]['ime']) {
                        		korisnici.korisnici[i]['ime']="<div style='background-color:#ed7417'>Није унето!</div>";
                        		korisnici.korisnici[i]['prezime']='';
                        	};
                            ispis+='<tr >' +
                            '<td style="" id="predmet-'+korisnici.korisnici[i]['id']+'">'+korisnici.korisnici[i]['predmeti']+'</td>' +
                            '<td style="">'+korisnici.korisnici[i]['ime']+' '+korisnici.korisnici[i]['prezime']+'</td>' +
                            '<td>' +
                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ажурирај" onclick="editPredmeta(\''+korisnici.korisnici[i]['id']+'\',\''+korisnici.korisnici[i]['predmeti']+'\')"><span style="font-size: 18px;" class="glyphicon glyphicon-pencil"></span></a> &nbsp' +
                                '<a data-href="/administracija/nastavniciadmin/obrisipredmet/'+korisnici.korisnici[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip"><span style="" class="glyphicon glyphicon-trash"></span></a>' +
                            '</td>' +
                            '</tr>';
							

                        }
                        $('#lista_predmeta').html(ispis+'</tbody></table>');
                        $('#lista_predmeta').fadeIn();
                        $('[data-togglee=tooltip]').tooltip();
						$('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});
						
                        //$('[data-toggle=tooltip]').tooltip();
                    });

        		}
        		function ucitajNastavnike(){
        			$('#lista_nastavnika').hide();
        			$('#lista_nastavnika').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        			$.post('/administracija/nastavniciadmin/ucitajnastavnike',
        					{
        						_token:'{{csrf_token()}}'
        					},
        					function(data){
		                        var nastavnici=JSON.parse(data);
		                        console.log(nastavnici);
		                        if(nastavnici.length<1){
		                            $('#lista_nastavnika').html('<h3>Не постоји предмет у евиденцији!.');
		                            return;
		                        }
		                        var ispis='' +
		                                '<table class="table table-condensed">' +
		                                '<thead>' +
		                                '<tr><th>Наставници</th><th>Предмети</th><th></th></tr>' +
		                                '</thead>' +
		                                '<tbody>';
		                        for(var i=0;i<nastavnici.length;i++){
		                            ispis+='<tr>' +
		                            '<td id="'+nastavnici[i]['id']+'">'+nastavnici[i]['ime']+' '+nastavnici[i]['prezime']+'</td>' +
		                             '<td id="">'+nastavnici[i]['naziv_predmeta']+'</td>' +
		                            '<td>'+
		                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ажурирај" onclick="izmeniNastavnika(\''+nastavnici[i]['id']+'\' , \''+nastavnici[i]['ime']+'\',\''+nastavnici[i]['prezime']+'\',\''+nastavnici[i]['predmet_id']+'\',\''+nastavnici[i]['username']+'\')"><span style="" class="glyphicon glyphicon-pencil"></span></a>&nbsp' +
		                                '<a data-href="/administracija/nastavniciadmin/obrisinastavnika/'+nastavnici[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip" ><span style="" class="glyphicon glyphicon-trash"></span></a>' +
		                            '</td>' +
		                            '</tr>';
		                        }
		                        $('#lista_nastavnika').html(ispis+'</tbody></table>');
		                        $('#lista_nastavnika').fadeIn();
		                        $('[data-togglee=tooltip]').tooltip();
		                        $('[data-toggle="confirmation"]').confirmation({
									placement: 'left',
									singleton: true,
									popout: true,
									title: 'Да ли сте сигурни?',
									btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',
									btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Обриши',
								});
		                    }
        				);
				}
				function ucitajRazredne(){
					$('#lista_razrednih').hide();
        			$('#lista_razrednih').html('<center><i class="icon-spin5 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        			$.post('/administracija/nastavniciadmin/ucitajrazredne',
        					{
        						_token:'{{csrf_token()}}'
        					},
        					function(data){
		                        var razredni=JSON.parse(data);
		                        console.log(razredni);
		                        if(razredni.length<1){
		                            $('#lista_razrednih').html('<h3>Ne postoji ni jedan predmet u evidenciji.');
		                            return;
		                        }
		                        var ispis='' +
		                                '<table class="table table-condensed">' +
		                                '<thead>' +
		                                '<tr><th>Разред</th><th>Одељење</th><th>Разредни</th><th></th><th></th></tr>' +
		                                '</thead>' +
		                                '<tbody>';
		                        for(var i=0;i<razredni.length;i++){
		                            ispis+='<tr>' +
		                            '<td id="raz-'+razredni[i]['id']+'">'+razredni[i]['razred']+'</td>' +
		                            '<td id="od-'+razredni[i]['id']+'">'+razredni[i]['odeljenje']+'</td>' +
		                            '<td id="razredni-'+razredni[i]['id']+'">'+razredni[i]['ime']+'</td>' +
		                            '<td>'+
		                                '<a href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Ažuriraj" onclick="izmeniRazred(\''+razredni[i]['id']+'\' , \''+razredni[i]['razred']+'\',\''+razredni[i]['odeljenje']+'\', \''+razredni[i]['id_nast']+'\')"><span style="font-size: 18px;" class="glyphicon glyphicon-pencil"></span></a>&nbsp' +
		                                '<a data-href="/administracija/nastavniciadmin/obrisirazredodeljenje/'+razredni[i]['id']+'" class="btn3d btn btn-xs btn-danger" data-toggle="confirmation" data-togglee="tooltip" ><span style="" class="glyphicon glyphicon-trash"></span></a>' +
		                            '</td>' +
		                            '</tr>';
		                        }
		                        $('#lista_razrednih').html(ispis+'</tbody></table>');
		                        $('#lista_razrednih').fadeIn();
		                        $('[data-toggle=tooltip]').tooltip();
		                        $('[data-toggle="confirmation"]').confirmation({
									placement: 'left',
									singleton: true,
									popout: true,
									title: 'Да ли сте сигурни?',
									btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',
									btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Обриши',
								});
		                    }
        				);
				}
				function izmeniRazred(id,razred,odeljenje,id_nast){
					$('#razred').val($('#raz-'+id).text());
					$('#odeljenje').val($('#od-'+id).text());
					$('#razredni_s').val(id_nast);
					$("#button_od_raz").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај податке");
					$('input[name=update_id]').val(1);
					$('input[name=odeljenje_id]').val(id);
					$('[data-toggle=tooltip]').tooltip();
				}
				//funkcije za predmete
				function editPredmeta(id,predmet){
					$('#predmet-'+id).html('<input name="pred-in-'+id+'" value="'+predmet+'"">&nbsp<a id="linkpr-'+id+'" href="#" class="btn3d btn btn-xs btn-info" data-toggle="tooltip" title="Сачувај" onclick="izmeniubazipredmet(\''+id+'\' )"><span style="font-size: 18px;" class="glyphicon glyphicon-ok"></span></a>');
					$('[data-toggle=tooltip]').tooltip();
				}
				function izmeniubazipredmet(id){
					var pred=$('input[name=pred-in-'+id+']').val();
					$.post('/administracija/nastavniciadmin/izmeniubazipredmet',
						{
							_token:'{{csrf_token()}}',
							id:id,
							name:pred,
						},	function(id){
							$('#linkpr-'+id).hide();	
							pred=$('input[name=pred-in-'+id+']').val();
							$('#predmet-'+id).empty();
							$('#predmet-'+id).append(pred);	
						}
						);
				}
				//funkcije za predmete
				function izmeniNastavnika(id,ime,prezime,predmet,username){
					$('#nastavnik_ime').val(ime);
					$('#nastavnik_prezime').val(prezime);
					$('#korisnicko_ime').val(username);
					$('select[name=predmeti]').val(predmet);
					$("#button_unesi").html("<span class='glyphicon glyphicon-pencil'></span> Ажурирај податке");

					$('input[name=update_nastavnik]').val(1);
					$('input[name=nastavnik_id]').val(id);
					$('[data-toggle=tooltip]').tooltip();
				}
				function izmeniubazinastavnika(id){
					var name=$('input[name=inp-'+id+']').val();
					$.post('/administracija/nastavniciadmin/izmeniubazinastavnika',
						{
							_token:'{{csrf_token()}}',
							id:id,
							name:name,
						},	function(id){
							$('#link-'+id).hide();
							
							name=$('input[name=inp-'+id+']').val();
							$('#'+id).empty();
							$('#'+id).append(name);
							
						}
						);
				}
				function obrisiNastavnika(data){
					console.log(data);
				}
        		</script>
        	<script>//script za zadržavanje aktivnog taba
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