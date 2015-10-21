<?php
# @AUTOR = massaharu #
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$objsolicitacaocorp = new SolicitacaoCorporativa(post('idsolicitacaocorp'));

if($objsolicitacaocorp->instatus == false){
	if($objsolicitacaocorp->idsolicitacaocorp){
	
		$objsolicitacaocorp->removeSolicitacao();
		
		echo json_encode(array('success'=>true,'msg'=>"Solicitação excluído com sucesso."));
	}else{
		echo json_encode(array('success'=>false,'msg'=>"Selecione uma Solicitação para excluir."));
	}
}else{
	echo json_encode(array('success'=>false,'msg'=>"Solicitação já foi executada."));
}
?>