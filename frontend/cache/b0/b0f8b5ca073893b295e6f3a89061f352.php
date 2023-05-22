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

/* /produtos/imposto/update.twig */
class __TwigTemplate_6364b740cb4d02acd572b9a946847245 extends Template
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
                        <h3 class=\"nk-block-title page-title\">Produtos / Imposto / <strong class=\"text-primary small\">Atualizando</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para atualizar imposto de produtos.</p>
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
                                <form name=\"formCreate\" id=\"formCreate\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\">
                                     <div class=\"row gy-4\">
                                        <div class=\"col-sm-6\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"nome\">Nome</label>
                                                <div class=\"form-control-wrap\">
                                                    <input type=\"text\" class=\"form-control input_name\" name=\"name\" value=\"";
        // line 36
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 36), "name", [], "any", false, false, false, 36), "html", null, true);
        echo "\" placeholder=\"Nome completo do imposto...\" autocomplete=\"off\" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=\"col-sm-6\">
                                            <div class=\"form-group\">
                                                <label class=\"form-label\" for=\"codigo\">Percentual</label>
                                                <div class=\"form-control-wrap\">
                                                   <div class=\"form-control-wrap \">
                                                         <input type=\"text\" class=\"form-control input_percentage input_percentage\" name=\"percentage\" value=\"";
        // line 45
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 45), "percentage", [], "any", false, false, false, 45), "html", null, true);
        echo "\" placeholder=\"Percentual...\" autocomplete=\"off\" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                    <hr class=\"preview-hr\">
                                    <div class=\"row gy-4\">
                                        <div class=\"col-12\">
                                            <div class=\"form-group text-end\">
                                                <input type=\"hidden\" name=\"tax_id\" class=\"input_tax_id\" value=\"";
        // line 56
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "conteudo", [], "any", false, false, false, 56), "id", [], "any", false, false, false, 56), "html", null, true);
        echo "\">
                                                <button type=\"button\" class=\"btn btn-lg btn-primary w-xs-100 d-inline btn_update_tax\">Salvar Alterações</button>
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
        // line 72
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/";
        // line 73
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 73), "var1", [], "any", false, false, false, 73), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 73), "var2", [], "any", false, false, false, 73), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 73), "var2", [], "any", false, false, false, 73), "html", null, true);
        echo ".js?ts=";
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "/produtos/imposto/update.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  128 => 73,  124 => 72,  105 => 56,  91 => 45,  79 => 36,  55 => 17,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/produtos/imposto/update.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\produtos\\imposto\\update.twig");
    }
}
