<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = @Sql::arrays("SATURN", "FIT_NEW", "sp_cursos_list");
success(TRUE, array("myData"=>$data));
?>