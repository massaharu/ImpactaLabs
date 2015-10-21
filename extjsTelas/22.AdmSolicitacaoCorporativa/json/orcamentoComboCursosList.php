<?php
	# @AUTOR = Bcunha #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	//////////////////////////////////////////////////////////////////////////////////
	//Variáveis necessárias
	$cortesia = post('cortesia');
	
	//////////////////////////////////////////////////////////////////////////////////
	//Verifica se é ou não cortesia
	if ($cortesia == "false"){
		//Obtem todos os cursos ativos
		$result = Curso::getList(false);
	}
	else {
		//Obtem todos os cursos cortesias ativos
		$result = Curso::getListCortesia();
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	//Objeto JSON
	echo json_encode(
		array(
			"success" => true,
			"myData" => $result
		)
	);
	
	//////////////////////////////////////////////////////////////////////////////////
?>