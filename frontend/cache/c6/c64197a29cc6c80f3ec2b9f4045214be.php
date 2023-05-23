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

/* /pedidos/vendas/checkout.twig */
class __TwigTemplate_60268d41ee11b032124031a5de325cd0 extends Template
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
        $context["CLIENTE"] = twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 1), "ITENS", [], "any", false, false, false, 1);
        // line 2
        echo "
<div class=\"container-fluid\">
    <div class=\"nk-content-inner\">
        <div class=\"nk-content-body\">
            <div class=\"nk-block-head nk-block-head-sm\">
                <div class=\"nk-block-between\">
                    <div class=\"nk-block-head-content\">
                        <h3 class=\"nk-block-title page-title\">Vendas / <strong class=\"text-primary small\">Finalizar Pedido</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela de checkout para finalizar venda.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class=\"nk-block-head-content\">
                        <div class=\"toggle-wrap nk-block-tools-toggle\">
                            <a href=\"#\" class=\"btn btn-icon btn-trigger toggle-expand mr-n1\" data-target=\"pageMenu\"><em class=\"icon ni ni-menu-alt-r\"></em></a>
                            <div class=\"toggle-expand-content\" data-content=\"pageMenu\">
                                <ul class=\"nk-block-tools g-2\">
                                    <li class=\"w-xs-100\"><a href=\"/";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var1", [], "any", false, false, false, 19), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var2", [], "any", false, false, false, 19), "html", null, true);
        echo "/create\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\"><em class=\"icon ni ni-curve-up-left\"></em><span class=\"d-none d-sm-inline-block\">Voltar</span></a></li> 
                                </ul>
                            </div>
                        </div><!-- .toggle-wrap -->
                    </div><!-- .nk-block-head-content -->                    
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class=\"nk-block\">
                <div class=\"card card-bordered\">                   
                    <div class=\"card-inner\">
                        <div class=\"card-head mb-4 block_DadosCliente\">
                            <h5 class=\"card-title mb-0 py-1\">Dados Básicos</h5>
                        </div>                         
                        <div class=\"table-responsive\">
                            <table class=\"table table-hover\" id=\"tableProdutos\">
                                <thead class=\"table-dark\">
                                    <tr>
                                        <th scope=\"col\">#</th>
                                        <th scope=\"col\">Nome</th>
                                        <th scope=\"col\" class=\"text-center\">Preço</th>
                                        <th scope=\"col\" class=\"text-center\">Quantidade</th>
                                        <th scope=\"col\" class=\"text-center\">Imposto</th>
                                        <th scope=\"col\" class=\"text-center w-15\">Total</th>
                                    </tr>
                                </thead>
                                <tbody id=\"recebeProdutosVenda\">
                                   
                                                     
                                </tbody>
                                <hr />
                                <tfoot>
                                    <tr>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"1\">
                                            <h5 class=\"mt-3 text-center\">Total </h5>
                                        </td>
                                        <td style=\"width: 160px\">
                                        <h5 class=\"mt-3 price_total text-center\">
                                            R\$ 0,00
                                        </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                                <tfoot>
                                    <tr>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"1\">
                                            <h5 class=\"mt-3 text-center\">Subtotal </h5>
                                        </td>
                                        <td style=\"width: 160px\">
                                            <h5 class=\"mt-3 price_subtotal text-center\">
                                            R\$ 0,00
                                            </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                                <tfoot>
                                    <tr>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"2\"></td>
                                        <td colspan=\"1\">
                                            <h5 class=\"mt-3 text-center\">Imposto </h5>
                                        </td>
                                        <td style=\"width: 160px\">
                                            <h5 class=\"mt-3 price_tax text-center\">
                                            R\$ 0,00
                                            </h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> 
                        <hr class=\"preview-hr\">
                        <div class=\"row gy-4\">
                            <div class=\"col-12\">
                                <div class=\"form-group text-end\">
                                    <button type=\"button\" class=\"btn btn-lg btn-primary w-xs-100 d-inline btn_save_sales\">Finalizar Pedido</button>
                                </div>
                            </div>                                        
                        </div>                        
                    </div>
                </div>
            </div><!-- .nk-block -->
        </div>
    </div>
</div>


<!-- LOAD EXTRA FILES -->
";
        // line 110
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/pedidos/vendas/checkout.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "/pedidos/vendas/checkout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 110,  58 => 19,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pedidos/vendas/checkout.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\pedidos\\vendas\\checkout.twig");
    }
}
