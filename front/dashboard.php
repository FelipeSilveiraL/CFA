<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');

include('head.php');
include('header.php');
include('menu.php');
include('../bd/conexao.php');
include('../back/query.php');

//MEUS DADOS / CELULA
$queryUsuarios .= " WHERE U.id = " . $_SESSION['id_usuario'];
$resultado = $conn->query($queryUsuarios);
$usuario = $resultado->fetch_assoc();

//MEUS ESTUDOS
$queryEstudantes .= " WHERE CES.id_usuario = " . $_SESSION['id_usuario'];
$resultadoEstudos = $conn->query($queryEstudantes);

//ANIVERSARIANTES
$mesAtual = date('m');
$queryAniversario = "SELECT id, nome, sobre_nome, data_nascimento FROM cfa_usuarios WHERE deletar = 0 AND data_nascimento like '%-" . $mesAtual . "-%'";
$resultAniversario = $conn->query($queryAniversario);

?>

<head>
	<!-- CSS -->
	<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
	<!-- JavaScript -->
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
</head>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--DIV é finalizada no footer.php-->

	<!--NAVEGAÇÃO-->
	<div class="row">
		<ol class="breadcrumb">
			<li class="active"><i class="fas fa-home"></i> Home</li>
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

	<!--COMUNICADOS-->
	<div class="row">
		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					Comunicados
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">

					<!-- Flickity HTML init -->
					<div class="carousel js-flickity">
						<!-- images from unsplash.com -->
						<div class="carousel-cell">
							<img src="../images/comunicados/01.jpeg" />
						</div>
						<div class="carousel-cell">
							<img src="../images/comunicados/02.jpeg" />
						</div>
						<div class="carousel-cell">
							<img src="../images/comunicados/03.jpeg" />
						</div>
						<div class="carousel-cell">
							<img src="../images/comunicados/04.jpeg" />
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					Aniversariantes neste mês
					<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<td>Nome</td>
								<td>dia</td>
							</tr>
						</thead>
						<tbody>
							<?php
								while($aniversario = $resultAniversario->fetch_assoc()){
									echo '
									<tr>
										<td><a href="novoMembro.php?pagina=3&idMembro='.$aniversario['id'].'"> '.$aniversario['nome'].' '.$aniversario['sobre_nome'].'</a></td>
										<td>'.date('d', strtotime($aniversario[''])).'</td>
									</tr>';
								}

							?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
	<!--/. COMUNICADOS-->

	<!--MEUS DADOS-->

	<div class="row">

		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading textNome" id="lider">
					Meus Dados
					<span class="pull-right clickable panel-toggle panel-button-tab-right"><em class="fa fa-toggle-up" aria-hidden="true"></em></span>
					<span class="pull-right panel-toggle panel-button-tab-left">
						<a href="novoMembro.php?pagina=3&idMembro=<?= $_SESSION['id_usuario'] ?>" title="Editar meu cadastro">
							<i class="fa-solid fa-pen"></i>
						</a>
					</span>

				</div>
				<div class="panel-body">
					<p><strong class="primary-font">Nome:</strong> <?= $usuario['nome'] . " " . $usuario['sobre_nome'] ?></p>
					<p><strong class="primary-font">Email:</strong> <?= $usuario['email'] ?></p>
					<p><strong class="primary-font">Whatsapp:</strong> <?= $usuario['celular'] ?></p>
					<p><strong class="primary-font">Estado civil:</strong> <?= $usuario['estado_civil'] ?></p>
					<p><strong class="primary-font">Incargo:</strong> <?= $usuario['cargo'] ?></p>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="panel panel-default" id="membro">
				<div class="panel-heading textNome">
					Minha Célula
					<span class="pull-right clickable panel-toggle panel-button-tab-right"><em class="fa fa-toggle-up" aria-hidden="true"></em></span>
					<span class="pull-right panel-toggle panel-button-tab-left">
						<a href="novaCelula.php?pagina=4&idCelula=<?= $usuario['id_celula'] ?>" title="Ver mais">
							<i class="fa-solid fa-eye"></i>
						</a>
					</span>
				</div>
				<div class="panel-body">
					<p><strong class="primary-font">Nome:</strong> <?= $usuario['celula'] ?></p>
					<p><strong class="primary-font">Dia semana:</strong> <?= $usuario['dia_semana'] ?></p>
					<p><strong class="primary-font">horario:</strong> <?= $usuario['horario'] ?>h</p>
					<p><strong class="primary-font">Endereço:</strong> <?= $usuario['endereco_celula'] . ", " . $usuario['numero_celula'] ?> </p>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-default" id="membro">
				<div class="panel-heading textNome">
					Meus cursos
					<span class="pull-right clickable panel-toggle panel-button-tab-right"><em class="fa fa-toggle-up" aria-hidden="true"></em></span>
					<span class="pull-right panel-toggle panel-button-tab-left">
						<a href="novoMembro.php?pagina=3&idMembro=5#meuCurso" title="Ver mais">
							<i class="fa-solid fa-eye"></i>
						</a>
					</span>
				</div>
				<div class="panel-body">
					<?php
					while ($estudos = $resultadoEstudos->fetch_assoc()) {
						echo '
							<p><strong class="primary-font">Nome:</strong> ' . $estudos['nomeEstudo'] . '</p>
							<p><strong class="primary-font">Inicio:</strong> ' . date('d/m/Y', strtotime($estudos['data_inicio'])) . '</p>
							<p><strong class="primary-font">Término:</strong> ' . date('d/m/Y', strtotime($estudos['data_fim'])) . '</p>
							<p><strong class="primary-font">Status:</strong> ' . $estudos['status'] . '</p>
							<hr>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!--/. MEUS DADOS-->

	<!--FOOTER-->
	<?php include('footer.php'); ?>
	<!--/. FOOTER-->