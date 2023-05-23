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

    ";
        // line 58
        echo twig_include($this->env, $context, "shopcart.twig");
        echo "

    <!-- MODAL USER -->
    <div class=\"modal fade\" id=\"modalUser\" tabindex=\"-1\" aria-labelledby=\"modalUser\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable\" role=\"document\">
            <div class=\"modal-content\">
                <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Faça seu cadastro</h5>
                </div>
                <div class=\"modal-body\">
                    <form action=\"\"
                        class=\"g-3 needs-validation\" novalidate
                        method=\"POST\" enctype=\"multipart/form-data\">
                        <div class=\"row g-4\">
                            <div class=\"col-12 col-md-12\">
                                <label class=\"form-label\" for=\"name\">Nome</label>
                                <input type=\"text\" class=\"form-control input_name required\" name=\"name\" placeholder=\"Nome...\" required>
                                </select>
                            </div>
                            <div class=\"col-12 col-md-12\">
                                <label class=\"form-label\" for=\"email\">E-mail</label>
                                <input type=\"email\" class=\"form-control input_email required\" name=\"email\" placeholder=\"E-mail...\" required>
                                </select>
                            </div>
                           <div class=\"col-12 col-md-12\">
                                <label class=\"form-label\" for=\"passsword\">Senha</label>
                                <input type=\"text\" class=\"form-control input_password required\" name=\"password\" placeholder=\"Senha...\" required autocomplete=\"off\">
                                </select>
                            </div>
                        </div> <!-- ROW -->
                        <div class=\"row gy-4 \">
                            <div class=\"col-12\">
                                <div class=\"form-group text-end\">
                                    <button type=\"button\" class=\"btn btn-primary w-xs-100 d-inline submit_register_user\">Salvar</button>
                                </div>
                            </div>
                        </div> <!-- ROW -->
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
    <!-- .modal -->

     <!-- MODAL USER -->
    <div class=\"modal fade\" id=\"modalSession\" tabindex=\"-1\" aria-labelledby=\"modalSession\" aria-hidden=\"true\">
        <div class=\"modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable\" role=\"document\">
            <div class=\"modal-content\">
                <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Login</h5>
                </div>
                <div class=\"modal-body\">
                    <form action=\"\"
                        class=\"g-3 needs-validation\" novalidate
                        method=\"POST\" enctype=\"multipart/form-data\">
                        <div class=\"row g-4\">
                            <div class=\"col-12 col-md-12\">
                                <label class=\"form-label\" for=\"email\">E-mail</label>
                                <input type=\"email\" class=\"form-control input_email_session required_session\" name=\"email\" placeholder=\"E-mail...\" required>
                                </select>
                            </div>
                           <div class=\"col-12 col-md-12\">
                                <label class=\"form-label\" for=\"passsword\">Senha</label>
                                <input type=\"text\" class=\"form-control input_password_session required_session\" name=\"password\" placeholder=\"Senha...\" required autocomplete=\"off\">
                                </select>
                            </div>
                        </div> <!-- ROW -->
                        <div class=\"row gy-4 \">
                            <div class=\"col-12\">
                                <div class=\"form-group text-end\">
                                    <button type=\"button\" class=\"btn btn-primary w-xs-100 d-inline submit_register_session\">Salvar</button>
                                </div>
                            </div>
                        </div> <!-- ROW -->
                    </form>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
    <!-- .modal -->

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
        return array (  205 => 52,  199 => 18,  110 => 58,  103 => 53,  101 => 52,  96 => 50,  91 => 48,  58 => 18,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "templates/main.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\templates\\main.twig");
    }
}
