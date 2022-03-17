<?php
/* AQUI IRÁ FICAR TODAS AS QUERYS DO SISTEMAS */

//LISTANDO OS USUARIOS DO SISTEMAS
$queryUsuarios = "SELECT 
U.id,
U.nome,
U.sobre_nome,
U.email,
U.senha,
U.foto_perfil,
U.cadastrado_por,
U.data_criacao,
U.celular,
U.celula AS id_celula,
U.estado_civil AS id_estado_civil,
U.sexo AS id_sexo,
U.cargo AS id_cargo,
U.data_nascimento,
U.endereco,
U.numero,
U.bairro,
U.cep,
U.pais,
U.estado,
U.cidade,
U.deletar,
U.alterarSenha,

P.tela_configuracoes,
P.tela_membros,
P.tela_celula,
P.tela_patrimonio,
P.tela_financeiro,
P.tela_estudos,
P.config_informacao,
P.config_sistema,
P.config_menus,
P.membro_editar,
P.membro_excluir,
P.membro_adicionar,
P.membro_permissao,
P.celula_adicionar,
P.celula_editar,
P.celula_excluir,
P.celula_incluir_lider,
P.celula_excluir_lider,
P.celula_incluir_membro,
P.celula_excluir_membro,
P.celula_incluir_reuniao,
P.patrimonio_adicionar,
P.patrimonio_excluir,
P.financeiro_adicionar,
P.financeiro_excluir,
P.estudos_adicionar,
P.estudos_excluir,

MEC.nome AS estado_civil,
MG.nome AS genero,
MC.nome AS cargo,
CC.nome AS celula

FROM  cfa_usuarios U
LEFT JOIN cfa_permissao P ON (U.id = P.id_usuario)
LEFT JOIN menu_estado_civil MEC ON (U.estado_civil = MEC.id)
LEFT JOIN menu_sexo MG ON (U.sexo = MG.id)
LEFT JOIN menu_cargo MC ON (U.cargo = MC.id)
LEFT JOIN cfa_celulas CC ON (U.celula = CC.id)";

/* ============================================================================== */

//COLETANDO DADOS DO SISTEMA
$querysistema = 'SELECT * FROM cfa_sistema';
$result = $conn->query($querysistema);
$sistema = $result->fetch_assoc();

/* ============================================================================== */

//MENUS

$queryCargo = "SELECT * FROM menu_cargo";
$resultCargo = $conn->query($queryCargo);

$queryCivil = "SELECT * FROM menu_estado_civil";
$resultCivil = $conn->query($queryCivil);

$querySexo = "SELECT * FROM menu_sexo";
$resultSexo = $conn->query($querySexo);

$queryCategoria = "SELECT * FROM menu_categoria";
$resultCategoria = $conn->query($queryCategoria);

$queryLocal= "SELECT * FROM menu_local";
$resultLocal= $conn->query($queryLocal);

$querySituacao = "SELECT * FROM menu_situacao";
$resultSituacao = $conn->query($querySituacao);

$queryConservacao = "SELECT * FROM menu_conservacao";
$resultConservacao = $conn->query($queryConservacao);

$queryOrigem = "SELECT * FROM menu_origem";
$resultOrigem = $conn->query($queryOrigem);

/* ============================================================================== */

//COLETANDO DADOS DAS CELULAS
$queryCelulas = "SELECT * FROM cfa_celulas WHERE deletar = 0";
$resultCelulas = $conn->query($queryCelulas);

//COLETANDO DADOS DAS CELULAS
$countCelula = "SELECT COUNT(id) AS quantidade FROM cfa_usuarios";

/* ============================================================================== */

//COLETANDO DADOS DOS LIDERES DAS CELULAS
$queryLIderesCelulas = "SELECT 
U.nome,
U.id
FROM cfa_celula_lideres CLC
LEFT JOIN cfa_usuarios U ON (CLC.id_usuario = U.id)";

//COLETANDO DADOS DAS LIDERES
$countLideres = "SELECT COUNT(id) AS quantidade FROM cfa_celula_lideres";

/* ============================================================================== */

