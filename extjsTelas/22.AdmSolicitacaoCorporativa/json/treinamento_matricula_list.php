<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 
//////////////////////////////////////////////////////////////////////////////////////


$Matricula = new Matricula(post('matricula'));
$idaluno = post('idaluno');
//$idaluno = 907484;
//$Matricula = new Matricula('3610102468');

//$agendamentos = $Aluno->getAgendamentos('idalunoagendado', $matricula);
$agendamentos = $Matricula->getPedidoCursoAgendamentos($idpedido, $idaluno);
$data = array();
//pre($agendamentos );exit;
//////////////////////////////////////////////////////////////////////////////////////

foreach($agendamentos as $agendamento){
	
	$AlunoAgendado = new AlunoAgendado($agendamento['IdAlunoAgendado']);
	$CursoAgendado = new CursoAgendado($agendamento['IdCursoAgendado']);
	$Instrutor = $CursoAgendado->getInstrutor();
	$Curso = new Curso($CursoAgendado->idcurso);
	
	array_push($data, array(
		"desinstrutor"=>$Instrutor->desinstrutor,
		"descurso"=>($CursoAgendado->desobs)? $Curso->descurso.' - '.$CursoAgendado->desobs : $Curso->descurso,
		"idcurso"=>$CursoAgendado->idcurso,
		"idcursoagendado"=>$CursoAgendado->idcursoagendado,
		"idalunoagendado"=>$agendamento['IdAlunoAgendado'],
		"idinstrutor"=>$CursoAgendado->idinstrutor,
		"dtinicio"=>$CursoAgendado->dtinicio,
		"dttermino"=>$CursoAgendado->dttermino,
		"desperiodo"=>$CursoAgendado->desperiodo,
		"descomentario"=>$AlunoAgendado->descomentario,
		"idpedidocurso"=>$agendamento['idpedidocurso'],
		"idpedido"=>$agendamento['idpedido'],
		"tabela"=>$agendamento['tabela'],
		"perc"=>$agendamento['perc'],
		"unitario"=>$agendamento['unitario'],
		"total"=>$agendamento['total'],
		"qtde"=>$agendamento['qtde'],
		"inreposicao"=>(strpos(strtolower($AlunoAgendado->descomentario), "reposi") !== false )? 1 : 0
	));
}

echo json_encode(array(
	'success'=>true, 
	'myData'=>$data
));
?>