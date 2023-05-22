<?php 
// FIND MODEL
$model = carregarMVC($_QV['URL'],'models');
if(file_exists($model)) {
    
    // INCLUDE MODEL
    include $model;

    //******* INFORMACOES BASICAS
    if(empty($_QV['URL']['parametros']['var2'])) {

        // Instância Class
        $classe = new QV_MinhaConta();

        // Chama Metodo
        $_QV['controller'] = $classe->index();

    }
    //******* HISTORICO LOGIN
    elseif($_QV['URL']['parametros']['var2'] == 'historico') {

        // Instância Class
        $classe = new QV_MinhaConta();

        // Chama Metodo
        $_QV['controller'] = $classe->historicoLogin();
    }
    //******* FRANQUIAS
    elseif($_QV['URL']['parametros']['var2'] == 'franquias') {

        // Instância Class
        $classe = new QV_MinhaConta();

        // Chama Metodo
        $_QV['controller'] = $classe->franquiasList();

    } else {
        $_QV['controller'] = false;    
    }

} else {
    $_QV['controller'] = false;
}
?>