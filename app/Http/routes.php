<?php

#rotas home
Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::get('/home', function(){
    return redirect()->route('dashboard');
});
Route::get('/adm/login', ['as' => 'adm.login', 'uses' => 'AdmController@login']);
Route::post('/adm/auth', ['as' => 'adm.auth', 'uses' => 'AdmController@auth']);

Route::get('/home/cliente',['as'=>'home.cliente','middleware'=>'guest','uses'=>'HomeController@homeCliente']);
Route::get('/home/profissional',['as'=>'home.profissional','middleware'=>'guest','uses'=>'HomeController@homeProfissional']);
Route::get("/planos/ajaxplanocliente", ['as' => 'plano.ajaxplanocliente', 'uses' => "UserPlanoController@ajaxPlanoCliente"]);
Route::post('/register/user',['as'=>'register.user','uses'=>'HomeController@registerUser']);

Route::get("/pagseguro/teste", ['as' => "adm.pagteste", 'uses' => "AssinaturaController@teste"]);
Route::post("/assinatura/notificacao", ['as' => "assinatura.notificacao", 'uses' => "AssinaturaController@notificacao"]);

#rota profissional

Route::get("/assinatura/expira", ['as' => 'expira.assinatura', 'uses' => "AssinaturaController@expiraAssinaturas"]);
Route::get('/resultado',['as'=>'resultado.busca','uses'=>'PesquisaController@index']);
Route::get('/detalhes/profissional/{id}',['as'=>'profissional.detalhe','uses'=>'ProfissionalController@detalhe']);

Route::get("/cron/expiraassinaturas", ['as' => "cron.expira", 'uses' => "CronController@expiraPeriodoTeste"]);

