<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

include('head.php');
include('header.php');
/* PERMISSÃO */
$_SESSION['tela_patrimonio'] == 1 ?: header('location: dashboard.php?pagina=1');

include('menu.php');
include('../back/query.php');


if (!empty($_GET['idPatrimonio'])) {
	//coletando do patrimonio
	$queryPatrimonio .= " WHERE CFP.id = " . $_GET['idPatrimonio'];
	$resultPatrimonio = $conn->query($queryPatrimonio);
	$patrimonio = $resultPatrimonio->fetch_assoc();

	$nome = $patrimonio['nome'];
	$titulo = "ID: " . $patrimonio['id'];
	$icon = '<i class="fas fa-hotel"></i>';
	$button = 'Editar';
	$file = "style='display: none'";
} else {

	$titulo = " Dados - Patrimônio";
	$icon = '<i class="fas fa-plus"></i>';
	$button = 'Salvar';
	$display = "style='display: none'";
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
			<li><a href="patrimonio.php?pagina=5"><i class="fas fa-hotel"></i> Patrimônio</li></a>
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

			<div class="row">
				<div class="col-lg-12">
					<div class="alert bg-danger" role="alert" id="msnAlertaDocumento" style="display: <?= $_GET['msn'] == 3 ? "block" : "none" ?>;">
						<em class="fa fa-lg fa-warning">&nbsp;</em> Documentos Permitidos: [ doc, docx, PDF, txt ]<a href="javascript:" class="pull-right" onclick="fecharDoc()"><em class="fa fa-lg fa-close"></em></a>
					</div>
				</div>
			</div>
			<!--/.row-->
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					<i class="fas fa-hotel"></i> <?= $titulo ?>
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<form role="form" method="POST" action="../back/novoPatrimonio.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Nome / Modelo</label>
									<input class="form-control" name="nome" maxlength="50" value="<?= !empty($patrimonio['nome']) ? $patrimonio['nome'] : ""  ?>" required>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label>Código</label>
									<input type="text" class="form-control" name="codigo" maxlength="20" value="<?= !empty($patrimonio['codigo']) ? $patrimonio['codigo'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Categoria</label>
									<select class="form-control" name="categoria">
										<?php
										if (!empty($patrimonio['id_categoria'])) {
											echo '<option value="' . $patrimonio['id_categoria'] . '">' . $patrimonio['categoria'] . '</option>';
											echo '<option>------------</option>';
											while ($categoria = $resultCategoria->fetch_assoc()) {
												echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											while ($categoria = $resultCategoria->fetch_assoc()) {
												echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Local</label>
									<select class="form-control" name="local">
										<?php
										if (!empty($patrimonio['id_local'])) {
											echo '<option value="' . $patrimonio['id_local'] . '">' . $patrimonio['local'] . '</option>';
											echo '<option>------------</option>';
											while ($local = $resultLocal->fetch_assoc()) {
												echo '<option value="' . $local['id'] . '">' . $local['nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											while ($local = $resultLocal->fetch_assoc()) {
												echo '<option value="' . $local['id'] . '">' . $local['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Situação</label>
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

											while ($situacao = $resultSituacao->fetch_assoc()) {
												echo '<option value="' . $situacao['id'] . '">' . $situacao['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Conservação</label>
									<select class="form-control" name="conservacao">
										<?php
										if (!empty($patrimonio['id_conservacao'])) {
											echo '<option value="' . $patrimonio['id_conservacao'] . '">' . $patrimonio['conservacao'] . '</option>';
											echo '<option>------------</option>';
											while ($conservacao = $resultConservacao->fetch_assoc()) {
												echo '<option value="' . $conservacao['id'] . '">' . $conservacao['nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											while ($conservacao = $resultConservacao->fetch_assoc()) {
												echo '<option value="' . $conservacao['id'] . '">' . $conservacao['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Origem</label>
									<select class="form-control" name="origem">
										<?php
										if (!empty($patrimonio['id_origem'])) {
											echo '<option value="' . $patrimonio['id_origem'] . '">' . $patrimonio['origem'] . '</option>';
											echo '<option>------------</option>';
											while ($origem = $resultOrigem->fetch_assoc()) {
												echo '<option value="' . $origem['id'] . '">' . $origem['nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											while ($origem = $resultOrigem->fetch_assoc()) {
												echo '<option value="' . $origem['id'] . '">' . $origem['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Valor</label>
									<input class="form-control" placeholder="R$ 0.000,00" name="valor" maxlength="10" value="<?= !empty($patrimonio['valor']) ? $patrimonio['valor'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-4">
								<div class="form-group">
									<label>Quantidade</label>
									<input type="number" class="form-control" name="quantidade" value="<?= !empty($patrimonio['quantidade']) ? $patrimonio['quantidade'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-8">
								<div class="form-group">
									<label>Data de compra</label>
									<input class="form-control" name="data_compra" maxlength="10" <?php
																									if (!empty($patrimonio['data_compra'])) {

																										$data = date('d/m/Y', strtotime($patrimonio['data_compra']));
																										echo 'value="' . $data . '"';
																										echo 'type="text"';
																									} else {
																										echo 'type="date"';
																									}
																									?>>
								</div>
							</div>
					</div>
					<div class="col-md-6">

						<div class="col-xs-12">
							<div class="form-group">
								<label>Doc. nº</label>
								<input type="text" class="form-control" name="numero_documento" maxlength="10" value="<?= !empty($patrimonio['numero_documento']) ? $patrimonio['numero_documento'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-12" <?= $file ?>>
							<div class="form-group">
								<label>Documento</label>
								<input type="file" class="form-control" name="anexo">
							</div>
						</div>

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
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
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
											$resultadoDocumentos = $conn->query($queryDocumentosPatrimonios);

											while($documentos = $resultadoDocumentos->fetch_assoc()){
												echo '<tr>
														<td>'.$documentos['nome'].'</td>
														<td><a href="'.$documentos['documento'].'" target="_blank"><i class="fas fa-download fa-2x"></i></a></td>
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

		<!-- DOCUMENTAÇÃO -->
		<div class="col-lg-6" id="documentacao">
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					Registros
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Novo Registro
										</button>
									</div>
								</div>
								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Registrou" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Data" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Comentário" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Felipe Lara</td>
											<td>17/10/2021 11:54</td>
											<td>Olá Mundo</td>
										</tr>

										<tr>
											<td>Felipe Lara</td>
											<td>17/10/2021 11:54</td>
											<td>Olá Mundo</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Novo Registro - <?= $titulo ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="../back/patrimonioRegistro.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>" method="post">
						<fieldset>
							<!-- Assunto -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="message">Oservação:</label>
								<div class="col-md-9">
									<textarea class="form-control" id="message" name="observacao" placeholder="..." rows="10"></textarea>
								</div>
							</div>

						</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
				</form>
			</div>
		</div>
	</div>

</div><!-- /.panel-->
</div><!-- /.col-->

<!--/. CONTEUDO-->

<!--FOOTER-->
<?php include('footer.php'); ?>
<!--/. FOOTER-->

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