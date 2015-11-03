@if($futuras->count())
    @foreach($futuras as $n => $futura)
    <div class="panel-group expandir" role="tablist">
        <div class="panel-default">
            <div class="panel-heading" role="tab" id="collapsePanel1Heading_{{ $futura->id }}">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-40 text-extra-large">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $futura->id }}" aria-expanded="{{ $n < 1 ? 'true':'false' }}" aria-controls="collapsePanel1">{{  date('d/m/Y',strtotime($futura->data_agenda))   }}</a>
                        </div>
                        <div class="col-10 text-extra-large">
           

                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $futura->id }}" aria-expanded="{{ $n < 1 ? 'true':'false' }}" aria-controls="collapsePanel1">Horário</a>
                        </div>
                        <div class="col-40 text-extra-large">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $futura->id }}" aria-expanded="{{ $n < 1 ? 'true':'false' }}" aria-controls="collapsePanel1">Local</a>
                        </div>
                        <div class="col-10 text-extra-large">
                        </div>
                    </div>
                </h4>
            </div>

            <div id="collapsePanel1_{{ $futura->id }}" class="panel-collapse collapse {{ $n < 1 ? 'in':'' }}" role="tabpanel" aria-labelledby="collapsePanel1Heading_{{ $futura->id }}">
                <div class="panel-body">

                    <!-- Lista padrão -->
                    <ul class="list-group">
                        <li class="list-group-item profissional">
                            <div class="row">
                                <div class="col-40">
                                    <a href="{{ route('profissional.detalhe', $futura->profissional_id ) }}">

                                        @if(!$futura->profissional->thumbnail)
                                                <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                                        @else  
                                                <img src="{{ $futura->profissional->thumbnail }}" class="avatar">
                                        @endif
                                    </a>
                                    <h4 class="list-group-item-heading">
                                        <a href="{{ route('profissional.detalhe', $futura->profissional_id ) }}">{{ $futura->profissional->name}} {{ $futura->profissional->lastname }}</a>
                                    </h4>
                                    <p class="list-group-item-text">

                                    </p>
                                </div><!-- /. -->
                                <div class="col-10">
                                    <p class="list-group-item-text"><i class="fa fa-clock-o"></i> {{ date("H:i",strtotime($futura->horario_agenda) ) }}</p>
                                </div><!-- /. -->
                                <div class="col-40">
                                    <div>
                                        {{ $futura->localidade->logradouro }} , {{ $futura->localidade->numero }} 
                                        {{ $futura->localidade->complemento }}<br>
                                        {{ $futura->localidade->bairro->nome }} • {{ $futura->localidade->cep }}• {{ $futura->localidade->cidade->nome }}/{{ $futura->localidade->uf }}
                                    </div>
                                </div><!-- /. -->
                                <div class="col-10">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-xs red-btn confirmar-consulta" data-consulta="{{$futura->id }}"  data-resposta="nao">CANCELAR</a>
                                </div><!-- /. -->
                            </div>
                            <div class="dark action">Você poderá comparecer à consulta? 
                                <a href="javascript:void(0);" class="btn btn-primary green-btn confirmar-consulta" data-consulta="{{$futura->id }}" data-resposta="sim">SIM</a> 
                                <a href="javascript:void(0);" class="btn btn-primary red-btn confirmar-consulta" data-consulta="{{$futura->id }}"  data-resposta="nao">NÃO</a>
                            </div>
                        </li>
                    </ul><!-- /Lista padrão -->

                </div>
            </div>
        </div>
    </div>
    @endforeach
@else

    <hr>
    @include('notfound')   
@endif