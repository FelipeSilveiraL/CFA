<?php
require_once('../bd/conexao.php');
require_once('../back/permissao.php');
require_once('../back/query.php');

?>

<body onload="myFunctionOrigem()">
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