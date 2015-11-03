

<div class="row">

    <!-- Sidebar -->
    <div class="col-lg-3">
        @include('partials.filtro')
    </div>
    <!-- /Sidebar -->

    <!-- Conteúdo -->
    <div class="col-lg-9">


        <div class="panel panel-default">

            <div class="panel-heading header-sallus">
                <div class="row">
                    <div class="col-lg-10">
                        <h2><i class="fa fa-exclamation-circle  fa-2"></i> Minhas consultas</h2>
                    </div><!-- /.col-lg-10 -->
                    <div class="col-lg-2">
                        <div class="sub-header"> Data do aviso</div>
                    </div><!-- /.col-lg-2 -->
                </div>
            </div>

            <div class="panel-body">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#futuras" aria-controls="futuras" role="tab" data-toggle="tab">Futuras</a>
                        </li>
                        <li role="presentation">
                            <a href="#historico" aria-controls="historico" role="tab" data-toggle="tab">Histórico</a>
                        </li>
                    </ul>

                     <div class="tab-content" id="consultas">
                              
                            <!-- Tab futuras -->
                            <div role="tabpanel" class="tab-pane active" id="futuras">
                                    @include('consulta.tabs.futuras',['futuras'=>$futuras])
                            </div>

                            <!-- Tab historico -->
                            <div role="tabpanel" class="tab-pane" id="historico">
                                    @include('consulta.tabs.historico',['historicos'=>$historicos])
                            </div>

                     </div>

                

                </div>

            </div>

        </div>

    </div>


</div>

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
});

</script>

@endsection

