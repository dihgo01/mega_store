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

/* topo.twig */
class __TwigTemplate_3d898d9d2a20e11a527b18c182188c1b extends Template
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
        echo "<!-- main header @s -->
<div class=\"nk-header nk-header-fixed is-light\">
    <div class=\"container-fluid\">
        <div class=\"nk-header-wrap\">
            <div class=\"nk-menu-trigger d-xl-none ml-n1\">
                <a href=\"#\" class=\"nk-nav-toggle nk-quick-nav-icon\" data-target=\"sidebarMenu\"><em class=\"icon ni ni-menu\"></em></a>
            </div>
            <div class=\"nk-header-brand d-xl-none w-60 w-xs-50\">
                <a href=\"./\" class=\"logo-link\">
                    <img class=\"logo-light logo-img\" src=\"/assets/images/qv-logo-white.png\" srcset=\"/assets/images/qv-logo-white.png 2x\" alt=\"logo\">
                    <img class=\"logo-dark logo-img\" src=\"/assets/images/qv-logo-black.png\" srcset=\"/assets/images/qv-logo-black.png 2x\" alt=\"logo-dark\">
                </a>
            </div><!-- .nk-header-brand -->
            <div class=\"nk-header-news d-none d-xl-block\">
            </div><!-- .nk-header-news -->
            <div class=\"nk-header-tools\">
                <ul class=\"nk-quick-nav\">
                    
                    ";
        // line 19
        if (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var1", [], "any", false, false, false, 19) == "franquia") && (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var2", [], "any", false, false, false, 19) == "vendas"))) {
            // line 20
            echo "                    <li class=\"d-none d-sm-block me-n1\">
                        <a href=\"#\" class=\"nk-quick-nav-icon toggle\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"Ver Carrinho\"  data-target=\"userAside\">
                            <em class=\"icon ni ni-cart\"></em>
                        </a>
                    </li>
                    ";
        }
        // line 25
        echo "  
                    
                    <li class=\"dropdown user-dropdown\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-bs-toggle=\"dropdown\">
                            <div class=\"user-toggle\">
                                <div class=\"user-avatar sm\">
                                    <em class=\"icon ni ni-user-alt\"></em>
                                </div>
                                <div class=\"user-info d-none d-md-block\">
                                    <div class=\"user-status\">";
        // line 34
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "escopo", [], "any", false, false, false, 34), "html", null, true);
        echo "</div>
                                    <div class=\"user-name dropdown-indicator\">";
        // line 35
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "nome", [], "any", false, false, false, 35), "html", null, true);
        echo "</div>
                                </div>
                            </div>
                        </a>
                        <div class=\"dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1\">
                            <div class=\"dropdown-inner user-card-wrap bg-lighter d-none d-md-block\">
                                <div class=\"user-card\">
                                    <div class=\"user-avatar\">
                                        <span>";
        // line 43
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "iniciais", [], "any", false, false, false, 43), "html", null, true);
        echo "</span>
                                    </div>
                                    <div class=\"user-info\">
                                        <span class=\"lead-text\">";
        // line 46
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "nome", [], "any", false, false, false, 46), "html", null, true);
        echo "</span>
                                        <span class=\"sub-text\">";
        // line 47
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "email", [], "any", false, false, false, 47), "html", null, true);
        echo "</span>
                                    </div>
                                </div>
                            </div>
                            <div class=\"dropdown-inner\">
                                <ul class=\"link-list\">
                                    <li><a href=\"/minha-conta\"><em class=\"icon ni ni-user-alt\"></em><span>";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["lang"] ?? null), "menu_usuario_perfil", [], "any", false, false, false, 53), "html", null, true);
        echo "</span></a></li>
                                    <li><a href=\"/minha-conta/franquias\"><em class=\"icon ni ni-setting-alt\"></em><span>";
        // line 54
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["lang"] ?? null), "menu_usuario_configuracoes", [], "any", false, false, false, 54), "html", null, true);
        echo "</span></a></li>
                                    <li><a href=\"/minha-conta/historico\"><em class=\"icon ni ni-activity-alt\"></em><span>";
        // line 55
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["lang"] ?? null), "menu_usuario_historico_login", [], "any", false, false, false, 55), "html", null, true);
        echo "</span></a></li>
                                    <li><a class=\"dark-switch\" href=\"#\"><em class=\"icon ni ni-moon\"></em><span>";
        // line 56
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["lang"] ?? null), "menu_usuario_modo_escuro", [], "any", false, false, false, 56), "html", null, true);
        echo "</span></a></li>
                                </ul>
                            </div>
                            <div class=\"dropdown-inner\">
                                <ul class=\"link-list\">
                                    <li><a href=\"/logout\"><em class=\"icon ni ni-signout\"></em><span>";
        // line 61
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["lang"] ?? null), "menu_usuario_logout", [], "any", false, false, false, 61), "html", null, true);
        echo "</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li><!-- .dropdown -->

                </ul><!-- .nk-quick-nav -->
            </div><!-- .nk-header-tools -->
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>
<!-- main header @e -->";
    }

    public function getTemplateName()
    {
        return "topo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 61,  124 => 56,  120 => 55,  116 => 54,  112 => 53,  103 => 47,  99 => 46,  93 => 43,  82 => 35,  78 => 34,  67 => 25,  59 => 20,  57 => 19,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "topo.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\topo.twig");
    }
}
