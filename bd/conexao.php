<?php

$endereco = "localhost";
$senhadb = "oOSpB8GzY3kKOCAL";
$userdb = "root";
$portadb = "3306";
$db = "cfa";

$conn = new mysqli($endereco, $userdb, $senhadb, $db);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Erro de conexão: %s\n", mysqli_connect_error());
    exit();
}else{
	//echo "conexao: ON";
}
?>