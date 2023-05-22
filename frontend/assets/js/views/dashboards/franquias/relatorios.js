// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Dashboards';
var qv_modulo_slug = 'dashboards';
var qv_submodulo_nome = 'Franquias';
var qv_submodulo_slug = 'franquias';
var qv_url_path = window.location.pathname;

var qv_list = function() {
	return {
		init: function() {

            function carregarDT(colunas,destino) {    
                
                $('#responsive-datatable').DataTable().destroy();

                // Responsive Datatable
                var table = $('#responsive-datatable').DataTable({
                    "dom": 'rt<"bottom px-2 mb-1 mt-2 clearfix"<"row"<"col-6"i><"col-6"p>>>',
                    "columnDefs": [
                        { visible: false, "targets": [0] },
                        { orderable: false, "targets": "_all", "visible": true }
                    ],
                    "columns": colunas,
                    "createdRow": function( row, data, dataIndex ) {
                        $(row).addClass('nk-tb-item');
                    },
                    "order": [[ 0, "desc" ]],
                    "responsive": false,
                    "processing": true,
                    "serverSide": true,
                    "stateSave": false,
                    "ajax": {
                        "url": destino,
                        "data": function (d) {
                            d.tipo      = $('#tipo option:selected').val();
                            d.unidades  = $('#unidades option:selected').val();
                            d.dataDe    = $('#dataDe').val();
                            d.dataAte   = $('#dataAte').val();
                        }
                    },
                    "language": {
                        "url": "/inc/datatables/json/Portuguese-Brasil.json"
                    },
                    "initComplete": function(settings, json) {
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    "drawCallback": function( settings ) {
                        $("#responsive-datatable_paginate .pagination").addClass('float-end');
                    }				
                });

                return true;

            }

			
			// TIPO DE RELATORIO - CHANGE
			$('body').on('change', '#tipo', function() {

                // CAPTURA CAMPO
                var tipoRelatorio = $('option:selected',this).val();                

                // VARIAVEIS IMPORTANTES
                var TB_colunas = ""; 

                // CHECANDO OPCAO SELECIONADA
                if(tipoRelatorio == 'clientes') {

                    TB_colunas = 
                    '<th class="nk-tb-col">ID</th>'+
                    '<th class="nk-tb-col">NOME</th>'+
                    '<th class="nk-tb-col">TELEFONE</th>'+
                    '<th class="nk-tb-col">EMAIL</th>'+
                    '<th class="nk-tb-col">TAMANHO</th>'+
                    '<th class="nk-tb-col">STATUS</th>';                      

                } else if(tipoRelatorio == 'vendas') {

                    TB_colunas = 
                    '<th class="nk-tb-col">ID</th>'+
                    '<th class="nk-tb-col">DATA</th>'+
                    '<th class="nk-tb-col">CLIENTE</th>'+
                    '<th class="nk-tb-col">QTD</th>'+
                    '<th class="nk-tb-col">VALOR</th>'+
                    '<th class="nk-tb-col">STATUS</th>';                       

                } else {

                    TB_colunas = 
                    '<th class="nk-tb-col">ID</th>'+
                    '<th class="nk-tb-col">PRODUTO</th>'+
                    '<th class="nk-tb-col">SKU</th>'+
                    '<th class="nk-tb-col">TAMANHO</th>'+
                    '<th class="nk-tb-col">CATEGORIA</th>'+
                    '<th class="nk-tb-col">QUANTIDADE</th>';                       

                }

                // ADD HTML
                $("#responsive-datatable thead tr.nk-tb-head").html(TB_colunas);

			});          

			// ENVIAR FORM - CADASTRAR VENDEDOR
			$("#formFiltros").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

                var formID = "#formFiltros";

				// VALIDANDO FORM
				if($(formID)[0].checkValidity()) { 
                     
                    // VARIAVEIS IMPORTANTES
                    var DT_colunas = [];
                    var DT_destino = "";
                    
                    // CAPTURA CAMPO
                    var tipoRelatorio = $('#tipo option:selected',formID).val();

                    // CHECANDO OPCAO SELECIONADA
                    if(tipoRelatorio == 'clientes') {

                        DT_colunas = [
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"}
                        ];  

                        DT_destino = "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_relatorios_clientes.php";

                    } else if(tipoRelatorio == 'vendas') {

                        DT_colunas = [
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"}
                        ];  

                        DT_destino = "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_relatorios_vendas.php";

                    } else {

                        DT_colunas = [
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"},
                            {"className": "nk-tb-col text-center"}
                        ];  

                        DT_destino = "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_relatorios_estoque.php";

                    }

                    if(carregarDT(DT_colunas,DT_destino)) {
                        $("#responsive-datatable").removeClass('d-none');
                        $(".btGerarExcel").removeClass('d-none');
                        //$("#responsive-datatable").DataTable().ajax.reload(null, false);
                        //$("#responsive-datatable").DataTable().draw();
                    }

				}

			}); // FORM SUBMIT   
            
            
			/*** GERAR EXCEL  ***/
			$('body').on('click', 'a.btGerarExcel', function (e) {

                // CAPTURA VARIAVEIS
                var tipo      = $('#tipo option:selected').val();
                var unidades  = $('#unidades option:selected').val();
                var dataDe    = $('#dataDe').val();
                var dataAte   = $('#dataAte').val();

				Swal.fire({
					title: "RELATÓRIOS",
					text: "Deseja Realmente Exportar o Relatório?",
					icon: 'warning',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, gerar relatório!',
					cancelButtonText: 'Cancelar'
				}).then(function (result) {  
                    
                    if(result.value) {

                        // TOASTR - MENSAGEM INFORMATIVA                
                        toastr.options = Toastr_default_options;
                        
                        // CARREGA O TOASTR
                        toastr["info"]("Exportando", "Aguarde um Momento..."); 				

                        // VARIAVEIS AUXILIARES
                        var retornoResultado;
                        var retornoMensagem;
                        var retornoConteudo;

                        var version_numero = Math.floor(Math.random() * 999) + 100;

                        // REQUISICAO AJAX
                        $.ajax({
                            type: 'post',
                            dataType : "json",
                            data: 	'acao=relatorioExcel'+
                                    '&tipo='+tipo+
                                    '&unidades='+unidades+
                                    '&dataDe='+dataDe+
                                    '&dataAte='+dataAte+
                                    '&qv_url_path='+qv_url_path,
                            url: '/app/controllers/dashboards/franquias/ajax.php',
                            success: function(retorno){

                                retornoResultado    = retorno.resultado;
                                retornoMensagem     = retorno.mensagem;
                                retornoConteudo     = retorno.conteudo;

                            }, // SUCCESS
                            complete: function() {
                                if(retornoResultado == true) {

                                    // REMOVE TOASTR
                                    toastr.clear();	

                                    // ABRE ABA PARA DOWNLOAD DA PLANILHA
                                    window.open('/assets/relatorios/'+retornoConteudo,'_blank');

                                } else { 

                                    // REMOVE TOASTR
                                    toastr.clear();

									// ALERT
									swal.fire({
										title: "Oops...",
										allowEscapeKey: false,
										allowOutsideClick: false,
										text: retornoMensagem,
										icon: "warning"
									});

                                }                                    
                            }
                        }); // AJAX	
                    } else {
                        swal.fire("Relatórios", 'Operação foi Cancelada.', 'info');
                    }
                });

			});	// GERAR EXCEL	            

		} // INIT
	}; // RETURN
}(); // FUNCTION
