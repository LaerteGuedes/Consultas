

{!! Form::open([

    'route'  => 'register.user',
    'method' => 'post',
    'id'     => 'vue',
    'class'  => 'well'

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

<div class="checkbox">

    <label>
        <input type="checkbox" v-model="profissional"  v-on="change:showFieldCid"/> Caso você seja um profissional da saúde deixe marcado esta caixa.
    </label>

</div>

<div class="form-group" v-show="profissional">

    {!! Form::text('cid',old('cid') , ['class'=>'form-control','placeholder'=>'Registro de Conselho' ,'disabled','v-el'=>'fieldCid'] ) !!}

    <p class="help-block">
    * digite o número de registro do seu conselho profissional.
    </p>
</div>

<div class="form-group">

    {!! Form::submit('Criar minha conta',['class'=>'btn btn-success btn-lg']) !!}

</div>


{!! Form::close()  !!}