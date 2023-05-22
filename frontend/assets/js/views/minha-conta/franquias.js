// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Minha Conta';
var qv_modulo_slug = 'minha-conta';
var qv_submodulo_nome = 'Franquias';
var qv_submodulo_slug = 'franquias';
var qv_url_path = window.location.pathname;

var qvemcasa = function() {
	return {
		init: function() {

			// ENVIAR FORM - CONFIGS QV EM CASA
			$('form.formQVEmCasa').submit(function(e) {

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

var qvFiscal = function() {
	return {
		init: function() {

			// FUNCAO CARREGA DADOS FISCAIS
			function qvFiscal_Load() {

				// VARIAVEIS
				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;				

				// CARREGA O TOASTR
				toastr.options =  Toastr_default_options;
				toastr["success"]("Buscando Dados Fiscais", qv_modulo_nome + " / " + qv_submodulo_nome);	
				
				// AJAX FILE TARGET
				var destino = '/app/controllers/minha-conta/ajax.php';				

				// REQUISICAO AJAX
				$.ajax({
					type: 'POST',
					dataType : "json",
					data: 	'formAcao=dadosFiscaisList&qv_url_path='+qv_url_path,
					url: destino,
					success: function(retorno){
						retornoResultado = retorno.resultado;
						retornoMensagem  = retorno.mensagem;
						retornoConteudo  = retorno.conteudo.itens;
					}, // SUCCESS
					complete: function() {
						if(retornoResultado === true) {

							// TRANSFORMA EM OBJETO
							var lista_franquias = retornoConteudo;
							// PERCORRE OBJETO
							lista_franquias.forEach(function(value,index) {

								var cardFranquia = $("div.cardFranquias[data-idUnidade='"+value.unidade_id+"']");

								$(".formFiscal .regime_tributario option, .formFiscal .icms_situacao_tributaria option, .formFiscal .icms_modalidade_base option",cardFranquia).removeAttr("selected");

								$(".formFiscal .regime_tributario option[value='"+value.regime_tributario+"']",cardFranquia).attr("selected",true).trigger('change.select2');

								$(".formFiscal .icms_situacao_tributaria option[value='"+value.icms_situacao_tributaria+"']",cardFranquia).attr("selected",true).trigger('change.select2');

								var icms_aliquota = new Number(value.icms_aliquota);
								icms_aliquota = icms_aliquota.toLocaleString('pt-BR', {maximumFractionDigits: 2, minimumFractionDigits: 2});
								$(".formFiscal .icms_aliquota",cardFranquia).val(icms_aliquota);

								$(".formFiscal .icms_modalidade_base_calculo option[value='"+value.icms_modalidade_base_calculo+"']",cardFranquia).attr("selected",true).trigger('change.select2');

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

			// CONSULTA DADOS FISCAIS DAS UNIDADES DO USUARIO
			qvFiscal_Load();

			// ENVIAR FORM - CONFIGS DADOS FISCAIS
			$('form.formFiscal').submit(function(e) {

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