@extends('adm')
@section('title', 'Especialidades e ramos')


@section('content')

    @inject('ramoService','App\Services\RamoService')
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
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Tipos e Especialidades</h2>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <a href="{{route('adm.novaespecialidade')}}" class="btn btn-primary btn-agendar-multi">Adicionar novo tipo de profissional</a></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <div>

                                <div class="panel-group expandir" role="tablist">

                                    <div class="panel panel-default">
                                        <!-- Painel 1 -->
                                        @foreach($especialidades as $especialidade)
                                            <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4 class="panel-title">
                                                            <a class="" role="button" data-toggle="collapse" href="#collapseEspecialidade{{$especialidade->id}}" aria-expanded="false" aria-controls="collapseEspecialidade{{$especialidade->id}}">
                                                                {{$especialidade->nome}}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <a href="{{route('adm.novoramo', ['especialidade_id' => $especialidade->id])}}" class="btn btn-primary btn-xs blue-btn">Nova especialidade</a>
                                                        <a title="" data-placement="top" data-toggle="tooltip" href="{{route('adm.editespecialidade', ['id' => $especialidade->id])}}" class="btn btn-primary btn-xs" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                                        <a data-confirm="true"  data-placement="top" data-toggle="tooltip" href="{{route('adm.excluirespecialidade', ["id" => $especialidade->id])}}" class="btn btn-danger btn-xs" data-original-title="Apagar"><i class="glyphicon glyphicon-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="height: 0px;" aria-expanded="false" id="collapseEspecialidade{{$especialidade->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHEspecialidadeHeading">
                                                <div>
                                                    <ul class="list-group default">
                                                        <?php $ramos = $ramoService->listarRamoByEspecialidade($especialidade->id); ?>
                                                        @if(sizeof($ramos))
                                                            @foreach($ramos as $ramo)
                                                                <li class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-lg-8"><a href="tipos-especialidades-detalhe.php">{{$ramo->nome}}</a></div>
                                                                        <div class="col-lg-4 text-right"><a href="javascript:void(0)" class="exclui-ramo ramo-{{$ramo->id}}"><i class="fa fa-times red"></i></a></div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            Não há especialidades cadastradas ainda!
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
            excluiRamo();
        });
    </script>
@endsection