var INIT_QV_CUSTOM = function () {
    return {
        init: function () {

            // VARIAVEIS IMPORTANTES
            let QV_requisicaoAjax = "";

            // PATH DA URL
            var QV_url_path = window.location.pathname;

            // SALVA DOMINIO EM LOCAL_STORAGE
            if (document.location.hostname == "localhost") {
                sessionStorage.setItem("dominio", document.location.protocol + "//" + document.location.hostname + ":80");
            } else if (document.location.hostname == "qv-vitrine") {
                sessionStorage.setItem("dominio", document.location.protocol + "//" + document.location.hostname + ":8890");
            } else {
                sessionStorage.setItem("dominio", document.location.protocol + "//" + document.location.hostname);
            }

            // TOOlTIP
            $('[data-bs-tooltip="tooltip"]').tooltip();

            // MASKs
            $('input.maskCPF').mask('999.999.999-99');
            $('.input_percentage').mask('99');
            $('input.maskCNPJ').mask('99.999.999/9999-99');
            $('input.maskData').mask('99/99/9999');
            $('input.maskCEP').mask('99999-999');
            $('input.maskNumero').mask('9?99999');
            $('input.maskTelefone').mask('(99) 99999-999?9');
            $('input.maskNumeroCartao').mask('9999 9999 9999 9999');
            $('input.maskCodSeg').mask('999?99');
            $('input.maskVencCartao').mask('99/9999');
            $('input.maskVoucher').mask('aaa-999');
            $('input.maskTelefone').mask("(99) 99999-999?9").on('focusout', function (event) {
                var target, phone, element;
                target = (event.currentTarget) ? event.currentTarget : event.srcElement;
                phone = target.value.replace(/\D/g, '');
                element = $(target);
                element.unmask();
                if (phone.length > 10) {
                    element.mask("(99) 99999-999?9");
                } else {
                    element.mask("(99) 9999-9999?9");
                }
            });

            // DATATABLES
            if ($(".general-datatable").length > 0) {
                $(".general-datatable").each(function () {
        
                    $(this).DataTable({
                        dom: 'rt<"bottom px-2 mb-1 mt-2 clearfix"<"row"<"col-6"i><"col-6"p>>>',
                        columnDefs: [
                            { orderable: false, "targets": "_all", "visible": true }
                        ],
                        paging: true,
                        order: [[0, "desc"]],
                        fixedColumns: {
                            left: 2,
                        },
                        responsive: true,
                        language: {
                            processing: "Processando...",
                            search: "Pesquisar: ",
                            lengthMenu: "_MENU_",
                            info: "Mostrando  _START_  até  _END_  de  _TOTAL_  registros",
                            infoEmpty: "Mostrando 0 até 0 de 0 registros",
                            infoFiltered: "(filtrado de _MAX_ registros no total)",
                            infoPostFix: "",
                            loadingRecords: "Processando...",
                            zeroRecords: "Nenhum dado encontrado",
                            emptyTable: "Nenhum registro cadastrado",
                            paginate: {
                                first: "Primeira Página",
                                previous: "Anterior",
                                next: "Próximo",
                                last: "Última Página",
                            },
                            aria: {
                                sortAscending: ": ative para classificar a coluna em ordem crescente",
                                sortDescending: ": ative para classificar a coluna em ordem decrescente",
                            },
                        },
                    });
        
                    $(this).on('show.bs.dropdown', function () {
                        $(this).css("overflow", "inherit");
                    });
        
                    $(this).on('hide.bs.dropdown', function () {
                        $(this).css("overflow", "auto");
                    })
        
                });
        
            }

            // MASKMONEY
            $("input.maskMoney").maskMoney({
                "prefix": 'R$ ',
                "thousands": '.',
                "decimal": ',',
                "affixesStay": false,
                "allowZero": true
            });
            $("input.maskNumber").maskMoney({
                "prefix": '',
                "thousands": '.',
                "decimal": ',',
                "affixesStay": false,
                "allowZero": true
            });
            $("input.maskNumberAlt").maskMoney({
                "prefix": '',
                "thousands": '',
                "decimal": '.',
                "affixesStay": false,
                "allowZero": true
            });
            $("input.maskPeso").maskMoney({
                "suffix": ' kg',
                "thousands": '.',
                "decimal": ',',
                "affixesStay": false,
                "allowZero": true
            });
            $("input.maskDimensoes").maskMoney({
                "suffix": ' cm',
                "thousands": '.',
                "decimal": ',',
                "affixesStay": false,
                "allowZero": true
            });

            // SELECT2
            $(".qvSelect2").select2({
                placeholder: "Selecione uma opção...",
                allowClear: false
            });
            $(".qvSelect2_noSearch").select2({
                placeholder: "Selecione uma opção...",
                allowClear: false,
                minimumResultsForSearch: Infinity
            });

            // SELECT MULTIPLE - MULTISELECT
            $('.comboMultiselect').selectpicker({
                'mobile': false,
                'liveSearchPlaceholder': 'Digite a unidade desejada...'
            });            

            // DATEPICKER - LANGUAGE
            $.fn.datepicker.dates['BR'] = {
                days: ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"],
                daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sá"],
                months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                today: "Hoje",
                clear: "Limpar",
                format: "dd/mm/yyyy",
                titleFormat: "MM/yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };

            // DATEPICKER - CALL PLUGIN
            $('.inputCalendario').datepicker({
                language: 'BR',
                todayHighlight: true,
                autoclose: true
            });

            // BLOQUEAR ENTER
            $('form input:not([type="submit"])').keydown(function (e) {

                var block_enter = false;

                if (block_enter) {

                    if (e.keyCode == 13) {
                        var inputs = $(this).parents("form").eq(0).find(":input");
                        if (inputs[inputs.index(this) + 1] != null) {
                            inputs[inputs.index(this) + 1].focus();
                        }
                        e.preventDefault();
                        return false;
                    }

                }
            });

            // NUMBERSPINNER
            $('body').on('click', 'button[data-number="qv_minus"],button[data-number="qv_plus"]', function (e) {

                // VARIAVEIS IMPORTANTES
                var targetField = $(this).closest(".number-spinner-wrap");
                var btClicked = $(this).attr('data-number');
                var operation = btClicked.split("qv_");
                var currentValue = $("input.number-spinner", targetField).val();
                var minLenghtField = $("input.number-spinner", targetField).attr('min');
                var maxLenghtField = $("input.number-spinner", targetField).attr('max');
                var stepInput = 1;

                // NOVO VALOR
                if (operation[1] == 'minus') {
                    var newValue = parseInt(currentValue) - parseInt(stepInput);
                } else {
                    var newValue = parseInt(currentValue) + parseInt(stepInput);
                }

                if (parseInt(newValue) >= parseInt(minLenghtField) && parseInt(newValue) <= parseInt(maxLenghtField)) {
                    $("input.number-spinner", targetField).val(newValue);
                    $("input.number-spinner", targetField).trigger("change");
                }

            });

            // MOMENTJS
            moment.locale('pt-BR');

            // TOASTR - OPCOES PADROES
            Toastr_default_options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "20000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            /***************************************************************/
            /************************** EXTRAS *****************************/
            /***************************************************************/

            // COPIAR E COLAR
            $('body').on('click', '*.copiarAreaTransferencia', function (e) {

                // variable content to be copied
                var copyText = $(this).attr('data-alvo');
                // create an input element
                let input = document.createElement('input');
                // setting it's type to be text
                input.setAttribute('type', 'text');
                // setting the input value to equal to the text we are copying
                input.value = copyText;
                // appending it to the document
                document.body.appendChild(input);
                // calling the select, to select the text displayed
                // if it's not in the document we won't be able to
                input.select();
                // calling the copy command
                document.execCommand("copy");
                // removing the input from the document
                document.body.removeChild(input);

                // TOASTR - MENSAGEM INFORMATIVA                
                toastr.options = Toastr_default_options;

                // CARREGA O TOASTR
                toastr["success"]("Informação Copiada para o CTRL+V", "Copiar e Colar");

            });

            // TROCAR MODULO
            $('body').on('click', 'a.btTrocarModulo', function (e) {

                // VARIAVEIS AUXILIARES
                var modulo = $(this).attr('data-modulo');
                var retornoResultado;
                var retornoMensagem;

                // TOASTR - MENSAGEM INFORMATIVA                
                toastr.options =  Toastr_default_options;
                
                // CARREGA O TOASTR
                toastr["info"]("Enviando sua Solicitação", "Vitrine QV");                

                // CANCELA REQUISICAO ANTERIOR
                if (QV_requisicaoAjax.length) {
                    QV_requisicaoAjax.abort();
                }                

                // REQUISICAO AJAX
                QV_requisicaoAjax = $.ajax({
                    type: 'post',
                    dataType: "json",
                    data: 'acao=trocar_modulo&modulo='+modulo+'&qv_url_path=' + QV_url_path,
                    url: '/app/controllers/ajax.php',
                    success: function (retorno) {
                        retornoResultado = retorno.resultado;
                        retornoMensagem = retorno.mensagem;
                    }, // SUCCESS
                    complete: function () {
                        if (retornoResultado === true) {

                            // REDIRECIONA
                            window.location = '/';

                        } else {

                            // ALERT
                            swal.fire({
                                title: "Oops...",
                                allowEscapeKey: false,
                                allowOutsideClick: false,                                
                                text: retornoMensagem,
                                type: "warning"
                            });

                            // REMOVE TOASTR
                            toastr.clear();
                            
                        }
                    }
                }); // AJAX

            });


            // BUSCADOR UNIDADES
            $('body').on('keypress', '#QV_buscadorUnidade', function (e) {
                var termo = $(this).val();
                if (termo.length >= 4) {

                    // VARIAVEIS AUXILIARES
                    var retornoResultado;
                    var retornoMensagem;
                    var retornoConteudo;

                    // CANCELA REQUISICAO ANTERIOR
                    if (QV_requisicaoAjax.length) {
                        QV_requisicaoAjax.abort();
                    }

                    // BARRA PROGRESSO
                    var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 text-center">' +
                        '<div class="spinner-border text-dark" role="status">' +
                        '<span class="sr-only">Carregando...</span>' +
                        '</div></div></div>';
                    $("#recebeConsultaUnidades").html(barraProgresso);

                    // REQUISICAO AJAX
                    QV_requisicaoAjax = $.ajax({
                        type: 'post',
                        dataType: "json",
                        data: 'acao=consulta_unidades&termo=' + termo + '&qv_url_path=' + QV_url_path,
                        url: '/app/controllers/ajax.php',
                        success: function (retorno) {
                            retornoResultado = retorno.resultado;
                            retornoMensagem = retorno.mensagem;
                            retornoConteudo = retorno.conteudo;
                        }, // SUCCESS
                        complete: function () {
                            if (retornoResultado === true) {

                                if (retornoConteudo.RESULTADOS > 0) {

                                    // MONTANDO HTML
                                    var HTML_conteudo = "";
                                    for (let i = 0; i < retornoConteudo['ITENS'].length; i++) {
                                        HTML_conteudo +=
                                            '<li>' +
                                            '<div class="custom-control custom-control-sm custom-radio custom-control-pro">' +
                                            '<input type="radio" class="custom-control-input inputListagemUnidade" id="listagem_unidade_' + i + '" name="listagem_unidade" data-idUnidade="' + retornoConteudo['ITENS'][i]['id'] + '">' +
                                            '<label class="custom-control-label" for="listagem_unidade_' + i + '">' +
                                            '<span class="user-card">' +
                                            '<span class="user-avatar sm">' +
                                            '<img src="' + retornoConteudo['ITENS'][i]['foto'] + '" alt="' + retornoConteudo['ITENS'][i]['nome'] + '">' +
                                            '</span>' +
                                            '<span class="user-name">' + retornoConteudo['ITENS'][i]['nome'] + '</span>' +
                                            '</span>' +
                                            '</label>' +
                                            '</div>' +
                                            '</li>';
                                    }

                                } else {

                                    // MONTANDO HTML
                                    var HTML_conteudo =
                                        '<li>' +
                                        '<div class="custom-control custom-control-sm custom-radio custom-control-pro">' +
                                        '<label class="custom-control-label" for="user-choose-s1">' +
                                        '<span class="user-card">' +
                                        '<span class="user-name">Nenhum Resultado</span>' +
                                        '</span>' +
                                        '</label>' +
                                        '</div>' +
                                        '</li>';

                                }

                                // MOSTRA HTML
                                $("#recebeConsultaUnidades").html(HTML_conteudo);

                            } else {
                                // ALERT
                                swal.fire({
                                    title: "Oops...",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,                                    
                                    text: retornoMensagem,
                                    type: "warning"
                                });
                            }
                        }
                    }); // AJAX


                }
            });

            // SET ID UNIDADE NO BUTTON
            $('body').on('click', 'input.inputListagemUnidade', function (e) {
                var idUnidade = $(this).attr('data-idUnidade');
                $("#BT_enviarBuscadorUnidade").attr('data-idUnidade', idUnidade);
            });

            // DEFINIR NOVA UNIDADE
            $('body').on('click', '#BT_enviarBuscadorUnidade', function (e) {
                var idUnidade = $(this).attr('data-idUnidade');
                if (idUnidade != '') {

                    // VARIAVEIS AUXILIARES
                    var retornoResultado;
                    var retornoMensagem;

                    // CANCELA REQUISICAO ANTERIOR
                    if (QV_requisicaoAjax.length) {
                        QV_requisicaoAjax.abort();
                    }

                    // REQUISICAO AJAX
                    QV_requisicaoAjax = $.ajax({
                        type: 'post',
                        dataType: "json",
                        data: 'acao=definir_unidade&idUnidade=' + idUnidade + '&qv_url_path=' + QV_url_path,
                        url: '/app/controllers/ajax.php',
                        success: function (retorno) {
                            retornoResultado = retorno.resultado;
                            retornoMensagem = retorno.mensagem;
                        }, // SUCCESS
                        complete: function () {
                            if (retornoResultado === true) {

                                // CHAMA ALERT DE SUCESSO
                                swal.fire({
                                    title: 'Tudo OK!',
                                    text: retornoMensagem,
                                    type: 'success',
                                    confirmButtonColor: '#4fa7f3',
                                    confirmButtonText: 'Fechar',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then(function () {
                                    //window.location = sessionStorage.getItem("dominio")+'/ajuda/ocorrencias';
                                    //table.ajax.reload();
                                    location.reload();
                                    //$('.modal').modal('hide');
                                });

                            } else {
                                // ALERT
                                swal.fire({
                                    title: "Oops...",
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,                                    
                                    text: retornoMensagem,
                                    type: "warning"
                                });
                            }
                        }
                    }); // AJAX

                }
            });

            // RESTAURAR UNIDADE NEUTRA
            $('body').on('click', '#restaurarUnidadeNeutra', function (e) {

                // VARIAVEIS AUXILIARES
                var retornoResultado;
                var retornoMensagem;

                // CANCELA REQUISICAO ANTERIOR
                if (QV_requisicaoAjax.length) {
                    QV_requisicaoAjax.abort();
                }

                // REQUISICAO AJAX
                QV_requisicaoAjax = $.ajax({
                    type: 'post',
                    dataType: "json",
                    data: 'acao=unidade_neutra&qv_url_path=' + QV_url_path,
                    url: '/app/controllers/ajax.php',
                    success: function (retorno) {
                        retornoResultado = retorno.resultado;
                        retornoMensagem = retorno.mensagem;
                    }, // SUCCESS
                    complete: function () {
                        if (retornoResultado === true) {

                            // CHAMA ALERT DE SUCESSO
                            swal.fire({
                                title: 'Tudo OK!',
                                text: retornoMensagem,
                                type: 'success',
                                confirmButtonColor: '#4fa7f3',
                                confirmButtonText: 'Fechar',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(function () {
                                //window.location = sessionStorage.getItem("dominio")+'/ajuda/ocorrencias';
                                //table.ajax.reload();
                                location.reload();
                                //$('.modal').modal('hide');
                            });

                        } else {
                            // ALERT
                            swal.fire({
                                title: "Oops...",
                                allowEscapeKey: false,
                                allowOutsideClick: false,                                
                                text: retornoMensagem,
                                type: "warning"
                            });
                        }
                    }
                }); // AJAX

            });


            // BUSCADOR SKU POR BIPE
            $('body').on('paste', '#sku_bipe', function (e) {
                var sku = e.originalEvent.clipboardData.getData('text');
                if (sku.length == 14) {
                    sku_bipe(sku);
                }
            });
            $('body').on('keydown', '#sku_bipe', function (e) {
                var sku = $("#sku_bipe").val();
                if (sku.length == 14) {
                    sku_bipe(sku);
                }
            });

            // ABRE FECHA SIDEBAR
            /*$('body').on('click', '.nk-sidebar', function (e) {

                // VARIAVEIS IMPORTANTES
                var targetField = $(this);
                var sideBarAtual = $(targetField).hasClass('is-compact');
                if(sideBarAtual) {
                    
                }
                console.log(sideBarAtual);
                localStorage.setItem("sideBar", sideBarAtual);

            });*/

            //sideBar();

        }
    };
}();

/******************************************/
/***************** FUNCTIONS **************/
/******************************************/
function contarElementos(what) {
    return document.querySelectorAll(what).length;
}

function resetForm(form) {
    $(form).find('input:text, input:password, input:file, select, textarea').val('');
    $(form).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
}

function sideBar() {

    var sideBar = localStorage.getItem("sideBar");
    if(sideBar) {
        $(".nk-sidebar").addClass('is-compact');
    } else {
        $(".nk-sidebar").removeClass('is-compact');
    }

}

function tratarTamanhoProdutos(tamanho) {
    switch(tamanho) {
        case '1':
            var tamanhoFinal = 'P';
            break;
        case '2':
            var tamanhoFinal = 'M';
            break;
        case '3':
            var tamanhoFinal = 'G';
            break;
        default:
            var tamanhoFinal = tamanho
    } 
    return tamanhoFinal   
}


function enviarForm(formID, destino, callback, metodo = false) {

    // TRATAR METODO DE REQUISICAO
    if (!metodo) { metodo = "POST"; }

    // COLETA TODOS OS CAMPOS DO FORM
    var campos = new FormData($(formID)[0]);

    // TOASTR - MENSAGEM INFORMATIVA                
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    // CARREGA O TOASTR
    toastr["info"]("Executando sua Solicitação", "Aguarde um Momento...");

    // VARIAVEIS AUXILIARES
    var retornoResultado;
    var retornoMensagem;
    var retornoConteudo;

    // DISPARA REQUISISAO AJAX
    $.ajax({
        type: metodo,
        dataType: "json",
        data: campos,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        url: destino,
        success: function (retorno) {

            retornoResultado = retorno.resultado;
            retornoMensagem = retorno.mensagem;
            retornoConteudo = retorno.conteudo;

        }, // SUCCESS
        complete: function () {

            // REMOVE TOASTR
            toastr.clear();

            var retorno = { resultado: retornoResultado, mensagem: retornoMensagem, conteudo: retornoConteudo };
            callback(retorno);

        } // COMPLETE                       
    }); // AJAX 

} // enviarForm   

/******************************************/
/***************** FUNCTIONS **************/
/******************************************/

$(function () { INIT_QV_CUSTOM.init(); });