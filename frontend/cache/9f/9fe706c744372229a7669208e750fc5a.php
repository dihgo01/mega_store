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

/* templates/main.twig */
class __TwigTemplate_0683b653e0ed6316e2841dd7d3c99d9c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"pt-BR\" class=\"js\">
<head>
<!-- META TAGS -->
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='author' content='' />
<meta name='creator' content='' />
<meta name='copyright' content='' />
<meta name='url' content='' />
<meta name='language' content='pt-BR' />
<meta name='robots' content='noindex,nofollow' />
<link rel='alternate' href='' hreflang='pt-BR' />
<link rel='canonical' href='' />
<!-- META TAGS -->

<title>";
        // line 18
        $this->displayBlock('title', $context, $blocks);
        echo "</title>


<!-- CACHE -->
<meta http-equiv=\"cache-control\" content=\"max-age=0\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\" />
<meta http-equiv=\"expires\" content=\"0\" />
<meta http-equiv=\"expires\" content=\"Tue, 01 Jan 1980 1:00:00 GMT\" />
<meta http-equiv=\"pragma\" content=\"no-cache\" />
<!-- CACHE -->

<!-- FAVICON -->
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"/assets/images/favicon/favicon.png\">
<meta name=\"msapplication-TileColor\" content=\"#ffffff\">
<meta name=\"theme-color\" content=\"#ffffff\">
<!-- FAVICON -->

<!-- CSS -->
<link rel=\"stylesheet\" href=\"/assets/css/dashlite.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/libs/fontawesome-icons-6.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/qv-custom.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/qv-plugins.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/theme.css?ver=3.0.2\">
<!-- CSS -->
</head>

<body class=\"nk-body bg-lighter npc-general has-sidebar\">

    <div class=\"nk-app-root\">
        <div class=\"nk-main \"> 
            ";
        // line 48
        echo twig_include($this->env, $context, "sidebar.twig");
        echo "
            <div class=\"nk-wrap\">
                ";
        // line 50
        echo twig_include($this->env, $context, "topo.twig");
        echo "
                <div class=\"nk-content \">
                ";
        // line 52
        $this->displayBlock('content', $context, $blocks);
        // line 53
        echo "                </div>     
            </div> 
        </div> 
    </div>  

