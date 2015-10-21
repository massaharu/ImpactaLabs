<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idsolicitacaocorp = new SolicitacaoCorporativa(1);

$dtinicio = str_replace("/","-",post('dtinicio'));
$dtfinal = str_replace("/","-",post('dtfinal'));
$from = (post('from'))? post('from') : "corporativo" ;

$permisions = array(1495, 11);

//meu login visualiza todas as solicitações (tela corporativo)
if((string)array_search($_SESSION["idusuario"], $permisions) !== ""){
	$solicitacaocorplist = $idsolicitacaocorp->solicitacaoCorpList($dtinicio, $dtfinal.' 23:59:59');
//os demais usuários visualizam somente as próprias solicitações (tela corporativo)
}else{
	//se a requisição do ajax vier da tela da secretaria visualiza todas as solicitações
	if(strtolower(trim($from)) == "secretaria"){
		$solicitacaocorplist = $idsolicitacaocorp->solicitacaoCorpList($dtinicio, $dtfinal.' 23:59:59');
	//se a requisição vier do corporativo o usuario visualiza somente as próprias solicitações
	}else{
		$solicitacaocorplist = $idsolicitacaocorp->solicitacaoCorpList($dtinicio, $dtfinal.' 23:59:59', 2, $_SESSION["idusuario"]);
	}
}

$arr1 = array();


foreach($solicitacaocorplist as $a){
	$usuariosolicitante = new Usuario($a["idsolicitante"]);
	$usuariosolicitado = new Usuario($a["idsolicitado"]);
	
	array_push($arr1, array(
		'idsolicitacaocorp'=>$a["idsolicitacaocorp"], 
		'matricula'=>$a["matricula"], 
		'idsolicitante'=>$a["idsolicitante"], 
		'dessolicitante'=>$usuariosolicitante->nmcompleto, 
		'idsolicitado'=>(!is_null($a["idsolicitado"]) && $a["idsolicitado"] != 0)? $a["idsolicitado"] : "", 
		'dessolicitado'=>(!is_null($usuariosolicitado->nmcompleto))? $usuariosolicitado->nmcompleto : "",
		'idalunoagendado'=>$a["idalunoagendado"],
		'inalunoalterado'=>$a["inalunoalterado"], 
		'incertificado'=>$a["incertificado"], 
		'inlistapresenca'=>$a["inlistapresenca"], 
		'innfalterado'=>$a["innfalterado"], 
		'intreinamentoalterado'=>$a["intreinamentoalterado"], 
		'inalunodesmembrado'=>$a["inalunodesmembrado"], 
		'inalunodesagendado'=>$a["inalunodesagendado"], 
		'incadimpactaonline'=>$a["incadimpactaonline"],
		'intreinamentoreposicao'=>$a["intreinamentoreposicao"],
		'intreinamentotransfer'=>$a["intreinamentotransfer"],
		'instatus'=>$a["instatus"], 
		'invisivel'=>$a["invisivel"],
		'dtalteracao'=>$a["dtalteracao"], 
		'dtcadastro'=>$a["dtcadastro"]
	));
}

echo json_encode(array(
	'success'=>true, 
	'myData'=>$arr1
));
?>