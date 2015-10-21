<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

/*echo json_encode(array("myData"=>estados::todos()));*/

echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_estadobyidpais_list ".post('idpais'))))


/*echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_estado_list")))*/

?>