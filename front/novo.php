<?php
session_start();
	include('head.php');
	include('header.php');	
	/* PERMISSÃO */
	/* $_SESSION['tela_membros'] == 1 ?: header('location: dashboard.php?pagina=1'); */
	include('menu.php');
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php?pagina=1">
					<i class="fas fa-home"></i> Em branco
				</a>
			</li>
			<li class="active"><i class="fas fa-tools"></i> Branco</li>
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

	<!-- /================ COLOQUE O SEU CONTEUDO AQUI! ================/ -->

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->