Route::group(['middleware'=>['auth','check.profissional.etapa']] , function(){

    Route::get('/dashboard',['as'=>'dashboard','uses'=>'DashboardController@index']);
    #rota pesquisa profissional
    #rota profissional

    Route::get('/agendar/profissional/{user_id}/local/{localidade_id}',['as'=>'profissional.agendar','uses'=>'ProfissionalController@agendar']);
    Route::post('/confirmar/agendamento',['as'=>'profissional.confirmar.agendamento','uses'=>'ProfissionalController@confirmar']);
    Route::post('/finalizar/agendamento',['as'=>'profissional.finalizar.agendamento','uses'=>'ProfissionalController@finalizar']);
    Route::get('/agendamento/confirmado',['as'=>'profissional.agendamento.confirmado','uses'=>'ProfissionalController@confirmado']);

    #rota tutorial
    Route::get('/tutorial/inicial',['as'=>'tutorial.inicial','uses'=>'TutorialController@index']);

    #rota pagamento
    Route::get("/assinatura/nova", ['as' => 'nova.assinatura', 'uses' => 'AssinaturaController@nova']);
    Route::post("/assinatura/store", ['as' => "store.assinatura", 'uses' => "AssinaturaController@store"]);
    Route::get("/assinatura/checkstatus", ['as' => "status.assinatura", 'uses' => "AssinaturaController@checkStatus"]);

    #rota etapas
    Route::get("/etapa/localidade", ['as' => 'etapa.localidade', 'uses' => 'EtapaController@localidade']);
    Route::get("/etapa/grade", ['as' => 'etapa.grade', 'uses' => 'EtapaController@grade']);
    Route::get("/etapa/plano", ['as' => 'etapa.plano', 'uses' => 'EtapaController@plano']);
    Route::get('/etapa/assinatura', ['as' => 'etapa.assinatura', 'uses' => 'EtapaController@assinatura']);
    Route::get('/etapa/assinaturatestesuspensa', ['as' => 'etapa.assinaturatestesuspensa', 'uses' => 'EtapaController@assinaturaTesteSuspensa']);
    Route::get('/etapa/assinaturasuspensa', ['as' => 'etapa.assinaturasuspensa', 'uses' => 'EtapaController@assinaturaSuspensa']);
    Route::get('/etapa/assinaturaaguardando', ['as' => 'etapa.assinaturaaguardando', 'uses' => 'EtapaController@assinaturaAguardando']);


    #rotas comentario
    Route::post('/store/comentario',['as'=>'store.comentario','uses'=>'ComentarioController@store']);

    #rotas avaliacao
    Route::get('/avaliar/profissional',['as'=>'avaliar.profissional','uses'=>'AvaliacaoController@avaliarProfissional']);

    #rotas para perfil
    Route::get('/edit/perfil',['as'=>'edit.perfil','uses'=>'PerfilController@edit']);
    Route::put('/update/perfil/{id}',['as'=>'update.perfil','uses'=>'PerfilController@update']);
    Route::get("/perfil/cancelar", ['as' => "perfil.cancelar", 'uses' => "PerfilController@cancelarConta"]);
    Route::get("/perfil/excluir", ['as' => "perfil.excluir", 'uses' => "PerfilController@excluirConta"]);

    #rotas para curriculo
    Route::get('/experiencias',['as'=>'curriculos','uses'=>'CurriculoController@index']);
    Route::get('/editar/experiencia/{id}',['as'=>'edit.curriculo','middleware'=>['check.curriculo.user'],'uses'=>'CurriculoController@edit']);
    Route::get('/nova/experiencia',['as'=>'novo.curriculo','uses'=>'CurriculoController@novo']);
    Route::post('/store/experiencia',['as'=>'store.curriculo','uses'=>'CurriculoController@store']);
    Route::put('/update/experiencia/{id}',['as'=>'update.curriculo','middleware'=>['check.curriculo.user'],'uses'=>'CurriculoController@update']);
    Route::get('/delete/experiencia/{id}',['as'=>'delete.curriculo','middleware'=>['check.curriculo.user'],'uses'=>'CurriculoController@delete']);

    #rotas para servicos
    Route::get('/servicos',['as'=>'servicos','uses'=>'ServicoController@index']);
    Route::get('/editar/servico/{id}',['as'=>'edit.servico','middleware'=>['check.servico.user'],'uses'=>'ServicoController@edit']);
    Route::get('/novo/servico',['as'=>'novo.servico','uses'=>'ServicoController@novo']);
    Route::post('/store/servico',['as'=>'store.servico','uses'=>'ServicoController@store']);
    Route::put('/update/servico/{id}',['as'=>'update.servico','middleware'=>['check.servico.user'],'uses'=>'ServicoController@update']);
    Route::get('/delete/servico/{id}',['as'=>'delete.servico','middleware'=>['check.servico.user'],'uses'=>'ServicoController@delete']);


    #rotas para ramos
    Route::get('/especializacoes',['as'=>'ramos','uses'=>'RamoController@index']);
    Route::get('/editar/especializacao/{id}',['as'=>'edit.ramo','uses'=>'RamoController@edit']);
    Route::get('/nova/especializacao',['as'=>'novo.ramo','uses'=>'RamoController@novo']);
    Route::post('/store/especializacao',['as'=>'store.ramo','uses'=>'RamoController@store']);
    Route::put('/update/especializacao/{id}',['as'=>'update.ramo','uses'=>'RamoController@update']);
    Route::get('/delete/especializacao/{id}',['as'=>'delete.ramo','uses'=>'RamoController@delete']);
    Route::get('/listar-ramos/{especialidade_id?}',['as'=>'listar.ramos','uses'=>'RamoController@all']);

    #rotas para planos de saúde (adm)
    Route::get("/admplanos", ['as' => 'admplanos', 'uses' => "PlanoController@index"]);
    Route::get("/admplanos/novo", ['as' => 'admplano.novo', 'uses' => "PlanoController@novo"]);
    Route::post("/admplanos/salvar", ['as' => 'admplano.salvar', 'uses' => 'PlanoController@salvar']);

    #rotas para planos de saúde (profissional de saúde)
    Route::get("/planos", ['as' => 'planos', 'uses' => "UserPlanoController@index"]);
    Route::get("/planos/novo", ['as' => 'plano.novo', 'uses' => "UserPlanoController@novo"]);
    Route::post("/planos/salvar", ['as' => 'plano.salvar', 'uses' => 'UserPlanoController@salvar']);
    Route::get("/planos/ajaxplano", ['as' => 'plano.ajaxplano', 'uses' => "UserPlanoController@ajaxplano"]);
    Route::get("/planos/delete", ['as' => 'plano.delete', 'uses' => 'UserPlanoController@delete']);

    #rotas para localidades
    Route::get('/localidades',['as'=>'localidades','uses'=>'LocalidadeController@index']);
    Route::get('/editar/localidade/{id}',['as'=>'edit.localidade','uses'=>'LocalidadeController@edit']);
    Route::get('/nova/localidade',['as'=>'novo.localidade','uses'=>'LocalidadeController@novo']);
    Route::post('/store/localidade',['as'=>'store.localidade','uses'=>'LocalidadeController@store']);
    Route::put('/update/localidade/{id}',['as'=>'update.localidade','uses'=>'LocalidadeController@update']);
    Route::get('/delete/localidade/{id}',['as'=>'delete.localidade','uses'=>'LocalidadeController@delete']);
    Route::get('/delete/localidadegrade/{id}', ['as' => 'deletefromgrade.localidade', 'uses' => 'LocalidadeController@deleteFromGrade']);
    Route::get('/listar-cidades/{uf}',['as'=>'listar.cidades','uses'=>'LocalidadeController@listCidades']);
    Route::get('/listar-bairros/{cidade_id}',['as'=>'listar.bairros','uses'=>'LocalidadeController@listBairros']);

    #rotas para agenda
    Route::get('/agenda',['as'=>'agenda','uses'=>'AgendaController@index']);
    Route::get('/nova/agenda',['as'=>'nova.agenda','uses'=>'AgendaController@novo']);
    Route::post('/store/agenda',['as'=>'store.agenda','uses'=>'AgendaController@store']);
    Route::get('/editar/agenda/{id}',['as'=>'edit.agenda','uses'=>'AgendaController@edit']);
    Route::put('/update/agenda/{id}',['as'=>'update.agenda','uses'=>'AgendaController@update']);
    Route::get('/delete/agenda/{id}',['as'=>'delete.agenda','uses'=>'AgendaController@delete']);


    #rotas para consultas
    Route::get('/consultas',['as'=>'consultas','uses'=>'ConsultaController@index']);
    Route::get('/confirmar/consulta',['as'=>'consulta.confirmar','uses'=>'ConsultaController@confirmar']);
    Route::get('/realizar/consulta',['as'=>'consulta.realizar','uses'=>'ConsultaController@realizar']);

    #rotas para aviso
    Route::get('/avisos',['as'=>'avisos','uses'=>'AvisoController@index']);


    #rotas para grade de horario
    Route::get('/grade',['as'=>'grade','uses'=>'GradeController@index']);
    Route::post('/store/grade',['as'=>'store.grade','uses'=>'GradeController@store']);
    Route::get('/delete/horario-da-grade/{id}',['as'=>'delete.horario.grade','uses'=>'GradeController@deleteHorario']);
    Route::get("/grade/cancelardia/{localidade_id}/{dia_semana}", ['as' => 'grade.cancelardia', 'uses' => 'GradeController@cancelarDia']);

});

