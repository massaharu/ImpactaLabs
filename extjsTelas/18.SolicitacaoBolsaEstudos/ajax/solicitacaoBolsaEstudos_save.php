<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$idnomecolaborador = post('idnomecolaborador');
$idcurso = post('idcurso');
$idsemestre = post('idsemestre');
$nomecolaborador = adjust(post('nomecolaborador'));
$departamento = adjust(post('departamento'));
$cargo = adjust(post('cargo'));
$datadeadmissao = adjust(post('datadeadmissao'));
$cpf = adjust(post('cpf'));
$beneficiariotipo = post('beneficiariotipo');
$desdependente = adjust(post('desdependentetipo'));
$dependentetipo = post('dependentetipo');
$nomealuno = adjust(post('nomealuno'));
$datanascimento = explode("/",post('datanascimento'));
$cpfaluno = adjust(post('cpfaluno'));
$emailaluno = adjust(post('emailaluno'));
$curso = adjust(post('curso'));
$semestre = adjust(post('semestre'));
$justificativa = adjust(post('justificativa'));

if($iddependentetipo == '' || $iddependentetipo == NULL || $iddependentetipo == 0){
	$iddependentetipo == "NULL";
}

$datanascimento = date("Y-m-d", strtotime($datanascimento[2]."-".$datanascimento[1]."-".$datanascimento[0]));
$cpfaluno = str_replace(".","",str_replace("-","",$cpfaluno));

if($dependentetipo == '' || $dependentetipo == NULL || $dependentetipo == 0){
	$dependentetipo = "NULL";
}

function getDataNascimento($beneficiariotipo, $datanascimento){
	if($beneficiariotipo == 1){
		return "NULL";
	}else{
		return "'".$datanascimento."'";
	}
}
function maskCPF($nrcpf){
	return substr($nrcpf, 0, -8).'.'.substr($nrcpf, 3, -5).'.'.substr($nrcpf, 6, -2).'-'.substr($nrcpf, -2);
}

Sql::query("SATURN", "FIT_NEW", "sp_solicitacaobolsaestudos_save $idnomecolaborador, $beneficiariotipo, $idcurso, $idsemestre, $dependentetipo, '$nomealuno', ".getDataNascimento($beneficiariotipo, $datanascimento).", '$cpfaluno', '$emailaluno', '$justificativa'");

// ENVIO DE EMAIL //
$idgestor = Sql::select("SATURN", "SIMPAC", "sp_gerentes_list_idusuario $idnomecolaborador");
$idgestor = $idgestor['idusuario'];
$gestor = new Usuario($idgestor);
$emailgestor = $gestor->cdemail;

$emailgestor = "massaharu@impacta.com.br";
$assunto = "Solicitação de Bolsa de Estudos";

//Solicitação para o Titular
if($beneficiariotipo == 1){
	$mensagem = emailpadrao(utf8_decode("O colaborador(a) <b>".utf8_encode($nomecolaborador)."</b> solicitou a aprovação de bolsa de estudos do curso de <b>".utf8_encode($curso)."</b> do <b>".$semestre."</b> Semestre"));	
	
//Solicitação para o Dependente	
}else if( $beneficiariotipo == 2)		{
	$mensagem = emailpadrao(utf8_decode("O colaborador(a) <b>".utf8_encode($nomecolaborador)."</b> solicitou a aprovação de bolsa de estudos do curso de <b>".utf8_encode($curso)."</b> do <b>".$semestre."</b> Semestre para seu dependente (".utf8_encode($desdependente).") de nome <b>".utf8_encode($nomealuno)."</b>, nascido em <b> ".date("d/m/Y", strtotime($datanascimento))."</b>, CPF: <b>".maskCPF($cpfaluno)."</b>, Email: <b>".$emailaluno."</b>"));		
}
$para = $emailgestor;

envia_email($assunto, $mensagem, $para);

echo success;

?>