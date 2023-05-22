<?php 
// INCLUDE CLASS
include "inc/classes/".$_QV['URL']['parametros']['var1']."/class-".$_QV['URL']['parametros']['var1'].".php";

// RELACAO CLASSES E MODULOS (var2 x class name)
$relacaoClassModulos = array(
    'categorias'    => 'categorias',
    'cores'         => 'cores',
    'altura-saltos' => 'alturaSaltos',
    'colecoes'      => 'colecoes',
    'detalhes'      => 'detalhes',
    'estilos'       => 'estilos',
    'grades'        => 'grades',
    'materiais'     => 'materiais',
    'tamanho-saltos'=> 'tamanhoSaltos',
    'produtos'      => 'produtos',
    'fornecedores'  => 'fornecedores'
);

// EDITANDO REGISTRO
if($_QV['URL']['parametros']['var3'] == 'update' && !empty($_QV['URL']['parametros']['var4'])) {

    // Instância Class
    $categorias = new $relacaoClassModulos[$_QV['URL']['parametros']['var2']];

    // Chama Funcao de Consulta
    $_QV['controller'] = $categorias->getItem($_QV['URL']['parametros']['var4']);

} else {
    $_QV['controller'] = false;
}
?>