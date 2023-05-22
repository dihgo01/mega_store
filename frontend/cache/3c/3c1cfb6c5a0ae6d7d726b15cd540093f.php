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

/* login.twig */
class __TwigTemplate_2e521ab46a9e2c7c24774199a246c9f9 extends Template
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

<!-- TITULO, KEYWORDS E DESCRIPTION -->
<title>Vitrine QV - Login</title>

<!-- FAVICON -->
<link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"/assets/images/favicon/apple-icon-57x57.png\">
<link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"/assets/images/favicon/apple-icon-60x60.png\">
<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"/assets/images/favicon/apple-icon-72x72.png\">
<link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"/assets/images/favicon/apple-icon-76x76.png\">
<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"/assets/images/favicon/apple-icon-114x114.png\">
<link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"/assets/images/favicon/apple-icon-120x120.png\">
<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"/assets/images/favicon/apple-icon-144x144.png\">
<link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"/assets/images/favicon/apple-icon-152x152.png\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"/assets/images/favicon/apple-icon-180x180.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"/assets/images/favicon/android-icon-192x192.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"/assets/images/favicon/favicon-32x32.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"/assets/images/favicon/favicon-96x96.png\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"/assets/images/favicon/favicon-16x16.png\">
<link rel=\"manifest\" href=\"/assets/images/favicon/manifest.json\">
<meta name=\"msapplication-TileColor\" content=\"#ffffff\">
<meta name=\"msapplication-TileImage\" content=\"/assets/images/favicon/ms-icon-144x144.png\">
<meta name=\"theme-color\" content=\"#ffffff\">
<!-- FAVICON -->

<!-- CSS -->
<link rel=\"stylesheet\" href=\"/assets/css/dashlite.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/libs/fontawesome-icons.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/qv-custom.css?ver=3.0.2\">
<link rel=\"stylesheet\" href=\"/assets/css/theme.css?ver=3.0.2\">
<!-- CSS -->
</head>

