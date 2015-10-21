<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$iddata = post('iddata');
$dtdata = post('dtdata');

Sql::insert('SATURN','SIMPAC',"sp_retiradadecheque_diasemretirada_save $iddata, '$dtdata'");

echo success;
?>