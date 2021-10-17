<?php
include('head.php');
include('header.php');
/* PERMISSÃO */

if ($_GET['idMembro'] != $_SESSION['id_usuario']) {
	$_SESSION['tela_membros'] == 1 ?: header('location: dashboard.php?pagina=1');
}

include('menu.php');
include('../back/query.php');

if (!empty($_GET['idMembro'])) {
	//coletando dados do membro
	$queryUsuarios .= " WHERE U.id = " . $_GET['idMembro'];
	$resultMembro = $conn->query($queryUsuarios);
	$membro = $resultMembro->fetch_assoc();

	$titulo = $membro['nome'];
	$icon = '<i class="fas fa-user"></i>';
}

?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="dashboard.php?pagina=1"><i class="fas fa-home"></i> Home</a></li>
			<li><a href="membros.php?pagina=3&modo=1"><i class="fas fa-users"></i> Membros</li></a>
			<li><a href="novoMembro.php?pagina=3&idMembro=<?= $_GET['idMembro'] ?>"><?= $icon ?> <?= $titulo ?></li></a>
			<li class="active"><i class="fas fa-users-cog"></i> Configuração</li>
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
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					Permissões - Menus
				</div>
				<div class="panel-body">
					<form action="../back/alterandoPermissao.php?idMembro=<?= $_GET['idMembro'] ?>" method="post" class="form-horizontal">
						<ul class="todo-list">

							<?php
							$queryPermissao .= " WHERE id_usuario = " . $_GET['idMembro'] . "";
							$resultPermissao = $conn->query($queryPermissao);

							if ($permissao = $resultPermissao->fetch_assoc()) {

								//menu configuração

								echo '<li class="todo-list-item">
											<div class="checkbox">
												<input name="tela_configuracoes" value="1" type="checkbox" id="checkboxMenu-1"';

								if ($permissao['tela_configuracoes'] == 1) {
									echo 'checked';
								}
								echo '>
												<label for="checkboxMenu-1"><span style="color: red;">Configuracões</span></label>
											</div>
										</li>';



								//Menu Membros

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="tela_membros" value="1" type="checkbox" id="checkboxMenu-2"';

								if ($permissao['tela_membros'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkboxMenu-2"><span style="color: #45c745">Membros</span></label>
										</div>
									</li>';

								//Menu Célula

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="tela_celula" value="1" type="checkbox" id="checkboxMenu-3"';

								if ($permissao['tela_celula'] == 1) {
									echo 'checked';
								}

								echo '>
												<label for="checkboxMenu-3"><span style="color: blue">Células</span></label>
											</div>
										</li>';

								//Menu Patrimonio

								echo '<li class="todo-list-item">
								<div class="checkbox">
									<input name="tela_patrimonio" value="1" type="checkbox" id="checkboxMenu-4"';

								if ($permissao['tela_patrimonio'] == 1) {
									echo 'checked';
								}

								echo '>
										<label for="checkboxMenu-4"><span style="color: yellow">Patrimônio</span></label>
									</div>
								</li>';


								//Configura TITULO

								echo '<div class="panel-heading">
										Permissões - <span style="color: red">Tela Configurações</span>
									</div>';

								//Configura Informacoes

								echo '<li class="todo-list-item">
										<div class="checkbox">
										<input name="config_informacao" value="1" type="checkbox" id="checkbox-4"';

								if ($permissao['config_informacao'] == 1) {
									echo 'checked';
								}

								echo '>
												<label for="checkbox-4">Informações</label>
											</div>
									</li>';

								//Configura MENUS

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="config_menus" value="1" type="checkbox" id="checkbox-6"';

								if ($permissao['config_menus'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-6">Menus</label>
										</div>
									</li>';

								//Configura SISTEMA

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="config_sistema" value="1" type="checkbox" id="checkbox-7"';

								if ($permissao['config_sistema'] == 1) {
									echo 'checked';
								}

								echo '>
													<label for="checkbox-7">Sistema</label>
												</div>
										</li>';

								//Membros TITULO

								echo '<div class="panel-heading">
									Permissões - <span style="color: #45c745">Tela Membros</span>
										</div>';

								//Membros EDITAR

								echo '<li class="todo-list-item">
									<div class="checkbox">
										<input name="membro_editar" value="1" type="checkbox" id="checkbox-8"';

								if ($permissao['membro_editar'] == 1) {
									echo 'checked';
								}

								echo '>
										<label for="checkbox-8">Editar</label>
									</div>
								</li>';

								//Membros Excluir

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="membro_excluir" value="1" type="checkbox" id="checkbox-9"';

								if ($permissao['membro_excluir'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-9">Excluir</label>
										</div>
									</li>';

								//Membros Adicionar

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="membro_adicionar" value="1" type="checkbox" id="checkbox-10"';

								if ($permissao['membro_adicionar'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-10">Adicionar</label>
										</div>
									</li>';

								//Célula Configuracoes

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="membro_permissao" value="1" type="checkbox" id="checkbox-11"';

								if ($permissao['membro_permissao'] == 1) {
									echo 'checked';
								}

								echo '>
													<label for="checkbox-11">Configurações</label>
												</div>
										</li>';

								//Membros TITULO

								echo '<div class="panel-heading">
									Permissões - <span style="color: blue">Tela Células</span>
										</div>';

								echo '<li class="todo-list-item">
									<div class="checkbox">
										<input name="celula_editar" value="1" type="checkbox" id="checkbox-12"';

								if ($permissao['celula_editar'] == 1) {
									echo 'checked';
								}

								echo '>
										<label for="checkbox-12">Editar</label>
									</div>
								</li>';

								//Celula Excluir

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_excluir" value="1" type="checkbox" id="checkbox-13"';

								if ($permissao['celula_excluir'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-13">Excluir</label>
										</div>
									</li>';

								//Celula Adicionar

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_adicionar" value="1" type="checkbox" id="checkbox-14"';

								if ($permissao['celula_adicionar'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-14">Adicionar</label>
										</div>
									</li>';

								//Celula Adicionar LIDER

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_incluir_lider" value="1" type="checkbox" id="checkbox-15"';

								if ($permissao['celula_incluir_lider'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-15">Vincular Lider</label>
										</div>
									</li>';

								//Celula desvincular LIDER

								echo '<li class="todo-list-item">
											<div class="checkbox">
												<input name="celula_excluir_lider" value="1" type="checkbox" id="checkbox-16"';

								if ($permissao['celula_excluir_lider'] == 1) {
									echo 'checked';
								}

								echo '>
												<label for="checkbox-16">Desvincular Lider</label>
											</div>
										</li>';

								//Celula Adicionar MEMBRO

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_incluir_membro" value="1" type="checkbox" id="checkbox-17"';

								if ($permissao['celula_incluir_membro'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-17">Vicular Membro</label>
										</div>
									</li>';

								//Celula desvincular membro

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_excluir_membro" value="1" type="checkbox" id="checkbox-18"';

								if ($permissao['celula_excluir_membro'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-18">Desvincular Membros</label>
										</div>
									</li>';
								//Celula incluir reunião

								echo '<li class="todo-list-item">
										<div class="checkbox">
											<input name="celula_incluir_reuniao" value="1" type="checkbox" id="checkbox-19"';

								if ($permissao['celula_incluir_reuniao'] == 1) {
									echo 'checked';
								}

								echo '>
											<label for="checkbox-19">Incluir Reunião</label>
										</div>
									</li>';


								//Patrimonio TITULO

								echo '<div class="panel-heading">
								Permissões - <span style="color: yellow">Tela Patrimônio</span>
									</div>';

								echo '<li class="todo-list-item">
								<div class="checkbox">
									<input name="patrimonio_adicionar" value="1" type="checkbox" id="checkbox-20"';

								if ($permissao['patrimonio_adicionar'] == 1) {
									echo 'checked';
								}

								echo '>
									<label for="checkbox-20">Adicionar</label>
								</div>
							</li>';

								//Celula Excluir

								echo '<li class="todo-list-item">
									<div class="checkbox">
										<input name="patrimonio_excluir" value="1" type="checkbox" id="checkbox-21"';

								if ($permissao['patrimonio_excluir'] == 1) {
									echo 'checked';
								}

								echo '>
										<label for="checkbox-21">Excluir</label>
									</div>
								</li>';
								
							}

							?>
						</ul>
						<div class="panel-heading"></div><br /><br />
						<div class="form-group">
							<div class="col-md-12 widget-right">
								<button type="submit" class="btn btn-info btn-md pull-right">
									<i class="fas fa-share"></i> Salvar
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--/.col-->

	</div>


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

</html>