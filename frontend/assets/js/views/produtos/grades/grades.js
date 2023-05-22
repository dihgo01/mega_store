// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Produtos';
var qv_modulo_slug = 'produtos';
var qv_submodulo_nome = 'Grades';
var qv_submodulo_slug = 'grades';


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
					{ className: "nk-tb-col text-center nk-tb-col-tools" }
				],
				"createdRow": function( row, data, dataIndex ) {
					$(row).addClass('nk-tb-item');
				},
				"order": [[ 0, "asc" ]],
				"responsive": false,
				"processing": true,
				"serverSide": true,
				"stateSave": false,
				"ajax": {
					"url": "/app/models/"+qv_modulo_slug+"/"+qv_submodulo_slug+"/DT_list.php",
					"data": function (d) {
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

			// DEFININDO NOVOS FILTROS
			$('body').on('keyup', '#DT_buscador', function (e) {
				table.search($(this).val()).draw();
			});

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

		} // INIT
	}; // RETURN
}(); // FUNCTION

var qv_create = function() {
	return {
		init: function(formID) {

			// ENVIAR FORM - PRODUTOS
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

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

var qv_update = function() {
	return {
		init: function(formID) {

			// ENVIAR FORM - PRODUTOS
			$(formID).submit(function(e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

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

							$(formID+" button[type='submit']").html('Salvar Alterações');
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

					}, 'POST'); // FUNCTION
				}

			}); // FORM SUBMIT

		} // INIT
	}; // RETURN
}(); // FUNCTION
