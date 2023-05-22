// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'Estoque';
var qv_submodulo_slug = 'estoque';
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
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col" },
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
						d.tamanho    	= $('#DT_filtros #F_tamanho option:selected').val();
						d.categoria    	= $('#DT_filtros #F_categoria option:selected').val();
						//d.tipo    = $('#LV_produtosVitrine_Tipo').val();
						//d.dataDe    = $('#dataDe').val();
						//d.dataAte   = $('#dataAte').val();
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

            /*** MODAL GRADE DO PRODUTO  ***/
            $('#modalEstoqueGrade').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idProduto = $(button).attr('data-idProduto');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalEstoqueGrade .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');
				$("#modalEstoqueGrade .cardIndicadores").html('');					

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=visualizarGrade&idProduto='+idProduto+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

							var grade = retornoConteudo['ITENS'];
							var HTML_conteudo = "";
							for(let i = 0; i < retornoConteudo['ITENS'].length; i++) { 

								if(parseInt(grade[i]['SALDO']) > 0) {

									HTML_conteudo +=
									'<div class="col-md-2 col-6 text-center mb-2 p-1">'+
									'	<div class="card">'+
									'		<div class="card-body p-2">'+
									'			<h5 class="display-10 fw-normal">'+grade[i]['SALDO']+'</h5>'+
									'			<h5 class="card-title display-9 fw-bold border-top pt-1 mb-1">'+tratarTamanhoProdutos(grade[i]['GRADE'])+'</h5>'+
									'			<span class="small text-muted"><b>SKU:</b> '+grade[i]['SKU']+'</span>'+
									'		</div>'+
									'	</div> <!-- CARD -->'+
									'</div> <!-- COL -->';									

								}

							}                               

							// PREENCHE O HTML
                            $("#modalEstoqueGrade .cardIndicadores").html(HTML_conteudo);

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

            /*** MODAL GRADE DO MOVIMENTACAO  ***/
            $('#modalEstoqueMovimentacao').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idProduto = $(button).attr('data-idProduto');
				$("#formEstoqueMovimentacao #idProduto").val(idProduto);
			});

			// ENVIAR FORM - ESTOQUE MOVIMENTACAO
			$("#formEstoqueMovimentacao").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// VARIAVEIS 
				var formID = "#formEstoqueMovimentacao";

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
									//window.location = retornoUrlRedirecionar;
									//table.ajax.reload();
									location.reload();
									$('.modal').modal('hide');
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Salvar');
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
						
			// APAGAR REGISTRO
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

				Swal.fire({
					title: "RELATÓRIO DE ESTOQUE",
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
                                    '&qv_url_path='+qv_url_path,
                            url: '/app/controllers/franquia/estoque/ajax.php',
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
                        swal.fire("Relatório de Estoque", 'Operação foi Cancelada.', 'info');
                    }
                });

			});	// GERAR EXCEL				

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_create = function() {
	return {
		init: function(formID) {

            // VARIAVEIS IMPORTANTES
            let QV_requisicaoAjax = "";		
			
			// ENVIAR FORM - ESTOQUE MOVIMENTACAO EM MASSA
			$("#formCreate").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// VARIAVEIS 
				var formID = "#formCreate";

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
									window.location = '/franquia/estoque/movimentacoes';
									//table.ajax.reload();
									//location.reload();
									//$('.modal').modal('hide');
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

			// REMOVE PRODUTO DA TABELA DA VENDA
			$('body').on('click', 'a.QV_RemoverItemCarrinho', function() {
				var idItem = $(this).attr('data-idItem');
				if(idItem != '') {
					$("#tableProdutos tr[data-idItem="+idItem+"]").remove();
				}
			});

			// MANIPULA QTD PRODUTOS DA VENDA
			$('body').on('change', 'input.prod_quantidade', function() {

				// CAPTURANDO VARIAVEIS
				var produtoTR 	= $(this).closest(".linhaProdutos");
				var quantidade 	= $(".prod_quantidade",produtoTR).val();
				
				$(".prodQTD",produtoTR).val(quantidade);

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
					$("#QV_buscadorProdutos").attr('oninput',"this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');");
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
					var limitadorInput = 4;
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
					toastr["success"]("Buscando pelo Produto...", "Estoque");                  

                    // REQUISICAO AJAX
                    QV_requisicaoAjax = $.ajax({
                        type: 'post',
                        dataType : "json",
                        data: 	'acao=estoque_buscador_produtos&termo='+termo+'&parametro='+parametro+'&qv_url_path='+qv_url_path,
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
					'	<td class="text-center">'+
					'		<div class="form-group">'+
					'			<div class="form-control-wrap number-spinner-wrap">'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="qv_minus"><em class="icon ni ni-minus"></em></button>'+
					'				<input type="number" id="prod_quantidade" name="prod_quantidade[]" class="form-control number-spinner prod_quantidade" value="1" min="1" max="'+json_dados.estoque+'" required>'+
					'				<button type="button" class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="qv_plus"><em class="icon ni ni-plus"></em></button>'+
					'			</div>'+ 
					'		</div>'+
					'	</td>'+
					'	<td class="text-center">'+
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
				if(qtdLinhasProdutos == 1) {
					$('#recebeProdutosVenda').html(HTML_Produto_Novo);
				} else {
					$('#recebeProdutosVenda').append(HTML_Produto_Novo);
				}
				
				// FECHA MODAL
				$('#modalConsultaProdutos').modal('toggle');

			});				
		

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_movimentacoes_list = function() {
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
					{ className: "nk-tb-col text-center" },
					{ className: "nk-tb-col text-center w-10" },
					{ className: "nk-tb-col text-wrap" },
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
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_list_movimentacoes.php",
					"data": function (d) {
						d.tipo    	= $('#DT_filtros #tipo option:selected').val();
						d.natureza  = $('#DT_filtros #natureza option:selected').val();
						d.sku    	= $('#DT_filtros #sku').val();
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

			// APAGAR MOVIMENTACAO
			$('body').on('click', 'a.btDelete', function() {

				var idMovimentacao = $(this).attr('data-id');
				var retornoResultado;
				var retornoMensagem;

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja apagar esta Movimentação?",
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
							data: 	'acao=apagarMovimentacao&idMovimentacao='+idMovimentacao+'&qv_url_path='+qv_url_path,
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

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_movimentacoes_nf = function() {
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
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_list_notas_fiscais.php",
					"data": function (d) {
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

			// DAR ENTRADA MOVIMENTACAO
			$('body').on('click', 'a.btEntradaNF', function() {

				var notaFiscal = $(this).attr('data-nf');
				var retornoResultado;
				var retornoMensagem;

				Swal.fire({
					title: qv_submodulo_nome,
					text: "Tem certeza que deseja dar entrada nesta Nota Fiscal?",
					icon: 'info',
					allowEscapeKey: false,
					allowOutsideClick: false,					
					showCancelButton: true,
					confirmButtonText: 'Sim, dar entrada!',
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
							data: 	'acao=EntradaMovimentacaoNF&notaFiscal='+notaFiscal+'&qv_url_path='+qv_url_path,
							url: '/app/controllers/franquia/estoque/ajax.php',
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

		} // INIT
	}; // RETURN
}(); // FUNCTION

