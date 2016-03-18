@extends('site')

@section('title','Confirmar Agendamento')

@section('content')

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

                                    @if(!$profissional->thumbnail)
                                        <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                                    @else
                                        <img src="{{ $profissional->thumbnail }}" class="avatar">
                                    @endif

                                    <h2 class="list-group-item-heading">{{ $profissional->name }} {{ $profissional->lastname }}</h2>
                                    <p class="list-group-item-text">{{ $profissional->cid }}<br>{{ $profissional->especialidade->especialidade->nome }}, Clínico Geral</p>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4">
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <h3><i class="fa fa-exclamation-circle fa-2"></i> Confirme seu agendamento.</h3>

                            <!-- DATAS E HOÁRIOS -->
                            <div class="row dados-confirmar">
                                <div class="col-lg-6 ">
                                    <p><i class="fa fa-calendar fa-2x"></i> Dia {{  date('d/m/Y' , strtotime($dia_agenda) )}}</p>
                                    <p><i class="fa fa-clock-o fa-2x"></i> às {{  date('H:i' , strtotime($horario_agenda) )}}</p>
                                    @if($localidade->tipo == "CONSULTORIO")
                                        <p><i class="fa fa-hospital-o fa-2x"></i> {{ $localidade->logradouro }} , {{ $localidade->numero }}</p>
                                    @endif

                                    <div class="profile-adrress">
                                        {!! $localidade->complemento <> null ? $localidade->complemento .'<br>' : '' !!}

                                        @if($localidade->tipo == "DOMICILIO")
                                           <strong>Bairros atendidos:</strong> {{ $localidade->bairro->nome }} • {{ $localidade->cidade->nome }}/{{ $localidade->uf }}
                                        @else
                                            {{ $localidade->bairro->nome }} • {{ $localidade->bairro->cep }}•{{ $localidade->cidade->nome }}/{{ $localidade->uf }}
                                        @endif
                                    </div>
                                    <div class="profile-phone">
                                        <i class="fa fa-phone"></i>
                                        {{ $profissional->phone }}
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <!-- Painel padrão -->
                                    <div class="panel panel-default panel-cinza">
                                        <div class="panel-body">

                                            {!!

                                                 Form::open([

                                                     'route'  => 'profissional.finalizar.agendamento',
                                                     'method' => 'post'

                                                 ])
                                            !!}

                                            <div class="form-group">
                                                <label class="sr-only" for="nome">Nome</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                    <input type="text" disabled class="form-control" id="nome" placeholder="{{ $usuario->name . ' ' . $usuario->lastname}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="email">Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                                    <input type="text" class="form-control" id="email" disabled placeholder="{{ $usuario->email }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="telefone">Telefone</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                    <input type="text" class="form-control" id="telefone" disabled placeholder="{{ $usuario->phone }}">
                                                </div>
                                            </div>
                                            <p><i class="fa fa-exclamation-circle fa-2"></i> Você é o paciente ou esta marcando a consulta para alguém?</p>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pessoal"  value="2" checked>
                                                    A consulta é para mim.
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="pessoal" value="1" id="outro-radio">
                                                    Estou marcando para alguém.
                                                </label>
                                            </div>

                                            <input type="hidden" name="profissional_id" value="{{ $profissional->id }}" />
                                            <input type="hidden" name="user_id" value="{{ $usuario->id }}" />
                                            <input type="hidden" name="localidade_id" value="{{ $localidade->id }}" />
                                            <input type="hidden" name="data_agenda" value="{{ $dia_agenda }}" />
                                            <input type="hidden" name="horario_agenda" value="{{ $horario_agenda }}" />

                                            <input type="text" class="form-control" name="outro" placeholder="Informe o nome do paciente">
                                            @if($planoAtendido)
                                                {{--<br>--}}
                                                {{--<div id="plano-atendido">--}}
                                                    {{--<label for="">Este médico aceita o seu plano de saúde ({{$planoAtendido->titulo}}). Deseja marcar a consulta utilizando o plano?</label>--}}
                                                    {{--<input type="radio" name="id_plano" value="{{$planoAtendido->id}}"> Sim--}}
                                                    {{--<input type="radio" name="id_plano" value="0"> Não--}}
                                                {{--</div>--}}
                                            @endif
                                            <hr>
                                            <button type="submit" class="btn btn-primary">Confirmar agendamento</button>

                                            {!! Form::close() !!}

                                        </div>
                                    </div><!-- /Painel padrão -->
                                </div>
                            </div>

                        </div>

                    </div><!-- /Tabela com datas e horários -->


                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
    <script>
        $(function(){
            profissionalConfirmaHideShowPlano();
        });
    </script>
@endsection