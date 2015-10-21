<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular = post('idvestibular');

Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_delete $idvestibular");

echo success;

?>





























