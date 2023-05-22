// ATUALIZA TOTAL SHOPCART
function atualizarTotalShopCart() {
    
    // VARIAVEIS
    var shopCart_SubTotalCarrinho = 0;
    var shopCart_TotalCarrinho = 0;
    var descontoTipo = $("#shopCart_RecebeItens").attr('data-desconto-tipo');
    var desconto     = $("#shopCart_RecebeItens").attr('data-desconto');
    var descontoPercentual = 0;    

    // PERCORRE ITENS
    $("#shopCart_RecebeItens li").each(function() {
        var currentValue = $(this).attr("data-valor");
        shopCart_SubTotalCarrinho = parseFloat(shopCart_SubTotalCarrinho) + parseFloat(currentValue);
    });
    $("#shopCart_SubTotalPedido").html(shopCart_SubTotalCarrinho.toFixed(2));

    // DESCONTOS
    if(descontoTipo == 'Valor') {
        shopCart_TotalCarrinho = parseFloat(shopCart_SubTotalCarrinho) - parseFloat(desconto);
    } else if(descontoTipo == 'Porcentagem') {
        descontoPercentual = (parseFloat(desconto)/100) * parseFloat(shopCart_SubTotalCarrinho);
        shopCart_TotalCarrinho = parseFloat(shopCart_SubTotalCarrinho) - parseFloat(descontoPercentual);
        desconto = parseFloat(descontoPercentual).toFixed(2);
    } else {
        shopCart_TotalCarrinho = shopCart_SubTotalCarrinho;
    }

    // APLICA TOTAL, SUBTOTAL e DESCONTO
    $("#shopCart_SubTotalPedido").html(shopCart_SubTotalCarrinho.toFixed(2));
    $("#shopCart_TotalPedido").html(shopCart_TotalCarrinho.toFixed(2));
    $("#shopCart_TotalPedido").attr('data-valor',shopCart_TotalCarrinho.toFixed(2));
    $("#shopCart_Descontos").html(desconto);

    // VALIDA EXIBICAO DO BOTAO DE CHECKOUT
    if(shopCart_SubTotalCarrinho > 0) {
        $("#btCheckout").removeClass('d-none');
    } else {
        $("#btCheckout").addClass('d-none');
    }

}

