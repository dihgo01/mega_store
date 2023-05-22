// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Minha Conta';
var qv_modulo_slug = 'minha-conta';
var qv_submodulo_nome = 'Segurança';
var qv_submodulo_slug = 'seguranca';
var qv_url_path = window.location.pathname;

var qv_update = function() {
	return {
		init: function() {

			// ENVIAR FORM - CONFIGS QV EM CASA
			$('form.formSenha').submit(function(e) {

				//var formID = $(this).closest('form')[0];
				var formID = $(this);

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				// AJAX FILE TARGET
				var destino = '/app/controllers/minha-conta/ajax.php';

				// VALIDANDO FORM
				if($(formID)[0].checkValidity()) {

					$("button[type='submit']",formID).html(
						'<div class="spinner-border text-light" role="status">'+
						'<span class="sr-only">Carregando...</span>'+
						'</div>');
					$("button[type='submit']",formID).attr('disabled','disabled');

					enviarForm(formID,destino, function(retorno) {

						if(retorno.resultado === true) {

							// REMOVER BT SUBMIT
							$("button[type='submit']",formID).remove();

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

							$("button[type='submit']",formID).html('Salvar');
							$("button[type='submit']",formID).removeAttr('disabled');
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