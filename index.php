<!DOCTYPE html>
<html lang="pt-BR">
<?php
session_start();

// Desligue todos os relatórios de erros
error_reporting(0);

if ($_SESSION['email'] != NULL) { //verifiando se o usuário já esta logado
	header('Location: front/dashboard.php?pagina=1');
}

require_once('bd/conexao.php');
require_once('back/query.php');

?>

<head>
	<title>CFA - Centro Familiar de Adoração</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= $logo = substr($sistema['cfa_logo_login'], 3) ?>" alt="IMG" class="logo">
				</div>

				<form class="login100-form validate-form" method="post" action="back/validacao.php">
					<span class="login100-form-title font-cinzel">
						<h1><?= $sistema['cfa_titulo_login'] ?></h1>
						<h4><?= $sistema['cfa_subtitulo_login'] ?></h4>
					</span>

					<div class="wrap-input100 validate-input" data-validate="Inserir um e-mail valido">
						<input class="input100" type="text" name="email" placeholder="E-mail">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Forneça uma senha">
						<input class="input100" type="password" name="pass" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Forneça uma senha">
						<span class="focus-input100 txt2 alertaRed" style="<?= $_GET['erro'] == 1 ? 'display: block' : 'display: none' ?>;">Usuário nao encontrador</span>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Acessar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>