<?php 

include "app/models/".$_QV['URL']['parametros']['var1']."/".$_QV['URL']['parametros']['var1'].".php";

if($_QV['URL']['parametros']['var2'] == 'validar' && $_POST) {

    $classe = new QV_Login($_POST);

    $_QV['controller'] = $classe->index();

    if($_QV['controller']['resultado']) {
        header("Location: /");
    } else {
        header("Location: /login");
    }

} else {
    $_QV['controller'] = false;
}

?>