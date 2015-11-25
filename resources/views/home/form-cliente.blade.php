

{!! Form::open([

    'route'  => 'register.user',
    'method' => 'post',
    'id'     => 'vue',
    'class'  => ''

])!!}

<div class="form-group">


    <div class="row">

        <div class="col-xs-6">
            {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Nome'] ) !!}
        </div>

        <div class="col-xs-6">
            {!! Form::text('lastname',old('lastname'),['class'=>'form-control','placeholder'=>'Sobrenome'] ) !!}
        </div>

    </div>

</div>

<div class="form-group">

    {!! Form::email('email',old('email'),['class'=>'form-control','placeholder'=>'E-mail']) !!}

</div>

<div class="form-group">

    {!! Form::text('phone',old('phone'),['class'=>'form-control','placeholder'=>'Telefone','data-mask'=>'phone']) !!}

</div>

<div class="form-group">

    {!! Form::password('password', ['class'=>'form-control','placeholder'=>'Senha','maxlength'=>10]) !!}

    <p class="help-block">* digite pelo menos 5 caracteres e no máximo 10 caracteres.</p>

</div>

<div class="form-group">

    {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirmar Senha','maxlength'=>10]) !!}

</div>


<div class="form-group" id="tem-plano">
    <label for="">Possui plano de saúde?</label>
    <input type="radio" name="plano" value="1"> Sim
    <input type="radio" name="plano" value="2"> Não
</div>

<div class="form-group" id="empresa-planos" style="display:none;">
    <label for="user_plano">Selecione a empresa: </label>
    <select name="user_plano_empresa" id="user_plano_empresa">
        <option value="">Selecione...</option>
        @foreach($planos as $plano)
            <option value="{{$plano->id}}">{{$plano->titulo}}</option>
        @endforeach
    </select>
</div>

<div class="form-group" id="planos" style="display:none;">
    <label for="user_plano">Selecione o plano: </label>
    <select name="id_plano" id="id_plano" data-title="Selecione o plano">

    </select>
</div>

<div class="form-group">

    {!! Form::submit('Criar minha conta',['class'=>'btn btn-success btn-lg']) !!}

</div>


{!! Form::close()  !!}
<script>
    $(function(){
        var temPlanoInput = $("#tem-plano").find('input');
        var target = $("#empresa-planos");
        var target2 = $("#planos");

        temPlanoInput.on("change", function(){
            var value = $(this).val();

            if (value == 1){
                target.fadeIn();
            }else{
                if (value == 2){
                    target.fadeOut();
                    target2.fadeOut();
                }
            }
        });

        $("#user_plano_empresa").on("change", function(){
            var checked = $(this).find('option:selected');

            if (checked){
                var value = $(this).val();

                if (value){
                    var params = {id:value};
                    $.ajax({
                        url: "{{route('plano.ajaxplanocliente')}}",
                        method: "get",
                        dataType: "json",
                        data: params,
                        success: function(json) {
                            $("#planos").fadeIn();
                            $("#planos").find('select').html('<option value="">Selecione o plano</option>');

                            for (var i = 0; i < json.planos.length; i++) {
                                $("#id_plano").append('<option value="' + json.planos[i].id + '">' + json.planos[i].titulo + '</option>');
                                $("#id_plano").selectpicker('refresh');
                            }
                        }
                    });
                }
            }else{

            }
        });
    });
</script>