<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idcurso = post('idcurso');
$inemaberto = post('inemaberto');
//$idcurso = 1614;

if($inemaberto){
	$cursosagendados = new Curso($idcurso);
	$cursosagendados = $cursosagendados->getEmAbertoList(); 
}else{
	$cursosagendados = Sql::arrays('SATURN', 'SIMPAC', 'sp_cursoagendadonaoiniciados_list '.$idcurso);
}

$myData = array();
foreach($cursosagendados as $value1){
	$cursoAgendado = new CursoAgendado($value1['idcursoagendado']);
	$curso = $cursoAgendado->getCurso();
	$instrutor = $cursoAgendado->getInstrutor();
	
	array_push($myData, array(
		"desinstrutor"=>$instrutor->desinstrutor,
		"descurso"=>$curso->descurso.' '.$cursoAgendado->desobs,
		"idcurso"=>$cursoAgendado->idcurso,
		"idcursoagendado"=>$cursoAgendado->idcursoagendado,
		"idinstrutor"=>$cursoAgendado->idinstrutor,
		"dtinicio"=>$cursoAgendado->dtinicio,
		"dttermino"=>$cursoAgendado->dttermino,
		"desperiodo"=>$cursoAgendado->desperiodo,
		"nrcargahoraria"=>$cursoAgendado->nrcargahoraria,
		"nrvagas"=>$cursoAgendado->getVagas(),
		"nrtotalalunos"=>$cursoAgendado->getTotalAlunos(),
		"inturmafechada"=>$cursoAgendado->inturmafechada
	));
}

echo json_encode(array(
	'success'=>true, 
	'myData'=>$myData
));
?>