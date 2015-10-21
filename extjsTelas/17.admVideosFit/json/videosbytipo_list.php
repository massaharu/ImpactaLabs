<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvideotipo = post('idvideotipo');

$data = Sql::arrays('SQL_TESTE','DEV_TESTE',"sp_videosbytipo_list $idvideotipo");

echo json_encode(array("myData"=>$data));

?>