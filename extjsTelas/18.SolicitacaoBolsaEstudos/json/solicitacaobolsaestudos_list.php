<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idsuario = $_SESSION['idusuario'];


$data = Sql::arrays("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_list $idsuario");

echo json_encode(array("myData"=>$data));
?>
