<?php
include "../functions.php";
$CONEXAO_CNX = bancoDados("conectar");

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'employee_name', 
	1 => 'employee_salary',
	2=> 'employee_age'
);

// getting total number records without any search
$sql = "SELECT employee_name, employee_salary, employee_age ";
$sql.=" FROM employee";
$query=mysqli_query($CONEXAO_CNX, $sql) or die("MENSAGEM ERRO 01");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT employee_name, employee_salary, employee_age ";
$sql.=" FROM employee WHERE 1=1";

if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( employee_name LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR employee_salary LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR employee_age LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($CONEXAO_CNX, $sql) or die("MENSAGEM ERRO 02");

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length. */	
$query=mysqli_query($CONEXAO_CNX, $sql) or die("MENSAGEM ERRO 03");
	
$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["employee_name"];
	$nestedData[] = $row["employee_salary"];
	$nestedData[] = $row["employee_age"];
	
	$data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>