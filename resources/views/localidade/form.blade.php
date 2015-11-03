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

    </div>


</div>


<div class="form-group">

    <div class="row">
            <div class="col-xs-3">
                     {!! Form::label('cep','*CEP:') !!}
                     {!! Form::text('cep',isset($localidade->id) ? $localidade->cep : null ,['class'=>'form-control','data-mask'=>'cep']) !!}
            </div>
            <div class="col-xs-3">
                    {!! Form::label('uf','*Estado:') !!}
                    {!! Form::select('uf' , $estados , isset($localidade->id) ? $localidade->uf : null , ['class'=>'form-control'] ) !!}
            </div>
            <div class="col-xs-3">
                {!! Form::label('cidade_id','*Cidade:') !!}

                <select name="cidade_id" id="cidade_id" class="form-control">

                        <option value="">Selecione um estado</option>

                        @if(isset($cidades))
                            @foreach($cidades as $cidade)

                                <option value="{{ $cidade->id }}" {{ $cidade->id == $localidade->cidade_id ? 'selected': null }}>{{ $cidade->nome  }}</option>

                            @endforeach
                        @endif

                </select>

            </div>

            <div class="col-xs-3">

                {!! Form::label('bairro','*Bairro:') !!}

                {!! Form::text('bairro' , isset($localidade->id) ? $localidade->bairro->nome : null , [

                    'class'        => 'form-control',
                    'autocomplete' => 'off',
                    isset($localidade->id) ? null : 'disabled'


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

    $(function(){


            $("#tipo").on("change",function(){
                    var self = $(this);
                    var logradouro = $("#logradouro");
                    var numero     = $("#numero");
                    var complemento = $("#complemento");
                    var cep = $("#cep");
                    var preco = $("#preco");

                    if(self.val()==='CONSULTORIO')
                    {
                        preco.parent('div').hide();
                        logradouro.parent('div').show();
                        numero.parent('div').show();
                        complemento.parent('div').show();
                        cep.parent('div').show();

                    }else
                    {
                        preco.parent('div').show();
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

                        $("#bairro").prop('disabled',false);

                        $("#bairro").val('');

                        $("#bairro_id").val('');

                        $("#bairro").typeahead('destroy');

                        $("#bairro").typeahead({
                            source : response.data,
                            autoSelect: true
                        });

                        $("#bairro").change(function(){

                            var that            = $(this);
                            var bairro_id   = $("#bairro_id");
                            var current         = that.typeahead('getActive');

                            if( current.name === that.val() )
                            {
                                bairro_id.prop('disabled',false).val( current.id );

                            }else{

                                bairro_id.prop('disabled',true ).val('');
                            }

                        });

                    });
                }

            });


    });

</script>

@endsection