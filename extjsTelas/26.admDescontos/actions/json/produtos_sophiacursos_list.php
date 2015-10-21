<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idprodutotipo = (post('idprodutotipo'))? post('idprodutotipo') : 'NULL';

echo json_encode(array(
		'success'=>true,
		'data'=>Sql::arrays('SATURN', 'VENDAS', "sp_produtos_sophiacursos_list $idprodutotipo")
	)
);
?>