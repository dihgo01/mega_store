<?php  

// PHP MAILER
use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception as Exception;
/******************************************************************************/
/****************************** PRODUTOS **************************************/
/******************************************************************************/
class QV_Produtos {

    function __construct($slug = false){
        $this->slug = $slug;
    }     

    //***** CONSULTA DE CATEGORIAS
    public function categorias() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // LIMITAR CATEGORIAS
        $CAT_NOT_SHOW = array(13,14,24,25,26,28,29);

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "SELECT * FROM qv_categorias WHERE id NOT IN(".implode(',',$CAT_NOT_SHOW).") AND deleted_at IS NULL ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {
            $resConteudo['ITENS'][] = array('ID' => $resultado['id'], 'NOME' => $resultado['nome']);
        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;        

    }

    //***** CONSULTA DE DADOS DO PRODUTO
    public function consulta() {

        // VARIAVEIS
        $slug = $this->slug;
        
        $url = "http://localhost:8000/product-categorys";

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODQ3MzgwMzcsImlhdCI6MTY4NDcyODAzNywiaWQiOiJjMWE0MWYwNzllMGQzN2U4MjgyOGEyYmE2YzdjNTUwMSJ9.yZaWKMTHQW7pARbD0598FI324sAEQs4rjLrM45FwBgg';

        // CURL - START
        ponto_CURL_START:
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $resposta = json_decode($body, true);
        //var_dump($body);
        $array = array();
        foreach($resposta as $item) {
            //var_dump($item);
            $array['ITENS'] = [
                "id" => $item['id'],
                "category" => $item['category'],
                "tax" => $item['tax'],
            ];  
        }
        //var_dump($array);
        
        $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resposta);
              

        // RETORNO
        return $resultadoFinal;        

    }    
    
}


/******************************************************************************/
/******************************* SHOPCART *************************************/
/******************************************************************************/
class QV_ShopCart {

    function __construct($idUnidade,$campos = false){
        $this->idUnidade    = $idUnidade;
        if($campos) {
            $this->idItem           = (isset($campos['P_idItem']) ? $campos['P_idItem'] : false);
            $this->idProduto        = (isset($campos['P_idProduto']) ? $campos['P_idProduto'] : false);
            $this->grade            = (isset($campos['P_grade']) ? $campos['P_grade'] : false);
            $this->quantidade       = (isset($campos['P_quantidade']) ? $campos['P_quantidade'] : false);
            $this->preco            = (isset($campos['P_preco']) ? $campos['P_preco'] : false);
            $this->desconto         = (isset($campos['P_desconto']) ? $campos['P_desconto'] : false);
            $this->descontoTipo     = (isset($campos['P_descontoTipo']) ? $campos['P_descontoTipo'] : false);
            $this->sku              = (isset($campos['sku']) ? $campos['sku'] : false);
            $this->nova_quantidade  = (isset($campos['nova_quantidade']) ? $campos['nova_quantidade'] : false);
        }
    }       

    //***** CONSULTA ITENS DO CARRINHO
    public function consulta() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_idUnidade = $this->idUnidade;
        $QV_idUsuario = $_SESSION['Authentication']['id_usuario'];        

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();        

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // ARMAZENA DADOS BASICOS PARA ATUALIZAR O PEDIDO
        $dadosPedido = ['DESCONTO' => '', 'DESCONTO_TIPO' => '', 'PRECO_BRUTO' => 0, 'PRECO_LIQUIDO' => 0];

        // CONSULTA PRODUTOS DO PEDIDO ABERTO
        $consulta = mysqli_query($conexao, "SELECT PP.idItem AS ID_ITEM, PP.idProduto AS ID_PRODUTO, PP.tamanho AS TAMANHO, PP.preco AS PRECO, PP.sku AS SKU, PP.quantidade AS QUANTIDADE, P.descontoTipo AS TIPO_DESCONTO, P.desconto AS DESCONTO 
                                FROM PDV_pedidosProdutos PP
                                INNER JOIN PDV_pedidos P ON P.idPedido = PP.idPedido
                                WHERE PP.idPedido = '".$idPedido."' AND PP.status = 'Ativo' AND PP.dataDelete IS NULL");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);   
        if(mysqli_num_rows($consulta) > 0) {
            WHILE($resultado = mysqli_fetch_array($consulta)) {

                // CAPTURANDO DADOS BASICO DO PEDIDO
                $dadosPedido['DESCONTO'] = $resultado['DESCONTO'];
                $dadosPedido['DESCONTO_TIPO'] = $resultado['TIPO_DESCONTO'];
                $dadosPedido['PRECO_BRUTO'] += ($resultado['PRECO'] * $resultado['QUANTIDADE']);

                // ARMAZENANDO DADOS
                $resConteudo['DESCONTO']        = $resultado['DESCONTO'];
                $resConteudo['DESCONTO_TIPO']   = $resultado['TIPO_DESCONTO'];

                // CONSULTA DADOS DO PRODUTO
                $prodInfo = qvProdutosInfo_Intranet($resultado['ID_PRODUTO']);

                // GRADE DO PRODUTO
                if($QV_idUnidade == 573) {
                    $produto_grade = intranetEstoqueGrade($resultado['ID_PRODUTO'],$resultado['TAMANHO']);
                } else {
                    $produto_grade = vitrineEstoqueGrade($resultado['ID_PRODUTO'],$QV_idUnidade,$resultado['TAMANHO']);
                }                  

                // ARRAY
                $resConteudo['ITENS'][] = array(
                    'ID'            => $resultado['ID_PRODUTO'], 
                    'ID_ITEM'       => $resultado['ID_ITEM'], 
                    'NOME'          => $prodInfo['NOME'],
                    'SLUG'          => $prodInfo['SLUG'],
                    'TAMANHO'       => $resultado['TAMANHO'],
                    'QUANTIDADE'    => $resultado['QUANTIDADE'],
                    'ESTOQUE'       => $produto_grade,
                    'PRECO'         => ($resultado['PRECO'] * $resultado['QUANTIDADE']),
                    'FOTO'          => $prodInfo['FOTO']
                );
            }
        }
 
        // VALIDACAO FINAL                 
        if($consulta) {

            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);

            if(mysqli_num_rows($consulta) > 0) {

                // CHECANDO DESCONTO
                if($dadosPedido['DESCONTO_TIPO'] == 'Valor') {
                    $dadosPedido['PRECO_LIQUIDO'] = $dadosPedido['PRECO_BRUTO'] - $dadosPedido['DESCONTO'];
                } elseif($dadosPedido['DESCONTO_TIPO'] == 'Porcentagem') {
                    $dadosPedido['PRECO_LIQUIDO'] = $dadosPedido['PRECO_BRUTO'] - (($dadosPedido['DESCONTO']/100) * $dadosPedido['PRECO_BRUTO']);
                } else {
                    $dadosPedido['PRECO_LIQUIDO'] = $dadosPedido['PRECO_BRUTO'];
                }

                // ATUALIZANDO DADOS BASICOS DO PEDIDO
                $atualizarPedido = mysqli_query($conexao, "UPDATE PDV_pedidos SET descontoTipo = '".$dadosPedido['DESCONTO_TIPO']."', desconto = '".$dadosPedido['DESCONTO']."', precoBruto = '".$dadosPedido['PRECO_BRUTO']."', precoLiquido = '".$dadosPedido['PRECO_LIQUIDO']."' WHERE idPedido = '".$idPedido."' ");

            }

        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }

