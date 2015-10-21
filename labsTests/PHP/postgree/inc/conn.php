<?php
# @AUTOR = bbarbosa #
//Conexão iClass
function conectaiclass($banco){
	$string = "host=172.18.200.210 port=5432 dbname=".$banco." user=impacta password=impacta";
	$conn = pg_connect($string);
	return $conn;
}
//Conexao Saturn
function conectaSaturn(){
	$conn = sqlsrv_connect("SATURN", array( "Database"=>"FIT", "UID"=>"user_cheque", "PWD"=>"cheque123"));
	return $conn;
}
//Conenxao Supra
function conectaSupra(){
	$conn = sqlsrv_connect("SUPRA", array( "Database"=>"SGA", "UID"=>"user_cheque", "PWD"=>"cheque123"));
	return $conn;
}
?>