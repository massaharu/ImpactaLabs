<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$desvestibular = utf8_decode(post('desvestibular'));
/*$dt1 = date("Y-m-d", strtotime(post("dt1"))) . " 00:00";
$dt2 = date("Y-m-d", strtotime(post("dt2"))) . " 23:59";*/
$dt1 = post("dt1"). " 00:00";
$dt2 = post("dt2"). " 23:59";


Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_save '$desvestibular', '$dt1', '$dt2'");

echo success;
?>