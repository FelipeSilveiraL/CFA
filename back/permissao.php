<?php

//Ativando o Active

switch ($_GET['pagina']) {
    case '1':
        $dashboard = 'class="active"';
        break;

    case '2':
        $configuracao = 'class="active"';
        break;
    case '3':
        $membro = 'class="active"';
        break;
    case '4';
        $celula = 'class="active"';
        break;
}

//permissões de telas

/* ===== CONFIGURACOES ===== */
$_SESSION['tela_configuracao'] == 0 ? $configuracao .= " style='display: none;'" : $configuracao .= " style='display: block;'";

/* ===== MEMBROS ===== */
$_SESSION['tela_membros'] == 0 ? $membro .= " style='display: none;'" : $membro .= " style='display: block;'";

/* ===== MEMBROS ===== */
$_SESSION['tela_celula'] == 0 ? $celula .= " style='display: none;'" : $celula .= " style='display: block;'";

?>