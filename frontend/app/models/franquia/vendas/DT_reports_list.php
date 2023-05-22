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

if(anti_injection($_GET['vendedor']) != "0") {
    $queryVendedor = ' AND V.idUsuario = "'.anti_injection($_GET['vendedor']).'"  ';
} else {
    $queryVendedor = '';
}

if(anti_injection($_GET['status']) != "0") {
    $queryStatus = ' AND(V.status = "'.anti_injection($_GET['status']).'" AND V.status != "Deletada")  ';
} else {
    $queryStatus = '';
}

// EXTRA WHERE CLAUSULES
$queryCondicoes = " AND VP.status = 'Ativo' ";
$queryUnidade = " AND V.idUnidade = ".$QV_Unidade;
$queryDataDelete = " AND V.dataDelete IS NULL ";

// EXTRAS CLAUSULES
$GroupBY = " GROUP BY VP.idVenda ";

// QUERY FINAL
$queryFinal = $queryPeriodo.$queryStatus.$queryCondicoes.$queryDataDelete.$queryVendedor.$queryUnidade;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID_VENDA',
    1   =>  'DATA_VENDA',
	2   =>  'CLIENTE',
    3   =>  'PARES',
    4   =>  'VALOR',
    5   =>  'VENDEDOR',
    6   =>  'STATUS'
);

// getting total number records without any search
$sql = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA_VENDA, C.nome AS CLIENTE, V.totalLiquido AS VALOR, V.status AS STATUS, SUM(VP.quantidade) AS QTD_PARES, V.caminho_danfe AS URL_NF, V.status_nf AS NF_STATUS, V.idUsuario AS VENDEDOR_ID, V2.nomeExibicao AS VENDEDOR";
$sql.= " FROM PDV_vendas V ";
$sql.= " INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente ";
$sql.= " INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda ";
$sql.= " INNER JOIN PDV_vendedores V2 ON V2.idVendedor = V.idUsuario ";
$sql.= " WHERE ";
$sql.= $queryFinal;
$sql.= $GroupBY;
// echo $sql;
$query = mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT V.idVenda AS ID_VENDA, DATE(V.dataInsert) AS DATA_VENDA, C.nome AS CLIENTE, V.totalLiquido AS VALOR, V.status AS STATUS, SUM(VP.quantidade) AS QTD_PARES, V.caminho_danfe AS URL_NF, V.status_nf AS NF_STATUS, V.idUsuario AS VENDEDOR_ID, V2.nomeExibicao AS VENDEDOR";
$sql.= " FROM PDV_vendas V ";
$sql.= " INNER JOIN PDV_clientes C ON C.idCliente = V.idCliente ";
$sql.= " INNER JOIN PDV_vendasProdutos VP ON VP.idVenda = V.idVenda ";
$sql.= " INNER JOIN PDV_vendedores V2 ON V2.idVendedor = V.idUsuario ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

// CAMPO DE BUSCA
if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( C.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR C.email LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR V2.nome LIKE '%".$requestData['search']['value']."%' ";
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
    $nestedData[] = "<span class='fw-bold'>#" . $row["ID_VENDA"]."</span>";
    $nestedData[] = converterData($row["DATA_VENDA"],'BR');
    $nestedData[] = $row["CLIENTE"];
    $nestedData[] = $row["QTD_PARES"];
    $nestedData[] = "R$ ".numeroDecimal($row["VALOR"],2);
    $nestedData[] = "<a href='#modalVendedor' data-bs-toggle='modal' class='text-primary fw-bold' data-idVendedor='".$row["VENDEDOR_ID"]."'>".$row["VENDEDOR"]."</a>";
    $nestedData[] = $badgeStatus;

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