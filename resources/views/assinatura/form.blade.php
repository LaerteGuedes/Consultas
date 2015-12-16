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
                    @if ($ass->id == $assinatura->id)
                        <option value="{{$ass->id}}" selected>{{$ass->titulo}} - {{$ass->valor}}</option>
                    @else
                        <option value="{{$ass->id}}">{{$ass->titulo}} - {{$ass->valor}}</option>
                    @endif
                @endforeach
            </select>
            <br><br>
        </div>
        <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
        <input type="hidden" name="assinatura_status" id="assinatura_status" value="PERIODO_TESTES">
        @if(isset($assinatura->id))
            <input type="hidden" name="id" id="id" value="{{$assinatura->id}}">
       @endif
    </div>
</div>
<hr/>
<div class="form-group">
    {!! Form::submit('Salvar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}
</div>
{!! Form::close() !!}