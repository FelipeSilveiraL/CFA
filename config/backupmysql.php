<?php

// Incluindo o autoload do Composer para carregar a biblioteca
require_once '../vendor/autoload.php';

// Incluindo a classe que criamos
require_once '../class/backupdatabase.php';

// Banco de dados
require_once '../bd/conexao.php';

// Como a geração do backup pode ser demorada, retiramos
// o limite de execução do script
set_time_limit(0);

// Utilizando a classe para gerar um backup na pasta 'backups'
// e manter os últimos dez arquivos
$backup = new BackupDatabase('/home2/cfasit28/public_ftp/backup', 5);
$backup->setDatabase($endereco, $db, $userdb, $senhadb);
$backup->generate();

?>