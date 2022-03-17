<?php
session_start();

if ($_SESSION['email'] == NULL) {
	header('Location: ../adm.php?erro=1');
}

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

include('head.php');
include('header.php');
/* PERMISSÃO */
$_SESSION['tela_membros'] == 1 ?: header('location: dashboard.php?pagina=1');

include('menu.php');
include('../back/query.php');


if (!empty($_GET['idCelula'])) {
	//coletando da célula
	$queryCelulas .= " AND id = " . $_GET['idCelula'];
	$resultMembro = $conn->query($queryCelulas);
	$membro = $resultMembro->fetch_assoc();
	$titulo = $membro['nome'];
	$icon = '<i class="fas fa-house-user"></i>';
	$button = 'Editar';

	//membros por celula
	$queryUsuarios .= " WHERE CC.id = " . $_GET['idCelula'];

	//count membros
	$countCelula .= " WHERE celula = " . $_GET['idCelula'];
	$resultCaount = $conn->query($countCelula);
	$count = $resultCaount->fetch_assoc();

	//lideres por celula
	$queryLIderesCelulas .= " WHERE CLC.id_celula = " . $_GET['idCelula'];


	//count lideres
	$countLideres .= " WHERE id_celula = " . $_GET['idCelula'];
	$resultCountLideres = $conn->query($countLideres);
	$countLidere = $resultCountLideres->fetch_assoc();
} else {

	$titulo = "Nova Célula";
	$icon = '<i class="fas fa-house-user"></i>';
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
			<li><a href="celula.php?pagina=4&modo=1"><i class="fas fa-project-diagram"></i> Células</li></a>
			<li class="active"><?= $icon ?> <?= $titulo ?></li>
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
					<i class="fas fa-house-user"></i> Dados da Célula
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<form role="form" method="POST" action="../back/novaCelula.php?idCelula=<?= $_GET['idCelula'] ?>" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Nome</label>
									<input class="form-control" name="nome" maxlength="45" value="<?= !empty($membro['nome']) ? $membro['nome'] : ""  ?>" required>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label>Data da Inalguração</label>
									<input type="text" class="form-control" name="data_abertura" maxlength="10" placeholder="xx/xx/xxxx" value="<?= !empty($membro['data_abertura']) ? $membro['data_abertura'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-6">
								<div class="form-group">
									<label>Dia Semana (Reunião)</label>
									<select class="form-control" name="dia_semana">
										<?php
										if (!empty($membro['dia_semana'])) {
											echo '<option value="' . $membro['dia_semana'] . '">' . $membro['dia_semana'] . '</option>';
											echo '<option>------------</option>';
										} else {
											echo '<option>Selecione...</option>';
											echo '<option>------------</option>';
										}
										?>
										<option value="Segunda-feira">Segunda-feira</option>
										<option value="Terça-feira">Terça-feira</option>
										<option value="Quarta-feira">Quarta-feira</option>
										<option value="Quinta-feira">Quinta-feira</option>
										<option value="Sexta-feira">Sexta-feira</option>
										<option value="Sábado">Sábado</option>
										<option value="Domingo">Domingo</option>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Horario</label>
									<input type="text" class="form-control" placeholder="xx:xx" name="horario" maxlength="5" value="<?= !empty($membro['horario']) ? $membro['horario'] : ""  ?>">
								</div>
							</div>

							<div class="col-xs-8">
								<div class="form-group">
									<label>Endereço</label>
									<input class="form-control" name="endereco" maxlength="100" value="<?= !empty($membro['endereco']) ? $membro['endereco'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-4">
								<div class="form-group">
									<label>Número</label>
									<input class="form-control" name="numero" maxlength="10" value="<?= !empty($membro['numero']) ? $membro['numero'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label>Bairro</label>
									<input class="form-control" name="bairro" maxlength="50" value="<?= !empty($membro['bairro']) ? $membro['bairro'] : ""  ?>">
								</div>
							</div>
					</div>
					<div class="col-md-6">
						<div class="col-xs-12">
							<div class="form-group">
								<label>CEP</label>
								<input class="form-control" name="cep" maxlength="10" value="<?= !empty($membro['cep']) ? $membro['cep'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>País</label>
								<input type="text" class="form-control" name="pais" maxlength="10" value="<?= !empty($membro['pais']) ? $membro['pais'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>Estado</label>
								<input type="text" class="form-control" name="estado" maxlength="10" value="<?= !empty($membro['estado']) ? $membro['estado'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-12">
							<div class="form-group">
								<label>Cidade</label>
								<input type="text" class="form-control" name="cidade" maxlength="20" value="<?= !empty($membro['cidade']) ? $membro['cidade'] : ""  ?>">
							</div>
						</div>
						<div style="display: <?= $_SESSION['celula_editar'] == 1 ? "block" : "none" ?>;">
							<div class="col-xs-12">
								<div class="form-group">
									<label>Termo LGPD e GDPR</label>
									<div class="checkbox">
										<label style="color: red">
											<input type="checkbox" id="lgpd" onclick="termo()">Sou consciente das minhas responsabilidades com os dados cadastrados, em conformidade com a LGPD e GDPR.<p> <a href="../images/termo-LGPD.pdf" target="_blank"> Termo LGPD </a></p>
										</label>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-success" id="enviar" disabled>
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
				<div class="panel-heading textNome" id="lider">
					Lideres (<?= $countLidere['quantidade'] ?>)
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<ul class="todo-list">
						<?php
						$resultlideres = $conn->query($queryLIderesCelulas);

						while ($listalideres = $resultlideres->fetch_assoc()) {
							echo '<li class="todo-list-item">
							<div class="checkbox textNome">
								<a href="novoMembro.php?pagina=3&idMembro=' . $listalideres['id'] . '">
									<label for="checkbox-1">' . $listalideres['nome'] . '</label>
								</a>
							</div>
							<div class="pull-right action-buttons"  style="display:';
							echo  $_SESSION['celula_excluir_lider'] == 1 ? "block" : "none";
							echo '">
								<a href="../back/desvincular.php?idCelula=' . $_GET['idCelula'] . '&modo=1&idMembro=' . $listalideres['id'] . '" class="trash" title="Excluir">
									<em class="fa fa-trash"></em>
								</a>
							</div>
						</li>';
						}
						?>
					</ul>
					<br />
					<div style="display: <?= $_SESSION['celula_incluir_lider'] == 1 ? "block" : "none" ?>;">
						<form action="../back/vincular.php?modo=1&idCelula=<?= $_GET['idCelula'] ?>" class="" method="POST">
							<div class="panel-footer">
								<div class="input-group">
									<select class="form-control largo textNome" name="lider">
										<option>Selecione...</option>
										<?php
										$query = "SELECT id, nome FROM cfa_usuarios WHERE deletar = 0";

										$resultadoTodos = $conn->query($query);

										while ($todoMembros = $resultadoTodos->fetch_assoc()) {
											echo '<option value="' . $todoMembros['id'] . '">' . $todoMembros['nome'] . '</option>';
										}
										?>
									</select>

									<span class="input-group-btn">
										<button type="submit" class="btn btn-sm btn-primary" id="btn-todo">
											<i class="fas fa-plus"></i> Vicular lider
										</button>
									</span>

								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="panel panel-default" id="membro">
				<div class="panel-heading textNome">
					Membros (<?= $count['quantidade'] ?>)
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<ul class="todo-list">
						<?php
						$resultmembros = $conn->query($queryUsuarios);

						while ($listaMembros = $resultmembros->fetch_assoc()) {
							echo '<li class="todo-list-item">
							<div class="checkbox textNome">
								<a href="novoMembro.php?pagina=3&idMembro=' . $listaMembros['id'] . '">
									<label for="checkbox-1">' . $listaMembros['nome'] . '</label>
								</a>
							</div>
							<div class="pull-right action-buttons" style="display:';
							echo  $_SESSION['celula_excluir_membro'] == 1 ? "block" : "none";
							echo '">
								<a href="../back/desvincular.php?idCelula=' . $_GET['idCelula'] . '&modo=2&idMembro=' . $listaMembros['id'] . '" class="trash" title="Excluir">
									<em class="fa fa-trash"></em>
								</a>
							</div>
						</li>';
						}
						?>
					</ul>
					<br />
					<div style="display: <?= $_SESSION['celula_incluir_membro'] == 1 ? "block" : "none" ?>;">
						<form action="../back/vincular.php?modo=2&idCelula=<?= $_GET['idCelula'] ?>" class="" method="POST">
							<div class="panel-footer">
								<div class="input-group">
									<select class="form-control largo textNome" name="membro">
										<option>Selecione...</option>
										<?php
										$query = "SELECT id, nome FROM cfa_usuarios WHERE deletar = 0";

										$resultadoTodos = $conn->query($query);

										while ($todoMembros = $resultadoTodos->fetch_assoc()) {
											echo '<option value="' . $todoMembros['id'] . '">' . $todoMembros['nome'] . '</option>';
										}
										?>
									</select>

									<span class="input-group-btn">
										<button type="submit" class="btn btn-sm btn-primary" id="btn-todo">
											<i class="fas fa-plus"></i> Vincular Membro
										</button>
									</span>

								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
	if (!empty($_GET['idCelula'])) {
		include('novaReuniao.php');
	}
	?>
	
</div> <!-- FIM CHART REUNIÔES -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> Nova reunião - <?= $titulo ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="../back/reuniao.php?idCelula=<?= $_GET['idCelula'] ?>" method="post">
					<fieldset>
						<!-- Data-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="name">Data:</label>
							<div class="col-md-5">
								<input id="name" name="date" type="date" placeholder="xx/xx/xxxx" class="form-control">
							</div>
						</div>

						<!-- Ofertas-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="email">Ofertas:</label>
							<div class="col-md-3">
								<input id="email" name="oferta" type="text" class="form-control" placeholder="R$" maxlength="10">
							</div>
						</div>
						<br />

						<!-- Participantes-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="email">Membros:</label>
							<div class="col-md-9">
								<ul class="todo-list">

									<?php

									$resultadodosMembros = $conn->query($queryUsuarios);

									while ($participantes = $resultadodosMembros->fetch_assoc()) {
										echo '<li class="todo-list-item noPadding">
													<div class="checkbox">
														<input name="participante[]" type="checkbox" value="' . $participantes['id'] . '" id="checkbox-' . $participantes['id'] . '">
														<label for="checkbox-' . $participantes['id'] . '">' . $participantes['nome'] . '</label>
													</div>
												</li>';
									}

									?>
								</ul>
							</div>
						</div>
						<br />

						<!-- Visitantes-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="email">Visitantes:</label>
							<div class="col-md-9">
								<table id="myTable" class="table table-borderless" style="margin-left: -11px;">
									<tbody>
										<tr>
											<td class="col-sm-9" style="border-top: none;">
												<input type="text" name="nomeVisitante0" class="form-control" placeholder="Nome visitante" />
											</td>
											<td class="col-sm-2" style="border-top: none;">
												<a class="deleteRow"></a>

											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="1" style="border-top: none;">
												<input style=" width: 50%; margin-left: 24%" type="button" class="btn btn-sm btn-block btn-success" id="addrow" value="Novo Visitante" />
											</td>
										</tr>
										<tr>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<br />

						<!-- Assunto -->
						<div class="form-group">
							<label class="col-md-3 control-label" for="message">Assunto:</label>
							<div class="col-md-9">
								<textarea class="form-control" id="message" name="assunto" placeholder="..." rows="5" maxlength="255"></textarea>
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
<!-- DADOS DO CHART -->
<?php include('../back/chartData.php'); ?>
<!--/. DADOS DO CHART-->
<script>
	window.onload = function() {
		var chart1 = document.getElementById("line-chart").getContext("2d");
		window.myLine = new Chart(chart1).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
		});

	};
</script>

<!-- VISUALIZAR IMAGEM ANTES DE SALVAR NO BANCO -->
<script>
	function mostraImagem(img) {
		if (img.files && img.files[0]) {
			var reader = new FileReader();
			var imagem = document.getElementById("imgImage");
			reader.onload = function(e) {
				imagem.style.height = '140px';
				imagem.style.width = '140px';
				imagem.src = e.target.result;
			};

			reader.readAsDataURL(img.files[0]);
		}
	}
</script>

<!-- VER SENHA -->
<script>
	function ver() {
		let input = document.querySelector('#btn-input');

		if (input.getAttribute('type') == 'password') {
			input.setAttribute('type', 'text');
		} else {
			input.setAttribute('type', 'password');
		}
	}
</script>

<!-- VALIDACAO TERMO -->
<script>
	function termo() {
		let lgpd = document.getElementById('lgpd');

		if (lgpd.checked) {
			document.getElementById("enviar").disabled = false;
		} else {
			document.getElementById("enviar").disabled = true;
		}
	}
</script>

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

<!--FOOTER-->
<?php include('footer.php'); ?>
<!--/. FOOTER-->