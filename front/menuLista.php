<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_configuracao'] == 1 ?: header('location: dashboard.php?pagina=1');

include('head.php');
include('header.php');
include('menu.php');
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php?pagina=1">
					<i class="fas fa-home"></i> Home
				</a>
			</li>
			<li>
				<a href="configuracao.php?pagina=2">
					<i class="fas fa-tools"></i> Configuração
				</a>
			</li>
			<li class="active"><i class="fas fa-bars fa-sm text-white-50"></i> Menus Lista</li>
		</ol>
	</div>
	<!-- /.NAVEGAÇÃO-->

	<!--TITULO DA PAGINA-->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"></h1>
		</div>
	</div>
	<!--/. TITULO DA PAGINA-->

	<!--CONTEUDO-->
	<div class="row">

		<!-- INCARGOS -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=1">
					<div class="panel-body easypiechart-panel">
						<h4>Incargos</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- GENERO -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=2">
					<div class="panel-body easypiechart-panel">
						<h4>Gênero</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- ESTADO CIVIL -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=3">
					<div class="panel-body easypiechart-panel">
						<h4>Estado Cívil</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- CONSERCAÇÃO -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=4">
					<div class="panel-body easypiechart-panel">
						<h4>Conservação</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- CATEGORIAS -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=5">
					<div class="panel-body easypiechart-panel">
						<h4>Categorias</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- LOCAL -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=6">
					<div class="panel-body easypiechart-panel">
						<h4>Local</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- ORIGEM -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=7">
					<div class="panel-body easypiechart-panel">
						<h4>Origem</h4>
					</div>
				</a>
			</div>
		</div>

		<!-- SITUAÇÃO -->
		<div class="col-xs-6 col-md-3">
			<div class="panel panel-default">
				<a href="alterarmenu.php?pagina=2&idMenu=8">
					<div class="panel-body easypiechart-panel">
						<h4>Situação</h4>
					</div>
				</a>
			</div>
		</div>




	</div>

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->