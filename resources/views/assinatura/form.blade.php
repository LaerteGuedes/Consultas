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
            <br>
            <div class="row text-center">
                {{--@foreach($assinaturas as $assinatura)--}}
                {{--<div class="panel panel-default col-xs-4">--}}
                {{--<div class="panel-heading">--}}
                {{--<h3 class="panel-title">{{$assinatura->titulo}}</h3>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                {{--<p><strong>R$ {{$assinatura->valor}},00</strong><br>--}}
                {{--<input type="radio" name="assinatura_id" value="{{$assinatura->id}}"></p>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@endforeach--}}
            </div>
            <br>
        </div>
        <div class="col-xs-12">
            {{--@if(!$usou_periodo_testes)--}}
            {{--Desejo utilizar a versão de testes (válido por 30 dias): <input type="checkbox" name="versao_teste">--}}
            {{--@endif--}}
        </div>
        <select name="pay_method" id="pay_method">
            <option value="">Selecione...</option>
        </select>
        <input type="hidden" name="assinatura_status" id="assinatura_status" value="AGUARDANDO">
        {{--<input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">--}}
    </div>
</div>
<hr/>
<div class="form-group">
    {!! Form::submit('Salvar e finalizar',['class'=>'btn btn-success btn-lg btn-block'] ) !!}
</div>
{!! Form::close() !!}
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js
"></script>
<script type="text/javascript">
    $(function(){
        PagSeguroDirectPayment.setSessionId('{{$sessionId}}');
        PagSeguroDirectPayment.getPaymentMethods({
            amount: 500.00,
            success:function(response){
                var pay = response.paymentMethods;

                $.each(pay, function(code, value){
                    console.log(value);
                    $("#pay_method").append("<option value='"+value.code+"'>"+value.name+"</option>");
                    $("#pay_method").selectpicker("refresh");
                });

                var boleto = pay.BOLETO;
                var cartao_credito = pay.CREDIT_CARD;
                var cartao_credito_options = cartao_credito.options;

            },
            error: function(response){
                console.log(response);
            },
            complete: function(response){
                console.log(response);
            }
        });
    });
</script>