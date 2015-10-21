<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays('SQL_TESTE','DEV_TESTE',"sp_videos_list");

echo json_encode(array("myData"=>$data));

?>