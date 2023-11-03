<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', function () {
    if (Auth::check())
        return view('home');
    return view('welcome');
})->name("welcome");

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('editar/perfil', [\App\Http\Controllers\UsuarioController::class, 'editar_perfil'])->name('user.perfil.editar');
    Route::get('editar/senha', [\App\Http\Controllers\UsuarioController::class, 'editar_senha'])->name('user.senha.editar');
    Route::post('alterar/senha', [\App\Http\Controllers\UsuarioController::class, 'alterar_senha'])->name('user.senha.alterar');
    Route::post('alterar/perfil', [\App\Http\Controllers\UsuarioController::class, 'alterar_perfil'])->name('user.perfil.alterar');

    Route::get('/formula/{planejamento_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadFormula'])->name('planejamento.formula.download');
    Route::get('/anexo_amostra_planejamento/{planejamento_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadAnexoAmostraPlanejamento'])->name('anexo_amostra_planejamento.download');
    Route::get('/licencas_previas/{modelo_animal_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadLicencasPrevias'])->name('licencas_previas.download');
    Route::get('/termos_responsabilidades/{responsavel_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadTermoResponsabilidade'])->name('termo_responsabilidade.downloadTermoResponsabilidade');
    Route::get('/experiencia/{responsavel_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadExperiencia'])->name('experiencia.download');
    Route::get('/experiencias_previasColaborador/{colaborador_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadExperienciaPreviaColaborador'])->name('experiencias_previasColaborador.download');
    Route::get('/termos_responsabilidadesColaborador/{colaborador_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadTermoResponsabilidadeColaborador'])->name('termo_responsabilidadeColaborador.download');
    Route::get('/termo/{modelo_animal_id}/download', [App\Http\Controllers\SolicitacaoController::class, 'downloadTermo'])->name('termo.download');
});

Route::group(['middleware' => ['auth', 'verified', 'checkAdministrador']], function () {
    Route::post('/instituicao/store', [App\Http\Controllers\InstituicaoController::class, 'store'])->name('instituicao.store');
    Route::post('/instituicao/update', [App\Http\Controllers\InstituicaoController::class, 'update'])->name('instituicao.update');
    Route::get('/instituicao/index', [App\Http\Controllers\InstituicaoController::class, 'index'])->name('instituicao.index');
    Route::get('/instituicao/{instituicao_id}/delete', [App\Http\Controllers\InstituicaoController::class, 'delete'])->name('instituicao.delete');

    Route::get('/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuario/store', [App\Http\Controllers\UsuarioController::class, 'store'])->name('usuario.store');
    Route::post('/usuario/update', [App\Http\Controllers\UsuarioController::class, 'update'])->name('usuario.update');

    Route::get('/instituicao/{instituicao_id}/unidade/index', [App\Http\Controllers\UnidadeController::class, 'index'])->name('unidade.index');
    Route::post('/unidade/store', [App\Http\Controllers\UnidadeController::class, 'store'])->name('unidade.store');
    Route::post('/unidade/update', [App\Http\Controllers\UnidadeController::class, 'update'])->name('unidade.update');
    Route::get('/unidade/{unidade_id}/delete', [App\Http\Controllers\UnidadeController::class, 'delete'])->name('unidade.delete');

    Route::get('/unidade/{unidade_id}/departamento/index', [App\Http\Controllers\DepartamentoController::class, 'index'])->name('departamento.index');
    Route::post('/departamento/store', [App\Http\Controllers\DepartamentoController::class, 'store'])->name('departamento.store');
    Route::post('/departamento/update', [App\Http\Controllers\DepartamentoController::class, 'update'])->name('departamento.update');
    Route::get('/departamento/{departamento_id}/delete', [App\Http\Controllers\DepartamentoController::class, 'delete'])->name('departamento.delete');

    Route::get('/solicitacao/index_admin', [App\Http\Controllers\SolicitacaoController::class, 'index_admin'])->name('solicitacao.admin.index');
    Route::post('/solicitacao/atribuir_avaliador', [App\Http\Controllers\AvaliadorController::class, 'atribuir'])->name('avaliador.atribuir');
    Route::post('/solicitacao/remover_avaliador', [App\Http\Controllers\AvaliadorController::class, 'remover'])->name('avaliador.remover');
    Route::get('/solicitacao/{solicitacao_id}/visualizar', [App\Http\Controllers\SolicitacaoController::class, 'visualizar'])->name('solicitacao.admin.visualizar');
    Route::get('/solicitacao/{solicitacao_id}/apreciacao', [App\Http\Controllers\SolicitacaoController::class, 'aprovar_avaliacao'])->name('solicitacao.admin.apreciacao');
    Route::get('/historico_modal/{solicitacao_id}', [App\Http\Controllers\SolicitacaoController::class, 'HistoricoModal'])->name('historico.modal');
    Route::get('/solicitacao/{solicitacao}/historicos/download', [App\Http\Controllers\SolicitacaoController::class, 'historicoDownload'])->name('solicitacao.historicos.download');

});


