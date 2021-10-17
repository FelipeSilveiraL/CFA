<?php

switch ($_GET['idMenu']) {
    case '1':
        $nomeMenu = "Incargo";
        $icone = '<i class="fas fa-people-carry"></i>';
        $menuBanco = "menu_cargo";
        break;

    case '2':
        $nomeMenu = "Gênero";
        $icone = '<i class="fas fa-venus-mars"></i>';
        $menuBanco = "menu_sexo";
        break;

    case '3':
        $nomeMenu = "Estado Cívil";
        $icone = '<i class="fas fa-church"></i>';
        $menuBanco = "menu_estado_civil";
        break;
}
?>