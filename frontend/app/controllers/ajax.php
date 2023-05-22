<?php 
ini_set('max_execution_time', 1000);
set_time_limit(1000);

// INCLUDE FUNCTIONS
include "../../inc/functions.php";

// CAPTURA REQUESTS
$acao = checarAcao($_SERVER['REQUEST_METHOD']);

// TRATANDO URL
$capturaURL = explode('/', $_POST['qv_url_path']);

//******* INCLUDE MODEL
include "../models/geral.php";

/******************************************************************************/
/*************************** CONSULTA UNIDADES ********************************/
/******************************************************************************/
if($acao == 'consulta_unidades') {

    // Instância Class | POST dos Campos
    $classe = new QV_Unidades($_POST);

    // Chama Metodo - Consulta
    $resultadoFinal = $classe->consulta();

}

/******************************************************************************/
/************************** DEFINIR NOVA UNIDADE ******************************/
/******************************************************************************/
if($acao == 'definir_unidade') {

    // Instância Class | POST dos Campos
    $classe = new QV_Unidades($_POST);

    // Chama Metodo - Consulta
    $resultadoFinal = $classe->definirUnidade();

}

/******************************************************************************/
/***************************** UNIDADE NEUTRA *********************************/
/******************************************************************************/
if($acao == 'unidade_neutra') {

    // Instância Class | POST dos Campos
    $classe = new QV_Unidades($_POST);

    // Chama Metodo - Consulta
    $resultadoFinal = $classe->unidadeNeutra();

}

/******************************************************************************/
/***************************** TROCAR MODULO **********************************/
/******************************************************************************/
if($acao == 'trocar_modulo') {

    // Instância Class | POST dos Campos
    $classe = new QV_Geral($_POST);

    // Chama Metodo - Consulta
    $resultadoFinal = $classe->trocarModulo(); 

}

echo json_encode($resultadoFinal);
?>