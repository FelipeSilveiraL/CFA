<?php

    include('../bd/conexao.php');

    switch ($_GET['modo']) {
        case '1':
            # lider...
            $query = "INSERT INTO cfa_celula_lideres (id_celula, id_usuario) VALUES ('".$_GET['idCelula']."', '".$_POST['lider']."')";
            $location = "lider";
            break;
        
        case '2':
            # Membro...
            $query = "UPDATE cfa_usuarios SET celula = '".$_GET['idCelula']."' WHERE (id = '".$_POST['membro']."')";
            $location = "membro";
            break;
    }

    if (!$result = $conn->query($query)) {
        printf("Error message[1]: %s\n", $conn->error);
    } else {
        header('location: ../front/novaCelula.php?pagina=4&idCelula='.$_GET['idCelula'].'#'.$location.'');
    }
?>
