<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$IdInstrutor = post('IdInstrutor');
$IdCurso = post('IdCurso');

$data = Sql::arrays("SATURN", "Simpac", "sp_instrutorcursosministrados_get_idcurso $IdInstrutor , $IdCurso");

success(TRUE, array("myData"=>$data));
?>



