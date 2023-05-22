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
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_vendedores_list.php",
					"data": function (d) {
						//d.status    = $('#status option:selected').val();
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
            
			// ENVIAR FORM - CADASTRAR VENDEDOR
			$("#formCadastrarVendedor").submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

                var formID = "#formCadastrarVendedor";

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
									//location.reload();
                                    resetForm("#formCadastrarVendedor");
									$('.modal').modal('hide');
									$(formID+" button[type='submit']").html('Salvar');
									$(formID+" button[type='submit']").removeAttr('disabled');
								}
							});

						} else {

							$(formID+" button[type='submit']").html('Salvar');
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

            /*** MODAL VENDEDOR  ***/
            $('#modalCadastrarNovoVendedor').on('show.bs.modal', function (event) {

				// LENDO DADOS DO EVENTO
                var button = $(event.relatedTarget); // Button that triggered the modal
				var modalAcao = $(button).attr('data-acao');

                if(modalAcao == 'editar') {

                    $('#modalCadastrarNovoVendedor .modal-title').html('Editar Vendedor');

                    var idVendedor = $(button).attr('data-idVendedor');

                    // VARIAVEIS
                    var retornoResultado;
                    var retornoMensagem;
                    var retornoConteudo;

                    // MOSTRA BARRA PROGRESSO
                    $("#modalCadastrarNovoVendedor .modal-body").append(
                        '<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');

                    // REQUISICAO AJAX
                    $.ajax({
                        type: 'POST',
                        dataType : "json",
                        data: 	'acao=vendedorConsulta&idVendedor='+idVendedor+'&qv_url_path='+qv_url_path,
                        url: '/app/controllers/franquia/vendas/ajax.php',
                        success: function(retorno){
                            retornoResultado = retorno.resultado;
                            retornoMensagem  = retorno.mensagem;
                            retornoConteudo  = retorno.conteudo;
                        }, // SUCCESS
                        complete: function() {
                            if(retornoResultado === true) {

                                $("#formCadastrarVendedor #nome").val(retornoConteudo.nome);
                                $("#formCadastrarVendedor #nomeExibicao").val(retornoConteudo.nomeExibicao);
                                $("#formCadastrarVendedor #status option").removeAttr('selected');
                                $("#formCadastrarVendedor #status option[value='"+retornoConteudo.status+"']").attr('selected',"selected");

                                $("select.qvSelect2_noSearch").select2({
                                    placeholder: "Selecione uma opção...",
                                    allowClear: false,
                                    minimumResultsForSearch: Infinity
                                });

                                $("#formCadastrarVendedor #idVendedor").val(idVendedor);
                                $("#formCadastrarVendedor #formAcao").val("atualizarVendedor");

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


                } else {
                    $('#modalCadastrarNovoVendedor .modal-title').html('Salvar');
                    $("#formCadastrarVendedor #formAcao").val("cadastrarVendedor");
                }

			});	

		} // INIT
	}; // RETURN
}(); // FUNCTION
