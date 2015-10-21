<?
	# @AUTOR: renan #
	$GLOBALS["JSON"] = true;
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");
	
	$iduser = post("idusuario");
	$dt1	= post("dt1");
	$dt2 	= post("dt2");
	$data= array();
	
	$a = Sql::arrays("Saturn","Ecommerce","sp_afiliadosrelatorio_get $iduser, '$dt1', '$dt2'");
		
	foreach($a as $al){
		array_push($data,array(
			'Matricula'=>$al['matricula'],
			'VlTotal'=>$al['vltotal'],
			'DtCadastramento'=>date("d/m/Y H:i", $al['dtcadastro']),
			'NmAluno'=>$al['nome_cli'],
			'DesPagto'=>$al['despagto'], 
			'DesTransacao'=>$al['destransacao'],
			'NrParcelas'=>$al['nrparcelas']
		));
	}
	
	echo json_encode(array(
		"mydata"=>$data,
		"aa"=>"sp_afiliadosrelatorio_get $iduser, '$dt1', '$dt2'",
		"success"=>true
		
	));
?>