// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'QV em Casa';
var qv_submodulo_slug = 'qvemcasa';
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

			// APAGAR PEDIDO
			$('body').on('click', 'a.btDelete', function() {

				var idPedido = $(this).attr('data-idPedido');
				var retornoResultado;			

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja apagar este pedido?",
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
							data: 	'acao=delete&idPedido='+idPedido+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/qvemcasa/ajax.php',
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

							// REMOVE TOASTR
							toastr.clear();										

							}						

						});						

					} else {

						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');
						// REMOVE TOASTR
						toastr.clear();		

					}

				});

			});

			// CONVERTER PEDIDO
			$('body').on('click', 'a.btConverterPedido', function() {

				var idPedido = $(this).attr('data-idPedido');
				var retornoResultado;	
				var retornoMensagem;		
				var retornoConteudo;

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja converter este pedido?",
					icon: 'info',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, converter!',
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
							data: 	'acao=converterPedido&idPedido='+idPedido+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/qvemcasa/ajax.php',
							success: function(retorno){
								retornoResultado = retorno.resultado;
								retornoMensagem  = retorno.mensagem;
								retornoConteudo  = retorno.conteudo;
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

										window.location = '/franquia/vendas/update/' + retornoConteudo;
										//table.ajax.reload();
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

								// REMOVE TOASTR
								toastr.clear();									

							}

						});						

					} else {

						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');

						// REMOVE TOASTR
						toastr.clear();	

					}

				});

			});			

			// GERAR PDF
			$('body').on('click', 'a.btGerarPDF', function() {

				var idPedido = $(this).attr('data-idPedido');
				var retornoResultado;	
				var retornoMensagem;		
				var retornoConteudo;

				// TOASTR - MENSAGEM INFORMATIVA                
				toastr.options =  Toastr_default_options;
				
				// CARREGA O TOASTR
				toastr["success"]("Enviando sua Solicitação", qv_modulo_nome + " / " + qv_submodulo_nome);					

				// REQUISICAO AJAX
				$.ajax({
					type: 'POST',
					dataType : "json",
					data: 	'acao=pdf&idPedido='+idPedido+'&qv_url_path='+qv_url_path,
					url: '/app/controllers/franquia/qvemcasa/ajax.php',
					success: function(retorno){
						retornoResultado = retorno.resultado;
						retornoMensagem  = retorno.mensagem;
						retornoConteudo  = retorno.conteudo;
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

								//window.location = '/franquia/vendas/update/' + retornoConteudo;
								//table.ajax.reload();
								//location.reload();
								//$('.modal').modal('hide');
								window.open(retornoConteudo,'_blank');	

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

						// REMOVE TOASTR
						toastr.clear();									

					}

				});

			});					

            /*** MODAL ITENS DO PEDIDO  ***/
            $('#modalItensPedido').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idPedido = $(button).attr('data-idPedido');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#recebeItensPedido").html(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=getItens&idPedido='+idPedido+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/qvemcasa/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

                            if(retornoConteudo.RESULTADOS > 0) {

                                var itens = retornoConteudo['ITENS'];
                                var HTML_conteudo = "";
                                for(let i = 0; i < retornoConteudo['ITENS'].length; i++) { 

                                    HTML_conteudo +=
                                        '<tr class="row-vertical-align">'+
                                        '	<th scope="row">'+(parseInt(i)+parseInt(1))+'</th>'+
                                        '	<td class="text-center w-10"><img src="'+itens[i]['foto']+'"class="img-fluid" /></td>'+
                                        '	<td>'+itens[i]['nome']+'<br><span class="small text-muted">'+itens[i]['sku']+'</span></td>'+
                                        '	<td class="text-center">'+itens[i]['categoria']+'</td>'+ 
                                        '	<td class="text-center">'+itens[i]['tamanho']+'</td>'+
										'	<td class="text-center">'+itens[i]['quantidade']+'</td>'+
                                        '</tr>'; 
                                }    
                                
                            } else {

                                var HTML_conteudo =
                                '<tr class="row-vertical-align">'+
                                '	<td class="text-center" colspan="7">Nenhum Item Encontrado</td>'+
                                '</tr>';                                 

                            }

							// PREENCHE O HTML
                            $("#recebeItensPedido").html(HTML_conteudo);

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
