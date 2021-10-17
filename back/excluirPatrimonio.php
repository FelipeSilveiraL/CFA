<?php
//banco
include('../bd/conexao.php');

$queryOne = "DELETE FROM cfa_patrimonio WHERE (id = '".$_GET['idPatrimonio']."')";
$queryTwo = "DELETE FROM cfa_patrimonio_documentos WHERE (id_patrimonio = '".$_GET['idPatrimonio']."')";
$queryThree = "DELETE FROM cfa_patrimonio_registros WHERE (id_patrimonio = '".$_GET['idPatrimonio']."')";


$resultOne = $conn->query($queryOne);
$resultTwo = $conn->query($queryTwo);
$resultThree = $conn->query($queryThree);

header('Location: ../front/patrimonio.php?pagina=5&msn=1');