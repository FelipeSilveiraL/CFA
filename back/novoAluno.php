<?php

require_once('../bd/conexao.php');


foreach ($_POST['aluno'] as $key => $idUsuario) {
    
    //salvando
    $insert = "INSERT INTO cfa_estudantes (id_estudo, id_usuario, data_inicio, data_fim, status) 
                VALUES 
                (
                '".$_GET['idEstudo']."', 
                '".$idUsuario."', 
                '".$_POST['data_inicio'.$idUsuario]."',
                '".$_POST['data_fim'.$idUsuario]."',
                '".$_POST['status'.$idUsuario]."'
                )";
    $result = $conn->query($insert);
}

header('Location: ../front/novoEstudo.php?pagina=7&idEstudo='.$_GET['idEstudo'].'#alunos');

$conn->close();