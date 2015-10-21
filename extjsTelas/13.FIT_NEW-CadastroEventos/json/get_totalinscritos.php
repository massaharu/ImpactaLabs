<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$palestracadastroid = post("palestracadastroid");

$data = @Sql::arrays("SATURN", "FIT_NEW", "sp_cadpalestra_qtde_get $palestracadastroid");
success(TRUE, array("myData"=>$data));
?>