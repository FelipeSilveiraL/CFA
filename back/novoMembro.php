<?php
session_start();
//banco de dados
include('../bd/conexao.php');

//variaveis do formulario
$email = $_POST['email'];
$senha = !empty($_POST['senha']) ? $_POST['senha'] : "cfasitiocercado312";
$nome  = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$rg = $_POST['rg'];
$civil = $_POST['civil'];
$conjuge = $_POST['nome_conjuge'];
$sexo = $_POST['genero'];
$celula = $_POST['celula'];
$telefone = $_POST['telefone'];
$cargo = $_POST['cargo'];
$nascimento = $_POST['nascimento'];
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
$str = str_replace(" ", "_", $nome);
$strs = str_replace(" ", "_", $sobrenome);

//cadastrando no banco de dados

if(!empty($_GET['idMembro'])){

	//subindo arq foto
	if(isset($_FILES['foto'])){

		$ext = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando extensão do arquivo
		$new_name = "foto-". $str . $strs . $ext; //Definindo um novo nome para o arquivo    

		if(move_uploaded_file($_FILES['foto']['tmp_name'], $dir.$new_name)){
			//echo 'Foto enviada com sucesso![1]';
			$foto = "foto_perfil = '".$dir.$new_name."',";

		}else{
			//echo 'não foi enviado, erro[1]';
		}
		
	}

	$query = "UPDATE cfa_usuarios SET 
					rg = '".$rg."',
					nome = '".$nome."',
					sobre_nome = '".$sobrenome."',
					nome_conjuge '".$conjuge."',
					email = '".$email."',";
					$query .= empty($senha) ? "" : "senha = '".  $hash."',";
					$query .= $foto."
					editado_por = '".$responsavel."',
					data_alteracao = '".$datahoje."',
					estado_civil = '".$civil."',
					sexo = '".$sexo."',
					celula = '".$celula."',
					telefone = '".$telefone."',
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
		$new_name = "foto-". $str . $strs . $ext; //Definindo um novo nome para o arquivo    

		if(move_uploaded_file($_FILES['foto']['tmp_name'], $dir.$new_name)){
			//echo 'Foto enviada com sucesso![2]';
			$foto = $dir.$new_name;

		}else{
			//echo 'não foi enviado, erro[2]';
			$foto = $dir."avatar.png";
		}
		
	}

	$query = "INSERT INTO cfa_usuarios 
					(rg,
					nome,
					sobre_nome,
					nome_conjuge,
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
					celular,
					telefone)
				VALUES
					('".$rg."',
					'".$nome."',
					'".$sobrenome."',
					'".$conjuge."',
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
					'".$celular."',
					'".$telefone."')";
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

		//cadastrar permissões
		$queryPermissao = "INSERT INTO cfa_permissao 
							(id_usuario, 
							tela_configuracoes, 
							tela_membros, 
							tela_celula, 
							tela_patrimonio, 
							tela_financeiro, 
							tela_estudos, 
							config_informacao, 
							config_sistema, 
							config_menus, 
							membro_editar, 
							membro_excluir, 
							membro_adicionar, 
							membro_permissao, 
							celula_adicionar,
							celula_editar, 
							celula_excluir, 
							celula_incluir_lider, 
							celula_excluir_lider, 
							celula_incluir_membro, 
							celula_excluir_membro, 
							celula_incluir_reuniao, 
							patrimonio_adicionar, 
							patrimonio_excluir,
							financeiro_adicionar, 
							financeiro_excluir, 
							estudos_adicionar,
							estudos_excluir) 
						VALUES ('".$idUsuario['id']."', 
								'0', '0', '1', '0', '0', '0', '0', 
								'0', '0', '0', '0', '0', '0', '0', 
								'0', '0', '0', '0', '0', '0', '0', 
								'0', '0', '0', '0', '0', '0')";
								
		$resultPermissao = $conn->query($queryPermissao);

		//CADASTRAR FILHOS
		for ($i=0; $_POST['nomePlus'.$i.''] != null; $i++) { 

			$insertVisitante = "INSERT INTO cfa_filhos (id_pais, nome, data_nascimento) 
									VALUES 
										('".$idUsuario['id']."', '".$_POST['nomePlus'.$i.'']."', '".$_POST['dataNascimento'.$i.'']."')";
	
			if(!$resultInsertVisitante = $conn->query($insertVisitante)){
				printf("Error[".$i."]: %s\n:", $conn->error);  
			}  
	
		}
	
		header('Location: ../front/novoMembro.php?pagina=3&msn=1&idMembro='.$idUsuario['id'].'');
	}	
}

$conn->close();
