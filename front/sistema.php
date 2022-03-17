<?php
session_start();

if ($_SESSION['email'] == NULL) {
	header('Location: ../adm.php?erro=1');
}

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
			<li>
				<a href="configuracao.php?pagina=2">
					<i class="fas fa-tools"></i> Configuração
				</a>
			</li>
			<li class="active"><i class="fas fa-sitemap fa-sm text-white-50"></i> Sistema</li>
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

			<?php
			//ALERTAS

			switch ($_GET['erro']) {
				case '1':
					echo '<div class="alert bg-danger" role="alert">
								<em class="fa fa-lg fa-warning">&nbsp;</em>
								Não foi possivel alterar a imagem.
							</div>';
					break;

				case '2':
					echo '<div class="alert bg-danger" role="alert">
									<em class="fa fa-lg fa-warning">&nbsp;</em>
									Não foi possivel salvar os dados, entre em contato com o administrador do sistema
								</div>';
					break;
			}
			?>


			<div class="panel panel-default">
				<div class="panel-heading">Campos do Sistema</div>
				<div class="panel-body">
					<div class="col-md-6">
						<form role="form" method="POST" action="../back/sistema.php" enctype="multipart/form-data">
							<div class="form-group">
								<label>Instituição: </label>
								<input class="form-control" name="titulo" value="<?= $sistema['cfa_titulo'] ?>">
							</div>
							<div class="form-group">
								<label>Endereço: </label>
								<input class="form-control" name="endereco" value="<?= $sistema['cfa_endereco'] ?>">
							</div>
							<div class="form-group">
								<label>CNPJ: </label>
								<input class="form-control" name="cnpj" value="<?= $sistema['cfa_cnpj'] ?>">
							</div>
							<div class="form-group">
								<label>Telefone: </label>
								<input class="form-control" name="telefone" value="<?= $sistema['cfa_telefone'] ?>">
							</div>
							<div class="form-group">
								<label>Rodapé: </label>
								<input type="text" class="form-control" name="redape" value="<?= $sistema['cfa_footer'] ?>">
							</div>
							<div class="form-group">
								<label>Logo - Tela Login: </label>
								<input type="file" name="file">
								<p class="help-block">Dimensão Permitida: 624 x 624</p>
								<span class="chat-img pull-right">
									<img src="<?= $sistema['cfa_logo_login'] ?>" class="img-circle imgLogo">
								</span>

							</div>
							<div class="form-group">
								<label>Título - Tela Login: </label>
								<input class="form-control" name="tituloLogin" value="<?= $sistema['cfa_titulo_login'] ?>">
							</div>
							<div class="form-group">
								<label>Subtítulo - Tela Login: </label>
								<input class="form-control" name="subtituloLogin" value="<?= $sistema['cfa_subtitulo_login'] ?>" >
							</div>
							<button type="submit" class="btn btn-primary pull-right"><i class="fas fa-share fa-sm text-white-50"></i>&nbsp;Salvar</button>
							<button type="reset" class="btn btn-default"><i class="fas fa-broom fa-sm text-white-50"></i>&nbsp;Desfazer</button>
						</form>
					</div>
				</div>
			</div>
		</div><!-- /.panel-->
	</div>
	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->