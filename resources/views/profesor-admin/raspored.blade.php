@extends('profesor-admin')

@section('content')
  <div class="col-sm-7 col-sm-offset-1">
    <button id="dugme" class="btn btn-info ribbon">Распоред часова</button>
  </div>

<br><br>
<div class="col-sm-9">
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
@if(\App\Security::autentifikacijaTest(3,'min'))
<div style="box-shadow: 0 0 3px 3px #888;" class="col-sm-3"> 
@if (!empty($error))<div class="alert alert-danger" role="alert">{{$error or ''}}</div>

  

@endif
  {!!Form::open(['url'=>'/administracija/raspored/unos-rasporeda','class'=>'col-sm-12'])!!}
  {!!Form::hidden('boja_teksta',false)!!}
  <button id="dugme" class="btn btn-warning ribbon">Унос распореда</button>
  <div class="form-group">
              {!! Form::label('lpredmet','Унесите предмет:',['class'=>'control-label']) !!}
              {!! Form::text('predmet',null,['class'=>'form-control']) !!}
  </div>
  <div class="form-group  ">
              {!! Form::label('ltipkor','Број часа:',['class'=>'control-label']) !!}
              {!! Form::select('broj_casa',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'],2) !!}
  </div>
  <div class="form-group  ">
              {!! Form::label('ltipkor','Дан:',['class'=>'control-label']) !!}
              {!! Form::select('dan',['ponedeljak'=>'Понедељак','utorak'=>'Уторак','sreda'=>'Среда','cetvrtak'=>'Четвртак','petak'=>'Петак','subota'=>'Субота','nedelja'=>'Недеља'],2) !!}

  </div>
   <div class="form-group">
          {!! Form::label('lcolor','Изаберите боју:',['class'=>'control-label']) !!}
          <br>
        <input type="text" id="text-field" name="boja" class="form-control demo" value="#70c24a">
  </div>
  <script>
        $(document).ready( function() {
            $('.demo').each( function() {
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    format: $(this).attr('data-format') || 'hex',
                    keywords: $(this).attr('data-keywords') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    change: function(hex, opacity) {
                        var log;
                        try {
                            log = hex ? hex : 'transparent';
                            if( opacity ) log += ', ' + opacity;
                            console.log(log);
                        } catch(e) {}
                    },
                    theme: 'bootstrap'
                });

            });

        });
    </script>
    <div class="form-group  ">
        {!! Form::label('lcolor','Изаберите боју текста:',['class'=>'control-label']) !!}
        <input type="text" id="text-field" name="boja_teksta" class="form-control demo" value="#ffffff">
    </div>
  
   <div class="form-group has-feedback">
              {!!Form::button('<i class="glyphicon glyphicon-ok"></i> &nbsp УНЕСИ',['class'=>'btn3d btn btn-info pronadji_btn','type'=>'submit'])!!}
   </div>

          {!! Form::close() !!}
          <br><br>
</div>@endif
<script>
function unesi(){
  
}
  $( document ).ready(function() {
    var rasp = {!! json_encode($rasporedi) !!};
    jQuery.each(rasp,function(i,val){
     $("#"+val['broj_casa']+"-"+val['dan']).html("<a style='color:"+val['boja_teksta']+"; text-decoration:none;'  type='button' data-id="+val['id']+" data-boja="+val['boja']+" data-polje="+val['broj_casa']+'-'+val['dan']+" data-bojateksta="+val['boja_teksta']+" data-predmet=\'"+val['predmet']+"\'  data-toggle='modal' data-target='#myModal' href='#'>"+val['predmet']+"</a>").css({"background-color":''+val['boja'], "border-radius": "10px"});

    });

  });

  
</script>
<!-- Modal -->

<div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" style="border-top:5px solid #269ABC;opacity: 0.85; background: url(/img/bg2.jpg) no-repeat center center fixed;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Измените предмет</h4>
      </div>
      <div class="modal-body" >
      <div id="vrti" style="display:none"><center><i class='icon-spin4 animate-spin' style="font-size: 200%"></i></center></div>
        <div id="poruka" style="display:none"></div>
        <div id="forma">
          {!!Form::hidden('_token',csrf_token())!!}
          {!!Form::hidden('id',false)!!}
          {!!Form::hidden('id_polja',false) !!}
          <div class="form-group">
            <label for="recipient-name" class="control-label">Предмет:</label>
            {!! Form::textarea('predmet1', null, ['id'=>'predmet1','class' => 'form-control','rows'=>'2']) !!}
            
          </div>
          <div class="form-group">
                  {!! Form::label('lcolor','Изаберите боју позадине:',['class'=>'control-label']) !!}
                  <br>
                <input type="text" id="textboja" name="textboja" class="form-control demo" >
          </div>
          <div class="form-group  ">
            {!! Form::label('lcolor','Изаберите боју текста:',['class'=>'control-label']) !!}
            <input type="text" id="textbojateksta" name="textbojateksta" class="form-control demo" >
        </div>
        </div>
      </div>
      <div class="modal-footer">
        {!!Form::button('Откажи',['class'=>'btn3d btn btn-warning','data-dismiss'=>'modal'])!!}
        {!! Form::button('Сачувај измене',['class'=>'btn3d btn btn-primary','onclick'=>'Komunikacija.posalji("/administracija/raspored/izmeni",\'forma\',\'poruka\',\'vrti\',\'forma\')' ]) !!}
        {!! Form::button('Обриши предмет',['class'=>'btn3d btn btn-danger','onclick'=>'Komunikacija.obrisi("/administracija/raspored/obrisi/",\'forma\',\'poruka\',\'vrti\',\'forma\')' ]) !!}
      </div>
    </div>
  </div>
</div>
<script>

  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // prosledjivanje iddjaka modalu
    var id = button.data('id') ;
    var predmet = button.data('predmet') ;
    var boja = button.data('boja') ;
    var bojateksta = button.data('bojateksta') ;

    var polje = button.data('polje') ;
    var modal = $(this);
    $('input[name=id]').val(id);
    modal.find('#predmet1').val(predmet); 
    modal.find('#textboja').val(boja);
    modal.find('#textbojateksta').val(bojateksta);
    console.log(predmet);
    modal.find('input[name=id_polja]').val(polje);
    modal.find('.modal-title').text('Измените предмет ' +predmet);           
            });
</script>

@endsection
