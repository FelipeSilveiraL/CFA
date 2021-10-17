<?php
include('../bd/conexao.php');

$delete = "DELETE FROM cfa_reuniao WHERE (id = '".$_GET['idReuniao']."')";

if (!$result = $conn->query($delete)) {
    printf("Error message[1]: %s\n", $conn->error);
} else {
    //remove participantes
    $deleteParticipantes = "DELETE FROM cfa_participantes WHERE (id_reuniao = '".$_GET['idReuniao']."')";
    $result = $conn->query($deleteParticipantes);


    //remove visitantes
    $delete = "DELETE FROM cfa_visitantes WHERE (id_reuniao = '".$_GET['idReuniao']."')";
    $result = $conn->query($delete);

    //volta para a tela
    header('location: ../front/novaCelula.php?pagina=4&idCelula=' . $_GET['idCelula'] . '#reuniao');
}