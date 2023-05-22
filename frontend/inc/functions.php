<?php
// SESSION
session_start();

//////////////////////////////////////////////////////
/***  FUNCAO PARA CONECTAR COM O BANCO DE DADOS ***/
/////////////////////////////////////////////////////
function bancoDados($comando, $conexao = false) {

	//$MODO_CONEXAO = "PROD"; // DEV PROD

	if($comando == "conectar") {
		include "conexao.php";
		return $conexaoBD;	
	} else {
		return false;
	}

}

//////////////////////////////////////////////////////
/**********  FUNCAO GERAR DADOS DO PROJETO **********/
/////////////////////////////////////////////////////
function projetoDados() {

	// DEFININDO GLOBAL
	global $_QV;	

	$_QV['PROJETO'] = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/projeto.env');

}

//////////////////////////////////////////////////////
/***  DEFININDO IDIOMA PARA A APLICACAO ***/
/////////////////////////////////////////////////////
function IDIOMA() {

	// DEFININDO GLOBAL
	global $_QV;

	if(!isset($_QV['IDIOMA'])){
		$idioma = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		if(file_exists(strtolower($idioma[0]).'.lang')) {
			$_QV['IDIOMA'] = parse_ini_file(strtolower($_SERVER['DOCUMENT_ROOT'].'/inc/idiomas/'.$idioma[0]).'.lang');
		} else {
			$_QV['IDIOMA'] = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/inc/idiomas/pt-br.lang');
		}
	} elseif(isset($_GET['lang'])) {
		$_QV['IDIOMA'] = parse_ini_file(strtolower($_SERVER['DOCUMENT_ROOT'].'/inc/idiomas/'.$_GET['lang']).'.lang');
	} else {
		$_QV['IDIOMA'] = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/inc/idiomas/pt-br.lang');
	}

}

//////////////////////////////////////////////////////
/***************  TRATANDO A URL ********************/
/////////////////////////////////////////////////////
function url_friendly($capturaURL, $URI) {

	// DEFININDO GLOBAL
	global $_QV;	

	// DEFINE URI
	$_QV['URL']['uri'] = $URI;
	$_QV['URL']['full'] = $_SERVER['SERVER_NAME'].$URI;	

	/* MANIPULA CADA PARTE DA URL */
	if(sizeof($capturaURL) > 1) {
		$_QV['URL']['PG'] = $capturaURL[1];
		$_QV['URL']['parametros']['var1'] = $capturaURL[1];
	} else { $_QV['URL']['parametros']['var1'] = false; }
	if(sizeof($capturaURL) > 2) {
		$_QV['URL']['parametros']['var2'] = $capturaURL[2];
	} else { $_QV['URL']['parametros']['var2'] = false; }
	if(sizeof($capturaURL) > 3) {
		$_QV['URL']['parametros']['var3'] = $capturaURL[3];
	} else { $_QV['URL']['parametros']['var3'] = false; }
	if(sizeof($capturaURL) > 4) {
		$_QV['URL']['parametros']['var4'] = $capturaURL[4];
	} else { $_QV['URL']['parametros']['var4'] = false; }
	if(sizeof($capturaURL) > 5) {
		$_QV['URL']['parametros']['var5'] = $capturaURL[5];
	} else { $_QV['URL']['parametros']['var5'] = false; }
	if(sizeof($capturaURL) > 6) {
		$_QV['URL']['parametros']['var6'] = $capturaURL[6];
	} else { $_QV['URL']['parametros']['var6'] = false; }	
	
	// LISTA DE PAGINAS INDIVIDUAIS
	$listaPaginasIndividuais = array('login','novidades');

	// DEFININDO PAGINA PADRAO
	if(empty($_QV['URL']['PG'])) {
		$_QV['URL']['PG'] = "home.twig";
	} else {

		$_QV['URL']['PG'] = $capturaURL[1].".twig";
		
		/*if(in_array($_QV['URL']['parametros']['var1'],$listaPaginasIndividuais)) {
			$_QV['URL']['PG'] = $capturaURL[1].".twig";
		} else {
			$_QV['URL']['PG'] = $capturaURL[1]."/".$capturaURL[1].".twig";
		}*/
		
	}

}

/////////////////////////////////////////////////////
/**** FUNCAO PARA CARREGAR CONTROLLER ou MODEL *****/
/////////////////////////////////////////////////////
function carregarMVC($url_received,$target = false) {

	// URL BASE
	if(!$target || empty($target) || $target == 'controllers') {
		$url_base = $_SERVER['DOCUMENT_ROOT']."/app/controllers/";
	} else {
		$url_base = $_SERVER['DOCUMENT_ROOT']."/app/models/";
	}
	
	// VARIAVEIS
	$last_path = "";
	$end_foreach = false;
	$check_load_file = false;

	// CHECANDO URL RECEBIDA
	if($url_received['PG'] == "home.twig") {
		$url_base .= "home/home.php";
	} else {
		foreach($url_received['parametros'] AS $key => $value) {		

			if(!empty($value) && is_dir($url_base.$value)) {
				$url_base .= $value;
				$url_base .= "/";				
				$last_path = $value;
				clearstatcache();
			} else {
				if(!empty($value) && file_exists($url_base.$value.".php")) {
					$url_base .= $value;
					$url_base .= ".php";					
					$end_foreach = true;
					$check_load_file = true;

				} else {
					if(!empty($last_path) && file_exists($url_base.$last_path.".php")) {
						$url_base .= $last_path;
						$url_base .= ".php";						
						$end_foreach = true;
						$check_load_file = true;
					} else {
						$last_path = false;
					}				
				}				
			}

			if($end_foreach) {
				break;
			}

		}
	}

	if(!$check_load_file) {
		$url_base = false;
	}

	//logDebug($url_base);
	return $url_base;

}

/////////////////////////////////////////////////////
/*** FUNCAO PARA CHECAR ORIGEM DO VALOR DISPARADO ***/
/////////////////////////////////////////////////////
function checarAcao($requestType) {
	$acao = "";
	//Switch statement
	switch ($requestType) {
		case 'POST':
		if(isset($_POST['acao'])) {
			$acao = $_POST['acao'];
		} elseif(isset($_POST['formAcao'])) {
			$acao = $_POST['formAcao'];
		} else {
			$acao = "";
		}
		break;
		case 'GET':
		if(isset($_GET['acao'])) {
			$acao = $_GET['acao'];
		} elseif(isset($_GET['formAcao'])) {
			$acao = $_GET['formAcao'];
		} else {
			$acao = "";
		}
		break;
		case 'PUT':
		break;		
		case 'DELETE':
		//handle_delete_request();  
		break;
		default:
		$acao = $_POST['acao'];
		break;
	}
	return $acao;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA SEGURANÇA - EVITA SQL INJECTION ***/
/////////////////////////////////////////////////////
function anti_injection($variavel) {

	if(is_array($variavel)) {

		function myFunc($a) {
			$b = htmlspecialchars($a, ENT_QUOTES, 'UTF-8');
			$b = trim($a);
			$b = strip_tags($a);
			return $b;
		}
		  
		$variavel = array_map("myFunc", $variavel);		

	} else {

		$variavel = htmlspecialchars($variavel, ENT_QUOTES, 'UTF-8');
		$variavel = (!empty($variavel) ? trim($variavel) : $variavel);
		$variavel = (!empty($variavel) ? strip_tags($variavel) : $variavel);
		$variavel = filter_var($variavel, FILTER_SANITIZE_ADD_SLASHES);		

	}

	return $variavel;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA CONVERTER DATAS ***/
/////////////////////////////////////////////////////
function converterData($dataRecebida, $formatoConversao) {
	if($formatoConversao == "BR") {
		$data_temp = explode('-', $dataRecebida);
		$data = $data_temp[2].'/'.$data_temp[1].'/'.$data_temp[0];
		return $data;
	} elseif($formatoConversao == "EN") {
		$data_temp = explode('/', $dataRecebida);
		$data = $data_temp[2].'-'.$data_temp[1].'-'.$data_temp[0];
		return $data;
	} else {
		$data_temp = $dataRecebida;
		$data = implode("/", array_reverse(explode("-", substr($data_temp, 0, 10)))).substr($data_temp, 10);
		return $data;
	}
}

/////////////////////////////////////////////////////
// FUNCAO PARA GERAR NOME DO MES
/////////////////////////////////////////////////////
function nomeMes($mes) {

	switch ($mes) {
		case "01":    $mes = 'Janeiro';     break;
		case "02":    $mes = 'Fevereiro';   break;
		case "03":    $mes = 'Março';       break;
		case "04":    $mes = 'Abril';       break;
		case "05":    $mes = 'Maio';        break;
		case "06":    $mes = 'Junho';       break;
		case "07":    $mes = 'Julho';       break;
		case "08":    $mes = 'Agosto';      break;
		case "09":    $mes = 'Setembro';    break;
		case "10":    $mes = 'Outubro';     break;
		case "11":    $mes = 'Novembro';    break;
		case "12":    $mes = 'Dezembro';    break; 
	}	

	return $mes;

}

/////////////////////////////////////////////////////
/***  FUNCAO EXTRAIR DATA ***/
/////////////////////////////////////////////////////
function extrairData($dataRecebida) {	
	$s 		= $dataRecebida;
	$dt 	= new DateTime($s);

	$date 	= $dt->format('Y-m-d');
	$time 	= $dt->format('H:i:s');

	//$date = $dt->format('m/d/Y');
	//echo $date, ' | ', $time;

	return $date;
}

/////////////////////////////////////////////////////
/*** FUNCAO PARA LOG DEBUG ***/
/////////////////////////////////////////////////////
function logDebug($descricao) {
	$conexaoDB = bancoDados("conectar","intranet");
	mysqli_query($conexaoDB, "INSERT INTO logsDebug (descricao, ip, dataInsert) VALUES ('".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");
}

/////////////////////////////////////////////////////
/*** FUNCAO PARA LOGs FOCUS NFe / NFCe ***/
/////////////////////////////////////////////////////
function logsDebugFocus($idUnidade,$idVenda,$request,$response) {
	$conexaoDB = bancoDados("conectar","intranet");
	mysqli_query($conexaoDB, "INSERT INTO logsDebugFocus (idUnidade, idVenda, request, descricao, ip, dataInsert) VALUES ('".$idUnidade."', '".$idVenda."', '".$request."', '".$response."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

	// htmlspecialchars 
}

/////////////////////////////////////////////////////
/*** FUNCAO PARA LOG HISTORICO DAS VENDAS ***/
// ID DA VENDA + POST DOS INPUTS NO UPDATE DAS VENDA
// ACAO = preparar ou efetivar ou apagar
/////////////////////////////////////////////////////
function logVendas($acao,$idVenda,$idUsuario = false, $campos = false) {
	
	// BANCO DADOS
	$conexao = bancoDados("conectar","intranet");

	// ACAO - PREPARAR 
	if($acao == 'preparar') {

		//********** CONSULTA DA VENDA
		$consultaVenda = mysqli_query($conexao, "SELECT * FROM PDV_vendas WHERE idVenda = '".$idVenda."' ");
		$resVendas = mysqli_fetch_array($consultaVenda);

		//********** CHECANDO - VENDEDOR
		if($resVendas['idUsuario'] != $campos['vendedor']) {

			$descricao = 'Vendedor foi alterado de <b>'.$resVendas['idUsuario'].'</b> para <b>'.$campos['vendedor'].'</b>.';

			$logVendedor = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, dataInsert) VALUES ('".$idVenda."', '".$idUsuario."', '".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

		}

		//********** CHECANDO - CLIENTE
		if($resVendas['idCliente'] != $campos['idCliente']) {

			$descricao = 'Cliente foi alterado de <b>'.$resVendas['idCliente'].'</b> para <b>'.$campos['idCliente'].'</b>.';

			$logCliente = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, dataInsert) VALUES ('".$idVenda."', '".$idUsuario."', '".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

		}	
		
		//********** CHECANDO - PRODUTOS
		/* MONTA ARRAY DOS NOVOS PRODUTOS */
		$listaProdutosUpdate = array();
		for($U=0; $U<COUNT($campos['prodID']); $U++) {
			$listaProdutosUpdate[] = array(
				'id' 			=> $campos['prodID'][$U],
				'sku' 			=> $campos['prodSKU'][$U],
				'cor' 			=> $campos['prodCOR'][$U],
				'tamanho' 		=> $campos['prodTAMANHO'][$U],
				'quantidade'	=> $campos['prodQTD'][$U],
				'preco' 		=> $campos['prodPRECO'][$U]
			);
		}

		

		/* PERCORRE PRODUTOS ATUAIS PARA CHECAR SE EXISTEM NO NOVO ARRAY E ASSIM CONSIDERADAR QUE FORAM REMOVIDOS */
		$consultaProdutos = mysqli_query($conexao, "
			SELECT VP.idProduto AS PROD_ID, P.nome_comercial AS PROD_NOME, VP.cor AS PROD_COR, VP.tamanho AS PROD_TAMANHO, VP.quantidade AS PROD_QTD 
			FROM PDV_vendasProdutos VP
			INNER JOIN qv_produtos P ON  P.id = VP.idProduto
			WHERE VP.idVenda = '".$idVenda."' AND VP.status = 'Ativo' ");
		WHILE($resProdutos = mysqli_fetch_array($consultaProdutos)) {

			//$found_key = array_search($resProdutos['PROD_ID'], array_column($listaProdutosUpdate, 'id'));

			// BUSCA NO ARRAY NOVO SE O PRODUTO AINDA EXISTE
			$found_key = multi_array_search($listaProdutosUpdate, array('id' => $resProdutos['PROD_ID'], 'tamanho' => $resProdutos['PROD_TAMANHO']));

			// PERCORRE RESULTADO DA BUSCA SE EXISTIREM
			if(COUNT($found_key) > 0) {

				for($i=0; $i<COUNT($found_key); $i++) {

					// SE AS QUANTIDADES FOREM DIFERENTES, GERA O LOG E REMOVE DO ARRAY NOVO
					if($listaProdutosUpdate[$found_key[$i]]['quantidade'] != $resProdutos['PROD_QTD']) {

						$descricao = 'A quantidade do produto <b>'.$resProdutos['PROD_NOME'].' ('.$resProdutos['PROD_TAMANHO'].')</b> foi alterada de <b>'.$resProdutos['PROD_QTD'].'</b> para <b>'.$listaProdutosUpdate[$found_key[$i]]['quantidade'].' unidade(s)</b>.';

						$logProduto = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, dataInsert) VALUES ('".$idVenda."', '".$idUsuario."', '".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

					}

					//unset($listaProdutosUpdate[$found_key[$i]]);
					array_splice($listaProdutosUpdate,$found_key[$i],1);

				}

			// CASO NAO ENCONTRE NO NOVO ARRAY, ENTENDE QUE O PRODUTO COM RESPECTIVO TAMANHO FOI REMOVIDO
			} else {

				$descricao = 'Produto <b>'.$resProdutos['PROD_NOME'].' ('.$resProdutos['PROD_TAMANHO'].')</b> foi removido desta venda.';

				$logProduto = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, dataInsert) VALUES ('".$idVenda."', '".$idUsuario."', '".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

			}

		}		

		// PERCORRE FAZENDO AS ADICOES
		for($Q=0; $Q<COUNT($listaProdutosUpdate); $Q++) {	
			
			// CONSULTA DADOS DO PRODUTO
			$conProd = mysqli_query($conexao,"SELECT id, nome_comercial, cor_id, preco_custo, preco_sellout, preco_sellin FROM qv_produtos WHERE id = '".$listaProdutosUpdate[$Q]['id']."' ");
			$resProd = mysqli_fetch_array($conProd);			

			$descricao = 'O Produto <b>'.$resProd['nome_comercial'].' ('.$listaProdutosUpdate[$Q]['tamanho'].')</b> com <b>'.$listaProdutosUpdate[$Q]['quantidade'].' unidade(s)</b> foi adicionado nesta venda.';

			$logProduto = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, dataInsert) VALUES ('".$idVenda."', '".$idUsuario."', '".$descricao."', '".$_SERVER['REMOTE_ADDR']."', NOW())");

		}			

	} elseif($acao == 'efetivar') {

		$atualizar = mysqli_query($conexao, "UPDATE PDV_vendasLogs SET status = 'Ativo' WHERE idVenda = ".$idVenda." AND status = 'Pendente' ");

	} else {

		$apagar = mysqli_query($conexao, "DELETE FROM PDV_vendasLogs WHERE idVenda = ".$idVenda." AND status = 'Pendente' ");		

	}

}

/////////////////////////////////////////////////////
// COMPARAR ARRAYS
/////////////////////////////////////////////////////
function compararArray($array1,$array2) {
	if((is_array($array1) && is_array($array2) && array_diff($array1, $array2) === array_diff($array2, $array1))) {
		return true; // IGUAIS
	} else {
		return false; // DIFERENTE
	}
}

/////////////////////////////////////////////////////
// BUSCAR EM UM ARRAY MULTIDIMENSIONAL EM MULTIPLAS COLUNAS
/////////////////////////////////////////////////////
function multi_array_search($array, $search) {
	
	// Create the result array
	$result = array();
	
	// Iterate over each array element
	foreach ($array as $key => $value) {
	
		// Iterate over each search condition
		foreach ($search as $k => $v){
	
			// If the array element does not meet the search condition then continue to the next element
			if(!isset($value[$k]) || $value[$k] != $v){
				continue 2;
			}

		}

		// Add the array element's key to the result array
		$result[] = $key;
	
	}

	// Return the result array
	return $result;
}

/////////////////////////////////////////////////////
/*** FUNCAO PARA FORMATAR NUMERO DECIMAL ***/
/////////////////////////////////////////////////////
function numeroDecimal($numero,$casas) {
	if(empty($casas)) { $casas = 2; }
	return number_format($numero,$casas,",",".");
}

/////////////////////////////////////////////////////
/* FUNCAO PARA CONVERTER PONTUACOES e REMOVER CIFRAO */
/////////////////////////////////////////////////////
function converterPontuacoes($string,$atual,$substituto,$centenas = false) {

	if($centenas) { $nova_string = str_replace($centenas,'',$string); } else { $nova_string = $string; }
	$nova_string = str_replace('R$','',$nova_string);
	$nova_string = str_replace('kg','',$nova_string);
	$nova_string = str_replace('cm','',$nova_string);
	$nova_string = str_replace(' ','',$nova_string);
	$nova_string = str_replace($atual,$substituto,$nova_string);

	//$nova_string = str_replace($atual,$substituto,str_replace(' ','',str_replace('R$','',str_replace($centenas,'',$string))));

	return $nova_string;

}

/////////////////////////////////////////////////////
/***  FUNCAO PARA GERAR O ANO AUTOMATICAMENTE ***/
/////////////////////////////////////////////////////
function ano() {
	$gerarAno = date("Y", mktime(gmdate("H")-3, gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")));
	echo $gerarAno;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA PREENCHER CAMPOS SELECT ***/
/////////////////////////////////////////////////////
function preencherSelect($primeiroValor, $segundoValor) {
	if($primeiroValor == $segundoValor) {
		$selecionar = ' selected="selected" ';
	} else {
		$selecionar = '';
	}
	return $selecionar;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA ENCURTAR TEXTOS LONGOS ***/
/////////////////////////////////////////////////////
function encurtarTexto($textoEnviado, $tamanhoLimite) {
	return (strlen(strip_tags($textoEnviado)) > $tamanhoLimite) ? substr(strip_tags($textoEnviado), 0, $tamanhoLimite).'...' : $textoEnviado;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA COMPRIMIR IMAGENS COM BASE NO PHP GD ***/
/////////////////////////////////////////////////////
function comprimirImagem($pastaOrigem, $pastaDestino, $qualidade) {

	$info = getimagesize($pastaOrigem);

	if ($info['mime'] 		== 'image/jpeg') $image 	= imagecreatefromjpeg($pastaOrigem);
	elseif ($info['mime'] 	== 'image/gif') $image 		= imagecreatefromgif($pastaOrigem);
	elseif ($info['mime'] 	== 'image/png') $image 		= imagecreatefrompng($pastaOrigem);

	//save it
	imagejpeg($image, $pastaDestino, $qualidade);

	//return destination file url
	//return $destination_url;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA REMOVER ACENTOS ***/
/////////////////////////////////////////////////////
function removeAcentos($texto) {
	$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
	, "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
	$array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
	, "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
		$texto = str_replace( $array1, $array2, $texto);
		$texto = preg_replace("/[^a-z0-9\s\-]/i", "", $texto);
		//$texto = preg_replace("/\s/", "_", $texto); // Replace all spaces with underline
	return $texto;
}


/////////////////////////////////////////////////////
// CONVERTE STRING EM URL AMIGÁVEL
/////////////////////////////////////////////////////
function ConverteURL($str){
	$str = str_replace("'", "",$str);
	$str = str_replace("\"", "",$str);
	$str = str_replace("º", "",$str);
	$str = str_replace("ª", "",$str);
	$str = str_replace(".", "",$str);
	$str = str_replace("@", "",$str);
	$str = str_replace("/", "",$str);
	$str = str_replace("\\", "",$str);
	$str = str_replace("-", "",$str);
	$str = str_replace("_", "",$str);
	$str = str_replace("^", "",$str);
	$str = str_replace("~", "",$str);
	$str = strtolower( strip_tags( preg_replace( array( '/[\/`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', removeAcentos($str) ) ) ) );
	return $str;
}

/////////////////////////////////////////////////////
/***  FUNCAO PARA LIMPAR STRINGS, REMOVENDO SIMBOLOS ***/
/////////////////////////////////////////////////////
function limpar($limparStringRecebida) {
	$limparStringRecebida = (!empty($limparStringRecebida) ? trim($limparStringRecebida) : "");
	$limparStringRecebida = str_replace("-", "", $limparStringRecebida);
	$limparStringRecebida = str_replace(",", "", $limparStringRecebida);
	$limparStringRecebida = str_replace("/", "", $limparStringRecebida);
	$limparStringRecebida = str_replace("(", "", $limparStringRecebida);
	$limparStringRecebida = str_replace(" ", "", $limparStringRecebida);
	$limparStringRecebida = str_replace(")", "", $limparStringRecebida);
	$limparStringRecebida = str_replace(".", "", $limparStringRecebida);
	return $limparStringRecebida;
}

/////////////////////////////////////////////////////
// FUNCAO MASCARA - MASK PHP
/////////////////////////////////////////////////////
function maskPHP($val, $mask) {
	$maskared = '';
	$k = 0;
	for($i = 0; $i<=strlen($mask)-1; $i++) {
		if($mask[$i] == '#') {
			if(isset($val[$k])) {
				$maskared .= $val[$k++];
			}
		} else {
			if(isset($mask[$i])) {
				$maskared .= $mask[$i];
			}
		}
	}
	return $maskared;

	/*
	$cnpj = "11222333000199";
	$cpf = "00100200300";
	$cep = "08665110";
	$data = "10102010";
	
	echo mask($cnpj,'##.###.###/####-##');
	echo mask($cpf,'###.###.###-##');
	echo mask($cep,'#####-###');
	echo mask($data,'##/##/####'); */	
}

/////////////////////////////////////////////////////
// FUNCAO PARA FOCAR CACHE ARQUIVOS
/////////////////////////////////////////////////////
function versaoArquivo() {
	$ts = '?ts='.date('Y-m-d-H-i-s');	
 	return $ts;	
}

/////////////////////////////////////////////////////
// FUNCAO CHECK VAZIO OU NULL
/////////////////////////////////////////////////////
function checkVazio($valor) {
	if(empty($valor) || is_null($valor)) {
		return 0;
	} else {
		return $valor;
	}
}

/////////////////////////////////////////////////////
// FUNCAO LOGS ERRO MYSQL
/////////////////////////////////////////////////////
function bd_log_error($conexao) {

	// CAPTURA DADOS
	$codigoErro 	= mysqli_errno($conexao);
	$mensagemErro 	= mysqli_error($conexao);

	if($codigoErro != 0 || !empty($codigoErro)) {
		$erro = $codigoErro.": ".$mensagemErro;
		array_push($_SESSION['BD_ERROS'],$erro);
	}
	
	return $_SESSION['BD_ERROS'];
}

/////////////////////////////////////////////////////////////////
/***  FUNCAO GERAR IMAGENS DE PRODUTOS A PARTIR DA INTRANET ***/
////////////////////////////////////////////////////////////////
function qvImagens_Intranet($idProduto, $dimensoes = false, $modo = false) {

	// CONECTA COM BANCO
	$conexaoIntranet = bancoDados("conectar","intranet");

	// ARRAY IMAGENS
	$lista_imagens = array();
	
	// URL QUE GERA IMAGEM DA INTRANET ANTIGA
	$url_requisitada = "https://franquia.quintavalentina.com.br/products/thumb";	

	// MODO IMAGENS - fit, fill, resize e crop
	if(!$modo) {
		$modo = "fill";
	}

	// DIMENSOES
	if(!$dimensoes) {
		$dimensoes = "800/800";	
	}
	$dimensoesAlt = explode("/",$dimensoes);

	// CONSULTA IMAGENS
	$consultaImagem = mysqli_query($conexaoIntranet, "SELECT GROUP_CONCAT(nome) AS ARQUIVO FROM qv_produtos_imagens WHERE produto_id = '".$idProduto."' ");
	$resImagem = mysqli_fetch_array($consultaImagem);
	$imagens_produtos = explode(",",$resImagem['ARQUIVO']);	

	// CONSULTA DADOS PRODUTO
	$consultaProduto = mysqli_query($conexaoIntranet, "SELECT id AS ID_PRODUTO, slug AS SLUG FROM qv_produtos WHERE id = '".$idProduto."' ");
	$resProd = mysqli_fetch_array($consultaProduto);

	// PERCORRE EXPLODE POPULANDO NOVO ARRAY
	if(!empty($imagens_produtos[0])) {
		for($i=0; COUNT($imagens_produtos) > $i; $i++) {

			// MONTA URL
			$url_final = $url_requisitada.'/'.$idProduto.'/'.$dimensoes.'/'.$modo.'/'.$imagens_produtos[$i];

			// ADD NO ARRAY
			array_push($lista_imagens,$url_final);

		}			

	}	

	// ANALISA SE OCORREU TUDO CERTO
	if(empty($lista_imagens)) {
		$lista_imagens = array('/assets/images/sem_foto.jpg','/assets/images/sem_foto.jpg');
	}

	return $lista_imagens;

}


/////////////////////////////////////////////////////////////////
/***  FUNCAO PEGAR DADOS DO PRODUTO NA INTRANET ***/
////////////////////////////////////////////////////////////////
function qvProdutosInfo_Intranet($idProduto) {

	// CONECTA COM BANCO
	$conexaoIntranet = bancoDados("conectar","intranet");	

	// CONSULTA DADOS PRODUTO
	$consultaProduto = mysqli_query($conexaoIntranet, "SELECT P.id AS ID_PRODUTO, P.slug AS SLUG, P.nome_comercial AS NOME, C.nome AS CATEGORIA FROM qv_produtos P INNER JOIN qv_categorias C ON C.id = P.categoria_id WHERE P.id = '".$idProduto."' ");
	$resProd = mysqli_fetch_array($consultaProduto);
	
	// GERANDO IMAGEM
	$produto_foto = qvImagens_Intranet($resProd['ID_PRODUTO']);
	
	// ARRAY DADOS DO PRODUTO
	$produtoInfo = array('ID' => $resProd['ID_PRODUTO'], 'NOME' => $resProd['NOME'], 'CATEGORIA' => $resProd['CATEGORIA'], 'SLUG' => $resProd['SLUG'], 'FOTO' => $produto_foto[0]);

	// RETORNO
	return $produtoInfo;

}

/////////////////////////////////////////////////////
// FUNCAO CONSULTA ESTOQUE x GRADE - INTRANET
/////////////////////////////////////////////////////
function intranetEstoqueGrade($produto_id,$grade = false) {

    // BANCO DADOS
    $conexaoIntranetAntiga  = bancoDados("conectar","intranet"); 

	// RESULTADO GRADES
	$resGrades = array();
	$saldoTotal = 0;

	// QUERY COM GRADE
	if($grade) {
		$queryGrade = " AND G.codigo = '".$grade."' ";
	} else {
		$queryGrade = "";
	}	
	
	// CONSULTA
	$consulta = mysqli_query($conexaoIntranetAntiga, "SELECT PE.produto_id AS ID_PRODUTO, 
	(COALESCE(sum(CASE WHEN ( PE.tipo = 'entrada' ) THEN PE.quantidade ELSE 0 END),0) - COALESCE(sum(CASE WHEN ( PE.tipo = 'saida' ) THEN PE.quantidade ELSE 0 END),0)) AS SALDO_ATUAL,
	G.codigo AS GRADE, PE.preco_ecommerce AS PRECO 
	FROM qv_produtos_estoques PE
	INNER JOIN qv_produtos_grades PG ON PG.id = PE.produto_grade_id
	INNER JOIN qv_grades G ON G.id = PG.grade_id
	INNER JOIN qv_produtos P ON P.id = PE.produto_id
	WHERE PE.loja_id IN(1,137) AND PE.ativado = 1 AND PE.deleted_at IS NULL AND P.ativado = 1 AND P.ecommerce = 1 AND PE.produto_id = ".$produto_id." ".$queryGrade." GROUP BY GRADE ORDER BY GRADE ASC");
	$resGrades['RESULTADOS'] = mysqli_num_rows($consulta);
	if(mysqli_num_rows($consulta) > 0) {
		WHILE($resultado = mysqli_fetch_array($consulta)) {
			$resGrades['ITENS'][] = array('GRADE'=> $resultado['GRADE'], 'SALDO'=> $resultado['SALDO_ATUAL']);
			$saldoTotal += $resultado['SALDO_ATUAL'];
		}
		$resGrades['SALDO_GERAL'] = $saldoTotal;
	}

	return $resGrades;

}

/////////////////////////////////////////////////////
// FUNCAO CONSULTA ESTOQUE x GRADE - VITRINE
/////////////////////////////////////////////////////
function vitrineEstoqueGrade($produto_id,$unidade_id,$grade = false) {

    // BANCO DADOS
    $conexaoIntranetAntiga  = bancoDados("conectar","intranet"); 

	// RESULTADO GRADES
	$resGrades = array();
	$saldoTotal = 0;

	// QUERY COM GRADE
	if($grade) {
		$queryGrade = " AND E.tamanho = '".$grade."' ";
	} else {
		$queryGrade = "";
	}
	
	// CONSULTA
	$consulta = mysqli_query($conexaoIntranetAntiga, "SELECT E.idProduto AS ID_PRODUTO, 
	COALESCE(sum(E.quantidade),0) AS SALDO_ATUAL, E.tamanho AS GRADE 
	FROM PDV_estoque E
	WHERE E.idProduto = ".$produto_id." AND E.idUnidade = ".$unidade_id." ".$queryGrade." GROUP BY GRADE ORDER BY GRADE ASC");
	$resGrades['RESULTADOS'] = mysqli_num_rows($consulta);
	if(mysqli_num_rows($consulta) > 0) {
		WHILE($resultado = mysqli_fetch_array($consulta)) {

			$sku = geradorSKU($resultado['ID_PRODUTO'], $resultado['GRADE']);

			$resGrades['ITENS'][] = array('GRADE'=> $resultado['GRADE'], 'SALDO'=> $resultado['SALDO_ATUAL'], 'SKU' => $sku);
			$saldoTotal += $resultado['SALDO_ATUAL'];
			
		}
		$resGrades['SALDO_GERAL'] = $saldoTotal;
	}

	return $resGrades;

}

/////////////////////////////////////////////////////
// FUNCAO CONSULTA ESTOQUE x GRADE
/////////////////////////////////////////////////////
function protheusEstoqueGrade($produto_id, $grade = false) {

	// URL PARA DISPARO
	$urlRequisitada = "177.93.109.202:8079/rest/SALDOSB2";  

	// VALIDANDO REQUISITOS PARA EXECUTAR
	if(empty($urlRequisitada) || empty($produto_id)) {

		return false;

	} else {

		// FILTROS
		$protheusFiltros = array(
			'cFil' 		=> '026801',
			'cCod' 		=> $produto_id,
			'cGrade' 	=> (!empty($grade) ? $grade : ''),
			'cArmazem' 	=> '01'
		);		

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $urlRequisitada."?".http_build_query($protheusFiltros));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		// CURL CALL
		$res 	  		= curl_exec($ch);
		$httpcode 		= curl_getinfo($ch, CURLINFO_HTTP_CODE); 
		$contentType 	= curl_getinfo($ch, CURLINFO_CONTENT_TYPE);	
		
		// Close the cURL handle.
		curl_close($ch);    

		// TRANSFORMANDO RETORNO
		$resposta = json_decode($res, true);

		$retorno = array('HTTP_CODE'=>$httpcode,'CONTEUDO'=>$resposta);

		// EM CASO DE SUCESSO
		if($retorno['HTTP_CODE'] == 200 && COUNT($retorno['CONTEUDO']) > 0) {
			return $retorno['CONTEUDO'];
		} else {
			return false;
		}

	}

}

/////////////////////////////////////////////////////
// GERADOR SKU
/////////////////////////////////////////////////////
function geradorSKU($idProduto,$grade) {

	// BANCO DADOS
	$conexao  = bancoDados("conectar","intranet"); 

	// TRATAMENTO
	$grade = str_pad($grade, 2, '0', STR_PAD_LEFT);

	// CONSULTA PRODUTO
	$consulta = mysqli_query($conexao, "SELECT F.codigo AS FORNECEDOR, C.codigo AS CATEGORIA, C2.codigo AS COR, P.codigo AS PRODUTO 
						FROM qv_produtos P
						INNER JOIN qv_fornecedores F ON F.id = P.fornecedor_id
						INNER JOIN qv_categorias C ON C.id = P.categoria_id
						INNER JOIN qv_cores C2 ON C2.id = P.cor_id
						WHERE P.id = '".$idProduto."' ");
	$resultado = mysqli_fetch_array($consulta);

	$sku = $resultado['FORNECEDOR'].$resultado['CATEGORIA'].$resultado['COR'].$grade.$resultado['PRODUTO'];

	if(strlen($sku) == 14) {
		return $sku;
	} else {
		return false;
	}

}

/////////////////////////////////////////////////////
// PEGA ID DE PEDIDO ABERTO
/////////////////////////////////////////////////////
function consultaPedido() {

	// BANCO DADOS
	$conexao = bancoDados("conectar","intranet"); 

	// VARIAVEIS IMPORTANTES
	$QV_Unidade = $_SESSION['Authentication']['franquias'][$_SESSION['Authentication']['franquiaActive']]['unidade'];
	$QV_idUsuario = $_SESSION['Authentication']['id_usuario'];
	
	// ACESSO COM PRIVILEGIOS PARA CONSULTA
	if($_SESSION['Authentication']['nivel'] == 1 || $_SESSION['Authentication']['nivel'] == 5) {
		$queryCustom = "P.idUnidade = ".$QV_Unidade;
	} else {
		$queryCustom = "P.idUnidade = ".$QV_Unidade." AND P.idUsuario = ".$QV_idUsuario;
	}

	// CONSULTA PEDIDO ABERTO
	$consulta = mysqli_query($conexao, "SELECT P.idPedido AS ID_PEDIDO
							FROM PDV_pedidos P
							WHERE ".$queryCustom." AND P.status = 'Ativo' AND P.dataDelete IS NULL");
	$resConsulta = mysqli_fetch_array($consulta);
	if(mysqli_num_rows($consulta) == 0) {

		// SQL INSERT - NOVO PEDIDO
		$adicionar = mysqli_query($conexao, "INSERT INTO PDV_pedidos (idUnidade, idUsuario, dataInsert) VALUES (".$QV_Unidade.", ".$QV_idUsuario.", NOW())");
		
		// DEFINE NOVO ID DO PEDIDO
		$resConsulta['ID_PEDIDO'] = mysqli_insert_id($conexao);

		// SQL INSERT - DADOS DE PAGAMENETO
		$adicionarDP = mysqli_query($conexao, "INSERT INTO PDV_pedidosFormasPagamento (idPedido, vencimento, dataInsert) VALUES (".$resConsulta['ID_PEDIDO'].", NOW(), NOW())");

	}     

	// RETORNO
	return $resConsulta['ID_PEDIDO'];

}   

/////////////////////////////////////////////////////
// CALCULA IDADE EM ANOS COM BASE DATA NASCIMENTO
/////////////////////////////////////////////////////
function calcularIdade($dataNascimento) {
	$data = new DateTime($dataNascimento);
	$resultado = $data->diff(new DateTime(date('Y-m-d')));
	return $resultado->format('%Y');
}


/////////////////////////////////////////////////////
// CONSULTA DOCUMENTO FISCAL - FOCUS NFe/NFCe
/////////////////////////////////////////////////////
function focusConsDocFiscal($idUnidade,$ref) {

	// BANCO DADOS
	$conexao = bancoDados("conectar","intranet"); 

	// CONSULTA DADOS FISCAIS DA UNIDADE FRANQUEADA
	$consulta = mysqli_query($conexao, "SELECT * FROM PDV_unidadesDadosFiscais WHERE idUnidade = '".$idUnidade."' ");
	$resultado = mysqli_fetch_array($consulta);

	//********** INTEGRACAO COM FOCUS - ECRAS | CONFIGS
	$tipoAmbiente = "https://api.focusnfe.com.br";
	//$tipoAmbiente = "https://homologacao.focusnfe.com.br";

	// Dados de Autenticacao na Focus
	$login = $resultado['token'];
	$password = "";
	$NF_Token = base64_encode($login.":".$password);

	// DEFININDO ENDPOINT
	$endpoint = ($resultado['tipoDocumento'] == 'NFCe' ? "/v2/nfce/" : "/v2/nfe/" );

	// CURL - START
	ponto_CURL_START:
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $tipoAmbiente . $endpoint . $ref . "?completa=0",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic ' . $NF_Token
		),
	));
	$body = curl_exec($curl);
	$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	$resposta = json_decode($body, true);
	// CURL - END
	
	//logDebug("CONSULTA DE DOCUMENTO FISCAL - ". json_encode($resposta));
	//logDebug("REQUEST - ". $tipoAmbiente . $endpoint . $ref);

	// VALIDANDO RETORNO
	if($resposta['status'] == 'processando_autorizacao') {
		goto ponto_CURL_START;
	}

	// TRATANDO RETORNO
	if($http_code == 200) {
		return $resposta;
	} else {
		return false;
	}

}

/////////////////////////////////////////////////////
// CRIPTOGRAFIA DE SENHA - BCRYPT
/////////////////////////////////////////////////////
function B_CRYPT($modo, $senha, $hash = false) {

	if($modo == "validar") {

		if(crypt($senha, $hash) === $hash) {
			return true;
		} else { return false; }		

	} else {

		//***** RANDOM SALT
		$saltLength = 22;
		$seed = uniqid(mt_rand(), true); // Salt seed

		// Generate salt
		$salt = base64_encode($seed);
		$salt = str_replace('+', '.', $salt);
		$salt = substr($salt, 0, $saltLength);
		//***** RANDOM SALT

		// Gera um hash baseado em bcrypt
		$custo = '10';
		$hash = crypt($senha, '$2y$' . $custo . '$' . $salt . '$');

		return $hash;

	}

}

/**
* Função que protege uma página
*/
function protegePagina($paginaAtual) {

	if($paginaAtual != 'login') {

		if(!isset($_SESSION['Authentication']['id_usuario']) && empty($_SESSION['Authentication']['id_usuario'])) {

			// Não há usuário logado, manda pra página de login
			expulsaVisitante();
			
		} elseif(!isset($_SESSION['Authentication']['id_usuario']) OR !isset($_SESSION['Authentication']['nome'])) {
	
			// Há usuário logado, verifica se precisa validar o login novamente
			if ($_SESSION['Authentication']['validaSempre'] == true) {
	
				// Verifica se os dados salvos na sessão batem com os dados do banco de dados
				/*if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
					// Os dados não batem, manda pra tela de login
					expulsaVisitante();
				}*/
	
			}
	
		}		

	}

}


/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {

	// Remove as variáveis da sessão (caso elas existam)
	unset($_SESSION['Authentication']);

	// Manda pra tela de login
	header("Location: /login");
}

?>
