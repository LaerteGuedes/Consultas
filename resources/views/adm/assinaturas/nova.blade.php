@extends('site')
@section('title', 'Nova assinatura')

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
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> Novo pacote de assinatura: </h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                <form method="POST" action="{{route('adm.salvaassinatura')}}" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><strong title="Nome">Nome: </strong></div>
                                            <input class="form-control" placeholder="Plano Trimestral" name="titulo" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><strong title="Valor">Valor ($) </strong></div>
                                            <input class="form-control" name="valor" data-mask="decimal" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><strong title="Parcelas">Parcelas: </strong></div>
                                            <input class="form-control" placeholder="3" name="numero_parcelas" type="text">
                                        </div>
                                    </div>
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