<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objBairros = new Cidade(post('idcidade'));

echo json_encode(array('success'=>true,'myData'=>$objBairros->getBairros()));


/*echo json_encode(array("myData"=>Sql::arrays('SATURN','VENDAS',"sp_cidadebyidestado_list ".post('idestado'))))*/
?>