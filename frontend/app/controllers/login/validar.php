<?php 
// INCLUDE MODEL
include "app/models/".$_QV['URL']['parametros']['var1']."/".$_QV['URL']['parametros']['var1'].".php";

// VALIDAR AUTENTICACAO
if($_QV['URL']['parametros']['var2'] == 'validar' && $_POST) {

    // Instância Class
    $classe = new QV_Login($_POST);

    // Chama Funcao de Valida Login
    $_QV['controller'] = $classe->index();

    // REDIRECIONANDO
    if($_QV['controller']['resultado']) {
        header("Location: /");
    } else {
        header("Location: /login");
    }

} else {
    $_QV['controller'] = false;
}

?>