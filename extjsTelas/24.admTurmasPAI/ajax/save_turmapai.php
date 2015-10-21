<?
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$TurmasPAI = json_decode(post('turmaspai'));
$ret = array();

foreach($TurmasPAI as $tmpai){
	$data = Sql::arrays('SATURN', 'FIT_NEW', "sp_turmapai_save $tmpai->id_cod_turma, ".$_SESSION['idusuario'], false);
	
	array_push($ret, array(
		'idturmapai'=>$data['idturmapai']
	));
}

if(count($ret) > 0){
	echo json_encode(
		array(
			'data'=>$ret,
			'success'=>true,	
			'msg'=>"Turmas PAI vinculadas com sucesso"
		)
	);
}else{
	echo json_encode(
		array(
			'data'=>$ret,
			'success'=>true,	
			'msg'=>"Nenhuma turma foi vinculado ao PAI"
		)
	);
}
?>