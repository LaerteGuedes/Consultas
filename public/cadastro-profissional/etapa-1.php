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
                  <h2><i class="fa fa-exclamation-circle  fa-2"></i> <span class="">Dados pessoais</span> <i class="fa fa-angle-right"></i> <span class="ativo">Local de atendimento</span> <i class="fa fa-angle-right inativo"></i> <span class="inativo">Horários de atendimento</span> <i class="fa fa-angle-right inativo"></i> <span class="inativo">Escolha seus planos de saúde</span></h2>
                </div>

                    
                <div class="panel-body">
                  <div>
                    <div class="text-center">
                      <h3>Cadastre um local onde você costume atender seus clientes.</h3>
                      <p class="lead">Pode ser em um endereço fixo (como um consultório ou clínica) ou atendimento em domicílio (Home Care). Caso atenda em mais de um local, você poderá cadastrar os demais após concluir o primeiro.</p>
                      <hr>
                    </div>

                    <form method="POST" action="http://sallus.net/store/localidade" accept-charset="UTF-8" class="jumbotron"><input name="_token" type="hidden" value="P9vPOjdCDCbtjzu92hNJXccW1uYm4rQ8XyolgQ4Z">

                      <div class="form-group">

                        <div class="row">

                          <div class="col-xs-2">

                            <label for="tipo">*Tipo:</label>

                            <select name="tipo" id="tipo" class="form-control bs-select-hidden" data-title="Selecione"><option class="bs-title-option" value="">Selecione</option>

                              <option value="DOMICILIO">Domiciliar ( Home Care )</option>
                              <option value="CONSULTORIO">Consultório</option>

                            </select><div class="btn-group bootstrap-select form-control"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="tipo" title="Selecione"><span class="filter-option pull-left">Selecione</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Domiciliar ( Home Care )</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Consultório</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>

                          </div>
                          <div class="col-xs-4">

                            <label for="logradouro">*Logradouro:</label>
                            <input class="form-control" name="logradouro" type="text" id="logradouro">

                          </div>
                          <div class="col-xs-2">

                            <label for="numero">*Numero:</label>
                            <input class="form-control" name="numero" type="text" id="numero">

                          </div>
                          <div class="col-xs-4">

                            <label for="complemento">Complemento:</label>
                            <input class="form-control" name="complemento" type="text" id="complemento">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-xs-3">
                            <label for="cep">*CEP:</label>
                            <input class="form-control" data-mask="cep" name="cep" type="text" id="cep">
                          </div>
                          <div class="col-xs-3">
                            <label for="uf">*Estado:</label>
                            <select class="form-control bs-select-hidden" id="uf" name="uf"><option value="PA" selected="selected">PA</option></select><div class="btn-group bootstrap-select form-control"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="uf" title="PA"><span class="filter-option pull-left">PA</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li data-original-index="0" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">PA</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>
                          </div>
                          <div class="col-xs-3">
                            <label for="cidade_id">*Cidade:</label>
                            <select name="cidade_id" id="cidade_id" class="form-control bs-select-hidden">
                              <option value="">Selecione...</option>
                              <option value="4538">ANANINDEUA</option>
                              <option value="4564">BELEM</option>
                              <option value="4566">BENEVIDES</option>
                              <option value="4604">CASTANHAL</option>
                              <option value="4680">MARITUBA</option>
                            </select><div class="btn-group bootstrap-select form-control"><button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="cidade_id" title="Selecione..."><span class="filter-option pull-left">Selecione...</span>&nbsp;<span class="caret"></span></button><div class="dropdown-menu open"><ul class="dropdown-menu inner" role="menu"><li data-original-index="0" class="selected"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">Selecione...</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">ANANINDEUA</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">BELEM</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">BENEVIDES</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">CASTANHAL</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="5"><a tabindex="0" class="" style="" data-tokens="null"><span class="text">MARITUBA</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div></div>
                          </div>
                          <div class="col-xs-3">
                            <label for="bairro">*Bairro:</label>
                            <input class="form-control" autocomplete="off" name="bairro" type="text" id="bairro">
                            <input id="bairro_id" disabled="disabled" name="bairro_id" type="hidden">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="preco">Valor da consulta</label>
                        <input class="form-control" data-mask="decimal" name="preco" type="text" id="preco" value="0,00" style="text-align: right;">
                      </div>
                      <br>
                      <div class="form-group">
                        <a href="etapa-2.php" class="btn btn-success btn-lg btn-block" >Salvar e avançar</a>
                      </div>
                    </form>
                    
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