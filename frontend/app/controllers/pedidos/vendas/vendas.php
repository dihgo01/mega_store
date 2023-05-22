<?php 
// VARIAVEIS

// FIND MODEL
$model = carregarMVC($_QV['URL'],'models');
if(file_exists($model)) {
    
    // INCLUDE MODEL
    include $model;

    //******* CRIANDO PEDIDO
    if($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'create') {

        // Instância Class
        $classe = new QV_Produtos();

        // Chama Funcao de Consulta de Categorias
        $_QV['controller'] = $classe->categorias();

    }
     //******* CONSULTA PEDIDO
     elseif($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'list') {

        // Instância Class
        $classe = new QV_Produtos();

        // Chama Funcao de Consulta de Categorias
        $_QV['controller'] = $classe->consulta();

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

        // Instância Class | Passar Unidade como Argumento
        $classe = new QV_Checkout($QV_Unidade);

        // Chama Metodo Consulta
        $_QV['controller'] = $classe->consulta();

    }
    //******* TELA EDICAO VENDA
    elseif($_QV['URL']['parametros']['var2'] == 'vendas' && $_QV['URL']['parametros']['var3'] == 'update' && !empty($_QV['URL']['parametros']['var4'])) {

        // DEFININDO VARIAVEIS A SEREM ENVIADAS
        $campos = array('idVenda' => $_QV['URL']['parametros']['var4'], 'idUnidade' => $QV_Unidade);

        // Instância Class | Passar Unidade como Argumento
        $classe = new QV_Vendas($campos);

        // Chama Metodo Consulta
        $_QV['controller'] = $classe->consultaVenda();

    } else {
        $_QV['controller'] = false;    
    }

} else {
    $_QV['controller'] = false;
}
