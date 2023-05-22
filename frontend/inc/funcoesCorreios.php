<?php
header("Content-type: text/html; charset=utf-8");

include "functions.php";
$conexao = bancoDados("conectar","nova_intranet");

// BANCO DADOS ERROS
$_SESSION['BD_ERROS'] = array();

$acao = checarAcao($_SERVER['REQUEST_METHOD']);

/******************************************************************************/
/**************** PESQUISAR CIDADES COM BASE EM ESTADO ************************/
/******************************************************************************/

if($acao == "buscarCidades") {

	$uf = anti_injection($_POST['uf']);

	$listaCidades = "";
	$buscarCidades = mysqli_query($conexao, "SELECT * FROM CORREIOS_cidades WHERE uf = '".$uf."' AND status = 'Ativo' ORDER BY nome ASC ");
	WHILE($resultadoCidades = mysqli_fetch_array($buscarCidades)) {
		$listaCidades .= '<option value="'.$resultadoCidades['idCidade'].'">'.$resultadoCidades['nome'].'</option>';
	}

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexao);  

	if($buscarCidades) {
		$resultadoFinal = array('resultado'=>true, 'mensagem'=>'Cidades Carregadas com Sucesso', 'listaCidades'=> $listaCidades, 'erro'=>$erro);
	} else {
		$resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Carregar Cidades. Tente mais tarde ou contate o Suporte.', 'erro'=>$erro);
	}	

	echo json_encode($resultadoFinal);  	

} // buscarCidades

/******************************************************************************/
/************************ CONSULTA PELO CEP ***********************************/
/******************************************************************************/

if($acao == "consultaCEP") {

	$cep = anti_injection(limpar($_POST['cep']));

	// BUSCA PELO CEP
	$consultaCEP = mysqli_query($conexao, "SELECT L.`nome` AS LOGRADOURO, B.`nome` AS BAIRRO, C.`nome` AS CIDADE, C.`uf` AS ESTADO, C.`idCidade` AS ID_CIDADE, E.`idEstado` AS ID_ESTADO, L.complemento AS COMPLEMENTO, L.tipo AS TIPO, CONCAT(L.tipo,' ',L.`nome`) AS ENDERECO_FINAL
	FROM CORREIOS_logradouros L
	INNER JOIN `CORREIOS_cidades` C ON C.`LOC_NU` = L.`LOC_NU`
	INNER JOIN `CORREIOS_estados` E ON E.`uf` = L.`uf`
	INNER JOIN `CORREIOS_bairros` B ON B.`BAI_NU` = L.`BAI_NU_INI`
	WHERE L.`cep` = '".$cep."' LIMIT 1 ");
	$resultadoCEP = mysqli_fetch_array($consultaCEP);

	// ENCONTRA OS ESTADOS
	$listaEstados = "";
	$buscarEstados = mysqli_query($conexao, "SELECT * FROM CORREIOS_estados WHERE status = 'Ativo' ORDER BY nome ASC ");
	WHILE($resultadoEstados = mysqli_fetch_array($buscarEstados)) {
		$listaEstados .= '<option value="'.$resultadoEstados['idEstado'].'" data-uf="'.$resultadoEstados['uf'].'" '.preencherSelect($resultadoCEP['ID_ESTADO'],$resultadoEstados['idEstado']).'>'.$resultadoEstados['nome'].'</option>';
	}	

	// ENCONTRA AS CIDADES
	$listaCidades = "";
	$buscarCidades = mysqli_query($conexao, "SELECT * FROM CORREIOS_cidades WHERE uf = '".$resultadoCEP['ESTADO']."' AND status = 'Ativo' ORDER BY nome ASC ");
	WHILE($resultadoCidades = mysqli_fetch_array($buscarCidades)) {
		$listaCidades .= '<option value="'.$resultadoCidades['idCidade'].'" '.preencherSelect($resultadoCEP['ID_CIDADE'],$resultadoCidades['idCidade']).'>'.$resultadoCidades['nome'].'</option>';
	}

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexao);  

	// CONTEUDO FINAL
	$conteudo = array('logradouro'=> $resultadoCEP['ENDERECO_FINAL'], 'bairro'=> $resultadoCEP['BAIRRO'], 'complemento'=> $resultadoCEP['COMPLEMENTO'], 'listaEstados'=> $listaEstados, 'listaCidades'=> $listaCidades);

	// RESULTADO FINAL
	if($consultaCEP && $buscarEstados && $buscarCidades) {
		$resultadoFinal = array('resultado'=>true, 'mensagem'=>'Dados Carregados com Sucesso', 'conteudo'=>$conteudo, 'erro'=>$erro);
	} else {
		$resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Carregar Cidades. Tente mais tarde ou contate o Suporte.', 'erro'=>$erro);
	}	

	echo json_encode($resultadoFinal);  	

} // consultaCEP

/******************************************************************************/
/********************** CONSULTA CIDADE PELO CEP ******************************/
/******************************************************************************/

if($acao == "consultaCidadeCEP") {

	$cep 	= anti_injection(limpar($_POST['cep']));
	$email 	= anti_injection($_POST['email']);

	// BUSCA PELO CEP 
	$consultaCEP = mysqli_query($conexao, "SELECT CC.`idCidade` AS ID_CIDADE, CC.`nome` AS CIDADE, CE.idEstado AS ID_ESTADO 
								FROM CORREIOS_cidades CC
								LEFT JOIN CORREIOS_logradouros CL on CL.`LOC_NU` = CC.`LOC_NU`
								LEFT JOIN CORREIOS_estados CE ON CE.uf = CC.uf
								WHERE (CL.cep = '".$cep."' OR CC.cep = '".$cep."') LIMIT 1 ");
	$resultadoCEP = mysqli_fetch_array($consultaCEP);

    // ARMAZENA MENSAGEM ERRO
    $bd_erros = bd_log_error($conexao);  

	// ADD LEAD
	$addLead = mysqli_query($conexao, "INSERT INTO carrinho_abandonado (email, cep, cidade, estado, ip, dataInsert) VALUES ('".$email."', '".$cep."', '".$resultadoCEP['ID_CIDADE']."', '".$resultadoCEP['ID_ESTADO']."', '".$_SERVER['REMOTE_ADDR']."', NOW())");	

	if($consultaCEP) {

		if($resultadoCEP['ID_CIDADE'] == 10413 || $resultadoCEP['ID_CIDADE'] == 10599) {
			$resultadoFinal = array('resultado'=>true, 'mensagem'=>'Ah que legal. Você mora em <strong>'.$resultadoCEP['CIDADE'].'</strong>, essa cidade é o máximo!', 'ID_CIDADE'=>$resultadoCEP['ID_CIDADE'], 'CIDADE'=>$resultadoCEP['CIDADE'], 'redirect'=>false, 'erro'=>$erro);
		} else {
			$resultadoFinal = array('resultado'=>false, 'mensagem'=>'Poxa, nós ainda não estamos em <strong>'.$resultadoCEP['CIDADE'].'</strong>. Mas com certeza em breve estaremos. Aproveite nosso blog enquanto isso. Abraços.', 'redirect'=>true, 'erro'=>$erro);
		}

	} else {
		$resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Consultar este CEP. Tente mais tarde ou contate o Suporte.', 'redirect'=>false, 'erro'=>$erro);
	}	

	echo json_encode($resultadoFinal);  	

} // consultaCidadeCEP
?>