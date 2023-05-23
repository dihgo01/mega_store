<?php

$model = carregarMVC($_QV['URL'], 'models');
if (file_exists($model)) {

    include $model;

    if ($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'create') {

        $classe = new QV_Vendas();

        $_QV['controller'] = $classe->consulta_produto();
    } elseif ($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'list') {

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso');

        $_QV['controller'] = $resultadoFinal;
    } elseif ($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'checkout') {

        $resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso');
        
        $_QV['controller'] = $resultadoFinal;
    }
} else {
    $_QV['controller'] = false;
}