    //***** ADD PRODUTOS AO CARRINHO
    public function addCarrinho() {

        // BANCO DADOS 
        $conexao = bancoDados("conectar","intranet");

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // GERANDO SKU
        $sku = geradorSKU($this->idProduto,$this->grade);

        // SQL INSERT - PRODUTO AO CARRINHO
        $adicionar = mysqli_query($conexao, "INSERT INTO PDV_pedidosProdutos (idPedido, idProduto, sku, tamanho, preco, quantidade, dataInsert) VALUES ('".$idPedido."', '".$this->idProduto."', '".$sku."', '".$this->grade."', '".$this->preco."', '".$this->quantidade."', NOW())");        
        
        // VALIDACAO FINAL                 
        if($adicionar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Produto Adicionado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Adicionar Produto. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    } 
    
    //***** REMOVER ITEM DO CARRINHO
    public function removerItemCarrinho() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // SQL DELETE - REMOVE PRODUTOS DO CARRINHO
        $deletar = mysqli_query($conexao, "DELETE FROM PDV_pedidosProdutos WHERE idItem = '".$this->idItem."' "); 
        
        // VALIDACAO FINAL                 
        if($deletar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Item Removido com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Remover Item. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    } 

    //***** ALTERA QTD ITEM DO CARRINHO
    public function alterarQTDItemCarrinho() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $QV_idItem = $this->idItem;
        $QV_quantidade = $this->nova_quantidade;

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // SQL UPDATE - ALTERA QUANTIDADE DO ITEM
        $atualizar = mysqli_query($conexao, "UPDATE PDV_pedidosProdutos SET quantidade = '".$QV_quantidade."' WHERE idItem = '".$QV_idItem."' AND idPedido = '".$idPedido."' "); 
        
        // VALIDACAO FINAL                 
        if($atualizar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Item Atualizado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Atualizar Item. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }     
    
    //***** ESVAZIAR CARRINHO
    public function esvaziarCarrinho() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // SQL DELETE - REMOVE PRODUTOS DO CARRINHO
        $deletar = mysqli_query($conexao, "DELETE FROM PDV_pedidosProdutos WHERE idPedido = '".$idPedido."' ");        
        
        // VALIDACAO FINAL                 
        if($deletar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Carrinho Esvaziado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Esvaziar Carrinho. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }  

    //***** ADD PRODUTOS AO CARRINHO POR BIPE SKU
    public function sku_bipe() {

        // BANCO DADOS 
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_sku = $this->sku;  
        $QV_idUnidade = $this->idUnidade;  
        $checkFinal = false;  
        $mensagemErro = "";  

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // CONSULTA SKU PARA DESCOBRIR ID PRODUTO E GRADE
        $consultaSKU = mysqli_query($conexao,"SELECT PG.produto_id AS PRODUTO_ID, G.codigo AS GRADE, P.preco_sellout AS PRECO 
        FROM qv_produtos_grades PG 
        INNER JOIN qv_grades G ON G.id = PG.grade_id
        INNER JOIN qv_produtos P ON P.id = PG.produto_id
        WHERE PG.codigo = '".$QV_sku."' ");
        if(mysqli_num_rows($consultaSKU) > 0) {

            $resSKU = mysqli_fetch_array($consultaSKU);

            // CHECANDO QUANTIDADE JA INSERIDA
            $consultaQTDCarrinho = mysqli_query($conexao, "SELECT COALESCE(SUM(PP.quantidade),0) AS TOTAL 
            FROM PDV_pedidosProdutos PP
            WHERE PP.idPedido = '".$idPedido."' AND PP.sku = '".$QV_sku."' AND PP.status = 'Ativo' ");
            $resCarrinho = mysqli_fetch_array($consultaQTDCarrinho);
    
            // CHECANDO ESTOQUE
            $consultaEstoque = mysqli_query($conexao, "SELECT COALESCE(SUM(quantidade),0) AS TOTAL 
            FROM PDV_estoque
            WHERE idProduto = '".$resSKU['PRODUTO_ID']."' AND tamanho = '".$resSKU['GRADE']."' AND status = 'Ativo' AND idUnidade = '".$QV_idUnidade."' ");
            $resEstoque = mysqli_fetch_array($consultaEstoque); 
            
            if($consultaQTDCarrinho && $consultaEstoque) {

                if(($resEstoque['TOTAL'] - $resCarrinho['TOTAL']) > 0) {
    
                    // SQL INSERT - PRODUTO AO CARRINHO
                    $adicionar = mysqli_query($conexao, "INSERT INTO PDV_pedidosProdutos (idPedido, idProduto, sku, tamanho, preco, quantidade, dataInsert) VALUES ('".$idPedido."', '".$resSKU['PRODUTO_ID']."', '".$QV_sku."', '".$resSKU['GRADE']."', '".$resSKU['PRECO']."', '1', NOW())");
                    
                    if($adicionar) {
                        $checkFinal = true;
                    } else {
                        $mensagemErro = "Problema ao Adicionar Produto ao Carrinho. Contate o Suporte.";
                    }
        
                } else {
                    $mensagemErro = "Não Há Saldo para este Produto.";
                }              
    
            } else {
                $mensagemErro = "Problema ao Consultar este SKU. Contate o Suporte.";
            }            

        } else {
            $mensagemErro = "SKU Inválido.";
        }
        
        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Produto Adicionado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    }     
    
    //***** APLICAR DESCONTO
    public function aplicarDesconto() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // PEGA ID DO PEDIDO
        $idPedido = consultaPedido();

        // SQL UPDATE - APLICA DESCONTO
        $atualizar = mysqli_query($conexao, "UPDATE PDV_pedidos SET descontoTipo = '".$this->descontoTipo."', desconto = '".$this->desconto."' WHERE idPedido = '".$idPedido."' ");        
        
        // VALIDACAO FINAL                 
        if($atualizar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Desconto Aplicado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Aplicar Desconto. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }      
    
}

/******************************************************************************/
/******************************* CHECKOUT *************************************/
/******************************************************************************/
class QV_Checkout {

    function __construct($idUnidade,$campos = false){
        $this->idUnidade = $idUnidade;
        if($campos) {
            $this->termo = (isset($campos['termo']) ? $campos['termo'] : false);
            //$this->cpf = (isset($campos['C_cpf']) ? $campos['C_cpf'] : false);
        }
    }       

    //***** CONSULTA PEDIDO
    public function consulta() {         

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_idUnidade   = $this->idUnidade; 
        $QV_checkFinal  = false;  
        $QV_mensagemErro = "";

        // PEGA ID DO PEDIDO
        $QV_idPedido = consultaPedido();        

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "SELECT P.idPedido AS ID_PEDIDO, P.descontoTipo AS DESCONTO_TIPO, P.desconto AS DESCONTO, C.idCliente AS ID_CLIENTE, C.nome AS NOME, C.nascimento AS NASCIMENTO, C.sexo AS SEXO, C.cpf AS CPF, C.telefone01 AS TELEFONE, C.email AS EMAIL, C.tamanho AS TAMANHO, P.observacoes AS OBSERVACOES 
                                FROM PDV_pedidos P
                                LEFT JOIN PDV_clientes C ON C.idCliente = P.idCliente
                                WHERE P.idPedido = '".$QV_idPedido."' AND P.idUnidade = ".$QV_idUnidade." AND P.status = 'Ativo' AND P.dataDelete IS NULL");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);   
        if(mysqli_num_rows($consulta) > 0) {
            
            $resultado = mysqli_fetch_array($consulta);
                
            // ARRAY
            $resConteudo['ITENS'] = array(
                'ID_CLIENTE'      => $resultado['ID_CLIENTE'], 
                'NOME'            => $resultado['NOME'], 
                'NASCIMENTO'      => (empty($resultado['NASCIMENTO']) ? false : converterData($resultado['NASCIMENTO'],'BR')),
                'SEXO'            => $resultado['SEXO'],
                'CPF'             => $resultado['CPF'],
                'TELEFONE'        => $resultado['TELEFONE'],
                'EMAIL'           => $resultado['EMAIL'],
                'TAMANHO'         => $resultado['TAMANHO'],
                'ID_PEDIDO'       => $resultado['ID_PEDIDO'],
                'DESCONTO_TIPO'   => $resultado['DESCONTO_TIPO'],
                'DESCONTO'        => $resultado['DESCONTO'],
                'OBSERVACOES'     => $resultado['OBSERVACOES']
            );

            $QV_checkFinal = true;

            // SQL SELECT - DADOS PAGAMENTO
            /*$consultaDadosPagamento = mysqli_query($conexao, "SELECT P.idPedido AS ID_PEDIDO, FP.idFormaPagamento AS ID_FORMA_PAGAMENTO, FP.tipo AS METODO_PAGAMENTO, FP.condicao AS FORMA_PAGAMENTO, FP.parcelas AS PARCELAS, FP.vencimento AS VENCIMENTO, FP.valor AS VALOR  
                                    FROM PDV_pedidosFormasPagamento FP
                                    INNER JOIN PDV_pedidos P ON P.idPedido = FP.idPedido
                                    WHERE FP.idPedido = '".$QV_idPedido."' AND FP.status = 'Ativo'  AND FP.dataDelete IS NULL");
            if(mysqli_num_rows($consultaDadosPagamento) > 0) {

                WHILE($resDP = mysqli_fetch_array($consultaDadosPagamento)) {
                    
                    // ARRAY
                    $resConteudo['FINANCEIRO'][] = array(
                        'ID_FORMA_PAGAMENTO'    => $resDP['ID_FORMA_PAGAMENTO'], 
                        'ID_PEDIDO'             => $resDP['ID_PEDIDO'], 
                        'METODO_PAGAMENTO'      => $resDP['METODO_PAGAMENTO'], 
                        'FORMA_PAGAMENTO'       => $resDP['FORMA_PAGAMENTO'], 
                        'PARCELAS'              => $resDP['PARCELAS'], 
                        'VENCIMENTO'            => converterData($resDP['VENCIMENTO'],'BR'),
                        'VALOR_PARCELAS'        => numeroDecimal(($resDP['VALOR'] / $resDP['PARCELAS']),2),
                        'VALOR_TOTAL'           => $resDP['VALOR']
                    );

                }

                $QV_checkFinal = true;

            } else {
                $QV_mensagemErro = "Erro ao buscar as dados de pagamento. Crie um novo pedido e avise o suporte sobre o erro.";
            }*/
            
        } else {
            $QV_mensagemErro = "O pedido não foi encontrado. Crie um novo pedido.";
        }     
            
        // VALIDACAO FINAL                 
        if($QV_checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $QV_mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    } 

    //***** BUSCADOR CLIENTES
    public function buscadorClientes() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $QV_idUnidade   = $this->idUnidade;
        $QV_termo       = $this->termo;

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "
            SELECT C.idCliente AS ID_CLIENTE, C.nome AS NOME, C.nascimento AS NASCIMENTO, C.cpf AS CPF, C.sexo AS SEXO, C.telefone01 AS TELEFONE, C.email AS EMAIL, C.tamanho AS TAMANHO
            FROM PDV_clientes C
            WHERE (C.nome LIKE '%".$QV_termo."%' OR C.cpf LIKE '%".limpar($QV_termo)."%') AND C.idUnidade = ".$QV_idUnidade." AND C.dataDelete IS NULL ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {         

            // MONTANDO ARRAY DE RESULTADOS
            $resConteudo['ITENS'][] = array('id'            => $resultado['ID_CLIENTE'], 
                                            'nome'          => $resultado['NOME'],
                                            'email'         => $resultado['EMAIL'],
                                            'telefone'      => limpar($resultado['TELEFONE']),
                                            'nascimento'    => converterData($resultado['NASCIMENTO'],"BR"),
                                            'cpf'           => limpar($resultado['CPF']),
                                            'sexo'          => $resultado['SEXO'],
                                            'tamanho'       => $resultado['TAMANHO']
                                        );

        }

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!', 'erro'=>$erro);
        }

        // RETORNO
        return $resultadoFinal;        

    }     
    
}

/******************************************************************************/
/****************** VENDAS | CREATE / UPDATE / REPORTS ************************/
/******************************************************************************/
class QV_Vendas { 

    function __construct($campos,$idUnidade = false){
        if($campos) {
            $this->campos = (isset($campos) ? $campos : false);
        }
        if($idUnidade || $idUnidade == 0) {
            $this->idUnidade = (isset($idUnidade) ? $idUnidade : false);
        } 
        
        $this->FP_Status_Concluido = array('Cartão Crédito','Dinheiro','Pix','Cartão Débito');
    }    

    //***** CRIA A VENDA
    public function create() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos                 = $this->campos; 
        $FP_Status_Concluido    = $this->FP_Status_Concluido;
        $QV_idUsuario           = $_SESSION['Authentication']['id_usuario'];
        $QV_checkCliente        = false;
        $QV_checkDadosPagamento = false;
        $QV_checkProdutos       = false;
        $QV_checkVenda          = false;  
        $QV_mensagemErro        = "";
        $resProdutos_MSG_ERRO   = "";
        $dadosPagamento_MSG_ERRO= "";

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL SELECT - DADOS BASICOS DO PEDIDO
        $consultaPedido = mysqli_query($conexao, "SELECT * FROM PDV_pedidos WHERE idPedido = '".$campos['idPedido']."' ");
        $resPedido = mysqli_fetch_array($consultaPedido);

        //********** CLIENTE
        if($campos['idCliente'] == 'consumidor') {

            // SQL SELECT - BUSCA CLIENTE CONSUMIDOR
            $consultaCliente = mysqli_query($conexao, "SELECT * FROM PDV_clientes WHERE email = 'consumidor@qv.shoes' AND idUnidade = '".$resPedido['idUnidade']."' AND dataDelete IS NULL ");
            if(mysqli_num_rows($consultaCliente) > 0) {
                $resCliente = mysqli_fetch_array($consultaCliente);
                $campos['idCliente'] = $resCliente['idCliente'];
                $QV_checkCliente = true;
            } else {

                // SQL INSERT - CADASTRA CONSUMIDOR
                $adicionarCliente = mysqli_query($conexao,"INSERT INTO PDV_clientes (idUnidade, nome, sexo, email, allowDelete, dataInsert) VALUES ('".$resPedido['idUnidade']."', 'Consumidor', 'Feminino', 'consumidor@qv.shoes', 0, NOW())"); 
                            
                // DEFINE NOVO ID DO PEDIDO
                if($adicionarCliente) {
                    $campos['idCliente'] = mysqli_insert_id($conexao);
                    $QV_checkCliente = true;
                } else {
                    $QV_mensagemErro .= "Erro ao Cadastrar Consumidor. | ";
                }                

            }

        } elseif(empty($campos['idCliente'])) {

            // SQL SELECT - BUSCA CLIENTE COM DADOS BASICOS
            $consultaCliente = mysqli_query($conexao, "SELECT * FROM PDV_clientes WHERE (cpf = '".limpar($campos['C_cpf'])."' AND cpf != '' AND cpf != '00000000000') AND idUnidade = '".$resPedido['idUnidade']."' LIMIT 1 ");
            if(mysqli_num_rows($consultaCliente) > 0) {
                $resCliente = mysqli_fetch_array($consultaCliente);
                $campos['idCliente'] = $resCliente['idCliente'];  
                $QV_checkCliente = true;
            } else {

                // SQL INSERT - CADASTRA CLIENTE
                $adicionarCliente = mysqli_query($conexao,"INSERT INTO PDV_clientes (idUnidade, nome, nascimento, cpf, sexo, telefone01, email, tamanho, dataInsert) VALUES ('".$resPedido['idUnidade']."', '".anti_injection($campos['C_nome'])."', '".(empty($campos['C_nascimento']) ? '0000-00-00' : converterData($campos['C_nascimento'],'EN'))."', '".limpar($campos['C_cpf'])."', '".(empty($campos['C_sexo']) ? 'Feminino' : $campos['C_sexo'])."', '".limpar($campos['C_telefone'])."', '".$campos['C_email']."', '".$campos['C_tamanho']."', NOW())"); 
                            
                // DEFINE NOVO ID DO PEDIDO
                if($adicionarCliente) {
                    $campos['idCliente'] = mysqli_insert_id($conexao);
                    $QV_checkCliente = true;
                } else {
                    $QV_mensagemErro .= "Erro ao Cadastrar Cliente. | ";
                }                

            }
            
        } else {

            // SQL UPDATE - ATUALIZA DADOS DO CLIENTE
            $atualizarCliente = mysqli_query($conexao,"UPDATE PDV_clientes SET nome = '".anti_injection($campos['C_nome'])."', nascimento = '".(empty($campos['C_nascimento']) ? '0000-00-00' : converterData($campos['C_nascimento'],'EN'))."', cpf = '".limpar($campos['C_cpf'])."', sexo = '".(empty($campos['C_sexo']) ? 'Feminino' : $campos['C_sexo'])."', telefone01 = '".limpar($campos['C_telefone'])."', email = '".$campos['C_email']."', tamanho = '".$campos['C_tamanho']."' WHERE idCliente = '".$campos['idCliente']."' ");

            if(!$atualizarCliente) {
                $QV_mensagemErro .= "Erro ao Atualizar Dados do Cliente. | ";
            } else {
                $QV_checkCliente = true;
            }

        }

        //********** DADOS DA VENDA
        if($QV_checkCliente) {

            // SQL INSERT - CADASTRA VENDA
            $adicionarVenda = mysqli_query($conexao,"INSERT INTO PDV_vendas (idUnidade, idCliente, idUsuario, tipoDesconto, desconto, totalBruto, totalLiquido, observacoes, status,  dataInsert) VALUES ('".$resPedido['idUnidade']."', '".$campos['idCliente']."', '".$campos['vendedor']."', '".$campos['C_descontoTipo']."', '".$campos['C_desconto']."', '".$resPedido['precoBruto']."', '".$resPedido['precoLiquido']."', '".$resPedido['observacoes']."', '".$campos['status']."', NOW())");

            if($adicionarVenda) {
                $idVenda = mysqli_insert_id($conexao);
                $QV_checkVenda = true;
            } else {
                $QV_mensagemErro = "Não foi possível cadastrar a venda. ";
            }            

            //********** PRODUTOS
            if($QV_checkVenda) {

                // SQL SELECT - PRODUTOS DO PEDIDO
                $consultaProdutos = mysqli_query($conexao, "SELECT * FROM PDV_pedidosProdutos WHERE idPedido = '".$campos['idPedido']."' AND status = 'Ativo' ");
                $resProdutos_ROWS = mysqli_num_rows($consultaProdutos);
                $contadorProdutos_ROWS = 0;
                WHILE($resProdutos = mysqli_fetch_array($consultaProdutos)) {

                    // CONSULTA DADOS DO PRODUTO
                    $conProd = mysqli_query($conexao,"SELECT id, nome, cor_id, preco_custo, preco_sellout, preco_sellin FROM qv_produtos WHERE id = '".$resProdutos['idProduto']."' ");
                    $resProd = mysqli_fetch_array($conProd);

                    // SQL INSERT - PRODUTOS DA VENDA
                    $adicionarProdutos = mysqli_query($conexao,"INSERT INTO PDV_vendasProdutos (idVenda, idProduto, sku, cor, tamanho, quantidade, preco, precoTotal, dataInsert) VALUES ('".$idVenda."', '".$resProdutos['idProduto']."', '".$resProdutos['sku']."', '".$resProd['cor_id']."', '".$resProdutos['tamanho']."', '".$resProdutos['quantidade']."', '".$resProdutos['preco']."', '".($resProdutos['preco']*$resProdutos['quantidade'])."', NOW())");  
                    
                    // MOVIMENTACAO
                    if($adicionarProdutos) {

                        // SQL INSERT - MOVIMENTACAO
                        $adicionarMovimentacao = mysqli_query($conexao, "INSERT INTO PDV_estoqueMovimentacoes (idUnidade, tipo, natureza, idProduto, descricao, cor, tamanho, quantidade, precoCusto, precoSellin, precoSellout, motivo, idVenda, sku, dataInsert) VALUES ('".$resPedido['idUnidade']."', 'Saída', 'Venda', '".$resProdutos['idProduto']."', '".$resProd['nome']."', '".$resProd['cor_id']."', '".$resProdutos['tamanho']."', '".$resProdutos['quantidade']."', '".$resProd['preco_custo']."', '".$resProd['preco_sellin']."', '".$resProd['preco_sellout']."', NULL, '".$idVenda."', '".$resProdutos['sku']."', NOW())");  

                        // ATUALIZA QUANTIDADE DO PRODUTO NO ESTOQUE
                        if($adicionarMovimentacao) {

                            // SQL UPDATE - ESTOQUE
                            $atualizarEstoque = mysqli_query($conexao,"UPDATE PDV_estoque SET quantidade = (quantidade - ".$resProdutos['quantidade'].")  WHERE idUnidade = '".$resPedido['idUnidade']."' AND idProduto = '".$resProdutos['idProduto']."' AND tamanho = '".$resProdutos['tamanho']."' AND idCor = '".$resProd['cor_id']."' ");

                            if($atualizarEstoque) {
                                $contadorProdutos_ROWS++;
                            } else {
                                $resProdutos_MSG_ERRO .= "Não foi possível atualizar o estoque do produto nesta venda | ";
                            }
                            
                        } else {
                            $resProdutos_MSG_ERRO .= "Não foi possível gerar movimentação desta venda | ";
                        }

                    } else {
                        $resProdutos_MSG_ERRO .= "Não foi possível adicionar produto na venda | ";
                    }

                }

                // CHECAGEM DOS PRODUTOS NA VENDA
                if($contadorProdutos_ROWS == $resProdutos_ROWS) {
                    $QV_checkProdutos = true;
                } else {
                    $QV_mensagemErro = "Houveram erros nas movimentações de produtos. Contate o suporte.";
                }

            }

            //********** DADOS PAGAMENTO
            if($QV_checkProdutos) {

                // PERCORRE DADOS DE PAGAMENTO
                $dadosPagamento_QTD = COUNT($campos['C_metodoPagamento']);
                for($i=0; $i < $dadosPagamento_QTD; $i++) {

                    // SQL INSERT - FORMAS PAGAMENTO
                    $adicionarDadosPagamento = mysqli_query($conexao, "INSERT INTO PDV_vendasFormasPagamento (idVenda, tipo, condicao, parcelas, dataInsert) VALUES ('".$idVenda."', '".$campos['C_metodoPagamento'][$i]."', '".$campos['C_formaPagamento'][$i]."', '".$campos['C_parcelas'][$i]."', NOW())");

                    // ID DA FORMA PAGAMENTO
                    if($adicionarDadosPagamento) {

                        $idFormaPagamento = mysqli_insert_id($conexao);

                        // CHECANDO SE EXISTE PARCELAS E PERCORRE GERANDO OS LANCAMENTOS FUTUROS 
                        if($campos['C_parcelas'][$i] == 1) {
                            $valorParcela = number_format(preg_replace('/[^0-9]/s', "", $campos['C_valor'][$i])/100,2,".","");
                        } else {
                            $valorParcela = number_format(preg_replace('/[^0-9]/s', "", $campos['C_valor'][$i])/100,2,".","");
                            $valorParcela = $valorParcela / $campos['C_parcelas'][$i];
                        }
                        $vencimentoParcela = converterData($campos['C_vencimento'][$i],'EN');
                        for($k=0; $k<$campos['C_parcelas'][$i]; $k++) {

                            // SELECT INSERT - ADICIONANDO PARCELAS
                            $adicionarParcelas = mysqli_query($conexao, "INSERT INTO PDV_vendasParcelas (idFormaPagamento, idVenda, dataVencimento, valor, dataInsert) VALUES ('".$idFormaPagamento."', '".$idVenda."', '".$vencimentoParcela."', '".$valorParcela."', NOW())");

                            // ID DA PARCELA
                            if($adicionarParcelas) {

                                if($campos['status'] == 'Concluída') {

                                    $idParcela = mysqli_insert_id($conexao); 

                                    // CHECA STATUS
                                    $data1 = $vencimentoParcela;
                                    $data2 = DATE("Y-m-d");
                                    if(in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido)) {
                                        $statusFinanceiro = 'Concluído';
                                    } elseif(!in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido) && $data1 == $data2) {
                                        $statusFinanceiro = 'Concluído';
                                    } elseif(!in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido) && $data1 != $data2) {
                                        $statusFinanceiro = 'Pendente';
                                    } else {
                                        $statusFinanceiro = 'Pendente';
                                    }
    
                                    // SQL INSERT - MOVIMENTACOES FINANCEIRAS
                                    $financeiro = mysqli_query($conexao, "INSERT INTO PDV_financeiro (idUnidade, tipo, idCategoria, idSubCategoria, descricao, valor, vencimento, status, idVenda, idParcela, dataInsert) VALUES ('".$resPedido['idUnidade']."', 'Contas a Receber', '9', '38', 'Venda Realizada | Parcela #".($k+1)."', '".$valorParcela."', '".$vencimentoParcela."', '".$statusFinanceiro."', '".$idVenda."', '".$idParcela."', NOW())");                                    

                                } else {
                                    $financeiro = true;
                                }

                            } else {
                                $dadosPagamento_MSG_ERRO .= "Erro ao registrar parcelas do metódo  de pagamento ".$campos['C_metodoPagamento'][$i]." | ";
                            }

                            // GERA PROXIMO VENCIMENTO
                            $vencimentoParcela = date('Y-m-d', strtotime($vencimentoParcela. ' + 1 months'));
                            
                        }

                        if($financeiro) {
                            $QV_checkDadosPagamento = true;
                        } else {
                            $dadosPagamento_MSG_ERRO .= "Erro ao gerar as movimentações financeiras. | ";
                        }

                    } else {
                        $dadosPagamento_MSG_ERRO .= "Erro ao gerar registro da Forma de Pagamento. | ";
                    }

                }
               
            }

        } 

