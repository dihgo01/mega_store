<?php

// FIND MODEL
$model = carregarMVC($_QV['URL'], 'models');
if (file_exists($model)) {

	// INCLUDE MODEL
	include $model;

	if ($_QV['URL']['parametros']['var2'] == 'imposto' && $_QV['URL']['parametros']['var3'] == 'list') {

		$classe = new QV_Imposto();

		$_QV['controller'] = $classe->consulta();
	} elseif ($_QV['URL']['parametros']['var2'] == 'imposto' && $_QV['URL']['parametros']['var3'] == 'create') {

		$resultadoFinal = array('resultado' => true, 'mensagem' => 'Consulta Realizada com Sucesso');

		return $resultadoFinal;
	} elseif ($_QV['URL']['parametros']['var2'] == 'imposto' && $_QV['URL']['parametros']['var3'] == 'update') {

		$classe = new QV_Imposto();

		$_QV['controller'] = $classe->consulta_unica($_QV['URL']['parametros']['var4']);
	}
} else {
	$_QV['controller'] = false;
}
