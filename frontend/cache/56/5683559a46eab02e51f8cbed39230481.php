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

/* home.twig */
class __TwigTemplate_9434e5e54ddf2d6202c105277912fd8d extends Template
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
        $this->parent = $this->loadTemplate("templates/main.twig", "home.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo " Mega Store ";
    }

    // line 4
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "<div class=\"container-fluid\">

    <div class=\"nk-content-inner\">
        <div class=\"nk-content-body\">
            <div class=\"nk-block\">
                <div class=\"card card-bordered card-stretch\">
                    <div class=\"row flex-lg-row-reverse align-items-center g-5 py-5 px-5\">
                        <div class=\"col-10 col-sm-8 col-lg-6\">
                            <div class=\"embed-responsive embed-responsive-16by9 mb-4\">
                            </div>
                            <img src=\"/assets/images/colecao-translacao.png\" class=\"d-block mx-lg-auto img-fluid d-none\" alt=\"Bootstrap Themes\" width=\"700\" height=\"500\" loading=\"lazy\">
                        </div>
                        <div class=\"col-lg-6\">
                            <h1 class=\"display-5 fw-bold lh-1 mb-3\">Coleção Tons</h1>
                            <p class=\"lead\">Confira como foi a Live de Lançamento da Coleção Tons que aconteceu no dia 26/11.</p>
                            <div class=\"d-grid gap-2 d-md-flex justify-content-md-start\">
                                <button type=\"button\" class=\"btn btn-primary btn-xl p-3 me-md-2 d-none\">Saiba Mais</button>
                            </div>
                        </div>
                    </div> <!-- ROW -->

                    <hr>

                    <div class=\"row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5 px-5\">
                        <div class=\"col\">
                            <div class=\"card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg img-bg-black\" style=\"background-image: url('/assets/images/home-001.webp');\">
                                <div class=\"d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1\">
                                    <h2 class=\"pt-5 mt-5 mb-4 display-6 lh-1 fw-bold\">Coturno for Trips</h2>
                                </div>
                            </div>
                        </div>

                        <div class=\"col\">
                            <div class=\"card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg img-bg-black\" style=\"background-image: url('/assets/images/home-002.webp');\">
                                <div class=\"d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1\">
                                    <h2 class=\"pt-5 mt-5 mb-4 display-6 lh-1 fw-bold\">Botas para o meu inverno</h2>
                                </div>
                            </div>
                        </div>

                        <div class=\"col\">
                            <div class=\"card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg img-bg-black\" style=\"background-image: url('/assets/images/home-003.webp');\">
                                <div class=\"d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1\">
                                    <h2 class=\"pt-5 mt-5 mb-4 display-6 lh-1 fw-bold\">Cores para animar as festas</h2>
                                </div>
                            </div>
                        </div>

                    </div> <!-- ROW -->                    
                </div> <!-- CARD -->
            </div> <!-- NK BLOCK -->
        </div>
    </div>
</div>

<!-- LOAD EXTRA FILES -->
";
        // line 61
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
";
    }

    public function getTemplateName()
    {
        return "home.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 61,  58 => 5,  54 => 4,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "home.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\home.twig");
    }
}
