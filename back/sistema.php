<?php
//banco de dados
include('../bd/conexao.php');


//alterando os dados
$update = "UPDATE cfa_sistema SET 
            cfa_titulo = '".$_POST['titulo']."',
            cfa_titulo_login = '".$_POST['tituloLogin']."', 
            cfa_subtitulo_login = '".$_POST['subtituloLogin']."',
            cfa_footer = '".$_POST['redape']."'";


if(isset($_FILES['file'])){
    date_default_timezone_set("Brazil/East"); //Definindo timezone padrão

    $ext = strtolower(substr($_FILES['file']['name'],-4)); //Pegando extensão do arquivo
    $new_name = "logo-". date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
    $dir = '../images/'; //Diretório para uploads

    if(move_uploaded_file($_FILES['file']['tmp_name'], $dir.$new_name)){
        $update .= ", cfa_logo_login= '".$dir.$new_name."'";
    }else{
        header('Location: ../front/sistema.php?pagina=2&erro=1');
    } //Fazer upload do arquivo    
}

$update .= " WHERE (id = '1')";

if(!$result = $conn->query($update)){
    printf("Error message[2]: %s\n", $conn->error);

    header('Location: ../front/sistema.php?pagina=2&erro=2');
}else{
    header('Location: ../front/sistema.php?pagina=2');
}