Route::group(['prefix'=>'api/sallus','middleware' => 'cors'], function(){
    Route::get('/listar/estados',['uses'=>'ServerController@listarEstados']);
    Route::get('/listar/cidades',['uses'=>'ServerController@listarCidades']);
    Route::get("/listar/bairros", ['as' => "api.lista.bairros", 'uses' => "ServerController@listarBairros"]);
    Route::get('/listar/especialidades',['uses'=>'ServerController@listarEspecialidades']);
    Route::get('/listar/ramos',['uses'=>'ServerController@listarRamos']);
    Route::get("/listar/localidades", ['as' => "listar.localidades", 'uses' => "ServerController@listarLocalidades"]);
    Route::get("/localidade/{id}", ['as' => "api.localidade", 'uses' => "ServerController@localidadeDetalhe"]);
    Route::get('/pesquisar/profissional',['uses'=>'ServerController@pesquisarProfissional']);
    //Route::get("/pesquisaravancada/profissional", ['as' => "api.pesquisa.avancada", 'uses' => "ServerController@pesquisaAvancadaProfissional"]);
    Route::get('/logar/usuario',['uses'=>'ServerController@logarUsuario']);
    Route::post('/registrar/novo/usuario',['uses'=>'ServerController@registrarNovoUsuario']);
    Route::get('/consultar/total/comentarios/',['uses'=>'ServerController@getTotalComentarioProfissional']);
    Route::get('/consultar/comentario/',['uses'=>'ServerController@comentarioByUserId']);
    Route::get('/listar/dados/profissional',['uses'=>'ServerController@listarDadosProfissional']);
    Route::get('/avaliar/profissional',['uses'=>'ServerController@avaliarProfissional']);
    Route::get('/enviar/comentario',['uses'=>'ServerController@enviarComentario']);
    Route::post("/registrar/editar/usuario", ['uses' => 'ServerController@editarUsuario']);
    Route::get("/agendar/horarios/{user_id}/{localidade_id}", ['uses' => 'ServerController@agendar']);
    Route::get("/detalhes/profissional/{user_id}/{localidade_id}", ['as' => "api.detalhes.profissional", 'uses' => "ServerController@detalhesProfissional"]);
    Route::post("/confirmar/agendamento", ['uses' => 'ServerController@confirmar']);
    Route::post("/finalizar/agendamento", ['uses' => 'ServerController@finalizar']);
    
    Route::get("/perfil/excluir", ['as' => "api.perfil.excluir", 'uses' => "ServerController@excluirConta"]);
    
    Route::get("/avisos", ['uses' => 'ServerController@avisos']);
    Route::get("/avisos/profissional", ['as' => "api.avisos.profissional", 'uses' => "ServerController@avisosProfissional"]);    
    
    Route::post("/localidade/store", ['as' => "localidade.store", 'uses' => "ServerController@storeLocalidade"]);

    Route::post("/grade/store", ['as' => "apigrade.store", 'uses' => "ServerController@storeGrade"]);
    Route::get("/grade/diassemana", ['as' => "apigrade.diassemana", 'uses' => "ServerController@gradeDiasSemana"]);
    Route::get("/grade/delete/{id}", ['as' => "api.grade.delete", 'uses' => "ServerController@deleteHorarioGrade"]);
    Route::get("/grade/cancelardia", ['as' => 'api.grade.cancelardia', 'uses' => 'ServerController@cancelarDia']);
    
    Route::get("/comentarios/usuario", ['as' => "api.comentarios.usuarios", 'uses' => "ServerController@comentariosPorUsuario"]);

    Route::get("/assinatura", ['as' => 'api.assinatura.index', 'uses' => 'ServerController@assinatura']);
    Route::post("/assinatura/store", ['as' => "api.assinatura.store", 'uses' => "ServerController@assinaturaStore"]);
    Route::get("/assinatura/lista", ['as' => "api.assinatura.lista", 'uses' => "ServerController@assinaturaLista"]);

    Route::get("/etapa/check", ['as' => "api.etapa.check", 'uses' => "ServerController@etapaAtual"]);
    
    Route::get("/operadoras", ['as' => "api.operadoras", 'uses' => "ServerController@operadoras"]);
    Route::get("/planos", ['as' => "api.planos", 'uses' => "ServerController@planos"]);
    Route::post("/planos/salvar", ['as' => "api.planos.salvar", 'uses' => "ServerController@salvarPlanos"]);

    Route::get("/consultas", ['uses' => "ServerController@consultas"]);
    Route::get("/consultas/datas", ['as' => "api.consultas.datas", 'uses' => "ServerController@consultasDatas"]);
    Route::get("/consultasprofissional/datas", ['as' => "api.consultasprofissional.datas", 'uses' => "ServerController@consultasProfissionalDatas"]);
    Route::get("/consultas/historico", ['uses' => "ServerController@consultasByDataHistorico"]);
    Route::get("/consultas/futuras", ['uses' => "ServerController@consultasByDataFuturas"]);
    Route::get("/consultas/confirmar", ['as' => "api.confimar.consultas", 'uses' => "ServerController@confirmarConsulta"]);
    Route::get("/consulta/detalhe/{id}", ['as' => "api.confirmar.consultaDetalhe", 'uses' => "ServerController@consultaDetalhe"]);

    Route::get("/buscaavancada", ['uses' => 'ServerController@buscaAvancada']);
    Route::get('/usuario/detalhe', ['uses' => 'ServerController@usuarioDetalhe']);

    Route::post('/register/user',['as'=>'apiregister.user','uses'=>'ServerController@registerUser']);
    Route::get("/user/listar", ['as' => "api.user.listar", 'uses' => "ServerController@getUser"]);

    Route::get("/planos/usuario", ['as' => "api.planos.usuario", 'uses' => "ServerController@planosUsuario"]);
    
    Route::get("/profissional/etapa", ['as' => "apiprofissional.etapa", 'uses' => "ServerController@profissionalEtapa"]);
});

