<?php
session_start();

$_SESSION['email'] != NULL ?: header('Location: ../adm.php?erro=1');
$_SESSION['tela_configuracao'] == 1 ?: header('location: dashboard.php?pagina=1'); 

include('head.php');
include('header.php');
?>

<!--MENU LATERAL-->
<?php include('menu.php'); ?>
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
            <li>
                <a href="configuracao.php?pagina=2">
                    <i class="fas fa-tools"></i> Configuração
                </a>
            </li>
            <li class="active"><i class="fas fa-info-circle"></i> Informações</li>
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
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Informações básicas</div>
            <div class="panel-body">
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> IP Servidor Local:
                    </span> <?= $_SERVER['SERVER_ADDR'] ?>
                </p>
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> IP Servidor Remoto:
                    </span> <?= $_SERVER['REMOTE_ADDR'] ?>
                </p>
                <p>
                    <?= printf("<span class='colorBlue'><i class='fas fa-caret-right'></i>  DB:</span> %s\n", $conn->client_info) ?>;
                </p>
                <p>
                    <?= printf("<span class='colorBlue'><i class='fas fa-caret-right'></i>  Versão DB:</span> %s\n", $conn->server_info) ?>;
                </p>
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> Porta DB:
                    </span> <?= $portadb ?>
                </p>
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> DB:
                    </span> <?= $db ?>
                </p>
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> Usuário DB:
                    </span> <?= $userdb ?>
                </p>
                <p>
                    <span class="colorBlue">
                        <i class="fas fa-caret-right"></i> Senha DB:
                        <input id="btn-input" class="btn btn-default btn-md" type="password" value="<?= $senhadb ?>" disabled>

                        <button class="btn btn-danger btn-md" id="btn-todo" onclick="ver()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </span>

                </p>
            </div>
        </div>
    </div>
</div>


<!--/. CONTEUDO-->
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

<!--FOOTER-->
<?php include('footer.php'); ?>
<!--/. FOOTER-->