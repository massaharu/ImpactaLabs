<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idocorrencia = post('idocorrencia');

Sql::insert("SATURN", "FINANCEIRO", "sp_shoplineocorrencia_delete '$idocorrencia'");
?>