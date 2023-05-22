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

/* /produtos/produto/list.twig */
class __TwigTemplate_6489b6180230b90f336a59d20d85e7c0 extends Template
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
                        <h3 class=\"nk-block-title page-title\">Produtos / <strong class=\"text-primary small\">Consulta</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para consulta de produtos.</p>
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
        echo "/create\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\"><em class=\"icon ni ni-plus-circle\"></em><span>Criar Novo Produto</span></a></li>
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
                            <div class=\"card-search search-wrap\" data-search=\"search\">
                                <div class=\"card-body\">
                                    <div class=\"search-content\">
                                    </div>
                                </div>
                            </div><!-- .card-search -->
                        </div><!-- .card-inner -->
                        <div class=\"card-inner px-0 pt-0\">
                            <div class=\"table-responsive\" style=\"padding-left:0px; padding-right:0px; overflow: visible !important;\">
                                <table class=\"table-hover nowrap nk-tb-list w-100 general-datatable\" data-auto-responsive=\"false\" >
                                    <thead class=\"head-table\">
                                        <tr class=\"nk-tb-item nk-tb-head\">
                                            <th class=\"nk-tb-col text-center\">NOME</th>
                                            <th class=\"nk-tb-col text-center\">CATEGORIA</th>
                                            <th class=\"nk-tb-col text-center\">CUSTO</th>
                                            <th class=\"nk-tb-col nk-tb-col-tools text-right\">OPÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 48));
        foreach ($context['_seq'] as $context["_key"] => $context["produto"]) {
            // line 49
            echo "                                            <tr class=\"nk-tb-item\">
                                                <td class=\"nk-tb-col text-center\">";
            // line 50
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "name", [], "any", false, false, false, 50));
            echo "</td>
                                                <td class=\"nk-tb-col text-center\">";
            // line 51
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "category", [], "any", false, false, false, 51));
            echo " </td>
                                                <td class=\"nk-tb-col text-center\">";
            // line 52
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "price", [], "any", false, false, false, 52));
            echo " </td>
                                                <td class=\"nk-tb-col text-center nk-tb-col-tools\">
                                                    <div class=\"dropdown\">
                                                        <a class=\"text-soft dropdown-toggle btn btn-icon btn-trigger\" data-bs-toggle=\"dropdown\" data-offset=\"-8,0\"><em class=\"icon ni ni-more-h\"></em></a>
                                                        <div class=\"dropdown-menu dropdown-menu-xs\">
                                                                <ul class=\"link-list-plain\">
                                                                    <li><a href=\"/produtos/produto/update/";
            // line 58
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "id", [], "any", false, false, false, 58));
            echo "\" class=\"text-primary\">Editar</a></li>
                                                                    <li><a href=\"#\" class=\"text-danger btn_delete_tax\" data-id=\"";
            // line 59
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["imposto"] ?? null), "id", [], "any", false, false, false, 59));
            echo "\">Excluir</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>                                       
                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['produto'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 66
        echo "                                    </tbody>
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
        // line 80
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 81
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 81), "var1", [], "any", false, false, false, 81), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 81), "var1", [], "any", false, false, false, 81), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 81), "var2", [], "any", false, false, false, 81), "html", null, true);
        echo ".js?ts=";
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "/produtos/produto/list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  152 => 81,  148 => 80,  132 => 66,  119 => 59,  115 => 58,  106 => 52,  102 => 51,  98 => 50,  95 => 49,  91 => 48,  56 => 18,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/produtos/produto/list.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\produtos\\produto\\list.twig");
    }
}
