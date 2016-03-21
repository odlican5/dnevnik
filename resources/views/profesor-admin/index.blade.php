@extends('profesor-admin')

@section('content')
    <br><hr>
    @foreach($obavestenja as $ob)
    @if (!$ob['url'])
        <div class="row">
            <div class="col-sm-12">
                <p style="color: #26C1D6" class=" pull-left"><span class="glyphicon glyphicon-time"></span> Објављено {{$ob['created_at']}}</p>
                 <h2 style="color: #26C1D6" class=" pull-left">{{$ob['naslov']}}</h2>
                 <br><br>
                 <p style="text-align: left;" >{!!stripslashes(trim($ob['obavestenje']))!!}</p>
            </div>
        </div>
    @else
        <div class="row">
        	<div class="col-sm-4">
        		<img style="width: 100%;max-height: 200px;" class="img-responsive" src="img_skole{{$ob['url']}}" alt="">
        	</div>
        	<div class="col-sm-8">
    	    		<p style="color: #26C1D6" class=" pull-left"><span class="glyphicon glyphicon-time"></span> Објављено {{$ob['created_at']}}</p>
                    <h2 style="color: #26C1D6" class=" pull-left">{{$ob['naslov']}}</h2>
    	        <br><br>
    	        <p style="text-align: left;" >{!!stripslashes(trim($ob['obavestenje']))!!}</p>
        	
            </div>
            
        </div><hr>
        @endif
    @endforeach
	
   
@endsection