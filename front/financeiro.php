<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_financeiro'] == 1 ?: header('location: dashboard.php?pagina=1');

include('head.php');
include('header.php');
include('menu.php');

?>
<!--FIM MENU LATERAL-->

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
				<i class="fas fa-file-invoice-dollar"></i> Financeiro
			</li>
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
	<div class="row" id="msnAlertaInfo" style="display: <?= $_GET['msn'] == 1 ? "block" : "none" ?>;">
		<div class="col-lg-12">
			<div class="alert bg-warning" role="alert">
				<em class="fa fa-lg fa-warning">&nbsp;</em> Membro desativado com sucesso! 
				<a href="javascript:" class="pull-right" onclick="fecharInfo()">
					<em class="fa fa-lg fa-close"></em>
				</a>
			</div>
		</div>
	</div>

	<!--CONTEUDO-->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Escolha uma opção</div>
				<div class="panel-body">
					<div class="col-md-12">
						<a href="membros.php?pagina=3&modo=1" type="button" class="btn btn-md btn-primary">
							<i class="fas fa-eye fa-sm text-white-50"></i>&nbsp; Ultimos Lançamentos
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=<?= $mesAtual ?>" type="button" class="btn btn-md btn-success">
							<i class="fas fa-birthday-cake"></i>&nbsp; Aniversáriantes
						</a>
						<a href="membros.php?pagina=3&modo=3" type="button" class="btn btn-md btn-warning">
							<i class="fas fa-chart-line"></i>&nbsp; Relatórios
						</a>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- MODO 1 -->
	<div class="row" style="display: <?= $_GET['modo'] == 1 ? "block" : "none"; ?>">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Todos os Membros</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
										</button>
										<a href="../back/pdf.php?modo=2" class="btn btn-sm btn-danger">
											<i class="fas fa-print"></i> PDF
										</a>
										<a href="../back/excel.php?modo=2" class="btn btn-sm btn-primary">
											<i class="fab fa-windows"></i> Excel
										</a>
										<a href="novoMembro.php?pagina=3" class="btn btn-sm btn-success" style="display: <?= $_SESSION['membro_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Novo Membro
										</a>
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
												<input type="text" class="form-control" placeholder="D. Nascimento" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Telefone" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Faixa etária" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Incargo" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Endereço" disabled>
											</th>
											<th>
												AÇÃO
											</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$resultUsuarios = $conn->query($queryUsuarios);

										while ($usuarios = $resultUsuarios->fetch_assoc()) {

											$idade = date('Y') - date('Y', strtotime($usuarios['data_nascimento']));

											include('../back/faixaEtaria.php');

											echo '<tr>
												<td>' . $usuarios['nome'] . '</td>
												<td>' . $usuarios['email'] . '</td>
												<td><a href="javascript:" title="' . $idade . ' anos">' . $usuarios['data_nascimento'] . '</a></td>
												<td>' . $usuarios['celular'] . '</td>
												<td>' . $etaria . '</td>
												<td>' . $usuarios['cargo'] . '</td>
												<td>' . $usuarios['endereco'] . ', ' . $usuarios['numero'] . ' - ' . $usuarios['cidade'] . ' - ' . $usuarios['estado'] . '</td>
												<td>
													<div class="pull-right action-buttons tabela">
														<a href="novoMembro.php?pagina=3&idMembro=' . $usuarios['id'] . '" class="edit" title="ver mais sobre">
															<em class="fa fa-eye"></em>
														</a>
														<a href="excluirMembro.php?pagina=3&idMembro=' . $usuarios['id'] . '" class="trash" title="Excluir" style="display:';
														
														echo $_SESSION['membro_excluir'] == 1 ? 'inline-block' : 'none';
														
														echo ';
														margin-right: 5px;
														margin-left: 4px;">
															<em class="fa fa-trash"></em>
														</a>
													</div>
												</td>
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
	</div> <!-- FIM MODO 1 -->

	<!-- MODO 2 -->
	<div class="row" style="display: <?= $_GET['modo'] == 2 ? "block" : "none"; ?>">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Aniversários</div>
				<div class="panel-body">
					<div class="col-md-12" style="margin-left: 11%;">
						<a href="membros.php?pagina=3&modo=2&mes=01" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '01' ? "info" : "default" ?>">
							Jan (<?= $janeiro['aniversarios'] ?>);
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=02" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '02' ? "info" : "default" ?>">
							Fev (<?= $fevereiro['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=03" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '03' ? "info" : "default" ?>">
							Mar (<?= $marco['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=04" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '04' ? "info" : "default" ?>">
							Abr (<?= $abril['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=05" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '05' ? "info" : "default" ?>">
							mai (<?= $maio['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=06" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '06' ? "info" : "default" ?>">
							jun (<?= $junho['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=07" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '07' ? "info" : "default" ?>">
							jul (<?= $julho['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=08" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '08' ? "info" : "default" ?>">
							ago (<?= $agosto['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=09" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '09' ? "info" : "default" ?>">
							set (<?= $setembro['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=10" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '10' ? "info" : "default" ?>">
							out (<?= $outubro['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=11" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '11' ? "info" : "default" ?>">
							Nov (<?= $novembro['aniversarios'] ?>)
						</a>
						<a href="membros.php?pagina=3&modo=2&mes=12" type="button" class="btn btn-sm btn-<?= $_GET['mes'] == '12' ? "info" : "default" ?>">
							Dez (<?= $dezembro['aniversarios'] ?>)
						</a>

						<br>
						<br>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
										</button>
										<a href="../back/pdf.php?mes=<?= $_GET['mes'] ?>&modo=2" class="btn btn-sm btn-danger">
											<i class="fas fa-print"></i> PDF
										</a>
										<a href="../back/excel.php?mes=<?= $_GET['mes'] ?>&modo=2" class="btn btn-sm btn-primary">
											<i class="fab fa-windows"></i> Excel
										</a>
									</div>
								</div>

								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Dia" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Idade" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Foto" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Nome" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										
										$resultUsuariosAniversario = $conn->query($queryUsuarios);

										while ($usuariosAni = $resultUsuariosAniversario->fetch_assoc()) {

											$idade = date('Y') - date('Y', strtotime($usuariosAni['data_nascimento']));

											echo '<tr>
											<td>'.$usuariosAni['data_nascimento'].'</td>
											<td>'.$idade.' Anos</td>
											<td>
												<div class="profile-userpic">
													<img src="'.$usuariosAni['foto_perfil'].'" class="img-responsive" style="margin-left: 42%;" alt="">
												</div>
											</td>
											<td>
												<a href="novoMembro.php?pagina=3&idMembro='.$usuariosAni['id'].'" title="ver membro" class="textNome">'.$usuariosAni['nome']." ".$usuariosAni['sobre_nome'].'</a>
											</td>
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
	</div> <!-- FIM MODO 2 -->

	<!-- MODO 3 -->
	<div class="row" style="display: <?= $_GET['modo'] == 3 ? "block" : "none"; ?>">
		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">Relatórios</div>
				<div class="panel-body">
					<div class="col-md-12">

						<ul class="todo-list">
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-1" onclick="cargo()">
									<label for="checkbox-1">Incargos</label>
								</div>

							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-2" onclick="faixa_etaria()">
									<label for="checkbox-2">Faixa etária</label>
								</div>

							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-3" onclick="aniversarios()">
									<label for="checkbox-3">aniversários</label>
								</div>

							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-4" onclick="sexo()">
									<label for="checkbox-4">Gênero</label>
								</div>

							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-5" onclick="estado_civil()">
									<label for="checkbox-5">Estado Cívil</label>
								</div>

							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-9" id="aniversario" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Aniversário</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="main-chart" id="happy" height="200" width="600"></canvas>
					</div>
				</div>
			</div>
		</div>

		<!--/.aniversarios-->
		<div class="col-lg-3" id="faixaEtaria" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Faixa etária</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="chart" id="etaria"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!--/.faixa etaria-->

		<div class="col-lg-3" id="cargo" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">incargos</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="chart" id="cargos"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!--/.cargo-->

		<div class="col-lg-3" id="sexo" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Gênero</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="chart" id="sexos"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!--/.sexo-->

		<div class="col-lg-3" id="estado_civil" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Estado Cívil</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<canvas class="chart" id="civil"></canvas>
					</div>
				</div>
			</div>
		</div>
		<!--/.estado civil-->

	</div> <!-- FIM MODO 3 -->

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->

	<!-- DADOS DO CHART -->
	<?php include('../back/chartData.php'); ?>
	<!--/. DADOS DO CHART-->
	<script>
		var chart1 = document.getElementById("etaria").getContext("2d");
		window.myFaixaEtaria = new Chart(chart1).Pie(etarias, {
			responsive: true,
			segmentShowStroke: false
		});
		var chart2 = document.getElementById("happy").getContext("2d");
		window.myHappy = new Chart(chart2).Bar(happydata, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
		});
		var chart3 = document.getElementById("cargos").getContext("2d");
		window.myCargo = new Chart(chart3).Doughnut(cargos, {
			responsive: true,
			segmentShowStroke: false
		});
		var chart4 = document.getElementById("sexos").getContext("2d");
		window.mySexo = new Chart(chart4).Pie(sexos, {
			responsive: true,
			segmentShowStroke: false
		});
		var chart5 = document.getElementById("civil").getContext("2d");
		window.myCivil = new Chart(chart5).Doughnut(civil, {
			responsive: true,
			segmentShowStroke: false
		});
	</script>

	<script>
		function fecharInfo() {
			let msn = document.getElementById("msnAlertaInfo").style.display;

			if (msn == "block") {
				document.getElementById("msnAlertaInfo").style.display = "none";
			}
		}
	</script>