<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular_aprovados = post('idvestibular_aprovados');

Sql::query('SQL_TESTE','FIT_NEW',"sp_alunoaprovado_instatus $idvestibular_aprovados");

echo success;
?>