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

/* /produtos/categoria/create.twig */
class __TwigTemplate_046c6beac312e36c3d7621c39fd01cbd extends Template
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
                        <h3 class=\"nk-block-title page-title\">Produtos / Categorias / <strong class=\"text-primary small\">Nova</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para cadastrar novas categorias de produtos.</p>
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
                                                <label class=\"form-label\" for=\"nome\">Nome</label>
                                                <div class=\"form-control-wrap\">
                                                    <input type=\"text\" class=\"form-control\" name=\"name\" placeholder=\"Nome completo da categoria...\" autocomplete=\"off\" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=\"col-sm-6\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"codigo\">Imposto</label>
                                                <div class=\"form-control-wrap\">
                                                   <div class=\"form-control-wrap \">
                                                        <select name=\"tax_id\" id=\"tax_id\" class=\"form-control qvSelect2\" data-search=\"on\" required>
                                                            <option></option>
                                                            ";
        // line 47
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 47));
        foreach ($context['_seq'] as $context["_key"] => $context["imposto"]) {
            // line 48
            echo "                                                                <option value=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["imposto"], "id", [], "any", false, false, false, 48));
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["imposto"], "name", [], "any", false, false, false, 48));
            echo "</option>
                                                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['imposto'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
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
                                                <button type=\"submit\" class=\"btn btn-lg btn-primary w-xs-100 d-inline\">Cadastrar</button>
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
        // line 76
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 77
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 77), "var1", [], "any", false, false, false, 77), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 77), "var2", [], "any", false, false, false, 77), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 77), "var2", [], "any", false, false, false, 77), "html", null, true);
        echo ".js?ts=";
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script>
\$(function(){
\tqv_create.init(\"#formCreate\");
});
</script>";
    }

    public function getTemplateName()
    {
        return "/produtos/categoria/create.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  137 => 77,  133 => 76,  105 => 50,  94 => 48,  90 => 47,  55 => 17,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/produtos/categoria/create.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\produtos\\categoria\\create.twig");
    }
}
