<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');

if (empty($_GET['idMembro'])) {

	if ($_SESSION['membro_adicionar'] != 1) {
		header('Location: dashboard.php?pagina=1');
	}
} else {

	if ($_GET['idMembro'] != $_SESSION['id_usuario']) {

		if ($_SESSION['membro_editar'] != 1) {
			header('Location: dashboard.php?pagina=1');
		}
	}
}

include('head.php');
include('header.php');
include('../bd/conexao.php');
include('menu.php');
include('../back/query.php');

if (!empty($_GET['idMembro'])) {
	//coletando dados do membro
	$queryUsuarios .= " WHERE U.id = " . $_GET['idMembro'];
	$resultMembro = $conn->query($queryUsuarios);
	$membro = $resultMembro->fetch_assoc();
	$titulo = $membro['nome'];
	$icon = '<i class="fas fa-user"></i>';
	$foto = $membro['foto_perfil'];
	$button = 'Editar';
} else {
	$titulo = "Novo Membro";
	$icon = '<i class="fas fa-plus"></i>';
	$foto = '../images/icons/avatar.png';
	$button = 'Salvar';
}
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="dashboard.php?pagina=1"><i class="fas fa-home"></i> Home</a></li>
			<li><a href="membros.php?pagina=3&modo=1"><i class="fas fa-users"></i> Membros</li></a>
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
						<em class="fa fa-lg fa-warning">&nbsp;</em> Novo membro cadastrado com sucesso<a href="javascript:" class="pull-right" onclick="fecharSuccess()"><em class="fa fa-lg fa-close"></em></a>
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
				<div class="panel-heading" style="display:

				<?php

				if (!empty($_GET['idMembro']) and $_SESSION['membro_permissao'] == 1) {
					echo 'block';
				} else {
					echo 'none';
				}

				?>
				
				;">
					Informações do membro
					<ul class="pull-right panel-settings panel-button-tab-right">
						<li class="dropdown">
							<a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
								<em class="fa fa-cogs"></em>
							</a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li>
									<ul class="dropdown-settings">
										<li><a href="permissao.php?pagina=3&idMembro=<?= $_GET['idMembro'] ?>">
												<em class="fa fa-users-cog"></em> Configuração
											</a></li>
									</ul>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="col-md-6">
						<form role="form" method="POST" action="../back/novoMembro.php?idMembro=<?= $_GET['idMembro'] ?>" enctype="multipart/form-data">
							<div class="panel-heading"><i class="fas fa-user"></i> Dados Pessoais</div>
							<br />
							<div class="col-xs-12">
								<div class="form-group">
									<label for="FileUpload1" class="labelFoto">Foto Perfil<br /><br />
										<img ID="imgImage" src="<?= $foto ?>" style="width: 139px; border-radius: 10px;" />
									</label>
									<input type="file" ID="FileUpload1" onChange="mostraImagem(this)" style="display: none;" name="foto" />
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Nome:</label>
									<input class="form-control" name="nome" maxlength="20" value="<?= !empty($membro['nome']) ? $membro['nome'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Sobrenome:</label>
									<input type="text" class="form-control" name="sobrenome" maxlength="30" value="<?= !empty($membro['sobre_nome']) ? $membro['sobre_nome'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label>E-mail:</label>
									<input type="mail" class="form-control" style="text-transform: lowercase;" name="email" maxlength="100" value="<?= !empty($membro['email']) ? $membro['email'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>RG:</label>
									<input type="text" class="form-control" name="rg" value="<?= !empty($membro['rg']) ? $membro['rg'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Data nascimento:</label>
									<input type="date" class="form-control" name="nascimento" value="<?= !empty($membro['data_nascimento']) ? $membro['data_nascimento'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Telefone:</label>
									<input type="text" class="form-control" placeholder="(xx) xxxx - xxxx" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" name="telefone" maxlength="15" value="<?= !empty($membro['telefone']) ? $membro['telefone'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Celular:</label>
									<input type="text" class="form-control" placeholder="(xx) xxxx - xxxx" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" name="celular" maxlength="15" value="<?= !empty($membro['celular']) ? $membro['celular'] : ""  ?>">
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Gênero:</label>
									<select class="form-control" name="genero" required>
										<?php
										if (!empty($membro['genero'])) {
											echo '<option value="' . $membro['id_sexo'] . '">' . $membro['genero'] . '</option>';
											echo '<option>------------</option>';
										} else {
											echo '<option selected>Selecione...</option>';
										}

										while ($sexo = $resultSexo->fetch_assoc()) {
											echo '<option value="' . $sexo['id'] . '">' . $sexo['nome'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Célula:</label>
									<select class="form-control" name="celula">
										<?php
										if (!empty($membro['celula'])) {

											if ($membro['id_celula'] != 0) {
												echo '<option value="' . $membro['id_celula'] . '">' . $membro['celula'] . '</option>';
												echo '<option value="0">------------</option>';
											} else {
												echo '<option value="0">Selecione...</option>';
											}
										} else {
											echo '<option value="0">Selecione...</option>';
										}

										while ($celula = $resultCelulas->fetch_assoc()) {
											echo '<option value="' . $celula['id'] . '">' . $celula['nome'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>incargo:</label>
									<select class="form-control" name="cargo" id="cargo" onchange="cargoMembro()">
										<?php
										if (!empty($membro['cargo'])) {
											echo '<option value="' . $membro['id_cargo'] . '">' . $membro['cargo'] . '</option>';
											echo '<option>------------</option>';
										} else {
											echo '<option value="5">Selecione...</option>';
										}
										while ($cargo = $resultCargo->fetch_assoc()) {
											echo '<option value="' . $cargo['id'] . '">' . $cargo['nome'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label>Estado Cívil:</label>
									<select class="form-control" name="civil" id="civil" onchange="casado()">
										<?php
										if (!empty($membro['id_estado_civil'])) {
											echo '<option value="' . $membro['id_estado_civil'] . '">' . $membro['estado_civil'] . '</option>';
											echo '<option>------------</option>';
										} else {
											echo '<option selected>Selecione...</option>';
										}

										while ($civil = $resultCivil->fetch_assoc()) {
											echo '<option value="' . $civil['id'] . '">' . $civil['nome'] . '</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-xs-12" style="display: none;" id="mostrarSenha">
								<div class="input-group" style="margin-bottom: 15px;">
									<label>Senha:</label>
									<input id="btn-input" class="form-control input-md" type="password" name="senha" maxlength="20">
									<span class="input-group-btn">
										<a href="javascript:" class="btn btn-danger btn-md" id="btn-todo" onclick="ver()" style="margin-top: 25px;">
											<i class="fas fa-eye" style="margin-top: 10px;"></i>
										</a>
									</span>
								</div>
							</div>
							<div id="conjuge" style="display: <?= !empty($membro['nome_conjuge']) ? "block" : "none" ?>;">
								<div class="col-xs-12">
									<div class="form-group">
										<label>Cônjuge:</label>
										<input type="text" id="myInput" name="nome_conjuge" value="<?= !empty($membro['nome_conjuge']) ? $membro['nome_conjuge'] : ""  ?>">
									</div>
									<div>
										<p id="no-results"></p>
										<ul id="myUL">
											<?php
											$resultadoConjuge = $conn->query($queryUsuarios);
											while ($conjuge = $resultadoConjuge->fetch_assoc()) {
												echo '
													<li><a href="javascript:" onclick="teste' . $conjuge['id'] . '()" id="nomeConjuge' . $conjuge['id'] . '">' . $conjuge['nome'] . " " . $conjuge['sobre_nome'] . '</a></li>
													<script>
														function teste' . $conjuge['id'] . '(){
															var test = document.getElementById("nomeConjuge' . $conjuge['id'] . '").innerHTML
															document.getElementById("myInput").value = test
															document.getElementById("myUL").style.display = "none"
														}
													</script>
													';
											}
											?>
										</ul>
									</div>
								</div>
								<?php
								$queryFilhos .= " WHERE CF.id_pais = " . $membro['id'];
								if ($resultadoFilhos = $conn->query($queryFilhos)) {
									while ($filhos = $resultadoFilhos->fetch_assoc()) {
										echo '<div class="col-xs-6">
												<div class="form-group">
													<label>Filhos:</label>
													<input type="text" class="form-control" style="text-transform: uppercase;" name="filhos' . $filhos['id'] . '" maxlength="100" value="' . $filhos['nome_filho'] . '">
												</div>
											</div>
											<div class="col-xs-6">
												<div class="form-group">
													<label>Data nascimento:</label>
													<input type="date" class="form-control" name="data_nascimento' . $filhos['id'] . '" value="' . $filhos['data_nascimento'] . '">
												
													<div class="pull-right action-buttons removeFilhos">
														<a href="../back/removeFilho.php?pagina=' . $_GET['pagina'] . '&idMembro=' . $_GET['idMembro'] . '&idFilho=' . $filhos['id'] . '&config=1" class="trash" title="Excluir">
															<em class="fa fa-trash" aria-hidden="true"></em>
														</a>
													</div>
												</div>
											</div>
											';
									}
								}
								?>
								<div class="col-xs-12">
									<div class="form-group">
										<label>filhos:</label>
										<select class="form-control" name="possuiFilhos" id="possuiFilhos" onchange="filhos()">
											<option selected>Selecione...</option>
											<option value="1">sim</option>
											<option value="2">não</option>
										</select>
									</div>
								</div>
								<!-- Filhos-->
								<div class="col-xs-12" style="display: none;" id="addFilho">
									<div class="form-group">
										<table id="myTable" class="table table-borderless">
											<thead>
												<th>Nome</th>
												<th>Data Nascimento</th>
											</thead>
											<tbody>
												<tr>
													<td class="col-sm-9" style="border-top: none;">
														<input type="text" name="nomePlus0" class="form-control" />
													</td>
													<td class="col-sm-9" style="border-top: none;">
														<input type="date" name="dataNascimento0" class="form-control" />
													</td>
													<td class="col-sm-2" style="border-top: none;">
														<a class="deleteRow"></a>

													</td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="1" style="border-top: none;">
														<input type="button" class="btn btn-sm btn-block btn-success" id="addrow" value="adicionar" />
													</td>
												</tr>
												<tr>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
					</div>
					<div class="col-md-6">
						<div class="panel-heading endereco"><i class="fas fa-book-open"></i> Dados Eclesiásticos</div>
						<br />

						<div class="col-xs-6">
							<div class="form-group">
								<label>Data batismo nas águas:</label>
								<input type="date" class="form-control" name="data_batismo" value="<?= !empty($membro['data_batismo']) ? $membro['data_batismo'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-6">
							<div class="form-group">
								<label>Igreja:</label>
								<input class="form-control" name="igreja_batismo" maxlength="100" value="<?= !empty($membro['igreja_batismo']) ? $membro['igreja_batismo'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-6">
							<div class="form-group">
								<label>Igreja anterior:</label>
								<input class="form-control" name="igreja_anterior" maxlength="100" value="<?= !empty($membro['igreja_anterior']) ? $membro['igreja_anterior'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-6">
							<div class="form-group">
								<label>Pastor:</label>
								<input class="form-control" name="pastor" maxlength="100" value="<?= !empty($membro['pastor']) ? $membro['pastor'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label>Cargos exercidos:</label>
								<input class="form-control" name="cargos_exercidos" placeholder="Ex: Obreiro, ministro de louvor, etc..." maxlength="100" value="<?= !empty($membro['cargos_exercidos']) ? $membro['cargos_exercidos'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label>Deseja exercer flguma função na igreja? Qual?:</label>
								<input class="form-control" name="cargos_desejados" placeholder="Ex: Obreiro, ministro de louvor, etc..." maxlength="100" value="<?= !empty($membro['cargos_desejados']) ? $membro['cargos_desejados'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label>Talentos/Ministérios que possui:</label>
								<input class="form-control" name="talentos" placeholder="Ex: Tocar instrumentos, pregar a palavra, etc..." maxlength="100" value="<?= !empty($membro['talentos']) ? $membro['talentos'] : ""  ?>">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="form-group">
								<label>Aceito por:</label>
								<select class="form-control" name="aceito_por">
									<?php

									if (!empty($membro['aceito_por'])) {
										switch ($membro['aceito_por']) {
											case '1':
												echo '<option value="1">Batismo</option>';
												break;

											case '2':
												echo '<option value="2">Adesão</option>';
												break;
											case '3':
												echo '<option value="3">Trasnferencia de igreja</option>';
												break;
										}
										echo '<option>------------</option>';
									}else{
										echo '<option selected>Selecione...</option>';
									}
									?>
									<option value="1">Batismo</option>
									<option value="2">Adesão</option>
									<option value="3">Trasnferencia de igreja</option>
								</select>
							</div>
						</div>

					</div>
					<div class="col-md-6">
						<div class="panel-heading endereco"><i class="fas fa-home"></i> Endereço</div>
						<br />

						<div class="col-xs-8">
							<div class="form-group">
								<label>Endereço:</label>
								<input class="form-control" name="endereco" maxlength="100" value="<?= !empty($membro['endereco']) ? $membro['endereco'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<label>Número:</label>
								<input class="form-control" name="numero" maxlength="10" value="<?= !empty($membro['numero']) ? $membro['numero'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>Bairro:</label>
								<input class="form-control" name="bairro" maxlength="50" value="<?= !empty($membro['bairro']) ? $membro['bairro'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>CEP:</label>
								<input class="form-control" name="cep" maxlength="10" value="<?= !empty($membro['cep']) ? $membro['cep'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>Natural de:</label>
								<input type="text" class="form-control" name="pais" maxlength="10" value="<?= !empty($membro['pais']) ? $membro['pais'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<label>Estado:</label>
								<input type="text" class="form-control" name="estado" maxlength="10" value="<?= !empty($membro['estado']) ? $membro['estado'] : ""  ?>">
							</div>
						</div>
						<div class="col-xs-12">
							<div class="form-group">
								<label>Cidade:</label>
								<input type="text" class="form-control" name="cidade" maxlength="20" value="<?= !empty($membro['cidade']) ? $membro['cidade'] : ""  ?>">
							</div>
						</div>
						<div style="display: <?= $_SESSION['membro_editar'] == 1 ? "block" : "none" ?>;">
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
			<?php empty($_GET['idMembro']) ?: include('meucurso.php') ?>
		</div><!-- /.col-->
		<!--/. CONTEUDO-->

		<!--FOOTER-->
		<?php include('footer.php'); ?>
		<!--/. FOOTER-->

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