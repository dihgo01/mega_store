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

/* /franquia/vendas/list.twig */
class __TwigTemplate_b6d8272bbcee2d54f6a70edc1270315d extends Template
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
                        <h3 class=\"nk-block-title page-title\">Vendas / <strong class=\"text-primary small\">Consulta</strong></h3>
                        <div class=\"nk-block-des text-soft\">
                            <p>Tela para consulta das vendas lançadas.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class=\"nk-block-head-content\">
                        <div class=\"toggle-wrap nk-block-tools-toggle\">
                            <a href=\"#\" class=\"btn btn-icon btn-trigger toggle-expand mr-n1\" data-target=\"pageMenu\"><em class=\"icon ni ni-menu-alt-r\"></em></a>
                            <div class=\"toggle-expand-content\" data-content=\"pageMenu\">
                                <ul class=\"nk-block-tools g-2\">
                                    <li class=\"w-xs-100\"><a href=\"#modalVendas_ExportarXML\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\" data-bs-toggle=\"modal\"><em class=\"icon ni ni-file-code\"></em><span>Exportar XML's</span></a></li>
                                    <li class=\"w-xs-100\"><a href=\"/";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var1", [], "any", false, false, false, 19), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "parametros", [], "any", false, false, false, 19), "var2", [], "any", false, false, false, 19), "html", null, true);
        echo "/create\" class=\"btn btn-white btn-outline-light w-xs-100 d-inline\"><em class=\"icon ni ni-plus-circle\"></em><span>Nova Venda</span></a></li>
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
                                        <input type=\"search\" class=\"form-control border-transparent form-focus-none ps-0\" name=\"DT_buscador\" id=\"DT_buscador\" placeholder=\"Digite o que deseja buscar...\">
                                        <button class=\"search-submit btn btn-icon\"><em class=\"icon ni ni-search\"></em></button>
                                    </div>
                                </div><!-- .card-tools -->
                                <div class=\"card-tools me-n1\">
                                    <ul class=\"btn-toolbar gx-1\">
                                        <li class=\"btn-toolbar-sep\"></li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div><!-- .card-tools -->
                            </div><!-- .card-title-group -->
                        </div><!-- .card-inner -->
                        <div class=\"card-inner px-0 pt-0\">
                            <div class=\"table-responsive\" style=\"padding-left:0px; padding-right:0px; overflow: visible !important;\">
                                <table class=\"table-hover nowrap nk-tb-list w-100\" data-auto-responsive=\"false\" id=\"responsive-datatable\">
                                    <thead class=\"\">
                                        <tr class=\"nk-tb-item nk-tb-head\">
                                            <th class=\"nk-tb-col\">CATEGORIA</th>
                                            <th class=\"nk-tb-col\">IMPOSTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div> <!-- RESPONSIVE TABLE -->
                        </div><!-- .card-inner -->
                        
                    </div><!-- .card-inner-group -->
                </div><!-- .card -->
            </div><!-- .nk-block -->

        </div> <!-- nk-content-body -->
    </div>
</div>

<!-- Modal Alert -->
<div class=\"modal fade\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" tabindex=\"-1\" id=\"modalGerarNF\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross\"></em></a>
            <div class=\"modal-body modal-body-lg text-center\">
                <div class=\"nk-modal\">
                    <em class=\"nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success\"></em>
                    <h4 class=\"nk-modal-title\">Documento Fiscal Gerado</h4>
                    <div class=\"nk-modal-text\">
                        <div class=\"caption-text\">Seu Documento Fiscal foi Gerado com Sucesso.</div>
                    </div>
                    <div class=\"nk-modal-action\">
                        <a href=\"javascript:(0);\" id=\"recebeDocumentoFiscal\" target=\"_blank\" class=\"btn btn-lg btn-mw btn-secondary\"><em class=\"icon ni ni-printer me-1\"></em> Abrir Documento Fiscal</a>
                        <a href=\"#\" class=\"btn btn-lg btn-mw btn-primary\" data-bs-dismiss=\"modal\">Fechar</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
            <div class=\"modal-footer bg-lighter\">
                <div class=\"text-center w-100\">
                    <p><b>Vitrine QV</b></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HISTORICO VENDA -->
<div class=\"modal fade\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" role=\"dialog\" id=\"modalVendasHistorico\">
    <div class=\"modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable\" role=\"document\">
        <div class=\"modal-content\">
            <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Histórico da Venda</h5>
            </div>            
            <div class=\"modal-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-hover\" id=\"tableProdutos\">
                        <thead class=\"table-dark\">
                            <tr>
                                <th scope=\"col\" class=\"text-center w-20\">Data</th>
                                <th scope=\"col\" class=\"text-center w-20\">Usuário</th>
                                <th scope=\"col\">Descrição</th>
                            </tr>
                        </thead>
                        <tbody id=\"recebeHistoricoVenda\">
                        </tbody>
                    </table>
                </div> <!-- RESPONSIVE TABLE -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- MODAL VISUALIZAR DOCUMENTO FISCAL -->
<div class=\"modal fade\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" role=\"dialog\" id=\"modalVendasNF_View\">
    <div class=\"modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable\" role=\"document\">
        <div class=\"modal-content\" style=\"height: 90vh;\">
            <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
            <div class=\"modal-header position-relative\">
                <h5 class=\"modal-title\">Documento Fiscal</h5>
                <a href=\"javascript:void(0);\" id=\"btPrintDocumentoFiscal\" class=\"btn btn-secondary position-absolute top-50 translate-middle-y\" style=\"right:10%;\">
                    <em class=\"icon ni ni-printer mr-2\"></em> Imprimir
                </a>
            </div>            
            <div class=\"modal-body p-0\" id=\"documentoFiscal_View\">
                <iframe id=\"documentoFiscal_frame\" src=\"\" width=\"100%\" frameborder=\"0\"></iframe>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- MODAL EXPORTAR XML -->
<div class=\"modal fade\" data-bs-backdrop=\"static\" data-bs-keyboard=\"false\" role=\"dialog\" id=\"modalVendas_ExportarXML\">
    <div class=\"modal-dialog modal-dialog-centered modal-dialog-scrollable\" role=\"document\">
        <div class=\"modal-content\">
            <a href=\"#\" class=\"close\" data-bs-dismiss=\"modal\"><em class=\"icon ni ni-cross-sm\"></em></a>
            <div class=\"modal-header\">
                <h5 class=\"modal-title\">Exportar XML dos Documentos Fiscais</h5>
            </div>            
            <div class=\"modal-body\">
                <form method=\"post\" name=\"formXML\" id=\"formXML\" onkeydown=\"return event.key != 'Enter';\">
                    <div class=\"row g-4\">
                        <div class=\"col-12\">
                            <div class=\"form-group\">
                                <label class=\"form-label\" for=\"emailContador\">E-mail do Contador</label>
                                <div class=\"form-control-wrap\">
                                    <input type=\"email\" class=\"form-control\" id=\"emailContador\" name=\"emailContador\" placeholder=\"nome@provedor.com.br\" required>
                                </div>
                            </div>
                        </div> 
                        <div class=\"col-12\">
                            <div class=\"form-group\">
                                <label class=\"form-label\" for=\"observacoes\">Observações</label>
                                <div class=\"form-control-wrap\">
                                    <textarea class=\"form-control\" id=\"observacoes\" name=\"observacoes\" placeholder=\"Descreva essa movimentação...\" row=\"3\" required></textarea>
                                </div>
                            </div>
                        </div> 
                        <div class=\"col-12\">
                            <div class=\"alert alert-fill alert-light alert-icon small\">
                                <em class=\"icon ni ni-alert-circle\"></em> Primeiramente filtre as vendas pelo período desejado para depois utilizar esta ferramenta. Serão enviados os XMLs das vendas com status <b>concluída</b> no período selecionado.
                            </div>
                        </div>                                              
                    </div> <!-- ROW -->
                    <hr class=\"preview-hr mt-4 mb-2\">
                    <div class=\"row gy-4 mb-4\">
                        <div class=\"col-12\">
                            <div class=\"form-group text-end\">
                                <input type=\"hidden\" name=\"formAcao\" id=\"formAcao\" value=\"documentoFiscal_ExportarXML\" />
                                <input type=\"hidden\" name=\"dataDe\" id=\"dataDe\" value=\"";
        // line 178
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_date_modify_filter($this->env, "now", "-30 day"), "d/m/Y"), "html", null, true);
        echo "\" />
                                <input type=\"hidden\" name=\"dataAte\" id=\"dataAte\" value=\"";
        // line 179
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "d/m/Y"), "html", null, true);
        echo "\" />
                                <input type=\"hidden\" name=\"qv_url_path\" id=\"qv_url_path\" value=\"";
        // line 180
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["url"] ?? null), "uri", [], "any", false, false, false, 180), "html", null, true);
        echo "\" />
                                <button type=\"submit\" class=\"btn btn-primary w-xs-100 d-inline\">Enviar</button>
                            </div>
                        </div>                                        
                    </div> <!-- ROW -->                                
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<!-- LOAD EXTRA FILES -->
";
        // line 192
        echo twig_include($this->env, $context, "scripts.twig");
        echo "
<script src=\"/assets/js/views/franquia/vendas/vendas.js\"></script>
<script src=\"/assets/js/views/franquia/vendas/shopcart.js?ts=";
        // line 194
        echo twig_escape_filter($this->env, twig_random($this->env, 100000, 999999), "html", null, true);
        echo "\"></script>
<script>
\$(function(){

    // ACIONADOR DO METODO
    qv_list.init();

    // FUNCOES
    carregarShopCart();

});
</script>";
    }

    public function getTemplateName()
    {
        return "/franquia/vendas/list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  249 => 194,  244 => 192,  229 => 180,  225 => 179,  221 => 178,  57 => 19,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/franquia/vendas/list.twig", "C:\\Users\\Diego\\Desktop\\prog\\SoftExpert\\frontend\\app\\views\\franquia\\vendas\\list.twig");
    }
}
