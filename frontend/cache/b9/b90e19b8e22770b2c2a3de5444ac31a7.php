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

/* /pedidos/vendas/list.twig */
class __TwigTemplate_1c4b98ede6859687e39bb3ab02c20d7e extends Template
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
        echo "<div class=\"container-fluid\">
    <div class=\"nk-content-inner\">
        <div class=\"nk-content-body\">

            <div class=\"nk-block-head nk-block-head-sm\">
                <div class=\"nk-block-between\">
                    <div class=\"nk-block-head-content\">
                        <h3 class=\"nk-block-title page-title\">Vendas / <strong class=\"text-primary small\">Consulta</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para consulta das vendas lançadas.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class=\"nk-block-head-content\">
                        <div class=\"toggle-wrap nk-block-tools-toggle\">
                            <a href=\"#\" class=\"btn btn-icon btn-trigger toggle-expand mr-n1\" data-target=\"pageMenu\"><em class=\"icon ni ni-menu-alt-r\"></em></a>
                            <div class=\"toggle-expand-content\" data-content=\"pageMenu\">
                                <ul class=\"nk-block-tools g-2\">
                                    <li class=\"w-xs-100\"><a href=\"/";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 18), "var1", [], "any", false, false, false, 18), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 18), "var2", [], "any", false, false, false, 18), "html", null, true);
        echo "/create\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\"><em class=\"icon ni ni-plus-circle\"></em><span>Nova Venda</span></a></li>
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class=\"nk-block\">
                <div class=\"card card-bordered card-stretch\">
                    <div class=\"card-inner-group\">
                        <div class=\"card-inner position-relative card-tools-toggle\">
                            <div class=\"card-title-group\">
                                <div class=\"card-tools w-90\">
                                    <div class=\"search-content\">
                                    </div>
                                </div><!-- .card-tools -->
                                <div class=\"card-tools me-n1\">
                                    <ul class=\"btn-toolbar gx-1\">
                                       
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                        </div><!-- .card-inner -->
                        <div class=\"card-inner px-0 pt-0\">
                            <div class=\"table-responsive\" style=\"padding-left:0px; padding-right:0px; overflow: visible !important;\">
                                <table class=\"table-hover nowrap nk-tb-list w-100 \" data-auto-responsive=\"false\" id=\"responsive-datatable\" >
                                    <thead class=\"head-table\">
                                        <tr class=\"nk-tb-item nk-tb-head\">
                                            <th class=\"nk-tb-col text-center\">DATA DE CADASTRO</th>
                                            <th class=\"nk-tb-col text-center\">TOTAL</th>
                                            <th class=\"nk-tb-col text-center\">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody class=\"table-body\">
                                       
                                    </tbody>
                                </table>
                            </div> <!-- RESPONSIVE TABLE -->
                        </div><!-- .card-inner -->
                        
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->

        </div> <!-- nk-content-body -->
    </div>
</div>


<!-- LOAD EXTRA FILES -->
";
        // line 68
        echo twig_include($this->env, $context, "scripts.twig");
        echo "

<script src=\"/assets/js/views/";
        // line 70
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 70), "var1", [], "any", false, false, false, 70), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 70), "var2", [], "any", false, false, false, 70), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 70), "var2", [], "any", false, false, false, 70), "html", null, true);
        echo ".js\"></script>
<script src=\"/assets/js/views/pedidos/vendas/shopcart.js?ts=";
        // line 71
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "/pedidos/vendas/list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  124 => 71,  116 => 70,  111 => 68,  56 => 18,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pedidos/vendas/list.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\pedidos\\vendas\\list.twig");
    }
}
