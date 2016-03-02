<p>Filtro de pesquisa</p>


@inject('estadoService','App\Services\EstadoService')
@inject('cidadeService','App\Services\CidadeService')
@inject('especialidadeService','App\Services\EspecialidadeService')

<div class="panel panel-default filtro">
    <div class="panel-body">
        {!! Form::open([

        'route' => 'resultado.busca',
        'method'=> 'get',
    ]) !!}


        <div class="form-group">
            {!! Form::text('name',isset($_GET['name']) ? $_GET['name'] : null  ,['class'=>'form-control','placeholder'=>'Nome do Profissional']) !!}
        </div>

        <div class="form-group">

            {!! Form::select('especialidade_id' , $especialidadeService->listCombo() , isset($_GET['especialidade_id']) ? $_GET['especialidade_id'] : null , ['class'=>'form-control','data-title'=>'Tipo de Profissional','id'=>'especialidade_id'] ) !!}

        </div>

        <div class="form-group">
            {!! Form::select('ramo_id', isset($ramos) ? $ramos : array(), isset($ramo_id) ? $ramo_id : null, ['class'=>'form-control','data-title'=>'Especialidade','id'=>'ramo_id'] ) !!}

        </div>

        <div class="form-group">
            {!!  Form::select('uf' , array('PA') , 'PA' , ['class'=>'form-control','id'=>'uf', 'disabled' => true] ) !!}
        </div>

        <div class="form-group">
            {!!  Form::select('cidade_id' , isset($cidades) ? $cidades : array(), isset($_GET['cidade_id']) ? $_GET['cidade_id'] : null , ['class'=>'form-control','id'=>'uf'] ) !!}
        </div>

        <div class="form-group">
            {{--<select name="bairro_id" id="bairro_id" class="form-control" data-title="Selecione o Bairro">--}}
            {{--</select>--}}
            <input type="text" name="bairro_nome" id="bairro_nome" placeholder="Bairro" class="form-control">
        </div>

        <div class="form-group">
            <input type="text" name="data_desejada" placeholder="Data desejada" data-mask = 'date' class="form-control"/>
        </div>

        <div class="form-group">

            <button class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i>
                Pesquisar
            </button>

        </div>

        {!! Form::close() !!}
    </div>
</div>




@section('script_filtro')

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