Route::group(['middleware' => ['auth', 'verified', 'checkProprietario']], function () {
    Route::get('/solicitacao/index_solicitante', [App\Http\Controllers\SolicitacaoController::class, 'index_solicitante'])->name('solicitacao.solicitante.index');
    Route::post('/solicitacao/inicio', [App\Http\Controllers\SolicitacaoController::class, 'inicio'])->name('solicitacao.inicio');
    Route::post('/solicitacao/criar', [App\Http\Controllers\SolicitacaoController::class, 'criar'])->name('solicitacao.criar');
    Route::get('/formularioE/edit/{solicitacao_id}', [App\Http\Controllers\SolicitacaoController::class, 'editForm'])->name('solicitacao.edit.form');
    Route::post('/solicitacao/criar_responsavel', [App\Http\Controllers\SolicitacaoController::class, 'criar_responsavel'])->name('solicitacao.responsavel.criar');
    Route::post('/solicitacao/criar_colaborador', [App\Http\Controllers\SolicitacaoController::class, 'criar_colaborador'])->name('solicitacao.colaborador.criar');
    Route::post('/solicitacao/editar_colaborador', [App\Http\Controllers\SolicitacaoController::class, 'editar_colaborador'])->name('solicitacao.colaborador.editar');
    Route::get('/solicitacao/colaborador/{id}', [App\Http\Controllers\SolicitacaoController::class, 'deletar_colaborador'])->name('solicitacao.colaborador.deletar');
    Route::get('/solicitacao/colaborador_tabela/{id}', [App\Http\Controllers\SolicitacaoController::class, 'atualizar_colaborador_tabela'])->name('solicitacao.colaborador_tabela');
    Route::get('/solicitacao/modal_atualizacao_colaborador/{colaborador_id}', [App\Http\Controllers\SolicitacaoController::class, 'abrir_colaborador_modal'])->name('solicitacao.modal_atualizacao_colaborador');
    Route::post('/solicitacao/criar_eutanasia', [App\Http\Controllers\SolicitacaoController::class, 'criar_eutanasia'])->name('solicitacao.eutanasia.criar');
    Route::post('/solicitacao/criar_modelo_animal', [App\Http\Controllers\SolicitacaoController::class, 'criar_modelo_animal'])->name('solicitacao.modelo_animal.criar');
    Route::post('/solicitacao/atualizar_modelo_animal', [App\Http\Controllers\SolicitacaoController::class, 'atualizar_modelo_animal'])->name('solicitacao.modelo_animal.update');
    Route::get('/solicitacao/remover_modelo_animal/{id}', [App\Http\Controllers\SolicitacaoController::class, 'deletar_modelo_animal'])->name('solicitacao.modelo_animal.delete');
    Route::get('/solicitacao/modelo_animal_tabela/{id}', [App\Http\Controllers\SolicitacaoController::class, 'atualizar_modelo_animal_tabela'])->name('solicitacao.modelo_animal_tabela');
    Route::post('/solicitacao/criar_perfil', [App\Http\Controllers\SolicitacaoController::class, 'criar_perfil'])->name('solicitacao.perfil.criar');
    Route::post('/solicitacao/criar_condicoes_animal', [App\Http\Controllers\SolicitacaoController::class, 'criar_condicoes_animal'])->name('solicitacao.condicoes_animal.criar');
    Route::post('/solicitacao/criar_planejamento', [App\Http\Controllers\SolicitacaoController::class, 'criar_planejamento'])->name('solicitacao.planejamento.criar');
    Route::post('/solicitacao/criar_procedimento', [App\Http\Controllers\SolicitacaoController::class, 'criar_procedimento'])->name('solicitacao.procedimento.criar');
    Route::post('/solicitacao/criar_resultado', [App\Http\Controllers\SolicitacaoController::class, 'criar_resultado'])->name('solicitacao.resultado.criar');
    Route::post('/solicitacao/criar_operacao', [App\Http\Controllers\SolicitacaoController::class, 'criar_operacao'])->name('solicitacao.operacao.criar');
    Route::post('/solicitacao/criar_solicitacao_fim', [App\Http\Controllers\SolicitacaoController::class, 'criar_solicitacao_fim'])->name('solicitacao.solicitacao_fim.criar');
    Route::get('/solicitacao/{solicitacao_id}/index', [App\Http\Controllers\SolicitacaoController::class, 'index_solicitacao'])->name('solicitacao.index');

    Route::get('/solicitacao/planejamento/index/{modelo_animal_id}', [App\Http\Controllers\SolicitacaoController::class, 'index_planejamento'])->name('solicitacao.planejamento.index');

    Route::get('/solicitacao/{solicitacao_id}/concluir', [App\Http\Controllers\SolicitacaoController::class, 'concluir'])->name('solicitacao.concluir');

});

