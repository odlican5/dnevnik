@extends ('roditelj')
@section('content')
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-3">
			<div style="background:#00BCD4; color:white; height:100px;" class="well well-sm">
				<div style="color:#7FDDE9; " class="pull-left"><span class="glyphicon glyphicon-envelope" ></span> Ukuno izostanaka:</div>
				<div style="font-size:56px;  color:#FFFFFF;" class="text-right">{{$izostanci['ukupno']}}</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div style="background:#009688; color:white; height:100px;" class="well well-sm">
				<div style="color:#7FCAC3; " class="pull-left"><span class="glyphicon glyphicon-map-marker" ></span> Broj neopravdanih:</div>
				<div style="font-size:56px;  color:#FFFFFF;" class="text-right">{{$izostanci['neopravdano']}}</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div style="background:#FF5722; color:white; height:100px;" class="well well-sm">
				<div style="color:#FFAA90; " class="pull-left"><span class="glyphicon glyphicon-envelope" ></span> Broj opravdanih:</div>
				<div style="font-size:56px;  color:#FFFFFF;" class="text-right">{{$izostanci['opravdano']}}</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div style="background:#3F51B5; color:white; height:100px;" class="well well-sm">
				<div style="color:#929CD5; " class="pull-left"><span class="glyphicon glyphicon-envelope" ></span> Broj nepravdanih:</div>
				<div style="font-size:56px; color:#FFFFFF;" class="text-right">{{$izostanci['nepravdano']}}</div>
			</div>
		</div>
	</div>
</div>
@endsection