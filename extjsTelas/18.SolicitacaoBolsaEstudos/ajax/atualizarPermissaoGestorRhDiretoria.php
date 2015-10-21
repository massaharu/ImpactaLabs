<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$gestor = new Usuario($_SESSION['idusuario']);

$idsolicitacaobolsaestudo = post('idsolicitacaobolsaestudo');
$idpermissao = post('idpermissao');
$instatus = post('instatus');
$idsolicitacaobolsaestudostipo = post('idsolicitacaobolsaestudostipo');
$idgestor = $gestor->idusuario;

$solicitacaobolsaestudo = new SolicitacaoBolsaEstudos($idsolicitacaobolsaestudo);
$usuario = new Usuario($solicitacaobolsaestudo->idusuario);

function maskCPF($nrcpf){
	return substr($nrcpf, 0, -8).'.'.substr($nrcpf, 3, -5).'.'.substr($nrcpf, 6, -2).'-'.substr($nrcpf, -2);
}

Sql::insert("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_solicitacaobolsaestudospermissao_save $idpermissao, $idsolicitacaobolsaestudo, $idgestor, NULL, $instatus");

$dataGestores = array();
foreach($usuario->getIdGerente($usuario->idusuario) as $idgestor){
	$user = new Usuario($idgestor['idgerente']);
	array_push($dataGestores, $user->nmcompleto);
}

//Se for aprovado
if($instatus == 1){	
	//pega o curso pelo idsolicitacaobolsaestudos
	$solicitacaobolsaestudos = new SolicitacaoBolsaEstudos($idsolicitacaobolsaestudo);
	$curso = $solicitacaobolsaestudos->getCursoBySolicitacaobolsaestudos();
	//pega o Tipo de Dependente pelo $solicitacaobolsaestudo
	$dependentetipo = $solicitacaobolsaestudos->getDependenteTipoBySolicitacaobolsaestudos();
	
	$assunto = "Soliçitação de Bolsa de Estudos";
	
	switch($idpermissao){
		//Gestor
		case 1:
			$para = "massaharu@impacta.com.br";//"CapitalIntelectual@impacta.net;Genilda@impacta.com.br"
			$titulo = "Gestor"; break;
		//RH	
		case 2:
			$para = "massaharu@impacta.com.br";//"diretoria@impacta.net";
			$titulo = "Gestor e RH"; break;	
		//Diretoria	
		case 3:
			$para = $usuario->cdemail;//"diretoria@impacta.net";
			$titulo = "Gestor, RH e Diretoria"; break;		
	}
	
	//Se a autorização vier do Gestor ou RH
	if($idpermissao != 3){
		//Se for  titular
		if($idsolicitacaobolsaestudostipo == 1){
			$mensagem = emailpadrao(utf8_decode("<b>Autorização confirmada pelo ".$titulo."</b> referente a solicitação interna,<br /><br />Curso: ".utf8_encode($curso['curso_titulo'])."<br />Funcionário: ".$usuario->nmcompleto."<br />Departamento: ".$usuario->desdepto."<br />Gestor(es) da área: ".implode(',',$dataGestores)."<br />E-mail: ".$usuario->cdemail."<br /><br />Prossiga com a autorização."));
			
		//Se for dependente	
		}else{
			$mensagem = emailpadrao(utf8_decode("<b>Autorização confirmada pelo ".$titulo."</b> referente a solicitação interna,<br /><br />Curso: ".utf8_encode($curso['curso_titulo'])."<br />Funcionário: ".$usuario->nmcompleto."<br />Departamento: ".$usuario->desdepto."<br /><b>Dependente:</b><br />Nome: ".utf8_encode($solicitacaobolsaestudos->desnomedependente)."<br />Tipo: ".utf8_encode($dependentetipo['desdependentetipo'])."<br />CPF: ".maskCPF($solicitacaobolsaestudos->nrcpfdependente)."<br />Email: ".$solicitacaobolsaestudos->desemaildependente."<br />Gestor(es) da área: ".implode(',',$dataGestores)."<br />E-mail: ".$usuario->cdemail."<br /><br />Prossiga com a autorização."));
		}
	
	//Se a autorização vier da Diretoria
	}else{
		
		$mensagem = emailpadrao(utf8_decode("<b>Autorização confirmada pelo ".$titulo."</b> referente a solicitação interna,<br /><br />Curso: ".utf8_encode($curso['curso_titulo'])." do <b>".utf8_encode($curso['dessemestre'])."</b> semestre.<br /><br /><br /><b>Isso é um Teste!</b>"));
		
	}
	
	envia_email($assunto, $mensagem, $para);
			
	echo ('{success:true}');
	
//Se for bloqueado	
}else if($instatus == 0){
	echo ('{success:true}');
}
?>