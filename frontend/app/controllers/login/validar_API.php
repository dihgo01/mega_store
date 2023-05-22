<?php 
// INCLUDE MODEL
//include "/app/models/".$_QV['URL']['parametros']['var1']."/".$_QV['URL']['parametros']['var1'].".php";

// VALIDAR AUTENTICACAO
if($_QV['URL']['parametros']['var2'] == 'validar' && $_POST) {

    // RECEBE DADOS
    $usuario    = anti_injection($_POST['login']);
    $senha      = anti_injection($_POST['senha']);

	// PREPARA DADOS
	$payload = array("usuario"=> $usuario, "senha"=> $senha);

    // CURL
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://qv-api:8890/autenticacao/login/valida',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode($payload),
      CURLOPT_HTTPHEADER => array(
        'Authentication: bearer 028e5fc159d6cb79e4957c3b53c79bf3',
        'Content-Type: application/json'
      ),
    ));

    // CURL - RETORNO
    $res 	  		= curl_exec($curl);
    $httpcode 		= curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    $contentType 	= curl_getinfo($curl, CURLINFO_CONTENT_TYPE);	
    
    // CURL - FINALIZA
    curl_close($curl);

	// TRANSFORMANDO RETORNO
	$resposta = json_decode($res, true);    

    // VALIDANDO RETORNO
    if($httpcode == 200 && $resposta['resultado']) {

        $_QV['controller']      = true;
        $_QV['Authentication']  = $resposta['conteudo'];

        // Manda pra tela inicial
        //header("Location: /");
        
    } else {
        $_QV['controller']      = $resposta;
        $_QV['Authentication']  = false;
    }

} else {
    $_QV['controller'] = false;
}

?>