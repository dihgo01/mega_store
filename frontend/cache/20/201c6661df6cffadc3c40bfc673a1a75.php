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
        echo "<div id=\"addProductCart\" class=\"nk-add-product toggle-slide toggle-slide-right\" data-content=\"addProductCart\" data-toggle-screen=\"any\" data-toggle-overlay=\"true\" data-toggle-body=\"true\" data-simplebar>
    <div class=\"card-inner-group\" data-simplebar>
        <div class=\"card-inner card-inner-sm\">
            <h5 class=\"text-center my-2\">Carrinho de Produtos</h5>
        </div><!-- .card-inner -->
        <div class=\"card-inner text-center\">
            <div class=\"overline-title-alt mb-2\">Resumo do Pedido</div>

            <div class=\"profile-balance\">
                <div class=\"profile-balance-group d-inline-flex gx-5\">
                    <div class=\"profile-balance-sub\">
                        <div class=\"profile-balance-sub\">
                            <div class=\"profile-balance-amount\">
                                <div class=\"number\">
                                    <small class=\"currency currency-usd fs-12px\">R\$</small>
                                    <span class=\"fs-15px total_price\" id=\"shopCartSales\"
                                        data-valor=\"0\">0,00</span>
                                </div>
                            </div>
                            <div class=\"profile-balance-subtitle mt-0 fs-11px\">Total</div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .card-inner -->
        <div class=\"card-inner px-0 py-0\">
            <ul class=\"list-group list-group-flush\" id=\"shopCart_Sales\" >
            </ul>
        </div><!-- .card-inner -->
        <div class=\"card-inner footer-btn-sales\">
            <a href=\"javascript:void(0);\"
                class=\"btn btn-outline-secondary text-center w-100 mb-1 d-block toggle cartProductAdd\"
                data-target=\"addProductCart\">
                Fechar
            </a>
            <a href=\"/fms/sales-cart/finish/\" id=\"btCheckout\"
                class=\"btn btn-primary text-center w-100 d-block \">
                    Checkout da venda
            </a>
        </div> <!-- card-inner-->
    </div>
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
