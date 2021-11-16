<?php

include('../bd/conexao.php');

if (!empty($_GET['idMembro'])) {

    //TELAS
    $telaconfiguracoes = empty($_POST['tela_configuracoes']) ? "0" : $_POST['tela_configuracoes'];
    $telamembros = empty($_POST['tela_membros']) ? "0" : $_POST['tela_membros'];
    $telacelula = empty($_POST['tela_celula']) ? "0" : $_POST['tela_celula'];
    $telapatrimonio = empty($_POST['tela_patrimonio']) ? "0" : $_POST['tela_patrimonio'];    
    $telafinanceiro = empty($_POST['tela_financeiro']) ? "0" : $_POST['tela_financeiro'];    
    $telaestudos = empty($_POST['tela_estudos']) ? "0" : $_POST['tela_estudos'];

    //CONFIGURAÇÃO
    $configinformacao = empty($_POST['config_informacao']) ? "0" : $_POST['config_informacao'];
    $configsistema = empty($_POST['config_sistema']) ? "0" : $_POST['config_sistema'];
    $configmenus = empty($_POST['config_menus']) ? "0" : $_POST['config_menus'];

    //MEMBROS
    $membroeditar = empty($_POST['membro_editar']) ? "0" : $_POST['membro_editar'];
    $membroexcluir = empty($_POST['membro_excluir']) ? "0" : $_POST['membro_excluir'];
    $membroadicionar = empty($_POST['membro_adicionar']) ? "0" : $_POST['membro_adicionar'];
    $membropermissao = empty($_POST['membro_permissao']) ? "0" : $_POST['membro_permissao'];

    //CELULA
    $celulaeditar = empty($_POST['celula_editar']) ? "0" : $_POST['celula_editar'];
    $celulaexcluir = empty($_POST['celula_excluir']) ? "0" : $_POST['celula_excluir'];
    $celulaadicionar = empty($_POST['celula_adicionar']) ? "0" : $_POST['celula_adicionar'];    
    $celulaincluirlider = empty($_POST['celula_incluir_lider']) ? "0" : $_POST['celula_incluir_lider'];
    $celulaexcluirlider = empty($_POST['celula_excluir_lider']) ? "0" : $_POST['celula_excluir_lider'];
    $celulaincluirmembro = empty($_POST['celula_incluir_membro']) ? "0" : $_POST['celula_incluir_membro'];
    $celulaexcluirmembro = empty($_POST['celula_excluir_membro']) ? "0" : $_POST['celula_excluir_membro'];
    $celulaincluirreuniao = empty($_POST['celula_incluir_reuniao']) ? "0" : $_POST['celula_incluir_reuniao'];

    //PATRIMONIO
    $patrimonioexcluir = empty($_POST['patrimonio_excluir']) ? "0" : $_POST['patrimonio_excluir'];
    $patrimonioadicionar = empty($_POST['patrimonio_adicionar']) ? "0" : $_POST['patrimonio_adicionar']; 

    //FINANCEIRO
    $financeiroadicionar = empty($_POST['financeiro_adicionar']) ? "0" : $_POST['financeiro_adicionar'];
    $financeiroexcluir = empty($_POST['financeiro_excluir']) ? "0" : $_POST['financeiro_excluir']; 
    
    //ESTUDOS
    $estudosadicionar = empty($_POST['estudos_adicionar']) ? "0" : $_POST['estudos_adicionar'];
    $estudosexcluir = empty($_POST['estudos_excluir']) ? "0" : $_POST['estudos_excluir']; 

    //variaveis do sistema
    $update = "UPDATE cfa_permissao SET 
            tela_configuracoes = '" . $telaconfiguracoes . "', 
            tela_membros = '" . $telamembros . "',  
            tela_celula = '" . $telacelula . "',  
            tela_patrimonio = '".$telapatrimonio."',  
            tela_financeiro = '".$telafinanceiro."',  
            tela_estudos = '".$telaestudos."',
            config_informacao = '" . $configinformacao . "',  
            config_sistema = '" . $configsistema . "',  
            config_menus = '" . $configmenus . "',  
            membro_editar = '" . $membroeditar . "',  
            membro_excluir = '" . $membroexcluir . "',  
            membro_adicionar = '" . $membroadicionar . "',  
            membro_permissao = '" . $membropermissao . "',  
            celula_editar = '" . $celulaeditar . "',  
            celula_excluir = '" . $celulaexcluir . "',  
            celula_adicionar = '" . $celulaadicionar . "',            
            celula_incluir_lider = '" . $celulaincluirlider . "',
            celula_excluir_lider = '" . $celulaexcluirlider . "',
            celula_incluir_membro = '" . $celulaincluirmembro . "',
            celula_excluir_membro = '" . $celulaexcluirmembro . "',
            celula_incluir_reuniao = '" . $celulaincluirreuniao . "',
            patrimonio_adicionar = '" . $patrimonioadicionar . "',  
            patrimonio_excluir = '" . $patrimonioexcluir . "',
            financeiro_adicionar = '" . $financeiroadicionar . "',  
            financeiro_excluir = '" . $financeiroexcluir . "',
            estudos_adicionar = '" . $estudosadicionar . "',  
            estudos_excluir = '" . $estudosexcluir . "'             

        WHERE (id_usuario = '" . $_GET['idMembro'] . "')";


    if (!$result = $conn->query($update)) {
        printf("Error message[1]: %s\n", $conn->error);
    } else {
        header('location: ../front/permissao.php?pagina=3&idMembro=' . $_GET['idMembro'] . '');
    }
}
