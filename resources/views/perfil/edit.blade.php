@extends('site')

@section('title','Editar Perfil')

@section('content')


    <section class="main">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('dashboard')  }}">Início</a></li>
                        <li class="active">Perfil</li>
                    </ol>
                </div>
            </div>
            @if(Auth::user()->role->name=='Profissional')
                @if(!isset(Auth::user()->especialidade->especialidade->nome))
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                <strong>
                                    <i class="glyphicon glyphicon-info-sign"></i>
                                </strong>
                                ATENÇÃO - Você precisa selecionar qual área de atuação você deseja
                                atender no sistema.
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="panel panel-default">
                <div class="panel-heading header-sallus">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> Meu perfil</h2>
                        </div><!-- /.col-lg-12 -->
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            @include('alerts')
                            <h3>Editar Perfil</h3>
                            @include('perfil.form')
                        </div>
                        <div class="col-lg-6">

                            <h3>Dados Atuais</h3>

                            <div class="jumbotron">

                                <dl class="dl-horizontal">
                                    <dt>Nome Completo:</dt>
                                    <dd>{{  Auth::user()->name . ' ' . Auth::user()->lastname  }}</dd>
                                    <dt>E-mail de Acesso:</dt>
                                    <dd>{{ Auth::user()->email }}</dd>
                                    <dt>Telefone de Contato:</dt>
                                    <dd>{{ Auth::user()->phone  }}</dd>
                                    <dt>Perfil:</dt>
                                    <dd>{{  Auth::user()->role->name}}</dd>
                                    @if (Auth::user()->role->name=='Cliente' && $temPlano)
                                        <dt>Empresa plano de saúde:</dt>
                                        <dd>{{$operadoraAtual->titulo}}</dd>
                                        <dt>Plano de saúde: </dt>
                                        <dd>{{$planoAtual->titulo}}</dd>
                                    @endif

                                    @if(Auth::user()->role->name=='Profissional')

                                        <dt>Área de Atuação:</dt>
                                        <dd>{{ isset(Auth::user()->especialidade->especialidade->nome) ? Auth::user()->especialidade->especialidade->nome : '-' }}</dd>

                                        <dt>Registro de Conselho</dt>
                                        <dd>{{ Auth::user()->cid }}</dd>

                                    @endif

                                </dl>


                            </div>



                        </div>

                    </div>
                </div>

            </div><!-- /.panel-default -->


        </div>

    </section>
    <script>
        $(function(){
            var temPlanoInput = $("#tem-plano").find('input');
            var target = $("#empresa-planos");
            var target2 = $("#planos");

            temPlanoInput.on("change", function(){
                var value = $(this).val();

                if (value == 1){
                    target.fadeIn();
                }else{
                    if (value == 2){
                        target.fadeOut();
                        target2.fadeOut();
                    }
                }
            });

            $("#user_plano_empresa").on("change", function(){
                var checked = $(this).find('option:selected');

                if (checked){
                    var value = $(this).val();

                    if (value){
                        var params = {id:value};
                        $.ajax({
                            url: "{{route('plano.ajaxplanocliente')}}",
                            method: "get",
                            dataType: "json",
                            data: params,
                            success: function(json) {
                                $("#planos").fadeIn();
                                $("#planos").find('select').html('<option value="">Selecione o plano</option>');

                                for (var i = 0; i < json.planos.length; i++) {
                                    $("#id_plano").append('<option value="' + json.planos[i].id + '">' + json.planos[i].titulo + '</option>');
                                    $("#id_plano").selectpicker('refresh');
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection


