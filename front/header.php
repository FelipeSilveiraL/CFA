<html lang="pt-br">
	<?php
	//sessões do portal
	session_start();
	// Desligue todos os relatórios de erros
	error_reporting(0);

	if ($_SESSION['email'] == NULL) {
		header('Location: ../index.php?erro=1');
	}
	//incluindo o banco de dados
	require_once('../bd/conexao.php');
	//incluindo as permissões
	require_once('../back/permissao.php');
	//incluindo as querys
	require_once('../back/query.php');

	?>

	<body>
		<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Alternar de navegação</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="dashboard.php?pagina=1"><span><?= $sistema['cfa_titulo'] ?></span></a>
				</div>
			</div><!-- /.container-fluid -->
		</nav>