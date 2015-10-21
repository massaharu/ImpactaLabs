<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudospermissao_list");

echo json_encode(array("myData"=>$data));
?>
