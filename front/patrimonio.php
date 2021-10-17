<!--HEAD-->
<?php include('head.php');
/* <!--FIM HEAD--> */

/* <!--HEADER--> */
include('header.php');
/* <!--FIM HEADER--> */

/* <!--PERMISSÃO--> */
$_SESSION['tela_patrimonio'] == 1 ?: header('location: dashboard.php?pagina=1');

/* <!--MENU LATERAL--> */
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
				<i class="fas fa-hotel"></i> Patrimônio
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
				<em class="fa fa-lg fa-warning">&nbsp;</em> Patrimônio excluida com sucesso!
				<a href="javascript:" class="pull-right" onclick="fecharInfo()">
					<em class="fa fa-lg fa-close"></em>
				</a>
			</div>
		</div>
	</div>

	<!-- MODO 1 -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Patrimônios</div>
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
										<a href="novoPatrimonio.php?pagina=5" class="btn btn-sm btn-success" style="display: <?= $_SESSION['patrimonio_adicionar'] == 1 ? "inline-block" : "none" ?>;">
											<i class="fas fa-plus"></i> Patrimônio
										</a>
									</div>
								</div>
								<table class="table table-bordered table-hover table-responsive">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="ID" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Nome / Modelo" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Código" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Local" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Situação" disabled>
											</th>
											<th>
												<input type="text" class="form-control" placeholder="Conservação" disabled>
											</th>
											<th>
												AÇÃO
											</th>
										</tr>
									</thead>
									<tbody>
										<?php

										$resultPatrimonio = $conn->query($queryPatrimonio);

										while ($patrimonio = $resultPatrimonio->fetch_assoc()) {

											echo '<tr>
												<td>' . $patrimonio['id'] . '</td>
												<td>' . $patrimonio['nome'] . '</td>
												<td>' . $patrimonio['codigo'] . '</td>
												<td>' . $patrimonio['local'] . '</td>
												<td>' . $patrimonio['situacao'] . '</td>
												<td>' . $patrimonio['conservacao'] . '</td>
												<td>
													<div class="pull-right action-buttons tabela">
														<a href="novoPatrimonio.php?pagina=5&idPatrimonio=' . $patrimonio['id'] . '" class="edit" title="Ver mais sobre">
															<em class="fa fa-eye"></em>
														</a>
														<a href="excluirPatrimonio.php?pagina=5&idPatrimonio=' . $patrimonio['id'] . '" class="trash" title="Excluir" style="display:';

											echo $_SESSION['patrimonio_excluir'] == 1 ? 'inline-block' : 'none';

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


	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->

	<script>
		function fecharInfo() {
			let msn = document.getElementById("msnAlertaInfo").style.display;

			if (msn == "block") {
				document.getElementById("msnAlertaInfo").style.display = "none";
			}
		}
	</script>