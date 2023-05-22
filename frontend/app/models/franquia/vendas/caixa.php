<?php   
/******************************************************************************/
/********************************* CAIXA **************************************/
/******************************************************************************/
class QV_Caixa {

    function __construct($campos,$idUnidade = false){
        if($campos) { $this->campos = (isset($campos) ? $campos : false); }
        if($idUnidade || $idUnidade == 0) { $this->idUnidade = (isset($idUnidade) ? $idUnidade : false); }
    }     

    //***** ABRIR CAIXA
    public function caixaAbrir() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";    

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // SQL SELECT - VERIFICA SE EXISTE CAIXA ABERTO
        $consulta = mysqli_query($conexao,"SELECT * FROM PDV_caixa WHERE idUnidade = '".$QV_idUnidade."' AND status = 'Aberto' ");
        if(mysqli_num_rows($consulta) > 0) {

            $mensagemRetorno = "Existe um ou mais caixas abertos.";

        } else {

            // TRATANDO DECIMAL
            $saldoInicial = number_format(preg_replace('/[^0-9]/s', "", $campos['saldoInicial'])/100,2,".","");

            // SQL INSERT - PRODUTO AO CARRINHO
            $adicionar = mysqli_query($conexao, "INSERT INTO PDV_caixa (idUnidade, idUsuario, saldoInicial, dataInsert) VALUES ('".$QV_idUnidade."', '".$QV_idUsuario."', '".$saldoInicial."', NOW())");
            
            if($adicionar) {

                // CAPTURA ID GERADO
                $idCaixa = mysqli_insert_id($conexao);

                // SQL INSERT - MOVIMENTACAO
                $adicionarMovimentacao = mysqli_query($conexao, "INSERT INTO PDV_caixaMovimentacoes (idCaixa, idUsuario, natureza, tipo, valor, dataInsert) VALUES ('".$idCaixa."', '".$QV_idUsuario."', 'Entrada', 'Saldo Inicial', '".$saldoInicial."', NOW())");                

                if($adicionarMovimentacao) {
                    $checkFinal = true;
                } else {
                    $mensagemRetorno = "Falha ao gerar movimentação do caixa. Contate o suporte.";
                }

            } else {
                $mensagemRetorno = "Falha ao tentar abrir caixa. Contate o suporte.";
            }

        }
        
