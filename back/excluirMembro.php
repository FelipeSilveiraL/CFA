<?php
//banco
include('../bd/conexao.php');

$query = "UPDATE cfa_usuarios SET deletar = '1' WHERE (id = ".$_GET['idMembro'].");";


if(!$result = $conn->query($query)){
	printf("Error message[1]: %s\n", $conn->error);
}else{
	header('Location: ../front/membros.php?pagina=3&msn=1&idMembro='.$_GET['idMembro'].'&modo=1');
}