<?php

require_once('../bd/conexao.php');

$dataHoje = date('Y-m-d');

$nome = $_POST['nomeEstudo'];
$lecionador = $_POST['lecionador'];
$observacao = $_POST['observacao'];


if(empty($_GET['idEstudo'])){
    //NOVO ESTUDO
    $query = "INSERT INTO cfa_estudos 
                (nome, lecionador, observacao, data_criacao) 
            VALUES 
                ('$nome', '$lecionador', '$observacao', '$dataHoje')";
    $msn = '1';

}else{
    //EDITANDO ESTUDO
    $query = "UPDATE cfa_estudos 
                SET nome = '$nome', 
                    lecionador = '$lecionador', 
                    observacao = '$observacao'
                WHERE (id = '".$_GET['idEstudo']."')";
    $msn = '2';
}

if(!$result = $conn->query($query)){    
    printf("Error message[1]: %s\n", $conn->error);
}else{
    header('Location: ../front/novoEstudo.php?pagina=7&idEstudo='.$_GET['idEstudo'].'&msn='.$msn.'');
}

$conn->close();