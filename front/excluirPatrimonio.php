<?php
include('head.php');
include('header.php');
/* <!--PERMISSÃO--> */
$_SESSION['tela_patrimonio'] == 1 ?: header('location: dashboard.php?pagina=1');
include('menu.php');
//incluindo as querys
require_once('../back/query.php');

//coletando dados do membro
$queryPatrimonio .= " AND CFP.id = " . $_GET['idPatrimonio'];
$resultMembro = $conn->query($queryPatrimonio);
$patrimonio = $resultMembro->fetch_assoc();

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
			<li class="active">
				<i class="fas fa-hotel"></i> Patrimônio
			</li>
			<li class="active"><i class="fa fa-trash"></i> <?= $patrimonio['nome'] ?></li>
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
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading textNome">Excluindo o patrimônio: (<?= $patrimonio['nome'] ?>)</div>
				<div class="panel-body">
					<p><i class="fas fa-angle-double-right"></i> Esta opção faz com que você desative o fazendo assim com que ele deixa de ser da <span style="color: red; font-weight: bold;"><?= $sistema['cfa_titulo'] ?></span></p>
					<p> <i class="fas fa-angle-double-right"></i>Deseja realmente fazer essa operação ?</p>
					<br />
					<br />
					<a href="patrimonio.php?pagina=5" class="btn btn-sm btn-primary">
						<i class="fas fa-reply-all"></i> NÃO
					</a>
					<a href="../back/excluirPatrimonio.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>" class="btn btn-sm btn-warning pull-right">
						<i class="fas fa-trash"></i> SIM
					</a>
				</div>
			</div>
		</div>
	</div>

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->