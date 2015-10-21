<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idsolicitacaobolsaestudos = post('idsolicitacaobolsaestudos');
$idpermissao = post('idpermissao');
$desmotivo = adjust(post('motivo'));

Sql::insert("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudosmotivo_save $idsolicitacaobolsaestudos, $idpermissao, '$desmotivo'");

echo success;
?>