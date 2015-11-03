<div class="row">
	
	<div class="col-lg-offset-2 col-lg-8">
		
			
		<h2 class="text-center">Agende uma consulta</h2>	
		
		{!! Form::open([
			
				'route' => 'resultado.busca',
				'method'=> 'get',
				'class' => 'jumbotron'

			]) !!}	
			
			
			<div class="form-group">
				{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Nome do Profissional']) !!}
			</div>	

			<div class="form-group">
				
				<div class="row">
					
					<div class="col-lg-6 col-xs-12">
                    	{!! Form::select('especialidade_id' , $especialidades , null , ['class'=>'form-control','data-title'=>'Tipo de Profissional','id'=>'especialidade_id'] ) !!}
					</div>

					<div class="col-lg-6 col-xs-12">
						<select name="ramo_id" id="ramo_id" class="form-control" data-title="Selecione a Especialidade"></select>
					</div>


				</div>

			</div>		

			<div class="form-group">
				
				<div class="row">
					<div class="col-lg-4 col-xs-12">
                    	{!! Form::select('uf' , $estados , null , ['class'=>'form-control','data-title'=>'Selecione o Estado','id'=>'uf'] ) !!}
					</div>
					<div class="col-lg-4 col-xs-1w">
						<select name="cidade_id" id="cidade_id" class="form-control" data-title="Selecione a Cidade">
						</select>
					</div>
					<div class="col-lg-4 col-xs-1w">
						<select name="bairro_id" id="bairro_id" class="form-control" data-title="Selecione o Bairro">
						</select>
					</div>
					
				</div>

			</div>



			<div class="form-group">
				
				<button class="btn btn-primary btn-lg">
						<i class="glyphicon glyphicon-search"></i>
						Pesquisar
				</button>

			</div>

		{!! Form::close() !!}

	</div>

</div>


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

                }

            });            


    });

</script>

@endsection
