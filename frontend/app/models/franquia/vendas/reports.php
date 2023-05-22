<?php  
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;    
/******************************************************************************/
/****************************** PRODUTOS **************************************/
/******************************************************************************/
class QV_Reports { 
    
    function __construct($idUnidade, $campos = false){
        if($campos) {
            $this->campos = (isset($campos) ? $campos : false);
        }
        if($idUnidade || $idUnidade == 0) {
            $this->idUnidade = (isset($idUnidade) ? $idUnidade : false);
        }        
    }        

    //***** CONSULTA DE CATEGORIAS
    public function vendedoresList() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS IMPORTANTES
        $QV_idUnidade = $this->idUnidade; 

        // ARMAZENA RESULTADOS
        $resConteudo = array();

        // SQL SELECT - VENDEDORES DA UNIDADE
        $consulta = mysqli_query($conexao, "SELECT * FROM PDV_vendedores WHERE idUnidade = '".$QV_idUnidade."' AND status = 'Ativo' ");
        $resConteudo['RESULTADOS'] = mysqli_num_rows($consulta);
        WHILE($resultado = mysqli_fetch_array($consulta)) {
            $resConteudo['ITENS'][] = array('id' => $resultado['idVendedor'], 'nome' => $resultado['nomeExibicao']);
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
    
    //***** DADOS DESEMPENHO VENDEDOR
    public function vendedorDesempenho() {

        // BANCO DADOS
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS IMPORTANTES
        $QV_idUnidade   = $this->idUnidade; 
        $campos         = $this->campos; 

        // ARMAZENA RESULTADOS
        $resConteudo = array('qtd_vendas' => 0, 'qtd_produtos' => 0, 'faturamento' => 0);

        // TRATANDO STATUS
        if($campos['status'] != "0") {
            //$queryStatus = ' AND(V.status = "'.$campos['status'].'" AND V.status != "Deletada")  ';
            $queryStatus = ' AND(V.status = "Concluída")  ';
        } else {
            $queryStatus = '';
        }        

        // SQL SELECT - DADOS VENDEDOR
        $consulta = mysqli_query($conexao, 
            "SELECT 
                COUNT(V.idVenda) AS TOTAL,
                COALESCE(sum(CASE WHEN ( V.totalLiquido > 0  ) THEN V.totalLiquido ELSE 0 END),0) AS FATURAMENTO
            FROM PDV_vendas V
            WHERE V.idUnidade = '".$QV_idUnidade."' AND V.idUsuario = '".$campos['idVendedor']."' AND DATE(V.dataInsert) BETWEEN '".converterData($campos['dataDe'],'EN')."' AND '".converterData($campos['dataAte'],'EN')."' ".$queryStatus." ");
        $resultado = mysqli_fetch_array($consulta);

        // SQL SELECT - QTD PRODUTOS
        $consultaQtdProdutos = mysqli_query($conexao, 
        "SELECT 
            COALESCE(sum(CASE WHEN ( VP.quantidade > 0 ) THEN VP.quantidade ELSE 0 END),0) AS TOTAL_PRODUTOS
        FROM PDV_vendas V
        INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda
        INNER JOIN PDV_vendedores VE ON VE.idVendedor = V.idUsuario
        WHERE 
            DATE(V.dataInsert) BETWEEN '".converterData($campos['dataDe'],'EN')."' 
            AND '".converterData($campos['dataAte'],'EN')."' 
            AND V.idUnidade = '".$QV_idUnidade."' AND V.idUsuario = '".$campos['idVendedor']."'
            AND V.status = 'Concluída' AND  VP.status = 'Ativo'
        ");
        $resQtdProdutos = mysqli_fetch_array($consultaQtdProdutos);         

        // POPULANDO RESULTADOS
        $resConteudo = array(
            'qtd_vendas'    => $resultado['TOTAL'], 
            'qtd_produtos'  => $resQtdProdutos['TOTAL_PRODUTOS'], 
            'faturamento'   => $resultado['FATURAMENTO']
        );

        // VALIDACAO FINAL                 
        if($consulta) {
            $resultadoFinal = array('resultado'=>true, 'mensagem'=>'Consulta Realizada com Sucesso', 'conteudo'=>$resConteudo);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=>'Erro ao Realizar Consulta. Contate o Suporte!');
        }        

        // RETORNO
        return $resultadoFinal;        

    }   
    
    //***** REPORTS - RELATORIO DE VENDAS EXCEL
    public function relatorioExcel() {        
        
        // INICIA O PLUGIN
        $spreadsheet = new Spreadsheet();        

        // BANCO DADOS 
        $conexao = bancoDados("conectar","intranet");

        // VARIAVEIS RECEBIDAS
        $campos = $this->campos;  
        $QV_idUnidade = $this->idUnidade;  
        $checkFinal = false;  
        $mensagemErro = "";  
        $mensagemRetorno = "";    

        /*** DEFINE METADATA DA PLANILHA ***/
        $spreadsheet->getProperties()
        ->setCreator("QUINTA VALENTINA")
        ->setLastModifiedBy("QV")
        ->setTitle("Relatório Vendas")
        ->setSubject("Vendas Realizadas")
        ->setDescription(
            "Relatório de Vendas Gerado pelo Sistema."
        )
        ->setKeywords("qv, quinta valentina, vendas")
        ->setCategory("VENDAS");

        // DEFINE PLANILHA ATIVA E A SELECIONA
        $sheet = $spreadsheet->getActiveSheet();  

        //********** TRATAR DADOS POST

        // DATAS
        if(empty($campos['dataDe'])) {
            $dataAtual = date("Y-m-d");
            $dataDe = date('Y-m-d', strtotime('-30 days', strtotime($dataAtual)));
        } else { $dataDe = converterData(anti_injection($campos['dataDe']),"EN"); }

        if(empty($campos['dataAte'])) { $dataAte = date("Y-m-d"); } else {
            $dataAte = converterData(anti_injection($campos['dataAte']),"EN");
        }
        $queryPeriodo = ' DATE(V.dataInsert) BETWEEN "'.$dataDe.'" AND "'.$dataAte.'" ';  
        
        // UNIDADE
        $queryUnidade = ' AND V.idUnidade = "'.$QV_idUnidade.'"  ';
            
        // TIPO RELATORIO
        if($campos['tipoRelatorio'] == 'simples') {

            $queryComplemento = ' AND V.dataDelete IS NULL ';
            //$queryComplemento = ' AND V.dataDelete IS NULL AND V.status NOT IN ("Cancelada", "Deletada")  AND VP.status = "Ativo" ';

            $queryStatus      = ' AND V.status = "Concluída" ';

            $queryFinal       = $queryPeriodo.$queryStatus.$queryUnidade.$queryComplemento;
            
            // SQL SELECT
            $query = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA, V.idUnidade AS ID_UNIDADE, C.nome AS NOME, C.telefone01 AS TELEFONE01, C.email AS EMAIL, V.totalLiquido AS TOTAL, V.status AS STATUS, V.nf_numero AS DOCUMENTO_FISCAL, V.tipoDesconto AS TIPO_DESCONTO, V.desconto AS DESCONTO, VD.nome AS VENDEDOR
            FROM PDV_vendas V
            INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente 
            LEFT JOIN PDV_vendedores VD ON VD.idVendedor = V.idUsuario
            WHERE ".$queryFinal." ";

            $result = mysqli_query($conexao,$query);
            $i = 1;      

            //Define os cabeçalhos
            $sheet->setCellValue('A1', "DATA_VENDA");
            $sheet->setCellValue('B1', "CLIENTE");
            $sheet->setCellValue('C1', "TELEFONE #1");        
            $sheet->setCellValue('D1', "QUANTIDADE");
            $sheet->setCellValue('E1', "TIPO_DESCONTO");
            $sheet->setCellValue('F1', "TOTAL_DESCONTO");
            $sheet->setCellValue('G1', "TOTAL_VENDA");
            $sheet->setCellValue('H1', "STATUS");
            $sheet->setCellValue('I1', "VENDEDOR");
            $sheet->setCellValue('J1', "DOCUMENTO_FISCAL");
            

            // WHILE - POPULANDO PLANILHA
            while($row = mysqli_fetch_assoc($result)){
                $i++;           

                // CALCULANDO QTD PARES
                $consultaPares = mysqli_query($conexao, "SELECT SUM(quantidade) AS TOTAL FROM PDV_vendasProdutos WHERE idVenda = ".$row["ID_VENDA"]." AND status = 'Ativo' ");
                $resPares = mysqli_fetch_array($consultaPares);

                // CONSULTA UNIDADE
                $consultaUnidade = mysqli_query($conexao, "SELECT QV.id AS ID_UNIDADE, QV.nome_exibicao AS NOME FROM qv_franquias AS QV WHERE id = ".$row["ID_UNIDADE"]." ");
                $resultadoUnidade = mysqli_fetch_array($consultaUnidade);  
                //$nomeUnidade = explode(" ",$resultadoUnidade['NOME']);  
                if(empty($resultadoUnidade['NOME'])) {
                    $nomeUnidade = "UNIDADE NEUTRA";
                } else {
                    $nomeUnidade = $resultadoUnidade['NOME'];
                }            

                // TRATANDO TELEFONE
                $telefone01 = '';
                if(strlen($row["TELEFONE01"]) == 11) {
                $telefone01 .= maskPHP($row["TELEFONE01"],'(##) #####-####');
                } else { $telefone01 .= maskPHP($row["TELEFONE01"],'(##) ####-####'); }
                
                $sheet->setCellValue('A'.$i, converterData($row["DATA"],"COMPLETA"));
                $sheet->setCellValue('B'.$i, $row["NOME"]);
                $sheet->setCellValue('C'.$i, $telefone01);
                $sheet->setCellValue('D'.$i, $resPares["TOTAL"]);
                $sheet->setCellValue('E'.$i, $row["TIPO_DESCONTO"]); 
                $sheet->setCellValue('G'.$i, $row["TOTAL"]);
                $sheet->setCellValue('H'.$i, $row["STATUS"]);
                $sheet->setCellValue('I'.$i, $row["VENDEDOR"]);

                if($row["TIPO_DESCONTO"] == 'Valor') {
                    $sheet->setCellValue('F'.$i, $row["DESCONTO"]);
                    $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');
                } elseif($row["TIPO_DESCONTO"] == 'Porcentagem') {
                    $sheet->setCellValue('F'.$i, ($row["DESCONTO"]/100));
                    $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode('#,##0.00%');
                } else {
                    $sheet->setCellValue('F'.$i, $row["DESCONTO"]);
                }

                if($row["DOCUMENTO_FISCAL"]){
                    $sheet->setCellValue('J'.$i, $row["DOCUMENTO_FISCAL"]);
                }else{
                    $sheet->setCellValue('J'.$i, "-");
                }

                $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-'); 
                     

            } // WHILE  

        } else {

            $queryStatus        = ' AND V.status = "Concluída" AND VP.status = "Ativo" ';
            //$queryStatus        = ' AND V.dataDelete IS NULL AND V.status NOT IN ("Cancelada", "Deletada") AND VP.status = "Ativo" ';
            $queryComplemento   = ' AND V.dataDelete IS NULL ';
            $queryGroup         = ' ';
            
            $queryFinal         = $queryPeriodo.$queryStatus.$queryUnidade.$queryComplemento.$queryGroup;
            
            // SQL SELECT
            $query = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA_VENDA, C.nome AS CLIENTE, VP.idProduto AS ID_PRODUTO, VP.tamanho AS TAMANHO, VP.quantidade AS QUANTIDADE, VP.preco AS SELLOUT, V.idUnidade AS ID_UNIDADE, V.status AS STATUS, V.totalBruto AS TOTAL_BRUTO, V.totalLiquido AS TOTAL_LIQUIDO, V.tipoDesconto AS TIPO_DESCONTO, V.desconto AS DESCONTO
                    FROM PDV_vendas AS V
                    INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda
                    INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente
                    WHERE ".$queryFinal." ";         


            $result  = mysqli_query($conexao,$query);        
            $i = 1;                
            
            //Definne os cabeçalhos
            $sheet->setCellValue('A1', "DATA_VENDA");
            $sheet->setCellValue('B1', "CLIENTE");
            $sheet->setCellValue('C1', "ID_VENDA");
            $sheet->setCellValue('D1', "DESCRICAO");
            $sheet->setCellValue('E1', "SKU");
            $sheet->setCellValue('F1', "NUMERO");
            $sheet->setCellValue('G1', "SELLIN");           
            $sheet->setCellValue('H1', "SELLOUT");
            $sheet->setCellValue('I1', "TOTAL_BRUTO_VENDA");
            $sheet->setCellValue('J1', "TIPO_DESCONTO");
            $sheet->setCellValue('K1', "DESCONTO");
            $sheet->setCellValue('L1', "TOTAL_LIQUIDO_VENDA");
            $sheet->setCellValue('M1', "STATUS");          

            // WHILE - POPULANDO PLANILHA
            while($row = mysqli_fetch_assoc($result)){
                $i++;          

                // CONSULTA MOV 
                $consultaMov = mysqli_query($conexao, "SELECT EM.descricao AS DESCRICAO, EM.precoSellin AS SELLIN  
                                            FROM PDV_estoqueMovimentacoes EM
                                            WHERE EM.tipo = 'Saída' AND EM.natureza = 'Venda' AND EM.status = 'OK' AND EM.idVenda = ".$row['ID_VENDA']." AND EM.idProduto = ".$row['ID_PRODUTO']." ");
                $resultadoMov = mysqli_fetch_array($consultaMov);

                // CONSULTA UNIDADE
                $consultaUnidade = mysqli_query($conexao, "SELECT id AS ID_UNIDADE, nome_exibicao AS NOME FROM qv_franquias WHERE id = ".$row["ID_UNIDADE"]." ");
                $resultadoUnidade = mysqli_fetch_array($consultaUnidade);  
                //$nomeUnidade = explode(" ",$resultadoUnidade['NOME']);  
                if(empty($resultadoUnidade['NOME'])) {
                    $nomeUnidade = "UNIDADE NEUTRA";
                } else {
                    $nomeUnidade = $resultadoUnidade['NOME'];
                }            
                // CONSULTA SKU | TRATANDO BOLSAS
                // str_pad($row["TAMANHO"], 2, "0", STR_PAD_LEFT) - PReenchdo com zeros a esquerda ate completar qtd de casas informada
                $consultaSKU = mysqli_query($conexao, "SELECT PG.codigo AS SKU 
                                FROM qv_produtos_grades PG 
                                INNER JOIN qv_grades G ON G.id = PG.grade_id
                                WHERE PG.produto_id = ".$row["ID_PRODUTO"]." AND G.codigo =  '".str_pad($row["TAMANHO"], 2, "0", STR_PAD_LEFT)."' ");
                $resultadoSKU = mysqli_fetch_array($consultaSKU);          

                // PREENCHENDO LINHAS
                $sheet->setCellValue('A'.$i, converterData($row["DATA_VENDA"],"COMPLETA"));
                $sheet->setCellValue('B'.$i, $row["CLIENTE"]);
                $sheet->setCellValue('C'.$i, $row["ID_VENDA"]);
                $sheet->setCellValue('D'.$i, $resultadoMov["DESCRICAO"]);
                $sheet->setCellValue('E'.$i, $resultadoSKU["SKU"]);
                $sheet->setCellValue('F'.$i, $row["TAMANHO"]);
                $sheet->setCellValue('G'.$i, $resultadoMov["SELLIN"]);
                $sheet->setCellValue('H'.$i, $row["SELLOUT"]);
                $sheet->setCellValue('I'.$i, $row["TOTAL_BRUTO"]);
                $sheet->setCellValue('J'.$i, $row["TIPO_DESCONTO"]);

                if($row["TIPO_DESCONTO"] == 'Valor') {
                    $sheet->setCellValue('K'.$i, $row["DESCONTO"]);
                    $sheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');
                } elseif($row["TIPO_DESCONTO"] == 'Porcentagem') {
                    $sheet->setCellValue('K'.$i, ($row["DESCONTO"]/100));
                    $sheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode('#,##0.00%');
                } else {
                    $sheet->setCellValue('K'.$i, $row["DESCONTO"]);
                }

                $sheet->setCellValue('L'.$i, $row["TOTAL_LIQUIDO"]);
                $sheet->setCellValue('M'.$i, $row["STATUS"]);

    
                $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');  
                $sheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');
                $sheet->getStyle('I'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');
                $sheet->getStyle('L'.$i)->getNumberFormat()->setFormatCode('R$ #,##0.00_-');
            
                
            } // WHILE         

        }
        
        $nomePlanilha = 'relatorioVendas'.rand(1, 9999).'.xlsx';

        // DOWNLOAD
        $writer = new Xlsx($spreadsheet);
        //unlink($_SERVER['DOCUMENT_ROOT'].'/assets/relatorios/relatorioVendas.xlsx');
        $writer->save($_SERVER['DOCUMENT_ROOT'].'/assets/relatorios/'.$nomePlanilha);           

        // VALIDACAO FINAL                 
        if($query) {
            $resultadoFinal = array('resultado'=>true, 'mensagem' => $mensagemRetorno, 'conteudo' => $nomePlanilha);
        } else {
            $resultadoFinal = array('resultado'=>false, 'mensagem'=> $mensagemErro);
        }        

        // RETORNO
        return $resultadoFinal;

    }      
    
}
?>