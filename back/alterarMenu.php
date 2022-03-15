<?php

include('../bd/conexao.php');

switch ($_GET['opcao']) {
    case '1': //new
        $query = "INSERT INTO ".$_GET['db']." (nome) VALUES ('".strtoupper($_POST['menu'])."')";
        break;
    
    case '2'://edit
        $query = "UPDATE ".$_GET['db']." SET nome = '".strtoupper($_POST['menu'])."' WHERE (id = '".$_GET['id']."')";
        break;

    case '3':// drop
        $query = "DELETE FROM ".$_GET['db']." WHERE (id = '".$_GET['id']."')";
        break;
}

if(!$result = $conn->query($query)){
	printf("Error message[1]: %s\n", $conn->error);
}else{
	header('Location: ../front/alterarmenu.php?pagina=2&idMenu='.$_GET['idMenu'].'');
}

$conn->close();
?>