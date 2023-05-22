<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* templates/main.twig */
class __TwigTemplate_0683b653e0ed6316e2841dd7d3c99d9c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"pt-BR\" class=\"js\">
<head>
<!-- META TAGS -->
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='author' content='' />
<meta name='creator' content='' />
<meta name='copyright' content='' />
<meta name='url' content='' />
<meta name='language' content='pt-BR' />
<meta name='robots' content='noindex,nofollow' />
<link rel='alternate' href='' hreflang='pt-BR' />
<link rel='canonical' href='' />
<!-- META TAGS -->

<title>";
        // line 18
        $this->displayBlock('title', $context, $blocks);
        echo "</title>


<!-- CACHE -->
<meta http-equiv=\"cache-control\" content=\"max-age=0\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />
<meta http-equiv=\"expires\" content=\"0\" />
<meta http-equiv=\"expires\" content=\"Tue, 01 Jan 1980 1:00:00 GMT\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<!-- CACHE -->

<!-- FAVICON -->
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"/assets/images/favicon/favicon.png\">
<meta name=\"msapplication-TileColor\" content=\"#ffffff\">
<meta name=\"theme-color\" content=\"#ffffff\">
<!-- FAVICON -->

<!-- CSS -->
<link rel=\"stylesheet\" href=\"/assets/css/dashlite.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/libs/fontawesome-icons-6.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/qv-custom.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/qv-plugins.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/theme.css?ver=3.0.2\">
<!-- CSS -->
</head>

<body class=\"nk-body bg-lighter npc-general has-sidebar\">

    <div class=\"nk-app-root\">
        <div class=\"nk-main \"> 
            ";
        // line 48
        echo twig_include($this->env, $context, "sidebar.twig");
        echo "
            <div class=\"nk-wrap\">
                ";
        // line 50
        echo twig_include($this->env, $context, "topo.twig");
        echo "
                <div class=\"nk-content \">
                ";
        // line 52
        $this->displayBlock('content', $context, $blocks);
        // line 53
        echo "                </div> <!-- content @s -->     
            </div> <!-- wrap @s -->
        </div> <!-- main @e -->
    </div> <!-- app-root @e -->   
</body>
</html>";
    }

    // line 18
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 52
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "templates/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 52,  112 => 18,  103 => 53,  101 => 52,  96 => 50,  91 => 48,  58 => 18,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "templates/main.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\templates\\main.twig");
    }
}
