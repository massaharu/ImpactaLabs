<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

echo json_encode(array("myData"=>Contato::getTiposCategorias()));
?>