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

    case '4':
        $nomeMenu = "Conservação";
        $icone = '<i class="fab fa-envira"></i>';
        $menuBanco = "menu_conservacao";
    break;

    case '5':
        $nomeMenu = "Categoria";
        $icone = '<i class="fas fa-tags"></i>';
        $menuBanco = "menu_categoria";
    break;

    case '6':
        $nomeMenu = "Local";
        $icone = '<i class="fas fa-map-marker-alt"></i>';
        $menuBanco = "menu_local";
    break;

    case '7':
        $nomeMenu = "Origem";
        $icone = '<i class="fas fa-box"></i>';
        $menuBanco = "menu_origem";
    break;

    case '8':
        $nomeMenu = "Situacao";
        $icone = '<i class="fas fa-exclamation-circle"></i>';
        $menuBanco = "menu_situacao";
    break;
}
?>