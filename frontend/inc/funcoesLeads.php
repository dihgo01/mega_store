<?php
header("Content-type: text/html; charset=utf-8");

// DEFAULT
include "functions.php";
$conexao = bancoDados("conectar");

// BANCO DADOS ERROS
$_SESSION['BD_ERROS'] = array();

// CAPTURA REQUESTS
$acao = checarAcao($_SERVER['REQUEST_METHOD']);

/******************************************************************************/
/***************************** NOME DA ACAO ***********************************/
/******************************************************************************/
if($acao == "nomeAcao") {

    // SQL QUERY
    // ...

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexao);  

    // VALIDACAO FINAL                 
    if($variavel) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Mensagem de Sucesso Sucesso');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Mensagem de Erro. Contate o Suporte!', 'erro'=>$erro);
    }	    

	echo json_encode($resultadoFinal);      

} // nomeAcao
?>