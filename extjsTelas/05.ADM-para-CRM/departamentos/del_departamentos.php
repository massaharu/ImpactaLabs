<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/atendimento/cadastros/inc/configuration.php");

$objDepartamentos = new Departamento(post('iddepartamento'));

echo json_encode(array('success'=>true,'myData'=>$objDepartamentos->destroy()));

echo success;
?>