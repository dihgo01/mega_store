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

/* /produtos/produto/create.twig */
class __TwigTemplate_7a71b9955a7c7632d6b22990e5a84f41 extends Template
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
                        <h3 class=\"nk-block-title page-title\">Produtos / <strong class=\"text-primary small\">Novo</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para cadastrar novos de produtos.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class=\"nk-block-head-content\">
                        <div class=\"toggle-wrap nk-block-tools-toggle\">
                            <a href=\"#\" class=\"btn btn-icon btn-trigger toggle-expand mr-n1\" data-target=\"pageMenu\"><em class=\"icon ni ni-menu-alt-r\"></em></a>
                            <div class=\"toggle-expand-content\" data-content=\"pageMenu\">
                                <ul class=\"nk-block-tools g-2\">
                                    <li class=\"w-xs-100\"><a href=\"/";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 17), "var1", [], "any", false, false, false, 17), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 17), "var2", [], "any", false, false, false, 17), "html", null, true);
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
                        <div class=\"card-inner\">
                            <div class=\"preview-block\">
                                <span class=\"preview-title-lg overline-title\">Dados Básicos</span>
                                <form name=\"formCreate\" id=\"formCreate\" method=\"post\" autocomplete=\"off\">
                                    <div class=\"row gy-4\">
                                        <div class=\"col-sm-6\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"name\">Nome</label>
                                                <div class=\"form-control-wrap\">
                                                    <input type=\"text\" class=\"form-control input_name required\" name=\"name\" placeholder=\"Nome completo do produto...\" autocomplete=\"off\" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=\"col-sm-6\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"price\">Preço</label>
                                                <div class=\"form-control-wrap\">
                                                   <div class=\"form-control-wrap \">
                                                         <input type=\"text\" class=\"form-control input_price maskMoney required\" name=\"price\" placeholder=\"R\$ 0,00\" autocomplete=\"off\" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class=\"col-sm-12\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"category_id\">Categoria</label>
                                                <div class=\"form-control-wrap\">
                                                   <div class=\"form-control-wrap \">
                                                        <select name=\"category_id required\" id=\"category_id\" class=\"form-control qvSelect2\" data-search=\"on\" required>
                                                            <option></option>
                                                            ";
        // line 57
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 57));
        foreach ($context['_seq'] as $context["_key"] => $context["categoria"]) {
            // line 58
            echo "                                                                <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["categoria"], "id", [], "any", false, false, false, 58));
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["categoria"], "category", [], "any", false, false, false, 58));
            echo "</option>
                                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['categoria'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 60
        echo "                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <hr class=\"preview-hr\">
                                    <div class=\"row gy-4\">
                                        <div class=\"col-12\">
                                            <div class=\"form-group text-end\">
                                                <button type=\"button\" class=\"btn btn-lg btn-primary w-xs-100 d-inline submit_register_product\">Cadastrar</button>
                                            </div>
                                        </div>                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->

            </div><!-- .nk-block -->
        </div>
    </div>
</div>

<!-- LOAD EXTRA FILES -->
";
        // line 87
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 88
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 88), "var1", [], "any", false, false, false, 88), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 88), "var1", [], "any", false, false, false, 88), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 88), "var2", [], "any", false, false, false, 88), "html", null, true);
        echo ".js?ts=";
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "/produtos/produto/create.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  148 => 88,  144 => 87,  115 => 60,  104 => 58,  100 => 57,  55 => 17,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/produtos/produto/create.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\produtos\\produto\\create.twig");
    }
}
