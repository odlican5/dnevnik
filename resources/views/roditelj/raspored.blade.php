@extends ('roditelj')

@section('content')
  <div class="col-sm-10 col-sm-offset-1">
    <button id="dugme" class="btn btn-info ribbon">Распоред часова</button>
  </div>

<br><br>
<div class="col-sm-12">
<div style="box-shadow: 0 0 3px 3px #888;" class="table-responsive">
  <table class="table table-condensed">
  	<thead style=" border-bottom:3px solid #3395B1;">
      <th></th>
  		@foreach($dani as $dan)
  		<th>{{$dan}}</th>
  		@endforeach
  	<tbody>
    <tr style="height:50px;" id="1">
      <td>1.</td>
      <td id="1-ponedeljak"></td>
      <td id="1-utorak"></td>
      <td  id="1-sreda"></td>
      <td id="1-cetvrtak"></td>
      <td id="1-petak"></td>
      <td id="1-subota"></td>
      <td id="1-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="2">
      <td>2.</td>
      <td id="2-ponedeljak"></td>
      <td id="2-utorak"></td>
      <td  id="2-sreda"></td>
      <td id="2-cetvrtak"></td>
      <td id="2-petak"></td>
      <td id="2-subota"></td>
      <td id="2-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="3">
      <td>3.</td>
      <td id="3-ponedeljak"></td>
      <td id="3-utorak"></td>
      <td  id="3-sreda"></td>
      <td id="3-cetvrtak"></td>
      <td id="3-petak"></td>
      <td id="3-subota"></td>
      <td id="3-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="4">
      <td>4.</td>
      <td id="4-ponedeljak"></td>
      <td id="4-utorak"></td>
      <td  id="4-sreda"></td>
      <td id="4-cetvrtak"></td>
      <td id="4-petak"></td>
      <td id="4-subota"></td>
      <td id="4-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="5">
      <td>5.</td>
      <td id="5-ponedeljak"></td>
      <td id="5-utorak"></td>
      <td  id="5-sreda"></td>
      <td id="5-cetvrtak"></td>
      <td id="5-petak"></td>
      <td id="5-subota"></td>
      <td id="5-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="6">
      <td>6.</td>
      <td id="6-ponedeljak"></td>
      <td id="6-utorak"></td>
      <td  id="6-sreda"></td>
      <td id="6-cetvrtak"></td>
      <td id="6-petak"></td>
      <td id="6-subota"></td>
      <td id="6-nedelja"></td>
    </tr>
    <tr style="height:50px;" id="7">
      <td>7.</td>
      <td id="7-ponedeljak"></td>
      <td id="7-utorak"></td>
      <td  id="7-sreda"></td>
      <td id="7-cetvrtak"></td>
      <td id="7-petak"></td>
      <td id="7-subota"></td>
      <td id="7-nedelja"></td>
    </tr>
    </tbody>
  	</thead>
  </table>
</div>
</div>

<script>
  $( document ).ready(function() {
    var rasp = {!! json_encode($rasporedi) !!};
    jQuery.each(rasp,function(i,val){
     $("#"+val['broj_casa']+"-"+val['dan']).html("<a style='color:"+val['boja_teksta']+"; text-decoration:none;'>"+val['predmet']+"</a>").css({"background-color":''+val['boja'], "border-radius": "10px"});
  });
});

  
</script>

@endsection
