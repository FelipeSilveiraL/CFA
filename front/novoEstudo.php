<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

include('head.php');
include('header.php');
/* PERMISSÃO */
$_SESSION['tela_estudos'] == 1 ?: header('location: dashboard.php?pagina=1');

include('menu.php');
include('../back/query.php');


if (!empty($_GET['idEstudo'])) {
	//Editar
	
} else {
	//Novo
	$icon = '<i class="fas fa-plus"></i>';
	$nome = 'Novo estudo';
	$titulo = 'Dados - Estudo';
	$button = 'Salvar';
	$display = 'style= "display: none;"';
}

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li>
				<a href="dashboard.php?pagina=1"><i class="fas fa-home"></i> Home</a>
			</li>
			<li><a href="estudos.php?pagina=7"><i class="fas fa-graduation-cap"></i> Estudos</li></a>
			<li class="active"><?= $icon . " " . $nome ?></li>
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
			<div class="row">
				<div class="col-lg-12">
					<div class="alert bg-success" role="alert" id="msnAlertaSuccess" style="display: <?= $_GET['msn'] == 1 ? "block" : "none" ?>;">
						<em class="fa fa-lg fa-warning">&nbsp;</em> Cadastrado com sucesso!<a href="javascript:" class="pull-right" onclick="fecharSuccess()"><em class="fa fa-lg fa-close"></em></a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="alert bg-info" role="alert" id="msnAlertaInfo" style="display: <?= $_GET['msn'] == 2 ? "block" : "none" ?>;">
						<em class="fa fa-lg fa-warning">&nbsp;</em> Editado com sucesso!<a href="javascript:" class="pull-right" onclick="fecharInfo()"><em class="fa fa-lg fa-close"></em></a>
					</div>
				</div>
			</div>
			<!--/.row-->
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					<i class="fas fa-graduation-cap"></i> <?= $titulo ?>
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<form role="form" method="POST" action="../back/novoPatrimonio.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Nome</label>
									<input class="form-control" name="nome" maxlength="50" value="<?= !empty($patrimonio['nome']) ? $patrimonio['nome'] : ""  ?>" required>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label>Lecionador</label>
									<select class="form-control" name="situacao">
										<?php
										if (!empty($patrimonio['id_situacao'])) {
											echo '<option value="' . $patrimonio['id_situacao'] . '">' . $patrimonio['situacao'] . '</option>';
											echo '<option>------------</option>';
											while ($situacao = $resultSituacao->fetch_assoc()) {
												echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											$resultUsuarios = $conn->query($queryUsuarios);
											while ($usuarios = $resultUsuarios->fetch_assoc()) {
												echo '<option value="' . $usuarios['id'] . '">' . $usuarios['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-12">
							<div class="form-group">
								<label>Observações</label>
								<textarea class="form-control" id="message" name="observacao" placeholder="..." rows="10"><?= !empty($patrimonio['observacao']) ? $patrimonio['observacao'] : ""  ?></textarea>
							</div>
						</div>

						<div style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "block" : "none" ?>;">
							<button type="submit" class="btn btn-success" id="enviar">
								<i class="fas fa-share fa-sm text-white-50"></i>&nbsp;<?= $button ?>
							</button>
							<button type="reset" class="btn btn-info pull-right">
								<i class="fas fa-broom fa-sm text-white-50"></i>&nbsp;Desfazer
							</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row" <?= $display ?>>
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					Documentos
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#doc" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Novo Documento
										</button>
									</div>
								</div>
								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Nome" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Caminho" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$queryDocumentosPatrimonios .= " WHERE id_patrimonio = ".$_GET['idPatrimonio'];
										$resultadoDocumentos = $conn->query($queryDocumentosPatrimonios);

										while ($documentos = $resultadoDocumentos->fetch_assoc()) {
											echo '<tr>
														<td>' . $documentos['nome'] . '</td>
														<td><a href="' . $documentos['documento'] . '" target="_blank"><i class="fas fa-download fa-2x"></i></a></td>
													</tr>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.panel-->
</div><!-- /.col-->

<!--/. CONTEUDO-->

<!-- FECHAR MSN DE CADASTRADO COM SUCESSO -->
<script>
	function fecharSuccess() {
		let msn = document.getElementById("msnAlertaSuccess").style.display;

		if (msn == "block") {
			document.getElementById("msnAlertaSuccess").style.display = "none";
		}
	}
</script>



<script>
	function fecharInfo() {
		let msn = document.getElementById("msnAlertaInfo").style.display;

		if (msn == "block") {
			document.getElementById("msnAlertaInfo").style.display = "none";
		}
	}
</script>

<script>
	function fecharDoc() {
		let msn = document.getElementById("msnAlertaDocumento").style.display;

		if (msn == "block") {
			document.getElementById("msnAlertaDocumento").style.display = "none";
		}
	}
</script>

<!--FOOTER-->
<?php include('footer.php'); ?>
<!--/. FOOTER-->