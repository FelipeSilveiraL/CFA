<?php
session_start();
//banco de dados
include('../bd/conexao.php');

//variaveis do formulario
$nome  = $_POST['nome'];
$diaSemana  = $_POST['dia_semana'];
$data_inauguracao  = $_POST['data_abertura'];
$horario  = $_POST['horario'];
$endereco = strtolower($_POST['endereco']);
$numero = $_POST['numero'];
$bairro = strtolower($_POST['bairro']);
$pais = strtolower($_POST['pais']);
$estado = strtolower($_POST['estado']);
$cidade = strtolower($_POST['cidade']);
$cep = $_POST['cep'];
$datahoje = date('d/m/Y');
$responsavel = $_SESSION['id_usuario'];
 

//cadastrando no banco de dados
if(!empty($_GET['idCelula'])){
	$query = "UPDATE cfa_celulas SET 
	
					nome = '".$nome."',
					data_abertura = '".$data_inauguracao."',
					dia_semana = '".$diaSemana."',
					horario = '".$horario."',
					editado_por = '".$responsavel."',
					data_alteracao = '".$datahoje."',
					endereco = '".$endereco."',
					numero = '".$numero."',
					bairro = '".$bairro."',
					cep = '".$cep."',
					pais = '".$pais."',
					estado = '".$estado."',
					cidade = '".$cidade."'			
				
				WHERE (id = ".$_GET['idCelula'].")";

}else{
	$query = "INSERT INTO cfa_celulas
					(nome,
					cadastrado_por,
					data_abertura,
					dia_semana,
					horario,
					data_criacao,
					endereco,
					numero,
					bairro,
					cep,
					pais,
					estado,
					cidade)
				VALUES
					('".$nome."',
					'".$responsavel."',
					'".$data_inauguracao."',
					'".$diaSemana."',
					'".$horario."',
					'".$datahoje."',
					'".$endereco."',
					'".$numero."',
					'".$bairro."',
					'".$cep."',
					'".$pais."',
					'".$estado."',
					'".$cidade."')";
	}

if(!$result = $conn->query($query)){
	printf("Error message[1]: %s\n", $conn->error);
}else{

	if(!empty($_GET['idCelula'])){
		header('Location: ../front/novaCelula.php?pagina=4&msn=2&idCelula='.$_GET['idCelula'].'');
	}else{
		$query = "SELECT MAX(id) as id FROM cfa_celulas";
		$resultQuery = $conn->query($query);
		$idcelula = $resultQuery->fetch_assoc();
	
		header('Location: ../front/novaCelula.php?pagina=4&msn=1&idCelula='.$idcelula['id'].'');
	}	
}

$conn->close();
