<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

/*$objBairros = new Endereco(post('idcidade'));

echo json_encode(array('success'=>true,'myData'=>$objBairros->getBairros()));*/

echo json_encode(array("myData"=>Logradouro::getLogradouroTipos()));
?>