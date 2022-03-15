<?php
	session_start();

	//banco de dados
	require_once '../bd/conexao.php';
	require_once 'query.php';
	
	//bcrypt - SENHA
	$custo = '10';
	$salt = 'Cf1f11ePArKlBJomM0F6aJ';
	$hash = crypt($_POST['passLogar'], '$2a$' . $custo . '$' . $salt . '$');

	//SQL injection
	$email = $conn->real_escape_string($_POST['email']);


	//validando usuario
	$queryUsuarios .= " WHERE U.email = '".$email."' AND U.senha = '".$hash."'";
	$result = $conn->query($queryUsuarios);
	$usuario = $result->fetch_assoc();

	if(!empty($usuario['email'])){

		if($usuario['deletar'] == 1){
			//volta
			header('Location: ../adm.php?erro=2');
		}else{
			

			############ DADOS DO USUÁRIO ############

			$_SESSION['nome'] = $usuario['nome'];
			$_SESSION['sobre_nome'] = $usuario['sobre_nome'];
			$_SESSION['email'] = $usuario['email'];
			$_SESSION['id_usuario'] = $usuario['id'];
			$_SESSION['foto_perfil'] = $usuario['foto_perfil'];
			$_SESSION['deletar_usuario'] = $usuario['deletar'];
			
			
			############ PERMISSÕES ############
			/* 
				query.php - Chamar a tela cadastrada no banco
				permissao.php - colocar o active e se o usuário pode ver ela ou não
			*/

			//TELAS
			$_SESSION['tela_configuracao'] = $usuario['tela_configuracoes'];
			$_SESSION['tela_membros'] = $usuario['tela_membros'];
			$_SESSION['tela_celula'] = $usuario['tela_celula'];
			$_SESSION['tela_patrimonio'] = $usuario['tela_patrimonio'];		
			$_SESSION['tela_financeiro'] = $usuario['tela_financeiro'];		
			$_SESSION['tela_estudos'] = $usuario['tela_estudos'];

			//TELA CONFIGURAÇÔES
			$_SESSION['config_informacao'] = $usuario['config_informacao'];
			$_SESSION['config_sistema'] = $usuario['config_sistema'];
			$_SESSION['config_menus'] = $usuario['config_menus'];

			//TELA MEMBROS
			$_SESSION['membro_editar'] = $usuario['membro_editar'];
			$_SESSION['membro_excluir'] = $usuario['membro_excluir'];
			$_SESSION['membro_adicionar'] = $usuario['membro_adicionar'];
			$_SESSION['membro_permissao'] = $usuario['membro_permissao'];//permite acessar a tela => front/permissao.php

			//TELA CÉLULA
			$_SESSION['celula_editar'] = $usuario['celula_editar'];
			$_SESSION['celula_excluir'] = $usuario['celula_excluir'];
			$_SESSION['celula_adicionar'] = $usuario['celula_adicionar'];		
			$_SESSION['celula_incluir_lider'] = $usuario['celula_incluir_lider'];
			$_SESSION['celula_excluir_lider'] = $usuario['celula_excluir_lider'];
			$_SESSION['celula_incluir_membro'] = $usuario['celula_incluir_membro'];
			$_SESSION['celula_excluir_membro'] = $usuario['celula_excluir_membro'];
			$_SESSION['celula_incluir_reuniao'] = $usuario['celula_incluir_reuniao'];

			//TELA PATRIMONIO		
			$_SESSION['patrimonio_adicionar'] = $usuario['patrimonio_adicionar'];
			$_SESSION['patrimonio_excluir'] = $usuario['patrimonio_excluir'];

			//TELA FINANCEIRO		
			$_SESSION['financeiro_adicionar'] = $usuario['financeiro_adicionar'];
			$_SESSION['financeiro_excluir'] = $usuario['financeiro_excluir'];

			//TELA ESTUDOS
			$_SESSION['estudos_adicionar'] = $usuario['estudos_adicionar'];
			$_SESSION['estudos_excluir'] = $usuario['estudos_excluir'];

			//levando o usuário para a pagina principal
			header('Location: ../front/dashboard.php?pagina=1');
		}
	}else{
		//volta
		header('Location: http://cfasitiocercado.com.br/adm.php?erro=1&pag=1');
	}
	
	
	$conn->close();
?>