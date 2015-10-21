<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$cadastroid = post('cadastroid');

Sql::query('SQL_TESTE','FIT_NEW',"sp_cadcadastro_delete $cadastroid");

echo success;

?>





























