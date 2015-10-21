<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idvestibular = post('idvestibular');
$idvestibular_reprovados = post('idvestibular_reprovados');
$desnome = utf8_decode(post('desnome'));
$descurso = utf8_decode(post("descurso"));
$desempresa = utf8_decode(post("desempresa"));


Sql::query('SQL_TESTE','FIT_NEW',"sp_alunoreprovado_update $idvestibular, $idvestibular_reprovados, '$desnome', '$descurso', '$desempresa'");

echo success;
?>