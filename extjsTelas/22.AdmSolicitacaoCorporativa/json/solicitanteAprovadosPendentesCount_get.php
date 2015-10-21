<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idsolicitacaocorp = new SolicitacaoCorporativa(1);

$permisions = array(1495, 11);

if((string)array_search($_SESSION["idusuario"], $permisions) !== ""){
	$solicitacaocorpcount = $idsolicitacaocorp->getSolicitanteAprovadosPendentesCount();
}else{
	$solicitacaocorpcount = $idsolicitacaocorp->getSolicitanteAprovadosPendentesCount($_SESSION["idusuario"]);
}

$arr2 = array();

array_push($arr2, 
	array(
		"instatus"=>$solicitacaocorpcount[0]["instatus"],
		"finalizado"=>$solicitacaocorpcount[0]["finalizado"]
	),
	array(
		"instatus"=>$solicitacaocorpcount[1]["instatus"],
		"finalizado"=>$solicitacaocorpcount[1]["finalizado"]
	)
);

echo json_encode(array(
	'success'=>true, 
	'myData'=>$arr2
));
?>