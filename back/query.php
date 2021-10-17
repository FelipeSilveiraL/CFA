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

P.tela_configuracoes,
P.tela_membros,
P.tela_celula,
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
$querysistema = "SELECT * FROM cfa_sistema";
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

//MEMBROS
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