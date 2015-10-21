<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = new solicitacaoBolsaEstudos(0);
$dependentestipo = $data->dependenteTipo_List();
$solicitacaobolsaestudostipo = $data->solicitacaoBolsaEstudostipo_List();


echo json_encode(array("myData1"=>$dependentestipo, "myData2"=>$solicitacaobolsaestudostipo));
?>
