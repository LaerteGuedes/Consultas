

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

    {!! Form::email('email',Auth::user()->email,['class'=>'form-control','placeholder'=>'E-mail','disabled']) !!}

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

<div class="form-group">

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg']) !!}

</div>


{!! Form::close()  !!}