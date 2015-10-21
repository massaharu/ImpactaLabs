<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objBairros = new Cidade(post('idcidade'));

echo json_encode(array('success'=>true,'myData'=>$objBairros->getBairros()));
?>