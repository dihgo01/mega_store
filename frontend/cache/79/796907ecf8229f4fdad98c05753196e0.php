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

/* /pedidos/vendas/create.twig */
class __TwigTemplate_707130c57cec1aa5e033daaa4f1557ff extends Template
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
                        <h3 class=\"nk-block-title page-title\">Vendas / <strong class=\"text-primary small\">Novo Pedido</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para cadastrar nova venda.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class=\"nk-block-head-content\">
                        <div class=\"toggle-wrap nk-block-tools-toggle\">
                            <a href=\"#\" class=\"btn btn-icon btn-trigger toggle-expand mr-n1\" data-target=\"pageMenu\"><em class=\"icon ni ni-menu-alt-r\"></em></a>
                            <div class=\"toggle-expand-content\" data-content=\"pageMenu\">
                                <ul class=\"nk-block-tools g-2\">
                                    <li class=\"w-xs-100 d-block-inline d-sm-none\"><a href=\"javascript:void(0);\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline toggle\" data-target=\"userAside\"><em class=\"icon ni ni-cart\"></em><span>Carrinho</span></a></li> 
                                    <li class=\"w-xs-100\"><a href=\"/";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 18), "var1", [], "any", false, false, false, 18), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 18), "var2", [], "any", false, false, false, 18), "html", null, true);
        echo "/list\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\"><em class=\"icon ni ni-curve-up-left\"></em><span>Voltar</span></a></li> 
                                </ul>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
            <div class=\"nk-block\">
                <div class=\"card card-bordered card-stretch\">
                    <div class=\"card-inner-group\">
                        <div class=\"card-inner\">
                            <div class=\"row g-gs\" id=\"recebeProdutos\">
                                ";
        // line 30
        if (twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 30)) {
            // line 31
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 31));
            foreach ($context['_seq'] as $context["_key"] => $context["produto"]) {
                // line 32
                echo "                                        <div class=\"col-sm-6 col-lg-4 col-xl-6 col-xxl-3 col-12\">
                                                            <div class=\"gallery card card-bordered\">

                                                                <a class=\"gallery-image popup-image\"
                                                                    href=\"\">
                                                                    <img class=\"w-100 rounded-top\"
                                                                    style=\"max-height: 376px; min-height: 376px;\"
                                                                        src=\"https://rocketseat-cdn.s3-sa-east-1.amazonaws.com/modulo-redux/tenis1.jpg\"
                                                                        alt=\"\">
                                                                </a>
                                                                <div
                                                                    class=\"gallery-body card-inner align-center justify-between flex-wrap\">
                                                                    <div class=\"col-12\">
                                                                        <h4 class=\"h4 fw-500 block-with-text txt-ellipses\"
                                                                            data-bs-tooltip=\"tooltip\"
                                                                            data-bs-placement=\"top\"
                                                                            title=\"";
                // line 48
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "name", [], "any", false, false, false, 48));
                echo "\">
                                                                            ";
                // line 49
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "name", [], "any", false, false, false, 49));
                echo "
                                                                        </h4>
                                                                    </div>

                                                                </div>
                                                                <div class=\"gallery-body align-center justify-between flex-wrap mb-2 mt-2 row\"
                                                                    style=\"padding-left: 1.5rem; padding-right: 1.5rem;\">

                                                                    <div class=\"col-12 col-md-12\">
                                                                        <span class=\"sub-text\">PREÇO </span>
                                                                        <span
                                                                            class=\"h4 fw-500 text-primary\">";
                // line 60
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "price", [], "any", false, false, false, 60));
                echo "</span>
                                                                    </div>
                                                                </div>
                                                                <div class=\"gallery-body align-center justify-center flex-wrap mb-2 row\"
                                                                    style=\"padding-left: 5.5rem; padding-right: 5.5rem;\">
                                                                        <button
                                                                            class=\"btn btn-primary add_cart p-1\"
                                                                            data-id=\"";
                // line 67
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["produto"], "id", [], "any", false, false, false, 67));
                echo "\"
                                                                            type=\"submit\"><em class=\"icon ni ni-cart\"
                                                                                style=\"margin-bottom:4px;\"></em>
                                                                            <span class=\"text-center\"
                                                                                style=\"margin-top: 2px; margin-bottom:2px;\">Adicionar</span></button>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['produto'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 78
            echo "                                ";
        } else {
            // line 79
            echo "                                    <div class=\"d-flex justify-content-center align-items-center\" style=\"height: 550px;\">
                                        <div>
                                            <h3 class=\"text-center\"><em
                                                class=\"icon ni ni-info text-center\"
                                                style=\"font-size: 60px;\"></em></h3>
                                            <h3 class=\"h4 fw-700 text-center\">Ops! Nenhum produto encontrado</h3>
                                            <h6 class=\"text-muted text-center\">Por enquanto não há
                                                produtos adicionado para esta loja. Por favor entre em
                                                contato com responsável.</h6>
                                        </div>
                                    </div>
                                ";
        }
        // line 91
        echo "                            </div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- LOAD EXTRA FILES -->
";
        // line 102
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 103
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 103), "var1", [], "any", false, false, false, 103), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 103), "var2", [], "any", false, false, false, 103), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 103), "var2", [], "any", false, false, false, 103), "html", null, true);
        echo ".js\"></script>";
    }

    public function getTemplateName()
    {
        return "/pedidos/vendas/create.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  177 => 103,  173 => 102,  160 => 91,  146 => 79,  143 => 78,  126 => 67,  116 => 60,  102 => 49,  98 => 48,  80 => 32,  75 => 31,  73 => 30,  56 => 18,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pedidos/vendas/create.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\pedidos\\vendas\\create.twig");
    }
}
