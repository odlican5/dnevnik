@extends('profesor-admin')

@section('content')
    <p class="col-sm-12">Zakazani dogadjaji</p>
    <br><hr>
    <div id="vrti" style="display:none;"><center><i class='icon-spin4 animate-spin' style="font-size: 150%"></i></center></div>
    <div id="poruka" style="display:none"></div>
    
    	
    <div class="row">
    	<div class="col-sm-4">
			        <!-- Responsive calendar - START -->
            <div class="responsive-calendar">
                <div class="controls">
                    <a class="pull-left" data-go="prev"><div class="btn btn-primary"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
                    <h4><span data-head-year></span> <span data-head-month></span></h4>
                    <a class="pull-right" data-go="next"><div class="btn btn-primary"><i class="glyphicon glyphicon-chevron-right"></i></div></a>
                </div><hr/>
                <div class="day-headers">
                  <div class="day header">Pon</div>
                  <div class="day header">Uto</div>
                  <div class="day header">Sre</div>
                  <div class="day header">Čet</div>
                  <div class="day header">Pet</div>
                  <div class="day header">Sub</div>
                  <div class="day header">Ned</div>
                </div>
                <div class="days" data-group="days">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
        	<div class="responsive-calendar-placeholder"></div>
        </div>
        @if(App\Metode::razredni_provera(Session::get('id')) == true)
        <div class="col-sm-4">
	    	<div id="forma" >
	    		{!!Form::hidden('_token',csrf_token())!!}
		    	<div class="form-group">
		    		{!! Form::label('ldogadjana','Унесите догађај:',['class'=>'control-label']) !!}
		    		{!! Form::textarea('dogadjaj',null,['class'=>'form-control', 'rows' => 2, 'cols' => 20]) !!}
		    	</div>
		    	<div class="row">
                    <div class="col-xs-7">
                        <input name="datum" placeholder="Izaberi datum" data-provide="datepicker">
                    </div>
          </div><br>
		    </div>
    		{!! Form::submit('Сачувај', array('class' => 'btn btn-info','onclick'=>'Komunikacija.posalji("/administracija/dogadjaji/unesi-dogadjaj","forma","poruka","vrti","zabrani")')) !!}
    	</div>
    	@endif
    </div>
    
    <br>
    




	<script>
		(function($) {
  /**
   *	Fade Placeholder
   */
  function fadeOutModalBox(num) {
    //setTimeout(function(){ $(".responsive-calendar-modal").fadeOut(); }, num);
  }
  /**
   *	Helper Function
   */
  function zero(num) {
    if (num < 10) { return "0" + num; }
    else { return "" + num; }
  }
  /**
   * Remove Placeholder
   */
  function removeModalBox() { $(".responsive-calendar-modal").remove(); }
  /**
   *	Calender
   */
   
  $(document).ready(function() {
    var $cal = $('.responsive-calendar');
    $cal.responsiveCalendar({
      events : {
        {!! $podaci['kalendar'] !!}
      }, /* end events */
      onActiveDayHover: function(events) {
        var $today, $dayEvents, $i, $isHoveredOver, $placeholder, $output;
        $i = $(this).data('year')+'-'+zero($(this).data('month'))+'-'+zero($(this).data('day'));
        $isHoveredOver = $(this).is(":hover");
        $placeholder = $(".responsive-calendar-placeholder");
        $today= events[$i];
        $dayEvents = $today.dayEvents;
        $output = '<div class="responsive-calendar-modal">';
        $.each($dayEvents, function() {
          $.each( $(this), function( key ){
            $output += '<h1>Naslov: '+$(this)[key].title+'</h1>' + '<p>Status: '+$(this)[key].status+'<br />'+$(this)[key].time+'</p>';
          });
        });
        $output + '</div>';
        
        if ( $isHoveredOver ) {
          $placeholder.html($output);
        }
        else {
          fadeOutModalBox(500);
        }
        
        },
    }); /* end $cal */
  }); /* end $document */
}(window.jQuery || window.$));
 
		</script><!-- Responsive calendar - END -->
@endsection