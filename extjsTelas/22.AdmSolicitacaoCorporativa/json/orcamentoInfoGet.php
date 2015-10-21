<?php
	# @AUTOR = Bcunha #
	$GLOBALS['JSON'] = true;
	require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	
	//////////////////////////////////////////////////////////////////////////////////
	//Variáveis necessárias
	$idpedido = post("pedido");
	
	//////////////////////////////////////////////////////////////////////////////////
	//Chama classe para trabalhar com o pedido
	$pedido = new Pedido($idpedido);
	
	//Obtem o Controle Financeiro
	$financeiro = new ControleFinanceiro($pedido->idcontrolefinanceiro);
	
	//Obtem o Aluno
	$Empresa = new Empresa($financeiro->idcliente);
	
	//Atribui as informações necessárias
	$pedido->nome = $Empresa->nmempresa;
	$pedido->email = $Empresa->cdemail;
	$pedido->nrcgc = $Empresa->nrcgc;
	
	
	//////////////////////////////////////////////////////////////////////////////////
	//Objeto JSON
	echo json_encode(
		array(
			"success" => true,
			"myData" => $pedido
		)
	);
	
	//////////////////////////////////////////////////////////////////////////////////
?>