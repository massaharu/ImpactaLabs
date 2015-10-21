<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$solicitacaobolsaestudo = new solicitacaoBolsaEstudos(post('idsolicitacaobolsaestudo'));

$data = $solicitacaobolsaestudo->getMotivoBySolicitacaobolsaestudos();


echo json_encode(array("myData"=>$data));
?>
