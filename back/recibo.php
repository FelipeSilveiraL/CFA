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
$queryPatrimonio .= " WHERE CFP.id = " . $_POST['aquipamento'];
$result = $conn->query($queryPatrimonio);
$patrimonio = $result->fetch_assoc();

//informando que foi gerado o recebi
$updatePatrimonio = "UPDATE cfa_patrimonio SET recibo_emitido = '0' WHERE id = " . $_POST['aquipamento'];
$resultPatrimonio = $conn->query($updatePatrimonio);

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

    #titulo {
        text-align: center;
        color: gray;
        font-size: 25px;
        margin-bottom: 10%;
    }
    .nome{font-weight: bold;}
    .info{font-size: 18px;}
    #recibo {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }
    #text {
        text-align: justify;
        width: 84%;
        margin-left: 7%;
        margin-top: 5%;
        margin-bottom: 5%;
        font-size: 18px;
    }

</style>

<body>
    <div id="corpo">
        <div id="titulo">
            <p><span class="conteudo nome">' . $sistema['cfa_titulo'] . '</span></p>
            <p class="info"><i><span class="conteudo">CNPJ - ' . $sistema['cfa_cnpj'] . '</span><br />
            <span class="conteudo">' . $sistema['cfa_endereco'] . '</span><br />
            <span class="conteudo">contato@cfasitiocercado.com.br</span></i></p>            
        </div>
        <div id="corpo">
            <p id="recibo" >RECIBO DE DOAÇÃO</p>
            <p id="text">'.$sistema['cfa_titulo'].', entidade sem fins lucrativos, 
            inscrita no CNPJ '.$sistema['cfa_cnpj'].' , com sede na ' . $sistema['cfa_endereco'] . ',
            declara ter recebido de '.$patrimonio['nome_doador'].', '.$patrimonio['nacionalidade_doador'].', 
            '.$patrimonio['civil_doador'].', '.$patrimonio['profissao_doador'].', inscrito(a) 
            no CPF sob o nº '.$patrimonio['cpf_doador'].' e no RG nº '.$patrimonio['rg_doador'].', em DOAÇÃO a importância de '.$patrimonio['valor'].', 
            declarando ainda que os recursos serão aplicados integralmente na realização de seus objetivos sociais, 
            sem distribuição de lucros, bonificações ou vantagens a dirigentes, mantenedores ou associados, 
            sob nenhuma forma ou pretexto.</p>
        </div>
    </div>
    <div id="rodape">
        <div id="data">
            <p>Curitiba,______ de ____________ de 20_______</p>
        </div>
        <div class="assinaturas">
            <div id="assinaturaIgreja" class="pull-right">
                <p class="tag">___________________________________________________</p>
                <p class="assinante">Assinatura: Representado CFA</p>
            </div>
            <div id="assinaturaDoador">
                <p class="tag">___________________________________________________</p>
                <p class="assinante">Assinatura: '.$patrimonio['nome_doador'].'</p>
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
