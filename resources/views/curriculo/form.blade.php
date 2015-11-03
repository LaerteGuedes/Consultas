{!!
    Form::open([
        'route'   => isset($curriculo->id) ? [ 'update.curriculo' , 'id' => $curriculo->id ] : 'store.curriculo',
        'method'  => isset($curriculo->id) ? 'put' : 'post',
        'class'   => 'jumbotron'
     ])
!!}

<div class="form-group">

    {!! Form::label('descricao','*Descrição:') !!}
    {!! Form::textarea('descricao', isset($curriculo->id) ? $curriculo->descricao : null , [ 'class' => 'form-control' , 'rows'=> 10  ]) !!}

</div>

<hr/>

<div class="form-group">

    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}

</div>


{!! Form::close() !!}