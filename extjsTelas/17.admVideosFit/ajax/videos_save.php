<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$videotitulo = utf8_decode(post('videotitulo'));
$videodescricao = utf8_decode(post("videodescricao"));
$videolink = utf8_decode(post("videolink"));
$idvideotipo = post('idvideotipo');

Sql::query('SQL_TESTE','DEV_TESTE',"sp_videos_save $idvideotipo, '$videotitulo', '$videodescricao', '$videolink'");

echo success;
?>