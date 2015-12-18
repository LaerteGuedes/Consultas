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
                  <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="">Local de atendimento</span> <i class="fa fa-angle-right"></i> <span class="">Horários de atendimento</span> <i class="fa fa-angle-right"></i> <span class="ativo">Escolha seus planos de saúde</span></h2>
                </div>

                    
                <div class="panel-body">
                  <div>
                    <div class="text-center">
                      <h3>Finalize seu cadastro informando quais planos de saúde você atende.</h3>
                      <p class="lead">Estamos acabando! Agora informe quais planos de saúde você costuma atender seus clientes.</p>
                      <hr>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">

                        <div class="form-group">
                          <label for="plano_pai"></label>
                          <h3>Escolha a empresa</h3>
                          <form action="http://sallus.net/planos/salvar" method="post">

                            <div class="checkbox-inline checkbox-categoria">
                              <input type="checkbox" value="1" checked=""> Unimed

                            </div>
                            <div class="checkbox-inline checkbox-categoria">
                              <input type="checkbox" value="6"> Hapvida
                            </div>
                            <div id="planos">
                              <div class="planos-1">
                                <h4>Planos de saúde da Unimed</h4>

                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="2" checked=""> Unimed Unimax Apartamento Individual
                                </div>
                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="3" checked=""> Unimed Unimax Enfermaria Individual
                                </div>
                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="4"> Unimed Uniplan Individual
                                </div>
                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="5"> Unimed Uniplan Enfermaria / Obstetrícia
                                </div>
                              </div>
                              <div class="planos-6">
                                <h4>Planos de saúde da Hapvida</h4>

                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="7"> Hapvida Enfermaria
                                </div>
                                <div class="foreach">
                                  <input type="checkbox" name="planos[]" value="8"> Hapvida Apartamento
                                </div>
                              </div>
                            </div>
                            <br><br>
                            <div class="form-group submit-form">
                              <a href="etapa-3.php" class="btn btn-success btn-lg btn-block" >Salvar e finalizar cadastro</a>
                            </div>
                            <input type="hidden" name="_token" value="P9vPOjdCDCbtjzu92hNJXccW1uYm4rQ8XyolgQ4Z">
                          </form>
                        </div>
                        <script>
                            $(function(){
                                $(".checkbox-categoria input").on("change", function(){
                                    var checked = $(this).prop('checked');

                                    if (checked){
                                        var value = $(this).val();

                                        if (value){
                                            var params = {id:value};
                                            $.ajax({
                                                url: "http://sallus.net/planos/ajaxplano",
                                                method: "get",
                                                dataType: "json",
                                                data: params,
                                                success: function(json){
                                                    var planoClass = '.planos-'+json.planoPai.id;

                                                    if (!$(planoClass).html()){
                                                        var html = '<div class="planos-'+json.planoPai.id+'">';
                                                        html += '<h4>Planos de saude da '+json.planoPai.titulo+': </h4>';

                                                        $.each(json.planos, function(index, value){
                                                            html += '<div class="checkbox"><input type="checkbox" name="planos[]" value="'+value.id+'"/>'+' '+value.titulo+"</div>";
                                                        });
                                                        html += '</div>';
                                                        $("#planos").append(html);
                                                  }
                                              }
                                          });
                                      }
                                  } else {
                                      var planoSelector = ".planos-" + $(this).val();

                                      $(planoSelector).remove();
                                  }
                              });
                          });
                        </script>

                      </div>
                    </div>
                    
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