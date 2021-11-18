<?php
//banco
include('../bd/conexao.php');

$queryOne = "DELETE FROM cfa_estudos WHERE (id = '".$_GET['idEstudo']."')";
$queryTwo = "DELETE FROM cfa_estudantes WHERE (id_estudo = '".$_GET['idEstudo']."')";


$resultOne = $conn->query($queryOne);
$resultTwo = $conn->query($queryTwo);

header('Location: ../front/estudos.php?pagina=7&msn=1');