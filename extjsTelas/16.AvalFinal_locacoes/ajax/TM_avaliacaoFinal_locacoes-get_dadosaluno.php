<?
# @AUTOR: massa#
	
	$GLOBALS["JSON"] = true;
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");
	
	$idaluno = post('idaluno');
	$idcursoagendado = post('idcursoagendado');	
	
	$arrDados = array();
	$arrDados2 = array();
	
	$curso = new CursoAgendado($idcursoagendado);
	
	$arrDados = $curso->getAlunosMatriculas();
	
	foreach($arrDados as $valor2){
		if($valor2["idaluno"] == $idaluno){
			array_push($arrDados2, array(
				//"idalunoagendado"=>$valor2["idalunoagendado"],
				//"dtcadastramento"=>$valor2["dtcadastramento"],
				//"matricula"=>$valor2["matricula"],
				//"nrfalta"=>$valor2["nrfalta"],
				//"infinanceiro"=>$valor2["infinanceiro"],
				"idaluno"=>$valor2["idaluno"],
				"nmaluno"=>$valor2["nmaluno"],
				"nmempresa"=>$valor2["nmempresa"],
				//"nome"=>$valor2["nome"],
				//"nmusuario"=>$valor2["nmusuario"],				
				//"idcontrolefinanceiro"=>$valor2["idcontrolefinanceiro"],
				//"inrecebido"=>$valor2["inrecebido"],
				//"idaceito"=>$valor2["idaceito"],
			));
		}
	}
	
	$aluno = new Aluno($idaluno);		
	
	echo json_encode(array(
		'mydata'=>$arrDados2,
		'data'=>array(
			'email'=>$aluno->cdemail,
		),
		'success'=>true,
	)); 
	
	

?>