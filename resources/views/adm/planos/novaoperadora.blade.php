@extends('site')
@section('title', 'Nova operadora')

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

                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default">

                        <div class="panel-heading header-sallus">
                            <h2>Nova Operadora</h2>
                        </div>


                        <div class="panel-body">
                            <div>
                                <form method="POST" action="{{route('adm.salvaoperadora')}}" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><strong title="Nome da Operadora">Nome: </strong></div>
                                            <input class="form-control" name="titulo" type="">
                                        </div>
                                    </div>
                                    <input type="hidden" name="exibir" value="1">
                                    <div class="form-group">
                                        <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div><!-- /Painel padrão com cabeçalho -->

                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->

            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection