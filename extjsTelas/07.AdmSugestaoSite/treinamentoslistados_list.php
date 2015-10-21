<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

echo json_encode(array("myData"=>Sql::arrays('SATURN','SIMPAC',"sp_cursosclassificado_ativos_list")));

?>