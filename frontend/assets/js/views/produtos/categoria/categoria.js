// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Produtos';
var qv_modulo_slug = 'produtos';
var qv_submodulo_nome = 'Categorias';
var qv_submodulo_slug = 'categorias';

$('body').on('click', '.submit_register', function () {
	$.ajax({
		url: 'http://localhost:8000/product-category',
		type: 'POST',
		dataType: "JSON",
		data: {
			'name': $(".input_name").val(),
			'tax_id': $("#tax_id").val(),
		},
		success: function (retorno) {
			console.log(retorno);
		}, // SUCCESS
		complete: function () {

			Swal.fire({
				title: 'Tudo OK',
				text: retornoMensagem,
				icon: 'success',
				allowEscapeKey: false,
				allowOutsideClick: false,
				showCancelButton: false,
				confirmButtonText: 'Continuar'
			}).then(function (result) {

				location.reload();
			});
		}

	});
});


var qv_update = function () {
	return {
		init: function (formID) {

			// ENVIAR FORM - PRODUTOS
			$(formID).submit(function (e) {

				// IMPEDE REFRESH PAGINA
				e.preventDefault();

				var destino = '/app/models/' + qv_modulo_slug + '/' + qv_submodulo_slug + '/' + qv_submodulo_slug + '.php';

				// VALIDANDO FORM
				if ($(formID)[0].checkValidity()) {

					$(formID + " button[type='submit']").html(
						'<div class="spinner-border text-light" role="status">' +
						'<span class="sr-only">Carregando...</span>' +
						'</div>');
					$(formID + " button[type='submit']").attr('disabled', 'disabled');

					enviarForm(formID, destino, function (retorno) {

						if (retorno.resultado === true) {

							// REMOVER BT SUBMIT
							$(formID + " button[type='submit']").remove();

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
								if (result.value) {
									// REDIRECT
									window.location = sessionStorage.getItem("dominio") + '/' + qv_modulo_slug + '/' + qv_submodulo_slug + '/list';
								}
							});

						} else {

							$(formID + " button[type='submit']").html('Salvar Alterações');
							$(formID + " button[type='submit']").removeAttr('disabled');
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
