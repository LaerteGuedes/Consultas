

<div id="full-clndr">

          <script type="text/template" id="full-clndr-template">

            <div class="clndr-controls">

               <div class="clndr-previous-button"><i class="glyphicon glyphicon-chevron-left"></i></div>
               <div class="current-month"><%= month %> <%= year %></div>
               <div class="clndr-next-button"><i class="glyphicon glyphicon-chevron-right"></i></div>

            </div>

            <div class="clndr-grid">
              <div class="days-of-the-week clearfix">
                <% _.each(daysOfTheWeek, function(day) { %>
                  <div class="header-day"><%= day %></div>
                <% }); %>
              </div>
              <div class="days">
                <% _.each(days, function(day) { %>
                  <div class="<%= day.classes %>" id="<%= day.id %>"><span class="day-number"><%= day.day %></span></div>
                <% }); %>
              </div>
            </div>

            <div class="event-listing">
              <div class="event-listing-title">AGENDA DO MÊS</div>
              <% _.each(eventsThisMonth, function(event) { %>
                  <div class="event-item">
                    <div class="event-item-name"><%= moment(event.date).format("DD/MM/YYYY") %> - <%= event.title %></div>
                    <div class="event-item-location"><%= event.localidade %></div>
                    <div>
                            <br/>
                            <div class="btn-group">

                                 <a class="btn btn-default" href="{{ url('editar/agenda') }}/<%= event.id %>" data-toggle="tooltip" data-placement="top" title="Editar"><i class="glyphicon glyphicon-edit"></i></a>
                                 <a class="btn btn-default" href="{{ url('delete/agenda') }}/<%= event.id %>" data-toggle="tooltip" data-placement="top" title="Apagar" data-confirm="true" onclick="return confirm('você tem certeza que deseja apagar este item?');"><i class="glyphicon glyphicon-trash"></i></a>

                            </div>

                            <hr/>
                    </div>
                  </div>
                <% }); %>
            </div>

          </script>

</div>

<template id="form-calendar">
    <form>
        <div class="form-group">

            <label for="localidade_id">Local:</label>
            <select name="localidade_id" id="localidade_id" class="form-control">
                  @if($localidades)
                        @foreach($localidades as $local)
                        <option value="{{ $local['id'] }}">{{ $local['local'] }}</option>
                        @endforeach
                  @else
                        <option value="">Você precisa registrar um local.</option>
                  @endif
            </select>

        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-6">
                    <label for="horas">Horas:</label>
                    <select name="horas" id="horas" class="form-control">
                        @foreach($horas as $hora)
                            <option value="{{ $hora }}">{{ $hora }} h</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-6">
                    <label for="minutos">Minutos:</label>
                    <select name="minutos" id="minutos" class="form-control">
                      @foreach($intervalos as $intervalo)
                          <option value="{{$intervalo}}">{{$intervalo}} min</option>
                      @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
</template>

@section('lib')

<script src= "{{ asset('lib/clndr/example/json2.js') }}"></script>
<script src="{{ asset('lib/underscore/underscore-min.js') }}"></script>
<script src="{{ asset('lib/clndr/example/moment-2.8.3.js') }}"></script>
<script src="{{ asset('lib/clndr/src/clndr.js') }}"></script>

@endsection


@section('script')

<script type="text/javascript">
    (function($){

            var eventos = {!!  $eventos !!};



        $(document).ready(function(){

           moment.locale('pt-br');

           var calendar = $("#full-clndr").clndr({
                template:$("#full-clndr-template").html(),
                events: eventos ,
                daysOfTheWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                clickEvents: {
                    click: function(target)
                    {
                        var data_agenda = target.date._i;

                        var template =  $("#form-calendar").html().trim();

                        var content  = $(template);

                        var data_evento = moment(target.date._d).format('DD/MM/YYYY');

                        $("#localidade_id",content).selectpicker();

                        $("#horas",content).selectpicker();

                        $("#minutos",content).selectpicker();


                        bootbox.dialog({
                            message: content,
                            title: 'Agendar no dia ' + data_evento ,
                            buttons:{
                                main:{

                                    label:'Confirmar',
                                    className:'btn-success',
                                    callback:function()
                                    {
                                        var horario_agenda = $("#horas").val() +':'+$("#minutos").val();

                                        var data = {
                                                data_agenda : data_agenda,
                                                horario_agenda : horario_agenda,
                                                localidade_id: $("#localidade_id").val()
                                        };

                                        var url = "{{ url('/store/agenda')  }}";

                                       $.post(url,data,function(response){


                                            if(response.success === true){
                                                calendar.setEvents(JSON.parse(response.events));
                                                bootbox.dialog({
                                                        message:'Registrado com sucesso!',
                                                        title:'Mensagem',
                                                        buttons:{
                                                            success:{
                                                                label:'OK',
                                                                className:'btn-success',
                                                                callback:function()
                                                                {
                                                                    bootbox.hideAll();
                                                                }
                                                            }
                                                        }
                                                });
                                            }else
                                            {
                                                bootbox.dialog({
                                                        message:response.message,
                                                        title:'Mensagem',
                                                        buttons:{
                                                            danger:{
                                                                label:'FECHAR',
                                                                className:'btn-danger',
                                                                callback:function()
                                                                {
                                                                    bootbox.hideAll();
                                                                }
                                                            }
                                                        }
                                                });

                                            }
                                       });

                                    }
                                },
                                danger:{
                                    label:'cancelar',
                                    className:'btn-danger',
                                    callback:function()
                                    {
                                        bootbox.hideAll();
                                    }
                                }

                            }
                        })
                    }
                }
            });

            });

    })(jQuery);
</script>

@endsection



