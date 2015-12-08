@extends('adm')
@section('title', 'Lista de Usuários')

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
                    <form class="form-inline text-right form-filtro">
                        <div class="form-group">
                            <label>Filtrar por:</label>
                            <input type="text" class="form-control" id="nome" placeholder="Nome do usuário">
                            <select class="form-control">
                                <option value="">Estado</option>
                            </select>
                            <select class="form-control">
                                <option value="">Cidade</option>
                            </select>
                        </div>
                    </form>

                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default">

                        <div class="panel-heading header-sallus">
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> Usuários</h2>
                        </div>

                        <ul class="list-group default">
                            @foreach($usuarios as $usuario)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-lg-8"><a href="{{route('adm.usuariodetalhe',['id' => $usuario->id])}}">{{$usuario->name}}</a></div>
                                        <div class="col-lg-4 text-right">{{$usuario->email}}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        {!! $usuarios->render() !!}

                    </div><!-- /.col-lg-9 -->
                    <!-- /Conteúdo -->

                </div><!-- /.row -->
            </div> <!-- /container -->
    </section> <!-- /section -->
@endsection