<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$Unidades = new Unidade(0);
$arr_unidades = $Unidades->getList();

$myData = array();

foreach($arr_unidades as $unid){
	if((strpos($unid["desunidade"], "FIT") !== false) || (strpos($unid["desunidade"], "Treinamentos") !== false)){
		array_push($myData, array(
			"idunidade"=>$unid["idunidade"],
			"desunidade"=>$unid["desunidade"],
			"instatus"=>$unid["instatus"],
			"desapelido"=>$unid["desapelido"]
		));
	}
}
 
echo json_encode(array(
	'success'=>true, 
	'myData'=>$myData
));
?>