<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idsolicitacaobolsaestudos = post('idsolicitacaobolsaestudos');
$idpermissao = post('idpermissao');
$nrpercentual = adjust(post('nrpercentual'));

if($nrpercentual == "" || $nrpercentual == NULL){
	$nrpercentual = 0;
}

Sql::insert("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudospercentual_save $idsolicitacaobolsaestudos, $idpermissao, $nrpercentual");

echo success;
?>