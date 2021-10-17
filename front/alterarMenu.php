<!DOCTYPE html>
<html>
<?php
include('head.php');
include('header.php');
include('../back/menu.php');
/* PERMISSÃO */
$_SESSION['tela_configuracao'] == 1 ?: header('location: dashboard.php?pagina=1');
include('menu.php');

/* LISTA DADOS */
$queryListaDados = "SELECT * FROM " . $menuBanco . "";
$result = $conn->query($queryListaDados);
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
			<li>
				<a href="menuLista.php?pagina=2">
					<i class="fas fa-tools"></i> Menu Lista
				</a>
			</li>
			<li class="active"><?= $icone . " " . $nomeMenu ?></li>
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

	<!-- MODO 1 -->
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><?= $icone . " " . $nomeMenu ?></li>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="panel panel-primary filterable col-md-13">
								<div class="panel-heading">
									<div class="pull-right">
										<button type="button" class="btn btn-sm btn-info btn-filter">
											<i class="fas fa-filter"></i> Filtro
										</button>
										<a href="javascript:" class="btn btn-sm btn-success" data-toggle="modal" data-target="#novoMenu">
											<i class="fas fa-plus"></i> Novo <?= $nomeMenu ?>
										</a>
									</div>
								</div>
								<table class="table table-bordered">
									<thead>
										<tr class="filters">
											<th>
												<input type="text" class="form-control" placeholder="Nome" disabled>
											</th>
											<th>
												Ação
											</th>
										</tr>
									</thead>
									<tbody>

										<?php

										while ($listaMenus = $result->fetch_assoc()) {

											echo '
											<tr>
												<td>' . $listaMenus['nome'] . '</td>
												<td>
													<div class="pull-right action-buttons tabela">
														<a href="#" class="edit" title="Editar" data-toggle="modal" data-target="#modal' . $listaMenus['id'] . '">
															<em class="fa fa-pen"></em>
														</a>
														<a href="#" class="trash" title="Excluir" data-toggle="modal" data-target="#modalEx' . $listaMenus['id'] . '">
															<em class="fa fa-trash"></em>
														</a>
													</div>
												</td>
											</tr>

											<!-- MODAL EDITAR -->
											<div class="modal fade" id="modal' . $listaMenus['id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Editar ' . $listaMenus['nome'] . '</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														
															<div class="panel panel-default">
																<div class="panel-body">
																	<form class="form-horizontal" action="../back/alterarMenu.php?opcao=2&id=' . $listaMenus['id'] . '&db='.$menuBanco.'&idMenu='.$_GET['idMenu'].'" method="post">
																		<fieldset>
																			<!-- Name input-->
																			<div class="form-group">
																				<label class="col-md-3 control-label" for="name">Nome</label>
																				<div class="col-md-9">
																					<input name="menu" type="text" value="' . $listaMenus['nome'] . '" class="form-control">
																				</div>
																			</div>
																			<br />															<br />				
																			<!-- Form actions -->
																			<div class="form-group">
																				<div class="col-md-12 widget-right">
																					<button type="submit" class="btn btn-info btn-md pull-right">Editar</button>
																				</div>
																			</div>
																		</fieldset>
																	</form>
																</div>
															</div>
														</div>
													</div>
												</div>
												</div>
												
												<!-- MODAL EXCLUIR -->
												<div class="modal fade" id="modalEx' . $listaMenus['id'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Excluir ' . $listaMenus['nome'] . '? </h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
															<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															Deseja realmente excluir a opção ' . $listaMenus['nome'] . ', após excluir não tem o que fazer!
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-info" data-dismiss="modal">Não</button>
															<a href="../back/alterarMenu.php?opcao=3&id=' . $listaMenus['id'] . '&db='.$menuBanco.'&idMenu='.$_GET['idMenu'].'" class="btn btn-danger">Sim</a>
														</div>
														</div>
													</div>
												</div>';
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

	<!-- Modal -->
	<div class="modal fade" id="novoMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Cadastrar um novo <?= $nomeMenu ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="../back/alterarMenu.php?opcao=1&db=<?= $menuBanco ?>&idMenu=<?= $_GET['idMenu'] ?>" method="post">
						<fieldset>
							<!-- Name input-->
							<div class="form-group">
								<label class="col-md-3 control-label" for="name">Nome</label>
								<div class="col-md-9">
									<input name="menu" type="text" class="form-control">
								</div>
							</div>
							<br /> <br />
							<!-- Form actions -->
							<div class="form-group">
								<div class="col-md-12 widget-right">
									<button type="submit" class="btn btn-success btn-md pull-right">Salvar</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--/. CONTEUDO-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->


</html>