<?php
# @AUTOR = ricardo #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$tipos = post("tipos");
$dt = post("dt");

$data = @Sql::arrays("SATURN", "FIT_NEW", "sp_Cadcadastro_curso_tipo_list '$tipos', '$dt'");
success(TRUE, array("myData"=>$data));
?>