//COLETANDO AS PEMISSOES
$queryPermissao = "SELECT * FROM cfa_permissao";

/* ============================================================================== */

//DADOS DA LISTA DE REUNIÕES
$queryListaReunioes = "SELECT 
CR.id,
CR.data_reuniao,
CR.assunto,
CR.ofertas,
(SELECT COUNT(id) FROM cfa_participantes WHERE id_reuniao = CR.id) participantes,
(SELECT COUNT(id) FROM cfa_visitantes WHERE id_reuniao = CR.id) visitantes
FROM cfa_reuniao CR";

/* ============================================================================== */

//MEMBROS Celula participantes
$queryParticipantes = "SELECT 
CP.id_usuario,
CP.nome
FROM cfa_participantes CP
LEFT JOIN cfa_reuniao CR ON (CP.id_reuniao = CR.id)";

/* ============================================================================== */

//VISITANTES
$queryVisitantes = "SELECT * FROM cfa_visitantes";

/* ============================================================================== */

//ULTIMAS REUNIÔES
$queryUltimaReuniao = "SELECT distinct(CR.id_celula) AS id_celula, max(CR.data_reuniao) AS dataReuniao, CC.nome FROM cfa_reuniao CR
                        LEFT JOIN cfa_celulas CC ON (CC.id = CR.id_celula)
                        group by id_celula";

/* ============================================================================== */

//PATRIMONIO
$queryPatrimonio = "SELECT 
CFP.nome,
CFP.codigo,
CFP.valor,
CFP.quantidade,
CFP.data_aquisicao,
CFP.numero_documento,
CFP.observacao,
CFP.id,
CFP.nome_doador,
CFP.cpf_doador,
CFP.recibo_emitido,
CFP.categoria AS id_categoria,
MC.nome AS categoria,
CFP.local AS id_local,
ML.nome AS local,
CFP.situacao AS id_situacao,
MS.nome AS situacao,
CFP.conservacao AS id_conservacao,
MCS.nome AS conservacao,
CFP.origem AS id_origem,
MO.nome AS origem
FROM cfa_patrimonio CFP
LEFT JOIN menu_categoria MC ON (CFP.categoria = MC.id)
LEFT JOIN menu_local ML ON (CFP.local = ML.id)
LEFT JOIN menu_situacao MS ON (CFP.situacao = MS.id)
LEFT JOIN menu_conservacao MCS ON (CFP.conservacao = MCS.id)
LEFT JOIN menu_origem MO ON (CFP.origem = MO.id)";
                        
/* ============================================================================== */

//DOCUMENTOS PERMITIDOS
$queryDocumentosPermitidos = "SELECT * FROM cfa_documento_permitido";
                        
/* ============================================================================== */

//DOCUMENTOS DO PATRIMONIO
$queryDocumentosPatrimonios = "SELECT * FROM cfa_patrimonio_documentos";
                        
/* ============================================================================== */

//REGISTROS DO PATRIMONIO
$queryrRegistrosPatrimonios = "SELECT 
CR.observacao,
CR.data_registro,
CU.nome
FROM cfa_patrimonio_registros CR
LEFT JOIN cfa_usuarios CU ON (CR.id_usuario = CU.id)";
                        
/* ============================================================================== */

//ESTUDOS
$queryEstudos = "SELECT 
CFAE.id, 
CFAE.nome, 
CFAE.observacao,
CFAE.data_criacao, 

CFAU.nome AS lecionador,
CFAU.id AS id_usuario

FROM
cfa_estudos CFAE
    LEFT JOIN
cfa_usuarios CFAU ON (CFAE.lecionador = CFAU.id)";
                        
/* ============================================================================== */

//ESTUDOS
$queryEstudantes = "SELECT 
CES.id,
CES.data_inicio,
CES.data_fim,
CES.status,
CES.id_usuario,
CE.nome AS nomeEstudo,
CE.id AS id_estudo, 

CU.nome AS estudante,
CU.email

FROM cfa_estudantes CES
LEFT JOIN cfa_estudos CE ON (CES.id_estudo = CE.id)
LEFT JOIN cfa_usuarios CU ON (CES.id_usuario = CU.id)";                        