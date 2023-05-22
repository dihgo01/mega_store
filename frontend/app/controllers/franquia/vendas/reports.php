<?php 
// VARIAVEIS
$QV_Unidade = $_SESSION['Authentication']['franquias'][$_SESSION['Authentication']['franquiaActive']]['unidade'];

// FIND MODEL
$model = carregarMVC($_QV['URL'],'models');
if(file_exists($model)) {
    
    // INCLUDE MODEL
    include $model;

    //******* TELA REPORTS
    if($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'reports') {

        // Instância Class
        $classe = new QV_Reports($QV_Unidade);

        // Chama Metodo Consulta
        $_QV['controller'] = $classe->vendedoresList();

    } else {
        $_QV['controller'] = false;    
    }

} else {
    $_QV['controller'] = false;
}

?>