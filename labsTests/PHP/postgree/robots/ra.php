<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
$sql="select codigo_alu from cadalu where curso_alu not in('Mecatrônica','Telecomunicações')";
$conn = sqlsrv_connect("SPIDER", array("Database"=>"FIT", "UID"=>"user_cheque", "PWD"=>"cheque123"));
$stmt = sqlsrv_query($conn, $sql);
$data = array();
while($a1 = sqlsrv_fetch_array($stmt)){
	array_push($data,array(
		"ra"=>$a1['codigo_alu']
	));
}
echo json_encode($data);

?>