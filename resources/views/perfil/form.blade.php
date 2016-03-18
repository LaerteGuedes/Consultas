

{!! Form::open([

    'route'  => ['update.perfil','id'=> Auth::user()->id ],
    'method' => 'put',
    'id'     => 'vue',
    'class'  => 'jumbotron',
    'files'  => true

])!!}



<div class="form-group">

    <label>Imagem</label>
    <p>Use formato JPG/GIF/PNG. Imagens com 350x350 pixels apresentam o melhor resultado.</p>


    <div class="img-edit">

        @if(! Auth::user()->thumbnail )

            <img height="100" width="100" src="{{ asset('img/no-profile.png') }}" class="img-responsive"/>

        @else

            <img height="100" width="100" src="{{ Auth::user()->thumbnail }}" class="img-responsive"/>

        @endif
    </div>

    <hr>

    <input type="file" name="thumbnail" class="filestyle" data-buttonName="btn-default" data-input="false" data-iconName="fa fa-cloud-upload" data-buttonText="Carregar Foto ">

</div>

<div class="form-group">


    <div class="row">

        <div class="col-xs-6">
            {!! Form::text('name',Auth::user()->name,['class'=>'form-control','placeholder'=>'Nome'] ) !!}
        </div>

        <div class="col-xs-6">
            {!! Form::text('lastname', Auth::user()->lastname ,['class'=>'form-control','placeholder'=>'Sobrenome'] ) !!}
        </div>

    </div>

</div>

<div class="form-group">

    {!! Form::email('email',Auth::user()->email,['class'=>'form-control','placeholder'=>'E-mail', 'disabled']) !!}

</div>

<div class="form-group">

    {!! Form::password('password',['class'=>'form-control','placeholder'=>'Senha']) !!}

</div>

<div class="form-group">

    {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirmar senha']) !!}

</div>

<div class="form-group">

    {!! Form::text('phone',Auth::user()->phone,['class'=>'form-control','placeholder'=>'Telefone','data-mask'=>'phone']) !!}

</div>

@if(Auth::user()->role->name =='Profissional')


    <div class="form-group">

        {!! Form::select('especialidade_id', $especialidades , isset(Auth::user()->especialidade->especialidade_id ) ? Auth::user()->especialidade->especialidade_id : null, ['class'=>'form-control','data-title'=>'Selecione sua área de atuação']) !!}
    </div>

    <div class="form-group" v-show="profissional">

        {!! Form::text('cid',Auth::user()->cid , ['class'=>'form-control','placeholder'=>'Registro de Conselho'] ) !!}

        <p class="help-block">
            * digite o número de registro do seu conselho profissional.
        </p>
    </div>

@endif
@if (Auth::user()->role->name=='Cliente')
<div class="form-group" id="tem-plano">
    <label for="">Possui plano de saúde?</label>
    @if($temPlano)
        <input type="radio" name="plano" checked value="1"> Sim
        <input type="radio" name="plano" value="2"> Não
    @else
        <input type="radio" name="plano" value="1"> Sim
        <input type="radio" name="plano" checked value="2"> Não
    @endif
</div>


    @if($temPlano)
        <div class="form-group" id="empresa-planos">
            <label for="user_plano">Selecione a empresa: </label>
            <select name="user_plano_empresa" id="user_plano_empresa">
                <option value="">Selecione...</option>
                @foreach($planos as $plano)
                    @if($operadoraAtual->id == $plano->id)
                        <option value="{{$plano->id}}" selected>{{$plano->titulo}}</option>
                    @else
                        <option value="{{$plano->id}}">{{$plano->titulo}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    @else
        <div class="form-group" id="empresa-planos" style="display:none;">
            <label for="user_plano">Selecione a empresa: </label>
            <select name="user_plano_empresa" id="user_plano_empresa">
                <option value="">Selecione...</option>
                @foreach($planos as $plano)
                    <option value="{{$plano->id}}">{{$plano->titulo}}</option>
                @endforeach
            </select>
        </div>
    @endif


    <div class="form-group" id="planos" style="display:none;">
        <label for="user_plano">Selecione o plano: </label>
        <select name="id_plano" id="id_plano" data-title="Selecione o plano">

        </select>
    </div>
@endif

<div class="form-group">

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg']) !!}

</div>


{!! Form::close()  !!}
@if($temPlano)
    <input type="hidden" name="plano_selecionado" id="plano_selecionado" value="{{$planoAtual->id}}">
@else
    <input type="hidden" name="plano_selecionado" id="plano_selecionado" value="0">
@endif

<script>
    $(function(){
        var userPlanoEmpresaSelect = $("#user_plano_empresa").val();
        var displayEmpresaPlanos = $("#empresa-planos").css("display");

        var planoSelecionado = $("#plano_selecionado").val();
        if(!planoSelecionado){
            return false;
        }

        if (displayEmpresaPlanos != 'none'){
            $("#user_plano_empresa").val(userPlanoEmpresaSelect);
            $("#user_plano_empresa").change();

            var checked = $("#user_plano_empresa").val();
            if (checked){
                var params = {id:checked};
                $.ajax({
                    url: "{{route('plano.ajaxplanocliente')}}",
                    method: "get",
                    dataType: "json",
                    data: params,
                    success: function(json) {
                        $("#planos").fadeIn();
                        $("#planos").find('select').html('<option value="">Selecione o plano</option>');

                        for (var i = 0; i < json.planos.length; i++) {
                            if (json.planos[i].id == planoSelecionado){
                                $("#id_plano").append('<option value="' + json.planos[i].id + '" selected>' + json.planos[i].titulo + '</option>');

                            }else{
                                $("#id_plano").append('<option value="' + json.planos[i].id + '">' + json.planos[i].titulo + '</option>');
                            }
                            $("#id_plano").selectpicker('refresh');
                        }
                    }
                });
            }
        }


    });
</script>