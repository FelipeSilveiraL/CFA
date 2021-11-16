<?php

require_once('../bd/conexao.php');

//Senha vindo do formulario
$senha = $_POST['passAlterarSenha'];

// Gera um hash baseado em bcrypt
$custo = '10';
$salt = 'Cf1f11ePArKlBJomM0F6aJ';
$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');

//alterando a senha no banco
$update = "UPDATE cfa_usuarios SET senha = '".$hash."', alterarSenha = 0  WHERE (id = ".$_GET['idUsuario'].")";

if($resultUpdate = $conn->query($update)){
    header('Location: ../index.php?pag=1&msn=1');
}else{    
    printf("Error message[1]: %s\n", $conn->error);
}