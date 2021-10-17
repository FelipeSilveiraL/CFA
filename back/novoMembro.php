<?php
session_start();
//banco de dados
include('../bd/conexao.php');

//variaveis do formulario
$email = $_POST['email'];
$senha = $_POST['senha'];
$str  = $_POST['nome'];
$strS = $_POST['sobrenome'];
$civil = $_POST['civil'];
$sexo = $_POST['genero'];
$celula = $_POST['celula'];
$cargo = $_POST['cargo'];
$nascimento = date('d/m/Y', strtotime($_POST['nascimento']));
$endereco = strtolower($_POST['endereco']);
$numero = $_POST['numero'];
$bairro = strtolower($_POST['bairro']);
$pais = strtolower($_POST['pais']);
$estado = strtolower($_POST['estado']);
$cidade = strtolower($_POST['cidade']);
$cep = $_POST['cep'];
$datahoje = date('d/m/Y');
$responsavel = $_SESSION['id_usuario'];
$celular = $_POST['celular'];
 
// Gera um hash baseado em bcrypt
$custo = '10';
$salt = 'Cf1f11ePArKlBJomM0F6aJ';
$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');

//caminho foto
$dir = '../images/foto_perfil/'; //Diretório para uploads

//tirando espaços do nome/sobrenome
$nome = str_replace(" ", "_", $str);
$sobrenome = str_replace(" ", "_", $strS);

//cadastrando no banco de dados

if(!empty($_GET['idMembro'])){

	//subindo arq foto
	if(isset($_FILES['foto'])){

		$ext = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando extensão do arquivo
		$new_name = "foto-". $nome . $sobrenome . $ext; //Definindo um novo nome para o arquivo    

		if(move_uploaded_file($_FILES['foto']['tmp_name'], $dir.$new_name)){
			echo 'Foto enviada com sucesso!';
			$foto = "foto_perfil = '".$dir.$new_name."',";

		}else{
			echo 'não foi enviado';
		}
		
	}

	$query = "UPDATE cfa_usuarios SET 
	
					nome = '".$nome."',
					sobre_nome = '".$sobrenome."',
					email = '".$email."',";
					$query .= empty($senha) ? "" : "senha = '".  $hash."',";
					$query .= $foto."
					editado_por = '".$responsavel."',
					data_alteracao = '".$datahoje."',
					estado_civil = '".$civil."',
					sexo = '".$sexo."',
					celula = '".$celula."',
					cargo = '".$cargo."',
					data_nascimento = '".$nascimento."',
					endereco = '".$endereco."',
					numero = '".$numero."',
					bairro = '".$bairro."',
					cep = '".$cep."',
					pais = '".$pais."',
					estado = '".$estado."',
					cidade = '".$cidade."',
					celular = '".$celular."'
				
				
				WHERE (id = '".$_GET['idMembro']."')";

}else{

	//subindo arq foto
	if(isset($_FILES['foto'])){

		$ext = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando extensão do arquivo
		$new_name = "foto-". $nome . $sobrenome . $ext; //Definindo um novo nome para o arquivo    

		if(move_uploaded_file($_FILES['foto']['tmp_name'], $dir.$new_name)){
			echo 'Foto enviada com sucesso!';
			$foto = $dir.$new_name;

		}else{
			echo 'não foi enviado';
			$foto = $dir."avatar.png";
		}
		
	}

	$query = "INSERT INTO cfa_usuarios 
					(nome,
					sobre_nome, 
					email, 
					senha,
					foto_perfil,
					cadastrado_por,
					data_criacao,
					estado_civil,
					sexo,
					celula,
					cargo,
					data_nascimento,
					endereco,
					numero,
					bairro,
					cep,
					pais,
					estado,
					cidade,
					celular)
				VALUES
					('".$nome."',
					'".$sobrenome."',
					'".$email."',
					'".$hash."',
					'".$foto."',
					'".$responsavel."',
					'".$datahoje."',
					'".$civil."',
					'".$sexo."',
					'".$celula."',
					'".$cargo."',
					'".$nascimento."',
					'".$endereco."',
					'".$numero."',
					'".$bairro."',
					'".$cep."',
					'".$pais."',
					'".$estado."',
					'".$cidade."',
					'".$celular."')";
	}
	
if(!$result = $conn->query($query)){
	printf("Error message[1]: %s\n", $conn->error);
}else{

	if(!empty($_GET['idMembro'])){
		header('Location: ../front/novoMembro.php?pagina=3&msn=2&idMembro='.$_GET['idMembro'].'');
	}else{
		$query = "SELECT MAX(id) as id FROM cfa_usuarios";
		$resultQuery = $conn->query($query);
		$idUsuario = $resultQuery->fetch_assoc();
	
		header('Location: ../front/novoMembro.php?pagina=3&msn=1&idMembro='.$idUsuario['id'].'');
	}	
}

$conn->close();
