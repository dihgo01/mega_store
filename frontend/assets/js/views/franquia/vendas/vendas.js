// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'Vendas';
var qv_submodulo_slug = 'vendas';
var qv_url_path = window.location.pathname;

var qv_list = function() {
	return {
		init: function() {

	
			// Responsive Datatable
			var table = $('#responsive-datatable').DataTable({
				"dom": 'rt<"bottom px-2 mb-1 mt-2 clearfix"<"row"<"col-6"i><"col-6"p>>>',
				"columnDefs": [
					{ visible: false, "targets": [0] },
					{ orderable: false, "targets": "_all", "visible": true }
				],
				"columns": [
					{ 
						className: "nk-tb-col",
						data: "category",
					},
					{ 
						className: "nk-tb-col text-center",
						data: "tax" 
					},
					
				],
				"createdRow": function( row, data, dataIndex ) {
					$(row).addClass('nk-tb-item');
				},
				"order": [[ 0, "desc" ]],
				"responsive": false,
				"processing": true,
				"stateSave": false,
				"ajax": {
					"url": "http://localhost:8000/product-categorys",
					"type": "GET",
					"headers": { 
						'authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODQ3MzU4MzEsImlhdCI6MTY4NDcyNTgzMSwiaWQiOiJjMWE0MWYwNzllMGQzN2U4MjgyOGEyYmE2YzdjNTUwMSJ9.tiNJ4kH9HNtTrmXVJoKNcsZAuvNMpSeRXAgwt1AKRHg'
					},
					"data": function (d) {
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

			// APAGAR VENDA (CANCELAR EH OUTRA CHAMADA)
			$('body').on('click', 'a.btDelete', function() {

				var idItem = $(this).attr('data-id');
				var retornoResultado;
				var retornoMensagem;

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
							type: 'DELETE',
							dataType : "json",
							data: 	'idItem='+idItem,
							url: '/app/models/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/'+qv_submodulo_slug+'.php',
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
										icon: "warning"
									});

								}

								toastr.clear();	

							}

						});						

					} else {
						toastr.clear();	
						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');
					}

				});

			});

			// EMISSAO DOCUMENTO FISCAL - NFe / NFCe
			$('body').on('click', 'a.btGerarDocumentoFiscal', function() {

				// VARIVEIS
				var idVenda = $(this).attr('data-idVenda');

				// VALIDANDO
				if(idVenda != '') {

					var retornoResultado;
					var retornoMensagem;
					var retornoConteudo;
	
					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Aguarde a emissão...", "Documento NFe / NFCe");	
	
					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=emissaoFiscal&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {

								// ABRE DOCUMENTO FISCAL EM UMA NOVA ABA
								window.open(retornoConteudo.url_nf,'_blank');

								// ABRE MODAL
								$("#modalGerarNF").modal('show');
								
								// ALTERA CTA DA MODAL
								$("#recebeDocumentoFiscal").attr('href',retornoConteudo.url_nf);

								// RECARREGA DATATABLES
								table.ajax.reload();
								
							} else {
	
								// ALERT
								swal.fire({
									title: "Oops...",
									allowEscapeKey: false,
									allowOutsideClick: false,									
									html: retornoMensagem,
									icon: "warning"
								});
	
							}	
							
							// REMOVE TOASTR
							toastr.clear();							
	
						}					
	
					});						

				}

			});				

			// CANCELAR VENDA
			$('body').on('click', 'a.btCancelar', function() {

				// CAPTURA VARIAVEIS
				var idVenda 	= $(this).attr('data-idVenda');
				var nf_status 	= $(this).attr('data-nf');
				var cpf 		= String($(this).attr('data-cpf'));
				var email 		= $(this).attr('data-email');
				var retornoResultado;
				var retornoMensagem;

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja cancelar esta venda?",
					icon: 'warning',
					input: 'select',
					inputOptions: {
						'Arrependimento': 'Arrependimento',
						'Defeito': 'Defeito',
						'Teste': 'Teste'
					},
					inputPlaceholder: 'Selecione o Motivo...',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, cancelar!',
					cancelButtonText: 'Cancelar',
					inputValidator: function (value) {
						return new Promise(function (resolve, reject) {
							if(value.length) {
								resolve();
							} else {
								resolve('Selecione um motivo...');
							}
						});
					}
				}).then(async function (result) {				

					if(result.isConfirmed) {

						if(nf_status == 'Emitida') {

							if(cpf.length != 11 || email == 'consumidor@qv.shoes') {

								const { value: formValues } = await Swal.fire({
									title: "Preencha com os Dados do Cliente",
									icon: 'warning',
									allowEscapeKey: false,
									allowOutsideClick: false,					
									showCancelButton: true,
									confirmButtonText: 'Salvar',
									cancelButtonText: 'Fechar',			
									html:
										'<form id="formCancelamento">' +
										'<label for="swal-nome">Nome do Cliente</label>' +
										'<input type="text" id="swal-nome" class="swal2-input" placeholder="Nome completo do cliente..." required>' +
										'<label for="swal-cpf">CPF do Cliente</label>' +
										'<input type="text" id="swal-cpf" class="swal2-input maskCPF" placeholder="CPF do Cliente" required>' + 
										'</form>',
									focusConfirm: false,
									onOpen: function() {
										$('#swal-cpf').mask('999.999.999-99');
									},
									preConfirm: function () {
										return [ 
											document.getElementById('swal-nome').value, 
											document.getElementById('swal-cpf').value 
										];
									}
								});
	
								if($("#formCancelamento")[0].checkValidity()) {
									var checkCancelamento = true;
								} else {
									var checkCancelamento = false;
								}
								
							} else {
								var checkCancelamento = true;
							}							

						} else {
							var checkCancelamento = true;
						}

						// VALIDANDO ENVIO FINAL
						if(checkCancelamento) {

							// CHECA E CAPTURA VALORES PREENCHIDOS
							if(nf_status == 'Emitida') {
								if(cpf.length != 11 || email == 'consumidor@qv.shoes') {
									var cancel_Nome = document.getElementById('swal-nome').value;
									var cancel_CPF 	= document.getElementById('swal-cpf').value;
								} else {
									var cancel_Nome = "";
									var cancel_CPF = "";
								}
							} else {
								var cancel_Nome = "";
								var cancel_CPF = "";
							}

							// TOASTR - MENSAGEM INFORMATIVA                
							toastr.options =  Toastr_default_options;
							
							// CARREGA O TOASTR
							toastr["success"]("Enviando sua Solicitação", qv_modulo_nome + " / " + qv_submodulo_nome);							

							// REQUISICAO AJAX
							$.ajax({
								type: 'POST',
								dataType : "json",
								data: 'acao=cancelarVenda&idVenda='+idVenda+'&cancel_Nome='+cancel_Nome+'&cancel_CPF='+cancel_CPF+'&motivo='+result.value+'&qv_url_path='+qv_url_path,
								url: '/app/controllers/franquia/vendas/ajax.php',
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
											icon: "warning"
										});

									}

									toastr.clear();	

								}

							});	
								
						} else {
							Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada. Dados não foram preenchidos.', 'info');
						}				

					} else {
						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');
					}

				});

			});			

			// CANCELAR DOCUMENTO FISCAL
			$('body').on('click', 'a.btCancelarDocumentoFiscal', function() {

				var idVenda = $(this).attr('data-idVenda');
				var retornoResultado;
				var retornoMensagem;

				Swal.fire({
					title: "Documento Fiscal",
					text: "Tem certeza que deseja cancelar este documento fiscal?",
					icon: 'warning',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, cancelar!',
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
							data: 	'acao=cancelarDocumentoFiscal&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/vendas/ajax.php',
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
										icon: "warning"
									});

								}

								// REMOVE TOASTR
								toastr.clear();									

							}

						});						

					} else {
						Swal.fire(qv_submodulo_nome, 'Operação foi Cancelada.', 'info');
					}

				});

			});	
			
            /*** MODAL HISTORICO VENDAS  ***/
            $('#modalVendasHistorico').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idVenda = $(button).attr('data-idVenda');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalVendasHistorico .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=vendasHistorico&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

                            if(retornoConteudo.RESULTADOS > 0) {

                                var historico = retornoConteudo['ITENS'];
                                var HTML_conteudo = "";
                                for(let i = 0; i < retornoConteudo['ITENS'].length; i++) { 

                                    HTML_conteudo +=
                                        '<tr class="row-vertical-align">'+
                                        '	<td class="text-center">'+historico[i]['data_criacao']+'</td>'+
                                        '	<td class="text-center">'+historico[i]['usuario']+'</td>'+
                                        '	<td>'+historico[i]['descricao']+'</td>'
                                        '</tr>'; 
                                }    
                                
                            } else {

                                var HTML_conteudo =
                                '<tr class="row-vertical-align">'+
                                '	<td class="text-center" colspan="4">Nenhum Registro Encontrado</td>'+
                                '</tr>';                                 

                            }

							// PREENCHE O HTML
                            $("#recebeHistoricoVenda").html(HTML_conteudo);

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

            /*** MODAL DOCUMENTO FISCAL - VISUALIZAR  ***/
            $('#modalVendasNF_View').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var nf_url = $(button).attr('data-url');
				$("#documentoFiscal_frame").css({ 'height': '78vh' });
				$("#documentoFiscal_frame").attr('src',nf_url);

			});	

			// BT CLICK IMPRIMIR DOCUMENTO FISCAL
			$('body').on('click', 'a#btPrintDocumentoFiscal', function() {
				var myIframe = document.getElementById("documentoFiscal_frame").contentWindow;
				myIframe.focus();
				myIframe.print();
				return false;				
			});

            /*** MODAL DOCUMENTO FISCAL - VISUALIZAR  ***/
            $('#modalVendasNF_View___').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var nf_url = $(button).attr('data-url');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalVendasNF_View .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=vendasDocumentoFiscal_View&url='+nf_url+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

							// PREENCHE O HTML
                            $("#modalVendasNF_View .modal-body").html(retornoConteudo);
							
							// TRATANDO A LOGO
							var logo_nf = $("#modalVendasNF_View .modal-body #logomarca img").attr('src');
							logo_nf = "https://api.focusnfe.com.br/" + logo_nf;
							$("#modalVendasNF_View .modal-body #logomarca img").attr('src',logo_nf);

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
			
			// ENVIAR FORM - EXPORTAR DOCUMENTO FISCAL XML
			$("#formXML").submit(function(e) {

				// VARIAVEIS
				var formID = "#formXML";

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// AJAX FILE TARGET
				var destino = '/app/controllers/franquia/vendas/ajax.php';

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
							//$(formID+" button[type='submit']").remove();

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
									//window.location = sessionStorage.getItem("dominio")+'/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/list';

									// ABRE ABA PARA DOWNLOAD DA PLANILHA
									window.open('/assets/relatorios/'+retorno.conteudo,'_blank');
									location.reload();

								}
							});

						} else {

							$(formID+" button[type='submit']").html('Enviar');
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

var qv_create = function() {
	return {
		init: function(formID) {	
			
            // VARIAVEIS IMPORTANTES
            let QV_requisicaoAjax = "";			

			// BUSCADOR POR TERMO
			$('body').on('keyup', '#F_buscador', function (e) {
				var F_buscador = $(this).val();
				if(F_buscador.length >= 4) {
					$("#btFiltrarProdutos").trigger('click');
				}
			});		

			// FILTRO DE ORDENACAO
			$('body').on('click', 'ul.link-check li', function () {

				// CAPTURA O CLIK
				var valor_capturado = $(this).attr('data-valor');

				// REMOVE ACTIVE DE TODOS
				$("ul.link-check li").removeClass('active');

				// ADD ACTIVE
				$("ul.link-check li[data-valor='"+valor_capturado+"']").addClass('active');

				// ATUALIZA VALOR FILTRO
				$("#F_order").val(valor_capturado);

				// GATILHO
				$("#btFiltrarProdutos").trigger('click');

			});		
						
			// REALIZAR CONSULTA PRODUTOS NO ESTOQUE
			$('body').on('click', '#btFiltrarProdutos, #btCarregarMais', function() {

				// VARIAVEIS
				var F_acionador 	= $(this).attr('id');
				var F_buscador 		= $("#F_buscador").val();
				var F_categoria 	= $("#F_categoria option:selected").val();
				var F_tamanho 		= $("#F_tamanho option:selected").val();
				var F_salto 		= $("#F_salto option:selected").val();
				var F_order 		= $("#F_order").val();
				//var F_hasBalance 	= $("#F_hasBalance option:selected").val();
				var F_paginacao 	= $("#F_paginacao").val();
				var F_paginacaoMais = parseInt(F_paginacao) + parseInt(9);

				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;

				// MANIPULANDO VARIAVEIS CONFORME ACIONADOR
				if(F_acionador == 'btFiltrarProdutos') {
					F_paginacao 	= 0;
					F_paginacaoMais = parseInt(F_paginacao) + parseInt(9);
				}

				// REMOVER BT CARREGAR MAIS SEMPRE QUE FOR FEITA NOVA REQUISICAO
				$("#btCarregarMais").remove();

				// BARRA PROGRESSO
				var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 text-center">'+
				'<div class="spinner-border text-dark" role="status">'+
				'<span class="sr-only">Carregando...</span>'+
				'</div></div></div>';

				// BARRA PROGRESSO - REESCREVER CONTAINER OU ADICONAR
				if(F_paginacao == 0) {
					$("#recebeProdutos").html(barraProgresso);
				} else {
					$("#recebeProdutos").append(barraProgresso);
				}

				// CANCELA REQUISICAO ANTERIOR
				if(QV_requisicaoAjax.length) {
					QV_requisicaoAjax.abort();
				}				

				// REQUISICAO AJAX
				QV_requisicaoAjax = $.ajax({
					type: 'POST',
					dataType : "json",
					data: 	'acao=consulta-estoque&F_buscador='+F_buscador+'&F_categoria='+F_categoria+'&F_tamanho='+F_tamanho+'&F_salto='+F_salto+'&F_order='+F_order+'&F_paginacao='+F_paginacao+'&qv_url_path='+qv_url_path,
					url: '/app/controllers/franquia/vendas/ajax.php',
					success: function(retorno){
						retornoResultado = retorno.resultado;
						retornoMensagem  = retorno.mensagem;
						retornoConteudo  = retorno.conteudo;
					}, // SUCCESS
					complete: function() {
						if(retornoResultado === true) {

							if(retornoConteudo['RESULTADOS'] == 0 && F_paginacao == 0) {

								$("#recebeProdutos").html('<div class="row"><div class="col-12 text-center"><h3>Nenhum Resultado Encontrado</h3></div></div>');

							} else if(retornoConteudo['RESULTADOS'] == 0 && F_paginacao > 0) {

								$("#btCarregarMais").addClass('d-none');
								$("#barraProgresso").remove();

							} else {

								// GERA BT CARREGAR MAIS
								var btCarregarMais = 
									'<div class="col-12" id="divBTCarregarMais"><a href="javascript:void(0);" id="btCarregarMais" class="btn btn-secondary d-block w-25 mx-auto my-2" data-paginacao="'+F_paginacaoMais+'">Carregar Mais</a></div>';

								// MONTANDO HTML
								var conteudo_html = "";
								for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {
									
									conteudo_html += 
										'<div class="col-md-4 mb-3">'+
										'	<div class="card card-bordered product-card">'+
										'		<div class="product-thumb">'+
										'			<a href="/franquia/vendas/produto/'+retornoConteudo['ITENS'][i]['SLUG']+'">'+
										'				<img class="card-img-top" src="'+retornoConteudo['ITENS'][i]['FOTO']+'" alt="">'+
										'			</a>'+
										'			<ul class="product-badges '+(retornoConteudo['ITENS'][i]['NOVIDADE'] ? '' : 'd-none')+'">'+
										'				<li><span class="badge bg-success">Novidade</span></li>'+
										'			</ul>'+
										'		</div>'+
										'		<div class="card-inner text-center">'+
										'			<ul class="product-tags">'+
										'				<li><a href="#">'+retornoConteudo['ITENS'][i]['CATEGORIA']+'</a></li>'+
										'			</ul>'+
										'			<h5 class="product-title"><a href="/franquia/vendas/produto/'+retornoConteudo['ITENS'][i]['SLUG']+'">'+retornoConteudo['ITENS'][i]['NOME']+'</a></h5>'+
										'			<div class="product-price text-primary h5">R$ '+retornoConteudo['ITENS'][i]['PRECO']+'</div>'+
										'			<ul class="product-tags">'+
										'				<li><p class="small">'+retornoConteudo['ITENS'][i]['SALDO']+' Unidades</p></li>'+
										'			</ul>'+
										'		</div>'+
										'	</div>'+
										'</div><!-- .col -->';

								} // FOR

								// HTML DE PRODUTOS - REESCREVER CONTAINER OU ADICONAR
								if(F_paginacao == 0) {
									$("#recebeProdutos").html(conteudo_html);
								} else {
									$("#barraProgresso").remove();
									$("#recebeProdutos").append(conteudo_html);
								}
								
								// VALIDANDO EXIBICAO DO BT CARREGAR MAIS
								if(retornoConteudo['RESULTADOS'] == 9) {
									$("#recebeProdutos").append(btCarregarMais);
								}

								// ATUALIZA NOVO VALOR DE PAGINACAO NO BT CARREGAR MAIS
								$("#F_paginacao").val(F_paginacaoMais);

								//$("#btCarregarMais").attr('data-paginacao',F_paginacaoMais);

							}
																

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

					}

				});						

			});			

			// ENVIAR FORM - PRODUTOS
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// AJAX FILE TARGET
				var destino = '/app/models/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/'+qv_submodulo_slug+'.php';

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
									window.location = sessionStorage.getItem("dominio")+'/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/list';
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Cadastrar');
							$(formID+" button[type='submit']").removeAttr('disabled');
							$(formID + " #nome").focus();
							//resetForm(formID);

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


var qv_productInfo = function() {
	return {
		init: function() {					

			// SELECIONAR GRADE - ATUALIZA CAMPO DE QUANTIDADE
			$('body').on('click', 'input.productInfo_Grade', function() {
					
				/** CAPTURA VARIAVEIS **/
				var productInfo_Grade = $(this).val();
				var productInfo_Saldo = $(this).attr('data-saldo');

				/** APLICA VALOR MAXIMO NA QUANTIDADE E RESETA CAMPO **/
				$("input.productInfo_Quantidade").val(0);
				$("input.productInfo_Quantidade").attr('max',productInfo_Saldo);

			});	

			// VALIDANDO QUANTIDADE MAXIMA DA GRADE
			$('body').on('change', 'input.productInfo_Quantidade', function() {
					
				/** CAPTURA VARIAVEIS **/
				var productInfo_Quantidade 		= $(this).val();
				var productInfo_QuantidadeMax 	= $(this).attr('max');

				// VALIDACAO
				if(parseInt(productInfo_Quantidade) > parseInt(productInfo_QuantidadeMax)) {
					$("input.productInfo_Quantidade").val(productInfo_QuantidadeMax);
				}

			});				
			
			// ADD AO CARRINHO
			$('body').on('click', '#productInfo_AddShopCart', function() {

				// VARIAVEIS
				var P_idProduto 	= $(this).attr('data-idProduto');
				var P_grade 		= $("input.productInfo_Grade:checked").val();
				var P_quantidade 	= $("input.productInfo_Quantidade").val();
				var P_preco 		= $(this).attr('data-preco');

				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;

				// CHECK QUANTIDADE FOI INSERIDA
				if(P_quantidade > 0) {

					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Adicionando Produto", "Carrinho de Compras");	

					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=adicionar-produto&P_idProduto='+P_idProduto+'&P_grade='+P_grade+'&P_quantidade='+P_quantidade+'&P_preco='+P_preco+'&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {
								
								carregarShopCart();

								// ABRIR BARRA LATERAL
								$("a[data-target=userAside]").trigger('click');

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
							
							// REMOVE TOASTR
							toastr.clear();							

						}					

					});	
				} else {

					// ALERT
					swal.fire({
						title: "Oops...",
						allowEscapeKey: false,
						allowOutsideClick: false,						
						text: "Escolha uma quantidade.",
						icon: "warning"
					});					
					
				}					

			});			

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_checkout = function() {
	return {
		init: function(formID) {

            // VARIAVEIS IMPORTANTES
            let QV_requisicaoAjax = "";				

			// VERIFICA SE EXISTE PEDIDO CARREGADO
			$('body').on('change', '#idCliente', function() {
				var idCliente = $(this).val();
				if(idCliente != '') {
					$("#C_formaPagamento").trigger('change');
					$("#C_descontoTipo").trigger('change');
					$("#btAplicarDesconto").trigger('click');
				}
			});	

			// ATIVA MODO CONSUMIDOR
			$('body').on('click', '#btVendaConsumidor', function() {

				// VARIAVEIS IMPORTANTES
				var modoVenda = $(this).attr('data-modo');
				var camposObrigatorios = ['#C_nome','#C_tamanho','#C_telefone','#C_sexo'];

				// CHECA QUAL MODO SERA ATIVADO
				if(modoVenda == 'consumidor') {

					$('div.block_DadosCliente').removeClass('d-none');
					$(this).attr('data-modo','cliente');
					$(this).removeClass('btn-secondary').addClass('btn-white btn-outline-light');

					for(i=0; camposObrigatorios.length > i; i++) {
						$(camposObrigatorios[i]).attr('required',true);
					}

					$("#idCliente").val('');

				} else {

					$('div.block_DadosCliente').addClass('d-none');
					$(this).attr('data-modo','consumidor');
					$(this).removeClass('btn-white btn-outline-light').addClass('btn-secondary');

					for(i=0; camposObrigatorios.length > i; i++) {
						$(camposObrigatorios[i]).removeAttr('required');
					}

					$("#idCliente").val('consumidor');

				}
			});	
			
			// BUSCADOR CLIENTES
			$('body').on('keypress', '#QV_buscadorClientes', function (e) {
				var termo = $(this).val();
				if(termo.length >= 4) {
					
                    // VARIAVEIS AUXILIARES
                    var retornoResultado;
                    var retornoMensagem;
                    var retornoConteudo;

                    // CANCELA REQUISICAO ANTERIOR
                    if(QV_requisicaoAjax.length) {
                        QV_requisicaoAjax.abort();
                    }

                    // BARRA PROGRESSO
                    var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 text-center">'+
                    '<div class="spinner-border text-dark" role="status">'+
                    '<span class="sr-only">Carregando...</span>'+
                    '</div></div></div>';
                    $("#recebeConsultaClientes").html(barraProgresso);                    

                    // REQUISICAO AJAX
                    QV_requisicaoAjax = $.ajax({
                        type: 'post',
                        dataType : "json",
                        data: 	'acao=buscador_clientes&termo='+termo+'&qv_url_path='+qv_url_path,
                        url: '/app/controllers/franquia/vendas/ajax.php',
                        success: function(retorno){
                            retornoResultado    = retorno.resultado;
                            retornoMensagem     = retorno.mensagem;
                            retornoConteudo     = retorno.conteudo;
                        }, // SUCCESS
                        complete: function() {
                            if(retornoResultado === true) {

                                if(retornoConteudo.RESULTADOS > 0) {

                                    // MONTANDO HTML
                                    var HTML_conteudo = "";
                                    for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {

										var objeto_json = JSON.stringify(retornoConteudo['ITENS'][i]);
										var json_tratado = objeto_json.replace(/\\n/g, "\\n")
											.replace(/\\'/g, "\\'")
											.replace(/\\"/g, '\\"')
											.replace(/\\&/g, "\\&")
											.replace(/\\r/g, "\\r")
											.replace(/\\t/g, "\\t")
											.replace(/\\b/g, "\\b")
											.replace(/\\f/g, "\\f");

                                        HTML_conteudo += 
                                            '<li>'+
                                                '<div class="custom-control custom-control-sm custom-radio custom-control-pro">'+
                                                    '<input type="radio" class="custom-control-input inputListagemCliente" id="listagem_cliente_'+i+'" name="listagem_cliente" data-idCliente="'+retornoConteudo['ITENS'][i]['id']+'" data-cpf="'+retornoConteudo['ITENS'][i]['cpf']+'" data-resultado=\''+objeto_json+'\'>'+
                                                    '<label class="custom-control-label" for="listagem_cliente_'+i+'">'+
                                                        '<span class="user-card">'+
                                                            '<span class="user-name">'+retornoConteudo['ITENS'][i]['nome']+'</span>'+
                                                        '</span>'+
                                                    '</label>'+
                                                '</div>'+
                                            '</li>'; 
                                    }                                   

                                } else {

                                    // MONTANDO HTML
                                    var HTML_conteudo = 
                                        '<li>'+
                                            '<div class="custom-control custom-control-sm custom-radio custom-control-pro">'+
                                                '<label class="custom-control-label" for="user-choose-s1">'+
                                                    '<span class="user-card">'+
                                                        '<span class="user-name">Nenhum Resultado</span>'+
                                                    '</span>'+
                                                '</label>'+
                                            '</div>'+
                                        '</li>';

                                }

                                // MOSTRA HTML
                                $("#recebeConsultaClientes").html(HTML_conteudo);

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
			
			// SET CPF CLIENTE NO BUTTON
			$('body').on('click', 'input.inputListagemCliente', function (e) { 
                var cpfCliente = $(this).attr('data-cpf');  
				var json_dados = $(this).attr('data-resultado');  
                $("#BT_enviarBuscadorCliente").attr('data-cpf',cpfCliente);    
				$("#BT_enviarBuscadorCliente").attr('data-resultado',json_dados);         
            });

			// DEFINIR NOVO CLIENTE
			$('body').on('click', '#BT_enviarBuscadorCliente', function (e) {
				var cpfCliente = $(this).attr('data-cpf');
				var json_dados = $(this).attr('data-resultado');
				if(cpfCliente != '') {
					$('#C_cpf',formID).val(cpfCliente);
					$("#C_cpf").trigger('change');
					$('#modalConsultaClientes').modal('toggle');
				} else {

					json_dados = $.parseJSON(json_dados);

					$('#idCliente',formID).val(json_dados.id);
					$('#C_nome',formID).val(json_dados.nome);
					$('#C_nascimento',formID).val(json_dados.nascimento);
					$('#C_sexo option[value="'+json_dados.sexo+'"]',formID).attr('selected', 'selected').trigger('change.select2');
					$('#C_tamanho',formID).val(json_dados.tamanho);
					$('#C_telefone',formID).val(json_dados.telefone);
					$('#C_email',formID).val(json_dados.email);

					$('#modalConsultaClientes').modal('toggle');

				}
			});	   			

			// CONSULTA CPF
			$('body').on('change', '#C_cpf', function() {
				
				var cpf = $(this).val().replace(/[^0-9]/gi, '');
				if(cpf.length == 11) {

					var retornoResultado;
					var retornoMensagem;
					var retornoConteudo;
	
					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Consultando CPF...", "Checkout do Pedido");	
	
					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=consultar-cpf&C_cpf='+cpf+'&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {
								
								if(retornoConteudo.RESULTADOS > 0) {
									$('#idCliente',formID).val(retornoConteudo.ITENS.ID_CLIENTE);
									$('#C_nome',formID).val(retornoConteudo.ITENS.NOME);
									$('#C_nascimento',formID).val(retornoConteudo.ITENS.NASCIMENTO);
									$('#C_sexo option[value="'+retornoConteudo.ITENS.SEXO+'"]',formID).attr('selected', 'selected').trigger('change.select2');
									$('#C_tamanho',formID).val(retornoConteudo.ITENS.TAMANHO);
									$('#C_telefone',formID).val(retornoConteudo.ITENS.TELEFONE);
									$('#C_email',formID).val(retornoConteudo.ITENS.EMAIL);
								} else {
									$('#idCliente',formID).val('');
								}
	
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
							
							// REMOVE TOASTR
							toastr.clear();							
	
						}					
	
					});						

				}					

			});

			// ATIVA MODO AUTO PREENCHIMENTO FORMAS PAGAMENTO
			$('body').on('click', '#btAutoFillPagamentos', function() {
				var status = $(this).attr('data-status');
				if(status == 'ativado') {
					$(this).attr('data-status','desativado');
					$(this).removeClass('btn-secondary').addClass('btn-white btn-outline-light');
					$(this).attr('title','Auto Preencher Valores - Desativado');
					$(this).attr('data-bs-original-title','Auto Preencher Valores - Desativado');
				} else {
					$(this).attr('data-status','ativado');
					$(this).removeClass('btn-white btn-outline-light').addClass('btn-secondary');
					$(this).attr('title','Auto Preencher Valores - Ativado');
					$(this).attr('data-bs-original-title','Auto Preencher Valores - Ativado');
				}
				$("#recebeFormasPagamento .linhaFormaPagamento[data-linha=1] .C_valor").focus();
			});				

			// ADICIONA OU REMOVE LINHA DE FORMA DE PAGAMENTO
			$('body').on('click', 'button.btFormasPagamentos', function() {
					
				/** CAPTURA VARIAVEIS **/
				var btAcao = $(this).attr('data-acao');
				if(formID == "#formUpdateVenda") {
					var valorShopCart = $("#totalLiquido").val();
				} else {
					var valorShopCart = $("#shopCart_TotalPedido").attr('data-valor');
				}
				

				// CONTAGEM DE LINHAS
				var linhasQTDAtual = contarElementos("#recebeFormasPagamento .linhaFormaPagamento");
				var linhasQTDNova  = (btAcao == 'adicionar' ? parseInt(linhasQTDAtual) + parseInt(1) : parseInt(linhasQTDAtual) - parseInt(1)); 

				// HTML
				var linhaFormaPagamento_HTML =
					'<div class="row linhaFormaPagamento mb-2" data-linha="'+linhasQTDNova+'">'+
					'	<div class="col-lg-3 col-6 mb-2">'+
					'		<div class="form-group">'+
					'			<label class="form-label" for="C_metodoPagamento_'+linhasQTDNova+'">Método de Pagamento</label>'+
					'			<div class="form-control-wrap ">'+
					'				<select name="C_metodoPagamento[]" id="C_metodoPagamento_'+linhasQTDNova+'" class="form-control qvSelect2_noSearch C_metodoPagamento" required>'+
					'					<option></option>'+
					'					<option value="Dinheiro">Dinheiro</option>'+
					'					<option value="Pix">Pix</option>'+
					'					<option value="Cartão Débito">Cartão Débito</option>'+
					'					<option value="Cartão Crédito">Cartão Crédito</option>'+
					'					<option value="Boleto">Boleto</option>'+
					'					<option value="Cheque">Cheque</option>'+
					'					<option value="Carnê">Carnê</option>'+
					'				</select>'+
					'			</div>'+
					'		</div>'+
					'	</div>'+
					'	<div class="col-lg-3 col-6 mb-2">'+
					'		<div class="form-group">'+
					'			<label class="form-label" for="C_formaPagamento_'+linhasQTDNova+'">Forma de Pagamento</label>'+
					'			<div class="form-control-wrap ">'+
					'				<select name="C_formaPagamento[]" id="C_formaPagamento_'+linhasQTDNova+'" class="form-control qvSelect2_noSearch C_formaPagamento" required>'+
					'					<option></option>'+
					'					<option value="À Vista">À Vista</option>'+
					'					<option value="Parcelada">Parcelada</option>'+
					'				</select>'+
					'			</div>'+
					'		</div>'+
					'	</div>'+
					'	<div class="col-lg-2 col-6 mb-2">'+
					'		<div class="form-group">'+
					'			<label class="form-label" for="C_parcelas_'+linhasQTDNova+'">'+
					'				Parcelas '+
					'				<span class="text-muted recebeValorParcela" style="font-size:68%;">(R$ 0,00)</span>'+
					'			</label>'+
					'			<div class="form-control-wrap number-spinner-wrap">'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="qv_minus"><em class="icon ni ni-minus"></em></button>'+
					'				<input type="number" id="C_parcelas_'+linhasQTDNova+'" name="C_parcelas[]" class="form-control number-spinner C_parcelas" min="1" value="1" max="1">'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="qv_plus"><em class="icon ni ni-plus"></em></button>'+
					'			</div>'+
					'		</div>'+
					'	</div>'+ 
					'	<div class="col-lg-2 col-6 mb-2">'+
					'		<div class="form-group">'+
					'			<label class="form-label" for="C_vencimento">Vencimento</label>'+
					'			<a href="#modalVencimentoExplicacao" data-bs-toggle="modal" data-bs-placement="top" title="Explicação"><em class="icon ni ni-info-fill"></em></a>'+
					'			<div class="form-control-wrap">'+
					'				<input type="text" class="form-control maskData" id="C_vencimento" name="C_vencimento[]" value="'+moment().format('L')+'" placeholder="00/00/0000">'+
					'			</div>'+
					'		</div>'+
					'	</div>'+
					'	<div class="col-lg-2 mb-2">'+
					'		<div class="form-group">'+
					'			<label class="form-label" for="C_valor_'+linhasQTDNova+'">Valor Total (R$)</label>'+
					'			<div class="form-control-wrap">'+
					'				<input type="text" class="form-control maskNumber C_valor" name="C_valor[]" id="C_valor_'+linhasQTDNova+'" placeholder="0,00" autocomplete="off" value="0" data-valueAutoFill="true" required>'+
					'			</div>'+
					'		</div>'+
					'	</div>'+
					'	<hr class="my-3 d-block d-sm-none" />'+
					'</div> <!-- ROW -->';				

				// EXECUTANDO ACAO E VALIDANDO QTDs - ADD LINHA
				if(btAcao == 'adicionar') {

					$("#recebeFormasPagamento").append(linhaFormaPagamento_HTML);

					// RECARREGA PLUGINS
					$('input.maskData').mask('99/99/9999');
					$("select.qvSelect2_noSearch").select2({
						placeholder: "Selecione uma opção...",
						allowClear: false,
						minimumResultsForSearch: Infinity
					});
					$("input.maskNumber").maskMoney({
						"prefix":       '',
						"thousands":    '.',
						"decimal":      ',',
						"affixesStay":  false,
						"allowZero":    true
					}); 					  					

				} 

				// EXECUTANDO ACAO E VALIDANDO QTDs - REMOVE LINHA
				if(btAcao == 'remover' && linhasQTDNova > 0) {
					$(".linhaFormaPagamento[data-linha="+linhasQTDAtual+"]").remove();
				} 	
				
				// ATUALIZA VALOR TOTAL DAS PARCELAS
				if((btAcao == 'adicionar') || (btAcao == 'remover' && linhasQTDNova > 0)) {

					// CHECA O AUTO PREENCHIMENTO
					var autoFillPagamentos = $("#btAutoFillPagamentos").attr('data-status');
					if(autoFillPagamentos == 'ativado' || linhasQTDNova == 1) {

						// DIVISAO DO VALOR TOTAL DA VENDA PELAS FORMAS DE PAGAMENTO | NAO INCLUI PARCELAS
						var valorTotalPorFormaPagamento = currency(valorShopCart).distribute(linhasQTDNova);
						
						// PERCORRE LINHAS DE PAGAMENTO ATUALIZANDO VALOR TOTAL | CONSIDERANDO PARCELAS
						$(".linhaFormaPagamento").each(function(i) {

							var currentElement 		= $(this);
							var parcelas 			= $(".C_parcelas",currentElement).val();
							var novoValorParcela 	= currency(valorTotalPorFormaPagamento[i]).divide(parcelas);
							

							$(".C_valor",currentElement).val(parseFloat(valorTotalPorFormaPagamento[i]).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

							$(".recebeValorParcela",currentElement).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");

						});							

					}
					
					alertaFormasPagamento();

				}				

			});	

			// SELECIONAR METODO PAGAMENTO - DESATIVA PARCELAMENTO
			$('body').on('change', '*.C_metodoPagamento', function() {

				// RECEBE E DEFINE VARIAVEIS
				var targetField     		= $(this).closest(".linhaFormaPagamento");
				var C_metodoPagamento 		= $(this,'option:selected').val();
				var metodosPagamento_Vista	= ['Dinheiro','Pix','Cartão Débito','Boleto'];

				// FAZ CHECAGEM
				if(metodosPagamento_Vista.includes(C_metodoPagamento)) {
					$(".C_formaPagamento option[value='Parcelada']",targetField).attr('disabled','disabled');
				} else {
					$(".C_formaPagamento option[value='Parcelada']",targetField).removeAttr('disabled');
				}

				$("select.qvSelect2_noSearch").select2({
					placeholder: "Selecione uma opção...",
					allowClear: false,
					minimumResultsForSearch: Infinity
				});

			});
			
			
			// SELECIONAR FORMA PAGAMENTO - ATUALIZA LIMITE DE PARCELAS
			$('body').on('change', '*.C_formaPagamento', function() {
					
				/** CAPTURA VARIAVEIS **/
				var targetField     = $(this).closest(".linhaFormaPagamento");
				var C_formaPagamento = $(this,'option:selected').val();

				// APLICAR LIMITE PARCELAS
				if(C_formaPagamento == 'Parcelada') {
					$(".C_parcelas",targetField).attr('max',12);
				} else {
					$(".C_parcelas",targetField).attr('max',1);
				}

				$(".C_parcelas",targetField).val(1);
				$("input.number-spinner",targetField).trigger("change");

			});	

			// TRATANDO NUMERO DE PARCELAS
			$('body').on('change', 'input.C_parcelas', function() {

				// CAPTURANDO VARIAVEIS
				var targetField  		= $(this).closest(".linhaFormaPagamento");
				var parcelas 			= $(".C_parcelas",targetField).val();
				var valorFormaPagamento = $(".C_valor",targetField).maskMoney('unmasked')[0];
				var novoValorParcela 	= (parseFloat(valorFormaPagamento) / parseInt(parcelas)).toFixed(2);

				// APLICA NOVOS VALORES POR PARCELA
				$(".recebeValorParcela",targetField).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");
				
			});	
			
			// MANIPULANDO MANUALMENTE VALOR TOTAL DE CADA FORMA PAGAMENTO
			$('body').on('change', 'input.C_valor', function() {

				// CAPTURANDO VARIAVEIS
				var targetField  		= $(this).closest(".linhaFormaPagamento");
				var targetField_ID		= $(".C_valor",targetField).attr('id');
				var valorInserido  		= $(".C_valor",targetField).maskMoney('unmasked')[0];
				var parcelasAtuais  	= $(".C_parcelas",targetField).val();
				var linhasQTDAtual 		= parseInt(contarElementos("#recebeFormasPagamento .linhaFormaPagamento"));
				var linhasQTDAlt 		= parseInt(contarElementos("#recebeFormasPagamento .linhaFormaPagamento")) - parseInt(1);
				var valorShopCart 		= $("#shopCart_TotalPedido").attr('data-valor');
				var autoFillPagamentos 	= $("#btAutoFillPagamentos").attr('data-status');

				// CHECAGEM
				if(autoFillPagamentos == 'ativado' && linhasQTDAtual > 1) {

					// DIVISAO DO VALOR TOTAL DA VENDA PELAS FORMAS DE PAGAMENTO EXCETO A ATUAL EM EDIÇÃO | NAO INCLUI PARCELAS
					var valorTotalPorFormaPagamento = currency((parseFloat(valorShopCart) - parseFloat(valorInserido))).distribute(linhasQTDAlt);

					var contador = 0;

					// PERCORRE LINHAS DE PAGAMENTO ATUALIZANDO VALOR TOTAL | CONSIDERANDO PARCELAS
					$(".linhaFormaPagamento").each(function() {

						var currentElement 		= $(this);
						var currentElement_ID	= $(".C_valor",currentElement).attr('id');
						var parcelas 			= $(".C_parcelas",currentElement).val();
						var novoValorParcela 	= currency(valorTotalPorFormaPagamento[contador]).divide(parcelas);

						if(currentElement_ID != targetField_ID) {

							$(".C_valor",currentElement).val(parseFloat(valorTotalPorFormaPagamento[contador]).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

							$(".recebeValorParcela",currentElement).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");	
														
							contador++;

						} else {
							var novoValorParcela = currency(valorInserido).divide(parcelasAtuais);
							$(".C_valor",targetField).val(parseFloat(valorInserido).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
							$(".recebeValorParcela",targetField).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");	
						}

					});	
					
				} else if((autoFillPagamentos == 'ativado' || autoFillPagamentos == 'desativado') && linhasQTDAtual == 1) {

					// DIVISAO DO VALOR TOTAL DA VENDA PELAS FORMAS DE PAGAMENTO | NAO INCLUI PARCELAS
					var valorTotalPorFormaPagamento = currency(valorShopCart).distribute(linhasQTDAtual);
					
					// PERCORRE LINHAS DE PAGAMENTO ATUALIZANDO VALOR TOTAL | CONSIDERANDO PARCELAS
					$(".linhaFormaPagamento").each(function(i) {

						var currentElement 		= $(this);
						var parcelas 			= $(".C_parcelas",currentElement).val();
						var novoValorParcela 	= currency(valorTotalPorFormaPagamento[i]).divide(parcelas);

						$(".C_valor",currentElement).val(parseFloat(valorTotalPorFormaPagamento[i]).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

						$(".recebeValorParcela",currentElement).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");

					});						

				} else {

					var parcelas 			= $(".C_parcelas",targetField).val();
					var novoValorParcela 	= currency(valorInserido).divide(parcelas);

					$(".C_valor",targetField).val(parseFloat(valorInserido).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

					$(".recebeValorParcela",targetField).html("(R$ "+parseFloat(novoValorParcela).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");	

				}
				
				alertaFormasPagamento();
				
			});			

			// TRATANDO REMOCAO DESCONTO
			$('body').on('change', '#C_descontoTipo', function() {

				// CAPTURANDO VARIAVEIS
				var tipoDesconto = $(this,' option:selected').val();

				// VALIDANDO
				if(tipoDesconto == 'Nenhum') {
					$("#C_desconto",formID).val(0);
				}
				
			});
			
			// APLICAR DESCONTO
			$('body').on('click', '#btAplicarDesconto', function() {

				// VARIVEIS
				var P_descontoTipo = $("#C_descontoTipo option:selected",formID).val();
				var P_desconto 	   = $("#C_desconto",formID).val();
				if(formID == "#formUpdateVenda") {
					var valorShopCart = $("#totalBruto").val();
				}

				// APLICANDO
				if((P_descontoTipo != 'Nenhum' && P_desconto > 0) || (P_descontoTipo == 'Nenhum' && P_desconto == 0)) {

					// VALIDANDO PAGINA 
					if(formID != "#formUpdateVenda") {

						var retornoResultado;
						var retornoMensagem;
		
						// TOASTR - MENSAGEM INFORMATIVA                
						toastr.options =  Toastr_default_options;
						
						// CARREGA O TOASTR
						toastr["success"]("Aplicando Desconto...", "Checkout do Pedido");	
		
						// REQUISICAO AJAX
						$.ajax({
							type: 'POST',
							dataType : "json",
							data: 	'acao=aplicar-desconto&P_descontoTipo='+P_descontoTipo+'&P_desconto='+P_desconto+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/vendas/ajax.php',
							success: function(retorno){
								retornoResultado = retorno.resultado;
								retornoMensagem  = retorno.mensagem;
							}, // SUCCESS
							complete: function() {
								if(retornoResultado === true) {

									if(formID != "#formUpdateVenda") {

										// RECARREGA SHOPCART
										carregarShopCart();
		
										// ABRIR BARRA LATERAL
										$("a[data-target=userAside]").trigger('click');

									}
		
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
								
								// REMOVE TOASTR
								toastr.clear();							
		
							}					
		
						});	

					} else {

						var descontoPercentual = 0; 
						var desconto = P_desconto;
						var valorLiquido = valorShopCart;						

						if(P_descontoTipo == 'Nenhum') {

							valorLiquido = valorShopCart;	

						} else if(P_descontoTipo == 'Porcentagem' && P_desconto > 0) {

							descontoPercentual = (parseFloat(desconto)/100) * parseFloat(valorShopCart);
							valorLiquido = parseFloat(valorShopCart) - parseFloat(descontoPercentual);
							desconto = parseFloat(descontoPercentual).toFixed(2);

						} else {

							valorLiquido = parseFloat(valorShopCart) - parseFloat(desconto);

						}

						$("#totalDesconto").val(desconto);
						$("#totalLiquido").val(valorLiquido);

						$("#recebeDesconto").html("R$ " + parseFloat(desconto).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));						

						$("#recebeTotalLiquido").html("R$ " + parseFloat(valorLiquido).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));						

					}	
					
					alertaFormasPagamento();

				}

			});	

			// CARREGAR VENDEDORES
			$('#vendedor').on('select2:open', function (e) {

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;
				var opcoes = $("#vendedor option").length;

				if(opcoes == 0) {

					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Carregando Vendedores", "Checkout do Pedido");	

					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=buscarVendedores&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {

								if(retornoConteudo.RESULTADOS > 0) {
									var vendedores = retornoConteudo.ITENS;
									var HTML_conteudo = "";
									for(let i = 0; i < retornoConteudo.ITENS.length; i++) { 
										HTML_conteudo += '<option value="'+vendedores[i]['id']+'">'+vendedores[i]['nomeExibicao']+'</option>'; 
									}   
								}

								// PREENCHE O HTML
								$("#vendedor").html(HTML_conteudo);

								$("select.qvSelect2_noSearch").select2({
									placeholder: "Selecione uma opção...",
									allowClear: false,
									minimumResultsForSearch: Infinity
								});							

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

							// REMOVE TOASTR
							toastr.clear();	

						}

					});	   


				}

			});		
			
			// ENVIAR FORM - VENDA
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// VARIAVEIS IMPORTANTES
				var destino 		= '/app/controllers/franquia/vendas/ajax.php';
				var formasPagamento = alertaFormasPagamento();

				if(formID == "#formUpdateVenda") {		
					var produtos = contarElementos("#tableProdutos .linhaProdutos");
				} else {
					var produtos = contarElementos("ul#shopCart_RecebeItens li");
				}

				// VALIDANDO FORM
				if($(formID)[0].checkValidity() && formasPagamento && produtos > 0) {

					$(formID+" button[type='submit']").html(
						'<div class="spinner-border text-light" role="status">'+
						'<span class="sr-only">Carregando...</span>'+
						'</div>');
					$(formID+" button[type='submit']").attr('disabled','disabled');

					enviarForm(formID,destino, function(retorno) {

						if(retorno.resultado === true) {

							// REMOVER BT SUBMIT
							$(formID+" button[type='submit']").remove();
							
							// VALIDANDO ACAO DE INSERT OU UPDATE
							if(formID == "#formUpdateVenda") {

								// ATUALIZA BT EMISSAO FISCAL
								$("#btRe_EmitirDocumentoFiscal").attr('data-idVenda',retorno.conteudo.ID_VENDA);									

							} else {

								// ATUALIZA BT EMISSAO FISCAL
								$("#btEmitirDocumentoFiscal").attr('data-idVenda',retorno.conteudo.ID_VENDA);								

							}

							// ABRE MODAL
							$("#modalVendaFinalizada").modal('show');

							// REDIRECIONA QUANDO MODAL FOR FECHADA
							$("#modalVendaFinalizada").on("hidden.bs.modal", function () {
								window.location = '/franquia/vendas/list';
							});

						} else {

							if(formID == "#formUpdateVenda") {
								$(formID+" button[type='submit']").html('Salvar Alterações');
							} else {
								$(formID+" button[type='submit']").html('Finalizar Venda');
							}

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
				} else {
					Swal.fire({
						title: 'Oops!',
						text: "Existem erros na venda. Verifique os campos, os produtos e as dados de pagamento.",
						icon: 'error',
						allowEscapeKey: false,
						allowOutsideClick: false,						
						confirmButtonColor: '#4fa7f3',
						confirmButtonText: 'Fechar'
					});					
				}

			}); // FORM SUBMIT	
			
			// EMISSAO DOCUMENTO FISCAL - NFe / NFCe
			$('body').on('click', '#btEmitirDocumentoFiscal', function() {

				// VARIVEIS
				var idVenda = $(this).attr('data-idVenda');
				var btClicado = $(this);

				// VALIDANDO
				if(idVenda != '') {

					var retornoResultado;
					var retornoMensagem;
					var retornoConteudo;
	
					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Aguarde a emissão...", "Documento NFe / NFCe");	
	
					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=emissaoFiscal&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {

								// ABRE DOCUMENTO FISCAL EM UMA NOVA ABA
								window.open(retornoConteudo.url_nf,'_blank');
								
								$(btClicado).attr('id','abrirNF');
								$(btClicado).attr('href',retornoConteudo.url_nf);
								$(btClicado).attr('target','_blank');
								$(btClicado).removeClass('btn-secondary');
								$(btClicado).addClass('btn-light');
								$(btClicado).html('<em class="icon ni ni-printer me-1"></em> Abrir Cupom Fiscal');
								
							} else {
	
								// ALERT
								swal.fire({
									title: "Oops...",
									allowEscapeKey: false,
									allowOutsideClick: false,									
									html: retornoMensagem,
									icon: "warning"
								});
	
							}	
							
							// REMOVE TOASTR
							toastr.clear();							
	
						}					
	
					});						

				}

			});	

			// RE_EMISSAO DOCUMENTO FISCAL - NFe / NFCe | APOS UPDATE
			$('body').on('click', '#btRe_EmitirDocumentoFiscal', function() {

				// VARIVEIS
				var idVenda = $(this).attr('data-idVenda');
				var btClicado = $(this);

				// VALIDANDO
				if(idVenda != '') {

					var retornoResultado;
					var retornoMensagem;
					var retornoConteudo;
	
					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Aguarde a emissão...", "Documento Fiscal");	
	
					// REQUISICAO AJAX
					$.ajax({
						type: 'POST',
						dataType : "json",
						data: 	'acao=ReemissaoFiscal&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
						url: '/app/controllers/franquia/vendas/ajax.php',
						success: function(retorno){
							retornoResultado = retorno.resultado;
							retornoMensagem  = retorno.mensagem;
							retornoConteudo  = retorno.conteudo;
						}, // SUCCESS
						complete: function() {
							if(retornoResultado === true) {

								// ABRE DOCUMENTO FISCAL EM UMA NOVA ABA
								window.open(retornoConteudo.url_nf,'_blank');
								
								$(btClicado).attr('id','abrirNF');
								$(btClicado).attr('href',retornoConteudo.url_nf);
								$(btClicado).attr('target','_blank');
								$(btClicado).removeClass('btn-secondary');
								$(btClicado).addClass('btn-light');
								$(btClicado).html('<em class="icon ni ni-printer me-1"></em> Abrir Cupom Fiscal');
								
							} else {
	
								// ALERT
								swal.fire({
									title: "Oops...",
									allowEscapeKey: false,
									allowOutsideClick: false,									
									html: retornoMensagem,
									icon: "warning"
								});
	
							}	
							
							// REMOVE TOASTR
							toastr.clear();							
	
						}					
	
					});						

				}

			});				
			
			/****************************************/
			/********** UPDATE EDITANDO VENDA *******/
			/****************************************/
			// ATIVA CONSUMIDOR
			if(formID == '#formUpdateVenda') {
				var email = $("#C_email",formID).val();
				var idCliente = $("#idCliente",formID).val();
				if(email == 'consumidor@qv.shoes') {
					$("#btVendaConsumidor").trigger('click');
					$("#idCliente",formID).val(idCliente);
				}
			}

			// REMOVE PRODUTO DA TABELA DA VENDA
			$('body').on('click', 'a.QV_RemoverItemCarrinho', function() {
				var idItem = $(this).attr('data-idItem');
				if(idItem != '') {

					$("#tableProdutos tr[data-idItem="+idItem+"]").remove();
					var qtdProdutos = contarElementos("#tableProdutos .linhaProdutos");
					if(qtdProdutos == 0 ) {

						$("#totalBruto").val(0);
						$("#totalLiquido").val(0);
						$("#recebeTotalBruto").html("R$ 0,00");
						$("#recebeTotalLink").html("R$ 0,00");

						// ATIVAR VALIDACAO DO DESCONTO E PREENCHER OS INDICADORES
						$("#btAplicarDesconto").trigger('click');

						// ATIVAR VALIDACAO DOS DADOS DE PAGAMENTO E SINCRONIZAR COM OS INDICADORES
						$("#C_valor_1").trigger('change');	

					} else {
						alertaFormasPagamento();
					}

				}
			});

			// MANIPULA QTD PRODUTOS DA VENDA
			$('body').on('change', 'input.prod_quantidade', function() {

				// CAPTURANDO VARIAVEIS
				var produtoTR 	= $(this).closest(".linhaProdutos");
				var quantidade 	= $(".prod_quantidade",produtoTR).val();
				var preco 		= $(".prodPreco",produtoTR).val();
				var precoTotal 	= parseInt(quantidade) * parseFloat(preco);
				var valorBruto 	= 0;
				
				$(".tdRecebePrecoTotal",produtoTR).html("R$ " + parseFloat(precoTotal).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

				$(".prodQTD",produtoTR).val(quantidade);

				// PERCORRE LINHAS DE PRODUTOS ATUALIZANDO VALOR TOTAL
				$(".linhaProdutos").each(function(i) {
					var currentElement 	= $(this);
					var LP_quantidade 	= $(".prod_quantidade",currentElement).val();
					var LP_preco 		= $(".prodPreco",currentElement).val();
					valorBruto 			= parseFloat(valorBruto) + (parseInt(LP_quantidade) * parseFloat(LP_preco));
				});	
				
				$("#totalBruto").val(valorBruto);
				$("#recebeTotalBruto").html("R$ " + parseFloat(valorBruto).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
				
				// ATIVAR VALIDACAO DO DESCONTO E PREENCHER OS INDICADORES
				$("#btAplicarDesconto").trigger('click');

				// ATIVAR VALIDACAO DOS DADOS DE PAGAMENTO E SINCRONIZAR COM OS INDICADORES
				$("#C_valor_1").trigger('change');
				
				// VALIDAR VALORES
				alertaFormasPagamento();

			});

            /*** MODAL CONSULTA PRODUTOS  ***/
            $('#modalConsultaProdutos').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var parametroBusca = $(button).attr('data-parametro');
				$("#QV_buscadorProdutos").attr('data-parametro',parametroBusca);
				
				// CHECA QUAL PARAMETRO SERA USADO
				if(parametroBusca == 'sku') {
					$("#QV_buscadorProdutos").attr('maxlength',14);
					$("#QV_buscadorProdutos").attr('oninput',"");
				} else {
					$("#QV_buscadorProdutos").attr('oninput',"");
					$("#QV_buscadorProdutos").attr('maxlength',"32");
				}				

				$("input#QV_buscadorProdutos").focus();
				
			});		

			// BUSCADOR PRODUTOS - NOME OU SKU
			$('body').on('keypress paste', '#QV_buscadorProdutos', function (e) {

				// CANCELA REQUISICAO ANTERIOR
				if(QV_requisicaoAjax.length) {
					QV_requisicaoAjax.abort();
				}

				// VARIAVEIS IMPORTANTES
				var eventoAcionador = e.type;
				var parametro 		= $("#QV_buscadorProdutos").attr('data-parametro');				
				
				// CHECA QUAL EVENTO FOI ACIONADO
				if(eventoAcionador == 'paste') {
					var limitadorInput = 14;
					var termo = e.originalEvent.clipboardData.getData('text');
				} else {
					var limitadorInput = 5;
					var termo = $("#QV_buscadorProdutos").val();
				}		

				if(termo.length >= limitadorInput) {
					
                    // VARIAVEIS AUXILIARES
                    var retornoResultado;
                    var retornoMensagem;
                    var retornoConteudo;

                    // CANCELA REQUISICAO ANTERIOR
                    if(QV_requisicaoAjax.length) {
                        QV_requisicaoAjax.abort();
                    }

					// TOASTR - MENSAGEM INFORMATIVA                
					toastr.options =  Toastr_default_options;
					
					// CARREGA O TOASTR
					toastr["success"]("Buscando pelo Produto...", "Vendas");                  

                    // REQUISICAO AJAX
                    QV_requisicaoAjax = $.ajax({
                        type: 'post',
                        dataType : "json",
                        data: 	'acao=buscador_produtos&termo='+termo+'&parametro='+parametro+'&qv_url_path='+qv_url_path,
                        url: '/app/controllers/franquia/vendas/ajax.php',
                        success: function(retorno){
                            retornoResultado    = retorno.resultado;
                            retornoMensagem     = retorno.mensagem;
                            retornoConteudo     = retorno.conteudo;
                        }, // SUCCESS
                        complete: function() {
                            if(retornoResultado === true) {

                                if(retornoConteudo.RESULTADOS > 0) {

                                    // MONTANDO HTML
                                    var HTML_conteudo = "";
                                    for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {

										var objeto_json = JSON.stringify(retornoConteudo['ITENS'][i]);
										var json_tratado = objeto_json.replace(/\\n/g, "\\n")
											.replace(/\\'/g, "\\'")
											.replace(/\\"/g, '\\"')
											.replace(/\\&/g, "\\&")
											.replace(/\\r/g, "\\r")
											.replace(/\\t/g, "\\t")
											.replace(/\\b/g, "\\b")
											.replace(/\\f/g, "\\f");

                                        HTML_conteudo += 
                                            '<li>'+
                                                '<div class="custom-control custom-control-sm custom-radio custom-control-pro">'+
                                                    '<input type="radio" class="custom-control-input inputListagemProduto" id="listagem_produtos_'+i+'" name="listagem_produtos" data-resultado=\''+json_tratado+'\'>'+
                                                    '<label class="custom-control-label" for="listagem_produtos_'+i+'">'+
                                                        '<span class="user-card">'+
                                                            '<span class="user-avatar sm">'+
                                                                '<img src="'+retornoConteudo['ITENS'][i]['foto']+'" alt="'+retornoConteudo['ITENS'][i]['nome']+'">'+
                                                            '</span>'+				
                                                            '<span class="user-name text-wrap">'+retornoConteudo['ITENS'][i]['nome']+'</span>'+
                                                        '</span>'+
                                                    '</label>'+
                                                '</div>'+
                                            '</li>'; 
                                    }                                   

                                } else {

                                    // MONTANDO HTML
                                    var HTML_conteudo = 
                                        '<li>'+
                                            '<div class="custom-control custom-control-sm custom-radio custom-control-pro">'+
                                                '<label class="custom-control-label" for="user-choose-s1">'+
                                                    '<span class="user-card">'+
                                                        '<span class="user-name">Nenhum Resultado</span>'+
                                                    '</span>'+
                                                '</label>'+
                                            '</div>'+
                                        '</li>';

                                }

                                // MOSTRA HTML
                                $("#recebeConsultaProdutos").html(HTML_conteudo);

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

                    }); // AJAX

				}
			});	
			
			// SET DADOS DO PRODUTO NO BUTTON
			$('body').on('click', 'input.inputListagemProduto', function (e) { 
				var json_dados = $(this).attr('data-resultado');  
				$("#BT_enviarBuscadorProdutos").attr('data-resultado',json_dados);         
            });

			// ADD NOVO PRODUTO
			$('body').on('click', '#BT_enviarBuscadorProdutos', function (e) {

				// VARIAVEIS IMPORTANTES
				var qtdLinhasProdutos = parseInt(contarElementos("#tableProdutos .linhaProdutos")) + parseInt(1);
				var json_dados 	= $(this).attr('data-resultado');
				json_dados 		= $.parseJSON(json_dados);

				var HTML_Produto_Novo =
					'<tr class="row-vertical-align linhaProdutos" data-idItem="'+qtdLinhasProdutos+'">'+
					'	<th scope="row">'+qtdLinhasProdutos+'</th>'+
					'	<td class="text-center">'+
					'		<img src="'+json_dados.foto+'" class="img-fluid w-40" />'+
					'	</td>'+
					'	<td>'+json_dados.nome+'</td>'+
					'	<td class="text-center">R$ '+parseFloat(json_dados.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</td>'+
					'	<td class="text-center">'+
					'		<div class="form-group">'+
					'			<div class="form-control-wrap number-spinner-wrap">'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="qv_minus"><em class="icon ni ni-minus"></em></button>'+
					'				<input type="number" id="prod_quantidade" name="prod_quantidade[]" class="form-control number-spinner prod_quantidade" value="1" min="1" max="'+json_dados.estoque+'" required>'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="qv_plus"><em class="icon ni ni-plus"></em></button>'+
					'			</div>'+ 
					'		</div>'+
					'	</td>'+
					'	<td class="text-center tdRecebePrecoTotal">R$ '+parseFloat(json_dados.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</td>'+
					'	<td>'+
					'		<a href="javascript:void(0);" class="btn btn-danger QV_RemoverItemCarrinho"  data-idItem="'+qtdLinhasProdutos+'">'+
					'			<em class="icon ni ni-delete-fill"></em>'+
					'		</a>'+
					'		<input type="hidden" name="prodID[]" class="prodID" value="'+json_dados.id+'" />'+
					'		<input type="hidden" name="prodSKU[]" class="prodSKU" value="'+json_dados.sku+'" />'+
					'		<input type="hidden" name="prodCOR[]" class="prodCOR" value="'+json_dados.cor_id+'" />'+
					'		<input type="hidden" name="prodTAMANHO[]" class="prodTAMANHO" value="'+json_dados.tamanho+'" />'+
					'		<input type="hidden" name="prodQTD[]" class="prodQTD" value="1" />'+
					'		<input type="hidden" name="prodPRECO[]" class="prodPreco" value="'+json_dados.preco+'" />'+
					'	</td>'+
					'</tr>';


				// ADICIONA NA TABELA
				$('#recebeProdutosVenda').append(HTML_Produto_Novo);

				// FECHA MODAL
				$('#modalConsultaProdutos').modal('toggle');	
				
				// ATIVAR VALIDACAO DO DESCONTO E PREENCHER OS INDICADORES
				$("#btAplicarDesconto").trigger('click');					

				alertaFormasPagamento();

			});	  	
			
            /*** MODAL HISTORICO VENDAS  ***/
            $('#modalVendasHistorico').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idVenda = $(button).attr('data-idVenda');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalVendasHistorico .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=vendasHistorico&idVenda='+idVenda+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

                            if(retornoConteudo.RESULTADOS > 0) {

                                var historico = retornoConteudo['ITENS'];
                                var HTML_conteudo = "";
                                for(let i = 0; i < retornoConteudo['ITENS'].length; i++) { 

                                    HTML_conteudo +=
                                        '<tr class="row-vertical-align">'+
                                        '	<td class="text-center">'+historico[i]['data_criacao']+'</td>'+
                                        '	<td class="text-center">'+historico[i]['usuario']+'</td>'+
                                        '	<td>'+historico[i]['descricao']+'</td>'
                                        '</tr>'; 
                                }    
                                
                            } else {

                                var HTML_conteudo =
                                '<tr class="row-vertical-align">'+
                                '	<td class="text-center" colspan="4">Nenhum Registro Encontrado</td>'+
                                '</tr>';                                 

                            }

							// PREENCHE O HTML
                            $("#recebeHistoricoVenda").html(HTML_conteudo);

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