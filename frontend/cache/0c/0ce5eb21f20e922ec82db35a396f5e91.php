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

/* /franquia/vendas/create.twig */
class __TwigTemplate_12d0b399020efa0a366a43d7dd8dadf5 extends Template
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
                                        <input type=\"search\" class=\"form-control border-transparent form-focus-none ps-0\" id=\"F_buscador\" placeholder=\"Digite o que deseja buscar...\">
                                        <button class=\"search-submit btn btn-icon\"><em class=\"icon ni ni-search\"></em></button>
                                    </div>
                                </div><!-- .card-tools -->
                                <div class=\"card-tools me-n1\">
                                    <ul class=\"btn-toolbar gx-1\">
                                        <li class=\"btn-toolbar-sep\"></li><!-- li -->
                                        <li>
                                            <div class=\"dropdown\">
                                                <a href=\"#\" class=\"btn btn-trigger btn-icon dropdown-toggle\" data-bs-toggle=\"dropdown\">
                                                    <em class=\"icon ni ni-filter-alt\"></em>
                                                </a>
                                                <div class=\"filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end\">
                                                    <div class=\"dropdown-head\">
                                                        <span class=\"sub-title dropdown-title\">Filtros de Produtos</span>
                                                    </div>
                                                    <div class=\"dropdown-body dropdown-body-rg\">
                                                        <div class=\"row gx-6 gy-3\">
                                                            <div class=\"col-12\">
                                                                <div class=\"form-group\">
                                                                    <label class=\"overline-title overline-title-alt\" for=\"F_categoria\">Categoria</label>
                                                                    <select name=\"F_categoria\" id=\"F_categoria\" class=\"form-select qvSelect2_noSearch\">
                                                                        <option value=\"0\">Todas</option>
                                                                        ";
        // line 55
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 55), "ITENS", [], "any", false, false, false, 55));
        foreach ($context['_seq'] as $context["_key"] => $context["categorias"]) {
            // line 56
            echo "                                                                            <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["categorias"], "ID", [], "any", false, false, false, 56));
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["categorias"], "NOME", [], "any", false, false, false, 56));
            echo "</option>
                                                                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['categorias'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 58
        echo "                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class=\"col-6\">
                                                                <div class=\"form-group\">
                                                                    <label class=\"overline-title overline-title-alt\" for=\"F_tamanho\">Tamanho</label>
                                                                    <select name=\"F_tamanho\" id=\"F_tamanho\" class=\"form-select qvSelect2_noSearch\">
                                                                        <option value=\"0\">Todos</option>
                                                                        <optgroup label=\"Sapatos\">
                                                                        <option value=\"33\">33</option>
                                                                        <option value=\"34\">34</option>
                                                                        <option value=\"35\">35</option>
                                                                        <option value=\"36\">36</option>
                                                                        <option value=\"37\">37</option>
                                                                        <option value=\"38\">38</option>
                                                                        <option value=\"39\">39</option>
                                                                        <option value=\"40\">40</option>
                                                                        </optgroup>
                                                                        <optgroup label=\"Bolsas e Carteiras\">
                                                                        <option value=\"01\">P</option>
                                                                        <option value=\"02\">M</option>
                                                                        <option value=\"03\">G</option>
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class=\"col-6\">
                                                                <div class=\"form-group\">
                                                                    <label class=\"overline-title overline-title-alt\" for=\"F_salto\">Salto</label>
                                                                    <select name=\"F_salto\" id=\"F_salto\" class=\"form-select js-select2\">
                                                                        <option value=\"0\" selected=\"selected\">Indiferente</option>
                                                                        <option value=\"Sem_Salto\">Sem Salto</option>
                                                                        <option value=\"Com_Salto\">Com Salto</option>
                                                                    </select>
                                                                </div>
                                                            </div>               
                                                            <div class=\"col-12\">
                                                                <div class=\"form-group\">
                                                                    <input type=\"hidden\" name=\"F_paginacao\" id=\"F_paginacao\" value=\"0\" />
                                                                    <input type=\"hidden\" name=\"F_order\" id=\"F_order\" value=\"cadastro\" />
                                                                    <button type=\"button\" id=\"btFiltrarProdutos\" class=\"btn btn-secondary d-block w-100\">Filtrar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .filter-wg -->
                                            </div><!-- .dropdown -->
                        
                                            <div class=\"dropdown\">
                                                <a href=\"#\" class=\"btn btn-trigger btn-icon dropdown-toggle\" data-bs-toggle=\"dropdown\">
                                                    <em class=\"icon ni ni-setting\"></em>
                                                </a>
                                                <div class=\"dropdown-menu dropdown-menu-sm dropdown-menu-end\">
                                                    <ul class=\"link-check\">
                                                        <li><span>Ordernar por</span></li>
                                                        <li class=\"active\" data-valor=\"cadastro\"><a href=\"javascript:void(0);\">Cadastro</a></li>
                                                        <li data-valor=\"nome\"><a href=\"javascript:void(0);\">Nome</a></li>
                                                    </ul>
                                                </div>
                                            </div><!-- .dropdown -->
                                                    
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                        </div><!-- .card-inner -->                        
                        <div class=\"card-inner\">

                            <div class=\"row\" id=\"recebeProdutos\"></div> <!-- ROW -->
                            
                        </div> <!-- CAARD INNER -->
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>


<!-- LOAD EXTRA FILES -->
";
        // line 138
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 139
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 139), "var1", [], "any", false, false, false, 139), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 139), "var2", [], "any", false, false, false, 139), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 139), "var2", [], "any", false, false, false, 139), "html", null, true);
        echo ".js\"></script>
<script src=\"/assets/js/views/";
        // line 140
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 140), "var1", [], "any", false, false, false, 140), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 140), "var2", [], "any", false, false, false, 140), "html", null, true);
        echo "/shopcart.js?ts=";
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script>
\$(function(){

    // ACIONADOR DO METODO
\tqv_create.init(\"#formCreate\");

    // TRIGERS
    \$(\"#btFiltrarProdutos\").trigger('click');
    
    // FUNCOES
    carregarShopCart();
    
});
</script>";
    }

    public function getTemplateName()
    {
        return "/franquia/vendas/create.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  207 => 140,  199 => 139,  195 => 138,  113 => 58,  102 => 56,  98 => 55,  56 => 18,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/franquia/vendas/create.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\franquia\\vendas\\create.twig");
    }
}
