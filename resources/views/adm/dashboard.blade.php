@extends('adm')
@section('title', 'Bem-vindo')

@section('content')
    <section class="main adm">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('partials.admmenu')
                </div><!-- /.col-lg-3 -->
                <!-- /Sidebar -->
                <!-- Conteúdo -->
                <div class="col-lg-9">
                    <h1>Resumo Geral</h1>

                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Painel padrão com cabeçalho -->
                            <div class="panel panel-default">
                                <div class="panel-heading header-sallus">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Usuários</h2>
                                </div>
                                <ul class="list-group default">
                                    <li class="list-group-item">
                                        Total de usuários <span class="destaque">{{$totalUsuarios}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Atendimentos agendados <span class="destaque">{{$totalAgendadas}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Atendimentos realizados <span class="destaque">{{$totalRealizadas}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Atendimentos canc. pelo usuário <span class="destaque">{{$totalCanceladas}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Total de avaliações <span class="destaque">{{$totalAvaliacoes}}</span>
                                    </li>
                                </ul>
                            </div><!-- /Painel padrão com cabeçalho -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Painel padrão com cabeçalho -->
                            <div class="panel panel-default profissional">
                                <div class="panel-heading header-sallus">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Profissionais</h2>
                                </div>
                                <ul class="list-group default">
                                    <li class="list-group-item">
                                        Total de profissionais <span class="destaque">{{$totalProfissionais}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Atendimentos canc. pelo profissional <span class="destaque">100</span>
                                    </li>
                                    <li class="list-group-item">
                                        Profissionais em período de avaliação <span class="destaque">{{$totalProfissionaisTeste}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Profissionais com assinatura <span class="destaque">{{$totalProfissionaisAtivos}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Profissionais inativos <span class="destaque">{{$totalProfissionaisInativos}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Nº de assinaturas <span class="destaque">{{$valorAssinaturas->contagem}} <i>(R$ {{$valorAssinaturas->soma}})</i></span>
                                    </li>
                                    {{--<li class="list-group-item">--}}
                                        {{--Tipo + requisitado <span class="destaque">Médico</span>--}}
                                    {{--</li>--}}
                                    {{--<li class="list-group-item">--}}
                                        {{--Especialização + requisitada <span class="destaque">Dermatologista</span>--}}
                                    {{--</li>--}}
                                </ul>
                            </div><!-- /Painel padrão com cabeçalho -->
                        </div>
                    </div>
                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->
            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection