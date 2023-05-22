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
	

	// DEFININDO PAGINA PADRAO
	if(empty($_QV['URL']['PG'])) {
		$_QV['URL']['PG'] = "home.twig";
	} else {

		$_QV['URL']['PG'] = $capturaURL[1].".twig";
		
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
		$url_base .= "vendas/vendas.php";
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

		if(!isset($_SESSION['Authentication']['id_usuario']) OR !isset($_SESSION['Authentication']['nome'])) {
	
			// Há usuário logado, verifica se precisa validar o login novamente
			
	
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
