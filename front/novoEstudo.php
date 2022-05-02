<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_estudos'] == 1 ?: header('location: dashboard.php?pagina=1');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


include('head.php');
include('header.php');
include('menu.php');
include('../back/query.php');
include('../bd/conexao.php');


if (!empty($_GET['idEstudo'])) {
	//Editar

	$queryEstudos .= " WHERE CFAE.id = " . $_GET['idEstudo'];
	$resul = $conn->query($queryEstudos);
	$estudos = $resul->fetch_assoc();

	$icon = '<i class="fas fa-book-open"></i>';
	$nome = $estudos['nome'];
	$titulo = 'Dados - ' . $estudos['nome'];
	$button = 'Editar';
	$display = 'style= "display: block;"';
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
			<li><a href="estudos.php?pagina=7"><i class="fas fa-book"></i> Estudos</li></a>
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
						<em class="fa fa-lg fa-warning">&nbsp;</em> Criado com sucesso!<a href="javascript:" class="pull-right" onclick="criado();"><em class="fa fa-lg fa-close"></em></a>
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
					<i class="fas fa-book-open"></i> <?= $titulo ?>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="../back/novoEstudo.php?idEstudo=<?= $_GET['idEstudo'] ?>" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label class="col-md-3 control-label">Nome Estudo:</label>
								<div class="col-md-9">
									<input class="form-control" name="nomeEstudo" maxlength="45" value="<?= !empty($estudos['nome']) ? $estudos['nome'] : ""  ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Professor:</label>
								<div class="col-md-9">
									<select class="form-control" name="lecionador">
										<?php
										if (!empty($estudos['id_usuario'])) {
											echo '<option value="' . $estudos['id_usuario'] . '">' . $estudos['lecionador'] . " " . $estudos['sobre_nome'] . '</option>';
											echo '<option>------------</option>';

											$resultUsuarios = $conn->query($queryUsuarios);
											while ($usuarios = $resultUsuarios->fetch_assoc()) {
												echo '<option value="' . $usuarios['id'] . '">' . $usuarios['nome'] . " " . $usuarios['sobre_nome'] . '</option>';
											}
										} else {
											echo '<option>Selecione...</option>';

											$resultUsuarios = $conn->query($queryUsuarios);
											while ($usuarios = $resultUsuarios->fetch_assoc()) {
												echo '<option value="' . $usuarios['id'] . '">' . $usuarios['nome'] . " " . $usuarios['sobre_nome'] . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Observações:</label>
								<div class="col-md-9">
									<textarea class="form-control" id="message" name="observacao" placeholder="..." rows="10"><?= !empty($estudos['observacao']) ? $estudos['observacao'] : ""  ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Apostila:</label>
								<div class="col-md-9">
									<input type="file" name="apostila">
								</div>
							</div>
							<div class="form-group" style="display: <?= $_SESSION['estudos_adicionar'] == 1 ? "block" : "none" ?>;">
								<div class="col-md-12 widget-right">
									<button type="reset" class="btn btn-info">
										<i class="fas fa-broom fa-sm text-white-50"></i>&nbsp;Desfazer
									</button>
									<button type="submit" class="btn btn-success pull-right" id="enviar">
										<i class="fas fa-share fa-sm text-white-50"></i>&nbsp;<?= $button ?>
									</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row" <?= $display ?> id="apostilas">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					<i class="fas fa-book"></i> Apostilas
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Nome" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Arquivo" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$queryApostilas .= " WHERE id_curso = " . $_GET['idEstudo'];
										$resultApostilas = $conn->query($queryApostilas);

										while ($apostilas = $resultApostilas->fetch_assoc()) {
											echo '
												<tr>
													<td>' . $apostilas['nome'] . '</td>
													<td><a href="' . $apostilas['caminho'] . '" target="_blank"><i class="fas fa-file fa-2x"></i></a></td>
													
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

	<div class="row" <?= $display ?> id="alunos">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading textNome">
					<i class="fas fa-graduation-cap"></i> Estudantes
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<a href="../back/pdf.php?modo=5" class="btn btn-sm btn-danger">
											<i class="fas fa-print"></i> PDF
										</a>
										<a href="../back/excel.php?modo=4" class="btn btn-sm btn-primary">
											<i class="fab fa-windows"></i> Excel
										</a>
										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#aluno" style="display: <?= $_SESSION['estudos_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Novo aluno
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
												<input type="text" class="form-control" placeholder="E-mail" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Data Inicio" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Data Fim" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Status" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$queryEstudantes .= " WHERE CES.id_estudo = " . $_GET['idEstudo'];
										$resultEstudantes = $conn->query($queryEstudantes);

										while ($estudantes = $resultEstudantes->fetch_assoc()) {
											echo '
												<tr>
													<td><a href="novoMembro.php?pagina=3&idMembro=' . $estudantes['id_usuario'] . '">' . $estudantes['estudante'] . " " . $estudantes['sobre_nome'] . '</a></td>
													<td>' . $estudantes['email'] . '</td>
													<td>' . date('d/m/Y', strtotime($estudantes['data_inicio'])) . '</td>
													<td>' . date('d/m/Y', strtotime($estudantes['data_fim'])) . '</td>
													<td style="background:';
											echo $estudantes['status'] == 'Concluido' ? '#80f580' : '#f9dfaf';
											echo '">' . $estudantes['status'] . '</td>
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

</div>
<!-- ESTUDANTES-->
<div class="modal fade" id="aluno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="width: 150%; margin-left: -170px">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Novo Aluno</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="../back/novoAluno.php?idEstudo=<?= $_GET['idEstudo'] ?>" method="post" enctype="multipart/form-data">
					<table class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>Seleção</th>
								<th>Nome</th>
								<th>E-mail</th>
								<th>Data Inicio</th>
								<th>Data Fim</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$queryUsuarios .= " WHERE U.deletar = 0";
							$resultUsuario = $conn->query($queryUsuarios);

							while ($user = $resultUsuario->fetch_assoc()) {
								echo '<tr>
										<td><input type="checkbox" onclick="requerir' . $user['nome'] . '()" name="aluno[]" value="' . $user['id'] . '"></td>
										<td><label>' . $user['nome'] . ' ' . $user['sobre_nome'] . '</label></td>
										<td>' . $user['email'] . '</td>
										<td><input type="date" name="data_inicio' . $user['id'] . '" id="dataInicio' . $user['nome'] . '"></td>
										<td><input type="date" name="data_fim' . $user['id'] . '" id="dataFim' . $user['nome'] . '"></td>
										<td>
										<select name="status' . $user['id'] . '" id="status' . $user['nome'] . '">
											<option value="">Selecione...</option>
											<option value="Cursando">Cursando</option>
											<option value="Concluido">Concluido</option>
										</select>										
										</td>
									</tr>';

								echo '
									<script>
										function requerir' . $user['nome'] . '() {
											var x = document.getElementById("dataInicio' . $user['nome'] . '").required;
											var y = document.getElementById("dataFim' . $user['nome'] . '").required;
											var k = document.getElementById("status' . $user['nome'] . '").required;

											if(x == false){document.getElementById("dataInicio' . $user['nome'] . '").required = true;}
											if(y == false){document.getElementById("dataFim' . $user['nome'] . '").required = true;}
											if(k == false){document.getElementById("status' . $user['nome'] . '").required = true;}
										}
									</script>
									
									';
							}
							?>
						</tbody>
					</table>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!-- FIM MODAL DOCUMENTOS -->
<!-- FECHAR MSN DE CADASTRADO COM SUCESSO -->
<script>
	function criado() {
		document.getElementById("msnAlertaSuccess").style.display = "none";
	}

	function fecharInfo() {
		let msn = document.getElementById("msnAlertaInfo").style.display;

		if (msn == "block") {
			document.getElementById("msnAlertaInfo").style.display = "none";
		}
	}

	function fecharDoc() {
		let msn = document.getElementById("msnAlertaDocumento").style.display;

		if (msn == "block") {
			document.getElementById("msnAlertaDocumento").style.display = "none";
		}
	}
</script>
</div><!-- /.col-->

<!--FOOTER-->
<?php
require_once('footer.php');
?>
<!--/. FOOTER-->