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
$queryPeriodo = ' DATE(LA.dataInsert) BETWEEN "'.$dataDe.'" AND "'.$dataAte.'" ';

// EXTRA WHERE CLAUSULES
$queryUnidade = " AND LA.idAfiliado = '".$QV_Unidade."'";
$queryDataDelete = " AND LA.dataDelete IS NULL ";

// EXTRAS CLAUSULES
$GroupBY = "";

// QUERY FINAL
$queryFinal = $queryPeriodo.$queryDataDelete.$queryUnidade;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID',
    1   =>  'DATA_CRIACAO',
	2   =>  'NOME',
    3   =>  'PEDIDO',
    4   =>  'PEDIDO_VALOR',
    5   =>  'COMISSAO_TAXA',
    6   =>  'COMISSAO_VALOR'
);

// getting total number records without any search
$sql = "SELECT LA.id AS ID, DATE(LA.dataInsert) AS DATA_CRIACAO, LA.nome AS NOME, CONCAT(LA.idOrder,'/',LA.numeroPedido) AS PEDIDO, LA.json AS JSON, LA.afiliadoPorcentagem AS COMISSAO_TAXA";
$sql.= " FROM PDV_linkAfiliados LA ";
$sql.= " WHERE ";
$sql.= $queryFinal;
$sql.= $GroupBY;
//echo $sql;
$query = mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT LA.id AS ID, DATE(LA.dataInsert) AS DATA_CRIACAO, LA.nome AS NOME, CONCAT(LA.idOrder,'/',LA.numeroPedido) AS PEDIDO, LA.json AS JSON, LA.afiliadoPorcentagem AS COMISSAO_TAXA";
$sql.= " FROM PDV_linkAfiliados LA ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

// CAMPO DE BUSCA
if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( LA.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR LA.numeroPedido LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR LA.idOrder LIKE '%".$requestData['search']['value']."%' ) ";
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
                        <li>
                            <a href="javascript:void(0);">
                                <em class="icon ni ni-search"></em>
                                <span>Movimentações</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>';
    
    $nsJSON = json_decode($row["JSON"],true);
    
    $nestedData[] = $row["ID"];
    $nestedData[] = converterData($row["DATA_CRIACAO"],'BR');
    $nestedData[] = $row["NOME"];
    $nestedData[] = $row["PEDIDO"];
    $nestedData[] = "R$ ". numeroDecimal($nsJSON['total'],2);
    $nestedData[] = $row["COMISSAO_TAXA"]."%";
    $nestedData[] = "R$ ". numeroDecimal(($row["COMISSAO_TAXA"]/100) * $nsJSON['total'],2);
    $nestedData[] = "-";

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