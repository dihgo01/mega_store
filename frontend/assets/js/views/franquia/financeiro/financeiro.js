// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'Financeiro';
var qv_submodulo_slug = 'financeiro';
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
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center nk-tb-col-tools" }
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
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_list.php",
					"data": function (d) {
						d.status    = $('#DT_filtros #status option:selected').val();
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

			// APAGAR REGISTRO
			$('body').on('click', 'a.btDelete', function() {

				var idItem = $(this).attr('data-id');
				var retornoResultado;			

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja apagar este item?",
					icon: 'warning',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, apagar!',
					cancelButtonText: 'Cancelar'
				}).then(function (result) {

					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Enviando sua Solicitação", qv_modulo_nome + " / " + qv_submodulo_nome);					

					if(result.value) {

						// REQUISICAO AJAX
						$.ajax({
							type: 'POST',
							dataType : "json",
							data: 	'acao=delete&idFinanceiro='+idItem+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/financeiro/ajax.php',
							success: function(retorno){
								retornoResultado = retorno.resultado;
								retornoMensagem  = retorno.mensagem;
							}, // SUCCESS
							complete: function() {
								if(retornoResultado === true) {

									Swal.fire({
										title: 'Tudo OK',
										text: retornoMensagem,
										icon: 'success',
										allowEscapeKey: false,
										allowOutsideClick: false,
										showCancelButton: false,
										confirmButtonText: 'Continuar'
									}).then(function (result) {	

										//window.location = retornoUrlRedirecionar;
										table.ajax.reload();
										//location.reload();
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

						});						

					} else {
						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');
					}

					// REMOVE TOASTR
					toastr.clear();	

				});

			});

			/*** GERAR EXCEL  ***/
			$('body').on('click', 'a.btGerarExcel', function (e) {

                // CAPTURA VARIAVEIS
                var status      = $('#status option:selected').val();
                var dataDe    = $('#dataDe').val();
                var dataAte   = $('#dataAte').val();				

				Swal.fire({
					title: "RELATÓRIO FINANCEIRO",
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
                                    '&status='+status+
                                    '&dataDe='+dataDe+
                                    '&dataAte='+dataAte+
                                    '&qv_url_path='+qv_url_path,
                            url: '/app/controllers/franquia/financeiro/ajax.php',
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
                        swal.fire("Relatório de Financeiro", 'Operação foi Cancelada.', 'info');
                    }
                });

			});	// GERAR EXCEL				

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_create = function() {
	return {
		init: function(formID) {

			// ENVIAR FORM - MOVIMENTACAO FINANCEIRA
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				var destino = '/app/controllers/franquia/financeiro/ajax.php';

				// VALIDANDO FORM
				if($(formID)[0].checkValidity()) {

					$(formID+" button[type='submit']").html(
						'<div class="spinner-border text-light" role="status">'+
						'<span class="sr-only">Carregando...</span>'+
						'</div>');
					$(formID+" button[type='submit']").attr('disabled','disabled');

					enviarForm(formID,destino, function(retorno) {

						if(retorno.resultado === true) {

							// REMOVER BT SUBMIT
							$(formID+" button[type='submit']").remove();

							// CHAMA ALERT
							Swal.fire({
								title: 'Tudo Ok!',
								text: retorno.mensagem,
								icon: 'success',
								allowEscapeKey: false,
								allowOutsideClick: false,								
								showCancelButton: false,
								confirmButtonColor: '#4fa7f3',
								confirmButtonText: 'Fechar'
							}).then(function (result) {
								if(result.value) {
									// REDIRECT
									window.location = '/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/list';
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Cadastrar');
							$(formID+" button[type='submit']").removeAttr('disabled');

							// CHAMA ALERT DE ERRO
							Swal.fire({
								title: 'Algo deu Errado!',
								text: retorno.mensagem,
								icon: 'error',
								allowEscapeKey: false,
								allowOutsideClick: false,								
								confirmButtonColor: '#4fa7f3',
								confirmButtonText: 'Fechar'
							});

						}

					}); // FUNCTION
				}

			}); // FORM SUBMIT

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_update = function() {
	return {
		init: function(formID) {

			// ENVIAR FORM - MOVIMENTACAO FINANCEIRA
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				var destino = '/app/controllers/franquia/financeiro/ajax.php';

				// VALIDANDO FORM
				if($(formID)[0].checkValidity()) {

					$(formID+" button[type='submit']").html(
						'<div class="spinner-border text-light" role="status">'+
						'<span class="sr-only">Carregando...</span>'+
						'</div>');
					$(formID+" button[type='submit']").attr('disabled','disabled');

					enviarForm(formID,destino, function(retorno) {

						if(retorno.resultado === true) {

							// REMOVER BT SUBMIT
							$(formID+" button[type='submit']").remove();

							// CHAMA ALERT
							Swal.fire({
								title: 'Tudo Ok!',
								text: retorno.mensagem,
								icon: 'success',
								allowEscapeKey: false,
								allowOutsideClick: false,								
								showCancelButton: false,
								confirmButtonColor: '#4fa7f3',
								confirmButtonText: 'Fechar'
							}).then(function (result) {
								if(result.value) {
									// REDIRECT
									window.location = '/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/list';
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Salvar Alterações');
							$(formID+" button[type='submit']").removeAttr('disabled');

							// CHAMA ALERT DE ERRO
							Swal.fire({
								title: 'Algo deu Errado!',
								text: retorno.mensagem,
								icon: 'error',
								allowEscapeKey: false,
								allowOutsideClick: false,								
								confirmButtonColor: '#4fa7f3',
								confirmButtonText: 'Fechar'
							});

						}

					}); // FUNCTION
				}

			}); // FORM SUBMIT

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_geral = function() {
	return {
		init: function(formID) {

            // VARIAVEIS IMPORTANTES
            let QV_requisicaoAjax = "";				

			// BUSCA CATEGORIA COM BASE NO TIPO
			$('body').on('change', '#tipo', function() {

				// CANCELA REQUISICAO ANTERIOR
				if(QV_requisicaoAjax.length) {
					QV_requisicaoAjax.abort();
				}

				// DEFINE VARIAVEIS
				var tipo = $('option:selected',this).val();
				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;

				// TOASTR - MENSAGEM INFORMATIVA                
				toastr.options =  Toastr_default_options;
				
				// CARREGA O TOASTR
				toastr["success"]("Buscando categorias...", qv_modulo_nome + " / " + qv_submodulo_nome);					

				// REQUISICAO AJAX
				QV_requisicaoAjax = $.ajax({
					type: 'post',
					dataType : "json",
					data: 	'acao=categoriasBuscar&tipo='+tipo+'&qv_url_path='+qv_url_path,
					url: '/app/controllers/franquia/financeiro/ajax.php',
					success: function(retorno){
						retornoResultado    = retorno.resultado;
						retornoMensagem     = retorno.mensagem;
						retornoConteudo     = retorno.conteudo;
					}, // SUCCESS
					complete: function() {
						if(retornoResultado === true) {

							if(retornoConteudo.RESULTADOS > 0) {

								// MONTANDO HTML
								var HTML_conteudo = '<option></option>';
								var categorias = retornoConteudo['ITENS'];
								for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {

									HTML_conteudo += 
										'<option value="'+categorias[i]['id']+'">'+categorias[i]['nome']+'</option>';

								}                                   

							} else {

								// MONTANDO HTML
								var HTML_conteudo = '';

							}

							// MOSTRA HTML
							$("#categoria",formID).html(HTML_conteudo);

							// RESETA SUBCATEGORIA
							$("#subcategoria",formID).html('<option></option>');

							// RECARREGA PLUGIN
							$("select.qvSelect2_noSearch").select2({
								placeholder: "Selecione uma opção...",
								allowClear: false,
								minimumResultsForSearch: Infinity
							});			

						} else {

							swal.fire({
								title: "Oops...",
								allowEscapeKey: false,
								allowOutsideClick: false,								
								text: retornoMensagem,
								type: "warning"
							});

						}

						// REMOVE TOASTR
						toastr.clear();	

					}

				}); // AJAX

			});	
			
			// BUSCA SUBCATEGORIA COM BASE NA CATEGORIA
			$('body').on('change', '#categoria', function() {

				// CANCELA REQUISICAO ANTERIOR
				if(QV_requisicaoAjax.length) {
					QV_requisicaoAjax.abort();
				}

				// DEFINE VARIAVEIS
				var categoria = $('option:selected',this).val();
				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;

				// TOASTR - MENSAGEM INFORMATIVA                
				toastr.options =  Toastr_default_options;
				
				// CARREGA O TOASTR
				toastr["success"]("Buscando sub-categorias...", qv_modulo_nome + " / " + qv_submodulo_nome);					

				// REQUISICAO AJAX
				QV_requisicaoAjax = $.ajax({
					type: 'post',
					dataType : "json",
					data: 	'acao=subcategoriasBuscar&categoria='+categoria+'&qv_url_path='+qv_url_path,
					url: '/app/controllers/franquia/financeiro/ajax.php',
					success: function(retorno){
						retornoResultado    = retorno.resultado;
						retornoMensagem     = retorno.mensagem;
						retornoConteudo     = retorno.conteudo;
					}, // SUCCESS
					complete: function() {
						if(retornoResultado === true) {

							if(retornoConteudo.RESULTADOS > 0) {

								// MONTANDO HTML
								var HTML_conteudo = '<option></option>';
								var subcategorias = retornoConteudo['ITENS'];
								for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {

									HTML_conteudo += 
										'<option value="'+subcategorias[i]['id']+'">'+subcategorias[i]['nome']+'</option>';

								}                                   

							} else {

								// MONTANDO HTML
								var HTML_conteudo = '';

							}

							// MOSTRA HTML
							$("#subcategoria",formID).html(HTML_conteudo);

							// RECARREGA PLUGIN
							$("select.qvSelect2_noSearch").select2({
								placeholder: "Selecione uma opção...",
								allowClear: false,
								minimumResultsForSearch: Infinity
							});			

						} else {

							swal.fire({
								title: "Oops...",
								allowEscapeKey: false,
								allowOutsideClick: false,								
								text: retornoMensagem,
								type: "warning"
							});

						}

						// REMOVE TOASTR
						toastr.clear();	

					}

				}); // AJAX

			});		
			
			// MANIPULA RECORRENCIA
			$('body').on('change', '#recorrencia', function() {

				// CAPTURA VARIAVEIS
				var recorrencia = $('option:selected',this).val();

				// CHECA OPCAO
				if(recorrencia == 'Sim') {
					$("#divRecorrenciaDataFinal").removeClass('d-none');
					$("#recorrenciaDataFinal").attr('required','required');
				} else {
					$("#divRecorrenciaDataFinal").addClass('d-none');
					$("#recorrenciaDataFinal").removeAttr('required');
				}

			});

		} // INIT
	}; // RETURN
}(); // FUNCTION
