{!!
    Form::open([
        'route'   => isset($localidade->id) ? [ 'update.localidade' , 'id' => $localidade->id ] : 'store.localidade',
        'method'  => isset($localidade->id) ? 'put' : 'post',
        'class'   => 'jumbotron'
     ])
!!}

<div class="form-group">

    <div class="row">

        <div class="col-xs-2">

            {!! Form::label('tipo','*Tipo:') !!}

            <select name="tipo" id="tipo" class="form-control" data-title="Selecione">

                @foreach($tipos as $tipo => $label_tipo )
                    <option value="{{ $tipo  }}" {{ isset($localidade->id) && $localidade->tipo == $tipo ? 'selected' : null }} >{{ $label_tipo }}</option>
                @endforeach

            </select>



        </div>

        <div class="col-xs-3">
            {!! Form::label('cep','*CEP:') !!}
            {!! Form::text('cep',isset($localidade->id) ? $localidade->cep : null ,['class'=>'form-control','data-mask'=>'cep']) !!}
        </div>


    </div>


</div>


<div class="form-group">

    <div class="row">

        <div class="col-xs-4">

            {!! Form::label('logradouro','*Logradouro:') !!}
            {!! Form::text('logradouro', isset($localidade->id) ? $localidade->logradouro : null , [ 'class' => 'form-control' ]) !!}

        </div>
        <div class="col-xs-2">

            {!! Form::label('numero','*Numero:') !!}
            {!! Form::text('numero',isset($localidade->id) ? $localidade->numero : null ,['class'=>'form-control']) !!}

        </div>
        <div class="col-xs-4">

            {!! Form::label('complemento','Complemento:') !!}
            {!! Form::text('complemento',isset($localidade->id) ? $localidade->complemento : null ,['class'=>'form-control']) !!}

        </div>

        <div class="col-xs-3">
            {!! Form::label('uf','*Estado:') !!}
            {!! Form::select('uf' , $estados , isset($localidade->id) ? $localidade->uf : 'PA' , ['class'=>'form-control', 'required' => 'required'] ) !!}
        </div>
        <div class="col-xs-3">
            {!! Form::label('cidade_id','*Cidade:') !!}

            <select name="cidade_id" id="cidade_id" class="form-control">
                <option value="">Selecione...</option>
                @if(isset($cidades))
                    @foreach($cidades as $cidade)
                        <option value="{{ $cidade->id }}" {{ $cidade->id == $localidade->cidade_id ? 'selected': null }}>{{ $cidade->nome  }}</option>
                    @endforeach
                @endif

                @if(isset($cidades_belem))
                    @foreach($cidades_belem as $cidade)
                        <option value="{{ $cidade->id }}" {{ $cidade->id == (isset($localidade) && $localidade->cidade_id) ? 'selected': null }}>{{ $cidade->nome  }}</option>
                    @endforeach
                @endif

            </select>

        </div>

        <div class="col-xs-3">

            {!! Form::label('bairro','*Bairro:') !!}

            {!! Form::text('bairro' , isset($localidade->id) ? $localidade->bairro->nome : null , [
                'class'        => 'form-control'
             ]) !!}

            {!! Form::hidden('bairro_id',isset($localidade->id) ? $localidade->bairro_id : null,[
                    'id'   =>   'bairro_id',
                    isset($localidade->id) ? null : 'disabled'
            ]) !!}
        </div>
    </div>
</div>

<div class="form-group">

    {!! Form::label('preco','Valor da consulta') !!}
    {!! Form::text('preco', isset($localidade->id) ? $localidade->preco : null , ['class'=>'form-control','data-mask'=>'decimal'])  !!}
</div>

<hr/>

<div class="form-group">

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}

</div>


{!! Form::close() !!}


@section('lib')

    <script src="{{ asset('lib/bootstrap3-typeahead/bootstrap3-typeahead.js') }}"></script>

@endsection

@section('script')

    <script type="text/javascript">

        $("#tipo").find('option:selected');

        if ($("#cep").val() == ''){
            $("#tipo option:eq(1)").attr('selected', true);
        }

        $("#tipo").on("change", function(){
            if ($("#tipo").val() == 'DOMICILIO'){
                $("#bairro").parent().removeClass("col-xs-3");
                $("#bairro").parent().addClass("col-xs-5");
                $("#bairro").prev('label').html('*Bairros atendidos (escreva os bairros separados por virgula)');
            }else{
                $("#bairro").parent().removeClass("col-xs-5");
                $("#bairro").parent().addClass("col-xs-3");
                $("#bairro").prev('label').html('*Bairro');
            }
        });

        $(function(){
            $("#cep").on("change", function(){
                var value = $(this).val();
                var data = {cep: value, formato: 'jsonp'};

                $.ajax({
                    url: "http://cep.republicavirtual.com.br/web_cep.php",
                    jsonp: "callback",
                    dataType: "jsonp",
                    data: data,
                    success: function(response){
                        if (response.resultado){
                            var verificador = response.cidade.substr(0,3).toUpperCase();
                            var target = $("#cidade_id").next().find('.dropdown-menu').find('ul').find('li');
                            var success = false;

                            target.each(function(index){
                                var span = $(this).find('a').find('span.text');
                                if (span.html().indexOf(verificador) > -1){
                                    success = true;
                                    span.parent('a').trigger('click');
                                    return success;
                                }
                            });

                            if (success){
                                $("#bairro").prop('disabled',false);
                                $("#bairro").val('');
                            //    $("#bairro").typeahead('destroy');
                                $("#bairro").val(response.bairro);
                                $("#logradouro").val(response.logradouro);
                            }else{
                                alert('CEP não encontrado');
                            }
                        }else{
                            alert('CEP não encontrado');
                        }
                    }
                });
            });

            $("#tipo").on("change",function(){
                var self = $(this);
                var logradouro = $("#logradouro");
                var numero     = $("#numero");
                var complemento = $("#complemento");
                var cep = $("#cep");
                var preco = $("#preco");

                if(self.val()==='CONSULTORIO')
                {
                   // preco.parent('div').hide();
                    logradouro.parent('div').show();
                    numero.parent('div').show();
                    complemento.parent('div').show();
                    cep.parent('div').show();

                }else
                {
                   // preco.parent('div').show();
                    logradouro.parent('div').hide();
                    numero.parent('div').hide();
                    complemento.parent('div').hide();
                    cep.parent('div').hide();
                }

            });


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
                    var options = '<option value="">Selecione um Estado</option>';
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

//                        $("#bairro").prop('disabled',false);
//                        $("#bairro").val('');
//
//                        $("#bairro_id").val('');
//
//                        $("#bairro").typeahead('destroy');
//
//                        $("#bairro").typeahead({
//                            source : response.data,
//                            autoSelect: true
//                        });

                        $("#bairro").change(function(){

//                            var that            = $(this);
//                            var ba_id   = $("#bairro_id");
//                            var current         = that.typeahead('getActive');
//
//                            if( current.name === that.val() )
//                            {
//                                bairro_id.prop('disabled',false).val( current.id );
//
//                            }else{
//
//                                bairro_id.prop('disabled',true ).val('');
//                            }

                        });

                    });
                }

            });

            var bairroAtual = $("#bairro").val();
            var bairroIdAtual = $("#bairro_id").val();

            $("#bairro").on("keyup", function(){
//                var bairro = $(this).val();
//                if (bairroAtual != bairro){
//                    $("#bairro_id").val('');
//                }else{
//                    $("#bairro_id").val(bairroIdAtual);
//                }
            });

        });

    </script>

@endsection