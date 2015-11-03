<div class="row">
    
  <!-- Sidebar -->
  <div class="col-lg-3">
    @include('partials.filtro')
  </div><!-- /.col-lg-3 -->
  <!-- /Sidebar -->
  
  <!-- Conteúdo -->
  <div class="col-lg-9">

      

      <div class="panel panel-default">
          
          <div class="panel-heading header-sallus">
                <div class="row">
                    <div class="col-lg-10">
                          <h2><i class="fa fa-exclamation-circle  fa-2"></i> Meus avisos</h2>
                    </div><!-- /.col-lg-10 -->
                    <div class="col-lg-2">
                          <div class="sub-header"> Data do aviso</div>
                    </div><!-- /.col-lg-2 -->
                </div>
          </div>
          
          <div class="panel-body">

            @if($avisos)
              
              <!-- Lista padrão -->
              <ul class="list-group">

                @foreach($avisos as $aviso)

                <li class="list-group-item profissional">

                  @if($aviso->tipo =='SUCESSO')
                    
                    <div class="row">
                        <div class="col-lg-1">
                            <i class="fa fa-calendar fa-2x green"></i>
                        </div><!-- /.col-lg-1 -->
                        <div class="col-lg-9">
                            <p class="text-extra-large green">Consulta Confirmada</p>
                            
                            <p>A consulta com  <strong class="text-capitalize">{{ $aviso->consulta->profissional->name . ' ' . $aviso->consulta->profissional->lastname }} </strong> no dia {{  date("d/m/Y",strtotime($aviso->consulta->data_agenda)) }} as {{  date("H:i",strtotime($aviso->consulta->horario_agenda)) }} foi confirmada com sucesso.</p>
                              
                            
                            <div class="green action">
                              <strong>Consulta foi confirmda por você em {{  date('d/m/Y \a\s H:i' ,strtotime($aviso->consulta->updated_at)  ) }}.</strong>
                            </div>

                        </div><!-- /.col-lg-9 -->
                        <div class="col-lg-2 text-large text-right dark">
                            {{ date('d/m/Y' , strtotime( $aviso->updated_at ) ) }}
                        </div><!-- /.col-lg-2 -->
                    </div>

                    @elseif($aviso->tipo =='ERROR')


                    <div class="row">
                        <div class="col-lg-1">
                            <i class="fa fa-calendar fa-2x red"></i>
                        </div><!-- /.col-lg-1 -->
                        <div class="col-lg-9">
                            <p class="text-extra-large red">Consulta cancelada</p>
                            
                            <p>A consulta com  <strong class="text-capitalize">{{ $aviso->consulta->profissional->name . ' ' . $aviso->consulta->profissional->lastname }} </strong> no dia {{  date("d/m/Y",strtotime($aviso->consulta->data_agenda)) }} as {{  date("H:i",strtotime($aviso->consulta->horario_agenda)) }} foi cancelada.</p>
                            
                            <div class="dark action">Gostaria de remarcar esta consulta? 
                              <a href="{{ route('profissional.detalhe' , $aviso->consulta->profissional_id) }}" class="btn btn-primary green-btn">SIM</a>
                            </div>

                            

                        </div><!-- /.col-lg-9 -->
                        <div class="col-lg-2 text-large text-right dark">
                            {{ date('d/m/Y' , strtotime( $aviso->updated_at ) ) }}
                        </div><!-- /.col-lg-2 -->
                    </div>


                    @else


                    <div class="row">
                        <div class="col-lg-1">
                            <i class="fa fa-calendar fa-2x blue"></i>
                        </div><!-- /.col-lg-1 -->
                        <div class="col-lg-9">
                            <p class="text-extra-large blue">Confirmação de consulta</p>
                            
                            <p>A consulta com  <strong class="text-capitalize">{{ $aviso->consulta->profissional->name . ' ' . $aviso->consulta->profissional->lastname }} </strong> no dia {{  date("d/m/Y",strtotime($aviso->consulta->data_agenda)) }} as {{  date("H:i",strtotime($aviso->consulta->horario_agenda)) }} precisa ser confirmada.</p>
                            
                    <div class="dark action">Você poderá comparecer à consulta? 
                      <a href="javascript:void(0);" class="btn btn-primary green-btn confirmar-consulta" data-consulta="{{$aviso->consulta->id }}" data-resposta="sim">SIM</a> 
                      <a href="javascript:void(0);" class="btn btn-primary red-btn confirmar-consulta" data-consulta="{{$aviso->consulta->id }}"  data-resposta="nao">NÃO</a>
                  </div>


                            

                        </div><!-- /.col-lg-9 -->
                        <div class="col-lg-2 text-large text-right dark">
                            {{ date('d/m/Y' , strtotime( $aviso->updated_at ) ) }}
                        </div><!-- /.col-lg-2 -->
                    </div>

                    @endif

                </li>

                @endforeach

              </ul><!-- /Lista padrão -->

              @else

                  @include('notfound')

              @endif
          </div>
          
      </div>

      
 </div><!-- /.col-lg-9 -->
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
});

</script>

@endsection





