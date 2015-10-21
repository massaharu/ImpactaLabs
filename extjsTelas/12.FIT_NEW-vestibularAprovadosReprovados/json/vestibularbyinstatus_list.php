<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays('SQL_TESTE','FIT_NEW',"sp_vestibularbyinstatus_list");
foreach($data as &$a){
	$a['dataformatada'] = $a['desvestibular'].' - '.date('d/m/Y', $a['dtinicio']);
}

echo json_encode(array("myData"=>$data))

/*echo json_encode(array("myData"=>Sql::arrays('SQL_TESTE','FIT_NEW',"sp_vestibular_list")))*/

?>