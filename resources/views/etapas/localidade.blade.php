@extends('site')

@section('title','Novo Local')

@section('content')
    <section class="main adm">
        <div class="container">
            <div class="row">
                <!-- Conteúdo -->
                <div class="col-lg-12">
                    @include('alerts')
                    <!-- Painel padrão com cabeçalho -->
                    <div class="panel panel-default profissional-cadastro">

                        <div class="panel-heading header-sallus">
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="ativo">Local de atendimento</span> <i class="fa fa-angle-right inativo"></i> <span class="inativo">Horários de atendimento</span> <i class="fa fa-angle-right inativo"></i> <span class="inativo">Planos de saúde</span><i class="fa fa-angle-right inativo"></i><span class="inativo"> Assinatura </span></h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div class="text-center">
                                    <h3>Cadastre um local onde você costume atender seus clientes.</h3>
                                    <p class="lead">Pode ser em um endereço fixo (como um consultório ou clínica) ou atendimento em domicílio (Home Care). Caso atenda em mais de um local, você poderá cadastrar os demais após concluir o primeiro.</p>
                                    <hr>
                                </div>
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

