<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

function emptyNumber($n){
	if($n == "" || $n == NULL){
		return "''";
	}
	return $n;
}

$idocorrencia = post('idocorrencia');
$cod_ocorrencia = post('cod_ocorrencia');
$desocorrencia = utf8_decode(post('desocorrencia'));

Sql::insert("SATURN", "FINANCEIRO", "sp_shoplineocorrencia_save ".emptyNumber($idocorrencia).", ".emptyNumber($cod_ocorrencia).", '$desocorrencia'");
?>