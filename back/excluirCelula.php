<?php
//banco
include('../bd/conexao.php');

$query = "UPDATE cfa_celulas SET deletar = '1' WHERE (id = ".$_GET['idCelula'].");";


if(!$result = $conn->query($query)){
	printf("Error message[1]: %s\n", $conn->error);
}else{
	header('Location: ../front/celula.php?pagina=4&msn=1&modo=1');
}