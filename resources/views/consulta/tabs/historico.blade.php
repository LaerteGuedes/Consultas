@if($historicos->count())
    @foreach($historicos as $historico)
    <div class="panel-group expandir" role="tablist">
        <div class="panel-default">
            <div class="panel-heading" role="tab" id="collapsePanel1Heading">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-40 text-extra-large">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">{{  date('d/m/Y',strtotime($historico->data_agenda))   }}</a>
                        </div>
                        <div class="col-10 text-extra-large">
           

                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">Horário</a>
                        </div>
                        <div class="col-40 text-extra-large">
                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">Local</a>
                        </div>
                        <div class="col-10 text-extra-large">
                        </div>
                    </div>
                </h4>
            </div>

            <div id="collapsePanel1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapsePanel1Heading">
                <div class="panel-body">

                    <!-- Lista padrão -->
                    <ul class="list-group">
                        <li class="list-group-item profissional">
                            <div class="row">
                                <div class="col-40">
                                    <a href="{{ route('profissional.detalhe', $historico->profissional_id ) }}">
                                            @if(!$historico->profissional->thumbnail)
                                                <img src="{{ asset('img/no-profile.png') }}" class="avatar">
                                            @else  
                                                <img src="{{ $historico->profissional->thumbnail }}" class="avatar">
                                             @endif
                                    </a>
                                    <h4 class="list-group-item-heading">
                                        <a href="{{ route('profissional.detalhe', $historico->profissional_id ) }}">{{ $historico->profissional->name}} {{ $historico->profissional->lastname }}</a>
                                    </h4>
                                    <p class="list-group-item-text">

                                    </p>
                                </div><!-- /. -->
                                <div class="col-10">
                                    <p class="list-group-item-text"><i class="fa fa-clock-o"></i> {{ date("H:i",strtotime($historico->horario_agenda) ) }}</p>
                                </div><!-- /. -->
                                <div class="col-40">
                                    <div>
                                        {{ $historico->localidade->logradouro }} , {{ $historico->localidade->numero }} 
                                        {{ $historico->localidade->complemento }}<br>
                                        {{ $historico->localidade->bairro->nome }} • {{ $historico->localidade->cep }}• {{ $historico->localidade->cidade->nome }}/{{ $historico->localidade->uf }}
                                    </div>
                                </div><!-- /. -->
                                <div class="col-10">
                                    @if($historico->status == 'REALIZADA')

                                     <a href="{{ url(route('profissional.detalhe', $historico->profissional_id ) . '#avaliacoes') }}" class="btn btn-primary btn-xs blue-btn">AVALIE 
                                     	<i class="fa fa-star"></i>
                                     </a>

                                    @endif
                                </div><!-- /. -->
                            </div>
								
							@if($historico->status === 'CANCELADA')	
                             <div class="red action"><strong>Consulta cancelada por você em {{ date('d/m/Y \a\s H:i',strtotime($historico->updated_at) ) }}.</strong></div>
							@elseif($historico->status === 'CONFIRMADA')
                             <div class="green action"><strong>Consulta confirmada por você em {{ date('d/m/Y \a\s H:i',strtotime($historico->updated_at) ) }}.</strong></div>
                             @elseif($historico->status === 'REALIZADA')
                             <div class="green action"><strong>Consulta já realizada por você!.</strong></div>
                             @endif
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