<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular = post('idvestibular');
$alunoreprovado = utf8_decode(post("alunoreprovado"));
$alunoreprovadocargo = utf8_decode(post("alunoreprovadocargo"));
$alunoreprovadoempresa = utf8_decode(post('alunoreprovadoempresa'));


Sql::query('SQL_TESTE','FIT_NEW',"sp_vestibular_reprovados_save $idvestibular, '$alunoreprovado', '$alunoreprovadocargo', '$alunoreprovadoempresa'");

echo success;
?>