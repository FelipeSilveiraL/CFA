<?php
//reference the Dompdf namespace
use Dompdf\Dompdf;

//date
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//chamando ele pelo autoload do vendor
require '../vendor/autoload.php';

//chamar o banco
require_once('../bd/conexao.php');
require_once('query.php');

//coletando informações do patrimonio
$queryPatrimonio .= " WHERE CFP.id = " . $_GET['idPatrimonio'];
$result = $conn->query($queryPatrimonio);
$patrimonio = $result->fetch_assoc();

$nomeArq = "ReciboDoacao_".$patrimonio['nome_doador'];
$saida = "portrait";

$html = '<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">   	
</head>
<style>
    .assinaturas{margin-top: 20%;}
    .data{margin-top: 10%;}
    .titulo {text-align: center;margin-bottom: 7%;font-weight: bold;font-family: "Dosis", sans-serif;}
    .relevo{font-weight: bold;}
    p {font-size: 12px;}
    table {
        align-items: center;
        border: solid 1px;
        font-size: 12px;
    }
    .tituloTabela{font-weight: bold;}
    td{border: solid 1px; padding: 5px;}
</style>

<body>

    <div id="titulo">
        <h1 class="titulo">Recibo de Doação</h1>
    </div>

    <div id="corpo">
        <div id="dados">
            <p><span class="relevo">Insituição: </span><span class="conteudo">' . $sistema['cfa_titulo'] . '</span></p>
            <p><span class="relevo">Endereço: </span><span class="conteudo">' . $sistema['cfa_endereco'] . '</span></p>
            <p><span class="relevo">Telefone: </span><span class="conteudo">' . $sistema['cfa_telefone'] . '</span></p>
            <p><span class="relevo">CNPJ: </span><span class="conteudo">' . $sistema['cfa_cnpj'] . '</span></p>
            <p><span class="relevo">Recebemos de: </span><span class="conteudo">' . $patrimonio['nome_doador'] . ', portador do CPF nº (' . $patrimonio['cpf_doador'] . ') os seguintes itens listados abaixo:</span></p>
        </div>
        <div id="tabela">
            <table class="table">
                <thead>
                    <tr class="tituloTabela">
                        <td>NOME/MODELO</td>
                        <td>CÓDIGO</td>
                        <td>QUANTIDADE</td>
                        <td>VALOR</td>
                        <td>CATEGORIA</td>
                        <td>SITUACAO</td>
                        <td>LOCAL</td>
                    </tr>
                </thead>
                <tbody>';
foreach ($_POST["aquipamento"] as $key => $value) {

    include 'query.php';

    //aplicando a regra emitir recibo
    $update = "UPDATE cfa_patrimonio SET recibo_emitido = '0' WHERE (id = '".$value."')";
    $resultUpdate = $conn->query($update);

    //coletando informações do patrimonio para a montagem da tabela
    $queryPatrimonio .= " WHERE CFP.id = " . $value . "";
    $resultEquip = $conn->query($queryPatrimonio);
    $equipamento = $resultEquip->fetch_assoc();


    $html .= "<tr>";
        $html .= "<td>" . $equipamento['nome'] . "</td>";
        $html .= "<td>" . $equipamento['codigo'] . "</td>";
        $html .= "<td>" . $equipamento['quantidade'] . "</td>";
        $html .= "<td>" . $equipamento['valor'] . "</td>";
        $html .= "<td>" . $equipamento['categoria'] . "</td>";
        $html .= "<td>" . $equipamento['situacao'] . "</td>";
        $html .= "<td>" . $equipamento['local'] . "</td>";
        
    $html .= "</tr>";
}

$html .=    '</tbody>
            </table>
        </div>
    </div>
    <div id="rodape">
        <div id="data">
            <p>Curitiba - PR, ' . strftime('%d de %B de %Y', strtotime('today')) . '</p>
        </div>
        <div class="assinaturas">
            <div id="assinaturaIgreja" class="pull-right">
                <p class="tag">___________________________________________________</p>
                <p class="assinante">Assinatura: Representado CFA</p>
            </div>
            <div id="assinaturaDoador">
                <p class="tag">___________________________________________________</p>
                <p class="assinante">Assinatura: Doador</p>
            </div>
        </div>
    </div>
</body>

</html>';

/* echo $html;
exit; */

// instantiate and use the dompdf class
$dompdf = new Dompdf();

//load body PDF
$dompdf->loadHtml($html,'UTF-8');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', $saida); // portrait = retrato, landscape = paisagem

// Render the HTML as PDF
$dompdf->render();

//Output file
$dompdf->stream($nomeArq, array("Attachment" => true)); //true - Download, false - Abre no navegador

//close data base
$conn->close();
