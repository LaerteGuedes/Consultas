@extends('adm')
@section('title', 'Bairro')

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
                    <form class="form-inline text-right form-filtro" action="#" method="get">
                        <div class="form-group">
                            <label>Filtrar por:</label>
                            <select class="form-control" name="cidade_id">
                                <option value="">Cidade</option>
                                @foreach($cidades as $cidade)
                                    <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success">Buscar</button>
                    </form>

                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default">
                        <div class="panel-heading header-sallus">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2><i class="fa fa-exclamation-circle fa-2"></i>Bairros</h2>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="sub-header"> <button class="btn btn-primary btn-agendar-multi" id="btn-bairro-modal">Adicionar bairro</button></div>
                                </div><!-- /.col-lg-4 -->
                            </div>
                        </div>
                        <ul class="list-group default">
                            @if(sizeof($bairros))
                                @foreach($bairros as $bairro)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-lg-10 text-left">{{$bairro->nome}}</div>
                                            <div class="col-lg-2">
                                                <button data-placement="top" data-toggle="tooltip" class="btn btn-primary btn-xs btn-editar-bairro" id="button-editar-{{$bairro->id}}" data-original-title="Editar"><i class="glyphicon glyphicon-edit"></i></button>
                                                <a data-confirm="true"  data-placement="top" data-toggle="tooltip" href="{{route('adm.excluirbairro', ["id" => $bairro->id])}}" class="btn btn-danger btn-xs" data-original-title="Apagar"><i class="glyphicon glyphicon-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <div id="modal-editar-bairro-{{$bairro->id}}" class="modal fade bairro-editar-modal" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Editar bairro {{$bairro->nome}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{route('adm.updatebairro')}}" accept-charset="UTF-8" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                                        <div class="form-group">
                                                            <label for="nome">Titulo: </label>
                                                            <input type="text" class="form-control" name="nome" id="nome" value="{{$bairro->nome}}" required/>
                                                        </div>
                                                        <input type="hidden" name="id" value="{{$bairro->id}}">
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
                                <p style="text-align:center;">Não há bairros cadastrados!</p>
                            @endif
                        </ul>
                    </div><!-- /.col-lg-9 -->
                    <!-- /Conteúdo -->
                    <div id="modal-novo-bairro" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Novo bairro</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{route('adm.salvabairro')}}" id="form-novo-bairro" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                        <div class="form-group">
                                            <label for="cidade_id">Escolha a cidade: </label>
                                            <select class="form-control" name="cidade_id" id="cidade_id">
                                                <option value="">Cidade</option>
                                                @foreach($cidades as $cidade)
                                                    <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <br>
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
                </div><!-- /.row -->
            </div> <!-- /container -->
        </div>
    </section> <!-- /section -->
@endsection
@section('script')
    <script>
        $(function(){
            function bairroModal(){
                var buttonBairroModal = $("#btn-bairro-modal");
                var target = $("#modal-novo-bairro");

                buttonBairroModal.on("click", function(){
                    target.modal();
                });
            }

            function editarBairroModal(){
                var buttonEditBairroModal = $(".btn-editar-bairro");

                buttonEditBairroModal.on("click", function(){
                    var idAttr = $(this).attr('id');
                    var idArray = idAttr.split('-');
                    var bairro_id = idArray[2];

                    var target = $("#modal-editar-bairro-"+bairro_id);
                    target.modal();
                });
            }

            bairroModal();
            editarBairroModal();

        });
    </script>
@endsection