        // CONCATENANDO MENSAGENS DE ERRO
        $QV_mensagemErro .= $resProdutos_MSG_ERRO.$dadosPagamento_MSG_ERRO;
            
        // VALIDACAO FINAL                 
        if($QV_checkCliente && $QV_checkDadosPagamento && $QV_checkProdutos && $QV_checkVenda) {

            // APAGANDO PEDIDO
            $apagarPedido = mysqli_query($conexao,"DELETE FROM PDV_pedidos WHERE idPedido = '".$campos['idPedido']."' ");
            $apagarPedidoFormasPagamento = mysqli_query($conexao,"DELETE FROM PDV_pedidosFormasPagamento WHERE idPedido = '".$campos['idPedido']."' ");
            $apagarPedidoProdutos = mysqli_query($conexao,"DELETE FROM PDV_pedidosProdutos WHERE idPedido = '".$campos['idPedido']."' ");

            // RETORNO COM ID DA VENDA
            $resConteudo = ['ID_VENDA' => $idVenda];

            //********** GERA LOG DA VENDA
			$logDescricao = 'Venda Criada.';
			$logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$idVenda."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
            //********** GERA LOG DA VENDA           

            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Venda Lançada com Sucesso', 'conteudo'=>$resConteudo);

        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $QV_mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    }   

    //***** ATUALIZAR VENDA
    public function update() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos                 = $this->campos; 
        $FP_Status_Concluido    = $this->FP_Status_Concluido;
        $QV_idUsuario           = $_SESSION['Authentication']['id_usuario'];
        $QV_checkCliente        = false;
        $QV_checkDadosPagamento = false;
        $QV_checkProdutos       = false;
        $QV_checkVenda          = false;  
        $QV_mensagemErro        = "";
        $resProdutos_MSG_ERRO   = "";
        $dadosPagamento_MSG_ERRO= "";

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // PREPARA LOGS
        logVendas('preparar',$campos['idVenda'],$QV_idUsuario,$campos);

        //********** CONSULTA VENDA 
        $consultaVenda = mysqli_query($conexao, "SELECT * FROM PDV_vendas WHERE idVenda = '".$campos['idVenda']."' ");
        $resVenda = mysqli_fetch_array($consultaVenda);  
        
        // SQL SELECT / UPDATE - DESFAZER MOVIMENTACOES ANTERIORES
        $consultaMovimentacoes = mysqli_query($conexao, "SELECT * FROM PDV_estoqueMovimentacoes WHERE idUnidade = '".$resVenda['idUnidade']."' AND idVenda = ".$campos['idVenda']." AND status = 'OK' ");
        WHILE($resultadoConsultaMovimentacoes = mysqli_fetch_array($consultaMovimentacoes)) {

            // SQL UPDATE - ESTOQUE
            $atualizarEstoque = mysqli_query($conexao,"UPDATE PDV_estoque SET quantidade = (quantidade + ".$resultadoConsultaMovimentacoes['quantidade'].") WHERE idUnidade = '".$resVenda['idUnidade']."' AND idProduto = '".$resultadoConsultaMovimentacoes['idProduto']."' AND tamanho = '".$resultadoConsultaMovimentacoes['tamanho']."' AND idCor = '".$resultadoConsultaMovimentacoes['cor']."' ");

            // SQL UPDATE - ANULA MOVIMENTACAO
            if($atualizarEstoque) {
                $anularMovimentacao = mysqli_query($conexao, "UPDATE PDV_estoqueMovimentacoes SET status = 'Inativo', dataDelete = NOW() WHERE idMovimentacao = ".$resultadoConsultaMovimentacoes['idMovimentacao']." ");
            }

        }  

        // SQL UPDATE - ANULAR FORMAS PAGAMENTO
        $anularFormasPagamentos = mysqli_query($conexao, "UPDATE PDV_vendasFormasPagamento SET status = 'Inativo', dataDelete = NOW() WHERE idVenda = ".$campos['idVenda']." ");

        // SQL UPDATE - ANULAR PARCELAS
        $anularParcelas = mysqli_query($conexao, "UPDATE PDV_vendasParcelas SET status = 'Inativo', dataDelete = NOW() WHERE idVenda = ".$campos['idVenda']." ");

        // SQL UPDATE - ANULAR PRODUTOS DA VENDA
        $anularProdutos = mysqli_query($conexao, "UPDATE PDV_vendasProdutos SET status = 'Inativo', dataDelete = NOW() WHERE idVenda = ".$campos['idVenda']." ");    
        
        // SQL UPDATE - INATIVA FINANCEIRO
        $updateFinanceiro = mysqli_query($conexao,"UPDATE PDV_financeiro SET status = 'Inativo', dataDelete = NOW() WHERE idVenda = '".$campos['idVenda']."' ");

