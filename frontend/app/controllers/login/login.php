<?php 

if($_QV['URL']['parametros']['var1'] == 'login') {

    $_QV['controller'] = (isset($_SESSION['loginMensagemErro']) ? array('mensagemErro'=>true, 'mensagem'=>$_SESSION['loginMensagemErro']) : false);

} else {
    $_QV['controller'] = false;
}

?>