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
$queryPeriodo = ' DATE(C.dataInsert) BETWEEN "'.$dataDe.'" AND "'.$dataAte.'" ';

if(anti_injection($_GET['status']) != "0") {
    $queryStatus = ' AND C.status = "'.anti_injection($_GET['status']).'"  ';
} else {
    $queryStatus = '';
}

// EXTRA WHERE CLAUSULES
$queryUnidade = " AND C.idUnidade = ".$QV_Unidade;
$queryDataDelete = " AND C.dataDelete IS NULL ";

// EXTRAS CLAUSULES
$GroupBY = "";

// QUERY FINAL
$queryFinal = $queryPeriodo.$queryStatus.$queryDataDelete.$queryUnidade;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID_CAIXA',
    1   =>  'DATA_ABERTURA',
	2   =>  'SALDO_INICIAL',
    3   =>  'SALDO_FINAL',
    4   =>  'DIFERENCA',
    5   =>  'DATA_FECHAMENTO',
    6   =>  'STATUS'
);

// getting total number records without any search
$sql = "SELECT C.idCaixa AS ID_CAIXA, DATE(C.dataInsert) AS DATA_ABERTURA, C.saldoInicial AS SALDO_INICIAL, C.saldoFinal AS SALDO_FINAL, C.diferenca AS DIFERENCA, C.status AS STATUS, DATE(C.dataFechamento) AS DATA_FECHAMENTO";
$sql.= " FROM PDV_caixa C ";
$sql.= " WHERE ";
$sql.= $queryFinal;
$sql.= $GroupBY;
//echo $sql;
$query = mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT C.idCaixa AS ID_CAIXA, DATE(C.dataInsert) AS DATA_ABERTURA, C.saldoInicial AS SALDO_INICIAL, C.saldoFinal AS SALDO_FINAL, C.diferenca AS DIFERENCA, C.status AS STATUS, DATE(C.dataFechamento) AS DATA_FECHAMENTO";
$sql.= " FROM PDV_caixa C ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

// CAMPO DE BUSCA
if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( C.status LIKE '%".$requestData['search']['value']."%' ) ";
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
                        <li><a href="#modalMovimentacoesCaixa" data-idCaixa="'.$row["ID_CAIXA"].'" class="" data-bs-toggle="modal"><em class="icon ni ni-search"></em><span>Movimentações</span></a></li>
                        <li class="'.($row["STATUS"] == 'Aberto' ? "" : "d-none").'"><a href="#modalMovimentacoesNova" data-idCaixa="'.$row["ID_CAIXA"].'" class="" data-bs-toggle="modal"><em class="icon ni ni-plus-circle"></em><span>Adicionar Movimentação</span></a></li>
                        <li class="'.($row["STATUS"] == 'Aberto' ? "" : "d-none").'"><a href="#modalCaixaFechamento" data-idCaixa="'.$row["ID_CAIXA"].'"  data-bs-toggle="modal"><em class="icon ni ni-property-remove"></em><span>Fechar Caixa</span></a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>';

    // TRATANDO STATUS
    if($row["STATUS"] == 'Aberto') {
        $badgeStatus = '<span class="badge badge-dot bg-success">'.$row['STATUS'].'</span>';
    } else {
        $badgeStatus = '<span class="badge badge-dot bg-primary">'.$row['STATUS'].'</span>';
    }

    // TRATANDO DIFERENCA
    if($row["DIFERENCA"] < 0) {
        $classDiferenca = 'text-danger';
    } elseif($row["DIFERENCA"] > 0) {
        $classDiferenca = 'text-success';
    } else {
        $classDiferenca = 'text-dark';
    }
    
    $nestedData[] = $row["ID_CAIXA"];
    $nestedData[] = converterData($row["DATA_ABERTURA"],'BR');
    $nestedData[] = "R$ ". numeroDecimal($row["SALDO_INICIAL"],2);
    $nestedData[] = (empty($row["SALDO_FINAL"]) ? "-" : "R$ " . numeroDecimal($row["SALDO_FINAL"],2));
    $nestedData[] = '<span class="'.$classDiferenca.' fw-bold">' . ($row["STATUS"] == "Aberto" ? "-" : "R$ " . numeroDecimal($row["DIFERENCA"],2)) . '</span>';
    $nestedData[] = ($row["STATUS"] == "Aberto" ? "-" : converterData($row["DATA_FECHAMENTO"],'BR'));
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