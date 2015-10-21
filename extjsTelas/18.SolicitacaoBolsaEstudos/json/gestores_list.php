<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");


$usuarios = Usuario::getList();

$data = array();

foreach($usuarios as &$usuarios){
	
	$user = new Usuario($usuarios['idusuario']);
	
	if($user->isGestor()){
		array_push($data, array(
			'idusuario'=>$usuarios['idusuario'],
			'nmcompleto'=>$usuarios['nmcompleto']
		));
	}
}

echo json_encode(array("myData"=>$data));
?>
