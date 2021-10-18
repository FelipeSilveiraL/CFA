<?php

$endereco = "localhost";
$senhadb = "9N2V4!z4+S[/Z[pb";
$userdb = "id17786578_manager";
$portadb = "3306";
$db = "id17786578_cfa";

$conn = new mysqli($endereco, $userdb, $senhadb, $db);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Erro de conexão: %s\n", mysqli_connect_error());
    exit();
}else{
	//echo "conexao: ON";
}
?>