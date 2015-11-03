



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
              <div class="event-listing-title">CONSULTAS</div>
              <% _.each(eventsThisMonth, function(event) { %>
                  <div class="event-item">
                    <div class="event-item-name"><%= event.title %></div>
                    <div class="event-item-location">Cliente: <%= event.cliente %></div>
                    <div class="event-item-location">Paciente: <%= event.pessoal %></div>
                    <div class="event-item-location">Status: <%= event.status %></div>
                    <div class="event-item-location">Local: <%= event.local %></div>
                  </div>
                <% }); %>
            </div>


          </script>

</div>







@section('lib')

<script src= "{{ asset('lib/clndr/example/json2.js') }}"></script>
<script src="{{ asset('lib/underscore/underscore-min.js') }}"></script>
<script src="{{ asset('lib/clndr/example/moment-2.8.3.js') }}"></script>
<script src="{{ asset('lib/clndr/src/clndr.js') }}"></script>

@endsection


@section('script')

<script type="text/javascript">

;(function($){

    var eventos = {!!  $eventos !!};
    moment.locale('pt-br');

    $(document).ready(function(){

        $("#full-clndr").clndr({

                events: eventos,
                template:$("#full-clndr-template").html(),
                daysOfTheWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                clickEvents: {
                    click: function(target)
                    {
                        console.log(target);
                    }
                }
        });

    });


})(jQuery);

</script>

@endsection