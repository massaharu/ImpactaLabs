<?
	# @AUTOR: massa#
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////						Inserir no banco informações referente a Avaliação Final das Locações              /////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$GLOBALS["JSON"] = true;
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");
			
	$idcursoagendado = post('idcursoagendado');
	$idaluno = post('idalunoagendado');
	$coffee_options = utf8_decode(post('coffee_options'));
	$idquestao1 = post('idquestao1');
	$coment1 = utf8_decode(post('coment1'));
	$ava1_value = post('ava1_value');
	$idquestao2 = post('idquestao2');
	$coment2 = utf8_decode(post('coment2'));
	$ava2_value = post('ava2_value');
	$idquestao3 = post('idquestao3');
	$coment3 = utf8_decode(post('coment3'));
	$ava3_value = post('ava3_value');
	$idquestao4 = post('idquestao4');
	$coment4 = utf8_decode(post('coment4'));
	$ava4_value = post('ava4_value');
	$idquestao5 = post('idquestao5');
	$coment5 = utf8_decode(post('coment5'));
	$ava5_value = post('ava5_value');
	$idquestao6 = post('idquestao6');
	$coment6 = utf8_decode(post('coment6'));
	$ava6_value = post('ava6_value');
		
	$idquestao = array($idquestao1,$idquestao2,$idquestao3,$idquestao4,$idquestao5,$idquestao6);
	$coment = array($coment1,$coment2,$coment3,$coment4,$coment5,$coment6);
	$ava_value = array($ava1_value,$ava2_value,$ava3_value,$ava4_value,$ava5_value,$ava6_value);
	
	$avaliacao = new AvaliacaoFinalLocacoes;	
	
	for($i = 0;$i < 6;$i++){
		$avaliacao->add($idquestao[$i],$idcursoagendado,$idaluno,$coment[$i],$ava_value[$i]);
	}
	
	echo success;
?>