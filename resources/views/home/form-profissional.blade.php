
{!! Form::open([

    'route'  => 'register.user',
    'method' => 'post',
    'id'     => 'vue',
    'class'  => 'well bk-white'

])!!}

<div class="form-group">


    <div class="row">

        <div class="col-xs-6">
           <div class="input-group">
                <div class="input-group-addon" style="display:block; float: left; width:50px;"><i class="fa fa-user"></i></div>
                <div style="display: block;float: right;width:192px;">
                    {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>'Nome', 'id' => 'name'] ) !!}
                </div>

           </div>
        </div>

        <div class="col-xs-6">
        {!! Form::text('lastname',old('lastname'),['class'=>'form-control','placeholder'=>'Sobrenome', 'id' => 'lastname']) !!}
        </div>

    </div>

</div>

<div class="form-group">

    {!! Form::email('email',old('email'),['class'=>'form-control','placeholder'=>'E-mail', 'id' => 'email']) !!}

</div>

<div class="form-group">

    {!! Form::text('phone',old('phone'),['class'=>'form-control','placeholder'=>'Nº do celular','data-mask'=>'phone', 'id' => 'phone']) !!}

</div>

<div class="form-group">
  <div class="row">
    <div class="col-lg-6">{!! Form::password('password', ['class'=>'form-control','placeholder'=>'Senha','maxlength'=>10, 'id' => 'password']) !!}</div>
    <div class="col-lg-6">{!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirmar Senha','maxlength'=>10, 'id' => 'password_confirmation']) !!}</div>
  </div>
  <p class="help-block">* digite pelo menos 5 caracteres e no máximo 10 caracteres.</p>

</div>

<div class="form-group">

    {!! Form::text('cid',old('cid') , ['class'=>'form-control','placeholder'=>'Registro do Conselho'] ) !!}

    <p class="help-block">
    * digite o número de registro do seu conselho profissional. Ex.: CRM 0000.
    </p>

</div>

<div class="form-group">

    {!! Form::submit('Criar minha conta',['class'=>'btn btn-success btn-lg']) !!}

</div>


{!! Form::close()  !!}