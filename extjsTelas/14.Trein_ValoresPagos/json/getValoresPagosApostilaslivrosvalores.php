<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$IdCurso = post('IdCurso');

$data = Sql::arrays("SATURN", "Simpac", "sp_apostilaslivrosvalores_list $IdCurso");

success(TRUE, array("myData"=>$data));
?>