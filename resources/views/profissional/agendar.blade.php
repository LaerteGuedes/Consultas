@extends('site')

@section('title','Agendar')

@section('content')


@inject('gradeService','App\Services\GradeService')
@inject('consultaService','App\Services\ConsultaService')


    <section class="main">
        <div class="container">
          <div class="row">
              
            <!-- Sidebar -->
            <div class="col-lg-3">
                @include('partials.filtro')
            </div><!-- /.col-lg-3 -->
            <!-- /Sidebar -->
            
            <!-- Conteúdo -->
            <div class="col-lg-9">
                
                <!-- Tabela com datas e horários -->
                <div class="panel panel-default profissional">
                    
                    <div class="panel-heading header-sallus">
                          <div class="row">
                              <div class="col-lg-8">
                                
                            @if(!$user->thumbnail)
                                <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                            @else  
                                <img src="{{ $user->thumbnail }}" class="avatar">
                            @endif

                                <h2 class="list-group-item-heading">{{  $user->name }} {{  $user->lastname }}</h2>
                                <p class="list-group-item-text text-capitalize">{{ $user->cid }}<br>{{ $user->especialidade->especialidade->nome }} 
                                
                                @if($user->ramos()->count())
                                    @foreach($user->ramos as $ramo)
                                        , {{ $ramo->ramo->nome }}
                                    @endforeach
                                @endif
                                
                                 </p>
                              </div><!-- /.col-lg-8 -->
                              <div class="col-lg-4">
                                <h2 class="list-group-item-heading">Local da Consulta</h2>
                                <p class="list-group-item-text">
                                @if($localidade->tipo ==="CONSULTORIO")
                                  <strong>{{ $localidade->logradouro }} , {{ $localidade->numero }}</strong>
                                  <br>
                                   {!! $localidade->complemento <> null ?  $localidade->complemento .'<br>' : null !!}
                                    {{ $localidade->bairro->nome }} • {{ $localidade->cep }} • {{ $localidade->cidade->nome }} / {{ $localidade->uf }}


                                @else
                                  <strong>HOME CARE</strong>
                                  <br>
                                  
                                    {{ $localidade->bairro->nome }} •  {{ $localidade->cidade->nome }} / {{ $localidade->uf }}



                                @endif

                                
                                </p>
                              </div><!-- /.col-lg-4 -->
                          </div>
                    </div>
                    
                    <div class="panel-body">
                      <h3><i class="fa fa-hospital-o fa-2"></i> Escolha o dia e horário para agendar sua consulta.</h3>

                      <!-- DATAS E HOÁRIOS -->
                      <div id="datas-horarios">
                        <div class="header-nav row">
                            <div class="col-lg-6 text-left">
                                <a  href="{{ url( route('profissional.agendar',['user_id'=>$user->id,'localidade_id'=> $localidade->id]) .'?previous=' . $semana_atual['seg'] ) }}"><i class="fa fa-chevron-left"></i> Semana anterior</a>
                            </div>
                            <div class="col-lg-6 text-right">
                                <a  href="{{ url( route('profissional.agendar',['user_id'=>$user->id,'localidade_id'=> $localidade->id]) .'?next=' . $semana_atual['seg'] ) }}">Próxima semana <i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    @foreach($semana_atual as $dia_semana => $dia)
                                    <th class="row-fim text-uppercase {{ $dia_semana == 'dom' ? 'col-fim' :'' }}">
                                        <span>{{ date('d/m',strtotime($dia)) }}</span>{{ $dia_semana }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($turnos as $sigla_turno => $turno)
                                    <tr>
                                      @foreach($semana_atual as $dia_semana => $dia)

                                          <?php $horarios = $gradeService->getHorariosPorLocalidadeByUser($user->id,$localidade->id,$dia_semana,$sigla_turno); ?>

                                          <td>  
                                              @if($horarios->count() > 0)
                                                      
                                                      @foreach($horarios as $horario)

                                                         <?php 

                                                          $is_agendado = $consultaService->checkIfAgendado([


                                                                'profissional_id' => $user->id,
                                                                'localidade_id'   => $localidade->id,
                                                                'data_agenda'     => $dia,
                                                                'horario_agenda'  => $horario->horario


                                                            ]); 

                                                          ?>

                                                          @if(!$is_agendado && $dia >= date('Y-m-d'))

                                                                  <a onclick="$(this).find('form').submit();">
                                                                      {{ date("H:i",strtotime($horario->horario)) }}
                                                                      <form method="post" action="{{ route('profissional.confirmar.agendamento') }}">
                                                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                                        <input type="hidden" name="profissional_id" value="{{ $user->id }}">
                                                                        <input type="hidden" name="localidade_id" value="{{ $localidade->id }}">
                                                                        <input type="hidden" name="dia_agenda" value="{{ $dia }}">
                                                                        <input type="hidden" name="horario_agenda" value="{{ $horario->horario }}">
                                                                      </form>
                                                                  </a>
                                                          @endif        

                                                      @endforeach
                                              @else
                                                  -       
                                              @endif
                                          </td>

                                      @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                      </div><!-- /DATAS E HOÁRIOS -->

                    </div>
                    
                </div><!-- /Tabela com datas e horários -->

                
           </div><!-- /.col-lg-9 -->
           <!-- /Conteúdo -->
            
          </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection