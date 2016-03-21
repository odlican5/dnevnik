@extends ('roditelj')

@section('content')
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-4">
			<div style="background:#00BCD4; border-radius: 7px; color:white; height:100px; -webkit-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);-moz-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);" class="well well-sm">
				<div style="color:#7FDDE9; " class="pull-left"><img style="width:50px" src="/img/prisustvo.png"> Број неоправданих часова:</div>
				<div  class=" well_izostanci text-right">{{$izostanci['neopravdano']}}</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div style="background:#009688;border-radius: 7px; color:white; height:100px; -webkit-box-shadow: inset 0px 0px 51px -1px rgba(2,71,64,1);
-moz-box-shadow: inset 0px 0px 51px -1px rgba(2,71,64,1);
box-shadow: inset 0px 0px 51px -1px rgba(2,71,64,1);" class="well well-sm">
				<div style="color:#7FCAC3; " class="pull-left"><img style="width:50px" src="/img/neopravdan.png"> Укупно изостанака:</div>
				<div  class="well_izostanci text-right">{{$izostanci['ukupno']}}</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div style="background:#FF5722;border-radius: 7px; color:white; height:100px;-webkit-box-shadow: inset 0px 0px 51px -1px rgba(168,43,5,1);
-moz-box-shadow: inset 0px 0px 51px -1px rgba(168,43,5,1);
box-shadow: inset 0px 0px 51px -1px rgba(168,43,5,1);" class="well well-sm">
				<div style="color:#FFAA90; " class="pull-left"><img style="width:50px" src="/img/average.png">Просек закључених оцена:</div>
				<div  class="well_izostanci text-right">{{round($prosek,2)}}</div>
			</div>
		</div>
	</div>
</div>

<div class="col-sm-3">    
{{-- Leva kolona pregled predmeta --}}
    <div class="row">
        <ul style="list-style-type:none;">
       
        @foreach($predmeti as $predmet)
        	 <li>
        	 	<a href="#" onclick="UcitajOcene({{$predmet['id']}})" style="width:75%" class="btn3d btn btn-sm btn-info " data-toggle="tooltip">{{ucfirst($predmet['naziv'])}}</a>
        	 </li>
        @endforeach
        
        </ul>
    </div>
    <div class="row">
        <div id="left-djaci"></div>
        <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
    </div>
    <script>
    function UcitajOcene(id){
		$('#work-place').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
    	$.post('/administracija/roditelj/ucitaj-pregled',
    		{
    			id: id,
    			_token: '{{csrf_token()}}'
    		},function(data){
    			
    			
    			var podaci=JSON.parse(data);
    			console.log(podaci);
                //console.log(podaci.po_predmetima[0]['naziv']);
                 // console.log(podaci.zakljucne[0]['zakljucna']);
                    var zakl=''+
                        '<div style="background:#00BCD4; border-radius: 7px; padding:3px 5px; color:white;  -webkit-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);-moz-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);" >'+
                           ' <div style="color:white; " class="pull-left">'+
                            '<img style="width:30px" src="/img/badge-icon.png"> Закључна оцена:</div>'+
                            '<br><br><div style="font-size:16px;" class="text-left"> - I - полугодиште: '+podaci.zakljucna_prvo[0]['ocene']+'</div>'+
                            '<div style="font-size:16px;" class="text-left"> - II - полугодиште: '+podaci.zakljucna_kraj[0]['ocene']+'</div>'+
                        '</div>';
              
                 $('#zakljucna').html(zakl);
                 $('#zakljucna').hide();
                $('#zakljucna').fadeIn();

                if (podaci.po_predmetima.length>0) 
                {
        			var ispisi=''+
                    '<div style="background:#00BCD4; border-radius: 7px; padding:3px 5px; color:white;  -webkit-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);-moz-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);" >'+
                        '<div class=" text-left"><strong>Предмет: '+podaci.po_predmetima[0]['naziv']+'</strong></div>'+ 
                        '<div class=" text-left"><strong>Професор: '+podaci.po_predmetima[0]['ime']+' '+podaci.po_predmetima[0]['prezime']+'</strong></div>'+

                             
                    '</div><br>'+
                        '<div class="table-responsive">'+
                          '<table style="width:100%">'+
                          '<thead>'+
                          '<th>Датум</th><th>Оцена</th><th>Запажање</th><thead>';
                    // console.log(podaci);
                        
                   for(var i=0;i<podaci.po_predmetima.length;i++)
                   {
                        ispisi+='<tr style=" border-bottom:1px solid white;">' +
                        '<td ><img style="width:30px" data-toggle="tooltip" title="'+podaci.po_predmetima[i]['created_at']+'" src="/img/time.png"></td>' +
                        '<td >'+podaci.po_predmetima[i]['ocene']+'</td>' +
                        '<td >'+podaci.po_predmetima[i]['zapazanje']+'</td>' +
                        '</tr>';
                   }
                       
                }//if 
                else{ispisi='<h4 >Нема оцена из изабраног предмета!</h4>';}       
                $('#work-place').html(ispisi+'</table></div></div>');
                $('#work-place').hide();
				$('#work-place').fadeIn();
                $('[data-toggle=tooltip]').tooltip();
    		}//function
    		);
    }
    function UcitajNoveocene(id, predmet_id){//ucitavanje neprocitanih ocena
        $('#work-place').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
        $.post('/administracija/roditelj/ucitaj-preglednovi',
            {
                id: id,
                predmet_id: predmet_id,
                _token: '{{csrf_token()}}'
            },function(data){              
                var podaci=JSON.parse(data);
                 var zakl=''+
                        '<div style="background:#00BCD4; border-radius: 7px; padding:3px 5px; color:white;  -webkit-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);-moz-box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);box-shadow: inset 0px 0px 51px -1px rgba(8,99,109,1);" >'+
                           ' <div style="color:white; " class="pull-left">'+
                            '<img style="width:30px" src="/img/badge-icon.png"> Закључна оцена:</div>'+
                            '<br><br><div style="font-size:16px;" class="text-left"> - I - полугодиште: '+podaci.zakljucna_prvo[0]['ocene']+'</div>'+
                            '<div style="font-size:16px;" class="text-left"> - II - полугодиште: '+podaci.zakljucna_kraj[0]['ocene']+'</div>'+
                        '</div>';
                 $('#zakljucna').html(zakl);
                 $('#zakljucna').hide();
                $('#zakljucna').fadeIn();

                if (podaci.po_predmetima.length>0) 
                {
                    var ispisi=''+
                    '<div class="col-sm-12">'+
                    '<div class="row text-center"><strong>'+podaci.po_predmetima[0]['naziv']+'</strong>'+         
                    '</div><br>'+
                        '<div class="table-responsive">'+
                          '<table style="width:100%">'+
                          '<thead>'+
                          '<th>Датум</th><th>Оцена</th><th>Запажање</th><thead>';
                    // console.log(podaci);
                        
                   for(var i=0;i<podaci.po_predmetima.length;i++)
                   {
                        ispisi+='<tr style=" border-bottom:1px solid white;">' +
                        '<td><img style="width:30px" data-toggle="tooltip" title="'+podaci.po_predmetima[i]['created_at']+'" src="/img/time.png"></td>'+
                        '<td >'+podaci.po_predmetima[i]['ocene']+'</td>' +
                        '<td >'+podaci.po_predmetima[i]['zapazanje']+'</td>' +
                        '</tr>';
                   }
                       
                }//if 
                else{ispisi='<h4 >Нема оцена из изабраног предмета!</h4>';}       
                $('#work-place').html(ispisi+'</table></div></div>');
                $('#work-place').hide();
                $('#work-place').fadeIn();
                $('[data-toggle=tooltip]').tooltip();
            }//function
            );

    }
    </script>
</div>
<div class="col-sm-6">{{--  --}}
    <div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Имате 6 непрочитаних порука</h4>
    </div>
    <div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><tr><h4>Нове оцене!</h4></tr>
        <table class="table table-condensed">@foreach(\App\Metode::nove_ocene_provera(Session::get('id')) as $noveocene) <tr><td><a href='#' onclick='UcitajNoveocene({{$noveocene['id']}},{{$noveocene['id_predmeti']}})'>{{$noveocene['naziv']}}</a></td><td>{{$noveocene['ocene']}}</td><td>{{$noveocene['created_at']}}</td></tr> @endforeach </table>
    </div>
    <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Имате {{App\Metode::broj_neopravdanih(Session::get('id'))}} нових неоправданих часова!</h4>

    </div>
    
    <div id="work-place"></div>
    <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
</div>
<div class="col-sm-3">
    <div id="zakljucna"></div>
    <div id="poruka"></div>
</div>
@endsection