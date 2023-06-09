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

/* sidebar.twig */
class __TwigTemplate_9d87e5cef36e8fdb51f4ff68146bd03a extends Template
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
        echo "<!-- sidebar @s -->
<div class=\"nk-sidebar nk-sidebar-fixed is-dark \" data-content=\"sidebarMenu\">
    <div class=\"nk-sidebar-element nk-sidebar-head\">
        <div class=\"nk-menu-trigger\">
            <a href=\"#\" class=\"nk-nav-toggle nk-quick-nav-icon d-xl-none\" data-target=\"sidebarMenu\"><em class=\"icon ni ni-arrow-left\"></em></a>
            <a href=\"#\" class=\"nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex\" data-target=\"sidebarMenu\"><em class=\"icon ni ni-menu\"></em></a>
        </div>
        <div class=\"nk-sidebar-brand\">
            <a href=\"";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "urlProjeto", [], "any", false, false, false, 9), "html", null, true);
        echo "\" class=\"logo-link nk-sidebar-logo\">
                <img class=\"logo-light logo-img w-100\" src=\"/assets/images/qv-logo-white.png\" srcset=\"/assets/images/qv-logo-white.png 2x\" alt=\"logo\">
                <img class=\"logo-dark logo-img w-100\" src=\"/assets/images/qv-logo-black.png\" srcset=\"/assets/images/qv-logo-black.png 2x\" alt=\"logo-dark\">
            </a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class=\"nk-sidebar-element nk-sidebar-body\">
        <div class=\"nk-sidebar-content\">
            <div class=\"nk-sidebar-menu\" data-simplebar>
                <ul class=\"nk-menu\">
                    <li class=\"nk-menu-item\">
                        <a href=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "urlProjeto", [], "any", false, false, false, 20), "html", null, true);
        echo "\" class=\"nk-menu-link\">
                            <span class=\"nk-menu-icon\"><em class=\"icon ni ni-home\"></em></span>
                            <span class=\"nk-menu-text\">Início</span>
                        </a>
                    </li><!-- .nk-menu-item -->    
                    
                    <li class=\"nk-menu-item has-sub\">
                        <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
                            <span class=\"nk-menu-icon\"><i class=\"far fa-store\" style=\"font-size:120%;\"></i></span>
                            <span class=\"nk-menu-text\">Vendas</span>
                        </a>
                        <ul class=\"nk-menu-sub\">
                            <li class=\"nk-menu-item\">
                                <a href=\"/pedidos/vendas/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Nova Venda</span></a>
                            </li>
                            <li class=\"nk-menu-item\">
                                <a href=\"/pedidos/vendas/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consulta</span></a>
                            </li> 
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->

                    <li class=\"nk-menu-item has-sub\">
                        <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
                            <span class=\"nk-menu-icon\"><em class=\"icon ni ni-package\"></em></span>
                            <span class=\"nk-menu-text\">Produtos</span>
                        </a>
                        <ul class=\"nk-menu-sub\">
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/produto/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Produto</span></a>
                            </li>
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/produto/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>

                    <li class=\"nk-menu-item has-sub\">
                        <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
                            <span class=\"nk-menu-icon\"><em class=\"icon ni ni-layer\"></em></span>
                            <span class=\"nk-menu-text\">Categoria</span>
                        </a>
                        <ul class=\"nk-menu-sub\">
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/categoria/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Nova Categoria</span></a>
                            </li>
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/categoria/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>

                    <li class=\"nk-menu-item has-sub\">
                        <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
                            <span class=\"nk-menu-icon\"><em class=\"icon ni ni-coins\"></em></span>
                            <span class=\"nk-menu-text\">Imposto</span>
                        </a>
                        <ul class=\"nk-menu-sub\">
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/imposto/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Imposto</span></a>
                            </li>
                            <li class=\"nk-menu-item\">
                                <a href=\"/produtos/imposto/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>

                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->";
    }

    public function getTemplateName()
    {
        return "sidebar.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 20,  47 => 9,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "sidebar.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\sidebar.twig");
    }
}
