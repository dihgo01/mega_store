<?php 
ini_set('max_execution_time', 1000);
set_time_limit(1000);

// INCLUDE FUNCTIONS
include $_SERVER['DOCUMENT_ROOT']."/inc/functions.php";

// CAPTURA REQUESTS
$acao = checarAcao($_SERVER['REQUEST_METHOD']);

// TRATANDO URL
$capturaURL = explode('/', $_POST['qv_url_path']);
url_friendly($capturaURL, $_POST['qv_url_path']);

/******************************************************************************/
/***************** MINHA CONTA > FRANQUIAS > QV EM CASA ***********************/
/******************************************************************************/
if($acao == 'qvemcasa') {

    // FIND MODEL
    $model = carregarMVC($_QV['URL'],'models');
    if(file_exists($model)) {

        // INCLUDE MODEL
        include $model;        

        // Instância Class | POST dos Campos
        $classe = new QV_MinhaConta($_POST);

        // Chama Metodo
        $resultadoFinal = $classe->franquiasQVEmCasa(); 
        
    }

}

/******************************************************************************/
/***************** MINHA CONTA > FRANQUIAS > DADOS FISCAIS ********************/
/******************************************************************************/
if($acao == 'dadosFiscaisList') {

    // FIND MODEL
    $model = carregarMVC($_QV['URL'],'models');
    if(file_exists($model)) {

        // INCLUDE MODEL
        include $model;        

        // Instância Class
        $classe = new QV_MinhaConta();

        // Chama Metodo
        $resultadoFinal = $classe->franquiasConfigFiscaisList(); 
        
    }

}

if($acao == 'dadosFiscaisUpdate') {

    // FIND MODEL
    $model = carregarMVC($_QV['URL'],'models');
    if(file_exists($model)) {

        // INCLUDE MODEL
        include $model;        

        // Instância Class
        $classe = new QV_MinhaConta($_POST);

        // Chama Metodo
        $resultadoFinal = $classe->franquiasConfigFiscaisUpdate(); 
        
    }

}

/******************************************************************************/
/************************** MINHA CONTA > SEGURANCA ***************************/
/******************************************************************************/
if($acao == 'alterarSenha') {

    // FIND MODEL
    $model = carregarMVC($_QV['URL'],'models');
    if(file_exists($model)) {

        // INCLUDE MODEL
        include $model;        

        // Instância Class
        $classe = new QV_MinhaConta($_POST);

        // Chama Metodo
        $resultadoFinal = $classe->alterarSenha(); 
        
    }

}


echo json_encode($resultadoFinal);
?>