Route::group(['prefix'=>'ajax'],function(){
    Route::get('/listar-cidades/{uf}',['as'=>'listar.cidades','uses'=>'LocalidadeController@listCidades']);
    Route::get('/listar-bairros/{cidade_id}',['as'=>'listar.bairros','uses'=>'LocalidadeController@listBairros']);
    Route::get('/listar-ramos/{especialidade_id?}',['as'=>'listar.ramos','uses'=>'RamoController@all']);
});

Route::group(['prefix'=>'adm', 'middleware' => 'admauth'], function(){
    Route::get('dashboard', ['as' => 'adm.dashboard', 'uses' => 'AdmController@dashboard']);

    Route::get('usuarios', ['as' => 'adm.usuarios', 'uses' => 'AdmController@usuarios']);
    Route::get("usuariodetalhe/{id}", ['as' => "adm.usuariodetalhe", 'uses' => "AdmController@usuariodetalhe"]);
    Route::get("usuariodetalhe/{id}", ['as' => "adm.usuariodetalhe", 'uses' => "AdmController@usuariodetalhe"]);
    Route::post("usuario/update", ['as' => 'adm.usuarioupdate', 'uses' => 'AdmController@updateUsuario']);
    Route::get('deleteusuario/{user_id}', ['as' => 'adm.deleteusuario', 'uses' => 'AdmController@deleteusuario']);

    Route::get('operadoras', ['as' => 'adm.operadoras', 'uses' => 'AdmController@operadoras']);
    Route::get("novaoperadora", ['as' => "adm.novaoperadora", 'uses' => "AdmController@novaOperadora"]);
    Route::post("salvaoperadora", ['as' => "adm.salvaoperadora", 'uses' => "AdmController@salvaOperadora"]);
    Route::post("updateoperadora", ['as' => "adm.updateoperadora", 'uses' => "AdmController@updateOperadora"]);
    Route::get("editoperadora/{id}", ['as' => "adm.editoperadora", 'uses' => "AdmController@editOperadora"]);
    Route::get("excluiroperadora/{id}", ['as' => "adm.excluiroperadora", 'uses' => "AdmController@excluirOperadora"]);
    
    Route::get("novoplano/{id_pai}", ['as' => "adm.novoplano", 'uses' => "AdmController@novoplano"]);
    Route::post("salvaplano", ['as' => "adm.salvaplano", 'uses' => "AdmController@salvaplano"]);
    Route::post("updateplano", ['as' => "adm.updateplano", 'uses' => "AdmController@updateplano"]);
    Route::get("planos", ['as' => "adm.planos", 'uses' => "AdmController@planos"]);
    Route::get("excluirplano/{id}", ['as' => "adm.excluirplano", 'uses' => "AdmController@excluirPlano"]);

    Route::get("profissionais", ['as' => "adm.profissionais", 'uses' => "AdmController@profissionais"]);
    Route::get("profissional/{id}", ['as' => "adm.profissionaldetalhe", 'uses' => "AdmController@profissionalDetalhe"]);
    Route::post("profissional/update", ['as' => "adm.profissionalupdate", 'uses' => "AdmController@profissionalUpdate"]);
//    Route::post("alteraassinatura", ['as' => "adm.alteraassinatura", 'uses' => "AdmController@alteraassinatura"]);

    Route::get("especialidades", ['as' => "adm.especialidades", 'uses' => "AdmController@especialidades"]);
    Route::get("novaespecialidade", ['as' => "adm.novaespecialidade", 'uses' => "AdmController@novaespecialidade"]);
    Route::post("salvaespecialidade", ['as' => "adm.salvaespecialidade", 'uses' => "AdmController@salvaespecialidade"]);
    Route::get("editespecialidade/{id}", ['as' => "adm.editespecialidade", 'uses' => "AdmController@editespecialidade"]);
    Route::post("updateespecialidade", ['as' => "adm.updateespecialidade", 'uses' => "AdmController@updateespecialidade"]);
    Route::get("excluirespecialidade/{id}", ['as' => "adm.excluirespecialidade", 'uses' => "AdmController@excluirespecialidade"]);

    Route::get("novoramo/{especialidade_id}", ['as' => "adm.novoramo", 'uses' => "AdmController@novoRamo"]);
    Route::post("salvaramo", ['as' => "adm.salvaramo", 'uses' => "AdmController@salvaRamo"]);
    Route::post("updateramo", ['as' => "adm.updateramo", 'uses' => "AdmController@updateRamo"]);
    Route::get("excluirramo/{id}", ['as' => "adm.excluirramo", 'uses' => "AdmController@excluirRamo"]);
    
    Route::get("bairros", ['as' => "adm.bairros", 'uses' => "AdmController@bairros"]);
    Route::post("salvabairro", ['as' => "adm.salvabairro", 'uses' => "AdmController@salvabairro"]);
    Route::post("updatebairro", ['as' => "adm.updatebairro", 'uses' => "AdmController@updatebairro"]);
    Route::get("excluirbairro/{id}", ['as' => "adm.excluirbairro", 'uses' => "AdmController@excluirbairro"]);

    Route::get("assinaturas", ['as' => "adm.assinaturas", 'uses' => "AdmController@assinaturas"]);
    Route::get("novaassinatura", ['as' => "adm.novaassinatura", 'uses' => "AdmController@novaAssinatura"]);
    Route::post("salvaassinatura", ['as' => "adm.salvaassinatura", 'uses' => "AdmController@salvaAssinatura"]);
    Route::get("editassinatura/{id}", ['as' => "adm.editassinatura", 'uses' => "AdmController@editassinatura"]);
    Route::post("updateassinatura", ['as' => "adm.updateassinatura", 'uses' => "AdmController@updateassinatura"]);
    Route::get("excluirassinatura/{id}", ['as' => "adm.excluirassinatura", 'uses' => "AdmController@excluirassinatura"]);

    Route::get("cidades", ['as' => "adm.cidades", 'uses' => "AdmController@cidades"]);
    Route::get("novacidade", ['as' => "adm.novacidade", 'uses' => "AdmController@novacidade"]);
    Route::post("salvacidade", ['as' => "adm.salvacidade", 'uses' => "AdmController@salvacidade"]);
    Route::get("editcidade", ['as' => "adm.editcidade", 'uses' => "AdmController@editcidade"]);
    Route::post("updatecidade", ['as' => "adm.updatecidade", 'uses' => "AdmController@updatecidade"]);
    Route::get("excluircidade", ['as' => "adm.excluir", 'uses' => "AdmController@excluircidade"]);
});














