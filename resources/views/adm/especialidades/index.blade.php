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
                                    <div class="sub-header"> <button class="btn btn-primary btn-agendar-multi" id="btn-especialidade-modal">Adicionar novo tipo de profissional</button></div>
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
                                                        <button class="btn btn-primary btn-xs blue-btn btn-ramo-modal" id="button-{{$especialidade->id}}">Nova especialidade</button>
                                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-especialidade" id="button-editar-{{$especialidade->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
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
                                                                        <div class="col-lg-"><p>{{$ramo->nome}}</p></div>
                                                                        <div class="col-lg-2 text-right">
                                                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-ramo" id="button-editar-{{$ramo->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                                                            <a href="javascript:void(0)" class="exclui-ramo ramo-{{$ramo->id}}"><i class="fa fa-times red"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <div id="modal-editar-ramo-{{$ramo->id}}" class="modal fade ramo-editar-modal" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Editar ramo {{$ramo->nome}}</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="POST" action="{{route('adm.updateramo')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                                    <div class="form-group">
                                                                                        <label for="nome">Titulo: </label>
                                                                                        <input type="text" class="form-control" name="nome" id="nome" value="{{$ramo->nome}}" required/>
                                                                                    </div>
                                                                                    <input type="hidden" name="id" value="{{$ramo->id}}">
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
                                                            Não há especialidades cadastradas ainda!
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="modal-editar-especialidade-{{$especialidade->id}}" class="modal fade especialidade-editar-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Editar especialidade</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.updateespecialidade')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="nome">Titulo: </label>
                                                                    <input type="text" class="form-control" name="nome" id="nome" value="{{$especialidade->nome}}" required/>
                                                                </div>
                                                                <input type="hidden" name="id" value="{{$especialidade->id}}">
                                                                <br>
                                                                <div class="form-group">
                                                                    <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="modal-especialidade-{{$especialidade->id}}" class="modal fade ramo-modal" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Nova especialidade da área de {{$especialidade->nome}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{route('adm.salvaramo')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                                <div class="form-group">
                                                                    <label for="nome">Titulo: </label>
                                                                    <input type="text" class="form-control" name="nome" id="nome" required/>
                                                                </div>
                                                                <br>
                                                                <input type="hidden" name="especialidade_id" value="{{$especialidade->id}}">
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
            <div id="modal-nova-especialidade" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nova especialidade</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('adm.salvaespecialidade')}}" id="form-nova-especialidade" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
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

            function especialidadeModal(){
                var buttonEspModal = $("#btn-especialidade-modal");
                var target = $("#modal-nova-especialidade");

                buttonEspModal.on("click", function(){
                    target.modal();
                });
            }

            function editarEspecialidadeModal(){
                var buttonEditEspModal = $(".btn-editar-especialidade");

                buttonEditEspModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var especialidade_id = idArray[2];

                    var target = $("#modal-editar-especialidade-"+especialidade_id);
                    target.modal();
                });
            }

            function editarRamoModal(){
                var buttonEditRamoModal = $(".btn-editar-ramo");

                buttonEditRamoModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var ramo_id = idArray[2];

                    var target = $("#modal-editar-ramo-"+ramo_id);
                    target.modal();
                });
            }

            function ramoModal(){
                var buttonRamoModal = $(".btn-ramo-modal");

                buttonRamoModal.on('click', function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var ramo_id = idArray[1];

                    var target = $("#modal-especialidade-"+ramo_id);
                    target.modal();
                });
            }

            especialidadeModal();
            editarRamoModal();
            editarEspecialidadeModal();
            ramoModal();

        });
    </script>
@endsection