<div id=\"addProductCart\" class=\"nk-add-product toggle-slide toggle-slide-right\" data-content=\"addProductCart\"
    data-toggle-screen=\"any\" data-toggle-overlay=\"true\" data-toggle-body=\"true\" data-simplebar>
        <div class=\"card-inner-group\" data-simplebar>
                <div class=\"card-inner card-inner-sm\">
                    <h5 class=\"text-center my-2\">Carrinho de Produtos</h5>
                    <ul class=\"btn-toolbar justify-center gx-1\">
                        <li class=\"d-none\"><a href=\"javascript:void(0);\" class=\"btn btn-trigger btn-icon\"
                                data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\"
                                title=\"Salvar Pedido como Rascunho\"><em class=\"icon ni ni-save\"></em></a></li>
                        <li class=\"d-flex\"><a href=\"#inputBiparCaixas\" id=\"sku_bipe\" class=\"btn btn-trigger btn-icon\"
                                data-bs-toggle=\"collapse\" data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\"
                                title=\"Bipar Caixas\"><i class=\"far fa-scanner-gun px-2\"></i></a></li>
                        <li><a href=\"javascript:void(0);\" class=\"btn btn-trigger btn-icon text-danger cleanSales\"
                                data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\" title=\"Limpar Carrinho Inteiro\"
                                data-id=\"\">
                                <em class=\"icon ni ni-na\"></em></a></li>
                    </ul>
                    <div class=\"collapse\" id=\"inputBiparCaixas\">
                        <div class=\"card card-body\">
                            <div class=\"form-group text-center\">
                                <label class=\"form-label\" for=\"sku_bipe_sales\">Bipando Caixas - SKU</label>
                                <div class=\"form-control-wrap\">
                                    <div class=\"input-group\">
                                        <input type=\"text\" class=\"form-control search_sku_sales\" id=\"sku_bipe_sales\"
                                            name=\"sku_bipe\" placeholder=\"00000000000000\" maxlength=\"14\"
                                            oninput=\"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\\..*)\\./g, '\$1');\"
                                            anpaste=\"sku_bipe(this);\">
                                        <div class=\"input-group-append\">
                                            <button type=\"button\"
                                                class=\"btn btn-outline-success btn-dim add_product_sku\"
                                                data-id=\"\"
                                                data-bs-tooltip=\"tooltip\" data-bs-placement=\"top\"
                                                title=\"Adicionar desconto\"><em class=\"icon ni ni-check\"></em></button>
                                        </div>
                                    </div>
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
                                        <span class=\"fs-15px\" id=\"shopCartSubTotalSale\"
                                            data-valor=\"0\">0,00</span>
                                    </div>
                                </div>
                                <div class=\"profile-balance-subtitle mt-0 fs-11px\">SubTotal</div>
                            </div>
                            <div class=\"profile-balance-sub\">
                                <div class=\"profile-balance-amount\">
                                    <div class=\"number\">
                                        <small class=\"currency currency-usd fs-12px\">R\$</small>
                                        <span class=\"fs-15px\" id=\"shopCartSalesDiscount\"
                                            data-valor=\"0\">0,00</span>
                                    </div>
                                </div>
                                <div class=\"profile-balance-subtitle mt-0 fs-11px\">Descontos</div>
                            </div>
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
                </div><!-- .card-inner -->
                <div class=\"card-inner px-0 py-0\">
                    <ul class=\"list-group list-group-flush\" id=\"shopCart_Sales\" data-desconto-tipo=\"Nenhum\"
                        data-desconto=\"0.00\">
                            <li class=\"list-group-item list_item_grid_sales\"
                                    data-id=\"\">
                                    <div class=\"row p-0 align-items-center\">
                                        <div class=\"col-2 p-0 mb-1\">
                                            <img class=\"icon me-1 img-fluid rounded-circle\"
                                                src=\"/assets/images/no_product.jpg\"
                                                alt=\"Quinta Valentina\">
                                        </div> <!-- COL -->
                                        <div class=\"col-8 px-1 py-0 mb-1\">
                                            <p class=\"fs-12px mb-0\">
                                               Produto Excluido
                                            </p>
                                        </div> <!-- COL -->
                                        <div class=\"col-2 p-0 mb-1\">
                                            <a href=\"javascript:void(0);\"
                                                class=\"btn btn-sm btn-outline-danger btnRemoverCartSales\"
                                                data-id=\"\"><i class=\"fas fa-trash\"></i></a>
                                        </div> <!-- COL -->
                                        <div class=\"display-11 col-12\">

                                        </div>
                                        <div class=\"col-5\">
                                            <h5 class=\"display-11 text-center\">Quantidade</h5>
                                            <div class=\"form-control-wrap number-spinner-wrap\">
                                                <button
                                                    class=\"btn btn-icon btn-outline-light number-spinner-btn number-minus remove_number_cart_sale\"
                                                    data-id=\"\" data-number=\"minus-qv\"><em
                                                        class=\"icon ni ni-minus\"></em></button>
                                                <input type=\"number\"
                                                    class=\"form-control number-spinner input_qtd_sales_\"
                                                    value=\"0\" min=\"1\" readonly=\"\">
                                                <button
                                                    class=\"btn btn-icon btn-outline-light number-spinner-btn number-plus add_number_cart_sale\"
                                                    data-id=\"\" data-number=\"plus-qv\"><em
                                                        class=\"icon ni ni-plus\"></em></button>
                                            </div>
                                        </div> <!-- COL -->
                                        <div class=\"col-3\">
                                            <h5 class=\"display-11 text-center\">Grade</h5>
                                            <div class=\"form-control-wrap\">
                                                <input type=\"number\" class=\"form-control\"
                                                    value=\"32\"
                                                    readonly=\"\">
                                            </div>
                                        </div> <!-- COL -->
                                        <div class=\"col-4\">
                                            <h5 class=\"display-11 text-center \">Preço</h5>
                                            <div class=\"form-control-wrap\">
                                                <input type=\"hidden\"
                                                    class=\"form-control input_price_sales_\"
                                                    value=\"154\">
                                                <input type=\"text\"
                                                    class=\"form-control price_input_sales_\"
                                                    value=\"2\"
                                                    readonly=\"\">
                                            </div>
                                        </div>
                                    </div> <!-- COL -->
                                </li>
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
      
</div><!-- .card-aside -->

</body>
</html>";
    }

    // line 18
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 52
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "templates/main.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  277 => 52,  271 => 18,  103 => 53,  101 => 52,  96 => 50,  91 => 48,  58 => 18,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "templates/main.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\templates\\main.twig");
    }
}
