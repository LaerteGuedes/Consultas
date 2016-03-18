@extends('site')
@section('title', 'Nova assinatura')

@section('content')

    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-heading header-sallus">
                        <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="">Local de atendimento</span> <i class="fa fa-angle-right"></i> <span class="">Horários de atendimento</span> <i class="fa fa-angle-right"></i> <span class="inativo">Planos de saúde</span><i class="fa fa-angle-right inativo"></i><span class="ativo"> Assinatura </span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('alerts')
                            <!-- Painel padrão -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Assinatura de pacote: </h3>
                        </div>
                    </div>
                    <!-- /Painel padrão -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('assinatura.form')
                </div>
            </div>
        </div>
    </section>
@endsection