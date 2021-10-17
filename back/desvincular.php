<?php

    include('../bd/conexao.php');

    switch ($_GET['modo']) {
        case '1':
            # lider...
            $query = "DELETE FROM cfa_celula_lideres WHERE (id_usuario = '".$_GET['idMembro']."')";
            $location = "lider";
            break;
        
        case '2':
            # Membro...
            $query = "UPDATE cfa_usuarios SET celula = '0' WHERE (id = '".$_GET['idMembro']."')";
            $location = "membro";
            break;
    }

    if (!$result = $conn->query($query)) {
        printf("Error message[1]: %s\n", $conn->error);
    } else {
        header('location: ../front/novaCelula.php?pagina=4&idCelula='.$_GET['idCelula'].'#'.$location.'');
    }
?>
