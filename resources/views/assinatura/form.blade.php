{!!
    Form::open([
        'route'   => isset($assinatura->id) ? [ 'update.assinatura' , 'id' => $assinatura->id ] : 'store.assinatura',
        'method'  => 'post',
        'class'   => 'jumbotron'
     ])
!!}

<div class="form-group">
    <div class="row">
        <div class="col-xs-12">
            {!! Form::label('assinatura_id','*Pacote de assinatura:') !!}
            <select name="assinatura_id" id="assinatura_id" class="form-control" data-title="Selecione">
                @foreach($assinaturas as $ass)
                        <option value="{{$ass->id}}">{{$ass->titulo}} - {{$ass->valor}}</option>
                @endforeach
            </select>
            <br><br>
        </div>
        Desejo utilizar a versão de testes (válido por 30 dias): <input type="checkbox" name="versao_teste">
        <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
        <input type="hidden" name="assinatura_status" id="assinatura_status" value="PERIODO_TESTES">
    </div>
</div>
<hr/>
<div class="form-group">
    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}
</div>
{!! Form::close() !!}