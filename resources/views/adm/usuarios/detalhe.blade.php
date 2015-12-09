@extends('adm')
@section('title', 'Detalhes do usuário')


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
                            <h2><i class="fa fa-exclamation-circle  fa-2"></i> Detalhes do usuário</h2>
                        </div>


                        <div class="panel-body">
                            <div>
                                <form method="POST" action="{{route('adm.usuarioupdate')}}" accept-charset="UTF-8" id="vue" class=""><input name="_token" type="hidden" value="kmwqLZmVK8Us7ngbtRRXQVnuVdLq10UxL8y5v3HR">

                                    <div class="form-group">


                                        <div class="row">

                                            <div class="col-xs-6">
                                                <div class="input-group">
                                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                    <input class="form-control" placeholder="Nome" name="name" value="{{$usuario->name}}" type="text">
                                                </div>
                                            </div>

                                            <div class="col-xs-6">
                                                <input class="form-control" placeholder="Sobrenome" name="lastname" value="{{$usuario->lastname}}" type="text">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                                            <input class="form-control" placeholder="E-mail" name="email" value="{{$usuario->email}}" type="email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                            <input class="form-control" placeholder="Telefone" data-mask="phone" name="phone" value="{{$usuario->phone}}" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group form-inline">
                                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                            <input class="form-control" placeholder="Senha" maxlength="10" name="password" type="password" value="">
                                            <input class="form-control" placeholder="Confirmar Senha" maxlength="10" name="password_confirmation" type="password" value="">
                                        </div>
                                        <p class="help-block">* digite pelo menos 5 caracteres e no máximo 10 caracteres.</p>

                                    </div>

                                    {{--<div id="tem-plano" class="form-group">--}}
                                        {{--<p class="lead">Possui plano de saúde? </p>--}}
                                        {{--@if(isset($plano->id))--}}
                                            {{--<label class="radio-inline">--}}
                                                {{--<input type="radio" name="plano" value="1" checked=""> Sim--}}
                                            {{--</label>--}}
                                            {{--<label class="radio-inline">--}}
                                                {{--<input type="radio" name="plano" value="2"> Não--}}
                                            {{--</label>--}}
                                        {{--@else--}}
                                            {{--<label class="radio-inline">--}}
                                                {{--<input type="radio" name="plano" value="1"> Sim--}}
                                            {{--</label>--}}
                                            {{--<label class="radio-inline">--}}
                                                {{--<input type="radio" name="plano" value="2" checked=""> Não--}}
                                            {{--</label>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                    {{--@if(isset($plano->id))--}}
                                        {{--<div class="form-group" id="empresa-planos" style="">--}}
                                            {{--<p>Selecione a empresa: </p>--}}
                                            {{--{!! Form::select('user_plano_empresa' , $operadorasOptions , isset($plano->id_pai) ? $plano->id_pai : 0 , ['class'=>'form-control','id'=>'user_plano_empresa', ''] ) !!}--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group" id="planos" style="">--}}
                                            {{--<p>Selecione o plano: </p>--}}
                                            {{--{!! Form::select('user_plano' , $planos , $plano->id, ['class'=>'form-control','id'=>'user_plano', '']) !!}--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">--}}
                                        {{--</div>--}}
                                    {{--@else--}}
                                        {{--<div class="form-group" id="empresa-planos" style="display: none">--}}
                                            {{--<p>Selecione a empresa: </p>--}}
                                            {{--<select name="user_plano_empresa" id="user_plano_empresa">--}}
                                                {{--<option value="">Selecione...</option>--}}
                                                {{--@foreach($operadoras as $operadora)--}}
                                                    {{--<option value="{{$operadora->id}}">{{$operadora->titulo}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group" id="planos" style="display:none;">--}}
                                            {{--<p>Selecione o plano: </p>--}}
                                            {{--<select name="id_plano" id="id_plano">--}}
                                                {{--<option value="">Selecione...</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                        <div class="form-group">
                                            <input class="btn btn-success btn-lg" type="submit" value="Salvar Informações">
                                        </div>
                                    {{--@endif--}}
                                    <input type="hidden" name="user_id" value="{{$usuario->id}}">
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
@section('script')
<script>
    $(function(){
        $("#tem-plano").on('change', function(){

            var checked = $(this).find('input:checked');
            if (checked.val() == 1){
                $("#empresa-planos").fadeIn();
            }else{
                $("#empresa-planos").fadeOut();
                $("#planos").fadeOut();
            }
        });
        populateFormPlanoSelect();
    });
</script>
    @endsection