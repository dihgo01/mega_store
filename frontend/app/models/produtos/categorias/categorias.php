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
/******************************* NOVA CATEGORIA *******************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "POST" && empty($_POST['_method'])) {

    // RECEBE DADOS
    $nome           = anti_injection($_POST['nome']);
    $codigo         = anti_injection($_POST['codigo']);
    $peso_liquido   = converterPontuacoes(anti_injection($_POST['peso_liquido']),',','.','.');
    $peso_bruto     = converterPontuacoes(anti_injection($_POST['peso_bruto']),',','.','.');
    $altura         = converterPontuacoes(anti_injection($_POST['altura']),',','.','.');
    $largura        = converterPontuacoes(anti_injection($_POST['largura']),',','.','.');
    $comprimento    = converterPontuacoes(anti_injection($_POST['comprimento']),',','.','.');
    $slug           = ConverteURL($nome);

    // CHECA SLUG EXISTE
    $consulta = mysqli_query($conexaoIntranetNova,"SELECT * FROM produtosCategorias WHERE slug = '".$slug."' ");
    if(mysqli_num_rows($consulta) == 0) {

        // SQL INSERT - CATEGORIA
        $adicionar = mysqli_query($conexaoIntranetNova, "INSERT INTO produtosCategorias (nome, slug, codigo, peso_liquido, peso_bruto, altura, largura, comprimento, dataInsert) VALUES ('".$nome."', '".$slug."', '".$codigo."', '".$peso_liquido."', '".$peso_bruto."', '".$altura."', '".$largura."', '".$comprimento."', NOW())");

        // ARMAZENA MENSAGEM ERRO
        $bd_erros = bd_log_error($conexaoIntranetNova);         

    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Já existe uma categoria com nome igual.');
    }

    // VALIDACAO FINAL                 
    if($adicionar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro gerado com sucesso.');
    } else {
        if(!isset($resultadoFinal)) {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível realizar o cadastro. Contate o Suporte!', 'erro'=> $bd_erros);
        }
    }	    

	echo json_encode($resultadoFinal);      

} // NOVA CATEGORIA - POST

/******************************************************************************/
/*************************** ATUALIZAR CATEGORIA ******************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['_method'] === "PUT") {

    // RECEBE DADOS
    $idCategoria    = anti_injection($_POST['idCategoria']);
    $nome           = anti_injection($_POST['nome']);
    $codigo         = anti_injection($_POST['codigo']);
    $peso_liquido   = converterPontuacoes(anti_injection($_POST['peso_liquido']),',','.','.');
    $peso_bruto     = converterPontuacoes(anti_injection($_POST['peso_bruto']),',','.','.');
    $altura         = converterPontuacoes(anti_injection($_POST['altura']),',','.','.');
    $largura        = converterPontuacoes(anti_injection($_POST['largura']),',','.','.');
    $comprimento    = converterPontuacoes(anti_injection($_POST['comprimento']),',','.','.');    

    // SQL - UPDATE
    $atualizar = mysqli_query($conexaoIntranetNova, "UPDATE produtosCategorias SET nome = '".$nome."', codigo = '".$codigo."', peso_liquido = '".$peso_liquido."', peso_bruto = '".$peso_bruto."', altura = '".$altura."', largura = '".$largura."', comprimento = '".$comprimento."' WHERE idCategoria = '".$idCategoria."' ");

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexaoIntranetNova);   

    // VALIDACAO FINAL                 
    if($atualizar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro Atualizado com Sucesso.');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível atender sua solicitação. Contate o Suporte!', 'erro'=> $bd_erros);
    }	    

	echo json_encode($resultadoFinal);      

} // ATUALIZAR CATEGORIA - PUT

/******************************************************************************/
/****************************** APAGAR CATEGORIA ******************************/
/******************************************************************************/
if($_SERVER['REQUEST_METHOD'] === "DELETE") {

    // RECEBE DADOS
    parse_str(file_get_contents("php://input"),$_DELETE);
    $idCategoria  = anti_injection($_DELETE['idItem']);

    // SQL - UPDATE
    $apagar = mysqli_query($conexaoIntranetNova, "UPDATE produtosCategorias SET status = 'Inativo', dataDelete = NOW() WHERE idCategoria = '".$idCategoria."' ");

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexaoIntranetNova);   

    // VALIDACAO FINAL                 
    if($apagar) {
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cadastro apagado com sucesso.');
    } else {
        $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não possível atender sua solicitação. Contate o Suporte!', 'erro'=> $bd_erros);
    }	    

	echo json_encode($resultadoFinal);      

} // APAGAR CATEGORIA - DELETE
?>