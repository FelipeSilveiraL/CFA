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

</style>

<body>
    <div id="corpo">
        <div id="titulo">
            <p><span class="conteudo">' . $sistema['cfa_titulo'] . '</span></p>
            <p><span class="conteudo">CNPJ - ' . $sistema['cfa_cnpj'] . '</span></p>
            <p><span class="conteudo">' . $sistema['cfa_endereco'] . '</span></p>
            <p><span class="conteudo">contato@cfasitiocercado.com.br</span></p>            
        </div>
        <div id="corpo">
            <p>RECIBO DE DOAÇÃO</p>
            <p>Centro Familiar de Adoração de Sitio Cercado, entidade sem fins lucrativos, 
            inscrita no CNPJ '.$sistema['cfa_cnpj'].' , com sede na ' . $sistema['cfa_endereco'] . ',
            declara ter recebido de '.$patrimonio['nome_doador'].', (nacionalidade), (estado civil), (profissão), inscrito(a) 
            no CPF sob o nº (informar) e no RG nº (informar), em DOAÇÃO a importância de R$ X.XXX,XX (valor por extenso), 
            declarando ainda que os recursos serão aplicados integralmente na realização de seus objetivos sociais, 
            sem distribuição de lucros, bonificações ou vantagens a dirigentes, mantenedores ou associados, 
            sob nenhuma forma ou pretexto.</p>
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

echo $html;
exit;

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
