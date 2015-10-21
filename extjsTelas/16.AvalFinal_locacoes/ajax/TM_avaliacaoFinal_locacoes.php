<?php
	# @AUTOR: massa#
	
	$GLOBALS["JSON"] = true;
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");
	///////////////////////////////DECLARAÇÃO DE VARIAVEIS//////////////////////////////////////////////
	$allowed;
	////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////DECLARAÇÃO DE ARRAYS//////////////////////////////////////////////
	$arrDados = array();
	$arrDados2 = array();
	$arrDados3 = array();	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	$link = '<img width=50 src="https://www.impacta.com.br/avaliacao/images/';

	$idcursoagendado = post("idcursoagendado");
	
	$curso = new CursoAgendado($idcursoagendado);
	
	$arrDados = $curso->getAlunosAgendados();
	
	foreach($arrDados as $valor){
		array_push($arrDados2,array(
			'name'=>$valor["nmaluno"],
			'id'=>$valor["idaluno"],
		));
	}
	//////////////////////////////////////////////////////////////////////////	
	//$avaliacao = new AvaliacaoFinal;
	
	$avaliacao = new AvaliacaoFinalLocacoes;
	
	$avaliacaoArray = $avaliacao->getFinalQuestions();
	
	foreach($avaliacaoArray as $e){
		array_push($arrDados3,array(
			"idquestao"=>$e["idquestao"],
			"desquestao"=>$e["desquestao"]
		));
	}
	//////////////////////////////////////////////////////////////////////////	
	
	//////////////////////////////////////////////////////////////////////////	
	echo json_encode(array(
		'mydata'=>$arrDados2,
		'data'=>array(
			'avaliacao_final_locacoes_idquestao1'=>$arrDados3[0]["idquestao"],
			'avaliacao_final_locacoes_questao1'=>$arrDados3[0]["desquestao"],
			'avaliacao_final_locacoes_idquestao2'=>$arrDados3[1]["idquestao"],
			'avaliacao_final_locacoes_questao2'=>$arrDados3[1]["desquestao"],
			'avaliacao_final_locacoes_idquestao3'=>$arrDados3[2]["idquestao"],
			'avaliacao_final_locacoes_questao3'=>$arrDados3[2]["desquestao"],
			'avaliacao_final_locacoes_idquestao4'=>$arrDados3[3]["idquestao"],
			'avaliacao_final_locacoes_questao4'=>$arrDados3[3]["desquestao"],
			'avaliacao_final_locacoes_idquestao5'=>$arrDados3[4]["idquestao"],
			'avaliacao_final_locacoes_questao5'=>$arrDados3[4]["desquestao"],
			'avaliacao_final_locacoes_idquestao6'=>$arrDados3[5]["idquestao"],
			'avaliacao_final_locacoes_questao6'=>$arrDados3[5]["desquestao"]
		),
		'success'=>true,
	));
?>