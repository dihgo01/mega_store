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

/* rodape.twig */
class __TwigTemplate_5f7839d859b48e6f39845550f0e90e85 extends Template
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
        echo "<!-- footer @s -->
<div class=\"nk-footer\">
    <div class=\"container-fluid\">
        <div class=\"nk-footer-wrap small\">
            <div class=\"nk-footer-copyright\">
                <a href=\"";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "siteCliente", [], "any", false, false, false, 6), "html", null, true);
        echo "\" target=\"_blank\" class=\"text-muted\">Feito com grande <i class=\"fas fa-heart text-danger\"></i> pela <strong>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "cliente", [], "any", false, false, false, 6), "html", null, true);
        echo " </strong> · Copyright 2022 · Todos os Direitos Reservados</a></strong>
            </div>
            <div class=\"nk-footer-links\">
                <ul class=\"nav nav-sm\">
                    <li class=\"nav-item\"><a class=\"nav-link\" href=\"javascript:void(0);\">Termos de Uso</a></li>
                    <li class=\"nav-item\"><a class=\"nav-link\" href=\"javascript:void(0);\">Política de Privacidade</a></li>
                    <li class=\"nav-item\"><a class=\"nav-link\" href=\"javascript:void(0);\">Ajuda</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- footer @e -->";
    }

    public function getTemplateName()
    {
        return "rodape.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "rodape.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\rodape.twig");
    }
}
