@extends('profesor-admin')

@section('content')
<div class="table-responsive">
	  <table class="table table-condensed">
	  	<thead>
	  		<th>Ime i Prezime</th>
	  		<th>Broj izostanaka</th>
	  		<th>Datum</th>
	  		<th>Razred</th>
	  		<th>Odeljenje</th>
	  		<th>(Ne)Opravdano</th>
	  		<th></th>
	  	</thead>
	  	<tbody>
			@foreach($izostanci as $izostanak)
			<div id="vrti" style="display:none;"><center><i class='icon-spin4 animate-spin' style="font-size: 150%"></i></center></div>
			<div id="poruka" style="display:none"></div>
				<tr id="red-{{$izostanak['id']}}">
					<td>{{$izostanak['ime']}} {{$izostanak['prezime']}}</td>
					<td>{{$izostanak['broj_casova']}}</td>
					<td>{{$izostanak['datum']}} </td>
					<td>{{$izostanak['razred']}}</td>
					<td> {{$izostanak['odeljenje']}}</td>
					<td>
					 	<div id="forma-{{$izostanak['id']}}" class="form-horizontal">
				        	{!!Form::hidden('_token',csrf_token())!!}
				          	{!!Form::hidden('id', $izostanak['id'])!!}

							<select id="opravdano" name="opravdano" class="form-control">
							  <option value="0" selected>Neopravdano</option>
							  <option value="1">Opravdano</option>
							</select>
							
						</div>
					</td>
					<td>
						<div id="btn-{{$izostanak['id']}}" class="pravdanje btn btn-xs btn-primary" data-placement="top" data-toggle="confirmation" data-togglee="tooltip" title="(Ne)Opravdaj" href="#" onclick='Komunikacija.posalji1("/administracija/izostanci/pravdaj","forma-{{$izostanak['id']}}","poruka","vrti","red-{{$izostanak['id']}}")'><span class="glyphicon glyphicon-pencil"></span>
						
						</div>
					</td>
				</tr>

			@endforeach
			<script> $(function() { 
							$('[data-togglee=tooltip]').tooltip();
							$('[data-toggle="confirmation"]').confirmation({placement: 'left',singleton: true,popout: true,title: 'Да ли сте сигурни?',btnCancelLabel: '<i class="icon-remove-sign"></i> Откажи',btnOkLabel: ' &nbsp<i class="icon-ok-sign icon-white"></i> Обриши',});
						});
						</script>
		</tbody>
	</table>
</div>
@endsection