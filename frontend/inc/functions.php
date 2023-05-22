<?php
// SESSION
session_start();

//////////////////////////////////////////////////////
/**********  FUNCAO GERAR DADOS DO PROJETO **********/
/////////////////////////////////////////////////////
function projetoDados() {

	// DEFININDO GLOBAL
	global $_QV;	

	$_QV['PROJETO'] = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/projeto.env');

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
