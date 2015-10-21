<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$data = Sql::arrays('SONATA', 'SOPHIA', "sp_periodos_list");

array_unshift($data, array(
	'CODIGO' => NULL,
	'DESCRICAO' => "Todos os períodos"
));

echo json_encode(array(
		'success'=>true,
		'data'=>$data
	)
);
?>