<?php

//ANIVERSARIOS
/* ============================================================================== */
$queryJaneiro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-01-%'";
$resultJan = $conn->query($queryJaneiro);
$janeiro = $resultJan->fetch_assoc();

$queryFevereiro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-02-%'";
$resultFev = $conn->query($queryFevereiro);
$fevereiro = $resultFev->fetch_assoc();

$queryMarco = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-03-%'";
$resultMar = $conn->query($queryMarco);
$marco = $resultMar->fetch_assoc();

$queryAbril = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-04-%'";
$resultAbr = $conn->query($queryAbril);
$abril = $resultAbr->fetch_assoc();

$queryMaio = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-05-%'";
$resultMai = $conn->query($queryMaio);
$maio = $resultMai->fetch_assoc();

$queryJunho = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-06-%'";
$resultJun = $conn->query($queryJunho);
$junho = $resultJun->fetch_assoc();

$queryJulho = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-07-%'";
$resultJul = $conn->query($queryJulho);
$julho = $resultJul->fetch_assoc();

$queryAgosto = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-08-%'";
$resultAgo = $conn->query($queryAgosto);
$agosto = $resultAgo->fetch_assoc();

$querySetembro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-09-%'";
$resultSet = $conn->query($querySetembro);
$setembro = $resultSet->fetch_assoc();

$queryOutubro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-10-%'";
$resultOut = $conn->query($queryOutubro);
$outubro = $resultOut->fetch_assoc();

$queryNovembro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-11-%'";
$resultNov = $conn->query($queryNovembro);
$novembro = $resultNov->fetch_assoc();

$queryDezembro = "SELECT COUNT(id) AS aniversarios FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-12-%'";
$resultDez = $conn->query($queryDezembro);
$dezembro = $resultDez->fetch_assoc();

//ETINIAS
/* ============================================================================== */
$queryEtinias = "SELECT data_nascimento FROM cfa_usuarios WHERE deletar = 0 ";
$resultEtinias = $conn->query($queryEtinias);

//CARGOS
/* ============================================================================== */
$queryCargos = "SELECT count(U.cargo) AS cargo, C.nome 
                FROM menu_cargo C
                LEFT JOIN cfa_usuarios U ON (U.cargo = C.id) WHERE U.deletar = 0 GROUP BY C.id";
$resultCargos = $conn->query($queryCargos);

//Estado Civil
/* ============================================================================== */
$queryCivil = "SELECT estado_civil FROM cfa_usuarios WHERE deletar = 0 ";
$resultCivil = $conn->query($queryCivil);

//sexo
/* ============================================================================== */
$querySexo = "SELECT sexo FROM cfa_usuarios WHERE deletar = 0 ";
$resultSexo = $conn->query($querySexo);

//VISITANTES
/* ============================================================================== */