<body class=\"nk-body bg-white npc-general pg-auth\">

    <div class=\"nk-app-root\">
        <!-- main @s -->
        <div class=\"nk-main \">
            <!-- wrap @s -->
            <div class=\"nk-wrap nk-wrap-nosidebar\">
                <!-- content @s -->
                <div class=\"nk-content \">
                    <div class=\"nk-split nk-split-page nk-split-md\">
                        <div class=\"nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white\">
                            <div class=\"absolute-top-right d-lg-none p-3 p-sm-5\">
                                <a href=\"#\" class=\"toggle btn-white btn btn-icon btn-light\" data-target=\"athPromo\"><em class=\"icon ni ni-info\"></em></a>
                            </div>
                            <div class=\"nk-block nk-block-middle nk-auth-body pb-0\">
                                <div class=\"brand-logo pb-5\">
                                    <a href=\"";
        // line 65
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "urlProjeto", [], "any", false, false, false, 65), "html", null, true);
        echo "\" class=\"logo-link\">
                                        <img class=\"logo-light logo-img logo-img-lg\" src=\"/assets/images/qv-logo-black.png\" srcset=\"/assets/images/qv-logo-black.png 2x\" alt=\"logo\">
                                        <img class=\"logo-dark logo-img logo-img-lg\" src=\"/assets/images/qv-logo-black.png\" srcset=\"/assets/images/qv-logo-black.png 2x\" alt=\"logo-dark\">
                                    </a>
                                </div>
                                <div class=\"nk-block-head\">
                                    <div class=\"nk-block-head-content\">
                                        <h5 class=\"nk-block-title\">Login da Intranet </h5>
                                        <div class=\"nk-block-des\">
                                            <p>Acesse usando o seu e-mail e sua senha.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form action=\"";
        // line 78
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "urlProjeto", [], "any", false, false, false, 78), "html", null, true);
        echo "/login/validar\" id=\"formLogin\" class=\"form-validate is-alter\" method=\"post\" autocomplete=\"off\">
                                    <div class=\"form-group\">
                                        <div class=\"form-label-group\">
                                            <label class=\"form-label\" for=\"login\">E-mail ou Usuário</label>
                                            <a class=\"link link-primary link-sm\" tabindex=\"-1\" href=\"javascript:void(0);\">Precisa de Ajuda?</a>
                                        </div>
                                        <div class=\"form-control-wrap\">
                                            <input autocomplete=\"off\" type=\"text\" class=\"form-control form-control-lg\" required id=\"login\" name=\"login\" placeholder=\"Digite seu e-mail ou login\">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class=\"form-group\">
                                        <div class=\"form-label-group\">
                                            <label class=\"form-label\" for=\"senha\">Senha</label>
                                            <a class=\"link link-primary link-sm\" tabindex=\"-1\" href=\"/esqueci-minha-senha\">Esqueceu?</a>
                                        </div>
                                        <div class=\"form-control-wrap\">
                                            <a tabindex=\"-1\" href=\"#\" class=\"form-icon form-icon-right passcode-switch lg\" data-target=\"senha\">
                                                <em class=\"passcode-icon icon-show icon ni ni-eye\"></em>
                                                <em class=\"passcode-icon icon-hide icon ni ni-eye-off\"></em>
                                            </a>
                                            <input autocomplete=\"new-password\" type=\"password\" class=\"form-control form-control-lg\" required id=\"senha\" name=\"senha\" placeholder=\"Digite sua senha\">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class=\"form-group\">
                                        <button type=\"submit\" class=\"btn btn-lg btn-primary btn-block\">Entrar</button>
                                    </div>
                                </form><!-- form -->

                                ";
        // line 106
        if ((twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "mensagemErro", [], "any", false, false, false, 106) == true)) {
            // line 107
            echo "                                <div class=\"alert alert-fill alert-danger alert-dismissible alert-icon mt-2\">
                                    <em class=\"icon ni ni-cross-circle\"></em> <strong>Falha no Login</strong>!<br> ";
            // line 108
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["controller"] ?? null), "mensagem", [], "any", false, false, false, 108), "html", null, true);
            echo " <button class=\"close\" data-bs-dismiss=\"alert\"></button>
                                </div>
                                ";
        }
        // line 111
        echo "
                            </div><!-- .nk-block -->

                            <div class=\"nk-block nk-auth-footer\">
                                <div class=\"nk-block-between\">
                                    <ul class=\"nav nav-sm\">
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link\" href=\"javascript:void(0);\">Termos & Condições</a>
                                        </li>
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link\" href=\"javascript:void(0);\">Política de Privacidade</a>
                                        </li>
                                        <li class=\"nav-item\">
                                            <a class=\"nav-link\" href=\"javascript:void(0);\">Ajuda</a>
                                        </li>
                                    </ul><!-- .nav -->
                                </div>
                                <div class=\"mt-3 text-center\">
                                    <p>
                                    <a href=\"";
        // line 130
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "urlProjeto", [], "any", false, false, false, 130), "html", null, true);
        echo "\" target=\"_blank\" class=\"text-muted small\">Feito com grande <i class=\"fas fa-heart text-danger\"></i> pela <strong>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["projeto"] ?? null), "cliente", [], "any", false, false, false, 130), "html", null, true);
        echo "</strong> · Copyright 2022 <br>  Todos os Direitos Reservados</a></strong>
                                    </p>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .nk-split-content -->

                        <div class=\"nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right\" data-content=\"athPromo\" data-toggle-screen=\"lg\" data-toggle-overlay=\"true\">
                            <div class=\"slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto\">
                                <div class=\"slider-init\" data-slick='{\"dots\":true, \"arrows\":false, \"autoplay\": true}'>
                                    <div class=\"slider-item\">
                                        <div class=\"nk-feature nk-feature-center\">
                                            <div class=\"nk-feature-img\">
                                                <img class=\"round\" src=\"/assets/images/login/001.jpg\" srcset=\"/assets/images/login/001.jpg 2x\" alt=\"\">
                                            </div>
                                            <div class=\"nk-feature-content py-4 p-sm-5\">
                                                <h4>Quinta Valentina</h4>
                                                <p>Você. E Seu Movimento. Imagem 800x600</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class=\"slider-item\">
                                        <div class=\"nk-feature nk-feature-center\">
                                            <div class=\"nk-feature-img\">
                                                <img class=\"round\" src=\"/assets/images/login/002.jpg\" srcset=\"/assets/images/login/002.jpg 2x\" alt=\"\">
                                            </div>
                                            <div class=\"nk-feature-content py-4 p-sm-5\">
                                                <h4>Quinta Valentina</h4>
                                                <p>Você. E Seu Movimento. Imagem 800x600</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                    <div class=\"slider-item\">
                                        <div class=\"nk-feature nk-feature-center\">
                                            <div class=\"nk-feature-img\">
                                                <img class=\"round\" src=\"/assets/images/login/003.jpg\" srcset=\"/assets/images/login/003.jpg 2x\" alt=\"\">
                                            </div>
                                            <div class=\"nk-feature-content py-4 p-sm-5\">
                                                <h4>Quinta Valentina</h4>
                                                <p>Você. E Seu Movimento. Imagem 800x600</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                </div><!-- .slider-init -->
                                <div class=\"slider-dots\"></div>
                                <div class=\"slider-arrows\"></div>
                            </div><!-- .slider-wrap -->
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
</body>
</html>

<!-- LOAD EXTRA FILES -->
";
        // line 190
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/login/login.js?ts=";
        // line 191
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script>
\$(function(){
\t//login.init();
});
</script>
";
    }

    public function getTemplateName()
    {
        return "login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  251 => 191,  247 => 190,  182 => 130,  161 => 111,  155 => 108,  152 => 107,  150 => 106,  119 => 78,  103 => 65,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\qv-vitrine\\_V2\\app\\views\\login.twig");
    }
}
