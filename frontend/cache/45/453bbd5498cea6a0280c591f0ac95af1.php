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

/* scripts.twig */
class __TwigTemplate_6748419131bfa78281083bf47ae1b555 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!-- JavaScript -->
<script src=\"/assets/js/bundle.js?ts=";
        // line 2
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script src=\"/assets/js/scripts.js?ts=";
        // line 3
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script src=\"/assets/js/qv-plugins.js?ts=";
        // line 4
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script src=\"/assets/js/qv-custom.js?ts=";
        // line 5
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script src=\"/assets/js/views/login/login.js?ts=";
        // line 6
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script src=\"/assets/js/views/pedidos/vendas/shopcart.js?ts=";
        // line 7
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>";
    }

    public function getTemplateName()
    {
        return "scripts.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 7,  56 => 6,  52 => 5,  48 => 4,  44 => 3,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "scripts.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\scripts.twig");
    }
}
