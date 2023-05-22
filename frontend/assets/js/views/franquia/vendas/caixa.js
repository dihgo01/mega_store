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
					{ className: "nk-tb-col text-center" },
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
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_caixa_list.php",
					"data": function (d) {
						d.status    = $('#status option:selected').val();
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
            
			// ENVIAR FORM - ABRIR CAIXA
			$("#formAbrirCaixa").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

                var formID = "#formAbrirCaixa";

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
									location.reload();
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Salvar');
							$(formID+" button[type='submit']").removeAttr('disabled');
							$(formID + " #saldoInicial").focus();

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

            /*** MODAL MOVIMENTACOES CAIXA | NOVA  ***/
            $('#modalMovimentacoesNova').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idCaixa = $(button).attr('data-idCaixa');

				$("#formCaixaMovimentacaoNova #idCaixa").val(idCaixa);

			});		
			
			// MOVIMENTACAO CAIXA | NOVA | NATUREZA
			$('body').on('change', '#formCaixaMovimentacaoNova #natureza', function() {

				// CAPTURA VARIAVEL
				var natureza = $('option:selected',this).val();
				if(natureza == 'Entrada') {
					$("#formCaixaMovimentacaoNova #tipo option[value='Sangria']").attr('disabled',true);
					$("#formCaixaMovimentacaoNova #tipo option[value='Suprimento']").removeAttr('disabled');
				} else {
					$("#formCaixaMovimentacaoNova #tipo option[value='Sangria']").removeAttr('disabled');
					$("#formCaixaMovimentacaoNova #tipo option[value='Suprimento']").attr('disabled',true);
				}

				$("#formCaixaMovimentacaoNova #tipo option").removeAttr('selected');
				$("#formCaixaMovimentacaoNova #tipo option:first").attr('selected',true);

				$("select.qvSelect2_noSearch").select2({
					placeholder: "Selecione uma opção...",
					allowClear: false,
					minimumResultsForSearch: Infinity
				});

			});
			
			// ENVIAR FORM - NOVA MOVIMENTACAO CAIXA
			$("#formCaixaMovimentacaoNova").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

                var formID = "#formCaixaMovimentacaoNova";

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
									table.ajax.reload();
									location.reload();
									//$('.modal').modal('hide');
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Salvar');
							$(formID+" button[type='submit']").removeAttr('disabled');
							$(formID + " #saldoInicial").focus();

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
            
            /*** MODAL MOVIMENTACOES CAIXA  ***/
            $('#modalMovimentacoesCaixa').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idCaixa = $(button).attr('data-idCaixa');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalMovimentacoesCaixa .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=caixaMovimentacoes&idCaixa='+idCaixa+'&qv_url_path='+qv_url_path,
                    url: '/app/controllers/franquia/vendas/ajax.php',
                    success: function(retorno){
                        retornoResultado = retorno.resultado;
                        retornoMensagem  = retorno.mensagem;
                        retornoConteudo  = retorno.conteudo;
                    }, // SUCCESS
                    complete: function() {
                        if(retornoResultado === true) {

                            if(retornoConteudo.RESULTADOS > 0) {

                                var movimentacoes = retornoConteudo['ITENS'];
                                var HTML_conteudo = "";
                                for(let i = 0; i < retornoConteudo['ITENS'].length; i++) { 

                                    HTML_conteudo +=
                                        '<tr class="row-vertical-align" data-idMovimentacao="'+movimentacoes[i]['id']+'">'+
                                        '	<th scope="row">'+movimentacoes[i]['id']+'</th>'+
                                        '	<td class="text-center">'+movimentacoes[i]['data_criacao']+'</td>'+
                                        '	<td class="text-center">'+movimentacoes[i]['usuario']+'</td>'+
                                        '	<td class="text-center">'+movimentacoes[i]['natureza']+'</td>'+ 
                                        '	<td class="text-center">'+movimentacoes[i]['tipo']+'</td>'+                  
                                        '	<td class="text-center">R$ '+parseFloat(movimentacoes[i]['valor']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</td>'+
                                        '	<td class="text-center">'+
                                        '		<a href="javascript:void(0);" class="btn btn-danger removerMovimentacao '+(movimentacoes[i]['status'] == "Aberto" ? "":"d-none")+'" data-idCaixa="'+movimentacoes[i]['idCaixa']+'" data-idMovimentacao="'+movimentacoes[i]['id']+'">'+
                                        '			<em class="icon ni ni-delete-fill"></em>'+
                                        '		</a>'+
                                        '	</td>'+
                                        '</tr>'; 
                                }    
                                
                            } else {

                                var HTML_conteudo =
                                '<tr class="row-vertical-align">'+
                                '	<td class="text-center" colspan="7">Nenhum Registro Encontrado</td>'+
                                '</tr>';                                 

                            }

							// PREENCHE O HTML
                            $("#recebeMovimentacoesCaixa").html(HTML_conteudo);

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
			
			// APAGAR MOVIMENTACAO CAIXA
			$('body').on('click', 'a.removerMovimentacao', function() {

				var idCaixa = $(this).attr('data-idCaixa');
				var idMovimentacao = $(this).attr('data-idMovimentacao');
				var retornoResultado;
				var retornoMensagem;

				Swal.fire({
					title: "Vendas - Caixa",
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
					toastr["success"]("Enviando sua Solicitação", "Vendas - Caixa");

					if(result.value) {

						// REQUISICAO AJAX
						$.ajax({
							type: 'POST',
							dataType : "json",
							data: 	'acao=caixaMovimentacoesApagar&idCaixa='+idCaixa+'&idMovimentacao='+idMovimentacao+'&qv_url_path='+qv_url_path,
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
										//table.ajax.reload();
										//location.reload();
										//$('.modal').modal('hide');

										$("#recebeMovimentacoesCaixa tr[data-idMovimentacao="+idMovimentacao+"]").remove();

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

							}

						});						

					} else {
						Swal.fire("Vendas - Caixa", 'Operação foi Cancelada.', 'info');
					}

					// REMOVE TOASTR
					toastr.clear();	

				});

			});
			
            /*** MODAL CAIXA | FECHAMENTO  ***/
            $('#modalCaixaFechamento').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var idCaixa = $(button).attr('data-idCaixa');

                // VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
                var retornoConteudo;

				// MOSTRA BARRA PROGRESSO
				$("#modalCaixaFechamento .modal-body").append(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                // REQUISICAO AJAX
                $.ajax({
                    type: 'POST',
                    dataType : "json",
                    data: 	'acao=caixaFechamento&idCaixa='+idCaixa+'&qv_url_path='+qv_url_path,
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
								'<div class="row mb-0 cardIndicadores">'+
								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">'+retornoConteudo['data_abertura']+'</h5>'+
								'				<h5 class="card-title display-11">Data Abertura</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['saldoInicial']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Saldo Inicial</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['suprimentos']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Suprimentos</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['sangrias']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Sangrias</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['vendas']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Vendas</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'	<div class="col-md-2 col-6 text-center mb-2 p-1">'+
								'		<div class="card">'+
								'			<div class="card-body p-2">'+
								'				<h5 class="display-11 fw-normal">R$ '+parseFloat(retornoConteudo['total']).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+'</h5>'+
								'				<h5 class="card-title display-11">Total</h5>'+
								'			</div>'+
								'		</div> <!-- CARD -->'+
								'	</div> <!-- COL -->'+

								'</div> <!-- ROW --> <hr class="mt-0" />';

							// PREENCHE O HTML
                            $("#modalCaixaFechamento #recebeIndicadores").html(HTML_conteudo);

							// ID CAIXA NO INPUT HIDDEN 
							$("#formFecharCaixa #idCaixa").val(idCaixa);

							// SALDO FINAL
							$("#formFecharCaixa #saldoFinal").val(retornoConteudo['total']);

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
			
			// ENVIAR FORM - FECHAR CAIXA
			$("#formFecharCaixa").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

                var formID = "#formFecharCaixa";

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
									//table.ajax.reload();
									location.reload();
									//$('.modal').modal('hide');
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Fechar Caixa');
							$(formID+" button[type='submit']").removeAttr('disabled');
							$(formID+" #saldoInicial").focus();

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
