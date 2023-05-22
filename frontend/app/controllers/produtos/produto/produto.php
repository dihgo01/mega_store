<?php

// FIND MODEL
$model = carregarMVC($_QV['URL'], 'models');
if (file_exists($model)) {

	include $model;

	if ($_QV['URL']['parametros']['var2'] == 'produto' && $_QV['URL']['parametros']['var3'] == 'list') {

		$classe = new QV_Produto();

		$_QV['controller'] = $classe->consulta();
	} elseif ($_QV['URL']['parametros']['var2'] == 'produto' && $_QV['URL']['parametros']['var3'] == 'create') {

		$classe = new QV_Produto();

		$_QV['controller'] = $classe->consulta_categoria();
	} elseif ($_QV['URL']['parametros']['var2'] == 'produto' && $_QV['URL']['parametros']['var3'] == 'update') {

		$classe = new QV_Produto();

		$_QV['controller'] = $classe->consulta_produto_unica($_QV['URL']['parametros']['var4']);
	}
} else {
	$_QV['controller'] = false;
}
