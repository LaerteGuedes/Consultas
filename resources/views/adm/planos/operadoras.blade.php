@extends('site')
@section('title', 'Operadoras e planos')

@section('content')

    @inject("planoService", "App\Services\PlanoService")
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
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Planos de Saúde</h2>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <a href="{{route('adm.novaoperadora')}}" class="btn btn-primary btn-agendar-multi">Adicionar nova operadora</a></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <div>
                                <div class="panel-group expandir" role="tablist">
                                    <div class="panel panel-default">
                                        @foreach($operadoras as $operadora)
                                            <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4 class="panel-title">
                                                            <a class="" role="button" data-toggle="collapse" href="#collapseEspecialidade{{$operadora->id}}" aria-expanded="false" aria-controls="collapseEspecialidade{{$operadora->id}}">
                                                                {{$operadora->titulo}}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <a href="{{route('adm.novoplano', ['id_pai' => $operadora->id])}}" class="btn btn-primary btn-xs blue-btn">Adicionar novo plano</a>
                                                        <a title="" data-placement="top" data-toggle="tooltip" href="{{route('adm.editoperadora', ['id' => $operadora->id])}}" class="btn btn-primary btn-xs" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                                        <a data-confirm="true"  data-placement="top" data-toggle="tooltip" href="{{route('adm.excluiroperadora', ["id" => $operadora->id])}}" class="btn btn-danger btn-xs" data-original-title="Apagar"><i class="glyphicon glyphicon-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade{{$operadora->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidadeHeading">
                                                <div>
                                                    <?php $planos = $planoService->findChildren($operadora->id); ?>
                                                    <ul class="list-group default">
                                                        @if(sizeof($planos))
                                                            @foreach($planos as $plano)
                                                                <li class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-lg-8"><a href="planos-saude-plano-detalhe.php">{{$plano->titulo}}</a></div>
                                                                        <div class="col-lg-4 text-right"><a href="javascript:void(0)" class="exclui-plano plano-{{$plano->id}}"><i class="fa fa-times red"></i></a></div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <p>Não há plano cadastrados para essa operadora!</p>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
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

@section('script')
    <script>
        $(function(){
            excluiPlano();
        });
    </script>
@endsection