        // VALIDANDO SE OS CANCELAMENTOS DERAM CERTO
        if($atualizarEstoque && $anularMovimentacao && $updateFinanceiro) {

            //********** CLIENTE
            if($campos['idCliente'] == 'consumidor') {

                // SQL SELECT - BUSCA CLIENTE CONSUMIDOR
                $consultaCliente = mysqli_query($conexao, "SELECT * FROM PDV_clientes WHERE email = 'consumidor@qv.shoes' AND idUnidade = '".$resVenda['idUnidade']."' ");
                if(mysqli_num_rows($consultaCliente) > 0) {
                    $resCliente = mysqli_fetch_array($consultaCliente);
                    $campos['idCliente'] = $resCliente['idCliente'];
                    $QV_checkCliente = true;
                } else {

                    // SQL INSERT - CADASTRA CONSUMIDOR
                    $adicionarCliente = mysqli_query($conexao,"INSERT INTO PDV_clientes (idUnidade, nome, sexo, email, allowDelete, dataInsert) VALUES ('".$resVenda['idUnidade']."', 'Consumidor', 'Feminino', 'consumidor@qv.shoes', 0, NOW())"); 
                                
                    // DEFINE NOVO ID DO PEDIDO
                    if($adicionarCliente) {
                        $campos['idCliente'] = mysqli_insert_id($conexao);
                        $QV_checkCliente = true;
                    } else {
                        $QV_mensagemErro .= "Erro ao Cadastrar Consumidor. | ";
                    }                

                }

            } elseif($campos['idCliente'] > 0) {

                // SQL UPDATE - ATUALIZA DADOS DO CLIENTE
                if($campos['C_email'] != 'consumidor@qv.shoes') {

                    $atualizarCliente = mysqli_query($conexao,"UPDATE PDV_clientes SET nome = '".$campos['C_nome']."', nascimento = '".(empty($campos['C_nascimento']) ? '0000-00-00' : converterData($campos['C_nascimento'],'EN'))."', cpf = '".limpar($campos['C_cpf'])."', sexo = '".(empty($campos['C_sexo']) ? 'Feminino' : $campos['C_sexo'])."', telefone01 = '".limpar($campos['C_telefone'])."', email = '".$campos['C_email']."', tamanho = '".$campos['C_tamanho']."' WHERE idCliente = '".$campos['idCliente']."' ");

                    if(!$atualizarCliente) {
                        $QV_mensagemErro .= "Erro ao Atualizar Dados do Cliente. | ";
                    } else {
                        $QV_checkCliente = true;
                    }                    

                } else {
                    $QV_checkCliente = true;
                }

                
            } else {

                // SQL SELECT - BUSCA CLIENTE COM DADOS BASICOS
                $consultaCliente = mysqli_query($conexao, "SELECT * FROM PDV_clientes WHERE (cpf = '".limpar($campos['C_cpf'])."' AND cpf != '' AND cpf != '00000000000') AND idUnidade = '".$resVenda['idUnidade']."' LIMIT 1 ");
                if(mysqli_num_rows($consultaCliente) > 0) {
                    $resCliente = mysqli_fetch_array($consultaCliente);
                    $campos['idCliente'] = $resCliente['idCliente'];  
                    $QV_checkCliente = true;
                } else {
                    
                    // SQL INSERT - CADASTRA CLIENTE
                    $adicionarCliente = mysqli_query($conexao,"INSERT INTO PDV_clientes (idUnidade, nome, nascimento, cpf, sexo, telefone01, email, tamanho, dataInsert) VALUES ('".$resVenda['idUnidade']."', '".$campos['C_nome']."', '".(empty($campos['C_nascimento']) ? '0000-00-00' : converterData($campos['C_nascimento'],'EN'))."', '".limpar($campos['C_cpf'])."', '".(empty($campos['C_sexo']) ? 'Feminino' : $campos['C_sexo'])."', '".limpar($campos['C_telefone'])."', '".$campos['C_email']."', '".$campos['C_tamanho']."', NOW())"); 
                                
                    // DEFINE NOVO ID DO PEDIDO
                    if($adicionarCliente) {
                        $campos['idCliente'] = mysqli_insert_id($conexao);
                        $QV_checkCliente = true;
                    } else {
                        $QV_mensagemErro .= "Erro ao Cadastrar Cliente. | ";
                    }                

                }                

            }

            //********** DADOS DA VENDA
            if($QV_checkCliente) {

                // SQL UPDATE - ATUALIZA DADOS DA VENDA
                $atualizarVenda = mysqli_query($conexao,
                    "UPDATE PDV_vendas
                    SET idCliente       = '".$campos['idCliente']."',
                        idUsuario       = '".$campos['vendedor']."',
                        tipoDesconto    = '".$campos['C_descontoTipo']."',
                        desconto        = '".$campos['C_desconto']."',
                        totalBruto      = '".$campos['totalBruto']."',
                        totalLiquido    = '".$campos['totalLiquido']."',
                        observacoes     = '".$campos['observacoes']."',
                        status          = '".$campos['status']."'
                    WHERE idVenda = '".$campos['idVenda']."'
                ");

                if($atualizarVenda) {
                    $idVenda = $campos['idVenda'];
                    $QV_checkVenda = true;
                } else {
                    $QV_mensagemErro = "Não foi possível atualizar a venda. ";
                }            

                //********** PRODUTOS
                if($QV_checkVenda) {
                    
                    // CONTAGEM LINHA PRODUTOS
                    $contagemLinhaProdutos = COUNT($campos['prodID']);
                    $contadorProdutos_ROWS = 0;

                    // PERCORRE PRODUTOS
                    for($U=0; $U<$contagemLinhaProdutos; $U++) {

                        // CONSULTA DADOS DO PRODUTO
                        $conProd = mysqli_query($conexao,"SELECT id, nome, cor_id, preco_custo, preco_sellout, preco_sellin FROM qv_produtos WHERE id = '".$campos['prodID'][$U]."' ");
                        $resProd = mysqli_fetch_array($conProd);

                        // SQL INSERT - PRODUTOS DA VENDA
                        $adicionarProdutos = mysqli_query($conexao,"INSERT INTO PDV_vendasProdutos (idVenda, idProduto, sku, cor, tamanho, quantidade, preco, precoTotal, dataInsert) VALUES ('".$idVenda."', '".$campos['prodID'][$U]."', '".$campos['prodSKU'][$U]."', '".$campos['prodCOR'][$U]."', '".$campos['prodTAMANHO'][$U]."', '".$campos['prodQTD'][$U]."', '".$campos['prodPRECO'][$U]."', '".($campos['prodPRECO'][$U]*$campos['prodQTD'][$U])."', NOW())");  
                        
                        // MOVIMENTACAO
                        if($adicionarProdutos) {

                            // SQL INSERT - MOVIMENTACAO
                            $adicionarMovimentacao = mysqli_query($conexao, "INSERT INTO PDV_estoqueMovimentacoes (idUnidade, tipo, natureza, idProduto, descricao, cor, tamanho, quantidade, precoCusto, precoSellin, precoSellout, motivo, idVenda, sku, dataInsert) VALUES ('".$resVenda['idUnidade']."', 'Saída', 'Venda', '".$campos['prodID'][$U]."', '".$resProd['nome']."', '".$resProd['cor_id']."', '".$campos['prodTAMANHO'][$U]."', '".$campos['prodQTD'][$U]."', '".$resProd['preco_custo']."', '".$resProd['preco_sellin']."', '".$campos['prodPRECO'][$U]."', NULL, '".$idVenda."', '".$campos['prodSKU'][$U]."', NOW())");  

                            // ATUALIZA QUANTIDADE DO PRODUTO NO ESTOQUE
                            if($adicionarMovimentacao) {

                                // SQL UPDATE - ESTOQUE
                                $atualizarEstoque = mysqli_query($conexao,"UPDATE PDV_estoque SET quantidade = (quantidade - ".$campos['prodQTD'][$U].")  WHERE idUnidade = '".$resVenda['idUnidade']."' AND idProduto = '".$campos['prodID'][$U]."' AND tamanho = '".$campos['prodTAMANHO'][$U]."' AND idCor = '".$resProd['cor_id']."' ");

                                if($atualizarEstoque) {
                                    $contadorProdutos_ROWS++;
                                } else {
                                    $resProdutos_MSG_ERRO .= "Não foi possível atualizar o estoque do produto nesta venda | ";
                                }
                                
                            } else {
                                $resProdutos_MSG_ERRO .= "Não foi possível gerar movimentação desta venda | ";
                            }

                        } else {
                            $resProdutos_MSG_ERRO .= "Não foi possível adicionar produto na venda | ";
                        }

                    }

                    // CHECAGEM DOS PRODUTOS NA VENDA
                    if($contadorProdutos_ROWS == $contagemLinhaProdutos) {
                        $QV_checkProdutos = true;
                    } else {
                        $QV_mensagemErro = "Houveram erros nas movimentações de produtos. Contate o suporte.";
                    } 

                }

                //********** DADOS PAGAMENTO
                if($QV_checkProdutos) {

                    // PERCORRE DADOS DE PAGAMENTO
                    $dadosPagamento_QTD = COUNT($campos['C_metodoPagamento']);
                    for($i=0; $i < $dadosPagamento_QTD; $i++) {

                        // SQL INSERT - FORMAS PAGAMENTO
                        $adicionarDadosPagamento = mysqli_query($conexao, "INSERT INTO PDV_vendasFormasPagamento (idVenda, tipo, condicao, parcelas, dataInsert) VALUES ('".$idVenda."', '".$campos['C_metodoPagamento'][$i]."', '".$campos['C_formaPagamento'][$i]."', '".$campos['C_parcelas'][$i]."', NOW())");

                        // ID DA FORMA PAGAMENTO
                        if($adicionarDadosPagamento) {

                            $idFormaPagamento = mysqli_insert_id($conexao);

                            // CHECANDO SE EXISTE PARCELAS E PERCORRE GERANDO OS LANCAMENTOS FUTUROS 
                            if($campos['C_parcelas'][$i] == 1) {
                                $valorParcela = number_format(preg_replace('/[^0-9]/s', "", $campos['C_valor'][$i])/100,2,".","");
                            } else {
                                $valorParcela = number_format(preg_replace('/[^0-9]/s', "", $campos['C_valor'][$i])/100,2,".","");
                                $valorParcela = $valorParcela / $campos['C_parcelas'][$i];
                            }

                            // CONTROLANDO VENCIMENTOS
                            $vencimentoParcela = converterData($campos['C_vencimento'][$i],'EN');

                            // PERCORRE PARCELAS
                            for($k=0; $k<$campos['C_parcelas'][$i]; $k++) {

                                // SELECT INSERT - ADICIONANDO PARCELAS
                                $adicionarParcelas = mysqli_query($conexao, "INSERT INTO PDV_vendasParcelas (idFormaPagamento, idVenda, dataVencimento, valor, dataInsert) VALUES ('".$idFormaPagamento."', '".$idVenda."', '".$vencimentoParcela."', '".$valorParcela."', NOW())");

                                // ID DA PARCELA
                                if($adicionarParcelas) {

                                    if($campos['status'] == 'Concluída') {

                                        $idParcela = mysqli_insert_id($conexao); 

                                        // CHECA STATUS
                                        $data1 = $vencimentoParcela;
                                        $data2 = DATE("Y-m-d");
                                        
                                        if(in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido)) {
                                            $statusFinanceiro = 'Concluído';
                                        } elseif(!in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido) && $data1 == $data2) {
                                            $statusFinanceiro = 'Concluído';
                                        } elseif(!in_array($campos['C_metodoPagamento'][$i],$FP_Status_Concluido) && $data1 != $data2) {
                                            $statusFinanceiro = 'Pendente';
                                        } else {
                                            $statusFinanceiro = 'Pendente';
                                        }
    
                                        // SQL INSERT - MOVIMENTACOES FINANCEIRAS
                                        $financeiro = mysqli_query($conexao, "INSERT INTO PDV_financeiro (idUnidade, tipo, idCategoria, idSubCategoria, descricao, valor, vencimento, status, idVenda, idParcela, dataInsert) VALUES ('".$resVenda['idUnidade']."', 'Contas a Receber', '9', '38', 'Venda Realizada | Parcela #".($k+1)."', '".$valorParcela."', '".$vencimentoParcela."', '".$statusFinanceiro."', '".$idVenda."', '".$idParcela."', NOW())");                                        

                                    } else {
                                        $financeiro = true;
                                    }

                                } else {
                                    $dadosPagamento_MSG_ERRO .= "Erro ao registrar parcelas do metódo  de pagamento ".$campos['C_metodoPagamento'][$i]." | ";
                                }

                                // GERA PROXIMO VENCIMENTO
                                $vencimentoParcela = date('Y-m-d', strtotime($vencimentoParcela. ' + 1 months'));
                                
                            }

                            if($financeiro) {
                                $QV_checkDadosPagamento = true;
                            } else {
                                $dadosPagamento_MSG_ERRO .= "Erro ao gerar as movimentações financeiras. | ";
                            }

                        } else {
                            $dadosPagamento_MSG_ERRO .= "Erro ao gerar registro da Forma de Pagamento. | ";
                        }

                    }
                
                }

            }             

        }

        // CONCATENANDO MENSAGENS DE ERRO
        $QV_mensagemErro .= $resProdutos_MSG_ERRO.$dadosPagamento_MSG_ERRO;
            
        // VALIDACAO FINAL                 
        if($QV_checkCliente && $QV_checkDadosPagamento && $QV_checkProdutos && $QV_checkVenda) {

            // RETORNO COM ID DA VENDA
            $resConteudo = ['ID_VENDA' => $idVenda];

            // EFETIVA LOGS
            logVendas('efetivar',$campos['idVenda']);            

            // RESULTADO
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Venda Atualizada com Sucesso', 'conteudo'=>$resConteudo);

        } else {

            // EFETIVA LOGS
            logVendas('apagar',$campos['idVenda']);  

            // RESULTADO
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $QV_mensagemErro);

        }        

        // RETORNO
        return $resultadoFinal;

    }       

    //***** CANCELAR VENDA
    public function cancelarVenda() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos         = $this->campos; 
        $QV_idUsuario   = $_SESSION['Authentication']['id_usuario'];

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        //********** CONSULTA VENDA 
        $consultaVenda = mysqli_query($conexao, "SELECT * FROM PDV_vendas WHERE idVenda = '".$campos['idVenda']."' ");
        $resVenda = mysqli_fetch_array($consultaVenda);   
        
        //********** CONSULTA FRANQUIA
        $consultaFranquia = mysqli_query($conexao, "SELECT F.id AS ID_UNIDADE,  F.NF_token AS TOKEN
        FROM qv_franquias F 
        WHERE F.id = '".$resVenda['idUnidade']."' ");
        $resFranquia = mysqli_fetch_array($consultaFranquia);        

        // SQL UPDATE - CANCELA VENDA
        $cancelarVenda = mysqli_query($conexao, "UPDATE PDV_vendas SET status = 'Cancelada', motivoCancelamento = '".$campos['motivo']."' WHERE idVenda = ".$campos['idVenda']." ");

        // SQL SELECT / UPDATE - DESFAZER MOVIMENTACOES ANTERIORES
        if($cancelarVenda) {

            $consultaMovimentacoes = mysqli_query($conexao, "SELECT * FROM PDV_estoqueMovimentacoes WHERE idUnidade = '".$resVenda['idUnidade']."' AND idVenda = ".$campos['idVenda']." AND status = 'OK' ");
            WHILE($resultadoConsultaMovimentacoes = mysqli_fetch_array($consultaMovimentacoes)) {
    
                // SQL UPDATE - ESTOQUE
                $atualizarEstoque = mysqli_query($conexao,"UPDATE PDV_estoque SET quantidade = (quantidade + ".$resultadoConsultaMovimentacoes['quantidade'].") WHERE idUnidade = '".$resVenda['idUnidade']."' AND idProduto = '".$resultadoConsultaMovimentacoes['idProduto']."' AND tamanho = '".$resultadoConsultaMovimentacoes['tamanho']."' AND idCor = '".$resultadoConsultaMovimentacoes['cor']."' ");   
    
                // SQL UPDATE - ANULA MOVIMENTACAO
                if($atualizarEstoque) {
                    $anularMovimentacao = mysqli_query($conexao, "UPDATE PDV_estoqueMovimentacoes SET status = 'Inativo', dataDelete = NOW() WHERE idMovimentacao = ".$resultadoConsultaMovimentacoes['idMovimentacao']." ");
                }

            }        
    
            // SQL UPDATE - INATIVA FINANCEIRO
            $updateFinanceiro = mysqli_query($conexao,"UPDATE PDV_financeiro SET status = 'Inativo', dataDelete = NOW() WHERE idVenda = '".$campos['idVenda']."' "); 
            
            // CANCELAR DOCUMENTOS FISCAIS SE HOUVEREM
            if($resVenda['status_nf'] == 'Emitida') {

                // Cancelamento da NFCe só pode ser feito em até 30min após emissão.
                // Substituir a variável, ref, pela sua identificação interna de nota.
                $ref = $resVenda['nf_referencia'];

                // Dados de Autenticacao na Focus
                $login = $resFranquia['TOKEN'];
                $password = "";
                $NF_Token = base64_encode($login.":".$password);

                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.focusnfe.com.br/v2/nfce/'.$ref,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'DELETE',
                  CURLOPT_POSTFIELDS =>'{
                    "justificativa": "Desistência por parte do cliente."
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . $NF_Token,
                    'Content-Type: text/plain'
                  ),
                ));
                
                $body = curl_exec($curl);
                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);        
                curl_close($curl);
        
                $resposta = json_decode($body, true);
                
                // ATUALIZANDO VENDA
                if($resposta['status'] == 'cancelado' && $resposta['status_sefaz'] == 135) {

                    // SQL UPDATE - ATUALIZAR HISTORICO
                    $historicoFiscal = mysqli_query($conexao, "UPDATE PDV_documentosFiscais SET status = 'Cancelada', caminho_xml_cancelamento = '".$resposta['caminho_xml_cancelamento']."' WHERE referencia = '".$ref."' ORDER BY idDocumento DESC LIMIT 1 ");

                    // SQL UPDATE - VENDA - NF
                    $atualizarVendaNF = mysqli_query($conexao, "UPDATE PDV_vendas SET status_nf = 'Cancelada' WHERE idVenda = '".$campos['idVenda']."' ");                    

                } else {

                    //***************************************************************************/
                    //*** START DO PROCESSO PARA EMITIR NF MODELO 55 PARA ANULAR CUPOM FISCAL ***/
                    //***************************************************************************/

                    // DEFINE TIMEZONE PARA EMISSAO
                    date_default_timezone_set("America/Sao_Paulo");

                    //********** CONSULTA VENDA 
                    $consultaVenda = mysqli_query($conexao, "SELECT V.idUnidade AS ID_UNIDADE, V.idVenda AS ID_VENDA, C.nome AS CLIENTE, C.cpf AS CPF, C.telefone01 AS TELEFONE, C.email AS EMAIL, V.totalLiquido AS TOTAL_LIQUIDO, V.totalBruto AS TOTAL_BRUTO, VFP.tipo AS FORMA_PAGAMENTO, V.nf_referencia AS NF_REFERENCIA, V.chave_nfe AS NF_CHAVE 
                    FROM PDV_vendas V
                    INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente
                    INNER JOIN PDV_vendasFormasPagamento VFP ON VFP.idVenda = V.idVenda
                    WHERE V.idVenda = '".$campos['idVenda']."' LIMIT 1 ");
                    $resVenda = mysqli_fetch_array($consultaVenda);   

                    // CHECANDO SE É CONSUMIDOR
                    if($resVenda['EMAIL'] == 'consumidor@qv.shoes' || 
                        (
                            $resVenda['CPF'] == '00000000000' || 
                            strlen($resVenda['CPF']) != 11 || 
                            empty($resVenda['CPF'])
                        )
                    ) {
                        $nome_destinatario = $campos['cancel_Nome'];
                        $cpf_destinatario = $campos['cancel_CPF'];
                    } else {
                        $nome_destinatario = $resVenda['CLIENTE'];
                        $cpf_destinatario = $resVenda['CPF'];
                    }
                    
                    //********** CONSULTA FRANQUIA
                    $consultaFranquia = mysqli_query($conexao, "SELECT F.cnpj AS CNPJ, F.razao_social AS RAZAO_SOCIAL, F.nome_fantasia AS NOME_FANTASIA, F.endereco AS ENDERECO, F.numero AS NUMERO, F.bairro AS BAIRRO, C.nome AS CIDADE, E.uf AS ESTADO, F.cep AS CEP, F.ie AS INSCRICAO_ESTADUAL, F.NF_token AS TOKEN, UDF.tipoDocumento AS TIPO_DOCUMENTO, UDF.regime_tributario AS REGIME_TRIBUTARIO, UDF.icms_situacao_tributaria AS ICMS_SITUACAO_TRIBUTARIA, UDF.icms_aliquota AS ICMS_ALIQUOTA, UDF.icms_modalidade_base_calculo AS ICMS_MODALIDADE_BASE_CALCULO
                    FROM qv_franquias F 
                    INNER JOIN qv_estados E ON E.id = F.estado_id
                    INNER JOIN qv_cidades C ON C.id = F.cidade_id
                    INNER JOIN PDV_unidadesDadosFiscais UDF ON UDF.idUnidade = F.id
                    WHERE F.id = '".$resVenda['ID_UNIDADE']."' ");
                    $resFranquia = mysqli_fetch_array($consultaFranquia);

                    //********** CONSULTA ITENS DA VENDA
                    $listaProdutos = array();
                    $contadorItens = 1;
                    $consultaItens = mysqli_query($conexao, "SELECT * FROM PDV_vendasProdutos WHERE idVenda = '".$campos['idVenda']."' AND status = 'Ativo' ");
                    $totalItens = mysqli_num_rows($consultaItens);
                    //$descontoDiluido = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']);
                    $descontoDiluido = strval(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO'])*100);
                    $descontoDiluido_contador = 0;
                    if($descontoDiluido > 0) {

                        //$descontoDiluido = $descontoDiluido / $totalItens;
                        //$descontoDiluido_Final = array();
                        //$money = Money::USD($descontoDiluido);
                        //$descontoDiluido = json_decode(json_encode($money->allocateTo($totalItens)), true);
                        //foreach($descontoDiluido AS $key => $value) {
                        //    array_push($descontoDiluido_Final,number_format(($value['amount']/100),2));
                        //}     

                        $descontoDiluido_Final = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) / $resVenda['TOTAL_BRUTO'];

                    } else {
                        $descontoDiluido_Final = 0;
                    }

                    // VALIDADORES
                    $RES_FINAL_TOTALNF = 0;
                    $RES_FINAL_TOTALDESCONTO = 0;

                    WHILE($resItens = mysqli_fetch_array($consultaItens)) {

                        // CONSULTA DADOS PRODUTO
                        $consultaProduto = mysqli_query($conexao, "SELECT id, nome, ncm FROM qv_produtos WHERE id = '".$resItens['idProduto']."' ");
                        $resProduto = mysqli_fetch_array($consultaProduto);

                        $listaProdutos[] = array(
                            "numero_item"                   => $contadorItens,
                            "codigo_ncm"                    => $resProduto['ncm'],
                            "quantidade_comercial"          => $resItens['quantidade'],
                            "cfop"                          => "1202",
                            "valor_unitario_comercial"      => $resItens['preco'],
                            "valor_desconto"                => number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2),
                            "descricao"                     => $resProduto['nome'],
                            "valor_bruto"                   => $resItens['precoTotal'],
                            "codigo_produto"                => $resProduto['id'],
                            "unidade_comercial"             => "un",

                            "icms_origem"                   => "0",
                            "icms_situacao_tributaria"      => $resFranquia['ICMS_SITUACAO_TRIBUTARIA'],
                            "icms_aliquota"                 => $resFranquia['ICMS_ALIQUOTA'],
                            "icms_modalidade_base_calculo"  => $resFranquia['ICMS_MODALIDADE_BASE_CALCULO'],
                            
                            "pis_situacao_tributaria"       => ($resFranquia['REGIME_TRIBUTARIO'] == 'Simples Nacional' ? "49" : "98"),    
                            "cofins_situacao_tributaria"    => ($resFranquia['REGIME_TRIBUTARIO'] == 'Simples Nacional' ? "49" : "98")                            
                        );

                        // TOTALIZADORES
                        $RES_FINAL_TOTALNF += $resItens['precoTotal'];
                        $RES_FINAL_TOTALDESCONTO += number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2);

                        $contadorItens++;
                        $descontoDiluido_contador++;

                    } // WHILE 
                    
                    // VALIDANDO TOTALIZADORES
                    if(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) > $RES_FINAL_TOTALDESCONTO) {
                        $DIFERENCA_CENTAVOS = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) - $RES_FINAL_TOTALDESCONTO;
                        $listaProdutos[0]['valor_desconto'] += $DIFERENCA_CENTAVOS;
                    }                    

                    //********** INTEGRACAO COM FOCUS - ECRAS | CONFIGS
                    $tipoAmbiente = "https://api.focusnfe.com.br";
                    //$tipoAmbiente = "https://homologacao.focusnfe.com.br";

                    if($tipoAmbiente == 'https://homologacao.focusnfe.com.br') {
                        $resVenda['CLIENTE'] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
                    }

                    // Substituir a variável, ref, pela sua identificação interna de nota.
                    $ref = $resVenda['NF_REFERENCIA']."C";

                    // Dados de Autenticacao na Focus
                    $login = $resFranquia['TOKEN'];
                    $password = "";
                    $NF_Token = base64_encode($login.":".$password);

                    $endpoint = "/v2/nfe?ref=";

                    $nfFull = array (
                        "natureza_operacao"         => "DEVOLUÇÃO",
                        "data_emissao"              => DATE("c"),
                        "tipo_documento"            => "0",
                        "finalidade_emissao"        => "4",        
                        "cnpj_emitente"             => limpar($resFranquia['CNPJ']),
                        "indicador_inscricao_estadual_destinatario" => "9",

                        "nome_destinatario"         => $nome_destinatario,
                        "cpf_destinatario"          => limpar($cpf_destinatario), 
                        "logradouro_destinatario"   => $resFranquia['ENDERECO'],
                        "numero_destinatario"       => $resFranquia['NUMERO'],
                        "bairro_destinatario"       => $resFranquia['BAIRRO'],         
                        "municipio_destinatario"    => $resFranquia['CIDADE'],
                        "uf_destinatario"           => $resFranquia['ESTADO'],
                        "cep_destinatario"          => limpar($resFranquia['CEP']),
                        "pais_destinatario"         => "Brasil",

                        "modalidade_frete"          => "9",
                        "local_destino"             => "1",
                        "presenca_comprador"        => "1",
                        "forma_pagamento"           => "0", 

                        "notas_referenciadas" => array(
                            array("chave_nfe" => str_replace("NFe","",$resVenda['NF_CHAVE']))
                        ),                        
                        "items" => $listaProdutos
                    ); 
                        
                    // CURL - Inicia o processo de envio das informações usando o cURL.
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $tipoAmbiente . $endpoint . $ref,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($nfFull),
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Basic ' . $NF_Token,
                            'Content-Type: text/plain'
                        ),
                    ));
                    $body = curl_exec($curl);
                    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    curl_close($curl);
                    $resposta = json_decode($body, true);
                    // END CURL

                    //***************************************************************************/
                    //**** END DO PROCESSO PARA EMITIR NF MODELO 55 PARA ANULAR CUPOM FISCAL ****/
                    //***************************************************************************/

                    // CONSULTANDO REQUISICAO
                    if($resposta['status'] == 'processando_autorizacao' && $http_code == 202) {

                        sleep(5);

                        // CURL PARA CONSULTAR NFe
                        $curl = curl_init();                        
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://api.focusnfe.com.br/v2/nfe/'.$ref.'?completa=0',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: Basic ' . $NF_Token
                            )
                        ));
                        $response = curl_exec($curl);
                        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                        curl_close($curl);
                        $resposta_consulta = json_decode($response, true);
                        
                        // VERIFICACAO
                        if($resposta_consulta['status'] == 'autorizado' && $http_code == 200) {

                            // SQL UPDATE - ATUALIZAR HISTORICO
                            $historicoFiscal = mysqli_query($conexao, "UPDATE PDV_documentosFiscais SET status = 'Cancelada' WHERE referencia = '".$resVenda['NF_REFERENCIA']."' ORDER BY idDocumento DESC LIMIT 1 ");

                            // SQL UPDATE - VENDA - NF
                            $atualizarVendaNF = mysqli_query($conexao, "UPDATE PDV_vendas SET status_nf = 'Cancelada' WHERE idVenda = '".$campos['idVenda']."' ");                             

                            // SELECT INSERT - HISTORICO DOCUMENTOS FISCAIS
                            $historicoFiscal = mysqli_query($conexao, "INSERT INTO PDV_documentosFiscais (idVenda, referencia, numero, protocolo, chave_nfe, caminho_xml_nota_fiscal, caminho_danfe, nf_json, json_request, dataInsert) VALUES ('".$campos['idVenda']."', '".$ref."', '".$resposta_consulta['numero']."', '".$resposta_consulta['protocolo']."', '".$resposta_consulta['chave_nfe']."', '".$resposta_consulta['caminho_xml_nota_fiscal']."', '".$resposta_consulta['caminho_danfe']."', '".$response."', '".json_encode($nfFull)."', NOW())");

                            //********** GERA LOG DA VENDA
                            $logDescricao = 'Cupom Fiscal Anulado via NFe (55).';
                            $logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$campos['idVenda']."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
                            //********** GERA LOG DA VENDA                             

                        } else {
                            logsDebugFocus($resVenda['ID_UNIDADE'],$resVenda['ID_VENDA'],'',$response);
                        }

                    } else {
                        logsDebugFocus($resVenda['ID_UNIDADE'],$resVenda['ID_VENDA'],json_encode($nfFull),$body);
                    }                    

                }

            }

        }

        // VALIDACAO FINAL                 
        if($cancelarVenda && $atualizarEstoque && $anularMovimentacao) {

            //********** GERA LOG DA VENDA
			$logDescricao = 'Venda Cancelada por motivo de <b>' . $campos['motivo'] . '</b>.';
			$logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$campos['idVenda']."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
            //********** GERA LOG DA VENDA             

            // RESULTADO
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Venda Cancelada com Sucesso');

        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Cancelar Venda. Contate o Suporte!');
        }

        // RETORNO
        return $resultadoFinal;        

    }         

    //***** EMISSAO DOCUMENTO FISCAL - NFe / NFCe
    public function documentoFiscal() {  

        date_default_timezone_set("America/Sao_Paulo");

        // VENDAS DE MERC. ADQUIRIDAS E/OU RECEBIDAS DE TERCEIROS 
        // CFOP: 6108 (fora estado) ou 5108 (dentro estado)
        // Checar local_destino | Venda dentro e fora do estado

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos         = $this->campos; 
        $QV_idUsuario   = $_SESSION['Authentication']['id_usuario'];

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        //********** CONSULTA VENDA 
        $consultaVenda = mysqli_query($conexao, "SELECT V.idUnidade AS ID_UNIDADE, V.idVenda AS ID_VENDA, C.nome AS CLIENTE, C.cpf AS CPF, C.telefone01 AS TELEFONE, V.totalLiquido AS TOTAL_LIQUIDO, V.totalBruto AS TOTAL_BRUTO, VFP.tipo AS FORMA_PAGAMENTO
        FROM PDV_vendas V
        INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente
        INNER JOIN PDV_vendasFormasPagamento VFP ON VFP.idVenda = V.idVenda
        WHERE V.idVenda = '".$campos['idVenda']."' LIMIT 1 ");
        $resVenda = mysqli_fetch_array($consultaVenda);

        //********** CONSULTA FRANQUIA
        $consultaFranquia = mysqli_query($conexao, "SELECT F.cnpj AS CNPJ, F.razao_social AS RAZAO_SOCIAL, F.nome_fantasia AS NOME_FANTASIA, F.endereco AS ENDERECO, F.numero AS NUMERO, F.bairro AS BAIRRO, C.nome AS CIDADE, E.uf AS ESTADO, F.cep AS CEP, F.ie AS INSCRICAO_ESTADUAL, F.NF_token AS TOKEN, UDF.tipoDocumento AS TIPO_DOCUMENTO, UDF.regime_tributario AS REGIME_TRIBUTARIO, UDF.icms_situacao_tributaria AS ICMS_SITUACAO_TRIBUTARIA, UDF.icms_aliquota AS ICMS_ALIQUOTA, UDF.icms_modalidade_base_calculo AS ICMS_MODALIDADE_BASE_CALCULO
        FROM qv_franquias F 
        INNER JOIN qv_estados E ON E.id = F.estado_id
        INNER JOIN qv_cidades C ON C.id = F.cidade_id
        INNER JOIN PDV_unidadesDadosFiscais UDF ON UDF.idUnidade = F.id
        WHERE F.id = '".$resVenda['ID_UNIDADE']."' ");
        $resFranquia = mysqli_fetch_array($consultaFranquia);

        //********** CONSULTA ITENS DA VENDA
        $listaProdutos = array();
        $contadorItens = 1;
        $consultaItens = mysqli_query($conexao, "SELECT * FROM PDV_vendasProdutos WHERE idVenda = '".$campos['idVenda']."' AND status = 'Ativo' ");
        $totalItens = mysqli_num_rows($consultaItens);

        //$descontoDiluido = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']);
        $descontoDiluido = strval(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO'])*100);
        $descontoDiluido_contador = 0;
        if($descontoDiluido > 0) {

            //$descontoDiluido = $descontoDiluido / $totalItens;
            //$descontoDiluido_Final = array();
            //$money = Money::USD($descontoDiluido);
            //$descontoDiluido = json_decode(json_encode($money->allocateTo($totalItens)), true);
            //foreach($descontoDiluido AS $key => $value) {
            //    array_push($descontoDiluido_Final,number_format(($value['amount']/100),2));
            //}  

            $descontoDiluido_Final = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) / $resVenda['TOTAL_BRUTO'];

        } else {
            $descontoDiluido_Final = 0;
        }

        // "valor_desconto"                => ($descontoDiluido_Final == 0 ? 0 : $descontoDiluido_Final[$descontoDiluido_contador]),

        // VALIDADORES
        $RES_FINAL_TOTALNF = 0;
        $RES_FINAL_TOTALDESCONTO = 0;
        
        WHILE($resItens = mysqli_fetch_array($consultaItens)) {

            // CONSULTA DADOS PRODUTO
            $consultaProduto = mysqli_query($conexao, "SELECT id, nome, ncm FROM qv_produtos WHERE id = '".$resItens['idProduto']."' ");
            $resProduto = mysqli_fetch_array($consultaProduto);

            // VALIDA TIPO DOCUMENTO FISCAL
            if($resFranquia['TIPO_DOCUMENTO'] == 'NFe') {

                $listaProdutos[] = array(
                    "numero_item"                   => $contadorItens,
                    "codigo_ncm"                    => $resProduto['ncm'],
                    "quantidade_comercial"          => $resItens['quantidade'],
                    "cfop" => "5102",
                    "valor_unitario_comercial"      => $resItens['preco'],
                    "valor_desconto"                => number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2),
                    "descricao"                     => $resProduto['nome'],
                    "valor_bruto"                   => $resItens['precoTotal'],
                    "codigo_produto"                => $resProduto['id'],
    
                    "icms_origem"                   => "0",
                    "icms_situacao_tributaria"      => $resFranquia['ICMS_SITUACAO_TRIBUTARIA'],
                    "icms_aliquota"                 => $resFranquia['ICMS_ALIQUOTA'],
                    "icms_modalidade_base_calculo"  => $resFranquia['ICMS_MODALIDADE_BASE_CALCULO'],
                    
                    "pis_situacao_tributaria"       => "07",    
                    "cofins_situacao_tributaria"    => "07",
                    "cofins_aliquota_porcentual"    => "07",                    
                    "unidade_comercial"             => "un",

                    "codigo_barras_comercial"       => "SEM GTIN",
                    "codigo_barras_tributavel"      => "SEM GTIN",

                    "unidade_comercial"             => "un"
    
                );                

            } else {

                $listaProdutos[] = array(
                    "numero_item"                   => $contadorItens,
                    "codigo_ncm"                    => $resProduto['ncm'],
                    "quantidade_comercial"          => $resItens['quantidade'],
                    "cfop"                          => "5102",
                    "valor_unitario_comercial"      => $resItens['preco'],
                    "valor_desconto"                => number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2),
                    "descricao"                     => $resProduto['nome'],
                    "valor_bruto"                   => $resItens['precoTotal'],
                    "codigo_produto"                => $resProduto['id'],
    
                    "icms_origem"                   => "0",
                    "icms_situacao_tributaria"      => $resFranquia['ICMS_SITUACAO_TRIBUTARIA'],
                    "icms_aliquota"                 => $resFranquia['ICMS_ALIQUOTA'],
                    "icms_modalidade_base_calculo"  => $resFranquia['ICMS_MODALIDADE_BASE_CALCULO'],
        
                    "codigo_barras_comercial"       => "SEM GTIN",
                    "codigo_barras_tributavel"      => "SEM GTIN",                
                    
                    "unidade_comercial"             => "un"
    
                );                

            }

            // TOTALIZADORES
            $RES_FINAL_TOTALNF += $resItens['precoTotal'];
            $RES_FINAL_TOTALDESCONTO += number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2);

            $contadorItens++;
            $descontoDiluido_contador++;

        } // WHILE 
        
        // VALIDANDO TOTALIZADORES
        if(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) > $RES_FINAL_TOTALDESCONTO) {
            $DIFERENCA_CENTAVOS = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) - $RES_FINAL_TOTALDESCONTO;
            $listaProdutos[0]['valor_desconto'] += $DIFERENCA_CENTAVOS;
        }
        
        //********** INTEGRACAO COM FOCUS - ECRAS | CONFIGS
        $tipoAmbiente = "https://api.focusnfe.com.br";
        //$tipoAmbiente = "https://homologacao.focusnfe.com.br";

        if($tipoAmbiente == 'https://homologacao.focusnfe.com.br') {
            $resVenda['CLIENTE'] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }

        // Substituir a variável, ref, pela sua identificação interna de nota.
        //$ref = str_pad($resVenda['ID_VENDA'],6,0,STR_PAD_LEFT);
        $ref = str_pad($resVenda['ID_VENDA'],6,0,STR_PAD_LEFT)."_".DATE("Ymd_his");

        // Dados de Autenticacao na Focus
        $login = $resFranquia['TOKEN'];
        $password = "";
        $NF_Token = base64_encode($login.":".$password);


        // TRATANDO REGIME TRIBUTARIO
        if($resFranquia['REGIME_TRIBUTARIO'] == 'Simples Nacional') {
            $regimeTributario = "1";
        } elseif($resFranquia['REGIME_TRIBUTARIO'] == 'Regime Normal') {
            $regimeTributario = "3";
        } else {
            $regimeTributario = "2";
        }

        // FORMA PAGAMENTO
        switch ($resVenda['FORMA_PAGAMENTO']) {
            case "Dinheiro":        $nfFormaPagamento = '01'; break;
            case "Pix":             $nfFormaPagamento = '99'; break;
            case "Cartão Débito":   $nfFormaPagamento = '04'; break;
            case "Cartão Crédito":  $nfFormaPagamento = '03'; break;
            case "Boleto":          $nfFormaPagamento = '99'; break;
            case "Cheque":          $nfFormaPagamento = '02'; break;
            case "Carnê":           $nfFormaPagamento = '99'; break;
        }	        

        // Cabecalho do Documento Fiscal
        if($resFranquia['TIPO_DOCUMENTO'] == 'NFe') {

            // ENDPOINT DA API
            $endpoint = "/v2/nfe?ref=";

            // ESTRUTURA ARRAY -> JSON
            $nfFull = array (
                "natureza_operacao"         => "VENDA",
                "data_emissao"              => DATE("c"),
                "tipo_documento"            => "1",
                "finalidade_emissao"        => "1",   

                "cnpj_emitente"             => limpar($resFranquia['CNPJ']),
                "nome_emitente"             => $resFranquia['RAZAO_SOCIAL'],
                "nome_fantasia_emitente"    => $resFranquia['NOME_FANTASIA'],
                "logradouro_emitente"       => $resFranquia['ENDERECO'],
                "numero_emitente"           => $resFranquia['NUMERO'],
                "bairro_emitente"           => $resFranquia['BAIRRO'],
                "municipio_emitente"        => $resFranquia['CIDADE'],
                "uf_emitente"               => $resFranquia['ESTADO'],
                "cep_emitente"              => limpar($resFranquia['CEP']),
                "inscricao_estadual_emitente"   => $resFranquia['INSCRICAO_ESTADUAL'],
                "regime_tributario_emitente"    => $regimeTributario,

                "nome_destinatario"         => $resVenda['CLIENTE'],
                "cpf_destinatario"          => $resVenda['CPF'],       
                "telefone_destinatario"     => $resVenda['TELEFONE'],
                "logradouro_destinatario"   => $resFranquia['ENDERECO'],
                "numero_destinatario"       => $resFranquia['NUMERO'],
                "bairro_destinatario"       => $resFranquia['BAIRRO'],         
                "municipio_destinatario"    => $resFranquia['CIDADE'],
                "uf_destinatario"           => $resFranquia['ESTADO'],
                "cep_destinatario"          => limpar($resFranquia['CEP']),
                "pais_destinatario"         => "Brasil",
                "indicador_inscricao_estadual_destinatario" => "2",

                "valor_frete"               => "0.0",
                "valor_seguro"              => "0",
                "valor_produtos"            => $resVenda['TOTAL_BRUTO'],
                "modalidade_frete"          => "9",
                "valor_desconto"            => ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']),
                "items"                     => $listaProdutos,
                "formas_pagamento" => array(
                    array(
                        "forma_pagamento" => $nfFormaPagamento,
                        "valor_pagamento" => $resVenda['TOTAL_LIQUIDO']
                    )
                )

            );

        } else {

            $endpoint = "/v2/nfce?ref=";

            $nfFull = array (
                "cnpj_emitente"         => limpar($resFranquia['CNPJ']),
                "cpf_destinatario"      => (empty($resVenda['CPF']) ? '' : $resVenda['CPF']),
                "data_emissao"          => DATE("Y-m-d H:i:s"),
                "indicador_inscricao_estadual_destinatario" => "9",
                "modalidade_frete"      => "9",
                "local_destino"         => "1",
                "presenca_comprador"    => "1",
                "natureza_operacao"     => "VENDA AO CONSUMIDOR",
                "items" => $listaProdutos,
                "formas_pagamento" => array(
                    array(
                        "forma_pagamento" => $nfFormaPagamento,
                        "valor_pagamento" => $resVenda['TOTAL_LIQUIDO']
                    )
                )
            );              

        }   
            
        // CURL - Inicia o processo de envio das informações usando o cURL.
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $tipoAmbiente . $endpoint . $ref,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($nfFull),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $NF_Token,
                'Content-Type: text/plain'
            ),
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // END CURL

        // As próximas três linhas são um exemplo de como imprimir as informações de retorno da API.
        // print($http_code."\n");
        // print($body."\n\n");

        curl_close($curl);

        $resposta = json_decode($body, true);
        
        // ATUALIZANDO VENDA
        if(
            ($resposta['status'] == 'autorizado' && $resposta['status_sefaz'] == 100) ||
            ($resposta['status'] == 'processando_autorizacao' && $http_code == 202)
        ) {

            // CHECANDO NECESSIDADE DE CONSULTAR EMISSAO
            if($resposta['status'] == 'processando_autorizacao' && $http_code == 202) {
                sleep(5);
                $resposta = focusConsDocFiscal($resVenda['ID_UNIDADE'],$ref);
            }

            // SELECT INSERT - HISTORICO DOCUMENTOS FISCAIS
            $historicoFiscal = mysqli_query($conexao, "INSERT INTO PDV_documentosFiscais (idVenda, referencia, numero, protocolo, chave_nfe, caminho_xml_nota_fiscal, caminho_danfe, qrcode_url, url_consulta_nf, nf_json, json_request, dataInsert) VALUES ('".$campos['idVenda']."', '".$ref."', '".$resposta['numero']."', '".$resposta['protocolo']."', '".$resposta['chave_nfe']."', '".$resposta['caminho_xml_nota_fiscal']."', '".$resposta['caminho_danfe']."', '".$resposta['qrcode_url']."', '".$resposta['url_consulta_nf']."', '".$body."', '".json_encode($nfFull)."', NOW())");

            // SQL UPDATE - VENDA
            $atualizarVenda = mysqli_query($conexao, "UPDATE PDV_vendas SET nf_referencia = '".$ref."', status_nf = 'Emitida', nf_numero = '".$resposta['numero']."', nf_protocolo = '".$resposta['protocolo']."', chave_nfe = '".$resposta['chave_nfe']."', caminho_xml_nota_fiscal = '".$resposta['caminho_xml_nota_fiscal']."', caminho_danfe = '".$resposta['caminho_danfe']."', qrcode_url = '".$resposta['qrcode_url']."', url_consulta_nf = '".$resposta['url_consulta_nf']."', nf_json = '".$body."' WHERE idVenda = '".$campos['idVenda']."' ");

            //********** GERA LOG DA VENDA
			$logDescricao = 'Documento Fiscal Emitido.';
			$logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$campos['idVenda']."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
            //********** GERA LOG DA VENDA              

            // RETORNO COM LINK DA NF
            $resConteudo = array('url_nf' => $tipoAmbiente.$resposta['caminho_danfe']);

        } else {
            logsDebugFocus($resVenda['ID_UNIDADE'],$resVenda['ID_VENDA'],json_encode($nfFull),$body);
        }

        // VALIDACAO FINAL                 
        if($atualizarVenda) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Documento Fiscal Emitido com Sucesso', 'conteudo'=>$resConteudo);
        } else {

            if(!empty($resposta['mensagem_sefaz'])) {
                $mensagemErroFocus = "[".$resposta['status_sefaz']."] ".$resposta['mensagem_sefaz'];
            } else {
                $mensagemErroFocus = $resposta['mensagem'];
            }

            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não foi possível emitir nota fiscal.<br> Log de Erro - <b>Código: </b>'.$http_code.' <br>___________<br><pre class="text-left text-wrap">'.$mensagemErroFocus.'</pre>');

        }

        // RETORNO
        return $resultadoFinal;        

    } 

    //***** RE-EMISSAO DOCUMENTO FISCAL - NFe / NFCe | APOS UPDATE
    public function documentoFiscal_Reemitir() {  

        date_default_timezone_set("America/Sao_Paulo");

        // VENDAS DE MERC. ADQUIRIDAS E/OU RECEBIDAS DE TERCEIROS 
        // CFOP: 6108 (fora estado) ou 5108 (dentro estado)
        // Checar local_destino | Venda dentro e fora do estado

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos         = $this->campos; 
        $QV_idUsuario   = $_SESSION['Authentication']['id_usuario'];        

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        //********** CONSULTA VENDA 
        $consultaVenda = mysqli_query($conexao, "SELECT V.idUnidade AS ID_UNIDADE, V.idVenda AS ID_VENDA, C.nome AS CLIENTE, C.cpf AS CPF, C.telefone01 AS TELEFONE, V.totalLiquido AS TOTAL_LIQUIDO, V.totalBruto AS TOTAL_BRUTO, VFP.tipo AS FORMA_PAGAMENTO, V.status_nf AS SITUACAO_NF, V.nf_referencia AS NF_REFERENCIA
        FROM PDV_vendas V
        INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente
        INNER JOIN PDV_vendasFormasPagamento VFP ON VFP.idVenda = V.idVenda
        WHERE V.idVenda = '".$campos['idVenda']."' LIMIT 1 ");
        $resVenda = mysqli_fetch_array($consultaVenda);      

        //********** CONSULTA FRANQUIA
        $consultaFranquia = mysqli_query($conexao, "SELECT F.cnpj AS CNPJ, F.razao_social AS RAZAO_SOCIAL, F.nome_fantasia AS NOME_FANTASIA, F.endereco AS ENDERECO, F.numero AS NUMERO, F.bairro AS BAIRRO, C.nome AS CIDADE, E.uf AS ESTADO, F.cep AS CEP, F.ie AS INSCRICAO_ESTADUAL, F.NF_token AS TOKEN, UDF.tipoDocumento AS TIPO_DOCUMENTO, UDF.regime_tributario AS REGIME_TRIBUTARIO, UDF.icms_situacao_tributaria AS ICMS_SITUACAO_TRIBUTARIA, UDF.icms_aliquota AS ICMS_ALIQUOTA, UDF.icms_modalidade_base_calculo AS ICMS_MODALIDADE_BASE_CALCULO
        FROM qv_franquias F 
        INNER JOIN qv_estados E ON E.id = F.estado_id
        INNER JOIN qv_cidades C ON C.id = F.cidade_id
        INNER JOIN PDV_unidadesDadosFiscais UDF ON UDF.idUnidade = F.id
        WHERE F.id = '".$resVenda['ID_UNIDADE']."' ");
        $resFranquia = mysqli_fetch_array($consultaFranquia);

        //********** CANCELAR DOCUMENTOS FISCAIS ANTERIORES SE HOUVEREM
        if($resVenda['SITUACAO_NF'] == 'Emitida') {

            // Cancelamento da NFCe só pode ser feito em até 30min após emissão.
            // Substituir a variável, ref, pela sua identificação interna de nota.
            $ref = $resVenda['NF_REFERENCIA'];

            // Dados de Autenticacao na Focus
            $login = $resFranquia['TOKEN'];
            $password = "";
            $NF_Token = base64_encode($login.":".$password);

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.focusnfe.com.br/v2/nfce/'.$ref,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_POSTFIELDS =>'{
                "justificativa": "Desistência por parte do cliente."
            }',
                CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $NF_Token,
                'Content-Type: text/plain'
                ),
            ));
            
            $body = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);        
            curl_close($curl);
    
            $resposta = json_decode($body, true);
            
            // ATUALIZANDO VENDA
            if($resposta['status'] == 'cancelado' && $resposta['status_sefaz'] == 135) {

                // SQL UPDATE - ATUALIZAR HISTORICO
                $historicoFiscal = mysqli_query($conexao, "UPDATE PDV_documentosFiscais SET status = 'Cancelada', caminho_xml_cancelamento = '".$resposta['caminho_xml_cancelamento']."' WHERE referencia = '".$ref."' ");

                // SQL UPDATE - VENDA - NF
                $atualizarVendaNF = mysqli_query($conexao, "UPDATE PDV_vendas SET status_nf = 'Cancelada' WHERE idVenda = '".$campos['idVenda']."' ");                    

            }

        }          

        //********** CONSULTA ITENS DA VENDA
        $listaProdutos = array();
        $contadorItens = 1;
        $consultaItens = mysqli_query($conexao, "SELECT * FROM PDV_vendasProdutos WHERE idVenda = '".$campos['idVenda']."' AND status = 'Ativo' ");
        $totalItens = mysqli_num_rows($consultaItens);
        //$descontoDiluido = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']);
        $descontoDiluido = strval(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO'])*100);
        $descontoDiluido_contador = 0;
        if($descontoDiluido > 0) {

            //$descontoDiluido = $descontoDiluido / $totalItens;
            //$descontoDiluido_Final = array();
            //$money = Money::USD($descontoDiluido);
            //$descontoDiluido = json_decode(json_encode($money->allocateTo($totalItens)), true);
            //foreach($descontoDiluido AS $key => $value) {
            //    array_push($descontoDiluido_Final,number_format(($value['amount']/100),2));
            //}    
            
            $descontoDiluido_Final = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) / $resVenda['TOTAL_BRUTO'];

        } else {
            $descontoDiluido_Final = 0;
        }

        // VALIDADORES
        $RES_FINAL_TOTALNF = 0;
        $RES_FINAL_TOTALDESCONTO = 0;

        WHILE($resItens = mysqli_fetch_array($consultaItens)) {

            // CONSULTA DADOS PRODUTO
            $consultaProduto = mysqli_query($conexao, "SELECT id, nome, ncm FROM qv_produtos WHERE id = '".$resItens['idProduto']."' ");
            $resProduto = mysqli_fetch_array($consultaProduto);

            // VALIDA TIPO DOCUMENTO FISCAL
            if($resFranquia['TIPO_DOCUMENTO'] == 'NFe') {

                $listaProdutos[] = array(
                    "numero_item"                   => $contadorItens,
                    "codigo_ncm"                    => $resProduto['ncm'],
                    "quantidade_comercial"          => $resItens['quantidade'],
                    "cfop" => "5102",
                    "valor_unitario_comercial"      => $resItens['preco'],
                    "valor_desconto"                => number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2),
                    "descricao"                     => $resProduto['nome'],
                    "valor_bruto"                   => $resItens['precoTotal'],
                    "codigo_produto"                => $resProduto['id'],
    
                    "icms_origem"                   => "0",
                    "icms_situacao_tributaria"      => $resFranquia['ICMS_SITUACAO_TRIBUTARIA'],
                    "icms_aliquota"                 => $resFranquia['ICMS_ALIQUOTA'],
                    "icms_modalidade_base_calculo"  => $resFranquia['ICMS_MODALIDADE_BASE_CALCULO'],
                    
                    "pis_situacao_tributaria"       => "07",    
                    "cofins_situacao_tributaria"    => "07",
                    "cofins_aliquota_porcentual"    => "07",                    
                    "unidade_comercial"             => "un",

                    "codigo_barras_comercial"       => "SEM GTIN",
                    "codigo_barras_tributavel"      => "SEM GTIN",

                    "unidade_comercial"             => "un"
    
                );                

            } else {

                $listaProdutos[] = array(
                    "numero_item"                   => $contadorItens,
                    "codigo_ncm"                    => $resProduto['ncm'],
                    "quantidade_comercial"          => $resItens['quantidade'],
                    "cfop"                          => "5102",
                    "valor_unitario_comercial"      => $resItens['preco'],
                    "valor_desconto"                => number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2),
                    "descricao"                     => $resProduto['nome'],
                    "valor_bruto"                   => $resItens['precoTotal'],
                    "codigo_produto"                => $resProduto['id'],
    
                    "icms_origem"                   => "0",
                    "icms_situacao_tributaria"      => $resFranquia['ICMS_SITUACAO_TRIBUTARIA'],
                    "icms_aliquota"                 => $resFranquia['ICMS_ALIQUOTA'],
                    "icms_modalidade_base_calculo"  => $resFranquia['ICMS_MODALIDADE_BASE_CALCULO'],
        
                    "codigo_barras_comercial"       => "SEM GTIN",
                    "codigo_barras_tributavel"      => "SEM GTIN",                
                    
                    "unidade_comercial"             => "un"
    
                );                

            }

            // TOTALIZADORES
            $RES_FINAL_TOTALNF += $resItens['precoTotal'];
            $RES_FINAL_TOTALDESCONTO += number_format(($descontoDiluido_Final == 0 ? 0 : ($resItens['precoTotal'] * $descontoDiluido_Final)),2);

            $contadorItens++;
            $descontoDiluido_contador++;

        } // WHILE 
        
        // VALIDANDO TOTALIZADORES
        if(($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) > $RES_FINAL_TOTALDESCONTO) {
            $DIFERENCA_CENTAVOS = ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']) - $RES_FINAL_TOTALDESCONTO;
            $listaProdutos[0]['valor_desconto'] += $DIFERENCA_CENTAVOS;
        }       

        //********** INTEGRACAO COM FOCUS - ECRAS | CONFIGS
        $tipoAmbiente = "https://api.focusnfe.com.br";
        //$tipoAmbiente = "https://homologacao.focusnfe.com.br";

        if($tipoAmbiente == 'https://homologacao.focusnfe.com.br') {
            $resVenda['CLIENTE'] = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }

        // Substituir a variável, ref, pela sua identificação interna de nota.
        $ref = str_pad($resVenda['ID_VENDA'],6,0,STR_PAD_LEFT)."_".DATE("Ymd_his");

        // Dados de Autenticacao na Focus
        $login = $resFranquia['TOKEN'];
        $password = "";
        $NF_Token = base64_encode($login.":".$password);

        // TRATANDO REGIME TRIBUTARIO
        if($resFranquia['REGIME_TRIBUTARIO'] == 'Simples Nacional') {
            $regimeTributario = "1";
        } elseif($resFranquia['REGIME_TRIBUTARIO'] == 'Regime Normal') {
            $regimeTributario = "3";
        } else {
            $regimeTributario = "2";
        }

        // FORMA PAGAMENTO
        switch ($resVenda['FORMA_PAGAMENTO']) {
            case "Dinheiro":        $nfFormaPagamento = '01'; break;
            case "Pix":             $nfFormaPagamento = '99'; break;
            case "Cartão Débito":   $nfFormaPagamento = '04'; break;
            case "Cartão Crédito":  $nfFormaPagamento = '03'; break;
            case "Boleto":          $nfFormaPagamento = '99'; break;
            case "Cheque":          $nfFormaPagamento = '02'; break;
            case "Carnê":           $nfFormaPagamento = '99'; break;
        }	        

        // Cabecalho do Documento Fiscal
        if($resFranquia['TIPO_DOCUMENTO'] == 'NFe') {

            // ENDPOINT API
            $endpoint = "/v2/nfe?ref=";

            // ESTRUTURA ARRAY -> JSON
            $nfFull = array (
                "natureza_operacao"         => "VENDA",
                "data_emissao"              => DATE("c"),
                "tipo_documento"            => "1",
                "finalidade_emissao"        => "1",   

                "cnpj_emitente"             => limpar($resFranquia['CNPJ']),
                "nome_emitente"             => $resFranquia['RAZAO_SOCIAL'],
                "nome_fantasia_emitente"    => $resFranquia['NOME_FANTASIA'],
                "logradouro_emitente"       => $resFranquia['ENDERECO'],
                "numero_emitente"           => $resFranquia['NUMERO'],
                "bairro_emitente"           => $resFranquia['BAIRRO'],
                "municipio_emitente"        => $resFranquia['CIDADE'],
                "uf_emitente"               => $resFranquia['ESTADO'],
                "cep_emitente"              => limpar($resFranquia['CEP']),
                "inscricao_estadual_emitente"   => $resFranquia['INSCRICAO_ESTADUAL'],
                "regime_tributario_emitente"    => $regimeTributario,

                "nome_destinatario"         => $resVenda['CLIENTE'],
                "cpf_destinatario"          => $resVenda['CPF'],       
                "telefone_destinatario"     => $resVenda['TELEFONE'],
                "logradouro_destinatario"   => $resFranquia['ENDERECO'],
                "numero_destinatario"       => $resFranquia['NUMERO'],
                "bairro_destinatario"       => $resFranquia['BAIRRO'],         
                "municipio_destinatario"    => $resFranquia['CIDADE'],
                "uf_destinatario"           => $resFranquia['ESTADO'],
                "cep_destinatario"          => limpar($resFranquia['CEP']),
                "pais_destinatario"         => "Brasil",
                "indicador_inscricao_estadual_destinatario" => "2",

                "valor_frete"               => "0.0",
                "valor_seguro"              => "0",
                "valor_produtos"            => $resVenda['TOTAL_BRUTO'],
                "modalidade_frete"          => "9",
                "valor_desconto"            => ($resVenda['TOTAL_BRUTO'] - $resVenda['TOTAL_LIQUIDO']),
                "items"                     => $listaProdutos,
                "formas_pagamento" => array(
                    array(
                        "forma_pagamento" => $nfFormaPagamento,
                        "valor_pagamento" => $resVenda['TOTAL_LIQUIDO']
                    )
                )

            );

        } else {

            $endpoint = "/v2/nfce?ref=";

            $nfFull = array (
                "cnpj_emitente" => limpar($resFranquia['CNPJ']),
                "cpf_destinatario" => (empty($resVenda['CPF']) ? '' : $resVenda['CPF']),
                "data_emissao" => DATE("Y-m-d H:i:s"),
                "indicador_inscricao_estadual_destinatario" => "9",
                "modalidade_frete" => "9",
                "local_destino" => "1",
                "presenca_comprador" => "1",
                "natureza_operacao" => "VENDA AO CONSUMIDOR",
                "items" => $listaProdutos,
                "formas_pagamento" => array(
                    array(
                        "forma_pagamento" => $nfFormaPagamento,
                        "valor_pagamento" => $resVenda['TOTAL_LIQUIDO']
                    )
                )
            );              

        }   
            
        // CURL - Inicia o processo de envio das informações usando o cURL.
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $tipoAmbiente . $endpoint . $ref,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($nfFull),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $NF_Token,
                'Content-Type: text/plain'
            ),
        ));
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // END CURL

        // As próximas três linhas são um exemplo de como imprimir as informações de retorno da API.
        // print($http_code."\n");
        // print($body."\n\n");

        curl_close($curl);

        $resposta = json_decode($body, true);
        
        // ATUALIZANDO VENDA
        if(
            ($resposta['status'] == 'autorizado' && $resposta['status_sefaz'] == 100) ||
            ($resposta['status'] == 'processando_autorizacao' && $http_code == 202)
        ) {

            // CHECANDO NECESSIDADE DE CONSULTAR EMISSAO
            if($resposta['status'] == 'processando_autorizacao' && $http_code == 202) {
                sleep(5);
                $resposta = focusConsDocFiscal($resVenda['ID_UNIDADE'],$ref);
            }

            // SELECT INSERT - HISTORICO DOCUMENTOS FISCAIS
            $historicoFiscal = mysqli_query($conexao, "INSERT INTO PDV_documentosFiscais (idVenda, referencia, numero, protocolo, chave_nfe, caminho_xml_nota_fiscal, caminho_danfe, qrcode_url, url_consulta_nf, nf_json, json_request, dataInsert) VALUES ('".$campos['idVenda']."', '".$ref."', '".$resposta['numero']."', '".$resposta['protocolo']."', '".$resposta['chave_nfe']."', '".$resposta['caminho_xml_nota_fiscal']."', '".$resposta['caminho_danfe']."', '".$resposta['qrcode_url']."', '".$resposta['url_consulta_nf']."', '".$body."', '".json_encode($nfFull)."', NOW())");

            // SQL UPDATE - VENDA
            $atualizarVenda = mysqli_query($conexao, "UPDATE PDV_vendas SET nf_referencia = '".$ref."', status_nf = 'Emitida', nf_numero = '".$resposta['numero']."', nf_protocolo = '".$resposta['protocolo']."', chave_nfe = '".$resposta['chave_nfe']."', caminho_xml_nota_fiscal = '".$resposta['caminho_xml_nota_fiscal']."', caminho_danfe = '".$resposta['caminho_danfe']."', qrcode_url = '".$resposta['qrcode_url']."', url_consulta_nf = '".$resposta['url_consulta_nf']."', nf_json = '".$body."' WHERE idVenda = '".$campos['idVenda']."' ");

            //********** GERA LOG DA VENDA
			$logDescricao = 'Novo Documento Fiscal Emitido.';
			$logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$campos['idVenda']."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
            //********** GERA LOG DA VENDA                

            // RETORNO COM LINK DA NF
            $resConteudo = array('url_nf' => $tipoAmbiente.$resposta['caminho_danfe']);

        } else {
            logsDebugFocus($resVenda['ID_UNIDADE'],$resVenda['ID_VENDA'],json_encode($nfFull),$body);
        }

        // VALIDACAO FINAL                 
        if($atualizarVenda) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Documento Fiscal Emitido com Sucesso', 'conteudo'=>$resConteudo);
        } else {

            if(!empty($resposta['mensagem_sefaz'])) {
                $mensagemErroFocus = "[".$resposta['status_sefaz']."] ".$resposta['mensagem_sefaz'];
            } else {
                $mensagemErroFocus = $resposta['mensagem'];
            }

            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Não foi possível emitir nota fiscal.<br> Log de Erro - <b>Código: </b>'.$http_code.' <br>___________<br><pre class="text-left text-wrap">'.$mensagemErroFocus.'</pre>');

        }

        // RETORNO
        return $resultadoFinal;        

    }   
    
    //***** CANCELAR DOCUMENTO FISCAL
    public function documentoFiscal_Cancelar() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos         = $this->campos; 
        $QV_idUsuario   = $_SESSION['Authentication']['id_usuario'];
        $checkFinal     = false;
        $mensagemErro   = "";

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        //********** CONSULTA VENDA 
        $consultaVenda = mysqli_query($conexao, "SELECT * FROM PDV_vendas WHERE idVenda = '".$campos['idVenda']."' ");
        $resVenda = mysqli_fetch_array($consultaVenda); 
        
        //********** CONSULTA FRANQUIA
        $consultaFranquia = mysqli_query($conexao, "SELECT F.id AS ID_UNIDADE,  F.NF_token AS TOKEN
        FROM qv_franquias F 
        WHERE F.id = '".$resVenda['idUnidade']."' ");
        $resFranquia = mysqli_fetch_array($consultaFranquia);                
        
        // CANCELAR DOCUMENTOS FISCAIS SE HOUVEREM
        if($resVenda['status_nf'] == 'Emitida') {

            // Cancelamento da NFCe só pode ser feito em até 30min após emissão.
            // Substituir a variável, ref, pela sua identificação interna de nota.
            //$ref = str_pad($resVenda['idVenda'],6,0,STR_PAD_LEFT);
            $ref = $resVenda['nf_referencia'];

            // Dados de Autenticacao na Focus
            $login = $resFranquia['TOKEN'];
            $password = "";
            $NF_Token = base64_encode($login.":".$password);

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.focusnfe.com.br/v2/nfce/'.$ref,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_POSTFIELDS =>'{
                "justificativa": "Desistência por parte do cliente."
            }',
                CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . $NF_Token,
                'Content-Type: text/plain'
                ),
            ));
            
            $body = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);        
            curl_close($curl);
    
            $resposta = json_decode($body, true);
            
            // ATUALIZANDO VENDA
            if($resposta['status'] == 'cancelado' && $resposta['status_sefaz'] == 135) {

                // SQL UPDATE - ATUALIZAR HISTORICO
                $historicoFiscal = mysqli_query($conexao, "UPDATE PDV_documentosFiscais SET status = 'Cancelada', caminho_xml_cancelamento = '".$resposta['caminho_xml_cancelamento']."' WHERE referencia = '".$ref."' ORDER BY idDocumento DESC LIMIT 1 ");

                if($historicoFiscal) {

                    // SQL UPDATE - VENDA - NF
                    $atualizarVendaNF = mysqli_query($conexao, "UPDATE PDV_vendas SET status_nf = 'Cancelada' WHERE idVenda = '".$campos['idVenda']."' ");                    

                    if($atualizarVendaNF) {
                        $checkFinal = true;
                    } else {
                        $mensagemErro = 'Erro ao gerar atualizar status da emissão fiscal mas documento fiscal foi cancelado.';
                    }                 

                } else {
                    $mensagemErro = 'Erro ao gerar histórico fiscal mas documento fiscal foi cancelado.';
                }

            } else {
                $mensagemErro = $resposta['mensagem_sefaz'];
            }

        } else {
            $mensagemErro = 'Erro ao Cancelar Documento Fiscal. Contate o Suporte!';
        } 

        // VALIDACAO FINAL                 
        if($checkFinal) {

            //********** GERA LOG DA VENDA
			$logDescricao = 'Documento Fiscal Cancelado.';
			$logVenda = mysqli_query($conexao, "INSERT INTO PDV_vendasLogs (idVenda, idUsuario, descricao, ip, status, dataInsert) VALUES ('".$campos['idVenda']."', '".$QV_idUsuario."', '".$logDescricao."', '".$_SERVER['REMOTE_ADDR']."', 'Ativo', NOW())"); 
            //********** GERA LOG DA VENDA             

            // RESULTADO
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Documento Fiscal Cancelado com Sucesso');

        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }

        // RETORNO
        return $resultadoFinal;        

    }     

    //***** DOCUMENTO FISCAL - VISUALIZAR
    public function documentoFiscal_View() {  

        // VARIAVEIS RECEBIDAS
        $campos = $this->campos; 

        // ARMAZENA RESULTADOS
        $resConteudo = array();  
        $PHP_SESSION_ID = session_id();   
        $check_ssl = false;
        $verifyHost = false;           

        // CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $campos['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYPEER => $check_ssl, // Skip SSL Verification
            CURLOPT_SSL_VERIFYHOST => $verifyHost,
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID='.$PHP_SESSION_ID
            ),                    
        ));
        
        $body = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);        
        curl_close($curl);

        $resConteudo = $body;

        // VALIDACAO FINAL                 
        if($http_code == 200) {         
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Solicitação Realizada com Sucesso', 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro na sua solicitação. Contate o suporte!');
        }

        // RETORNO
        return $resultadoFinal;

    }

    //***** DOCUMENTO FISCAL - EXPORTAR XML
    public function documentoFiscal_ExportarXML() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");        

        // VARIAVEIS RECEBIDAS
        $campos             = $this->campos;
        $QV_idUnidade       = $this->idUnidade;
        $localArmazenamento = $_SERVER['DOCUMENT_ROOT'].'/assets/relatorios/';
        $listaArquivos      = array();
        $checkFinal         = false;
        $mensagemErro       = "";

        // ARMAZENA RESULTADOS
        $resConteudo = array(); 
        
        // SQL - SELECT 
        $consultaFranquia = mysqli_query($conexao, "SELECT * FROM qv_franquias WHERE id = '".$QV_idUnidade."' ");
        $resFranquia = mysqli_fetch_array($consultaFranquia);

        // SQL - SELECT | VENDAS
        $consulta = mysqli_query($conexao,"SELECT * FROM PDV_vendas WHERE idUnidade = '".$QV_idUnidade."' AND DATE(dataInsert) BETWEEN '".converterData($campos['dataDe'],'EN')."' AND '".converterData($campos['dataAte'],'EN')."' AND status_nf = 'Emitida' ");
        if(mysqli_num_rows($consulta) > 0) {

            // INICIA ZIP
            $zip        = new ZipArchive();
            $zip_name   = "XML_RELATORIO_" . $QV_idUnidade . "_" . time() . ".zip";

            // CRIA O ARQUIVO
            if($zip->open($localArmazenamento . $zip_name, ZipArchive::CREATE) !== TRUE) {
                $mensagemErro = "Desculpe... não foi possível compactar os arquivos XML. Contate o suporte.";
            } else {

                // PERCORRE RESULTADOS DA CONSULTA
                WHILE($resultado = mysqli_fetch_array($consulta)) {

                    // URL DO ARQUIVO
                    $url = "https://api.focusnfe.com.br/" . $resultado['caminho_xml_nota_fiscal'];

                    // CURL - DOWNLOAD
                    $ch             = curl_init($url);
                    $file_name      = "XML_" . basename($url);
                    $save_file_loc  = $localArmazenamento . $file_name;
                    $fp             = fopen($save_file_loc, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);      
                    
                    // ALIMENTA LISTA DE ARQUIVOS
                    array_push($listaArquivos,$file_name);
        
                }   
                
                // PERCORRER ARRAY DA LISTA DOS ARQUIVOS PARA COMPACTAR
                for($i=0;$i<COUNT($listaArquivos);$i++) {

                    // Moving files to zip.
                    $zip->addFromString(
                        $listaArquivos[$i], 
                        file_get_contents($localArmazenamento . $listaArquivos[$i])
                    );

                }
                $zip->close(); 

                // APAGAR ARQUIVOS BAIXADOS
                for($k=0;$k<COUNT($listaArquivos);$k++) {
                    $arquivo_ativo = $localArmazenamento . $listaArquivos[$k];
                    unlink($arquivo_ativo);
                }

                // CHECK FINAL
                $checkFinal = true;

                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {

                    //Server settings
                    $mail->setLanguage('pt', $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpmailer/phpmailer/language');
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host       = 'smtp.office365.com'; //Set the SMTP server to send through
                    $mail->SMTPAuth   = true; // Enable SMTP authentication
                    $mail->Username   = 'webmaster@quintavalentina.com.br'; //SMTP username
                    $mail->Password   = '!QVrp2021'; //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
                    $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    // Recipients
                    $mail->setFrom('webmaster@quintavalentina.com.br', utf8_decode('Quinta Valentina'));
                    $mail->addAddress($campos['emailContador']); // Add a recipient

                    // Attachments
                    $mail->addAttachment($localArmazenamento . $zip_name); // Add attachments

                    // Content
                    $options_htmlToText = array('ignore_errors' => true);                    
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject      = utf8_decode('Relatório de XMLs');
                    $replacements 		= array(
                        '({RAZAO_SOCIAL})'  => utf8_decode($resFranquia['razao_social']),
                        '({CNPJ})'          => utf8_decode(maskPHP(limpar($resFranquia['cnpj']),'##.###.###/####-##')),
                        '({EMAIL})'         => utf8_decode($resFranquia['email']),
                        '({OBSERVACOES})'   => utf8_decode($campos['observacoes'])
                    );
                    $templateMensagem 	= utf8_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/assets/template_email/emkt_contador_xml.php'));
                    $templateMensagem 	= preg_replace(array_keys($replacements), array_values($replacements), $templateMensagem);

                    // PLAIN TEXT
                    $mensagemSimples    = \Soundasleep\Html2Text::convert($templateMensagem, $options_htmlToText);       

                    $mail->Body    		= $templateMensagem;
                    $mail->AltBody 		= $mensagemSimples;	

                    $mail->send();
                    //echo 'Message has been sent';

                } catch (Exception $e) {
                    logDebug("ERRO NO ENVIAR EMAIL CONTADOR - " . $mail->ErrorInfo);
                }                

            }

        } else {
            $mensagemErro = "Não foi encontrado XMLs para gerar o relatório.";
        }

        // VALIDACAO FINAL                 
        if($checkFinal) {         
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Solicitação Realizada com Sucesso', 'conteudo' => $zip_name);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }

        // RETORNO
        return $resultadoFinal;

    }    
    
    //***** VENDAS | HISTORICO | LOGS
    public function vendasHistorico() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $campos         = $this->campos;
        $QV_idUnidade   = $this->idUnidade; 

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL SELECT - CONSULTA LOGS
        $consulta = mysqli_query($conexao, "
            SELECT VL.idLog AS LOG_ID, VL.idVenda AS VENDA_ID, VL.descricao AS DESCRICAO, VL.dataInsert AS DATA_CRIACAO, U.display_name AS USUARIO 
            FROM PDV_vendasLogs VL
            INNER JOIN users U ON U.id = VL.idUsuario
            WHERE VL.idVenda = '".$campos['idVenda']."' AND VL.status = 'Ativo' 
        ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        if(mysqli_num_rows($consulta) > 0) {
            WHILE($resultado = mysqli_fetch_array($consulta)) {
                $resConteudo['ITENS'][] = array(
                    'id'            => $resultado['LOG_ID'], 
                    'usuario'       => $resultado['USUARIO'], 
                    'descricao'     => $resultado['DESCRICAO'], 
                    'data_criacao'  => converterData($resultado['DATA_CRIACAO'],'COMPLETA')
                );
            }  
        }
  
        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Histórico Encontrado com Sucesso', 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Buscar Histórico. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }        
    
    //***** CONSULTA DADOS DA VENDA
    public function consultaVenda() {  

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos = $this->campos;

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT DADOS VENDA E CLIENTE
        // LEFT JOIN vendedores por causa do QV em Casa
        $consulta = mysqli_query($conexao, "
            SELECT V.idVenda AS ID_VENDA, V.tipoDesconto AS TIPO_DESCONTO, V.desconto AS DESCONTO, V.totalBruto AS TOTAL_BRUTO, V.totalLiquido AS TOTAL_LIQUIDO, V.nf_numero AS NF_NUMERO, V.caminho_danfe AS URL_NF, V.status_nf AS NF_STATUS, C.idCliente AS ID_CLIENTE, C.nome AS NOME, C.nascimento AS NASCIMENTO, C.cpf AS CPF, C.sexo AS SEXO, C.telefone01 AS TELEFONE, C.email AS EMAIL, C.tamanho AS TAMANHO, DATE(V.dataInsert) AS DATA_CRIACAO, V.idUsuario AS VENDEDOR_ID, V2.nomeExibicao AS VENDEDOR, V.observacoes AS OBSERVACOES, V.status AS STATUS
            FROM PDV_vendas V
            INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente
            LEFT JOIN PDV_vendedores V2 ON V2.idVendedor = V.idUsuario
            WHERE V.idVenda = '".$campos['idVenda']."' AND V.idUnidade = ".$campos['idUnidade']." AND V.dataDelete IS NULL");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {         

            // MONTANDO ARRAY DE RESULTADOS
            $resConteudo['VENDA'] = array(
                'id'            => $resultado['ID_VENDA'], 
                'idCliente'     => $resultado['ID_CLIENTE'],
                'nome'          => $resultado['NOME'],
                'email'         => $resultado['EMAIL'],
                'telefone'      => limpar($resultado['TELEFONE']),
                'nascimento'    => (empty($resultado['NASCIMENTO']) ? false : converterData($resultado['NASCIMENTO'],"BR")),
                'cpf'           => limpar($resultado['CPF']),
                'sexo'          => $resultado['SEXO'],
                'tamanho'       => $resultado['TAMANHO'],
                'tipoDesconto'  => $resultado['TIPO_DESCONTO'],
                'desconto'      => $resultado['DESCONTO'],
                'totalBruto'    => $resultado['TOTAL_BRUTO'],
                'totalLiquido'  => $resultado['TOTAL_LIQUIDO'],
                'nfNumero'      => $resultado['NF_NUMERO'],
                'nfURL'         => $resultado['URL_NF'],
                'nfStatus'      => $resultado['NF_STATUS'],
                'dataVenda'     => converterData($resultado['DATA_CRIACAO'],'BR'),
                'vendedor'      => $resultado['VENDEDOR'],
                'vendedor_id'   => $resultado['VENDEDOR_ID'],
                'observacoes'   => $resultado['OBSERVACOES'],
                'status'        => $resultado['STATUS']
            );

        }

        // SQL - SELECT DADOS DE PAGAMENTO
        $consultaDadosPagamento = mysqli_query($conexao, 
            "SELECT VFP.idFormaPagamento AS ID_FORMA_PAGAMENTO, VFP.tipo AS METODO_PAGAMENTO, VFP.condicao AS FORMA_PAGAMENTO, VFP.parcelas AS PARCELAS, VP.dataVencimento AS VENCIMENTO, SUM(VP.valor) AS VALOR
            FROM PDV_vendasFormasPagamento VFP
            LEFT JOIN PDV_vendasParcelas VP ON VP.idFormaPagamento = VFP.idFormaPagamento
            WHERE VFP.idVenda = '".$campos['idVenda']."' AND VFP.status = 'Ativo' GROUP BY VP.idFormaPagamento ORDER BY VENCIMENTO ASC");
        WHILE($resDadosPagamento = mysqli_fetch_array($consultaDadosPagamento)) {         

            // MONTANDO ARRAY DE RESULTADOS
            $resConteudo['DADOS_PAGAMENTO'][] = array(
                'id'              => $resDadosPagamento['ID_FORMA_PAGAMENTO'], 
                'metodoPagamento' => $resDadosPagamento['METODO_PAGAMENTO'],
                'formaPagamento'  => $resDadosPagamento['FORMA_PAGAMENTO'],
                'parcelas'        => $resDadosPagamento['PARCELAS'],
                'valor'           => $resDadosPagamento['VALOR'],
                'vencimento'      => converterData($resDadosPagamento['VENCIMENTO'],'BR')
            );

        }        

        // CONSULTA PRODUTOS DA VENDA
        $consultaProdutos = mysqli_query($conexao, "SELECT VP.idItem AS ID_ITEM, VP.idProduto AS ID_PRODUTO, VP.tamanho AS TAMANHO, VP.preco AS PRECO, VP.precoTotal AS PRECO_TOTAL, VP.sku AS SKU, VP.quantidade AS QUANTIDADE, VP.cor AS COR
                                FROM PDV_vendasProdutos VP
                                WHERE VP.idVenda = '".$campos['idVenda']."' AND VP.status = 'Ativo' AND VP.dataDelete IS NULL");
        if(mysqli_num_rows($consultaProdutos) > 0) {
            WHILE($resProd = mysqli_fetch_array($consultaProdutos)) {

                // CONSULTA DADOS DO PRODUTO
                $prodInfo = qvProdutosInfo_Intranet($resProd['ID_PRODUTO']);

                // GRADE DO PRODUTO
                if($campos['idUnidade'] == 573) {
                    $produto_grade = intranetEstoqueGrade($resProd['ID_PRODUTO'],$resProd['TAMANHO']);
                } else {
                    $produto_grade = vitrineEstoqueGrade($resProd['ID_PRODUTO'],$campos['idUnidade'],$resProd['TAMANHO']);
                }                  

                // ARRAY
                $resConteudo['PRODUTOS'][] = array(
                    'id'            => $resProd['ID_PRODUTO'], 
                    'idItem'        => $resProd['ID_ITEM'], 
                    'nome'          => $prodInfo['NOME'],
                    'slug'          => $prodInfo['SLUG'],
                    'sku'           => $resProd['SKU'],
                    'cor'           => $resProd['COR'],
                    'tamanho'       => $resProd['TAMANHO'],
                    'quantidade'    => $resProd['QUANTIDADE'],
                    'estoque'       => $produto_grade,
                    'preco'         => $resProd['PRECO'],
                    'precoTotal'    => $resProd['PRECO_TOTAL'],
                    'foto'          => $prodInfo['FOTO']
                );
            }
        }   
        
        // SQL - SELECT VENDEDORES
        $consultaVendedores = mysqli_query($conexao, "SELECT * FROM PDV_vendedores V WHERE V.idUnidade = '".$campos['idUnidade']."' ");
        WHILE($resVendedores = mysqli_fetch_array($consultaVendedores)) {         

            // MONTANDO ARRAY DE RESULTADOS
            $resConteudo['VENDEDORES'][] = array(
                'id'   => $resVendedores['idVendedor'], 
                'nome' => $resVendedores['nomeExibicao']
            );

        }          

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!', 'erro'=>$erro);
        }

        // RETORNO
        return $resultadoFinal;        

    }  
    
    //***** BUSCADOR DE PRODUTOS - NOME OU SKU BIPE
    public function buscador_produtos() {

        // BANCO DADOS 
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos = $this->campos;  
        $QV_idUnidade = $this->idUnidade;  
        $checkFinal = false;  
        $mensagemErro = "";  
        $mensagemRetorno = "";  

        // ARMAZENA RESULTADOS
        $resConteudo = array();        

        // CHECANDO PARAMETRO - BUSCANDO PELO BIPE DO SKU
        if($campos['parametro'] == 'sku') {

            // CONSULTA SKU PARA DESCOBRIR ID PRODUTO E GRADE
            $consultaSKU = mysqli_query($conexao,"SELECT PG.produto_id AS PRODUTO_ID, G.codigo AS GRADE, P.preco_sellout AS PRECO 
            FROM qv_produtos_grades PG 
            INNER JOIN qv_grades G ON G.id = PG.grade_id
            INNER JOIN qv_produtos P ON P.id = PG.produto_id
            WHERE PG.codigo = '".$campos['termo']."' ");

            if(mysqli_num_rows($consultaSKU) > 0) {

                $resSKU = mysqli_fetch_array($consultaSKU);
        
                // CHECANDO ESTOQUE
                $consultaEstoque = mysqli_query($conexao, "SELECT COALESCE(SUM(quantidade),0) AS TOTAL 
                FROM PDV_estoque
                WHERE idProduto = '".$resSKU['PRODUTO_ID']."' AND tamanho = '".$resSKU['GRADE']."' AND status = 'Ativo' AND idUnidade = '".$QV_idUnidade."' ");
                $resEstoque = mysqli_fetch_array($consultaEstoque); 
                
                if($consultaEstoque) {

                    if($resEstoque['TOTAL'] > 0) {

                        // CONSULTA DADOS DO PRODUTO
                        $conProd = mysqli_query($conexao,"SELECT id, nome, cor_id, preco_custo, preco_sellout, preco_sellin FROM qv_produtos WHERE id = '".$resSKU['PRODUTO_ID']."' ");
                        $resProd = mysqli_fetch_array($conProd);

                        // GERANDO IMAGEM
                        $produto_foto = qvImagens_Intranet($resSKU['PRODUTO_ID']);

                        // POPULANDO RESULTADOS
                        $resConteudo['RESULTADOS'] = 1;
                        $resConteudo['ITENS'][] = array(
                            'id'        => $resProd['id'],
                            'nome'      => $resProd['nome'],
                            'cor_id'    => $resProd['cor_id'],
                            'sku'       => $campos['termo'],
                            'preco'     => $resProd['preco_sellout'],
                            'estoque'   => $resEstoque['TOTAL'],
                            'tamanho'   => $resSKU['GRADE'],
                            'foto'      => $produto_foto[0]
                        );

                        $checkFinal = true;

                    } else {
                        $mensagemErro = "Não Há Saldo para este Produto.";
                    }              
        
                } else {
                    $mensagemErro = "Problema ao Consultar este SKU. Contate o Suporte.";
                }            

            } else {
                $checkFinal = true;
                $mensagemRetorno = "Nada Encontrado";
            }            

        // CHECANDO PARAMETRO - BUSCANDO PELO TERMO DIGITADO
        } else {

            // SQL SELECT - CHECANDO ESTOQUE
            $consultaEstoque = mysqli_query($conexao, "SELECT P.id AS ID_PRODUTO, CONCAT(P.nome,' (',E.tamanho,')') AS NOME, P.cor_id AS COR_ID, P.preco_custo AS PRECO_CUSTO, P.preco_sellout AS PRECO_SELLOUT, P.preco_sellin AS PRECO_SELLIN, E.tamanho AS GRADE, COALESCE(SUM(E.quantidade),0) AS SALDO_TOTAL 
            FROM PDV_estoque E 
            INNER JOIN qv_produtos P ON P.id = E.idProduto
            WHERE P.nome_comercial LIKE '%".$campos['termo']."%' AND E.status = 'Ativo' AND E.idUnidade = '".$QV_idUnidade."' GROUP BY E.tamanho HAVING SALDO_TOTAL > 0 ORDER BY P.nome, E.tamanho ASC ");
            $resConteudo['RESULTADOS'] = mysqli_num_rows($consultaEstoque);
            if($resConteudo['RESULTADOS'] > 0) {
                WHILE($resEstoque = mysqli_fetch_array($consultaEstoque)) {

                    // GERANDO IMAGEM
                    $produto_foto = qvImagens_Intranet($resEstoque['ID_PRODUTO']);

                    // GERANDO SKU
                    $sku = geradorSKU($resEstoque['ID_PRODUTO'],$resEstoque['GRADE']);

                    // POPULANDO RESULTADOS
                    $resConteudo['ITENS'][] = array(
                        'id'        => $resEstoque['ID_PRODUTO'],
                        'nome'      => $resEstoque['NOME'],
                        'cor_id'    => $resEstoque['COR_ID'],
                        'sku'       => $sku,
                        'preco'     => $resEstoque['PRECO_SELLOUT'],
                        'estoque'   => $resEstoque['SALDO_TOTAL'],
                        'tamanho'   => $resEstoque['GRADE'],
                        'foto'    => $produto_foto[0]
                    );

                    $checkFinal = true;

                }  
            } else {
                $checkFinal = true;
                $mensagemRetorno = "Nada Encontrado";
            }


        }
        
        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem' => $mensagemRetorno, 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    }
    
    //***** VENDAS | VENDEDORES | CREATE
    public function vendedoresCreate() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $campos         = $this->campos;
        $QV_idUnidade   = $this->idUnidade; 

        // SQL INSERT - CRIAR VENDEDOR
        $adicionar = mysqli_query($conexao, "INSERT INTO PDV_vendedores (idUnidade, nome, nomeExibicao, dataInsert) VALUES ('".$QV_idUnidade."', '".$campos['nome']."', '".$campos['nomeExibicao']."', NOW())");          
        
        // VALIDACAO FINAL                 
        if($adicionar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Vendedor Criado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Cadastrar Vendedor. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }   
    
    //***** VENDAS | VENDEDORES | UPDATE
    public function vendedoresUpdate() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $campos         = $this->campos;
        $QV_idUnidade   = $this->idUnidade; 

        // SQL UPDATE - ATUALIZA VENDEDOR
        $atualizar = mysqli_query($conexao, "UPDATE PDV_vendedores SET nome = '".$campos['nome']."', nomeExibicao = '".$campos['nomeExibicao']."', status = '".$campos['status']."' WHERE idVendedor = ".$campos['idVendedor']." ");       
        
        // VALIDACAO FINAL                 
        if($atualizar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Vendedor Atualizado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Atualizar Vendedor. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }   

    //***** VENDAS | VENDEDORES | SELECT
    public function vendedoresSelect() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $campos         = $this->campos;
        $QV_idUnidade   = $this->idUnidade; 

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL - SELECT
        $consulta = mysqli_query($conexao, "SELECT * FROM PDV_vendedores WHERE idVendedor = '".$campos['idVendedor']."' AND idUnidade = '".$QV_idUnidade."' ");
        WHILE($resultado = mysqli_fetch_array($consulta)) {
            $resConteudo = array('nome' => $resultado['nome'], 'nomeExibicao' => $resultado['nomeExibicao'], 'status' => $resultado['status']);
        }    
        
        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Vendedor Encontrado com Sucesso', 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Buscar Vendedor. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }    

    //***** VENDAS | VENDEDORES | LIST
    public function vendedoresList() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // RECEBE VARIAVEIS
        $campos         = $this->campos;
        $QV_idUnidade   = $this->idUnidade; 
        $QV_nomeUsuario = $_SESSION['Authentication']['nome'];

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        consultaUsuarios:
        // SQL - SELECT
        $consulta = mysqli_query($conexao, "SELECT * FROM PDV_vendedores WHERE idUnidade = '".$QV_idUnidade."' AND status = 'Ativo' ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        if(mysqli_num_rows($consulta) > 0) {
            WHILE($resultado = mysqli_fetch_array($consulta)) {
                $resConteudo['ITENS'][] = array('id' => $resultado['idVendedor'], 'nome' => $resultado['nome'], 'nomeExibicao' => $resultado['nomeExibicao'], 'status' => $resultado['status']);
            }  
        } else {

            // SQL INSERT - CRIAR VENDEDOR COM NOME DA FRANQUIA
            $adicionar = mysqli_query($conexao, "INSERT INTO PDV_vendedores (idUnidade, nome, nomeExibicao, dataInsert) VALUES ('".$QV_idUnidade."', '".$QV_nomeUsuario."', '".$QV_nomeUsuario."', NOW())"); 
            
            if($adicionar) {
                goto consultaUsuarios;
            }

        }
  
        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Vendedores Encontrados com Sucesso', 'conteudo' => $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Buscar Vendedores. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;

    }        
    
}
