<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = post('data').' 23:00:00';
$idperiodo = post('idperiodo');
//echo($data);
echo json_encode(array("myData"=>Sql::arrays('SATURN','INSTRUTORES',"sp_Lista_avaliacao_instrutor '$data', $idperiodo")));

?>