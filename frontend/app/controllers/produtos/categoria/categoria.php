<?php

// FIND MODEL
$model = carregarMVC($_QV['URL'], 'models');
if (file_exists($model)) {

	// INCLUDE MODEL
	include $model;

	//******* CRIANDO CATEGORIA
	if ($_QV['URL']['parametros']['var2'] == 'categoria' && $_QV['URL']['parametros']['var3'] == 'list') {

		// Instância Class
		$classe = new QV_Categorias();

		// Chama Funcao de Consulta de Categorias
		$_QV['controller'] = $classe->consulta();
	} //******* CONSULTA PEDIDO
	elseif ($_QV['URL']['parametros']['var2'] == 'categoria' && $_QV['URL']['parametros']['var3'] == 'create') {
		
		// Instância Class
		$classe = new QV_Categorias();

		// Chama Funcao de Consulta de Categorias
		$_QV['controller'] = $classe->consulta_imposto();
	}
} else {
	$_QV['controller'] = false;
}
