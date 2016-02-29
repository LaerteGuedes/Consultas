
@inject('calendarService','App\Services\CalendarService')
<div class="row">

    <!-- Conteúdo -->
    <div class="col-lg-12">
        <div class="panel panel-default">

            <div class="panel-heading header-sallus">
                <div class="row">
                    <div class="col-lg-12">
                        <h2><i class="fa fa-exclamation-circle  fa-2"></i> Agenda de Consultas</h2>
                    </div><!-- /.col-lg-12 -->
                </div>
            </div>

            <div class="panel-body contract">
                <div class="header-nav row">
                    <div class="col-lg-3 text-left">
                        <a  href="?previous_mes={{ $previous_mes }}"><i class="fa fa-chevron-left"></i> </a>
                    </div>
                    <div class="col-lg-6 text-center">
                        {{ $calendarService->meses[date('n',strtotime($mes))] }}
                    </div>
                    <div class="col-lg-3 text-right">
                        <a  href="?next_mes={{ $next_mes }}"> <i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>

                <div id="consultas">
                    <!-- Painel collapse -->

                    @if(count($consultas)>0)
                        @foreach($consultas as $data_agenda => $data_consultas)
                            <div class="panel-group expandir" role="tablist">
                                <div class="panel-default">
                                    <div class="panel-heading" role="tab" id="collapsePanel1Heading_{{ $data_agenda }}">
                                        <h4 class="panel-title">
                                            <div class="row">
                                                <div class="col-20 text-extra-large">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $data_agenda }}" aria-expanded="false" aria-controls="collapsePanel1">{{ date('d/m/Y',strtotime($data_agenda)) }}</a>
                                                </div>
                                                <div class="col-30 text-extra-large">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $data_agenda }}" aria-expanded="false" aria-controls="collapsePanel1">Pacientes</a>
                                                </div>
                                                <div class="col-50 text-extra-large text-right">
                                                    <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1_{{ $data_agenda }}" aria-expanded="false" aria-controls="collapsePanel1"> total: {{ count($data_consultas) }}
                                                                <!--
                                              <a href="agendar-data-hora.php" class="btn btn-primary btn-xs red-btn">Cancelar todas deste dia</a>
                                              -->

                                                    </a>
                                                </div>
                                            </div>
                                        </h4>
                                    </div>

                                    <div id="collapsePanel1_{{ $data_agenda }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsePanel1Heading_{{ $data_agenda }}">
                                        <div class="panel-body">

                                            <!-- Lista padrão -->
                                            <ul class="list-group">
                                                @foreach($data_consultas as $consulta)
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col-20 text-large">
                                                                <p class="list-group-item-text"><i class="fa fa-clock-o"></i> {{$consulta->horario_agenda }}h</p>
                                                            </div><!-- /. -->
                                                            <div class="col-60 text-large">
                                                                {{  $consulta->paciente }}
                                                            </div><!-- /. -->
                                                            <div class="col-20 text-right">

                                                                @if($consulta->status =='CONFIRMADA')
                                                                    @if($consulta->data_agenda < date('Y-m-d'))
                                                                        <a href="javascript:void(0);" class="btn btn-primary btn-xs green-btn realizar-consulta" data-consulta="{{$consulta->id }}">Realizada</a>
                                                                    @endif
                                                                    <a href="javascript:void(0);" class="btn btn-primary btn-xs red-btn confirmar-consulta" data-consulta="{{$consulta->id }}"  data-resposta="nao">Cancelar</a>

                                                                @elseif($consulta->status =='CANCELADA')

                                                                    <span class="red">
                                                        <strong>{{  $consulta->status }}</strong>
                                                      </span>

                                                                @elseif($consulta->status == 'AGUARDANDO')
                                                                    @if($consulta->data_agenda < date('Y-m-d'))
                                                                        <a href="javascript:void(0);" class="btn btn-primary btn-xs green-btn realizar-consulta" data-consulta="{{$consulta->id }}">Realizada</a>
                                                                    @endif
                                                                    <a href="javascript:void(0);" class="btn btn-primary btn-xs red-btn confirmar-consulta" data-consulta="{{$consulta->id }}"  data-resposta="nao">Cancelar</a>
                                                                @else

                                                                    <span class="green">
                                                        <strong>{{  $consulta->status }}</strong>
                                                      </span>

                                                                @endif

                                                            </div><!-- /. -->
                                                        </div>
                                                    </li>
                                                @endforeach

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


                </div>
            </div>

        </div><!-- /.panel-default -->
    </div><!-- /.col-lg-12 -->
    <!-- /Conteúdo -->

</div><!-- /.row -->


@section('script')

    <script type="text/javascript">

        $(function(){

            $(".confirmar-consulta").on('click',function(){

                var me =  $(this);
                var data = {};
                data.resposta   = me.data('resposta');
                data.consulta_id = me.data('consulta');
                var url = "{{ url('/confirmar/consulta') }}";

                $.get(url,data,function(response){

                    if(response.success === true)
                    {
                        location.reload();
                    }

                });
            });

            $(".realizar-consulta").on('click',function(){

                var me =  $(this);
                var data = {};
                data.consulta_id = me.data('consulta');
                var url = "{{ url('/realizar/consulta') }}";

                $.get(url,data,function(response){

                    if(response.success === true)
                    {
                        location.reload();
                    }

                });
            });
        });

    </script>

@endsection