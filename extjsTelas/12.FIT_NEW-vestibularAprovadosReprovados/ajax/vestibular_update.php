<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular = post('idvestibular');
$desvestibular = utf8_decode(post('desvestibular'));
$dtinicio = post("dtinicio"). " 00:00";
$dttermino = post("dttermino"). " 23:59";


Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_update $idvestibular,'$desvestibular', '$dtinicio', '$dttermino'");

echo success;
?>