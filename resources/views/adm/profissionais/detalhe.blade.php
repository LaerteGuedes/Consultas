@extends('adm')
@section('title', 'Detalhes de Profissional')

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
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> Detalhes do profissional</h2>
                        </div>
                        <div class="panel-body">
                            <div>
                                @if (isset($assinatura->id))
                                    @if($assinatura->assinatura_status == 'PERIODO_TESTES')
                                        <p class="lead blue"><i class="fa fa-exclamation-circle blue"> </i> <strong>Em período de avaliação até o dia {{$assinatura->data_format}}</strong></p>
                                    @elseif($assinatura->assinatura_status == 'APROVADO')
                                        <p class="lead green"><i class="fa fa-exclamation-circle green"> </i> <strong>Assinatura: Plano Anual</strong></p>
                                    @elseif($assinatura->assinatura_status == 'SUSPENSO')
                                        <p class="lead red"><i class="fa fa-exclamation-circle red"> </i> <strong>Aguardando escolha de um plano de assinatura</strong></p>
                                    @endif
                                @else
                                    <p class="lead red"><i class="fa fa-exclamation-circle red"> </i> <strong>Aguardando a escolha de um plano de assinatura</strong></p>
                                @endif
                                <form method="POST" action="{{route('adm.profissionalupdate')}}" accept-charset="UTF-8" id="vue" class="">
                                    <input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-user-md"></i></div>
                                                    <input class="form-control" placeholder="Nome" name="name" value="{{$profissional->name}}" type="text">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <input class="form-control" placeholder="Sobrenome" value="{{$profissional->lastname}}" name="lastname" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                            <input class="form-control" placeholder="E-mail" name="email" value="{{$profissional->email}}" type="email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                            <input class="form-control" placeholder="Telefone"  value="{{$profissional->phone}}" data-mask="phone" name="phone" type="text">
                                        </div>
                                    </div>
                                    {{--<div class="form-group">--}}
                                    {{--<div class="input-group form-inline">--}}
                                    {{--<div class="input-group-addon"><i class="fa fa-asterisk"></i></div>--}}
                                    {{--<input class="form-control" placeholder="Senha" maxlength="10" name="password" type="password" value="value="{{$profissional->password}}">--}}
                                    {{--<input class="form-control" placeholder="Confirmar Senha" maxlength="10" name="password_confirmation" type="password" value="{{$profissional->password}}">--}}
                                    {{--</div>--}}
                                    {{--<p class="help-block">* digite pelo menos 5 caracteres e no máximo 10 caracteres.</p>--}}
                                    {{--</div>--}}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-info"></i></div>
                                            <input class="form-control" placeholder="Registro profissional" name="cid" type="cid" value="{{$profissional->cid}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{$profissional->id}}">
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