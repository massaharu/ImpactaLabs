<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

echo json_encode(array(
		'success'=>true,
		'data'=>Sql::arrays('SATURN', 'VENDAS', "sp_descontotipo_academico_list")
	)
);
?>