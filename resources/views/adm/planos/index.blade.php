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
                    @include('alerts')
                            <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional">

                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Planos de saúde</h2>
                                </div><!-- /.col-lg-8 -->
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <button class="btn btn-primary btn-agendar-multi" id="btn-plano-modal">Adicionar novo tipo de profissional</button></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>

                        <div class="panel-body">
                            <div>

                                <div class="panel-group expandir" role="tablist">

                                    <div class="panel panel-default">
                                        <!-- Painel 1 -->
                                        @foreach($planos as $plano)
                                            <div class="panel-heading" role="tab" id="collapsePerfilHeading">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <h4 class="panel-title">
                                                            <a class="" role="button" data-toggle="collapse" href="#collapseplano{{$plano->id}}" aria-expanded="false" aria-controls="collapseplano{{$plano->id}}">
                                                                {{$plano->nome}}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div class="col-lg-4 text-right">
                                                        <button class="btn btn-primary btn-xs blue-btn btn-ramo-modal" id="button-{{$plano->id}}">Nova plano</button>
                                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-plano" id="button-editar-{{$plano->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                                        <a data-confirm="true"  data-placement="top" data-toggle="tooltip" href="{{route('adm.excluirplano', ["id" => $plano->id])}}" class="btn btn-danger btn-xs" data-original-title="Apagar"><i class="glyphicon glyphicon-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="height: 0px;" aria-expanded="false" id="collapseplano{{$plano->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseHplanoHeading">
                                                <div>
                                                    <ul class="list-group default">
                                                        <?php $subplanos = $plano->children()->get(); ?>
                                                        @if(sizeof($ramos))
                                                            @foreach($subplanos as $subplano)
                                                                <li class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-lg-10"><p>{{$subplano->nome}}</p></div>
                                                                        <div class="col-lg-2 text-right">
                                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-subplano" id="button-editar-{{$subplano->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                                                            <a href="javascript:void(0)" class="exclui-subplano subplano-{{$subplano->id}}"><i class="fa fa-times red"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <div id="modal-editar-subplano-{{$subplano->id}}" class="modal fade subplano-editar-modal" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Editar subplano {{$subplano->nome}}</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="POST" action="{{route('adm.updatesubplano')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                                    <div class="form-group">
                                                                                        <label for="nome">Titulo: </label>
                                                                                        <input type="text" class="form-control" name="nome" id="nome" value="{{$subplano->nome}}" required/>
                                                                                    </div>
                                                                                    <input type="hidden" name="id" value="{{$subplano->id}}">
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
                                                            Não há planos cadastradas ainda!
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="modal-editar-plano-{{$plano->id}}" class="modal fade plano-editar-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Editar plano</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.updateplano')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="nome">Titulo: </label>
                                                                    <input type="text" class="form-control" name="nome" id="nome" value="{{$plano->nome}}" required/>
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
                                            <div id="modal-plano-{{$plano->id}}" class="modal fade ramo-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Nova plano da área de {{$plano->nome}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.salvaramo')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="nome">Titulo: </label>
                                                                    <input type="text" class="form-control" name="nome" id="nome" required/>
                                                                </div>
                                                                <br>
                                                                <input type="hidden" name="plano_id" value="{{$plano->id}}">
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
            <div id="modal-nova-plano" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nova plano</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('adm.salvaplano')}}" id="form-nova-plano" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
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
            excluiRamo();

            function planoModal(){
                var buttonplanoModal = $("#btn-plano-modal");
                var target = $("#modal-novo-plano");

                buttonplanoModal.on("click", function(){
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

            function editarsubplanoModal(){
                var buttonEditsubplanoModal = $(".btn-editar-subplano");

                buttonEditsubplanoModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var subplano_id = idArray[2];

                    var target = $("#modal-editar-subplano-"+subplano_id);
                    target.modal();
                });
            }

            function subplanoModal(){
                var buttonsubplanoModal = $(".btn-subplano-modal");

                buttonsubplanoModal.on('click', function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var subplano_id = idArray[1];

                    var target = $("#modal-subplano-"+subplano_id);
                    target.modal();
                });
            }

            planoModal();
            editarplanoModal();
            editarsubplanoModal();
            subplanoModal();
        });
    </script>
@endsection