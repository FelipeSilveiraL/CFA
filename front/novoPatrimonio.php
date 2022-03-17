<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_patrimonio'] == 1 ?: header('location: dashboard.php?pagina=1');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

include('../back/query.php');
include('head.php');
include('header.php');
include('menu.php');


if (!empty($_GET['idPatrimonio'])) {
	//coletando do patrimonio
	$queryPatrimonio .= " WHERE CFP.id = " . $_GET['idPatrimonio'];
	$resultPatrimonio = $conn->query($queryPatrimonio);
	$patrimonio = $resultPatrimonio->fetch_assoc();

	if ($patrimonio['id_origem'] == 7) {
		
		$buttonRecibo = "Emitir Recibo";
		$reciboBotao = "block";

		if($patrimonio['recibo_emitido'] == 1){
			$recibo = "block";
		}else {
			$recibo = "none";
		}
	}else{
		$reciboBotao = "none";
		$recibo = "none";
	}

	$nome = $patrimonio['nome'];
	$titulo = "ID: " . $patrimonio['id'];
	$icon = '<i class="fas fa-hotel"></i>';
	$button = 'Editar';
	$file = "style='display: none'";
} else {

	$nome = "Novo";
	$titulo = " Dados - Patrimônio";
	$icon = '<i class="fas fa-plus"></i>';
	$button = 'Salvar';
	$display = "style='display: none'";
	$recibo = 'none';
	$reciboBotao = "none";
}

?>
<!-- FECHAR MSN DE CADASTRADO COM SUCESSO -->
<script>


