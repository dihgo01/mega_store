// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'Vendas';
var qv_submodulo_slug = 'vendas';
var qv_url_path = window.location.pathname;

var qv_list = function() {
	return {
		init: function() {

			// POST FORM - ZERA CLEAR STATE DATATABLES
			$('body').on('click', 'button.btfiltrarProdutos', function (e) {
				table.state.clear();
			});

			// Responsive Datatable
			var table = $('#responsive-datatable').DataTable({
				"dom": 'rt<"bottom px-2 mb-1 mt-2 clearfix"<"row"<"col-6"i><"col-6"p>>>',
				"columnDefs": [
					{ visible: false, "targets": [0] },
					{ orderable: false, "targets": "_all", "visible": true }
				],
				"columns": [
					{ className: "nk-tb-col" },
					{ className: "nk-tb-col" },
                    { className: "nk-tb-col text-center" },
					{ className: "nk-tb-col" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" }
				],
				"createdRow": function( row, data, dataIndex ) {
					$(row).addClass('nk-tb-item');
				},
				"order": [[ 0, "desc" ]],
				"responsive": false,
				"processing": true,
				"serverSide": true,
				"stateSave": false,
				"ajax": {
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_reports_list.php",
					"data": function (d) {
						d.status    = $('#status option:selected').val();
						d.vendedor  = $('#vendedor option:selected').val();
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

			// CAMPO DE BUSCA
			$('body').on('keyup search', '#DT_buscador', function (e) {
				var tamanho = $(this).val().length;
				if(tamanho >= 4 || e.type == "search") {
					table.search($(this).val()).draw();
				}
			});

			// BOTAO DE FILTROS
			$('body').on('click', '#btFiltrarVendas', function (e) {
				table.draw();
			});		

			/*** GERAR EXCEL  ***/
			$('body').on('click', 'a.btGerarExcel', function (e) {

				// CAPTURA DADOS
                var dataDe 	        = $("#DT_filtros #dataDe").val();
                var dataAte 	    = $("#DT_filtros #dataAte").val();
                var tipoRelatorio   = $(this).attr('data-tipo');

				Swal.fire({
					title: "RELATÓRIO DE VENDAS",
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
                            data: 	'acao=relatorioVendas'+
                                    '&dataDe='+dataDe+
                                    '&dataAte='+dataAte+
                                    '&qv_url_path='+qv_url_path+
                                    '&tipoRelatorio='+tipoRelatorio,
                            url: '/app/controllers/franquia/vendas/ajax.php',
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
                        swal.fire("Relatório de Vendas", 'Operação foi Cancelada.', 'info');
                    }
                });

			});	// GERAR EXCEL

            /*** MODAL VENDEDOR | DADOS DESEMPENHO ***/
            $('#modalVendedor').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button 		= $(event.relatedTarget); // Button that triggered the modal
				var idVendedor 	= $(button).attr('data-idVendedor');
				var nome 		= $(button).text();
				var dataDe 		= $("#DT_filtros #dataDe").val();
				var dataAte 	= $("#DT_filtros #dataAte").val();
				var status 		= $("#DT_filtros #status option:selected").val();

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalVendedor .modal-body").html(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=vendedorDesempenho&idVendedor='+idVendedor+'&dataDe='+dataDe+'&dataAte='+dataAte+'&status='+status+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

                            // HTML
							var HTML_conteudo = 
								'<p class="mb-0"><span class="fw-bold display-10">Vendedor:</span> '+nome+'</p>'+
								'<p><span class="fw-bold">Período de Análise:</span> '+dataDe+' até '+dataAte+'</p>'+
								'<div class="row mb-0 cardIndicadores">'+
								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">'+retornoConteudo['qtd_vendas']+'</h5>'+
								'				<h5 class="card-title display-11">Total Vendas</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+		
								
								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">'+retornoConteudo['qtd_produtos']+'</h5>'+
								'				<h5 class="card-title display-11">Total Produtos</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+	
								
								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">'+parseFloat((retornoConteudo['qtd_produtos']/retornoConteudo['qtd_vendas'])).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Prod. por Venda</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+								

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['faturamento']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Faturamento</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat((retornoConteudo['faturamento']/retornoConteudo['qtd_vendas'])).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Ticket Médio</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'</div> <!-- ROW --> <hr class="mt-0" />';

							// PREENCHE O HTML
                            $("#modalVendedor .modal-body").html(HTML_conteudo);

                        } else {

                            // ALERT
                            swal.fire({
                                title: "Oops...",
								allowEscapeKey: false,
								allowOutsideClick: false,
                                text: retornoMensagem,
                                icon: "warning"
                            });

                        }

						// REMOVE BARRA PROGRESSO
						$("div.barraProgresso").remove();

                    }

                });	                

			});					

		} // INIT
	}; // RETURN
}(); // FUNCTION
