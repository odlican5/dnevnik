@extends ('profesor-admin')

@section('content')

        <div class="col-sm-12 col-md-6 col-md-offset-3 toppad" >

          <div class="">
            <div class="panel-body">
            <div class="row">
                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: {{$procenat_popunjenosti}}%;">
                  Попуњеност профила: {{$procenat_popunjenosti}}%
                  </div>
                </div>
              </div>
             {!! Form::open(['url'=>'/administracija/profil/edit-nalog','id'=>'forma','enctype'=>'multipart/form-data','class'=>'form-horizontal']) !!}
             {!! Form::hidden('id', $nastavnici[0]['id']) !!}
              <div class="row">
                <div class="col-md-4" align="center"> 
                  <div  class="row">
                      <img id="foto" data-toggle="tooltip" data-placement="bottom" title="Izmeni fotografiju" style="width:200px;height: 200px; background:transparent;" src="/img/teacher-icon.png" class="img-thumbnail img-responsive">           
                  </div>
                </div>
            
                <div class=" col-md-8"> 
                  <table class="table table-user-information">
                    <tbody>
                      @if ($errors->any())
                      <div class="alert alert-dangeИсправите следеће грешке:"</p>
                        <ul>
                          @foreach( $errors->all() as $message )
                            <li>{{ $message }}</li>
                          @endforeach
                        </ul>
                        </div>
                       @endif
                      <tr>
                        <td>Презиме:</td>
                        <td>{!! Form::text('prezime',$nastavnici[0]['prezime'], ['class'=>'form-control', 'placeholder'=>'Prezime'])!!}</td>
                      </tr>
                      <tr>
                        <td>Име:</td>
                        <td>{!! Form::text('ime',$nastavnici[0]['ime'], ['class'=>'form-control', 'placeholder'=>'Ime'])!!}</td>
                      </tr>
                      <tr>
                        <td>Корисничко име:</td>
                        <td>{!! Form::text('username',$nastavnici[0]['username'], ['class'=>'form-control', 'placeholder'=>'Username','id'=>'username'])!!}</td>
                      </tr>
                      <tr>
                        <td>Лозинка:</td>
                        <td>{!! Form::password('password', ['class'=>'form-control'])!!}</td>
                      </tr>
                      <tr>
                        <td>Потврдите лозинку:</td>
                        <td>{!! Form::password('password_confirmation', ['class'=>'form-control']) !!}</td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td>{!! Form::text('email',$nastavnici[0]['email'], ['class'=>'form-control', 'placeholder'=>'Email','type'=>'email'])!!}</td>
                      </tr>         
                      <tr>
                        <td>Телефон:</td>
                        <td>{!! Form::text('telefon',$nastavnici[0]['telefon'], ['class'=>'form-control', 'placeholder'=>'Telefon'])!!}</td>
                      </tr>                  
                    </tbody>
                  </table>
                  {!! Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Sačuvaj',['class'=>'btn3d btn btn-md btn-info','onClick'=>'SubmitForm.submit(\'forma\')'])!!}
                </div>
              </div>
              {!! Form::close() !!}
            </div>            
          </div>
        </div>
@endsection