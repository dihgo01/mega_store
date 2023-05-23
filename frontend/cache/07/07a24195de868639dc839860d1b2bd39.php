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

/* pedidos.twig */
class __TwigTemplate_ee052a7ee1ac92d53acff1c5e1fe713e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "templates/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("templates/main.twig", "pedidos.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Mega Store";
    }

    // line 4
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "
    ";
        // line 7
        echo "    ";
        if (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 7), "var3", [], "any", false, false, false, 7) == "update") && twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 7), "var4", [], "any", false, false, false, 7)))) {
            // line 8
            echo "        ";
            $context["urlRedirect"] = (((("/" . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 8), "var1", [], "any", false, false, false, 8)) . "/") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 8), "var2", [], "any", false, false, false, 8)) . "/list");
            // line 9
            echo "        <script>window.location = '";
            echo twig_escape_filter($this->env, ($context["urlRedirect"] ?? null), "html", null, true);
            echo "';</script>
    ";
        } else {
            // line 11
            echo "        ";
            // line 12
            echo "        ";
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 12), "var3", [], "any", false, false, false, 12))) {
                // line 13
                echo "            ";
                $this->loadTemplate((((((("/" . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 13), "var1", [], "any", false, false, false, 13)) . "/") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 13), "var2", [], "any", false, false, false, 13)) . "/") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 13), "var3", [], "any", false, false, false, 13)) . ".twig"), "pedidos.twig", 13)->display($context);
                // line 14
                echo "        ";
            } else {
                // line 15
                echo "            ";
                $this->loadTemplate((((((("/" . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 15), "var1", [], "any", false, false, false, 15)) . "/") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 15), "var2", [], "any", false, false, false, 15)) . "/") . twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 15), "var2", [], "any", false, false, false, 15)) . ".twig"), "pedidos.twig", 15)->display($context);
                // line 16
                echo "        ";
            }
            // line 17
            echo "       
    ";
        }
        // line 19
        echo "
";
    }

    public function getTemplateName()
    {
        return "pedidos.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 19,  90 => 17,  87 => 16,  84 => 15,  81 => 14,  78 => 13,  75 => 12,  73 => 11,  67 => 9,  64 => 8,  61 => 7,  58 => 5,  54 => 4,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pedidos.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\pedidos.twig");
    }
}
