<?php
include('../bd/conexao.php');


if($_GET['config'] == 1){

    $delete = "DELETE FROM cfa_filhos WHERE id = '".$_GET['idFilho']."'";
    $resultado = $conn->query($delete);
}else{
    $delete = "UPDATE cfa_filhos SET nome='1', data_nascimento='1' WHERE id = '".$_GET['idFilho']."'";
    $resultado = $conn->query($delete);
}

$conn->close();

header('location: ../front/novoMembro.php?pagina='.$_GET['pagina'].'&idMembro='.$_GET['idMembro'].'')

?>