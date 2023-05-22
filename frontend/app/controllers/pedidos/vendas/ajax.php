<?php 
ini_set('max_execution_time', 1000);
set_time_limit(1000);

// INCLUDE FUNCTIONS
include $_SERVER['DOCUMENT_ROOT']."/inc/functions.php";
include $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";

// CAPTURA REQUESTS
$acao = checarAcao($_SERVER['REQUEST_METHOD']);

// TRATANDO URL
$capturaURL = explode('/', $_POST['qv_url_path']);

// TRATANDO URL
$capturaURL = explode('/', $_POST['qv_url_path']);
url_friendly($capturaURL, $_POST['qv_url_path']);

$QV_Unidade = $_SESSION['Authentication']['franquias'][$_SESSION['Authentication']['franquiaActive']]['unidade'];

//***************************** FIND MODEL
$model = carregarMVC($_QV['URL'],'models');
if(file_exists($model)) {

    // INCLUDE MODEL
    include $model;      

    /******************************************************************************/
    /*************************** CONSULTA ESTOQUE *********************************/
    /******************************************************************************/
    if($acao == 'consulta-estoque') {

        // Instância Class | idUnidade + POST dos Filtros
        $classe = new QV_Estoque($QV_Unidade,$_POST);

        // Chama Funcao de Consulta de Estoque
        $resultadoFinal = $classe->consulta();

    }

    /******************************************************************************/
    /*************************** CONSULTA SHOPCART ********************************/
    /******************************************************************************/
    if($acao == 'consulta-shopcart') {

        // Instância Class | idUnidade
        $classe = new QV_ShopCart($QV_Unidade);

        // Chama Funcao de Consulta de Carrinho
        $resultadoFinal = $classe->consulta();

    }

    /******************************************************************************/
    /************************* ADD PRODUTO SHOPCART *******************************/
    /******************************************************************************/
    if($acao == 'adicionar-produto') {

        // Instância Class | idUnidade
        $classe = new QV_ShopCart($QV_Unidade,$_POST);

        // Chama Funcao de Consulta de Carrinho
        $resultadoFinal = $classe->addCarrinho();

    }

    /******************************************************************************/
    /*********************** REMOVE ITEM DO CARRINHO ******************************/
    /******************************************************************************/
    if($acao == 'remover-item-shopcart') {

        // Instância Class | idUnidade
        $classe = new QV_ShopCart($QV_Unidade,$_POST);

        // Chama Funcao de Esvaziar Carrinho
        $resultadoFinal = $classe->removerItemCarrinho();

    }

    /******************************************************************************/
    /*************** ALTERA QUANTIDADE DO ITEM NO CARRINHO ************************/
    /******************************************************************************/
    if($acao == 'alterar-quantidade-item-shopcart') {

        // Instância Class
        $classe = new QV_ShopCart($QV_Unidade,$_POST);

        // Chama Metodo
        $resultadoFinal = $classe->alterarQTDItemCarrinho();

    }    

    /******************************************************************************/
    /**************************** ESVAZIAR CARRINHO *******************************/
    /******************************************************************************/
    if($acao == 'esvaziar-shopcart') {

        // Instância Class | idUnidade
        $classe = new QV_ShopCart($QV_Unidade);

        // Chama Funcao de Esvaziar Carrinho
        $resultadoFinal = $classe->esvaziarCarrinho();

    }

    /******************************************************************************/
    /****************** ADD PRODUTO SHOPCART POR BIPE SKU *************************/
    /******************************************************************************/
    if($acao == 'sku_bipe') {

        // Instância Class
        $classe = new QV_ShopCart($QV_Unidade,$_POST);

        // Chama Metodo
        $resultadoFinal = $classe->sku_bipe();

    }    

    /******************************************************************************/
    /***************************** CONSULTAR CPF **********************************/
    /******************************************************************************/
    if($acao == 'consultar-cpf') {

        // Instância Class | idUnidade
        $classe = new QV_Clientes($QV_Unidade,$_POST);

        // Chama Funcao de Consulta Dados Cliente
        $resultadoFinal = $classe->consulta();

    }

    /******************************************************************************/
    /************************** BUSCADOR CLIENTES *********************************/
    /******************************************************************************/
    if($acao == 'buscador_clientes') {

        // Instância Class | idUnidade
        $classe = new QV_Checkout($QV_Unidade,$_POST);

        // Chama Metodo de Busca de Clientes
        $resultadoFinal = $classe->buscadorClientes();

    }

    /******************************************************************************/
    /**************************** APLICAR DESCONTO ********************************/
    /******************************************************************************/
    if($acao == 'aplicar-desconto') {

        // Instância Class | idUnidade
        $classe = new QV_ShopCart($QV_Unidade,$_POST);

        // Chama Funcao de Aplicar Desconto
        $resultadoFinal = $classe->aplicarDesconto();

    } 
    
    /******************************************************************************/
    /******************************* ENVIAR VENDA *********************************/
    /******************************************************************************/
    if($acao == 'enviarVenda') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->create();

    }   
    
    /******************************************************************************/
    /******************************* EDITAR VENDA *********************************/
    /******************************************************************************/
    if($acao == 'updateVenda') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->update();

    }       

    /******************************************************************************/
    /***************** EMITIR DOCUMENTO FISCAL - NFe / NFCe ***********************/
    /******************************************************************************/
    if($acao == 'emissaoFiscal') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->documentoFiscal();

    }

    /******************************************************************************/
    /**************** RE-EMITIR DOCUMENTO FISCAL - NFe / NFCe *********************/
    /******************************************************************************/
    if($acao == 'ReemissaoFiscal') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->documentoFiscal_Reemitir();

    }  
    
    /******************************************************************************/
    /************************ CANCELAR DOCUMENTO FISCAL ***************************/
    /******************************************************************************/
    if($acao == 'cancelarDocumentoFiscal') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->documentoFiscal_Cancelar();

    }

    /******************************************************************************/
    /************************ DOCUMENTO FISCAL | VISUALIZAR ***********************/
    /******************************************************************************/
    if($acao == 'vendasDocumentoFiscal_View') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->documentoFiscal_View();

    }     
    
    /******************************************************************************/
    /********************** DOCUMENTO FISCAL | EXPORTAR XML ***********************/
    /******************************************************************************/
    if($acao == 'documentoFiscal_ExportarXML') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->documentoFiscal_ExportarXML();

    }         

    /******************************************************************************/
    /******************************* CANCELAR VENDA *******************************/
    /******************************************************************************/
    if($acao == 'cancelarVenda') {

        // Instância Class
        $classe = new QV_Vendas($_POST);

        // Chama 
        $resultadoFinal = $classe->cancelarVenda();

    }      

    /******************************************************************************/
    /********************* BUSCA PRODUTOS PARA ADD NA VENDA ***********************/
    /******************************************************************************/
    if($acao == 'buscador_produtos') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->buscador_produtos();

    }    
    
    /******************************************************************************/
    /******************************* ABRIR CAIXA **********************************/
    /******************************************************************************/
    if($acao == 'abrirCaixa') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaAbrir();

    }   
    
    /******************************************************************************/
    /************************* MOVIMENTACOES DO CAIXA *****************************/
    /******************************************************************************/
    if($acao == 'caixaMovimentacoes') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaMovimentacoes();

    }   
    
    /******************************************************************************/
    /********************* MOVIMENTACOES DO CAIXA | NOVA  *************************/
    /******************************************************************************/
    if($acao == 'caixaMovimentacaoNova') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaMovimentacoesNova();

    }           

    /******************************************************************************/
    /**************************** CAIXA | FECHAMENTO  *****************************/
    /******************************************************************************/
    if($acao == 'caixaFechamento') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaFechamento_Consulta();

    } 

    /******************************************************************************/
    /************************ CAIXA | FECHAR FINALIZAR  ***************************/
    /******************************************************************************/
    if($acao == 'caixaFechar') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaFechar();

    } 


    /******************************************************************************/
    /******************* MOVIMENTACOES DO CAIXA | APAGAR  *************************/
    /******************************************************************************/
    if($acao == 'caixaMovimentacoesApagar') {

        // Instância Class
        $classe = new QV_Caixa($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->caixaMovimentacoesApagar();

    }  
    
    /******************************************************************************/
    /******************* VENDAS | RELATORIO EXCEL | GERAR  ************************/
    /******************************************************************************/
    if($acao == 'relatorioVendas') {

        // Instância Class
        $classe = new QV_Reports($QV_Unidade,$_POST);

        // Chama 
        $resultadoFinal = $classe->relatorioExcel();

    }  
    
    /******************************************************************************/
    /*************** ESTOQUE | CONSULTA PRODUTOS | VER GRADE  *********************/
    /******************************************************************************/
    if($acao == 'visualizarGrade') {

        // Instância Class
        $classe = new QV_Estoque($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->visualizarGrade();

    }  
    
    /******************************************************************************/
    /************ ESTOQUE | CONSULTA PRODUTOS | ACERTO ESTOQUE  *******************/
    /******************************************************************************/
    if($acao == 'movimentacaoProduto') {

        // Instância Class
        $classe = new QV_Estoque($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->acertoEstoque();

    }  
    
    /******************************************************************************/
    /******* ESTOQUE | CONSULTA PRODUTOS | ACERTO ESTOQUE EM MASSA ****************/
    /******************************************************************************/
    if($acao == 'movimentacaoProdutoMassa') {

        // Instância Class
        $classe = new QV_Estoque($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->acertoEstoqueMassa();

    }      
    
    /******************************************************************************/
    /***************** BUSCA PRODUTOS PARA ADD NA MOVIMENTACAO ********************/
    /******************************************************************************/
    if($acao == 'estoque_buscador_produtos') {

        // Instância Class
        $classe = new QV_Estoque($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->buscador_produtos();

    }  
    
    /******************************************************************************/
    /**************************** APAGAR MOVIMENTACAO *****************************/
    /******************************************************************************/
    if($acao == 'apagarMovimentacao') {

        // Instância Class
        $classe = new QV_Estoque($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->apagarMovimentacao();

    }      

    /******************************************************************************/
    /******************* CADASTRAR CLIENTE | CREATE  *************************/
    /******************************************************************************/
    if($acao == 'cadastrarCliente') {

        // Instância Class
        $classe = new QV_Clientes($_POST);

        // Chama 
        $resultadoFinal = $classe->cadastroCliente();

    }

    /******************************************************************************/
    /******************* DELETAR CLIENTE | DELET  *************************/
    /******************************************************************************/
    if($acao == 'deletarCliente') {

        // Instância Class
        $classe = new QV_Clientes($_POST);

        // Chama 
        $resultadoFinal = $classe->deletaCliente();

    }

    /******************************************************************************/
    /********************** ATUALIZAR CLIENTE | UPDATE  ***************************/
    /******************************************************************************/
    if($acao == 'atualizarCliente') {

        // Instância Class
        $classe = new QV_Clientes($_POST);

        // Chama 
        $resultadoFinal = $classe->atualizaCliente();

    }

    /******************************************************************************/
    /********************* VENDAS | VENDEDORES | CREATE  **************************/
    /******************************************************************************/
    if($acao == 'cadastrarVendedor') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->vendedoresCreate();

    }  
    
    /******************************************************************************/
    /********************* VENDAS | VENDEDORES | UPDATE  **************************/
    /******************************************************************************/
    if($acao == 'atualizarVendedor') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->vendedoresUpdate();

    }    
    
    /******************************************************************************/
    /********************* VENDAS | VENDEDORES | SELECT  **************************/
    /******************************************************************************/
    if($acao == 'vendedorConsulta') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->vendedoresSelect();

    }  
    
    /******************************************************************************/
    /**************** VENDAS | VENDEDORES | LISTA VENDEDORES  *********************/
    /******************************************************************************/
    if($acao == 'buscarVendedores') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama 
        $resultadoFinal = $classe->vendedoresList();

    }  
    
    /******************************************************************************/
    /************************* DESEMPENHO VENDEDORES ******************************/
    /******************************************************************************/
    if($acao == 'vendedorDesempenho') {

        // Instância Class
        $classe = new QV_Reports($QV_Unidade,$_POST);

        // Chama Metodo
        $resultadoFinal = $classe->vendedorDesempenho();

    }  
    
    /******************************************************************************/
    /**************************** HISTORICO DA VENDA ******************************/
    /******************************************************************************/
    if($acao == 'vendasHistorico') {

        // Instância Class
        $classe = new QV_Vendas($_POST,$QV_Unidade);

        // Chama Metodo
        $resultadoFinal = $classe->vendasHistorico();

    }      

    echo json_encode($resultadoFinal);

} else {
    return false;
}



?>