        // VALIDACAO FINAL                 
        if($checkFinal) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Caixa Aberto com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>$mensagemRetorno);
        }         

        // RETORNO
        return $resultadoFinal;        

    }  

    //***** MOVIMENTACOES DO CAIXA
    public function caixaMovimentacoes() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";     

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // SQL SELECT - MOVIMENTACOES
        $consulta = mysqli_query($conexao,
            "SELECT CM.idMovimentacao AS ID_MOVIMENTACAO, CM.idCaixa AS ID_CAIXA, U.display_name AS USUARIO, DATE(CM.dataInsert) AS DATA_CRIACAO, CM.natureza AS NATUREZA, CM.tipo AS TIPO, CM.valor AS VALOR, C.status AS STATUS  
            FROM PDV_caixaMovimentacoes CM
            INNER JOIN PDV_caixa C ON C.idCaixa = CM.idCaixa
            INNER JOIN users U ON U.id = CM.idUsuario
            WHERE CM.idCaixa = '".$campos['idCaixa']."' AND CM.status = 'Ativo' ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        if(mysqli_num_rows($consulta) > 0) {
            WHILE($resultado = mysqli_fetch_array($consulta)) {

                $resConteudo['ITENS'][] = array(
                    'id'            => $resultado['ID_MOVIMENTACAO'],
                    'idCaixa'       => $resultado['ID_CAIXA'],
                    'data_criacao'  => converterData($resultado['DATA_CRIACAO'],'BR'),
                    'usuario'       => $resultado['USUARIO'],
                    'natureza'      => $resultado['NATUREZA'],
                    'tipo'          => $resultado['TIPO'],
                    'valor'         => $resultado['VALOR'],
                    'status'        => $resultado['STATUS']
                );    

            }
            
        }
        
        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=> $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro em sua solicitação. Contate o Suporte.');
        }         

        // RETORNO
        return $resultadoFinal;        

    }   

    //***** MOVIMENTACOES DO CAIXA | NOVA
    public function caixaMovimentacoesNova() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";    

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // TRATANDO DECIMAL
        $valorMovimentacao = number_format(preg_replace('/[^0-9]/s', "", $campos['valor'])/100,2,".","");

        // SQL INSERT - MOVIMENTACAO
        $adicionarMovimentacao = mysqli_query($conexao, "INSERT INTO PDV_caixaMovimentacoes (idCaixa, idUsuario, natureza, tipo, valor, observacoes, dataInsert) VALUES ('".$campos['idCaixa']."', '".$QV_idUsuario."', '".$campos['natureza']."', '".$campos['tipo']."', '".$valorMovimentacao."', '".anti_injection($campos['observacoes'])."', NOW())");
        
        // VALIDACAO FINAL
        if($adicionarMovimentacao) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Movimentação Criada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro em sua solicitação. Contate o suporte.');
        }         

        // RETORNO
        return $resultadoFinal;        

    }    
    
    //***** MOVIMENTACOES DO CAIXA | APAGAR
    public function caixaMovimentacoesApagar() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";     

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // SQL UPDATE - DELETE MOVIMENTACOES
        $apagar = mysqli_query($conexao, "UPDATE PDV_caixaMovimentacoes SET status = 'Inativo', dataDelete = NOW() WHERE idCaixa = '".$campos['idCaixa']."' AND idMovimentacao = '".$campos['idMovimentacao']."' ");
        
        // VALIDACAO FINAL                 
        if($apagar) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Movimentação Apagada com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro em sua solicitação. Contate o Suporte.');
        }         

        // RETORNO
        return $resultadoFinal;        

    } 

    //***** CAIXA - FECHAMENTO CONSULTA
    public function caixaFechamento_Consulta() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";     

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // SQL SELECT - CONSULTA CAIXA
        $consulta = mysqli_query($conexao,"SELECT * FROM PDV_caixa WHERE idCaixa = '".$campos['idCaixa']."' ");
        $resultado = mysqli_fetch_array($consulta);

        // SQL SELECT - MOVIMENTACOES SOMATORIAS
        $consultaMovimentacoes = mysqli_query($conexao,
            "SELECT 
                COALESCE(sum(CASE WHEN ( natureza = 'Entrada' AND tipo = 'Suprimento' ) THEN valor ELSE 0 END),0) AS SUPRIMENTOS,
                COALESCE(sum(CASE WHEN ( natureza = 'Saída' AND tipo = 'Sangria' ) THEN valor ELSE 0 END),0) AS SANGRIA
            FROM PDV_caixaMovimentacoes
            WHERE idCaixa = '".$campos['idCaixa']."' AND status = 'Ativo' ");
            $resMovimentacoes = mysqli_fetch_array($consultaMovimentacoes);

        // SQL SELECT - VENDAS
        $consultaVendas = mysqli_query($conexao,
            "SELECT 
                COALESCE(sum(CASE WHEN ( VFP.tipo IN('Dinheiro','Cheque')  ) THEN VP.valor ELSE 0 END),0) AS TOTAL_LIQUIDO
            FROM PDV_vendas V
            INNER JOIN PDV_vendasFormasPagamento VFP ON VFP.idVenda = V.idVenda
            INNER JOIN PDV_vendasParcelas VP ON VP.idFormaPagamento = VFP.idFormaPagamento
            WHERE V.idUnidade = '".$QV_idUnidade."' AND DATE(V.dataInsert) = '".extrairData($resultado['dataInsert'])."' AND V.status = 'Concluída' AND VFP.status = 'Ativo' AND VP.status = 'Paga' ");
            $resVendas = mysqli_fetch_array($consultaVendas);

        // SQL SELECT - CONSULTA USUARIO
        $consultaUsuario = mysqli_query($conexao,"SELECT * FROM users WHERE id = '".$resultado['idUsuario']."' ");
        $resUsuario = mysqli_fetch_array($consultaUsuario);

        // POPULANDO RESULTADOS
        $resConteudo = array(
            'idCaixa'       => $resultado['idCaixa'],
            'data_abertura' => converterData(extrairData($resultado['dataInsert']),'BR'),
            'saldoInicial'  => $resultado['saldoInicial'],
            'suprimentos'   => $resMovimentacoes['SUPRIMENTOS'],
            'sangrias'      => $resMovimentacoes['SANGRIA'],
            'vendas'        => $resVendas['TOTAL_LIQUIDO'],
            'usuario'       => $resUsuario['display_name'],
            'total'         => ($resultado['saldoInicial'] + $resMovimentacoes['SUPRIMENTOS'] + $resVendas['TOTAL_LIQUIDO']) - $resMovimentacoes['SANGRIA'] 
        );    
            
        // VALIDACAO FINAL                 
        if(!empty($resConteudo)) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=> $resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro em sua solicitação. Contate o Suporte.');
        }         

        // RETORNO
        return $resultadoFinal;        

    }    
    
    //***** CAIXA | FECHAR
    public function caixaFechar() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS / IMPORTANTES
        $QV_idUnidade    = $this->idUnidade;
        $QV_idUsuario    = $_SESSION['Authentication']['id_usuario'];
        $campos          = $this->campos;  
        $checkFinal      = false; 
        $mensagemRetorno = "";     

        // ARMAZENA RESULTADOS
        $resConteudo = array();  

        // TRATANDO DECIMAL
        $saldoCaixa = number_format(preg_replace('/[^0-9]/s', "", $campos['saldoCaixa'])/100,2,".","");

        // SQL UPDATE - FECHAR CAIXA
        $fecharCaixa = mysqli_query($conexao, "UPDATE PDV_caixa SET status = 'Fechado', diferenca = '".($saldoCaixa - $campos['saldoFinal'])."', saldoFinal = '".$campos['saldoFinal']."', saldoCaixa = '".$saldoCaixa."', dataFechamento = NOW() WHERE idCaixa = '".$campos['idCaixa']."' ");
        
        // VALIDACAO FINAL                 
        if($fecharCaixa) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Caixa Fechado com Sucesso');
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> 'Erro em sua solicitação. Contate o Suporte.');
        }         

        // RETORNO
        return $resultadoFinal;        

    }     
    
}
?>