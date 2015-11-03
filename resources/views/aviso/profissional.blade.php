
<div class="row">
    
  <!-- Conteúdo -->
  <div class="col-lg-12">
      <div class="panel panel-default">
          
          <div class="panel-heading header-sallus">
                <div class="row">
                    <div class="col-lg-8">
                          <h2><i class="fa fa-exclamation-circle  fa-2"></i> Avisos</h2>
                    </div><!-- /.col-lg-10 -->
                    <div class="col-lg-4 text-right">
                          <div class="sub-header"> Data do aviso</div>
                    </div><!-- /.col-lg-2 -->
                </div>
          </div>
          
          <div class="panel-body">

          @if($avisos)
              <!-- Lista padrão -->
              <ul class="list-group">

                @foreach($avisos as $aviso)
                <li class="list-group-item">
                        
                        @if($aviso->tipo == 'SUCESSO')
                          <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x green"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large green">Confirmação de consulta</p>
                                      <p>com {{  $aviso->consulta->user->name .' '.$aviso->consulta->user->lastname   }} no dia {{  date('d/m/Y', strtotime($aviso->consulta->data_agenda )) }} as {{  date('H:i',strtotime($aviso->consulta->horario_agenda)) }}</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                     {{  date('d/m/Y', strtotime($aviso->updated_at)) }}
                                  </div><!-- /.col-lg-3 -->
                            </div>
                        @elseif($aviso->tipo == 'ERROR') 

                            <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x red"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large red">Consulta cancelada</p>
                                      <p>com {{  $aviso->consulta->user->name .' '.$aviso->consulta->user->lastname   }} no dia {{  date('d/m/Y', strtotime($aviso->consulta->data_agenda )) }} as {{  date('H:i',strtotime($aviso->consulta->horario_agenda)) }}</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                       {{  date('d/m/Y', strtotime($aviso->updated_at)) }}
                                  </div><!-- /.col-lg-3 -->
                            </div>

                        @else 
                        
                        <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x blue"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large blue">Consulta a Confirmar</p>
                                      <p>com {{  $aviso->consulta->user->name .' '.$aviso->consulta->user->lastname   }} no dia {{  date('d/m/Y', strtotime($aviso->consulta->data_agenda )) }} as {{  date('H:i',strtotime($aviso->consulta->horario_agenda)) }}</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                       {{  date('d/m/Y', strtotime($aviso->updated_at)) }}
                                  </div><!-- /.col-lg-3 -->
                            </div>   

                        @endif   
                </li>
                @endforeach
                
              </ul><!-- /Lista padrão -->

            @else

                    @include('notfound')

            @endif
          </div>
          
      </div><!-- /.panel-default -->
 </div><!-- /.col-lg-12 -->
 <!-- /Conteúdo -->
  
</div><!-- /.row -->
