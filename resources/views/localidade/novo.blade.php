@extends('site')

@section('title','Novo Local')

@section('content')

    <section class="main adm">
        <div class="container">
            <div class="row">
                <!-- Conteúdo -->
                <div class="col-lg-12">
                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional-cadastro">
                        <div class="panel-body">
                            <div>
                                <div class="text-center">
                                    <h3>Cadastre um local onde você costume atender seus clientes.</h3>
                                    <p class="lead">Pode ser em um endereço fixo (como um consultório ou clínica) ou atendimento em domicílio (Home Care). Caso atenda em mais de um local, você poderá cadastrar os demais após concluir o primeiro.</p>
                                    <hr>
                                </div>
                                @include('alerts')

                                @include('localidade.form')
                            </div>
                        </div>
                    </div><!-- /Painel padrão com cabeçalho -->
                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->
            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->

@endsection

