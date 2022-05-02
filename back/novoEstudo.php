<?php

require_once('../bd/conexao.php');

$dataHoje = date('Y-m-d');
$hora = date('h-i-s');

$nome = $_POST['nomeEstudo'];
$lecionador = $_POST['lecionador'];
$observacao = $_POST['observacao'];


if (empty($_GET['idEstudo'])) {
    //NOVO ESTUDO
    $query = "INSERT INTO cfa_estudos 
                (nome, lecionador, observacao, data_criacao) 
            VALUES 
                ('$nome', '$lecionador', '$observacao', '$dataHoje')";
    $msn = '1';

    if (!$result = $conn->query($query)) {
        printf("Error message[1]: %s\n", $conn->error);
    }
    //caminho apostila
    $dir = '../documentos/apostilas/'; //Diretório para uploads
    //tirando espaços do nome
    $str = str_replace(" ", "_", $nome);

    //subindo Apostila
    if (isset($_FILES['apostila'])) {

        switch ($_FILES['apostila']['type']) {
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': //docx
                $ext = strtolower(substr($_FILES['apostila']['name'], -5)); //Pegando extensão do arquivo
                break;

            default:
                $ext = strtolower(substr($_FILES['apostila']['name'], -4)); //Pegando extensão do arquivo
                break;
        }

        $new_name = "apostila-" . $str . $hora . $ext; //Definindo um novo nome para o arquivo    

        if (move_uploaded_file($_FILES['apostila']['tmp_name'], $dir . $new_name)) {
            /* echo 'apostila enviada com sucesso![1]'; */
            /* $arquivo = "apostila = '" . $dir . $new_name . "',"; */

            $buscandoCurso = "SELECT MAX(id) AS id_estudo FROM cfa_estudos";
            $resultCurso = $conn->query($buscandoCurso);
            $curso = $resultCurso->fetch_assoc();
            $a = $curso['id_estudo'];

            $salvandoApostila = "INSERT INTO cfa_apostilas (id_curso, nome, caminho) VALUES ('" . $a++ . "', '" . $new_name . "', '" . $dir . $new_name . "')";
            $salvou = $conn->query($salvandoApostila);
        } else {
            /* echo 'não foi enviado, erro[1]'; */
        }
    }

    header('Location: ../front/novoEstudo.php?pagina=7&idEstudo=' . $_GET['idEstudo'] . '&msn=' . $msn . '');
} else {
    //EDITANDO ESTUDO
    $query = "UPDATE cfa_estudos 
                SET nome = '$nome', 
                    lecionador = '$lecionador', 
                    observacao = '$observacao'
                WHERE (id = '" . $_GET['idEstudo'] . "')";
    $msn = '2';

    if (!$result = $conn->query($query)) {
        printf("Error message[2]: %s\n", $conn->error);
    } else {
        header('Location: ../front/novoEstudo.php?pagina=7&idEstudo=' . $_GET['idEstudo'] . '&msn=' . $msn . '');
    }
}

$conn->close();