</script>
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

			<div class="row">
				<div class="col-lg-12">
					<div class="alert bg-danger" role="alert" id="msnAlertaDocumento" style="display: <?= $recibo ?>;">
						<em class="fa fa-lg fa-warning">&nbsp;</em> Ainda não foi emitido um RECIBO sobre esse item, clique
						&nbsp;&nbsp;<a href="javascript:" style="color: black;" data-toggle="modal" data-target="#recibo" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
							<i class="fas fa-file-contract fa-2x"></i>
						</a> &nbsp;&nbsp;para gerar o documento<a href="javascript:" class="pull-right" onclick="fecharDoc()"><em class="fa fa-lg fa-close"></em></a>
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


							<div class="col-xs-6">
								<div class="form-group">
									<label>Origem</label>
									<select class="form-control" name="origem" onchange="myFunctionOrigem()" id="listOrigem" required>
										<?php
										if (!empty($patrimonio['id_origem'])) {
											echo '<option value="' . $patrimonio['id_origem'] . '">' . $patrimonio['origem'] . '</option>';
											echo '<option>------------</option>';
											while ($origem = $resultOrigem->fetch_assoc()) {
												echo '<option value="' . $origem['id'] . '">' . $origem['nome'] . '</option>';
											}
										} else {
											echo '<option value="">Selecione...</option>';

											while ($origem = $resultOrigem->fetch_assoc()) {
												echo '<option value="' . $origem['id'] . '">' . $origem['nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							<div id="doador" style="display: <?= empty($patrimonio['cpf_doador']) ? 'none' : 'block'; ?>;">
								<div class="col-xs-12">
									<div class="form-group">
										<label>Nome doador: </label>
										<input class="form-control" name="nomeDoador" maxlength="50" value="<?= !empty($patrimonio['nome_doador']) ? $patrimonio['nome_doador'] : ""  ?>" id="nomeDoador">
									</div>
								</div>
								<div class="col-xs-5">
									<div class="form-group">
										<label>CPF doador: </label>
										<input class="form-control" name="cpfDoador" value="<?= !empty($patrimonio['cpf_doador']) ? $patrimonio['cpf_doador'] : ""  ?>" id="cpfDoador" onkeydown="javascript: fMasc(this, mCPF );" maxlength="14" onblur="ValidarCPF(this)" disabled>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="form-group">
										<label>Termo LGPD e GDPR:</label>
										<div class="checkbox">
											<label style="color: red">
												<input type="checkbox" id="lgpd" onclick="myFuncionTermo()">Sou consciente das minhas responsabilidades com os dados cadastrados, em conformidade com a LGPD e GDPR.<p> <a href="../images/termo-LGPD.pdf" target="_blank"> Termo LGPD </a></p>
											</label>
										</div>
									</div>
								</div>
							</div>
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
									<label>Valor</label>
									<input class="form-control" placeholder="R$ 0.000,00" name="valor" maxlength="10" value="<?= !empty($patrimonio['valor']) ? $patrimonio['valor'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Quantidade</label>
									<input type="number" class="form-control" name="quantidade" value="<?= !empty($patrimonio['quantidade']) ? $patrimonio['quantidade'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-12">
								<div class="form-group">
									<label>Data aquisição</label>
									<input class="form-control" type="date" name="data_compra" maxlength="10" value="<?= !empty($patrimonio['data_aquisicao']) ? $patrimonio['data_aquisicao'] : "" ?>">
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
							<button type="submit" class="btn btn-success pull-right" id="enviar">
								<i class="fas fa-share fa-sm text-white-50"></i>&nbsp;<?= $button ?>
							</button>
						</div>
						<div style="display: <?= $reciboBotao ?>;">
							<a href="javascript:" class="btn btn-warning" data-toggle="modal" data-target="#recibo">
								<i class="fas fa-file-contract fa-sm text-white-50"></i>&nbsp;<?= $buttonRecibo ?>
							</a>
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
												<input type="text" class="form-control" placeholder="Arquivo" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Data" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$queryDocumentosPatrimonios .= " WHERE id_patrimonio = " . $_GET['idPatrimonio'];
										$resultadoDocumentos = $conn->query($queryDocumentosPatrimonios);

										while ($documentos = $resultadoDocumentos->fetch_assoc()) {
											echo '<tr>
														<td>' . $documentos['nome'] . '</td>
														<td>' . date('d/m/Y H:i:s', strtotime($documentos['data_criacao'])) . '</td>
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

		<!-- REGISTROS -->
		<div class="col-lg-6" id="registros">
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
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#registro" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
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
										<?php

										$queryrRegistrosPatrimonios .= ' WHERE CR.id_patrimonio = ' . $_GET['idPatrimonio'];
										$resultadoRegistros = $conn->query($queryrRegistrosPatrimonios);

										while ($registros = $resultadoRegistros->fetch_assoc()) {
											echo '<tr>
														<td>' . $registros['nome'] . '</td>
														<td>' . date('d/m/Y H:m:s', strtotime($registros['data_registro'])) . '</td>
														<td>' . $registros['observacao'] . '</td>
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

	<!-- Modal REGSITROS-->
	<div class="modal fade in" id="registro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Novo Registro - <?= $titulo ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="../back/novoPatrimonio.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>&modo=1" method="post">
						<fieldset>
							<!-- Assunto -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="message">Observação:</label>
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
	</div><!-- FIM MODAL REGISTROS -->

	<!-- MODAL DOCUMENTOS-->
	<div class="modal fade" id="doc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Novo Documentos - <?= $titulo ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="../back/novoPatrimonio.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>&modo=2" method="post" enctype="multipart/form-data">
						<fieldset>
							<div class="col-xs-12">
								<div class="form-group">
									<label>Documento</label>
									<input type="file" class="form-control" name="anexo">
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
	</div><!-- FIM MODAL DOCUMENTOS -->

	<!-- MODAL RECIBO-->
	<div class="modal fade" id="recibo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-file"></i> Recido Doação</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="panel panel-default">
						<div class="panel-body">
							<p>Segue uma lista de todos os itens do doador - <?= $patrimonio['nome_doador'] ?>, portador do CPF nº <?= $patrimonio['cpf_doador'] ?>.</p>
							<p> Peço que escolha quais itens deseja emitir o recibo.</p>
						</div>
					</div>
					<form class="form-horizontal" action="../back/recibo.php?idPatrimonio=<?= $_GET['idPatrimonio'] ?>" method="post" enctype="multipart/form-data">
						<label class="col-md-3">Equipamentos:</label>
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<td>Ação</td>
									<td>Nome / Modelo</td>
									<td>Código</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$queryRecibo = "SELECT * FROM cfa_patrimonio WHERE cpf_doador = '" . $patrimonio['cpf_doador'] . "'";
								$resultRecibo = $conn->query($queryRecibo);

								while ($recibo = $resultRecibo->fetch_assoc()) {
									echo '
										<tr>
											<td><input type="checkbox" name="aquipamento[]" value="'.$recibo['id'].'" class="equip" checked></td>
											<td>' . $recibo['nome'] . '</td>
											<td>' . $recibo['codigo'] . '</td>
										</tr>';
								}

								?>
							</tbody>
						</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">voltar</button>
					<button type="submit" class="btn btn-primary">Emitir recibo</button>
				</div>
				</form>
			</div>
		</div>
	</div><!-- FIM MODAL RECIBO -->

</div><!-- /.panel-->
</div><!-- /.col-->

<!--/. CONTEUDO-->

<!--FOOTER-->
<?php include('footer.php'); ?>
<!--/. FOOTER-->