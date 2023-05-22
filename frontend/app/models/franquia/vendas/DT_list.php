<?php
header("Content-type: text/html; charset=utf-8");

// INCLUDE
include_once($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");

// BANCO DADOS
$conexao = bancoDados("conectar","intranet");

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//*********** VARIAVEIS PREVIAMENTE DEFINIDAS
$QV_Unidade = $_SESSION['Authentication']['franquias'][$_SESSION['Authentication']['franquiaActive']]['unidade'];
$QV_UnidadeNF = $_SESSION['Authentication']['franquias'][$_SESSION['Authentication']['franquiaActive']]['emissaoFiscal'];

//*********** TRATANDO VARIAVEIS RECEBIDAS
if(empty($_GET['dataDe'])) {
    $dataAtual = date("Y-m-d");
    $dataDe = date('Y-m-d', strtotime('-30 days', strtotime($dataAtual)));
} else {
    $dataDe = converterData(anti_injection($_GET['dataDe']),"EN");
}
if(empty($_GET['dataAte'])) {
    $dataAte = date("Y-m-d");
} else {
    $dataAte = converterData(anti_injection($_GET['dataAte']),"EN");
}
$queryPeriodo = ' DATE(V.dataInsert) BETWEEN "'.$dataDe.'" AND "'.$dataAte.'" ';

if(anti_injection($_GET['status']) != "0") {
    $queryStatus = ' AND V.status = "'.anti_injection($_GET['status']).'"  ';
} else {
    $queryStatus = '';
}
if(anti_injection($_GET['notaFiscal']) != "0") {
    $queryNF = ' AND V.status_nf = "'.anti_injection($_GET['notaFiscal']).'"  ';
} else {
    $queryNF = '';
}

// EXTRA WHERE CLAUSULES
$queryUnidade = " AND V.idUnidade = ".$QV_Unidade;
$queryDataDelete = " AND V.dataDelete IS NULL ";
$queryProdutosStatus = " AND VP.status = 'Ativo' ";

// EXTRAS CLAUSULES
$GroupBY = " GROUP BY VP.idVenda ";

// QUERY FINAL
$queryFinal = $queryPeriodo.$queryStatus.$queryNF.$queryDataDelete.$queryUnidade.$queryProdutosStatus;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID_VENDA',
    1   =>  'DATA_VENDA',
	2   =>  'NOME',
    3   =>  'STATUS'
);

// getting total number records without any search
$sql = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA_VENDA, C.nome AS CLIENTE, C.cpf AS CPF, C.email AS EMAIL, V.totalLiquido AS TOTAL_LIQUIDO, V.status AS STATUS, SUM(VP.quantidade) AS QTD_PARES, V.caminho_danfe AS URL_NF, V.caminho_xml_nota_fiscal AS NF_XML, V.status_nf AS NF_STATUS";
$sql.= " FROM PDV_vendas V ";
$sql.= " INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente ";
$sql.= " INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda ";
$sql.= " WHERE ";
$sql.= $queryFinal;
$sql.= $GroupBY;
//echo $sql;
$query = mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA_VENDA, C.nome AS CLIENTE, C.cpf AS CPF, C.email AS EMAIL, V.totalLiquido AS TOTAL_LIQUIDO, V.status AS STATUS, SUM(VP.quantidade) AS QTD_PARES, V.caminho_danfe AS URL_NF, V.caminho_xml_nota_fiscal AS NF_XML, V.status_nf AS NF_STATUS";
$sql.= " FROM PDV_vendas V ";
$sql.= " INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente ";
$sql.= " INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

// CAMPO DE BUSCA
if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( C.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR C.email LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR V.status LIKE '%".$requestData['search']['value']."%' ) ";
}
$sql.= $GroupBY;

//echo $sql;
$query=mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 02");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length. */	

//echo $sql;

$query= mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 03");
$data = array();

