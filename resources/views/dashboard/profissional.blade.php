 <div class="row">
              
            <!-- Conteúdo -->
            <div class="col-lg-12">
                
                <div class="panel panel-default">
                    
                    <div class="panel-heading header-sallus">
                          <div class="row">
                              <div class="col-lg-12">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Estatísticas do meu perfil</h2>
                              </div><!-- /.col-lg-12 -->
                          </div>
                    </div>
                    
                    <div class="panel-body">
                          <div class="row">
                              <div class="col-lg-3">
                                <span class="fa-stack fa-lg fa-3x">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-search fa-stack-1x fa-inverse"></i>
                                </span>
                                  <p class="icon-text text-large">Visualizações<br><span class="icon-info">{{ Auth::user()->views }}</span></p>
                              </div><!-- /.col-lg-3 -->
                              <div class="col-lg-3">
                                <span class="fa-stack fa-lg fa-3x">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-user-md fa-stack-1x fa-inverse"></i>
                                </span>
                                  <p class="icon-text text-large">Consultas agendadas<br><span class="icon-info">{{ $total_consultas }}</span></p>
                              </div><!-- /.col-lg-3 -->
                              <div class="col-lg-3">
                                <span class="fa-stack fa-lg fa-3x">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-comment fa-stack-1x fa-inverse"></i>
                                </span>
                                  <p class="icon-text text-large">Nº de avaliações<br><span class="icon-info">{{ Auth::user()->comentarios()->count()  }}</span></p>
                              </div><!-- /.col-lg-3 -->
                              <div class="col-lg-3">
                                <span class="fa-stack fa-lg fa-3x">
                                  <i class="fa fa-square fa-stack-2x"></i>
                                  <i class="fa fa-star fa-stack-1x fa-inverse"></i>
                                </span>
                                  <p class="icon-text text-large">Média de avaliações<br>

                                  <i class="fa fa-star{{ $total_avaliacao >= 1 ? '':'-o'}} fa-1 dark"></i> 
                                  <i class="fa fa-star{{ $total_avaliacao >= 2 ? '':'-o'}} fa-1 dark"></i>
                                   <i class="fa fa-star{{ $total_avaliacao >= 3 ? '':'-o'}} fa-1 dark"></i> 
                                   <i class="fa fa-star{{ $total_avaliacao >= 4 ? '':'-o'}} fa-1 dark"></i> 
                                   <i class="fa fa-star{{ $total_avaliacao >= 5 ? '':'-o'}} fa-1 dark"></i>

                                    ({{ $total_avaliacao }})
                                   </p>
                              </div><!-- /.col-lg-3 -->
                              
                          </div>
                    </div>
                    
                </div><!-- /.panel-default -->
            </div><!-- /.col-lg-12 -->
            @if(false)
            <div class="col-lg-6">
                <div class="panel panel-default">
                    
                    <div class="panel-heading header-sallus">
                          <div class="row">
                              <div class="col-lg-12">
                                    <h2><i class="fa fa-exclamation-circle  fa-2"></i> Consultas de hoje</h2>
                              </div><!-- /.col-lg-12 -->
                          </div>
                    </div>
                    
                    <div class="panel-body contract">
                        <div id="consultas">
                            <!-- Painel collapse -->
                            <div class="panel-group expandir" role="tablist">
                              <div class="panel-default">
                                <div class="panel-heading" role="tab" id="collapsePanel1Heading">
                                  <h4 class="panel-title">
                                      <div class="row">
                                          <div class="col-30 text-extra-large">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">25/07/2015</a>
                                          </div>
                                          <div class="col-20 text-extra-large">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">Pacientes</a>
                                          </div>
                                          <div class="col-50 text-extra-large">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapsePanel1" aria-expanded="false" aria-controls="collapsePanel1">6 agendadas <a href="agendar-data-hora.php" class="btn btn-primary btn-xs red-btn">Cancelar todas de hoje</a></a>
                                          </div>
                                      </div>
                                  </h4>
                                </div>
                                  
                                <div id="collapsePanel1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapsePanel1Heading">
                                    <div class="panel-body">

                                        <!-- Lista padrão -->
                                        <ul class="list-group">
                                          <li class="list-group-item">
                                              <div class="row">
                                                  <div class="col-30 text-large">
                                                      <p class="list-group-item-text"><i class="fa fa-clock-o"></i> 11:00h</p>
                                                  </div><!-- /. -->
                                                  <div class="col-50 text-large">
                                                      Maria José Cunha
                                                  </div><!-- /. -->
                                                  <div class="col-20">
                                                      <a href="agendar-data-hora.php" class="btn btn-primary btn-xs red-btn">CANCELAR</a>
                                                  </div><!-- /. -->
                                              </div>
                                          </li>
                                          <li class="list-group-item">
                                              <div class="row">
                                                  <div class="col-30 text-large">
                                                      <p class="list-group-item-text"><i class="fa fa-clock-o"></i> 11:00h</p>
                                                  </div><!-- /. -->
                                                  <div class="col-50 text-large">
                                                      Maria José Cunha
                                                  </div><!-- /. -->
                                                  <div class="col-20">
                                                      <a href="agendar-data-hora.php" class="btn btn-primary btn-xs red-btn">CANCELAR</a>
                                                  </div><!-- /. -->
                                              </div>
                                          </li>
                                          <li class="list-group-item">
                                              <div class="row">
                                                  <div class="col-30 text-large">
                                                      <p class="list-group-item-text"><i class="fa fa-clock-o"></i> 11:00h</p>
                                                  </div><!-- /. -->
                                                  <div class="col-50 text-large">
                                                      Maria José Cunha
                                                  </div><!-- /. -->
                                                  <div class="col-20">
                                                      <a href="agendar-data-hora.php" class="btn btn-primary btn-xs red-btn">CANCELAR</a>
                                                  </div><!-- /. -->
                                              </div>
                                          </li>
                                        </ul><!-- /Lista padrão -->

                                    </div>
                                </div>
                                  
                              </div>
                            </div>
                        </div>
                    </div>
                    
                </div><!-- /.panel-default -->
           </div><!-- /.col-lg-6 -->
           
            <div class="col-lg-6">
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
                        <!-- Lista padrão -->
                        <ul class="list-group">
                          <li class="list-group-item">
                              <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x red"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large red">Consulta cancelada</p>
                                      <p>com Maria José Cunha  dia 20/07/2015 às 08:20</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                      14/07/2015
                                  </div><!-- /.col-lg-3 -->
                              </div>
                          </li>
                          <li class="list-group-item">
                              <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x green"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large green">Confirmação de consulta</p>
                                      <p>com Josão da Silva no dia 20/07/2015 às 11:00</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                      14/07/2015
                                  </div><!-- /.col-lg-3 -->
                              </div>
                          </li>
                          <li class="list-group-item">
                              <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x red"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large red">Consulta cancelada</p>
                                      <p>com Maria José Cunha  dia 20/07/2015 às 08:20</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                      14/07/2015
                                  </div><!-- /.col-lg-3 -->
                              </div>
                          </li>
                          <li class="list-group-item">
                              <div class="row">
                                  <div class="col-lg-1">
                                      <i class="fa fa-calendar fa-2x green"></i>
                                  </div><!-- /.col-lg-1 -->
                                  <div class="col-lg-8">
                                      <p class="text-extra-large green">Confirmação de consulta</p>
                                      <p>com Josão da Silva no dia 20/07/2015 às 11:00</p>
                                  </div><!-- /.col-lg-8 -->
                                  <div class="col-lg-3 text-large text-right dark">
                                      14/07/2015
                                  </div><!-- /.col-lg-3 -->
                              </div>
                          </li>
                        </ul><!-- /Lista padrão -->
                    </div>
                    
                </div><!-- /.panel-default -->
           </div><!-- /.col-lg-6 -->

           @endif

           <!-- /Conteúdo -->
            
          </div><!-- /.row -->