<?php
# @AUTOR = Massaharu #
$GLOBALS['JSON'] = TRUE;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = @Sql::arrays("SATURN", "FIT_NEW", "sp_cursostipos_list");

	array_push($data,array(
		"cursotipo_id"=>6,
		"cursotipo_titulo"=>'Treinamentos',
		"cursotipo_imagem"=>'treinamentos.jpg',
		"cursotipo_ativo"=>true
	));

success(TRUE, array("myData"=>$data));


?>