Route::group(['middleware' => ['auth', 'verified', 'checkAvaliador']], function () {
    Route::get('/solicitacao/index_avaliador', [App\Http\Controllers\SolicitacaoController::class, 'index_avaliador'])->name('solicitacao.avaliador.index');
    Route::post('/avaliador/aprovar', [App\Http\Controllers\AvaliacaoController::class, 'aprovarSolicitacao'])->name('avaliador.solicitacao.aprovar');
    Route::post('/avaliador/aprovarPendencia', [App\Http\Controllers\AvaliacaoController::class, 'aprovarPendenciaSolicitacao'])->name('avaliador.solicitacao.aprovarPendencia');
    Route::post('/avaliador/reprovar', [App\Http\Controllers\AvaliacaoController::class, 'reprovarSolicitacao'])->name('avaliador.solicitacao.reprovar');
    Route::get('/avaliar/{solicitacao_id}', [App\Http\Controllers\SolicitacaoController::class, 'avaliarSolicitacao'])->name('avaliador.solicitacao.avaliar');
    Route::get('/avaliar/planejamento/{modelo_animal_id}', [App\Http\Controllers\SolicitacaoController::class, 'avaliarPlanejamento'])->name('avaliador.solicitacao.planejamento.avaliar');

//Avaliação Individual
    Route::post('/avaliacao_individual/reprovar', [App\Http\Controllers\AvaliacaoIndividualController::class, 'realizarAvaliacao'])->name('avaliador.avaliacao_ind.realizarAvaliacao');

});

// Area e Subárea de Conhecimento

Route::post('/areas/', 'AreaController@consulta')->name('area.consulta');
Route::post('/subarea/', 'SubAreaController@consulta')->name('subarea.consulta');

//Gerar PDF
Route::get('/pdf/{solicitacao_id}', [App\Http\Controllers\PDFViewController::class, 'gerarPDFSolicitacao'])->name('pdf.gerarPDFSolicitacao');
Route::get('/pdf/avaliacao/{solicitacao_id}', [App\Http\Controllers\PDFViewController::class, 'gerarPDFAprovado'])->name('pdf.gerarPDFAprovado');


//Avaliação Individual - Ajustar middlware para Avaliador e Proprietario
Route::get('/avaliacao_individual/{tipo}/{avaliacao_id}/{id}', [App\Http\Controllers\AvaliacaoIndividualController::class, 'exibir'])->name('avaliador.avaliacao_ind.exibir');
Route::get('/avaliacao_individual/verificar/modelo/{modelo_animal_id}/{avaliacao_id}', [App\Http\Controllers\AvaliacaoIndividualController::class, 'verificarAvalModelo'])->name('avaliador.avaliacao_ind.verificar.modelo');

Route::post('/unidades', [App\Http\Controllers\UnidadeController::class, 'consulta'])->name('unidade.consulta');
Route::post('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'consulta'])->name('departamento.consulta');

//Contatos
Route::get('/contato', [App\Http\Controllers\ContatoController::class, 'contato'])->name('contato');
Route::get('/sobre', [App\Http\Controllers\ContatoController::class, 'sobre'])->name('sobre');
Route::get('/fluxograma', [App\Http\Controllers\ContatoController::class, 'fluxograma'])->name('fluxograma_documentos');
Route::get('/leis_decretos', [App\Http\Controllers\ContatoController::class, 'leis_decretos'])->name('leis_decretos');
Route::get('/membros', [App\Http\Controllers\ContatoController::class, 'membros'])->name('membros');
Route::get('/ceua', [App\Http\Controllers\ContatoController::class, 'ceua'])->name('ceua');
Route::get('/videos', [App\Http\Controllers\ContatoController::class, 'videos'])->name('videos');
Route::get('/calendarioReunioes', [App\Http\Controllers\ContatoController::class, 'calendarioReunioes'])->name('calendarioReunioes');

//Downloads documentos
Route::get('/modelo/termo/responsabilidade/download', [App\Http\Controllers\SolicitacaoController::class,'ModeloTermoResponsabilidade_download'])->name('modelo.termo.responsabilidade.download');
Route::get('/declaracao/consentimento/download', [App\Http\Controllers\SolicitacaoController::class,'DeclaracaoConsentimento_download'])->name('declaracao.consentimento.download');
Route::get('/declaracao/isencao/download', [App\Http\Controllers\SolicitacaoController::class,'DeclaracaoIsencao_download'])->name('declaracao.isencao.download');

