@extends('site')

@section('title','Detalhe do Profissional')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-star-rating/css/star-rating.min.css') }}">
@endsection

@section('content')


    @inject('gradeService', 'App\Services\GradeService')
    @inject('avaliacaoService', 'App\Services\AvaliacaoService')

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


                    <!-- Painel profissional -->
                    <div class="panel panel-default profissional">

                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-7">

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
                                </div><!-- /.col-lg-7 -->
                                <div class="col-lg-3">
                                    <p class="list-group-item-text">

                                        <?php
                                        $votos = $avaliacaoService->getAvaliacaoProfissional($user->id);
                                        ?>


                                        <i class="fa fa-star{{  $votos >= 1 ? '':'-o' }}"></i>
                                        <i class="fa fa-star{{  $votos >= 2 ? '':'-o' }}"></i>
                                        <i class="fa fa-star{{  $votos >= 3 ? '':'-o' }}"></i>
                                        <i class="fa fa-star{{  $votos >= 4 ? '':'-o' }}"></i>
                                        <i class="fa fa-star{{  $votos >= 5 ? '':'-o' }}"></i>

                                        ({{ $votos }})
                                    </p>
                                </div><!-- /.col-lg-3 -->
                                <div class="col-lg-2">

                                    <a href="javascript:void(0);" class="btn btn-primary btn-agendar-multi">Agendar</a>
                                    @if($user->localidades()->where('tipo','CONSULTORIO')->count())
                                            <!-- Painel padrão com locais de atendimento -->
                                    <div class="panel panel-default locais-atendimento">
                                        <div class="panel-body">
                                            <h4><i class="fa fa-info-circle"></i> Escolha em qual local gostaria de ser atendido:</h4>
                                            <ul class="list-group">
                                                @foreach($user->localidades()->where('tipo','CONSULTORIO')->get() as $local)
                                                    <li class="list-group-item">
                                                        @if(!$atende_plano)
                                                            <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="agenda-plano nao-atende-plano">
                                                                {{ $local->logradouro }} {{ $local->numero }}
                                                            </a>
                                                        @else
                                                            <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="agenda-plano">
                                                                {{ $local->logradouro }} {{ $local->numero }}
                                                            </a>
                                                        @endif

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div><!-- /Painel padrão com locais de atendimento -->
                                    @endif

                                </div><!-- /.col-lg-2 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <div>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#detalhes" aria-controls="detalhes" role="tab" data-toggle="tab">Detalhes</a></li>
                                    <li role="presentation"><a href="#avaliacoes" aria-controls="avaliacoes" role="tab" data-toggle="tab">Faça a sua avaliação</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <!-- Tab DETALHES -->
                                    <div role="tabpanel" class="tab-pane active" id="detalhes">

                                        @if($user->localidades()->where('tipo','CONSULTORIO')->count())
                                            <div id="locais-atendimento">
                                                <h3><i class="fa fa-hospital-o fa-2"></i> Locais de atendimento</h3>
                                                @foreach($user->localidades()->where('tipo','CONSULTORIO')->get() as $n => $local)
                                                        <!-- Painel collapse -->
                                                <div class="panel-group expandir" role="tablist">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="collapseAtendimentoHeading_{{ $local->id }}">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseAtendimento_{{ $local->id }}" aria-expanded="{{  $n < 1 ? 'true':'false'}}" aria-controls="collapseAtendimento_{{ $local->id }}">
                                                                    <i class="fa fa-map-marker"></i> {{ $local->logradouro }} , {{ $local->numero }}
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseAtendimento_{{ $local->id }}" class="panel-collapse collapse {{  $n < 1 ? 'in':''}}" role="tabpanel" aria-labelledby="collapseAtendimentoHeading_{{ $local->id }}">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4">
                                                                        <div class="profile-adrress">
                                                                            {!! $local->complemento <> null ?  $local->complemento .'<br>' : null !!}

                                                                            {{ $local->bairro->nome }} • {{ $local->cep }} • {{ $local->cidade->nome }} / {{ $local->uf }}
                                                                        </div>

                                                                        <div class="profile-phone">
                                                                            <i class="fa fa-phone"></i>
                                                                            {{ $user->phone }}
                                                                        </div>



                                                                    </div><!-- ./col-lg-4 -->

                                                                    <div class="col-lg-8">
                                                                        <div class="profile-schedule">
                                                                            <h4><i class="fa fa-clock-o"></i> Dias e horários de atendimento</h4>
                                                                            <ul>
                                                                                <?php

                                                                                $horarios = $gradeService->getHorarioFuncionamentoPorLocalidadeByUser($user->id,$local->id );

                                                                                ?>
                                                                                @foreach($dias_semanais as $dia_semana => $dia )

                                                                                    @if($horarios)

                                                                                        @if(isset($horarios[$dia_semana]))
                                                                                            <li>
                                                                                                <span class="day text-uppercase">{{ $dia_semana }}:</span>
                                                                                                @foreach($horarios[$dia_semana] as $horario)

                                                                                                    <span>{{ $horario['minimo'] }} - {{ $horario['maximo'] }}</span>

                                                                                                @endforeach
                                                                                            </li>
                                                                                        @endif

                                                                                    @endif

                                                                                @endforeach
                                                                            </ul>
                                                                            @if(!$atende_plano)
                                                                                <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="btn btn-primary agenda-plano nao-atende-plano">Agendar</a>
                                                                            @else
                                                                                <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="btn btn-primary agenda-plano">Agendar</a>
                                                                                @endif
                                                                        </div>
                                                                    </div><!-- ./col-lg-8 -->
                                                                </div><!-- ./row -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div><!-- /#locais-atendimento -->
                                        @endif

                                        @if($user->localidades()->where('tipo','DOMICILIO')->count())
                                            <div id="home-care">
                                                <h3><i class="fa fa-hospital-o fa-2"></i> Home Care</h3>

                                                @foreach($user->localidades()->where('tipo','DOMICILIO')->get() as $n => $local)
                                                        <!-- Painel collapse -->
                                                <div class="panel-group expandir" role="tablist">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="collapseAtendimentoHeading_{{ $local->id }}">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseAtendimento_{{ $local->id }}" aria-expanded="{{  $n < 1 ? 'true':'false'}}" aria-controls="collapseAtendimento_{{ $local->id }}">
                                                                    <i class="fa fa-map-marker"></i> {{ $local->bairro->nome }} • {{ $local->cidade->nome }} / {{ $local->uf }}
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseAtendimento_{{ $local->id }}" class="panel-collapse collapse {{  $n < 1 ? 'in':''}}" role="tabpanel" aria-labelledby="collapseAtendimentoHeading_{{ $local->id }}">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4">


                                                                        <div class="profile-phone">
                                                                            <i class="fa fa-phone"></i>
                                                                            {{ $user->phone }}
                                                                        </div>

                                                                        <div class="profile-price">
                                                                            <i class="fa fa-money"></i>
                                                                            R$ {{ number_format($local->preco,2,',','.') }} a consulta
                                                                        </div>

                                                                    </div><!-- ./col-lg-4 -->

                                                                    <div class="col-lg-8">
                                                                        <div class="profile-schedule">
                                                                            <h4><i class="fa fa-clock-o"></i> Dias e horários de atendimento</h4>
                                                                            <ul>
                                                                                <?php

                                                                                $horarios = $gradeService->getHorarioFuncionamentoPorLocalidadeByUser($user->id,$local->id );
                                                                                ?>
                                                                                @foreach($dias_semanais as $dia_semana => $dia )

                                                                                    @if($horarios)

                                                                                        @if(isset($horarios[$dia_semana]))
                                                                                            <li>
                                                                                                <span class="day text-uppercase">{{ $dia_semana }}:</span>
                                                                                                @foreach($horarios[$dia_semana] as $horario)

                                                                                                    <span>{{ $horario['minimo'] }} - {{ $horario['maximo'] }}</span>

                                                                                                @endforeach
                                                                                            </li>
                                                                                        @endif

                                                                                    @endif

                                                                                @endforeach
                                                                            </ul>
                                                                            <a href="{{  route('profissional.agendar',['user_id' => $user->id , 'localidade_id' => $local->id ])  }}" class="btn btn-primary">Agendar</a>
                                                                        </div>
                                                                    </div><!-- ./col-lg-8 -->
                                                                </div><!-- ./row -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div><!-- /#home-care -->
                                        @endif

                                        @if($user->curriculos()->count())

                                            <div id="perfil">
                                                <h3><i class="fa fa-user-md fa-2"></i> Perfil</h3>

                                                <!-- Painel collapse -->
                                                <div class="panel-group expandir" role="tablist">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePerfil" aria-expanded="false" aria-controls="collapsePerfil">
                                                                    <i class="fa fa-info-circle"></i> Informações adicionais do profisional
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePerfil" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseHPerfilHeading">
                                                            <div class="panel-body">
                                                                <ul class="list-group">
                                                                    @foreach($user->curriculos as $curriculo)
                                                                        <li class="list-group-item">{!! nl2br($curriculo->descricao) !!}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><!-- /#perfil -->

                                        @endif


                                        @if( $user->servicos()->count() )

                                            <div id="servicos">
                                                <h3><i class="fa fa-user-md fa-2"></i> Serviços Oferecidos</h3>

                                                <!-- Painel collapse -->
                                                <div class="panel-group expandir" role="tablist">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="collapseServicosHeading">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapseServicos" aria-expanded="false" aria-controls="collapseServicos">
                                                                    <i class="fa fa-info-circle"></i> Detalhes dos serviços
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapseServicos" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseServicosHeading">
                                                            <div class="panel-body">
                                                                <ul class="list-group">
                                                                    @foreach($user->servicos as $servico)
                                                                        <li class="list-group-item">{{ $servico->nome }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /#servicos -->
                                        @endif

                                        @if (count($planos))
                                            <div id="planos">
                                                <h3><i class="fa fa-user-md fa-2"></i>Planos de saúde atendidos</h3>

                                                <!-- Painel collapse -->
                                                <div class="panel-group expandir" role="tablist">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="collapsePlanosHeading">
                                                            <h4 class="panel-title">
                                                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePlanos" aria-expanded="false" aria-controls="collapsePlanos">
                                                                    <i class="fa fa-info-circle"></i> Lista completa de planos atendidos
                                                                </a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapsePlanos" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapsePlanosHeading">
                                                            <div class="panel-body">
                                                                <ul class="list-group">
                                                                    @foreach($user->planos as $plano)
                                                                        <li class="list-group-item">{{ $plano->titulo }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div><!-- /Tab DETALHES -->

                                    <!-- Tab AVALIACOES -->
                                    <div role="tabpanel" class="tab-pane" id="avaliacoes">

                                        <!-- COMENTÁRIOS -->
                                        <div class="col-lg-6">
                                            @if(sizeof($comentarios) > 0)
                                                <h3><i class="fa fa-hospital-o fa-2"></i> Seus comentários</h3>
                                                <ul class="list-group avaliacoes">

                                                    @foreach($comentarios as $comentario)

                                                        <li class="list-group-item avaliacao">
                                                            {{ $comentario->descricao }}
                                                            <span>

                                                <i class="fa fa-star{{  $comentario->star_votos >= 1 ? '':'-o' }}"></i>
                                                <i class="fa fa-star{{  $comentario->star_votos >= 2 ? '':'-o' }}"></i>
                                                <i class="fa fa-star{{  $comentario->star_votos >= 3 ? '':'-o' }}"></i>
                                                <i class="fa fa-star{{  $comentario->star_votos >= 4 ? '':'-o' }}"></i>
                                                <i class="fa fa-star{{  $comentario->star_votos >= 5 ? '':'-o' }}"></i>


                                                <strong>{{ $comentario->comentador }}</strong>
                                            </span>
                                                        </li>
                                                        @endforeach
                                                                <!--
                                        <li class="list-group-item avaliacao">
                                            Vestibulum est tellus, consectetur eu consectet vitae, ultrices ac risus.
                                            <span>
                                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i> <strong>Usuario identificado</strong>
                                            </span>
                                            
                                            
                                            <div class="resposta">
                                                <div class="panel panel-default">
                                                  <div class="panel-body">
                                                      Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat
                                                      <span><strong>Dr. Fulano de Tal</strong></span>
                                                  </div>
                                                </div>
                                                <a href="">Comentar</a>
                                            </div>
                                            
                                        </li>
                                        -->
                                                </ul>
                                            @else

                                                <h3><i class="fa fa-hospital-o fa-2"></i> Deixe seu comentário.</h3>

                                            @endif
                                        </div>

                                        <!-- ENVIO DE COMENTÁRIO -->
                                        @if(!Auth::guest())
                                            <div class="col-lg-6">
                                                <h3><i class="fa fa-hospital-o fa-2"></i> Faça sua avaliação</h3>

                                                <div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">

                                                            <div class="text-center" >
                                                                <!--
                                                                <i class="fa fa-star-o fa-2x rate-star" data-nota="1"></i>
                                                                <i class="fa fa-star-o fa-2x rate-star" data-nota="2"></i>
                                                                <i class="fa fa-star-o fa-2x rate-star" data-nota="3"></i>
                                                                <i class="fa fa-star-o fa-2x rate-star" data-nota="4"></i>
                                                                <i class="fa fa-star-o fa-2x rate-star" data-nota="5"></i>
                                                                -->
                                                                <form>
                                                                    <input type="number" id="star-rate" value="{{ !isset($votos) ? 3 : $votos }}" data-user-id="{{ $user->id }}" data-avaliador="{{ Auth::user()->id }}">
                                                                </form>

                                                            </div>


                                                            {!! Form::open([

                                                                    'route'  => 'store.comentario',
                                                                    'method' => 'post',
                                                                    'id'     => 'envia-avaliacoes'

                                                                ]) !!}




                                                            <textarea class="form-control" rows="3" name="descricao" required></textarea>

                                                            <input type="hidden" name="comentado" value="{{ $user->id }}"/>   <hr>

                                                            <button type="submit" class="btn btn-primary">Enviar avaliação</button>

                                                            {!! Form::close() !!}

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif

                                    </div><!-- /Tab AVALIACOES -->

                                </div>

                            </div>
                        </div>

                    </div><!-- /Painel profissional -->


                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection

@section('lib')
    <script type="text/javascript" src="{{ asset('lib/bootstrap-star-rating/js/star-rating.min.js') }}"></script>
@endsection

@section('script')

    <script type="text/javascript">
        $(function(){

            $(".agenda-plano").on('click', function(){
                var self = $(this);
                if (self.hasClass('nao-atende-plano')){
                    if (confirm("Este profissional não atende seu plano de saúde. Deseja continuar na categoria particular?")){
                        return true;
                    }else{
                        return false;
                    }
                }
            });

            //metodos responsaveis de avaliar
            $("#star-rate").rating({
                min:1,
                max:5,
                step:1,
                starCaptions: {1: "Regular", 2: "Bom", 3: "Muito Bom", 4: "Ótimo", 5: "Excelente"},
                showClear:false,
                ShowCaption:false,
                clearCaption:'Regular',
                size:'xs'

            });

            $('#star-rate').on('rating.change', function(event, value, caption) {
                var self = $(this);
                var data = {

                    avaliador: self.data('avaliador'),
                    user_id: self.data('user-id'),
                    nota: value
                };

                $.get('/avaliar/profissional',data,function(response){

                    console.log(response);
                });

            });


        });
    </script>

@endsection

