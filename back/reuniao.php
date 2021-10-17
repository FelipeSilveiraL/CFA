<?php
include('../bd/conexao.php');

//SALVAR REUNIÃO
$insertReuniao = "INSERT INTO cfa_reuniao (id_celula, data_reuniao, assunto, Ofertas) 
                    VALUES 
                        ('".$_GET['idCelula']."', '".$_POST['date']."', '".$_POST['assunto']."', 'R$ ".$_POST['oferta']."')";

if(!$resultInsertReuniao = $conn->query($insertReuniao)){
    printf("Error[1]: %s\n:", $conn->error);
}else{

    //ID da reunião
    $queryIDReuniao = "SELECT MAX(id) as id_reuniao FROM cfa_reuniao";
    $resultID = $conn->query($queryIDReuniao);
    $idReuniao = $resultID->fetch_assoc();

    //SALVAR VISITANTES
    for ($i=0; $_POST['nomeVisitante'.$i.''] != null; $i++) { 

        $insertVisitante = "INSERT INTO cfa_visitantes (id_reuniao, nome) 
                                VALUES 
                                    ('".$idReuniao['id_reuniao']."', '".$_POST['nomeVisitante'.$i.'']."')";

        if(!$resultInsertVisitante = $conn->query($insertVisitante)){
            printf("Error[".$i."]: %s\n:", $conn->error);  
        }  

    }

    //SALVAR PARTICIPANTES
    foreach ($_POST['participante'] as $key => $id_usuario) {

        $getNome = "SELECT nome FROM cfa_usuarios WHERE id = ".$id_usuario;
        $resutado = $conn->query($getNome);
        $nome = $resutado->fetch_assoc();


        $insertParticipante = "INSERT INTO cfa_participantes (id_reuniao, nome, id_usuario) 
                                VALUES 
                                    ('".$idReuniao['id_reuniao']."', '".$nome['nome']."', '".$id_usuario."')";

        if(!$resultInsertParticipante = $conn->query($insertParticipante)){
            printf("Error[".$nome['nome']."]: %s\n:", $conn->error);
        

        }

    }

}

header('Location: ../front/novaCelula.php?pagina=4&idCelula='.$_GET['idCelula'].'#reuniao');

?>