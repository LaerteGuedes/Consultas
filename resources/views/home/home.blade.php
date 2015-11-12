@extends('site')

@section('title','Página Inicial')

@section('content')

    <section class="main dashboard">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">


                    <h1 class="text-center">Agende uma consulta...</h1>

                    {!! Form::open([

                                    'route' => 'resultado.busca',
                                    'method'=> 'get',
                                    'class' => 'jumbotron'

                            ]) !!}


                    <div class="opacity">
                        <div class="form-group">

                            <div class="row">

                                <div class="col-lg-3 col-xs-12">

                                    {!!  Form::select('uf' , array('PA') , 'PA' , ['class'=>'form-control','id'=>'uf', 'disabled' => true] ) !!}
                                </div>
                                <div class="col-lg-3 col-xs-12">
                                    <select name="cidade_id" id="cidade_id" class="form-control" data-title="Selecione a Cidade">
                                        @foreach($cidades as $cidade)
                                            <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-xs-12">
                                    {!! Form::select('especialidade_id' , $especialidades , null , ['class'=>'form-control','data-title'=>'Tipo de Profissional','id'=>'especialidade_id'] ) !!}
                                </div>

                                <div class="col-lg-3 col-xs-12">
                                    <select name="ramo_id" id="ramo_id" class="form-control" data-title="Selecione a Especialidade"></select>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="row">

                                <div class="col-lg-9 col-xs-12">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user-md"></i></div>
                                        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nome do Profissional']) !!}
                                    </div>
                                </div>
                                <!--
                                <div class="col-lg-3 col-xs-12">
                                        <select name="data" id="data" class="form-control" data-title="Escolha a data da consulta">
                                        </select>
                                </div>
                                -->
                                <div class="col-lg-3 col-xs-12">
                                    {{--<select name="bairro_id" id="bairro_nome" class="form-control" data-title="Selecione o Bairro">--}}
                                    {{--</select>--}}
                                    <input class="form-control" type="text" name="bairro_nome" placeholder="Bairro">
                                </div>



                            </div>

                        </div>

                    </div>

                    <div class="form-group text-right ">

                        <button class="btn btn-primary btn-lg top10">
                            <i class="glyphicon glyphicon-search"></i>
                            PROCURAR
                        </button>

                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </section>

    <section class="bk-white padding60">
        <div class="container">
            <div class="row">
                <h1 class="text-center">Bem-vindo à SALLUS</h1>
                <h2 class="text-center">A plataforma virtual de agendamento de consultas</h2>
                <p class="text-center lead">Para prossionais da saúde que desejam divulgar serviços e precisam de um canal de relacionamento com o paciente, a  SALLUS oferece uma plataforma virtual de busca e agendamento de consultas para a Região Metropolitana de Belém.</p>
            </div>
        </div>
    </section>

    <section class="bk-blue padding60">
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-3 col-lg-5">
                    <h2 class="">Vantagens para os profissionais</h2>
                    <p class="">• Crie e organize sua agenda de atendimentos semanal.<br>
                        • Acompenhe as consultas agendadas por seus pacientes.<br>
                        • Tenha acesso a estatísticas sobre o seu perfil.<br>
                        • Veja as avaliações dos profissionais feitas por usuários do Salus.
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <img src="/imagens/pro.png" class="img-responsive hidden-xs hidden-sm img-pro">
                </div>

            </div>
        </div>
    </section>

    <section class="bk-white padding60">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 text-center">
                    <img src="/imagens/user.png" class="img-responsive hidden-xs hidden-sm img-user">
                </div>
                <div class="col-lg-8">
                    <h2 class="">Vantagens para os usuários</h2>
                    <p class="">• Localize profissionais de saúde em sua região.<br>
                        • Agende sua consulta de forma rápida e fácil.<br>
                        • Receba avisos de suas consultas próximo das datas agendadas.<br>
                        • Veja as avaliações dos profissionais feitas por usuários do Salus.
                    </p>
                </div>


            </div>
        </div>
    </section>

@endsection

@section('script')

    <script type="text/javascript">

        $(function(){


            $("#uf").on("change", function(){

                var self = $(this);
                var uf   = self.val();
                var url = "{{ url('ajax/listar-cidades')  }}/" + uf;
                if(uf != ""){

                    $.get(url,function(response){

                        var options = '';

                        $.each(response.data , function(v,k){

                            options += '<option value="'+ k.id +'">'+ k.nome +'</option>';
                        });

                        $("#cidade_id").empty().html(options);
                        $("#cidade_id").selectpicker('refresh');

                    });

                }else{
                    var options = '';
                    $("#cidade_id").empty().html(options);
                    $("#cidade_id").selectpicker('refresh');
                }
            });


            $('#cidade_id').on('change', function()
            {

                var self = $(this);
                var cidade = self.val();
                var url = "{{ url('ajax/listar-bairros')  }}/" + cidade;

                if(cidade != "")
                {
                    $.get(url, function(response){

                        var options = '';

                        $.each(response.data , function(v,k){

                            options += '<option value="'+ k.id +'">'+ k.name +'</option>';
                        });

                        $("#bairro_id").empty().html(options);
                        $("#bairro_id").selectpicker('refresh');

                    });
                }else{

                    var options = '';
                    $("#bairro_id").empty().html(options);
                    $("#bairro_id").selectpicker('refresh');

                }

            });

            $('#especialidade_id').on('change', function()
            {

                var self = $(this);
                var especialidade = self.val();
                var url = "{{ url('ajax/listar-ramos')  }}/" + especialidade;

                if(especialidade != "")
                {
                    $.get(url, function(response){

                        var options = '';

                        $.each(response.data , function(v,k){

                            options += '<option value="'+ k.id +'">'+ k.nome +'</option>';
                        });

                        $("#ramo_id").empty().html(options);
                        $("#ramo_id").selectpicker('refresh');

                    });
                }else{

                    var options = '';
                    $("#ramo_id").empty().html(options);
                    $("#ramo_id").selectpicker('refresh');

                }

            });


        });

    </script>

@endsection
