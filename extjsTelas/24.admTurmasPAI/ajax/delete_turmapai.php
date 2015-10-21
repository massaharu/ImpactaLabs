<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$TurmasPAI = json_decode(post('turmaspai'));

foreach($TurmasPAI as $tmpai){
	$data = Sql::arrays('SATURN', 'FIT_NEW', "sp_turmapai_delete $tmpai->id_cod_turma");
}

echo json_encode(
	array(
		'success'=>true,	
		'msg'=>"Turmas PAI desvinculadas com sucesso"
	)
);
?>