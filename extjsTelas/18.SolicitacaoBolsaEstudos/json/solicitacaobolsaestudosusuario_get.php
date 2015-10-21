<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$solicitacaobolsaestudo = new SolicitacaoBolsaEstudos(post('idsolicitacaobolsaestudo'));
$dependentetipo = $solicitacaobolsaestudo->getDependenteTipoBySolicitacaobolsaestudos();

$aprovacaoGestor = $solicitacaobolsaestudo->getAprovacaoBySolicitacaobolsaestudos(1);
$aprovacaoRH = $solicitacaobolsaestudo->getAprovacaoBySolicitacaobolsaestudos(2);

$usuario = new Usuario($solicitacaobolsaestudo->idusuario);
$departamento = new Departamento($usuario->iddepto);
$cargo	= new Cargo($usuario->idcargo);

$data = array();

function myGetDate($date){
	if($date == NULL || $date == ""){
		return 0;
	}else{
		return date('d/m/Y', timestamp($date));
	}
}

if($usuario->dtadmissao == NULL || $usuario->dtadmissao == ""){
	$dtadmissao = 0;
}else{
	$dtadmissao = date('d/m/Y', $usuario->dtadmissao);
}

array_push($data, array(
	    'idusuario'=>$usuario->idusuario,
		'nmcompleto'=>$usuario->nmcompleto,
		'nrcpf'=>$usuario->nrcpf,
		'nmlogin'=>$usuario->nmlogin,
		'cdemail'=>$usuario->cdemail,
		'idsolicitacaobolsaestudostipo'=>$solicitacaobolsaestudo->idsolicitacaobolsaestudostipo,
		'desdepartamento'=>$departamento->desdepto,
		'descargo'=>$cargo->descargo,
		'desnomedependente'=>utf8_encode($solicitacaobolsaestudo->desnomedependente),
		'desdependentetipo'=>utf8_encode($dependentetipo['desdependentetipo']),
		'dtnascimentodependente'=>myGetDate($solicitacaobolsaestudo->dtnascimentodependente),
		'nrcpfdependente'=>$solicitacaobolsaestudo->nrcpfdependente,
		'desemaildependente'=>$solicitacaobolsaestudo->desemaildependente,
		'desjustificativa'=>utf8_encode($solicitacaobolsaestudo->desjustificativa),
		'dtsolicitacao'=>date('d/m/Y', $solicitacaobolsaestudo->dtcadastro),
		'dtadmissao'=>$dtadmissao,
		'dtaprovacaogestor'=>myGetDate($aprovacaoGestor['dtcadastro']),
		'dtaprovacaorh'=>myGetDate($aprovacaoRH['dtcadastro'])				
	)
);

echo json_encode(array("myData"=>$data));
?>
