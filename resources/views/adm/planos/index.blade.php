@extends('site')
@section('title', '')

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
                    {{--<form class="form-inline text-right form-filtro">--}}
                        {{--<div class="form-group">--}}
                            {{--<label>Filtrar por:</label>--}}
                            {{--<select class="form-control">--}}
                                {{--<option value="">Estado</option>--}}
                            {{--</select>--}}
                            {{--<select class="form-control">--}}
                                {{--<option value="">Cidade</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</form>--}}

                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional">

                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Planos de Saúde</h2>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <a href="planos-saude-operadora-detalhe.php" class="btn btn-primary btn-agendar-multi">Adicionar nova operadora</a></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <div>

                                <div class="panel-group expandir" role="tablist">

                                    <div class="panel panel-default">
                                        <!-- Painel 1 -->
                                        <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="panel-title">
                                                        <a class="" role="button" data-toggle="collapse" href="#collapseEspecialidade" aria-expanded="false" aria-controls="collapseEspecialidade">
                                                            Unimed
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <a href="planos-saude-plano-detalhe.php" class="btn btn-primary btn-xs blue-btn">Adicionar novo plano</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidadeHeading">
                                            <div>
                                                <ul class="list-group default">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-8"><a href="planos-saude-plano-detalhe.php">Unimed Unimax</a></div>
                                                            <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-8"><a href="planos-saude-plano-detalhe.php">Unimed Uniplan</a></div>
                                                            <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- ./Painel 1 -->

                                        <!-- Painel 2 -->
                                        <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" href="#collapseEspecialidade2" aria-expanded="false" aria-controls="collapseEspecialidade2">
                                                            Hapvida
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <a href="planos-saude-plano-detalhe.php" class="btn btn-primary btn-xs blue-btn">Adicionar novo plano</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidade2Heading">
                                            <div>
                                                <ul class="list-group default">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-8"><a href="planos-saude-plano-detalhe.php">Hapvida Família</a></div>
                                                            <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-lg-8"><a href="tplanos-saude-plano-detalhe.php">Hapvida Cop</a></div>
                                                            <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- ./Painel 2 -->

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