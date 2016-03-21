{{-- Lista mailova poslatih i primljenih prikaz roditelju--}}
@extends('roditelj')

@section('content')

	<div class="list-group col-sm-4">{{-- Lista mailova poslatih i primljenih --}}
	<!-- Nav tabs -->
		<div id="myTab">
			<ul class="nav nav-tabs" role="tablist">
				<li class="tbl" role="presentation" ><a class="tbl" href="#poslate" aria-controls="poslate" role="tab" data-toggle="tab"><img id="img_poslate" src="/img/email-send-icon.png"></a></li>
				<li role="presentation" ><a href="#primljene" aria-controls="primljene" role="tab" data-toggle="tab"><img id="img_primljene" src="/img/email-receive-icon.png"></a></li>
			</ul>
		   	<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade " id="poslate">
					<div  style="overflow-y:auto; padding-top:5px; max-height: 620px;min-heigh:120px; ">  	
				    	@foreach($poruke['poslate'] as $por)
					    	<a id='link-{{$por['id']}}' onclick="displaymail({!!$por['id']!!})" style="cursor: pointer; " class="list-group-item" href="#">
						    	<div style="color:#757575; margin:5px; height:50px; " class="row">
						    		<strong><h4 style="color:#31B0D5">Primalac: {!!$por['ime']!!} <span style="font-size:12px;" class="pull-right">{!!$por['datum']!!}</span></h4></strong>
						    		
						    		<div style="font-size:18px;"  class="pull-left">{{App\Metode::limit_text($por['poruka'],5)}}</div>
						    		<br>
						    		
						    	</div>
					    	</a>
					    	
				    	@endforeach
				    </div>
				</div>{{-- end tabpannel --}}
				
			    <div role="tabpanel" class="tab-pane fade in active" id="primljene">
			   		<div  style="overflow-y:auto; padding-top:5px; max-height: 620px;min-heigh:120px;" >  	
				    	@foreach($poruke['primljene'] as $por)
					    	<a id='link-{{$por['id']}}' onclick="displaymailprimljene({!!$por['id']!!})" style="cursor: pointer; " class="list-group-item" href="#">
						    	<div style="color:#757575; margin:5px; height:50px; " class="row">
						    		<div>
						    		<strong><h5 style="color:#31B0D5">Poslao: {!!$por['ime']!!} <span style="font-size:12px;" class="pull-right">{!!$por['datum']!!}</span></h5></strong>
						    		</div>
						    		@if($por['procitano']==0)
						    			<strong><i><p id='p-{{$por['id']}}' style="font-size:18px;color:#5b5858;"  class="pull-left">{{App\Metode::limit_text($por['poruka'],5)}}</p></i></strong>
						    		@else 
						    		<div style="font-size:18px; margin-top:0px; "  class="pull-left">{{App\Metode::limit_text($por['poruka'],5)}}</div>
						    		@endif	
						    		
						    		<br>
						    		
						    	</div>
					    	</a>
				    	@endforeach
				    </div>
			    </div>{{--  end tab panel--}}
		  	</div>{{-- end tab content --}}
 		</div>{{-- end div --}}
	    <i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
	</div>{{-- end col-sm-4 --}}
	<div id="mail" >
		<div style=" height:620px; box-shadow: 0 -20px 15px -15px #888, 15px 0px 15px -15px #888, -15px 0px 15px -20px #888; border-radius:10px;"  class="col-sm-8">
			<div style="margin-top:20px;">
				<div class="text-center">
					Izaberite poruku
				</div>
			</div>
			<br>		
		</div>
	<i class='icon-spin4 animate-spin' style="font-size: 1px;color:rgba(0,0,0,0)"></i>
	</div>
	<script>
	function displaymail(id){//prikazi poslate
		$('#mail').hide();
		 $('#mail').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
		$.post('/administracija/poruke/current-message',
		    		{
		    			_token: '{!! csrf_token() !!}',
		    			id: id
		    		},function(data){
		    				var data=JSON.parse(data);
		    				//$('#mail').hide();
							$('#mail').html('' +
								'<div style="height:620px; border-bottom:none; box-shadow:0 -20px 15px -15px #888, 15px 0px 15px -15px #888, -15px 0px 15px -20px #888; border-radius:10px;"  class="col-sm-8">'+
									'<div style="margin-top:20px;">'+
										'<a type="button" data-id='+data[0].posiljalac_id+'  data-tooltip="true" data-toggle="modal" data-target="#myModal" title="Pošalji poruku" class="btn btn-info btn-circle btn-xl"><i class="glyphicon glyphicon-pencil"></i></a> &nbsp'+
										'<a type="button" onclick="obrisiPoruku('+data[0].id+')" data-tooltip="true" title="Obriši poruku" class="btn btn-danger btn-circle btn-xl"><i class="glyphicon glyphicon-remove"></i></a>'+
											'<a  href=""><span style="margin-top:5px;" class="pull-right glyphicon glyphicon-option-vertical"></span></a>'+
									'<div>'+
									'<br>'+
									'<div style="color:white;" class="line-separator"></div>'+
									'<br>'+
									'<div style="margin-left:5px;" class="text-left">'+ data[0].poruka +'</div>'+
								'</div>'+
								'<br>');
		    			});
		$('#mail').fadeIn();			
	}
	function displaymailprimljene(id){//prikazi primljene
		$('#mail').hide();
		$('#mail').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
		$('#p-'+id).fadeOut();
		$('#p-'+id).css({ 'font-weight': 'normal' });
		$('#p-'+id).css('font-style', 'normal');
		$('#p-'+id).fadeIn();
		$.post('/administracija/poruke/primljene',
		    		{
		    			_token: '{!! csrf_token() !!}',
		    			id: id
		    		},function(data){
		    				var data=JSON.parse(data);
							$('#mail').html('' +
								'<div style=" height:620px; box-shadow: 0 -20px 15px -15px #888, 15px 0px 15px -15px #888, -15px 0px 15px -20px #888; border-radius:10px;"  class="col-sm-8">'+
									'<div style="margin-top:20px;">'+
										'<a type="button" data-id='+data[0].posiljalac_id+' data-tooltip="true" data-toggle="modal" data-target="#myModal" title="Odgovori" class=" open-Dialog btn btn-info btn-circle btn-xl"><i class="glyphicon glyphicon-share-alt"></i></a> &nbsp'+
										'<a type="button" onclick="obrisiPoruku('+data[0].id+')" data-tooltip="true" title="Obriši poruku"  class="btn btn-danger btn-circle btn-xl"><i class="glyphicon glyphicon-remove"></i></a>'+
											'<a  href=""><span style="margin-top:5px;" class="pull-right glyphicon glyphicon-option-vertical"></span></a>'+
									'<div>'+
									'<br>'+
									'<div class="line-separator"></div>'+
									'<br>'+
									'<div style="margin-left:5px;" class="text-left">'+ data[0].poruka +'</div>'+
								'</div>'+
								'<br>');
		    			});
		$('#mail').fadeIn();			
	}
	//prosledjiavnje posiljalac_id modalu  za odgovor 
	$(document).on("click", ".open-Dialog", function () {
     var messageID = $(this).data('id');
     $(".modal-body #messageID").val( messageID );
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
	function obrisiPoruku(id){
		$('#mail').hide();	
		//$('#link-'+id).fadeOut();
		$('#link-'+id).fadeOut();
		$('#mail').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
		$.post('/administracija/poruke/obrisi-poruku',
		{
			_token:'{!! csrf_token() !!}',
			id: id
		},function(){
			$('#mail').html('<center><i class="icon-spin4 animate-spin" style="font-size: 100%;margin-top:80px"></i></center>');
			$('#mail').html(''+
				'<div style=" height:620px; box-shadow: 0 -20px 15px -15px #888, 15px 0px 15px -15px #888, -15px 0px 15px -20px #888; border-radius:10px;"  class="col-sm-8">'+
					'<div style="margin-top:20px;">'+
						'<div class="text-center" id="mail">Izaberite poruku</div>'+
					'<div>'+
					'<br>'+			
				'</div>');
			$('#mail').fadeIn();
		}
			);
	}
	</script>
<!--  Modal -->	
	<div class=" modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div style="width:100%; border-top:5px solid #269ABC; opacity: 0.85; background: url(/img/bg2.jpg) no-repeat center center fixed;" class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove"></span></button>
	        <h4 class="modal-title" id="myModalLabel">Kontaktiraj roditelja!</h4>
	      </div>
	      <div class="modal-body">
	        <div id="vrti" style="display:none"><center><i class='icon-spin4 animate-spin' style="font-size: 200%"></i></center></div>
	        <div id="poruka" style="display:none"></div>
	        <div id="forma" class="form-horizontal">
	        	{!! Form::hidden('_token',csrf_token()) !!}
	        	<input type="hidden" name="messageID" id="messageID" value="" />
	            <textarea name="poruka" style="width:100%"></textarea>
	        </div>
	      </div>
	      <div class="modal-footer">
	        {!! Form::button('<span class="glyphicon glyphicon-remove"></span>&nbsp Otkaži',['class'=>'btn btn-sm btn-warning','data-dismiss'=>'modal']) !!}
	        {!! Form::button('<span class="glyphicon glyphicon-ok"></span>&nbsp Pošalji',['class'=>'btn btn-sm btn-success','onclick'=>'Komunikacija.posalji("/administracija/poruke/posaljimail",\'forma\',\'poruka\',\'vrti\',\'forma\')' ]) !!}
	      </div>
	    </div>
	  </div>
	</div>
<!-- kraj Modal -->

<script>
	$(function() {
		$('[data-tooltip="true"]').tooltip();
	});
</script>
	
@endsection
