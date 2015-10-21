<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays('SQL_TESTE','FIT_NEW',"sp_vestibular_reprovados_list");

function getSemester($semester){
	if($semester < 7){
		return '1º Semestre';
	}else{
		return '2º Semestre';
	}
}


foreach($data as &$a){
	$a['desvestibularId'] = $a['idvestibular'].' - '.$a['desvestibular'].' - '.date('d/m/Y', $a['dtinicio']).' para '.date('Y', $a['dttermino']).' - '.getSemester(date('m', $a['dttermino'])).' ';
}

echo json_encode(array("myData"=>$data))

?>