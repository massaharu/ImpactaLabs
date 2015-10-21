<?php
	# @AUTOR = Bcunha #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	//////////////////////////////////////////////////////////////////////////////////
	//Variáveis necessárias
	$idpedido = post("idpedido");
	$result = "";
	
	//////////////////////////////////////////////////////////////////////////////////
	//Verifica se está na fila do robô
	$r = Sql::arrays('SATURN', 'Simpac', "sp_pedido_baixa_robo_get ".$idpedido.";");
	
	//Se estiver na fila do robô, não deixar alterar
	if ($r){
		$result = "false";
	}
	else {
		$result = "true";
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