@extends('admin-master')

@section('content')

    <div style="color:white; "class="col-sm-6 col-sm-offset-3">
        <h1 >Пријава</h1>
        <hr/>
        <div   class="form-group has-feedback">
            {!! Form::open(['url'=>'administracija/login','class'=>'form-horizontal','id'=>'forma']) !!}
            <div class="form-group ">
                <div class=" col-sm-8 col-sm-offset-2">
                    <select name="tip_korisnika" class="selectpicker " data-style="  btn-info" style="display: none;">
                          <option value="administrator">Администратор</option>
                          <option value="nastavnik">Наставник</option>
                          <option value="roditelj">Родитељ</option>
                    </select>
                </div>
            </div>
            <div id="dusername" class="form-group has-feedback">
                <div class="col-sm-8 col-sm-offset-2">
                    {!! Form::text('username',Input::old('username'),['placeholder'=>'Корисничко име','class'=>'form-control','id'=>'username']) !!}
                    <span id="susername" class="glyphicon form-control-feedback"></span>
                </div>
            </div>
            <div id="dpassword" class="form-group has-feedback">
                <div class="col-sm-8 col-sm-offset-2 ">
                    {!! Form::password('password', ['placeholder'=>'Приступна шифра','class'=>'form-control ','id'=>'password']) !!}
                    <span id="spassword" class="glyphicon form-control-feedback"></span>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-sm-8 col-sm-offset-2 ">
                    {!! Form::button(' Пријава', ['class' => 'btn btn-lg col-sm-12 btn-info','onClick'=>'SubmitForm.submit(\'forma\')']) !!}
            
                </div>
            </div>

            {!! Form::close() !!}
        </div>  
        <script type="text/javascript">
      window.onload=function(){
      $('.selectpicker').selectpicker();
      $('.rm-mustard').click(function() {
        $('.remove-example').find('[value=Mustard]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-ketchup').click(function() {
        $('.remove-example').find('[value=Ketchup]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.rm-relish').click(function() {
        $('.remove-example').find('[value=Relish]').remove();
        $('.remove-example').selectpicker('refresh');
      });
      $('.ex-disable').click(function() {
          $('.disable-example').prop('disabled',true);
          $('.disable-example').selectpicker('refresh');
      });
      $('.ex-enable').click(function() {
          $('.disable-example').prop('disabled',false);
          $('.disable-example').selectpicker('refresh');
      });

      // scrollYou
      $('.scrollMe .dropdown-menu').scrollyou();

      prettyPrint();
      };
    </script> 
    <script>
    $(document).ready(function () {
    $('.forgot-pass').click(function(event) {
      $(".pr-wrap").toggleClass("show-pass-reset");
    }); 
    
    $('.pass-reset-submit').click(function(event) {
      $(".pr-wrap").removeClass("show-pass-reset");
    }); 
});
        $(document).keypress(function(e) {
            if(e.which == 13) {
                SubmitForm.submit('forma');
            }
        });
    </script>
    </div>
@stop