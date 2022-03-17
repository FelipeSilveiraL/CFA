<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_celula'] == 1 ?: header('location: dashboard.php?pagina=1');

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
				<i class="fas fa-project-diagram"></i> Células
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
				<em class="fa fa-lg fa-warning">&nbsp;</em> Célula excluida com sucesso! :-(
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
						<a href="celula.php?pagina=4&modo=1" type="button" class="btn btn-md btn-primary">
							<i class="fas fa-eye fa-sm text-white-50"></i>&nbsp; Ver Todas
						</a>
						<a href="celula.php?pagina=4&modo=3" type="button" class="btn btn-md btn-warning">
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
				<div class="panel-heading">Toda as Células</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
										</button>
										<a href="../back/pdf.php?modo=1" class="btn btn-sm btn-danger">
											<i class="fas fa-print"></i> PDF
										</a>
										<a href="../back/excel.php?modo=1" class="btn btn-sm btn-primary">
											<i class="fab fa-windows"></i> Excel
										</a>
										<a href="novaCelula.php?pagina=4" class="btn btn-sm btn-success" style="display: <?= $_SESSION['celula_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Nova Célula
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
												<input type="text" class="form-control" placeholder="Dia Semana" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Horário" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Endereco" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Liderança1" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Liderança2" disabled>
											</th>
											<th>
												AÇÃO
											</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$resultCelulas = $conn->query($queryCelulas);

										while ($celula = $resultCelulas->fetch_assoc()) {

											$colspan = 3;

											echo '<tr>
												<td>' . $celula['nome'] . '</td>
												<td>' . $celula['dia_semana'] . '</td>
												<td>' . $celula['horario'] . '</td>
												<td>' . $celula['endereco'] . ', ' . $celula['numero'] . ' - ' . $celula['cidade'] . ' - ' . $celula['estado'] . '</td>';

											$query = 'SELECT CU.nome, CU.sobre_nome
											FROM cfa_celula_lideres CL
											LEFT JOIN cfa_celulas CC ON (CL.id_celula = CC.id) 
											LEFT JOIN cfa_usuarios CU ON (CL.id_usuario = CU.id)
											WHERE CL.id_celula = ' . $celula['id'] . ' Limit 2';

											$resultado = $conn->query($query);
											while ($lideres = $resultado->fetch_assoc()) {

												if (!empty($lideres)) {
													echo '<td>';
													echo $lideres['nome']." ".$lideres['sobre_nome'];
													echo '</td>';
												}
												$colspan--;
											}

											echo '
												<td colspan="' . $colspan . '">
													<div class="pull-right action-buttons tabela">
														<a href="novaCelula.php?pagina=4&idCelula=' . $celula['id'] . '" class="edit" title="Ver mais sobre">
															<em class="fa fa-eye"></em>
														</a>
														<a href="excluircelula.php?pagina=4&idCelula=' . $celula['id'] . '" class="trash" title="Excluir" style="display:';

											echo $_SESSION['celula_excluir'] == 1 ? 'inline-block' : 'none';

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

	<!-- MODO 3 -->
	<div class="row" style="display: <?= $_GET['modo'] == 3 ? "block" : "none"; ?>">
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">Relatórios</div>
				<div class="panel-body">
					<div class="col-md-12">

						<ul class="todo-list">
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-1" onclick="semCelula()">
									<label for="checkbox-1">Membros - <span class="text-sn">Sem Célula </span></label>
								</div>

							</li><!-- 
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-2" onclick="ausentes()">
									<label for="checkbox-2">Membros - <span class="text-sn">Ausentes</span></label>
								</div>

							</li> -->
							<li class="todo-list-item">
								<div class="checkbox">
									<input type="checkbox" id="checkbox-3" onclick="ultimaReuniao()">
									<label for="checkbox-3">Células - <span class="text-sn">Ultima Reunião</span></label>
								</div>

							</li>
						</ul>

					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-4" id="semCelulas" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Membros - <span class="text-sn">Sem Célula</span></div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
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
												<input type="text" class="form-control" placeholder="Foto" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$queryUsuarios .= " WHERE U.celula = 0";

										$resultSemCelula = $conn->query($queryUsuarios);

										while ($semCelula = $resultSemCelula->fetch_assoc()) {

											$colspan = 3;

											echo '<tr>
													<td><a href="novoMembro.php?pagina=3&idMembro=' . $semCelula['id'] . '">' . $semCelula['nome'] ." ". $semCelula['sobre_nome'] . '</a></td>
													<td>
														<div class="profile-userpic">
															<img src="' . $semCelula['foto_perfil'] . '" class="img-responsive" style="margin-left: 42%;" alt="">
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

		<!--/.aniversarios-->
		<!-- <div class="col-lg-6" id="ausente" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Membros - Ausentes</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
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
												<input type="text" class="form-control" placeholder="Foto" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>oi</td>
											<td>oi</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!--/.faixa etaria-->

		<div class="col-lg-4" id="ultimaReuniaos" style="display: block">
			<div class="panel panel-default">
				<div class="panel-heading">Células - <span class="text-sn">Ultima Reunião</span></div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
										</button>
									</div>
								</div>
								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Célula" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Data Reunião" disabled>
											</th>
										</tr>
									</thead>
									<tbody>
											<?php
											$resultUltima = $conn->query($queryUltimaReuniao);

											
											while($ultimaReuniao = $resultUltima->fetch_assoc()){
												
												$dataReuniao = date('d/m/Y', strtotime($ultimaReuniao['dataReuniao']));

												echo '
												<tr>
													<td><a href="novaCelula.php?pagina=4&idCelula='.$ultimaReuniao['id_celula'].'">'.$ultimaReuniao['nome'].'</a></td>
													<td>'.$dataReuniao.'</td>
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
		<!--/.cargo-->

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
