<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvideo = post('idvideo');
$idvideotipo = post('idvideotipo');
$videotitulo = utf8_decode(post('videotitulo'));
$videodescricao = utf8_decode(post("videodescricao"));
$videolink = utf8_decode(post("videolink"));


Sql::query('SQL_TESTE','DEV_TESTE',"sp_videos_update $idvideo, $idvideotipo, '$videotitulo', '$videodescricao', '$videolink'");

echo success;
?>