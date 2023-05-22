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

/* /pedidos/shopcart.twig */
class __TwigTemplate_93a1586a59a8ff24c6c7a429984fdfcd extends Template
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
        echo "<div class=\"card-aside card-aside-right user-aside toggle-slide toggle-slide-right toggle-break-xxl\" data-content=\"userAside\" data-toggle-screen=\"xxl\" data-toggle-overlay=\"true\" data-toggle-body=\"true\" style=\"min-width:400px;\">
    <div class=\"card-inner-group\" data-simplebar>
        <div class=\"card-inner card-inner-sm\">
            <h5 class=\"text-center my-2\">Carrinho de Produtos</h5>
            <ul class=\"btn-toolbar justify-center gx-1\">
                <li class=\"d-none\"><a href=\"javascript:void(0);\" class=\"btn btn-trigger btn-icon\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\" title=\"Salvar Pedido como Rascunho\"><em class=\"icon ni ni-save\"></em></a></li>
                <li><a href=\"#inputBiparCaixas\" class=\"btn btn-trigger btn-icon\" data-bs-toggle=\"collapse\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\" title=\"Bipar Caixas\"><i class=\"far fa-scanner-gun px-2\"></i></a></li>
                <li><a href=\"javascript:void(0);\" class=\"btn btn-trigger btn-icon\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\" title=\"Atualizar Carrinho\" onclick=\"carregarShopCart(); return false;\"><em class=\"icon ni ni-reload-alt\"></em></a></li>
                <li><a href=\"javascript:void(0);\" class=\"btn btn-trigger btn-icon text-danger\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\" title=\"Limpar Carrinho Inteiro\" onclick=\"esvaziarCarrinho(); return false;\"><em class=\"icon ni ni-na\"></em></a></li>
            </ul>
            <div class=\"collapse\" id=\"inputBiparCaixas\">
                <div class=\"card card-body\">
                    <div class=\"form-group text-center\">
                        <label class=\"form-label\" for=\"sku_bipe\">Bipando Caixas - SKU</label>
                        <div class=\"form-control-wrap\">
                            <input type=\"text\" class=\"form-control\" id=\"sku_bipe\" name=\"sku_bipe\" placeholder=\"00000000000000\" maxlength=\"14\" oninput=\"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\\..*)\\./g, '\$1');\" anpaste=\"sku_bipe(this);\">
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .card-inner -->
        <div class=\"card-inner text-center\">
            <div class=\"overline-title-alt mb-2\">Resumo do Pedido</div>
            <div class=\"profile-balance\">
                <div class=\"profile-balance-group d-inline-flex gx-5\">
                    <div class=\"profile-balance-sub\">
                        <div class=\"profile-balance-amount\">
                            <div class=\"number\">
                                <small class=\"currency currency-usd fs-12px\">R\$</small> 
                                <span class=\"fs-15px\" id=\"shopCart_SubTotalPedido\" data-valor=\"0\">0,00</span>
                            </div>
                        </div>
                        <div class=\"profile-balance-subtitle mt-0 fs-11px\">SubTotal</div>
                    </div>
                    <div class=\"profile-balance-sub\">
                        <div class=\"profile-balance-amount\">
                            <div class=\"number\">
                                <small class=\"currency currency-usd fs-12px\">R\$</small> 
                                <span class=\"fs-15px\" id=\"shopCart_Descontos\"  data-valor=\"0\">0,00</span>
                            </div>
                        </div>
                        <div class=\"profile-balance-subtitle mt-0 fs-11px\">Descontos</div>
                    </div>
                    <div class=\"profile-balance-sub\">
                        <div class=\"profile-balance-amount\">
                            <div class=\"number\">
                                <small class=\"currency currency-usd fs-12px\">R\$</small> 
                                <span class=\"fs-15px\" id=\"shopCart_TotalPedido\" data-valor=\"0\">0,00</span>
                            </div>
                        </div>
                        <div class=\"profile-balance-subtitle mt-0 fs-11px\">Total</div>
                    </div>                                      
                </div>
            </div>
        </div><!-- .card-inner -->
        <div class=\"card-inner px-0 py-0\">
            <ul class=\"list-group list-group-flush\" id=\"shopCart_RecebeItens\">              
            </ul>
        </div><!-- .card-inner -->
        <div class=\"card-inner\">
            <a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary text-center w-100 mb-1 d-block toggle\" data-target=\"userAside\">
                Fechar
            </a>            
            <a href=\"/franquia/vendas/checkout\" id=\"btCheckout\" class=\"btn btn-primary text-center w-100 d-block d-none\">
                Ir para o Checkout
            </a>
        </div> <!-- card-inner-->
    </div><!-- .card-inner group -->
</div><!-- .card-aside -->";
    }

    public function getTemplateName()
    {
        return "/pedidos/shopcart.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/pedidos/shopcart.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\pedidos\\shopcart.twig");
    }
}
