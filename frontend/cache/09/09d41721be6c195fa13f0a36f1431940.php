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

/* /sidebar/fms.twig */
class __TwigTemplate_e61dbeef9522cd2f1102309e72e42851 extends Template
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
        echo "<li class=\"nk-menu-heading pt-4\">
    <h6 class=\"overline-title text-primary-alt\">Franquia</h6>
</li><!-- .nk-menu-heading -->
<li class=\"nk-menu-item\">
    <a href=\"/franquia/dashboard\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-growth\"></em></span>
        <span class=\"nk-menu-text\">Dashboard</span>
    </a>
</li><!-- .nk-menu-item -->                      
<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><i class=\"far fa-store\" style=\"font-size:120%;\"></i></span>
        <span class=\"nk-menu-text\">Vendas</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Nova Venda</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consulta</span></a>
        </li>
        ";
        // line 22
        if ((twig_get_attribute($this->env, $this->source, (($__internal_compile_0 = twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "franquias", [], "any", false, false, false, 22)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[twig_get_attribute($this->env, $this->source, ($context["authentication"] ?? null), "franquiaActive", [], "any", false, false, false, 22)] ?? null) : null), "tipo_franquia", [], "any", false, false, false, 22) == "Loja")) {
            // line 23
            echo "        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/caixa\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Caixa</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/vendedores\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Vendedores</span></a>
        </li> 
        ";
        }
        // line 29
        echo "                                                       
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/link_afiliado\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Link de Afiliado</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/vendas/reports\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Relatórios</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-users\"></em></span>
        <span class=\"nk-menu-text\">Clientes</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/clientes/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Cliente</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/clientes/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/clientes/aniversariantes\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Aniversariantes</span></a>
        </li>        
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-package\"></em></span>
        <span class=\"nk-menu-text\">Estoque</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/estoque/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/estoque/movimentacoes\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Movimentações</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/estoque/notas-fiscais\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Notas Fiscais</span></a>
        </li>
        <li class=\"nk-menu-item d-none\">
            <a href=\"/franquia/estoque/relatorios\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Relatórios</span></a>
        </li>                            
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-coins\"></em></span>
        <span class=\"nk-menu-text\">Financeiro</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item d-none\">
            <a href=\"/franquia/financeiro/dashboard\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Dashboard</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/financeiro/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Movimentações</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/financeiro/create\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Novo Lançamento</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><i class=\"far fa-suitcase-rolling\" style=\"font-size:150%;\"></i></span>
        <span class=\"nk-menu-text\">QV em Casa</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item d-none\">
            <a href=\"/franquia/qvemcasa/dashboard\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Dashboard</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/qvemcasa/list\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Consultar Pedidos</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item has-sub\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-help\"></em></span>
        <span class=\"nk-menu-text\">Ajuda</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/ajuda/faq\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Dúvidas Frequentes</span></a>
        </li>
        <li class=\"nk-menu-item d-none\">
            <a href=\"/franquia/ajuda/chamados\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Chamados</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->                    

<li class=\"nk-menu-item has-sub d-none\">
    <a href=\"#\" class=\"nk-menu-link nk-menu-toggle\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-cart-fill\"></em></span>
        <span class=\"nk-menu-text\">Compras</span>
    </a>
    <ul class=\"nk-menu-sub\">
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/compras/consulta\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Meus Pedidos</span></a>
        </li>
        <li class=\"nk-menu-item\">
            <a href=\"/franquia/compras/lojas\" class=\"nk-menu-link\"><span class=\"nk-menu-text\">Lojas Disponíveis</span></a>
        </li>
    </ul><!-- .nk-menu-sub -->
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item d-none\">
    <a href=\"/franquia/produtos\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><i class=\"far fa-shoe-prints\" style=\"font-size:120%;\"></i></span>
        <span class=\"nk-menu-text\">Produtos</span>
    </a>
</li><!-- .nk-menu-item -->                    

<li class=\"nk-menu-item d-none\">
    <a href=\"/franquia/link_afiliado\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><em class=\"icon ni ni-link\"></em></span>
        <span class=\"nk-menu-text\">Link de Afiliado</span>
    </a>
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-item d-none\">
    <a href=\"/franquia/marketing\" class=\"nk-menu-link\">
        <span class=\"nk-menu-icon\"><i class=\"far fa-bullhorn\" style=\"font-size:120%;\"></i></span>
        <span class=\"nk-menu-text\">Marketing</span>
    </a>
</li><!-- .nk-menu-item -->

<li class=\"nk-menu-heading pt-4\">
    <h6 class=\"overline-title text-primary-alt\">Intranet</h6>
</li><!-- .nk-menu-heading -->
<li class=\"nk-menu-item\">
    <a href=\"https://franquia.quintavalentina.com.br/backboard/fms\" class=\"nk-menu-link\" target=\"_blank\">
        <span class=\"nk-menu-icon\"><i class=\"fal fa-shopping-basket\"  style=\"font-size:120%;\"></i></span>
        <span class=\"nk-menu-text\">Pedido de Compra</span>
    </a>
</li><!-- .nk-menu-item -->";
    }

    public function getTemplateName()
    {
        return "/sidebar/fms.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 29,  62 => 23,  60 => 22,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/sidebar/fms.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\sidebar\\fms.twig");
    }
}
