<?php
header("Content-type: text/html; charset=utf-8");

// INCLUDE
include_once($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");

// BANCO DADOS
$conexaoIntranetNova = bancoDados("conectar","intranetNova");

// BANCO DADOS ERROS
$_SESSION['BD_ERROS'] = array();

// CAPTURA REQUESTS
$acao = checarAcao($_SERVER['REQUEST_METHOD']);

// TRATANDO _METHOD
if(!isset($_POST['_method'])) {
    $_POST['_method'] = "";
}

/******************************************************************************/
/*************************** NOVA ALTURA SALTO ********************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "POST" && empty($_POST['_method'])) {

    // RECEBE DADOS
    $nome           = anti_injection($_POST['nome']);
    $codigo         = anti_injection($_POST['codigo']);

    // SQL INSERT - COR
    $adicionar = mysqli_query($conexaoIntranetNova, "INSERT INTO produtosAlturaSaltos (nome, codigo, dataInsert) VALUES ('".$nome."', '".$codigo."', NOW())");

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexaoIntranetNova);

    // VALIDACAO FINAL                 
    if($adicionar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro gerado com sucesso.');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível realizar o cadastro. Contate o Suporte!', 'erro'=> $bd_erros);
    }	    

	echo json_encode($resultadoFinal);      

} // NOVA ALTURA SALTO - POST

/******************************************************************************/
/************************* ATUALIZAR ALTURA SALTO *****************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['_method'] === "PUT") {

    // RECEBE DADOS
    $idRegistro     = anti_injection($_POST['idRegistro']);
    $nome           = anti_injection($_POST['nome']);
    $codigo         = anti_injection($_POST['codigo']); 

    // SQL - UPDATE
    $atualizar = mysqli_query($conexaoIntranetNova, "UPDATE produtosAlturaSaltos SET nome = '".$nome."', codigo = '".$codigo."' WHERE idAltura = '".$idRegistro."' ");

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexaoIntranetNova);   

    // VALIDACAO FINAL                 
    if($atualizar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro Atualizado com Sucesso.');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível atender sua solicitação. Contate o Suporte!', 'erro'=> $bd_erros);
    }	    

	echo json_encode($resultadoFinal);      

} // ATUALIZAR ALTURA SALTO - PUT

/******************************************************************************/
/*************************** APAGAR ALTURA SALTO ******************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "DELETE") {

    // RECEBE DADOS
    parse_str(file_get_contents("php://input"),$_DELETE);
    $idRegistro  = anti_injection($_DELETE['idItem']);

    // SQL - UPDATE
    $apagar = mysqli_query($conexaoIntranetNova, "UPDATE produtosAlturaSaltos SET status = 'Inativo', dataDelete = NOW() WHERE idAltura = '".$idRegistro."' ");

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexaoIntranetNova);   

    // VALIDACAO FINAL                 
    if($apagar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro Apagado com Sucesso.');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível atender sua solicitação. Contate o Suporte!', 'erro'=> $bd_erros);
    }	    

	echo json_encode($resultadoFinal);      

} // APAGAR ALTURA SALTO - DELETE
?>