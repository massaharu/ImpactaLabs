<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objEstado = new Estado(post('idestado'));

echo json_encode(array('success'=>true,'myData'=>$objEstado->getCidades()));

/*echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_cidadebyidestado_list ".post('idestado'))))*/
?>