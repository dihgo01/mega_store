<?php
if($conexao == "intranet") {

    $servidor 	= "mysql.quintavalentina.com.br";
    $usuario 	= "quintava_lucas";
    $senha 		= "@M7dqbrppX12Lucas";
    $banco 		= "quintava_backboard";
    
    $conexaoBD	= mysqli_connect($servidor, $usuario, $senha, $banco);
    mysqli_query($conexaoBD, "SET names UTF8");	
        
} elseif($conexao == "pdv") {

    $servidor 	= "mysql.quintavalentina.com.br";
    $usuario 	= "quintava_lucas";
    $senha 		= "@M7dqbrppX12Lucas";
    $banco 		= "quintava_pdv";

    $conexaoBD	= mysqli_connect($servidor, $usuario, $senha, $banco);
    mysqli_query($conexaoBD, "SET names UTF8");	

} elseif($conexao == "intranetNova") {

    $servidor 	= "mysql.quintavalentina.com.br";
    $usuario 	= "quintava_lucas";
    $senha 		= "@M7dqbrppX12Lucas";
    $banco 		= "quintava_intranetqv";

    $conexaoBD	= mysqli_connect($servidor, $usuario, $senha, $banco);
    mysqli_query($conexaoBD, "SET names UTF8");	

} else {

//	$serverName = "18.228.200.169";
//	$connectionOptions = array("Database" => "Protheus","Uid" => "lucas","PWD" => "O5t68ds%");
//	$conexaoBD = sqlsrv_connect($serverName, $connectionOptions);	

}
?>