{!!
    Form::open([
        'route'   => isset($servico->id) ? [ 'update.servico' , 'id' => $servico->id ] : 'store.servico',
        'method'  => isset($servico->id) ? 'put' : 'post',
        'class'   => 'jumbotron'
     ])
!!}

<div class="form-group">

    {!! Form::label('nome','*Nome:') !!}
    {!! Form::text('nome', isset($servico->id) ? $servico->nome : null , [ 'class' => 'form-control' ,'placeholder'=>'Preencha o nome.' ]) !!}

</div>

<hr/>

<div class="form-group">

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}

</div>


{!! Form::close() !!}