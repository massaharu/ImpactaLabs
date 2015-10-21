<?php
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idcurso = post('idcurso');
$descurso = post('descurso');

echo 'id do curso = '.$idcurso.', nome do curso = '.$descurso;

?>