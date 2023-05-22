<?php 
//******* INCLUDE MODEL
include "app/models/".$_QV['URL']['parametros']['var1']."/".$_QV['URL']['parametros']['var2']."/".(!empty($_QV['URL']['parametros']['var2']) ? $_QV['URL']['parametros']['var2'].".php" : $_QV['URL']['parametros']['var1']).".php";

//******* CRIANDO PEDIDO
if($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'create') {

    // Instância Class
    $classe = new QV_Produtos();

    // Chama Funcao de Consulta de Categorias
    $_QV['controller'] = $classe->categorias();

}
//******* VISUALIZAR PRODUTO
elseif($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'produto') {

    // Instância Class
    $classe = new QV_Produtos($_QV['URL']['parametros']['var4']);

    // Chama Funcao de Consulta Dados do Produto
    $_QV['controller'] = $classe->consulta();

}
//******* CHECKOUT
elseif($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'checkout') {

    // Instância Class
    $classe = new QV_Checkout(573);

    // Chama Funcao de Consulta Dados do Produto
    $_QV['controller'] = $classe->consulta();

} else {
    $_QV['controller'] = false;
}

?>