<?php 
// INCLUDES
include "inc/functions.php";
include "vendor/autoload.php";

// URL
$capturaURL = explode('/', $_SERVER['REQUEST_URI']);

// FUNCOES PADROES
url_friendly($capturaURL, $_SERVER['REQUEST_URI']);
projetoDados();
protegePagina($_QV['URL']['parametros']['var1']);

// INSTANCIANDO
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Carregando a pasta de templates
$loader = new FilesystemLoader('app/views');

// Carregando o ambiente
$twig = new Environment($loader, [
    'cache'         => 'cache',
    'auto_reload'   => true,
    'debug'         => false
]);

// Carregando Extensões
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Definindo variaveis
$twig->addGlobal('_session', $_SESSION);
$twig->addGlobal('_post', $_POST);
$twig->addGlobal('_get', $_GET);

#
# Controller
#
$controller = carregarMVC($_QV['URL'],'controllers');
if(file_exists($controller)) {
    include $controller;
} else {
    $_QV['controller'] = false;
}

#
# View
#
echo $twig->render($_QV['URL']['PG'], [
    'url'               => $_QV['URL'],
    'projeto'           => $_QV['PROJETO'],
    'controller'        => $_QV['controller'],
    'authentication'    => (isset($_SESSION['Authentication']) ? $_SESSION['Authentication'] : false)
]);
?>