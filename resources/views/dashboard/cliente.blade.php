<section class="main dashboard">
    <div class="container">
            <div class="row">

                <div class="col-lg-12">

                        @include('alerts')

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
                                {!! Form::select('uf' , $estados , null , ['class'=>'form-control','id'=>'uf', 'disabled'] ) !!}
                                                </div>
                                                <div class="col-lg-3 col-xs-12">
                                                        <select name="cidade_id" id="cidade_id" class="form-control" data-title="Selecione a Cidade">
                                                            <option value="">Selecione a cidade: </option>
                                                            @foreach($cidades as $cidade)
                                                                <option value="{{$cidade->id}}">{{$cidade->nome}}</option>
                                                            @endforeach
                                                        </select>
                                                </div>

                                                <div class="col-lg-3 col-xs-12">
                                {!! Form::select('especialidade_id' , $especialidades , null , ['class'=>'form-control','data-title'=>'Tipo de Profissional','id'=>'especialidade_id'] ) !!}
                                                </div>

                                                <div class="col-lg-3 col-xs-12">
                                                        <select name="ramo_id" id="ramo_id" class="form-control" data-title="Selecione a Especialidade">
                                                            <option value="">Selecione primeiro o tipo de profissional</option>
                                                        </select>
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
                                                        {{--<select name="bairro_id" id="bairro_id" class="form-control" data-title="Selecione o Bairro">--}}
                                                        {{--</select>--}}
                                                    <input class="form-control" type="text" name="bairro_nome" placeholder="Bairro">
                                                </div>



                                        </div>

                                </div>

                            </div>

                                <div class="form-group text-right ">

                                        <button class="btn btn-primary btn-lg top10">
                                                        <i class="glyphicon glyphicon-search"></i>
                                                        Pesquisar
                                        </button>

                                </div>

                        {!! Form::close() !!}

                </div>

        </div>
    </div>
</section>

<section class="bk-white">
    <div class="container">
        <div class="row">
          <h1 class="text-center">Bem-vindo à SALLUS</h1>
          <h2 class="text-center">A plataforma virtual de agendamento de consultas</h2>
          <p class="text-center">Para prossionais da saúde que desejam divulgar serviços e precisam de um canal de relacionamento com o paciente, a  SALLUS oferece uma plataforma virtual de busca e agendamento de consultas para a Região Metropolitana de Belém.</p>

        </div>
    </div>
</section>

@section('script')

<script type="text/javascript">

    $(function(){
            $("#uf").on("change", function(){

                    var self = $(this);
                    var uf   = self.val();
                    var url = "{{ url('listar-cidades')  }}/" + uf;
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
                var url = "{{ url('listar-bairros')  }}/" + cidade;

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
                var url = "{{ url('listar-ramos')  }}/" + especialidade;

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
                       $("#ramo_id").attr("disabled", false);

                }

            });


    });

</script>

@endsection
