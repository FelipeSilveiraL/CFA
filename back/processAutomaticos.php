<?php
require_once('/home2/cfasit28/public_html/bd/conexao.php');
require_once('/home2/cfasit28/public_html/back/query.php');

/* ========== CURSOS ========== */

//verificando dadas de conclusão de cursos

$resultEstudantes = $conn->query($queryEstudantes);

while($estudantes = $resultEstudantes->fetch_assoc()){
    if($estudantes['data_fim'] < date('Y-m-d')){
        $update = "UPDATE cfa_estudantes SET status = 'Concluido' WHERE (id = '".$estudantes['id']."')";
        if(!$aplicar = $conn->query($update)){
            printf("Error message[1]: %s\n", $conn->error);
        }
    }
}

//FIM