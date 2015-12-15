<?php 
/* 
 * Carrega o cabeçalho padrão do sistema 
 */
include_once 'header.php'; 
?>
    <section class="main adm">
        <div class="container">
          <div class="row">

              
            <!-- Conteúdo -->
            <div class="col-lg-12">
              
              <!-- Painel padrão com cabeçalho -->
              <div class="panel panel-default profissional-cadastro">

                <div class="panel-heading header-sallus">
                  <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="">Local de atendimento</span> <i class="fa fa-angle-right"></i> <span class="ativo">Horários de atendimento</span> <i class="fa fa-angle-right inativo"></i> <span class="inativo">Escolha seus planos de saúde</span></h2>
                </div>

                    
                <div class="panel-body">
                  <div>
                    <div class="text-center">
                      <h3>Agora crie os horários de atendimento para o local recém criado.</h3>
                      <p class="lead">Após ter criado seu primeiro local de atendimento, configure agora sua grade de horários de atendimento neste local.</p>
                      <hr>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">

                        <table class="table table-bordered table-horario">
                          <thead>
                            <tr>
                              <th>TURNO</th>
                              <th class="text-uppercase">seg</th>
                              <th class="text-uppercase">ter</th>
                              <th class="text-uppercase">qua</th>
                              <th class="text-uppercase">qui</th>
                              <th class="text-uppercase">sex</th>
                              <th class="text-uppercase">sab</th>
                              <th class="text-uppercase">dom</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr id="m">
                              <td class="text-uppercase">manhã</td>

                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="seg" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="ter" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="qua" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="qui" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="sex" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="sab" data-turno="m"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-manha" data-localidade_id="5" data-dia_semana="dom" data-turno="m"> criar horário</button>
                                </div>

                              </td>

                            </tr>
                            <tr id="t">
                              <td class="text-uppercase">tarde</td>

                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="seg" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="ter" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="qua" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="qui" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="sex" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="sab" data-turno="t"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-tarde" data-localidade_id="5" data-dia_semana="dom" data-turno="t"> criar horário</button>
                                </div>

                              </td>

                            </tr>
                            <tr id="n">
                              <td class="text-uppercase">noite</td>

                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="seg" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="ter" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="qua" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="qui" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="sex" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="sab" data-turno="n"> criar horário</button>
                                </div>

                              </td>


                              <td>
                                <div class="lista-horarios">
                                  <button type="button" class="btn btn-primary btn-xs add-horario-noite" data-localidade_id="5" data-dia_semana="dom" data-turno="n"> criar horário</button>
                                </div>

                              </td>

                            </tr>
                            <tr>
                              <td>CANCELAR CONSULTAS</td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/seg" id="botao-seg-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/ter" id="botao-ter-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/qua" id="botao-qua-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/qui" id="botao-qui-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/sex" id="botao-sex-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/sab" id="botao-sab-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                              <td style="text-align: center;">
                                <a href="grade/cancelardia/5/dom" id="botao-dom-5" class="btn btn-xs btn-danger cancelar-dia">Cancelar</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <a href="etapa-3.php" class="btn btn-success btn-lg btn-block" >Salvar e avançar</a>
                  </div>
                </div>

              </div><!-- /Painel padrão com cabeçalho -->

            </div><!-- /.col-lg-9 -->
            <!-- /Conteúdo -->
           
          </div><!-- /.row -->
        </div> <!-- /container -->
    </section> <!-- /section -->
<?php 
/* 
 * Carrega o rodapé padrão do sistema 
 */
include_once 'footer.php'; 
?>