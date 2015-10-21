<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$palestraid = post('palestraid');

Sql::query('SQL_TESTE','FIT_NEW',"sp_cadpalestra_delete $palestraid");

echo success;

?>





























