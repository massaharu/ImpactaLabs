<?php
# @AUTOR = bbarbosa #
require_once("../inc/conn.php");
/////////////////////////////////////////////////////////////////////////////
$sql = "select * from tb_turmasSophia";
$conn = sqlsrv_connect("SATURN", array( "Database"=>"FIT", "UID"=>"user_cheque", "PWD"=>"cheque123"));
$stmt = sqlsrv_query($conn, $sql);
$data = array();
while($a1 = sqlsrv_fetch_array($stmt)){
	//Inserindo disciplinas no banco do Iclass
	array_push($data,array(
		"idturma"=>$a1['idturmsophia'],
		"desturma"=>utf8_encode($a1['desturma'])
	));
}
echo json_encode(array("myData"=>$data));
?>