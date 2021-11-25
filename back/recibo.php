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

$queryPatrimonio .= " WHERE CFP.id = " . $_GET['idPatrimonio'];
$result = $conn->query($queryPatrimonio);
$patrimonio = $result->fetch_assoc();

$nomeArq = "ReciboDoacao_".$patrimonio['nome_doador'];
$saida = "portrait";

$html = '<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
</head>
<style>
    .assinaturas{margin-top: 20%;}
    .titulo {text-align: center;margin-bottom: 7%;font-weight: bold;}
    .relevo{font-weight: bold;}
</style>

<body>

    <div id="titulo">
        <h1 class="titulo">Recibo de Doação</h1>
    </div>

    <div id="corpo">
        <div id="dados">
            <p><span class="relevo">Insituição: </span><span class="conteudo">' . $sistema['cfa_titulo'] . '</span></p>
            <br />
            <p><span class="relevo">Endereço: </span><span class="conteudo">' . $sistema['cfa_endereco'] . '</span></p>
            <p><span class="relevo">Telefone: </span><span class="conteudo">' . $sistema['cfa_telefone'] . '</span></p>
            <p><span class="relevo">CNPJ: </span><span class="conteudo">' . $sistema['cfa_cnpj'] . '</span></p>
            <br />
            <p><span class="relevo">Recebemos de: </span><span class="conteudo">' . $patrimonio['nome_doador'] . ', portador do CPF nº (' . $patrimonio['cpf_doador'] . ') os seguintes itens listados abaixo:</span></p>
        </div>
        <div id="tabela">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <td>NOME/MODELO</td>
                        <td>CÓDIGO</td>
                        <td>QUANTIDADE</td>
                        <td>VALOR</td>
                    </tr>
                </thead>
                <tbody>';
foreach ($_POST["aquipamento"] as $key => $value) {
    $queryEquipamento = "SELECT * FROM cfa.cfa_patrimonio WHERE id = " . $value . "";
    $resultEquip = $conn->query($queryEquipamento);
    $equipamento = $resultEquip->fetch_assoc();


    $html .= "<tr>";
        $html .= "<td>" . $equipamento['nome'] . "</td>";
        $html .= "<td>" . $equipamento['codigo'] . "</td>";
        $html .= "<td>" . $equipamento['quantidade'] . "</td>";
        $html .= "<td>" . $equipamento['valor'] . "</td>";
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

// instantiate and use the dompdf class
$dompdf = new Dompdf();

//load body PDF
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', $saida); // portrait = retrato, landscape = paisagem

// Render the HTML as PDF
$dompdf->render();

//Output file
$dompdf->stream($nomeArq, array("Attachment" => true)); //true - Download, false - Abre no navegador

//close data base
$conn->close();
