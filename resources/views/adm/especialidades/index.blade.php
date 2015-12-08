@extends('adm')
@section('title', '')

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

                <!-- Painel padrão com cabeçalho -->
                <div class="panel panel-default profissional">

                    <div class="panel-heading header-sallus">
                        <div class="row">
                            <div class="col-lg-8">
                                <h2><i class="fa fa-exclamation-circle  fa-2"></i> Tipos e Especialidades</h2>
                            </div><!-- /.col-lg-8 -->
                            <div class="col-lg-4 text-right">
                                <div class="sub-header"> <a href="#" class="btn btn-primary btn-agendar-multi">Adicionar novo tipo de profissional</a></div>
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
                                                        Médico
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <a href="#" class="btn btn-primary btn-xs blue-btn">Nova especialidade</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidadeHeading">
                                        <div>
                                            <ul class="list-group default">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-8"><a href="tipos-especialidades-detalhe.php">Dermatologista</a></div>
                                                        <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-8"><a href="tipos-especialidades-detalhe.php">Neurologista</a></div>
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
                                                        Fisioterapeuta
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <a href="#" class="btn btn-primary btn-xs blue-btn">Nova especialidade</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidade2Heading">
                                        <div>
                                            <ul class="list-group default">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-8"><a href="tipos-especialidades-detalhe.php">Fisioterapeuta ocapacional</a></div>
                                                        <div class="col-lg-4 text-right"><a href="#"><i class="fa fa-times red"></i></a></div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-lg-8"><a href="tipos-especialidades-detalhe.php">Fisioterapeuta da terceira idade</a></div>
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
@section('content')
// code goes here
@endsection