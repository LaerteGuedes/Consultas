@extends('site')

@section('title', 'Nova assinatura')

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
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="">Local de atendimento</span> <i class="fa fa-angle-right"></i> <span class="">Horários de atendimento</span> <i class="fa fa-angle-right"></i> <span class="">Planos de saúde</span><i class="fa fa-angle-right inativo"></i><span class="ativo"> Assinatura </span></h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                <div class="text-center">
                                    <h3>Escolha um plano de assinatura para usar a Sallus!</h3>
                                    <p class="lead">Nesta etapa você escolhe qual plano de assinatura prefere assinar para utilizar os serviços da Sallus. Se preferir pode usar o período de 30 dias para testes gratuitamente. Ao final do período de avaliação iremos informá-lo novamente sobre os planos de assinatura.</p>
                                    <hr>
                                </div>
                                @include('assinatura.form')
                            </div>
                        </div>
                    </div><!-- /Painel padrão com cabeçalho -->
                </div><!-- /.col-lg-9 -->
                <!-- /Conteúdo -->
            </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
@endsection

