<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$busca = post("busca");
$arr_matricula = array();

$search = new Search($busca);

$search->searchMatricula();

foreach($search->result as $mat){
	array_push($arr_matricula, array(
		"matricula"=>$mat["display"]
	));
}

echo json_encode(array(
	"myData"=>$arr_matricula,
	"success"=>true
));

?>