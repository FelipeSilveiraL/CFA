<?php
session_start();
include('head.php');
include('header.php');
/* PERMISSÃO */
$_SESSION['tela_configuracao'] == 1 ?: header('location: dashboard.php?pagina=1');
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
			<li class="active"><i class="fas fa-tools"></i> Configuração</li>
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

	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Escolha uma opção</div>
			<div class="panel-body">
				<div class="col-md-12">
					<a href="menuLista.php?pagina=2" type="button" class="btn btn-lg btn-primary" style="display: <?= $_SESSION['config_menus'] == 1 ? "inline-block" : "none" ?>;">
						<i class="fas fa-bars fa-sm text-white-50"></i>&nbsp; Menus
					</a>
					<a href="sistema.php?pagina=2" type="button" class="btn btn-lg btn-danger" style="display: <?= $_SESSION['config_sistema'] == 1 ? "inline-block" : "none" ?>;">
						<i class="fas fa-sitemap fa-sm text-white-50"></i>&nbsp; Sistema
					</a>
					<a href="info.php?pagina=2" type="button" class="btn btn-lg btn-warning" style="display: <?= $_SESSION['config_informacao'] == 1 ? "inline-block" : "none" ?>;">
						<i class="fas fa-info-circle fa-sm text-white-50"></i>&nbsp; Informação
					</a>
					<br>
					<br>
				</div>
			</div>
		</div><!-- /.panel-->
	</div>

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->
