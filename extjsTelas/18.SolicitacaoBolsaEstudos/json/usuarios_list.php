<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

echo json_encode(array("myData"=>Usuario::getList()));
?>
