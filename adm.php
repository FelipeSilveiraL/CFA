<?php
session_start();

if ($_SESSION['email'] != NULL) { //verifiando se o usuário já esta logado
	header('Location: front/dashboard.php');
}
require_once('bd/conexao.php');
require_once('back/query.php');

//ações automaticas do sistemas
require_once('back/processAutomaticos.php');


switch ($_GET['pag']) {
	case '1':
		$idLogar = 'block';
		$idAlterarSenha = 'none';
		$idInsiraEmail = 'none';
		$nomeButton = 'Acessar';
		$actionForm = 'back/validacao.php';
		break;

	case '2':
		//verificar se ele pediu mesmo para alterar a senha

		if (!empty($_GET['idUsuario'])) {
			$queryUsuarios .= " WHERE U.id = " . $_GET['idUsuario'];
			$resultUsuario = $conn->query($queryUsuarios);
			$usuarios = $resultUsuario->fetch_assoc();

			if ($usuarios['alterarSenha'] == 1) {
				$idLogar = 'none';
				$idAlterarSenha = 'block';
				$idInsiraEmail = 'none';
				$nomeButton = 'Alterar';
				$actionForm = 'back/alterarSenha.php?idUsuario=' . $usuarios['id'];
			} else {
				header('Location: adm.php?pag=1');
			}
		} else {
			header('Location: adm.php?pag=1');
		}

		break;

	case '3':
		$idLogar = 'none';
		$idAlterarSenha = 'none';
		$idInsiraEmail = 'block';
		$nomeButton = 'Enviar por e-mail';
		$actionForm = '/back/emailSenha.php';
		break;

	default:
		header('Location: adm.php?pag=1');
		break;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

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
			<div class="col-lg-12" id="msnOne" style="display: <?= $_GET['msn'] == 1 ? 'block' : 'none' ?>">
				<div class="alert bg-success" role="alert"><em class="fa fa-lg fa-warning">&nbsp;</em> Senha alterada com sucesso! <a href="javascript:" class="pull-right" onclick="msnONE()"><em class="fa fa-lg fa-close"></em></a></div>
			</div>
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?= $logo = substr($sistema['cfa_logo_login'], 3) ?>" alt="IMG" class="logo">
				</div>

				<form class="login100-form validate-form" method="post" action="<?= $actionForm ?>">
					<span class="login100-form-title font-cinzel">
						<h1><?= $sistema['cfa_titulo_login'] ?></h1>
						<h4><?= $sistema['cfa_subtitulo_login'] ?></h4>
					</span>

					<div id="logar" style="display: <?= $idLogar ?>;">
						<div class="wrap-input100">
							<input class="input100" type="text" name="email" placeholder="E-mail">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100">
							<input class="input100" type="password" name="passLogar" placeholder="Senha">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>
					</div>

					<div id="AlterarSenha" style="display: <?= $idAlterarSenha ?>;">
						<div class="wrap-input100">
							<input class="input100" id="password" type="password" placeholder="Nova senha" onkeyup="check();">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-unlock-alt" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100">
							<input class="input100" type="password" name="passAlterarSenha" id="confirm_password" placeholder="Repita senha" onkeyup='check();'>
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>
						<span id='message' class="txt2"></span>
					</div>

					<div id="insiraEmail" style="display: <?= $idInsiraEmail ?>;">
						<div class="wrap-input100">
							<input class="input100" type="email" name="emailEsqueciSenha" placeholder="Email">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
						</div>
					</div>

					<div class="wrap-input100">
						<span class="focus-input100 txt2 alertaRed" style="<?= $_GET['erro'] == 1 ? 'display: block' : 'display: none' ?>;">Usuário nao encontrador</span>
					</div>
					<div class="wrap-input100">
						<span class="focus-input100 txt2 alertaRed" style="<?= $_GET['erro'] == 2 ? 'display: block' : 'display: none' ?>;">Conta desativada</span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" id="enviar">
							<?= $nomeButton ?>
						</button>
					</div>
					<div class="text-center p-t-12">
						<span class="txt1">
							Esqueceu
						</span>
						<a class="txt2" href="adm.php?pag=3">
							Usuário / Senha?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		//escondendo msn

		function msnONE() {
			document.getElementById("msnOne").style.display = "none";
		}

		//Validando senha iguais
		var check = function() {
			if (document.getElementById('password').value == document.getElementById('confirm_password').value) {
				document.getElementById('message').style.color = 'green';
				document.getElementById('message').innerHTML = 'Senha OK';
				document.getElementById("enviar").disabled = false;
			} else {
				document.getElementById('message').style.color = 'red';
				document.getElementById('message').innerHTML = 'Senha diferentes';
				document.getElementById("enviar").disabled = true;
			}
		}
	</script>

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