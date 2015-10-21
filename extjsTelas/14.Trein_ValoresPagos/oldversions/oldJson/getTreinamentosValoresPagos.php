<?
# @AUTOR = bbarbosa #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

echo json_encode(array("myData"=>Sql::arrays('SATURN','SIMPAC','sp_listcursos_valorespagos')));
?>
