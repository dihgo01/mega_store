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

// EXTRA WHERE CLAUSULES
$queryUnidade = " V.idUnidade = ".$QV_Unidade;
$queryDataDelete = " AND V.dataDelete IS NULL ";

// EXTRAS CLAUSULES
$GroupBY = "";

// QUERY FINAL
$queryFinal = $queryUnidade.$queryDataDelete;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID_VENDEDOR',
    1   =>  'DATA_CRIACAO',
	2   =>  'NOME',
    3   =>  'STATUS'
);

// getting total number records without any search
$sql = "SELECT V.idVendedor AS ID_VENDEDOR, DATE(V.dataInsert) AS DATA_CRIACAO, V.nome AS NOME, V.status AS STATUS";
$sql.= " FROM PDV_vendedores V ";
$sql.= " WHERE ";
$sql.= $queryFinal;
$sql.= $GroupBY;
//echo $sql;
$query = mysqli_query($conexao, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT V.idVendedor AS ID_VENDEDOR, DATE(V.dataInsert) AS DATA_CRIACAO, V.nome AS NOME, V.status AS STATUS";
$sql.= " FROM PDV_vendedores V ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

// CAMPO DE BUSCA
if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( V.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR V.nomeExibicao LIKE '%".$requestData['search']['value']."%' ) ";
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
                        <li><a href="#modalCadastrarNovoVendedor" data-acao="editar" data-idVendedor="'.$row["ID_VENDEDOR"].'" class="" data-bs-toggle="modal"><em class="icon ni ni-pencil"></em><span>Editar</span></a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>';

    // TRATANDO STATUS
    if($row["STATUS"] == 'Ativo') {
        $badgeStatus = '<span class="badge badge-dot bg-success">'.$row['STATUS'].'</span>';
    } else {
        $badgeStatus = '<span class="badge badge-dot bg-danger">'.$row['STATUS'].'</span>';
    }
    
    $nestedData[] = $row["ID_VENDEDOR"];
    $nestedData[] = "#".$row["ID_VENDEDOR"];
    $nestedData[] = converterData($row["DATA_CRIACAO"],'BR');
    $nestedData[] = $row["NOME"];
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