// ATUALIZA TOTAL SHOPCART
function atualizarLinhasFormaPagamento() {

    // CHECA PAGINA ATUAL
    var paginaAtual = window.location.pathname;
    var paginaCheckout = '/franquia/vendas/checkout';
    var paginaEditar = '/franquia/vendas/update';
    var valorPrimeiraLinha = $("#recebeFormasPagamento .linhaFormaPagamento[data-linha=1] .C_valor").maskMoney('unmasked')[0];
    var valorShopCart = $("#shopCart_TotalPedido").attr('data-valor');
    var parcelas = $("#recebeFormasPagamento .linhaFormaPagamento[data-linha=1] .C_parcelas").val();
    var valorParcelas = (parseFloat(valorShopCart) / parseInt(parcelas)).toFixed(2);
    var linhasQTDAtual = contarElementos("#recebeFormasPagamento .linhaFormaPagamento");

    // CHECA SE A PAGINA ATUAL É VALIDA PARA TAL ACAO E SE A PRIMEIRA LINHA DE PAGAMENTO ESTA VAZIA
    if( (paginaAtual.toLowerCase().includes(paginaCheckout.toLowerCase()) || paginaAtual.toLowerCase().includes(paginaEditar.toLowerCase())) && (parseInt(linhasQTDAtual) == 1) ) {

        $("#recebeFormasPagamento .linhaFormaPagamento[data-linha=1] .C_valor").val(parseFloat(valorShopCart).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $("#recebeFormasPagamento .linhaFormaPagamento[data-linha=1] .recebeValorParcela").html("(R$ "+parseFloat(valorParcelas).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+")");

    }

}

// VALIDACAO DO PREENCHIMENTO MANUAL DE VALORES DAS FORMAS PAGAMENTO
function alertaFormasPagamento() {

    // VARIAVEIS IMPORTANTES
    var paginaAtual         = window.location.pathname;
    var paginaCheckout      = '/franquia/vendas/checkout';
    var paginaEditar        = '/franquia/vendas/update';
    var valorDesconto       = $("#totalDesconto").val();
    var diferencaCentavos   = parseInt(5);

    // CHECA SE A PAGINA ATUAL É VALIDA PARA TAL ACAO E SE A PRIMEIRA LINHA DE PAGAMENTO ESTA VAZIA
    if((paginaAtual.toLowerCase().includes(paginaCheckout.toLowerCase()))) {
        var valorShopCart = $("#shopCart_TotalPedido").attr('data-valor').toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    } else{
        var valorShopCart = $("#totalLiquido").val().toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
    var valorTotalFormasPagamento = 0;
    var valorTotalProdutos = 0;

    // PERCORRE LINHAS DE PAGAMENTO COLETANDO VALORES
    $(".linhaFormaPagamento").each(function() {
        var currentElement 	        = $(this);
        var currentValue  	        = $(".C_valor",currentElement).maskMoney('unmasked')[0];
        valorTotalFormasPagamento   = parseFloat(valorTotalFormasPagamento) + parseFloat(currentValue);
    });	

    // PAGINA EDICAO DA VENDA
    if((paginaAtual.toLowerCase().includes(paginaEditar.toLowerCase()))) {

        // PERCORRE LINHAS DE DE PRODUTOS COLETANDO VALORES
        $(".linhaProdutos").each(function() {
            var currentElement 	= $(this);
            var currentValue  	= $(".prodPreco",currentElement).val();
            var currentQTD  	= $(".prodQTD",currentElement).val();
            valorTotalProdutos  = parseFloat(valorTotalProdutos) + (parseFloat(currentValue) * parseInt(currentQTD));
        });	  

        // CONSIDERA DESCONTO
        var valorTotalProdutos_Descontado = parseFloat(valorTotalProdutos) - parseFloat(valorDesconto);
        
        // ATUALIZA TOTALIZADORES
        $("#totalBruto").val(valorTotalProdutos);
        $("#totalLiquido").val(valorTotalProdutos_Descontado);
        
        // ATUALIZA INDICADORES
        $("#recebeTotalLiquido").html("R$ " + parseFloat(valorTotalProdutos_Descontado).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $("#recebeTotalBruto").html("R$ " + parseFloat(valorTotalProdutos).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));  
        
        // CHECAGEM
        if(valorShopCart != valorTotalFormasPagamento || valorTotalProdutos != valorTotalFormasPagamento) {

            // ORDENANDO VALORES DO MAIOR PARA MENOR PARA SUBSTRACAO
            var lista_A = [parseFloat(valorShopCart), parseFloat(valorTotalFormasPagamento)];
            var lista_B = [parseFloat(valorTotalProdutos), parseFloat(valorTotalFormasPagamento)];
            lista_A.sort(function(a, b) { return b - a; });  
            lista_B.sort(function(a, b) { return b - a; }); 
            var diferenca_lista_A = parseFloat((lista_A[0] - lista_A[1]));
            var diferenca_lista_B = parseFloat((lista_B[0] - lista_B[1]));

            // CHECANDO SE DIFERENCA ESTA DENTRO DO ACEITAVEL
            if( (diferenca_lista_A <= diferencaCentavos) || (diferenca_lista_B <= diferencaCentavos) ) {
                $("#alertaFormasPagamento").addClass('d-none');
                return true;                
            } else {
                $("#alertaFormasPagamento").removeClass('d-none');
                return false;
            }

        } else {
            $("#alertaFormasPagamento").addClass('d-none');
            return true;
        }        

    } else {

        /*console.log("Valor Total ShopCart: " + valorShopCart);
        console.log("Formas de Pagamento: " + valorTotalFormasPagamento.toFixed(2)); 
        console.log("Total Produtos: " + valorTotalProdutos);  
        console.log("Desconto: " + valorDesconto);*/   

        // CHECAGEM
        if(valorShopCart != valorTotalFormasPagamento) {
            $("#alertaFormasPagamento").removeClass('d-none');
            return false;
        } else {
            $("#alertaFormasPagamento").addClass('d-none');
            return true;
        }        
        
    }

}

// VERIFICANDO SHOPCART
function carregarShopCart() {

    var retornoResultado;
    var retornoMensagem;
    var retornoConteudo;

    // BARRA PROGRESSO
    var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 py-2 text-center">'+
    '<div class="spinner-border text-dark" role="status">'+
    '<span class="sr-only">Carregando...</span>'+
    '</div></div></div>';

    // BARRA PROGRESSO - APLICA
    $("#shopCart_RecebeItens").html(barraProgresso);

    // REQUISICAO AJAX
    $.ajax({
        type: 'POST',
        dataType : "json",
        data: 	'acao=consulta-shopcart&qv_url_path='+qv_url_path,
        url: '/app/controllers/franquia/vendas/ajax.php',
        success: function(retorno){
            retornoResultado = retorno.resultado;
            retornoMensagem  = retorno.mensagem;
            retornoConteudo  = retorno.conteudo;
        }, // SUCCESS
        complete: function() {
            if(retornoResultado === true) {

                if(retornoConteudo['RESULTADOS'] == 0) {
                    $("#shopCart_RecebeItens").html('<li class="list-group-item d-flex justify-content-between align-items-center" data-valor="0">Carrinho Vazio.</li>');
                } else {

                    // DESCONTOS
                    $("#shopCart_RecebeItens").attr('data-desconto-tipo',retornoConteudo['DESCONTO_TIPO']);
                    $("#shopCart_RecebeItens").attr('data-desconto',retornoConteudo['DESCONTO']);

                    // MONTANDO HTML
                    var conteudo_html = "";
                    for(let i = 0; i < retornoConteudo['ITENS'].length; i++) {

                        // SALDO LIMITE
                        var SaldoDisponivel = retornoConteudo['ITENS'][i]['ESTOQUE']['ITENS'][0]['SALDO']

                        // POPULANDO HTML
                        conteudo_html += 
                            '<li class="list-group-item" data-valor="'+retornoConteudo['ITENS'][i]['PRECO']+'" data-item="'+retornoConteudo['ITENS'][i]['ID_ITEM']+'">'+
                            '   <div class="row p-0 align-items-center">'+
                            '       <div class="col-2 p-0 mb-1">'+
                            '	        <img class="icon me-1 img-fluid rounded-circle" src="'+retornoConteudo['ITENS'][i]['FOTO']+'" alt="Quinta Valentina">'+
                            '       </div> <!-- COL -->'+
                            '       <div class="col-8 px-1 py-0 mb-1">'+
                            '	        <p class="fs-12px mb-0">'+retornoConteudo['ITENS'][i]['NOME']+'</p>'+                           
                            '       </div> <!-- COL -->'+
                            '       <div class="col-2 p-0 mb-1">'+
                            '           <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger btRemoverItem" onclick="removerItemCarrinho('+retornoConteudo['ITENS'][i]['ID_ITEM']+'); return false;"><i class="fas fa-trash"></i></a>'+                  
                            '       </div> <!-- COL -->'+

                            '       <div class="col-5">'+
                            '            <h5 class="display-11 text-center">Quantidade</h5>'+
                            '            <div class="form-control-wrap number-spinner-wrap">'+
                            '                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus-qv" onclick="alterarQuantidade(\'minus\','+retornoConteudo['ITENS'][i]['ID_ITEM']+');"><em class="icon ni ni-minus"></em></button>'+
                            '                <input type="number" class="form-control number-spinner" value="'+retornoConteudo['ITENS'][i]['QUANTIDADE']+'" min="1" max="'+SaldoDisponivel+'">'+
                            '                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus-qv" onclick="alterarQuantidade(\'plus\','+retornoConteudo['ITENS'][i]['ID_ITEM']+');"><em class="icon ni ni-plus"></em></button>'+
                            '            </div>'+
                            '       </div> <!-- COL -->'+

                            '       <div class="col-3">'+
                            '            <h5 class="display-11 text-center">Grade</h5>'+
                            '            <div class="form-control-wrap">'+
                            '                <input type="number" class="form-control" value="'+retornoConteudo['ITENS'][i]['TAMANHO']+'" readonly>'+
                            '            </div>'+
                            '       </div> <!-- COL -->'+
                            
                            '       <div class="col-4">'+
                            '            <h5 class="display-11 text-center">Preço</h5>'+
                            '            <div class="form-control-wrap">'+
                            '                <input type="text" class="form-control" value="R$ '+retornoConteudo['ITENS'][i]['PRECO']+'" readonly>'+
                            '            </div>'+
                            '       </div> <!-- COL -->'+

                            '   </div> <!-- ROW -->'+
                            '</li>';

                    } // FOR

                    // HTML DE PRODUTOS
                    $("#shopCart_RecebeItens").html(conteudo_html);

                }

                // ATUALIZA TOTAL SHOPCART
                atualizarTotalShopCart();
                
                // ATUALIZA LINHAS DA FORMA DE PAGAMENTO
                atualizarLinhasFormaPagamento();

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

};

// REMOVER ITEM DO CARRINHO
function removerItemCarrinho(idItem) {

    var retornoResultado;
    var retornoMensagem;

    // BARRA PROGRESSO
    var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 py-2 text-center">'+
    '<div class="spinner-border text-dark" role="status">'+
    '<span class="sr-only">Carregando...</span>'+
    '</div></div></div>';

    // BARRA PROGRESSO - APLICA
    $("#shopCart_RecebeItens").html(barraProgresso);

    // REQUISICAO AJAX
    $.ajax({
        type: 'POST',
        dataType : "json",
        data: 	'acao=remover-item-shopcart&P_idItem='+idItem+'&qv_url_path='+qv_url_path,
        url: '/app/controllers/franquia/vendas/ajax.php',
        success: function(retorno){
            retornoResultado = retorno.resultado;
            retornoMensagem  = retorno.mensagem;
        }, // SUCCESS
        complete: function() {
            if(retornoResultado === true) {

                // RECARREGA SHOPCART
                carregarShopCart();

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

};

// ESVAZIAR CARRINHO
function esvaziarCarrinho() {

    var retornoResultado;
    var retornoMensagem;

    // BARRA PROGRESSO
    var barraProgresso = '<div class="row" id="barraProgresso"><div class="col-12 py-2 text-center">'+
    '<div class="spinner-border text-dark" role="status">'+
    '<span class="sr-only">Carregando...</span>'+
    '</div></div></div>';

    // BARRA PROGRESSO - APLICA
    $("#shopCart_RecebeItens").html(barraProgresso);

    // REQUISICAO AJAX
    $.ajax({
        type: 'POST',
        dataType : "json",
        data: 	'acao=esvaziar-shopcart&qv_url_path='+qv_url_path,
        url: '/app/controllers/franquia/vendas/ajax.php',
        success: function(retorno){
            retornoResultado = retorno.resultado;
            retornoMensagem  = retorno.mensagem;
        }, // SUCCESS
        complete: function() {
            if(retornoResultado === true) {

                // APLICA HTML
                $("#shopCart_RecebeItens").html('<li class="list-group-item d-flex justify-content-between align-items-center" data-valor="0">Carrinho Vazio.</li>');

                // ATUALIZA TOTAL SHOPCART
                atualizarTotalShopCart();

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

};

// ALTERAR QTD DO ITEM PELO CARRINHO
function alterarQuantidade(operacao,idItem) {

    // VARIAVEIS
    var produto             = $("#shopCart_RecebeItens li[data-item="+idItem+"]");
    var produtoValorAtual   = $("input.number-spinner",produto).val();
    var produtoQTDMin       = $("input.number-spinner",produto).attr('min');
    var produtoQTDMax       = $("input.number-spinner",produto).attr('max');
    var produtoStep         = 1;
    var checkFinal          = false;

    var retornoResultado;
    var retornoMensagem;    

    // OPERACAO DE INCREMENTO
    if(operacao == 'plus') {
        var produtoNovoValor = parseInt(produtoValorAtual) + parseInt(produtoStep);
    } else {
        var produtoNovoValor = parseInt(produtoValorAtual) - parseInt(produtoStep);
    }

    // VALIDACAO DA OPERACAO
    if(parseInt(produtoNovoValor) <=  parseInt(produtoQTDMax) && parseInt(produtoNovoValor) >=  parseInt(produtoQTDMin)) { checkFinal = true; }

    // CONFERINDO O VALIDADOR
    if(checkFinal) {

        // REQUISICAO AJAX
        $.ajax({
            type: 'POST',
            dataType : "json",
            data: 	'acao=alterar-quantidade-item-shopcart&P_idItem='+idItem+'&nova_quantidade='+produtoNovoValor+'&qv_url_path='+qv_url_path,
            url: '/app/controllers/franquia/vendas/ajax.php',
            success: function(retorno){
                retornoResultado = retorno.resultado;
                retornoMensagem  = retorno.mensagem;
            }, // SUCCESS
            complete: function() {
                if(retornoResultado === true) {

                    // RECARREGA SHOPCART
                    carregarShopCart();

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

    }				

};

// ADD ITEM POR BIPE SKU
function sku_bipe(sku) {

    var retornoResultado;
    var retornoMensagem;

    // TOASTR - MENSAGEM INFORMATIVA                
    toastr.options =  Toastr_default_options;
    
    // CARREGA O TOASTR
    toastr["success"]("Consultando SKU", "Carrinho de Compras");	    

    // REQUISICAO AJAX
    $.ajax({
        type: 'POST',
        dataType : "json",
        data: 	'acao=sku_bipe&sku='+sku+'&qv_url_path='+qv_url_path,
        url: '/app/controllers/franquia/vendas/ajax.php',
        success: function(retorno){
            retornoResultado = retorno.resultado;
            retornoMensagem  = retorno.mensagem;
        }, // SUCCESS
        complete: function() {
            if(retornoResultado === false) {

                // ALERT
                swal.fire({
                    title: "Oops...",
                    allowEscapeKey: false,
                    allowOutsideClick: false,                    
                    text: retornoMensagem,
                    icon: "warning"
                });  
                
                $("#sku_bipe").val('').focus();

            } else {
                // RECARREGA SHOPCART
                carregarShopCart();
                $("#sku_bipe").val('').focus();                
            } 

            // REMOVE TOASTR
            toastr.clear();	            

        }

    });						

};
