<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$depto = post('iddepartamento');

echo json_encode(array("myData"=>Sql::arrays('JETTA','CHATV2',"sp_chatadmfrasesnew_list $depto")))

?>