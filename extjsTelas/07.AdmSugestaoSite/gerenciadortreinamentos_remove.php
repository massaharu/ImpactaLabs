<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idclassificacao = post('idclassificacao');

Sql::query('SATURN','SIMPAC',"sp_cursosclassificados_remove $idclassificacao");

echo success;

acao(''.($_SESSION["nmusuario"]).' removeu treinamento em "Gerenciador de Treinamentos"');

?>