if (!empty($_GET['idCelula'])) {

    $idCelula = $_GET['idCelula'];

    $queryJaneiroV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-01-01' AND '2021-01-31'";
    $resultJanV = $conn->query($queryJaneiroV);
    $janeiroV = $resultJanV->fetch_assoc();

    $queryFevereiroV = "SELECT 
                        COUNT(CV.id) AS visitantes
                        FROM
                        cfa_visitantes CV
                            LEFT JOIN
                        cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                        WHERE
                        CR.id_celula = " . $idCelula . "
                            AND CR.data_reuniao BETWEEN '2021-02-01' AND '2021-02-31'";
    $resultFevV = $conn->query($queryFevereiroV);
    $fevereiroV = $resultFevV->fetch_assoc();

    $queryMarcoV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-03-01' AND '2021-03-31'";
    $resultMarV = $conn->query($queryMarcoV);
    $marcoV = $resultMarV->fetch_assoc();

    $queryAbrilV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-04-01' AND '2021-04-31'";
    $resultAbrV = $conn->query($queryAbrilV);
    $abrilV = $resultAbrV->fetch_assoc();

    $queryMaioV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-05-01' AND '2021-05-31'";
    $resultMaiV = $conn->query($queryMaioV);
    $maioV = $resultMaiV->fetch_assoc();

    $queryJunhoV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-06-01' AND '2021-06-31'";
    $resultJunV = $conn->query($queryJunhoV);
    $junhoV = $resultJunV->fetch_assoc();

    $queryJulhoV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-07-01' AND '2021-07-31'";
    $resultJulV = $conn->query($queryJulhoV);
    $julhoV = $resultJulV->fetch_assoc();

    $queryAgostoV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-08-01' AND '2021-08-31'";
    $resultAgoV = $conn->query($queryAgostoV);
    $agostoV = $resultAgoV->fetch_assoc();

    $querySetembroV = "SELECT 
                        COUNT(CV.id) AS visitantes
                        FROM
                        cfa_visitantes CV
                            LEFT JOIN
                        cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                        WHERE
                        CR.id_celula = " . $idCelula . "
                            AND CR.data_reuniao BETWEEN '2021-09-01' AND '2021-09-31'";
    $resultSetV = $conn->query($querySetembroV);
    $setembroV = $resultSetV->fetch_assoc();

    $queryOutubroV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-10-01' AND '2021-10-31'";
    $resultOutV = $conn->query($queryOutubroV);
    $outubroV = $resultOutV->fetch_assoc();

    $queryNovembroV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-11-01' AND '2021-11-31'";
    $resultNovV = $conn->query($queryNovembroV);
    $novembroV = $resultNovV->fetch_assoc();

    $queryDezembroV = "SELECT 
                    COUNT(CV.id) AS visitantes
                    FROM
                    cfa_visitantes CV
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CV.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-12-01' AND '2021-12-31'";
    $resultDezV = $conn->query($queryDezembroV);
    $dezembroV = $resultDezV->fetch_assoc();

    //PARTICIPANTES
    /* ============================================================================== */
    $queryJaneiroP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-01-01' AND '2021-01-31'";
    $resultJanP = $conn->query($queryJaneiroP);
    $janeiroP = $resultJanP->fetch_assoc();

    $queryFevereiroP = "SELECT 
                        COUNT(CP.id) AS participantes
                        FROM
                        cfa_participantes CP
                            LEFT JOIN
                        cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                        WHERE
                        CR.id_celula = " . $idCelula . "
                            AND CR.data_reuniao BETWEEN '2021-02-01' AND '2021-02-31'";
    $resultFevP = $conn->query($queryFevereiroP);
    $fevereiroP = $resultFevP->fetch_assoc();

    $queryMarcoP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-03-01' AND '2021-03-31'";
    $resultMarP = $conn->query($queryMarcoP);
    $marcoP = $resultMarP->fetch_assoc();

    $queryAbrilP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-04-01' AND '2021-04-31'";
    $resultAbrP = $conn->query($queryAbrilP);
    $abrilP = $resultAbrP->fetch_assoc();

    $queryMaioP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-05-01' AND '2021-05-31'";
    $resultMaiP = $conn->query($queryMaioP);
    $maioP = $resultMaiP->fetch_assoc();

    $queryJunhoP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-06-01' AND '2021-06-31'";
    $resultJunP = $conn->query($queryJunhoP);
    $junhoP = $resultJunP->fetch_assoc();

    $queryJulhoP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-07-01' AND '2021-07-31'";
    $resultJulP = $conn->query($queryJulhoP);
    $julhoP = $resultJulP->fetch_assoc();

    $queryAgostoP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-08-01' AND '2021-08-31'";
    $resultAgoP = $conn->query($queryAgostoP);
    $agostoP = $resultAgoP->fetch_assoc();

    $querySetembroP = "SELECT 
                        COUNT(CP.id) AS participantes
                        FROM
                        cfa_participantes CP
                            LEFT JOIN
                        cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                        WHERE
                        CR.id_celula = " . $idCelula . "
                            AND CR.data_reuniao BETWEEN '2021-09-01' AND '2021-09-31'";
    $resultSetP = $conn->query($querySetembroP);
    $setembroP = $resultSetP->fetch_assoc();

    $queryOutubroP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-10-01' AND '2021-10-31'";
    $resultOutP = $conn->query($queryOutubroP);
    $outubroP = $resultOutP->fetch_assoc();

    $queryNovembroP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-11-01' AND '2021-11-31'";
    $resultNovP = $conn->query($queryNovembroP);
    $novembroP = $resultNovP->fetch_assoc();

    $queryDezembroP = "SELECT 
                    COUNT(CP.id) AS participantes
                    FROM
                    cfa_participantes CP
                        LEFT JOIN
                    cfa_reuniao CR ON (CR.id = CP.id_reuniao)
                    WHERE
                    CR.id_celula = " . $idCelula . "
                        AND CR.data_reuniao BETWEEN '2021-12-01' AND '2021-12-31'";
    $resultDezP = $conn->query($queryDezembroP);
    $dezembroP = $resultDezP->fetch_assoc();
}

//ESTUDANTES
/* ============================================================================== */
$countEstudantes = "SELECT COUNT(id) AS quantidade FROM cfa_estudantes";

?>