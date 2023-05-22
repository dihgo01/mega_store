<?php
header("Content-type: text/html; charset=utf-8");

// INCLUDE
include_once($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");

// BANCO DADOS
$conexaoIntranetNova = bancoDados("conectar","intranetNova");

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

// TRATANDO CONDICOES DA CONSULTA
$queryDataDelete = ' P.dataDelete IS NULL ';

$queryFinal = $queryDataDelete;

$columns = array( 
// datatable column index  => database column name
	0   =>  'ID_REGISTRO',
	1   =>  'FOTO',
    2   =>  'NOME',
    3   =>  'CATEGORIA',
    4   =>  'CUSTO',
    5   =>  'STATUS'
);

// getting total number records without any search
$sql = "SELECT P.idProduto AS ID_REGISTRO, P.nome AS NOME, PC.nome AS CATEGORIA, P.precoCusto AS PRECO_CUSTO, P.status AS STATUS";
$sql.= " FROM produtos P ";
$sql.= " INNER JOIN produtosCategorias PC ON PC.idCategoria = P.idCategoria ";
$sql.= " WHERE ";
$sql.= $queryFinal;
//echo $sql;
$query = mysqli_query($conexaoIntranetNova, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT P.idProduto AS ID_REGISTRO, P.nome AS NOME, PC.nome AS CATEGORIA, P.precoCusto AS PRECO_CUSTO, P.status AS STATUS";
$sql.= " FROM produtos P ";
$sql.= " INNER JOIN produtosCategorias PC ON PC.idCategoria = P.idCategoria ";
$sql.=" WHERE 1=1 ";
$sql.= " AND ".$queryFinal;

if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( P.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR P.idProduto LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR PC.nome LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR P.status LIKE '%".$requestData['search']['value']."%' ) ";
}

//echo $sql;
$query=mysqli_query($conexaoIntranetNova, $sql) or die("MENSAGEM ERRO 02");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length. */	
$query= mysqli_query($conexaoIntranetNova, $sql) or die("MENSAGEM ERRO 03");
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
                        <li><a href="/produtos/produtos/update/'.$row["ID_REGISTRO"].'" class=""><em class="icon ni ni-pen2"></em><span>Editar</span></a></li>
                        <li><a href="javascript:void(0);" class="btDelete" data-id="'.$row["ID_REGISTRO"].'"><em class="icon ni ni-trash"></em><span>Apagar</span></a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>';
    
    $nestedData[] = $row["ID_REGISTRO"];
    $nestedData[] = "";
    $nestedData[] = $row["NOME"];
    $nestedData[] = $row["CATEGORIA"];
    $nestedData[] = $row["PRECO_CUSTO"];
    $nestedData[] = ($row["STATUS"] == 'Ativo' ? '<span class="badge badge-dot bg-success">'.$row['STATUS'].'</span>' : '<span class="badge badge-dot bg-danger">'.$row['STATUS'].'</span>');
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