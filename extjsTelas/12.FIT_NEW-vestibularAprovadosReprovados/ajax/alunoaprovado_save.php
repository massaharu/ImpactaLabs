<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular = post('idvestibular');
$alunoaprovado = utf8_decode(post("alunoaprovado"));
$alunoaprovadocargo = utf8_decode(post("alunoaprovadocargo"));
$alunoaprovadoempresa = utf8_decode(post('alunoaprovadoempresa'));


Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_aprovados_save $idvestibular, '$alunoaprovado', '$alunoaprovadocargo', '$alunoaprovadoempresa'");

echo success;
?>