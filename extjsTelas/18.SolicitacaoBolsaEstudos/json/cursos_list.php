<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$data = Sql::arrays("SATURN", "FIT_NEW", "sp_cursos_list");

$dados = array();

foreach($data as $data2){
	array_push($dados, array(
		'curso_id'=>$data2['curso_id'],
		'curso_tipo'=>$data2['curso_tipo'],
		'curso_titulo'=>str_replace("<span class=menor>", "", str_replace("</span>", "", $data2['curso_titulo']))
	));
}

echo json_encode(array("myData"=>$dados));
?>
