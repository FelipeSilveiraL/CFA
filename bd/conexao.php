<?php

$endereco = "localhost";
$senhadb = "Cpdtec05";
$userdb = "cfasit28_admin";
$portadb = "3306";
$db = "cfasit28_cfa";

$conn = new mysqli($endereco, $userdb, $senhadb, $db, $portadb);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Erro de conexão: %s\n", mysqli_connect_error());
    exit();
}else{
	//echo "conexao: ON";
}

?>