@extends('site')

@section('title','Página Inicial')

@section('content')

    <section class="main dashboard">
        @include('alerts')
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                  <div class="logo">
                    <img src="/imagens/logo.png">
                  </div>


                    <h1 class="text-center">Agende uma consulta...</h1>

                    {!! Form::open([

                                    'route' => 'resultado.busca',
                                    'method'=> 'get',
                                    'class' => ''

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
                                <div class="col-lg-6 col-xs-12">
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
                                    <input type="text" name="data_desejada" placeholder="Data desejada" data-mask = 'date' class="form-control"/>
                                </div>
                                <div class="col-lg-3 col-xs-12">
                                    {{--<select name="bairro_id" id="bairro_nome" class="form-control" data-title="Selecione o Bairro">--}}
                                    {{--</select>--}}
                                    <input class="form-control" type="text" name="bairro_nome" id="bairro_nome" placeholder="Bairro">
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

    <section class="bk-grey padding30 home">
        <div class="container text-center">
          <h2><i class="fa fa-mobile"></i> Baixe nosso aplicativo grátis! <a href="#"><img src="/imagens/store-google.jpg"></a> <a href="#"><img src="/imagens/store-apple.jpg"></a></h2>
        </div>
    </section>

    <section class="bk-white padding60 home">
        <div class="container">
            <div class="row">
              <div class="col-lg-4">
                <div class="text-center">
                  <span class="fa-stack fa-lg fa-3x">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                  </span>
                  <h3>CADASTRO</h3>
                </div>
                <div>
                  <p>Encontre o profissional que deseja e marque um agendamento instantaneamente. <strong>É grátis!</strong></p>
                  <strong>Características</strong>
                  <ul>
                    <li>Encontrar uma lista de profissionais da saúde em um só lugar.</li>
                    <li>Ver horários disponíveis do profissional que procura. Basta clicar e agendar instantaneamente!</li>
                    <li>Receber avisos de suas consultas agendadas.</li>
                  </ul>
                </div>
                <div class="text-center">
                  <a href="#" class="btn btn-primary btn-lg top10">CADASTRAR</a>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="text-center">
                  <span class="fa-stack fa-lg fa-3x">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-user-md fa-stack-1x fa-inverse"></i>
                  </span>
                  <h3>PROFISSIONAIS</h3>
                </div>
                <div>
                  <p><strong>Você é um profissional cinco estrelas?<br> Quer conquistar novos clientes?</strong><br><br>
                  Faça seu cadastro na Sallus e ofereça um melhor conforto para seus clientes.</p>
                  <strong>Características</strong>
                  <ul>
                    <li>Atrair novos clientes.</li>
                    <li>Construir e fortalecer seu canal online.</li>
                    <li>Oferecer um serviço Premium para seus clientes.</li>
                  </ul>
                </div>
                <div class="text-center">
                  <a href="#" class="btn btn-primary btn-lg top10">CADASTRAR</a>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="text-center">
                  <span class="fa-stack fa-lg fa-3x">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-user-md fa-stack-1x fa-inverse"></i>
                  </span>
                  <h3>ATENDIMENTO</h3>
                </div>
                <div>
                  <p>Nossa equipe de atendimento está a sua disposição para esclarecer suas dúvidas.</p>
                </div>
                <div class="text-center">
                  <a href="#" class="btn btn-primary btn-lg top10">FALE CONOSCO</a>
                </div>
              </div>
            </div>
        </div>
    </section>

    <section class="bk-grey padding60 home video">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="">O que é Sallus?</h2>
                    <h3>A plataforma virtual de agendamento de consultas</h3>
                    <p class="">Para profissionais da saúde que desejam divulgar serviços e precisam de um canal de relacionamento com o paciente, a  SALLUS oferece uma plataforma virtual de busca e agendamento de consultas para a Região Metropolitana de Belém.</p>
                </div>
                <div class="col-lg-6">
                    <iframe width="645" height="363" src="https://www.youtube.com/embed/u3k_HLd_mec" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <section class="bk-white padding60 home depoimentos">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                  <h2 class="">DEPOIMENTOS</h2>
                </div>
                <div class="col-lg-3">
                  <div class="text-center">
                    <img src="/imagens/avatar-1.jpg">
                    <h3 class="">Dr. Carlos Silva</h3>
                    <p><i class="fa fa-quote-left"></i> Cras maximus, eros congue ultrices facilisis, nunc ante egestas lorem, et ullamcorper nisl ex sit amet erat. <i class="fa fa-quote-right"></i></p>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="text-center">
                    <img src="/imagens/avatar-2.jpg">
                    <h3 class="">Marina Costa</h3>
                    <p><i class="fa fa-quote-left"></i> Morbi tellus mauris, sollicitudin id neque eget, pharetra varius neque. <i class="fa fa-quote-right"></i></p>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="text-center">
                    <img src="/imagens/avatar-3.jpg">
                    <h3 class="">Dra. Luana Brandão</h3>
                    <p><i class="fa fa-quote-left"></i> Vivamus vitae accumsan nulla. Integer at elit elementum, pretium dolor quis, elementum tellus. <i class="fa fa-quote-right"></i></p>
                  </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('lib')

    <script src="{{ asset('lib/bootstrap3-typeahead/bootstrap3-typeahead.js') }}"></script>

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

                    //    $("#bairro_nome").prop('readonly',false);
                      //  $("#bairro_nome").prop('placeholder', '');
                        $("#bairro_nome").typeahead('destroy');

                        $("#bairro_nome").typeahead({
                            source : response.data,
                            autoSelect: true
                        });

                        $("#bairro_nome").change(function(){

                            var that = $(this);
                            var bairro_id   = $("#bairro_id");
                            var current = that.typeahead('getActive');

                            if( current.name === that.val() )
                            {
                                bairro_id.prop('disabled',false).val( current.id );

                            }else{

                                bairro_id.prop('disabled',true ).val('');
                            }

                        });
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
