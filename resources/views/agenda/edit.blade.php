@extends('site')

@section('title',' | Editar Agendamento')

@section('style')

   <link rel="stylesheet" href="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>

@endsection


@section('content')


<section>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                    <ol class="breadcrumb">
                      <li><a href="{{ route('dashboard')  }}">Dashboard</a></li>
                      <li><a href="{{ route('agenda')  }}">Agenda</a></li>
                      <li class="active">Editar Agendamento</li>
                    </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @include('alerts')

                <div class="page-header">
                    <h1><small>Editar Agendamento</small></h1>
                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">


                {!!
                    Form::open([

                            'route'  => ['update.agenda', $agenda->id ],
                            'method' => 'put',
                            'class'  => 'well'


                    ])
                !!}

                    <div class="form-group">
                        {!! Form::label('localidade_id','*Localidade:') !!}

                       <select name="localidade_id" id="localidade_id" class="form-control">
                             @if($localidades)
                                   @foreach($localidades as $local)
                                   <option value="{{ $local['id'] }}"  {{ $local['id'] == $agenda->localidade_id ? 'selected' : null  }}  >{{ $local['local'] }}</option>
                                   @endforeach
                             @else
                                   <option value="">Você precisa registrar um local.</option>
                             @endif
                       </select>
                    </div>

                    <div class="form-group">

                         <label for="data_agenda">*Data:</label>

                         <div class="input-group">

                           <input type="text" name="data_agenda" id="data_agenda" value="{{ date("d/m/Y" ,strtotime($agenda->data_agenda))  }}" class="form-control" />
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>

                         </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <label for="horas">Horas:</label>
                                <select name="horas" id="horas" class="form-control">
                                    @foreach($horas as $hora)
                                        <option value="{{ $hora }}" {{ $agenda->getHora($agenda->horario_agenda) == $hora ? 'selected':null  }}>{{ $hora }} h</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <label for="minutos">Minutos:</label>
                                <select name="minutos" id="minutos" class="form-control">
                                  @foreach($intervalos as $intervalo)
                                      <option value="{{$intervalo}}" {{ $agenda->getMinutos($agenda->horario_agenda) == $intervalo ? 'selected':null  }}>{{$intervalo}} min</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr/>


                    <div class="form-group">
                        {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block']) !!}
                    </div>

                {!!

                    Form::close()
                !!}



            </div>

        </div>

    </div>

</section>

@endsection

@section('lib')
    <script src="{{ asset('lib/clndr/example/moment-2.8.3.js') }}"></script>
    <script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('script')

    <script type="text/javascript">

        (function($){

                $(document).ready(function(){

                       $('#data_agenda').datetimepicker({
                            locale:'pt-br',
                           format:'DD/MM/YYYY'
                       });
                });

        })(jQuery)

    </script>

@endsection

