<?php
$GLOBALS['JSON'] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

$Descontos = json_decode(post('Descontos'));
$TIPO = $Descontos->iddescontotipo;

$DescontoFit = new DescontoFit(array(
	'desdesconto' => $Descontos->desdesconto,
	'iddescontotipo' => $Descontos->iddescontotipo,
	'instatus' => 1
));	

///////////////// BOLSA ///////////////// 
if($TIPO == (int)DescontoFit::BOLSA){
	
	try{
	
		$DescontoFit = $DescontoFit->save();
		
		$DescontoFitBolsa = new DescontoFitBolsa(array(
			'iddesconto'			=> $DescontoFit->getIddesconto(), 
			'idpessoa'	 			=> $Descontos->DescontoBolsaFit->idpessoajuridica, 
			'idnaturezadesconto' 	=> $Descontos->DescontoBolsaFit->idnaturezadesconto, 
			'ingerardebito'			=> $Descontos->DescontoBolsaFit->ingerardebito, 
			'inmatricula' 			=> $Descontos->DescontoBolsaFit->inmatricula,
			'inmensalidade' 		=> $Descontos->DescontoBolsaFit->inmensalidade,
			'nrporc' 				=> $Descontos->DescontoBolsaFit->nrporc
		));
		
		$DescontoFitBolsa->save()->addProdutos($Descontos->Cursos);
		
	}catch(Exception $e){
		
		echo json_encode(array(
			'success'=>false,
			'msg'=>"Desconto não foi salvo"
		));
	}
	
///////////////// CAMPANHA INTERNA ///////////////// 
}else if($TIPO == (int)DescontoFit::CAMPANHAINTERNA){
	
	try{
	
		$DescontoFit = $DescontoFit->save();
		
		$DescontoFitCampanha = new DescontoFitCampanha(array(
			'iddesconto'	=> $DescontoFit->getIddesconto(),
			'dtinicio' 		=> $Descontos->DescontoCampanhaFit->dtinicio,
			'dttermino' 	=> $Descontos->DescontoCampanhaFit->dttermino,
			'desobservacao' => $Descontos->DescontoCampanhaFit->desobservacao,
			'nrparcelas'	=> $Descontos->DescontoCampanhaFit-> nrparcelas
		));
		
		$DescontoFitCampanha->save()->saveItens($Descontos->Itens)->addProdutos($Descontos->Cursos);
		
		
	}catch(Exception $e){
		
		echo json_encode(array(
			'success'=>false,
			'msg'=>"Desconto não foi salvo"
		));
	}
	
///////////////// EMPRESA CONVENIADA ///////////////// 
}else if($TIPO == (int)DescontoFit::EMPRESACONVENIADA){	

	try{

		$DescontoFit->save()->saveItens($Descontos->Itens)->addProdutos($Descontos->Cursos);
		
	}catch(Exception $e){
		
		echo json_encode(array(
			'success'=>false,
			'msg'=>"Desconto não foi salvo"
		));
	}
	
///////////////// DESCONTO ///////////////// 
}else if((int)$TIPO == (int)DescontoFit::DESCONTO){

	try{
		
		$DescontoFit->save()->saveItens($Descontos->Itens)->addProdutos($Descontos->Cursos);
		
	}catch(Exception $e){
		
		echo json_encode(array(
			'success'=>false,
			'msg'=>"Desconto não foi salvo"
		));
	}
}

echo json_encode(array(
	'success'=>true,
	'msg'=>"Desconto Salvo com sucesso"
));
?>