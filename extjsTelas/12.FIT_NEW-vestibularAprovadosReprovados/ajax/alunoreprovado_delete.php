<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular_reprovados = post('idvestibular_reprovados');

Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibularreprovados_delete $idvestibular_reprovados");

echo success;

?>





























