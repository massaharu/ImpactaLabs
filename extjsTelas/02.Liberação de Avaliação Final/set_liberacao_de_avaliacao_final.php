<?
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcursoagendado = post('idcursoagendado');

Sql::query('SATURN','INSTRUTORES',"sp_avaliacaofinal_remove $idcursoagendado");

echo success;
?>