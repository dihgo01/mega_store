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

/* /sidebar/ims.twig */
class __TwigTemplate_ebf5f52a566f1976de5b732ca5eea096 extends Template
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
        if (((twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "nivel", [], "any", false, false, false, 1) == "1") || (twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "nivel", [], "any", false, false, false, 1) == "5"))) {
            // line 2
            echo "<li class=\"nk-menu-heading pt-4\">
    <h6 class=\"overline-title text-primary-alt\">Dashboards</h6>
</li><!-- .nk-menu-item -->
<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-share-alt\"></em></span>
        <span class=\"nk-menu-text\">Franquias</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/dashboards/franquias/micro-analise\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Micro Análise</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/dashboards/franquias/macro-analise\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Macro Análise</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/dashboards/franquias/relatorios\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Relatórios</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->                    
<li class=\"nk-menu-item d-none\">
    <a href=\"/dashboards/expansao\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-grid-add-fill-c\"></em></span>
        <span class=\"nk-menu-text\">Expansão</span>
    </a>
</li><!-- .nk-menu-item -->
<li class=\"nk-menu-item d-none\">
    <a href=\"/dashboards/ecommerce\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-cart\"></em></span>
        <span class=\"nk-menu-text\">Loja Virtual</span>
    </a>
</li><!-- .nk-menu-item -->
<li class=\"nk-menu-item d-none\">
    <a href=\"/dashboards/qv-em-casa\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-bag\"></em></span>
        <span class=\"nk-menu-text\">QV em Casa</span>
    </a>
</li><!-- .nk-menu-item -->
<li class=\"nk-menu-item d-none\">
    <a href=\"/dashboards/ocorrencias\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-help-alt\"></em></span>
        <span class=\"nk-menu-text\">Ocorrências</span>
    </a>
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-heading pt-4\">
    <h6 class=\"overline-title text-primary-alt\">Geral (IMS)</h6>
</li><!-- .nk-menu-heading -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-building\"></em></span>
        <span class=\"nk-menu-text\">Unidades</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/ims/unidades/consulta\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consulta</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/ims/unidades/nova\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Cadastro</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-cart\"></em></span>
        <span class=\"nk-menu-text\">Lojas</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/ims/lojas/consulta\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consulta</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/ims/lojas/nova\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Cadastro</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/ims/lojas/relatorios\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Relatórios</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item --> 

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-users-fill\"></em></span>
        <span class=\"nk-menu-text\">Usuários</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/ims/usuarios/consulta\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consulta</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/ims/usuarios/novo\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Cadastro</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-heading pt-4\">
    <h6 class=\"overline-title text-primary-alt\">Ajuda</h6>
</li><!-- .nk-menu-heading -->

<li class=\"nk-menu-item\">
    <a href=\"/ajuda/duvidas-frequentes\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-book-read\"></em></span>
        <span class=\"nk-menu-text\">Dúvidas Frequentes</span>
    </a>
</li><!-- .nk-menu-item -->
<li class=\"nk-menu-item\">
    <a href=\"/ajuda/ocorrencias\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-help-alt\"></em></span>
        <span class=\"nk-menu-text\">Ocorrências</span>
    </a>
</li><!-- .nk-menu-item -->
";
        }
    }

    public function getTemplateName()
    {
        return "/sidebar/ims.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/sidebar/ims.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\sidebar\\ims.twig");
    }
}
