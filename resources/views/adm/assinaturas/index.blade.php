@extends('adm')
@section('title', 'Assinaturas')

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

                    @include('alerts')
                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional">
                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Pacotes de assinatura</h2>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <a href="{{route('adm.novaassinatura')}}" class="btn btn-primary btn-agendar-multi">Adicionar novo pacote</a></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" r>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <h4 class="panel-title">
                                                        <a class="">
                                                            Titulo
                                                        </a>
                                                    </h4>
                                                </div>
                                                <!-- /.col-lg-6 -->

                                                <div class="col-lg-3 text-right">
                                                    Valor
                                                </div>
                                                <!-- /.col-lg-3 -->

                                                <div class="col-lg-2 text-right">
                                                    Parcelas
                                                </div>
                                                <!-- /.col-lg-2 -->

                                                <div class="col-lg-1 text-right">

                                                </div>
                                                <!-- /.col-lg-1 -->
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <ul class="list-group default">
                                                    @foreach($assinaturas as $assinatura)
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-6"><a href="{{route("adm.editassinatura", ['id' => $assinatura->id])}}">{{$assinatura->titulo}}</a></div>
                                                                <div class="col-lg-3 text-right">R$ {{$assinatura->valor}}</div>
                                                                <div class="col-lg-2 text-right">{{$assinatura->numero_parcelas}}</div>
                                                                <div class="col-lg-1 text-right"><a href="{{route('adm.excluirassinatura', ['id' => $assinatura->id])}}"><i class="fa fa-times red"></i></a></div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /Painel padrão com cabeçalho -->
                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->
            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection
