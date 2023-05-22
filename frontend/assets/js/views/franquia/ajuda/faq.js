// VARIAVEIS AUXILIARES
var qv_modulo_nome = 'Franquia';
var qv_modulo_slug = 'franquia';
var qv_submodulo_nome = 'Ajuda';
var qv_submodulo_slug = 'ajuda';
var qv_url_path = window.location.pathname;

var qv_list = function() {
	return {
		init: function() {
			
			// CARREGAR FAQ DA CATEGORIA
			$('body').on('click', 'a.carregarFAQ', function() {

				var idCategoria = $(this).attr('data-categoria');
				var retornoResultado;
				var retornoMensagem;
				var retornoConteudo;	
				
				// MOSTRA BARRA PROGRESSO
				$("#tabAccordion").html(
					'<div class="row text-center barraProgresso"><div class="col-12"><div class="spinner-border text-dark" role="status"><span class="sr-only">Carregando...</span></div></div></div>');				
			
				// REQUISICAO AJAX
				$.ajax({
					type: 'POST',
					dataType : "json",
					data: 	'acao=faqCategoria&idCategoria='+idCategoria+'&qv_url_path='+qv_url_path,
					url: '/app/controllers/'+qv_modulo_slug+'/'+qv_submodulo_slug+'/ajax.php',
					success: function(retorno){
						retornoResultado = retorno.resultado;
						retornoMensagem  = retorno.mensagem;
						retornoConteudo  = retorno.conteudo;
					}, // SUCCESS
					complete: function() {
						if(retornoResultado === true) {

							if(retornoConteudo.RESULTADOS > 0) {
								var faq = retornoConteudo.ITENS;
								var HTML_conteudo = '<div id="faqs" class="accordion">';
								for(let i = 0; i < retornoConteudo.ITENS.length; i++) {
									HTML_conteudo += 
										'<div class="accordion-item">'+
										'	<a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#faq-q'+faq[i]['id']+'">'+
										'		<h6 class="title">'+faq[i]['pergunta']+'</h6>'+
										'		<span class="accordion-icon"></span>'+
										'	</a>'+
										'	<div class="accordion-body collapse" id="faq-q'+faq[i]['id']+'" data-bs-parent="#faqs">'+
										'		<div class="accordion-inner">'+faq[i]['resposta']+'</div>'+
										'	</div>'+
										'</div><!-- .accordion-item -->';
								}  
								HTML_conteudo += '</div>'; 
							}

							// PREENCHE O HTML
							$("#tabAccordion").html(HTML_conteudo);							
										

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
