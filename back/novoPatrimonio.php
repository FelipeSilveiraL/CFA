<?php
session_start();
//banco de dados
include('../bd/conexao.php');
include('query.php');

//variaveis do formulario
$nome  = $_POST['nome'];
$codigo  = $_POST['codigo'];
$categoria  = $_POST['categoria'];
$local  = $_POST['local'];
$situacao = $_POST['situacao'];
$conservacao = $_POST['conservacao'];
$origem = $_POST['origem'];
$str =  str_replace("R$ ", "", $_POST['valor']);
$valor = "R$ ". $str;
$quantidade = $_POST['quantidade'];
$datacompra = date('Y-m-d', strtotime($_POST['data_compra']));
$numerodocumento = $_POST['numero_documento'];
$responsavel = $_SESSION['id_usuario'];
$observacao = $_POST['observacao'];
 

//cadastrando no banco de dados
if(!empty($_GET['idPatrimonio'])){

	$query = "UPDATE cfa_patrimonio SET 

				nome = '".$nome."',
				codigo = '".$codigo."',
				categoria = '".$categoria."',
				local = '".$local."',
				situacao = '".$situacao."',
				conservacao = '".$conservacao."',
				origem = '".$origem."',
				valor = '".$valor."',
				quantidade = '".$quantidade."',
				data_compra = '".$datacompra."',
				numero_documento = '".$numerodocumento."',
				observacao = '".$observacao."'		
			
			WHERE (id = ".$_GET['idPatrimonio'].")";

}else{

	//subindo arq foto
	if(isset($_FILES['anexo'])){

		//verificando se o arqivo é permitido
		$tipoDoc = $_FILES['anexo']['type'];		

		$queryDocumentosPermitidos .= " WHERE documento = '".$tipoDoc."'";		
		$resultDocumentosPermitidos = $conn->query($queryDocumentosPermitidos);
		$docuPermitido = $resultDocumentosPermitidos->fetch_assoc();

		if($docuPermitido['id'] == NULL){

			header('Location: ../front/novoPatrimonio.php?pagina=5&msn=3');
			exit;

		}else{

			//caminho documento
			$dir = '../documentos/patrimonio/'; //Diretório para uploads
			$ext = strtolower(substr($_FILES['anexo']['name'],-4)); //Pegando extensão do arquivo
			$new_name = date('dmyHi'). $_FILES['anexo']['name'] . $ext; //Definindo um novo nome para o arquivo    
	
			if(move_uploaded_file($_FILES['anexo']['tmp_name'], $dir.$new_name)){

				echo 'Ok - documento enviado';
				$documentoOK = "1";
	
			}else{
				echo 'Erro[1] - Documento nao pode ser enviado com sucesso!';			
				exit;
			}

		}		
		
	}

	$query = "INSERT INTO cfa_patrimonio
					(nome,
					codigo,
					categoria,
					local,
					situacao,
					conservacao,
					origem,
					valor,
					quantidade,
					data_compra,
					numero_documento,
					observacao)
				VALUES
					('".$nome."',
					'".$codigo."',
					'".$categoria."',
					'".$local."',
					'".$situacao."',
					'".$conservacao."',
					'".$origem."',
					'".$valor."',
					'".$quantidade."',
					'".$datacompra."',
					'".$numerodocumento."',
					'".$observacao."')";
	}


if(!$result = $conn->query($query)){
	printf("Error message[2]: %s\n", $conn->error);
}else{

	if(!empty($_GET['idPatrimonio'])){
		header('Location: ../front/novoPatrimonio.php?pagina=5&msn=2&idPatrimonio='.$_GET['idPatrimonio'].'');
	}else{

		$query = "SELECT MAX(id) as id FROM cfa_patrimonio";
		$resultQuery = $conn->query($query);
		$idPatrimonio = $resultQuery->fetch_assoc();

		if($documentoOK == 1){

			$insertDocumento = "INSERT INTO cfa_patrimonio_documentos (id_patrimonio, documento) VALUES ('".$idPatrimonio['id']."', '".$dir.$new_name."')";

			$resultQueryS = $conn->query($insertDocumento);
		}

		header('Location: ../front/novoPatrimonio.php?pagina=5&msn=1&idPatrimonio='.$idPatrimonio['id'].'');		
	}	
}

$conn->close();