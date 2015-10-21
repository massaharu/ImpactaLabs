<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvideo = post('idvideo');

Sql::query('SQL_TESTE','DEV_TESTE',"sp_videos_instatus $idvideo");

echo success;
?>