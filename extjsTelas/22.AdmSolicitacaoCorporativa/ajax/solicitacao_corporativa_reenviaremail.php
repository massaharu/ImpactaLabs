<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$nrcpf = post('nrcpf');
$email = post('email');
$solicitante = post('solicitante');

//$email = "lneto@impacta.com.br";
$curso = array();

$ImpactaOnline = new ImpactaOnline();
$Usuario = new Usuario($_SESSION['idusuario']);
$AccountCliente = Account::getByEmail($email, 1);

if(count($AccountCliente) > 0){

	$AccountCliente = new Account($AccountCliente[0]['cod_cli']);
	
	if($ImpactaOnline->isValidLogin($AccountCliente->email_cli, (string)$AccountCliente->senha_cli)){
		$SituationCourses = $ImpactaOnline->getSituacionCourseV2();
	} else {
		if($ImpactaOnline->getUser($AccountCliente->email_cli)){
			$SituationCourses = $ImpactaOnline->getSituacionCourseV2();
		} else {
			$SituationCourses = array();
		}
	}
	
	if(count($SituationCourses) > 0){
										
		foreach($SituationCourses as $SituationCourse){
			
			array_push($curso, $SituationCourse->course->title);
		}
		//pre($AccountCliente); pre($curso); exit;
		$wasSended = $ImpactaOnline->setEmail(
			$AccountCliente->nome_cli,
			(string)$AccountCliente->senha_cli,
			$AccountCliente->email_cli,
			$curso,
			1,
			$Usuario->cdemail
		);
		
		if($wasSended){
			$success = true;
			$msg = "E-mail enviado para ".$AccountCliente->email_cli." com sucesso!";
		}else{
			$success = false;
			$msg = "O email ".$AccountCliente->email_cli." não foi enviado para o destinatário. Verifique se o e-mail está correto!";
		}
	}else{
		$success = false;
		$msg = "Não existe uma conta no Impacta Online para o email: ".$email;
	}
}else{
	$success = false;
	$msg = "Não existe uma conta no Impacta Treinamentos para o email: ".$email;
}

echo json_encode(array(
	'success'=>$success,
	'msg'=>$msg,
	'retorno'=>array(
		'nome_cli' => $AccountCliente->nome_cli,
		'senha_cli' => (string)$AccountCliente->senha_cli,
		'email_cli' => $AccountCliente->email_cli,
		'curso' => $curso,
		'flagEmail' => 1,
		'cdemail' => $Usuario->cdemail
	)
))
?>