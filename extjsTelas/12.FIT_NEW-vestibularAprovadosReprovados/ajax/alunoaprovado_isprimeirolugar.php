<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular_aprovados = post('idvestibular_aprovados');
$idvestibular = post('idvestibular');

Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_isprimeirolugar $idvestibular_aprovados,$idvestibular");

echo success;
?>