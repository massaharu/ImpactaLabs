<?php
	# @AUTOR: renan #
	
	$GLOBALS["JSON"] = true;
	
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");
	
	/////////////////////////////////////////DECLARATION VARIABLES///////////////////////////////////
	
	$todas		= post("todas");
	$online		= post("online");
	$idcursoagendado = post("idcursoagendado");
	$dtinicio	= post("dtinicio") . " 00:00:00"; 
	$dttermino	= post("dttermino") . " 23:59:59";
	$arrAvaliacao = array();
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	///////////////////////////////////////CLASS INSTANCE	////////////////////////////////////////
	
	$avaliacao = new AvaliacaoDiaria;
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////// CLASS METHOD	////////////////////////////////////////////
	 
	if($todas == 1){
		
		if($online == 0){
		
			$resultado = $avaliacao->getAllAvaliacaoDiaria($idcursoagendado);
		
			foreach($resultado as $e){
				
				if($e["NrNota"] == 10){
						
					$nota = "&#211;timo";
						
				}else if($e["NrNota"] == 5){
						
					$nota = "Bom";
						
				}else{
						
					$nota = "Ruim";
						
				}
					
				array_push($arrAvaliacao,array(
					"aluno"=>$e["Aluno"],
					"nota"=>utf8_encode($nota),
					"comentario"=>($e["Comente"] == "") ? "s/ coment&#225;rio" : $e["Comente"],
					"avaliacao"=>date("d/m/Y", $e["DtAvaliacao"]),
					"treinamento"=>$e["Treinamento"],
					"periodo"=>$e["Periodo"],
					"sala"=>$e["Sala"],
					"unidade"=>$e["DesUnidade"]
				));
				
			}
			
		}else{

			$resultado = $avaliacao->getAllAvaliacaoDiariaOnline($idcursoagendado); 
			
			foreach($resultado as $e){
			
				if($e["Nota"] == 10){
				
					$nota = "&#211;timo";
				
				}else if($e["Nota"] == 5){
				
					$nota = "Bom";
				
				}else{
				
					$nota = "Ruim";
				
				}
				
				array_push($arrAvaliacao,array(
					"aluno"=>$e["Aluno"],
					"nota"=>$nota,
					"comentario"=>($e["Comentario"] == "") ? " s/ comentário" : $e["Comentario"],
					"cadastrado"=>date("d-m-Y H:i", timestamp($e["DataCadastro"]))
				));
				
			}
		
		}
		
	}else{
		
		if($online == 0){
		
			$resultado = $avaliacao->getAvaliacaoDiaria($idcursoagendado,$dtinicio,$dttermino);
						
			foreach($resultado as $e){
				
				if($e["NrNota"] == 10){
					
					$nota = "&#211;timo";
				
				}else if($e["NrNota"] == 5){
					
					$nota = "Bom";
				
				}else{
					
					$nota = "Ruim";
				
				}
				
				array_push($arrAvaliacao,array(
					"aluno"=>$e["Aluno"],
					"nota"=>utf8_encode($nota),
					"comentario"=>($e["Comente"] == "") ? "s/ coment&#225;rio" : $e["Comente"],
					"avaliacao"=>date("d/m/Y", $e["DtAvaliacao"]),
					"treinamento"=>$e["Treinamento"],
					"periodo"=>$e["Periodo"],
					"sala"=>$e["Sala"],
					"unidade"=>$e["DesUnidade"]
				));
				
			}
			
		}else{
	
			$resultado = $avaliacao->getAvaliacaoDiariaOnline($idcursoagendado,$dtinicio);
			
			foreach($resultado as $e){
		
				if($e["Nota"] == 10){
				
					$nota = "&#211;timo";
				
				}else if($e["Nota"] == 5){
				
					$nota = "Bom";
					
				}else{
				
					$nota = "Ruim";
				
				}
				
				array_push($arrAvaliacao,array(
					"aluno"=>$e["Aluno"],
					"nota"=>$nota,
					"comentario"=>($e["Comentario"] == "") ? " s/ comentário" : $e["Comentario"],
					"cadastrado"=>date("d-m-Y H:i", timestamp($e["DataCadastro"]))
				));
				
			}
		
		}
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	echo json_encode(array(
		"avaliacao"=>(count($arrAvaliacao)> 0) ? $arrAvaliacao : NULL,
		"success"=>true
	));
?>