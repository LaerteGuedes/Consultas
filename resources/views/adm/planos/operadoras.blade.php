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
                                                        <button class="btn btn-primary btn-xs blue-btn btn-plano-modal" id="button-{{$operadora->id}}">Adicionar novo plano</button>
                                                        <button title="" data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-operadora" id="button-editar-{{$operadora->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
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
                                                                        <div class="col-lg-8"><p>{{$plano->titulo}}</p></div>
                                                                        <div class="col-lg-4 text-right">
                                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-plano" id="button-editar-{{$plano->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                                                            <a href="javascript:void(0)" class="exclui-plano plano-{{$plano->id}}"><i class="fa fa-times red"></i></a></div>
                                                                    </div>
                                                                </li>
                                                                <div id="modal-editar-plano-{{$plano->id}}" class="modal fade plano-editar-modal" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Editar plano {{$plano->titulo}}</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="POST" action="{{route('adm.updateplano')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                                    <div class="form-group">
                                                                                        <label for="titulo">Titulo: </label>
                                                                                        <input type="text" class="form-control" name="titulo" id="titulo" value="{{$plano->titulo}}" required/>
                                                                                    </div>
                                                                                    <input type="hidden" name="id" value="{{$plano->id}}">
                                                                                    <br>
                                                                                    <div class="form-group">
                                                                                        <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <p>Não há plano cadastrados para essa operadora!</p>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="modal-editar-operadora-{{$operadora->id}}" class="modal fade operadora-editar-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Editar operadora</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.updateoperadora')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="titulo">Titulo: </label>
                                                                    <input type="text" class="form-control" name="titulo" id="titulo" value="{{$operadora->titulo}}" required/>
                                                                </div>
                                                                <input type="hidden" name="id" value="{{$operadora->id}}">
                                                                <br>
                                                                <div class="form-group">
                                                                    <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal-plano-{{$operadora->id}}" class="modal fade plano-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Nova plano da operadora {{$operadora->titulo}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.salvaplano')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="titulo">Titulo: </label>
                                                                    <input type="text" class="form-control" name="titulo" id="titulo" required/>
                                                                </div>
                                                                <br>
                                                                <input type="hidden" name="id_pai" value="{{$operadora->id}}">
                                                                <div class="form-group">
                                                                    <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
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
            <div id="modal-nova-operadora" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nova operadora</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('adm.salvaoperadora')}}" id="form-nova-operadora" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                <div class="form-group">
                                    <label for="nome">Titulo: </label>
                                    <input type="text" class="form-control" name="nome" id="nome"/>
                                </div>
                                <br>
                                <div class="form-group">
                                    <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection

@section('script')
    <script>
        $(function(){
            function operadoraModal(){
                var buttonoperadoraModal = $("#btn-operadora-modal");
                var target = $("#modal-novo-operadora");

                buttonoperadoraModal.on("click", function(){
                    target.modal();
                });
            }

            function editaroperadoraModal(){
                var buttonEditoperadoraModal = $(".btn-editar-operadora");

                buttonEditoperadoraModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var operadora_id = idArray[2];

                    var target = $("#modal-editar-operadora-"+operadora_id);
                    target.modal();
                });
            }

            function editarplanoModal(){
                var buttonEditplanoModal = $(".btn-editar-plano");

                buttonEditplanoModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var plano_id = idArray[2];

                    var target = $("#modal-editar-plano-"+plano_id);
                    target.modal();
                });
            }

            function planoModal(){
                var buttonplanoModal = $(".btn-plano-modal");

                buttonplanoModal.on('click', function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var plano_id = idArray[1];

                    var target = $("#modal-plano-"+plano_id);
                    target.modal();
                });
            }

            excluiPlano();
            operadoraModal();
            editaroperadoraModal();
            editarplanoModal();
            planoModal();
        });
    </script>
@endsection