<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objLogradouro = new Endereco(post('idlogradourotipo'));

echo json_encode(array('success'=>true,'myData'=>$objLogradouro->getLogradouro()));
?>