while($row=mysqli_fetch_array($query)) {  // preparing an array

    $nestedData = array();

    // DEFININDO BOTOES
    $botoes = '
    <ul class="nk-tb-actions gx-1">
        <li>
            <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="link-list-opt no-bdr">
                        <li><a href="/franquia/vendas/update/'.$row["ID_VENDA"].'" class=""><em class="icon ni ni-pen2"></em><span>Editar</span></a></li>
                        
                        <li class="'.($QV_UnidadeNF && $row["NF_STATUS"] == 'Emitida' ? "" : "d-none").'"><a href="https://api.focusnfe.com.br'.$row["URL_NF"].'" target="_blank" class=""><em class="icon ni ni-file-docs"></em><span>Visualizar Documento Fiscal</span></a></li>

                        <li class="'.($QV_UnidadeNF && $row["NF_STATUS"] == 'Emitida' ? "" : "d-none").'"><a href="https://api.focusnfe.com.br'.$row["NF_XML"].'" target="_blank" class=""><em class="icon ni ni-file-code"></em><span>Visualizar XML Fiscal</span></a></li>

                        <li class="d-none"><a href="#modalVendasNF_View" data-bs-toggle="modal" data-url="https://api.focusnfe.com.br'.$row["URL_NF"].'"><em class="icon ni ni-file-docs"></em><span>Modal Visualizar Documento Fiscal</span></a></li>

                        <li class="'.($QV_UnidadeNF && $row["NF_STATUS"] == 'Não Emitida' && $row["STATUS"] == 'Concluída' ? "" : "d-none").'"><a href="javascript:void(0);" class="btGerarDocumentoFiscal" data-idVenda="'.$row["ID_VENDA"].'"><em class="icon ni ni-file-plus"></em><span>Gerar Documento Fiscal</span></a></li>

                        <li class="'.($QV_UnidadeNF && $row["NF_STATUS"] == 'Cancelada' && $row["STATUS"] == 'Concluída' ? "" : "d-none").'"><a href="javascript:void(0);" class="btGerarDocumentoFiscal" data-idVenda="'.$row["ID_VENDA"].'"><em class="icon ni ni-file-plus"></em><span>Gerar Novo Documento Fiscal</span></a></li>                        

                        <li class="'.($row["NF_STATUS"] == 'Emitida' ? "" : "d-none").'"><a href="javascript:void(0);" class="btCancelarDocumentoFiscal" data-idVenda="'.$row["ID_VENDA"].'"><em class="icon ni ni-file-remove"></em><span>Cancelar Documento Fiscal</span></a></li> 

                        <li><a href="#modalVendasHistorico" class="btLogVenda" data-idVenda="'.$row["ID_VENDA"].'" data-bs-toggle="modal"><em class="icon ni ni-history"></em><span>Histórico</span></a></li>                         

                        <li class="divider '.($row["STATUS"] == 'Deletada' || $row["STATUS"] == 'Cancelada' ? "d-none" : "").'"></li>

                        <li class="'.($row["STATUS"] == 'Deletada' || $row["STATUS"] == 'Cancelada' ? "d-none" : "").'"><a href="javascript:void(0);" class="btCancelar" data-idVenda="'.$row["ID_VENDA"].'" data-nf="'.$row["NF_STATUS"].'" data-cpf="'.$row["CPF"].'" data-email="'.$row["EMAIL"].'"><em class="icon ni ni-trash"></em><span>Cancelar Venda</span></a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>';

    // TRATANDO STATUS
    if($row["STATUS"] == 'Concluída') {
        $badgeStatus = '<span class="badge badge-dot bg-success">'.$row['STATUS'].'</span>';
    } elseif($row["STATUS"] == 'Agendada') {
        $badgeStatus = '<span class="badge badge-dot bg-info">'.$row['STATUS'].'</span>';
    } elseif($row["STATUS"] == 'Pendente') {
        $badgeStatus = '<span class="badge badge-dot bg-warning">'.$row['STATUS'].'</span>';
    } else {
        $badgeStatus = '<span class="badge badge-dot bg-danger">'.$row['STATUS'].'</span>';
    }
    
    $nestedData[] = $row["ID_VENDA"];
    $nestedData[] = "#" . $row["ID_VENDA"];
    $nestedData[] = converterData($row["DATA_VENDA"],'BR');
    $nestedData[] = $row["CLIENTE"];
    $nestedData[] = $row["QTD_PARES"];
    $nestedData[] = "R$ ".numeroDecimal($row["TOTAL_LIQUIDO"],2);
    $nestedData[] = $badgeStatus;
    $nestedData[] = $botoes;

	$data[] = $nestedData;

}

$json_data = array(
			"draw"            => (int)$requestData['draw'],   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => (int)$totalData,  // total number of records
			"recordsFiltered" => (int)$totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data,   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>