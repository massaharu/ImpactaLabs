<?
	# @AUTOR: renan#
	/*PHP que carrega a ABA NOTA FISCAL da ABA DADOS DO CLIENTE da janela FICHA DE MATRICULA*/	
	$GLOBALS["JSON"] = true;
	require_once($_SERVER["DOCUMENT_ROOT"] . "/simpacweb/inc/configuration.php");

	$matricula = trim(post("matricula"));
	$id = "alterarNF_";
	
	$arrDados = array();
	$arrDados2 = array();
	$arrCombo = array();
	
	$select = "sp_NotaFiscalFaturamentoEnderecosLocaliza '$matricula'";
	$selectQuery = Sql::arrays("Saturn","Simpac",$select);
	foreach($selectQuery as $e){
		array_push($arrDados,array(
			'idregistro'=>$e["IdRegistro"],
			'matricula'=>$e["Matricula"],
			'endereco'=>$e["Endereco"],
			'cep'=>$e["cep"],
			'bairro'=>$e["Bairro"],
			'cidade'=>$e["Cidade"],
			'estado'=>$e["Estado"],
			'enderecoEntrega'=>$e["EnderecoEntrega"],
			'bairroEntrega'=>$e["BairroEntrega"],
			'cidadeEntrega'=>$e["CidadeEntrega"],
			'estadoEntrega'=>$e["EstadoEntrega"],
			'cepEntrega'=>$e["CEPEntrega"],
			'contato'=>$e["Contato"],
			'cadastrado'=>date("d/m/Y", $e["DtCadastro"]),
			'fone'=>$e["Fone"],
			'fax'=>$e["Fax"],
			'email'=>$e["Email"],
			'obs'=>$e["obs"],
			'enderecoNF'=>$e["EnderecoNF"],
			'tipoendereco'=>$e["TipoEndereco"],
			'numeroendereco'=>$e["NumeroEndereco"],
			'complemento'=>$e["Complemento"],
			'emailNF'=>$e["EmailNF"],
			'nrim'=>$e["NrInscricaoMunicipal"],
		));
	}
	
	$select = "sp_NotasMatricula '$matricula'";
	$selectQuery = Sql::arrays("Saturn","Simpac",$select);
	foreach($selectQuery as $e){
		array_push($arrDados2,array(
			'notafiscal'=>$e["NRNOTAFISCAL"]
		));
	}

	if(!is_null($arrDados)){
		echo json_encode(array(
			'success'=>true,
			'data'=>array(
				$id."nf_ccm"=>$arrDados[0]["nrim"],
				$id."nf_tipo_endereco"=>trim($arrDados[0]["tipoendereco"]),
				$id."nf_endereco"=>(is_null($arrDados[0]["endereco"])) ? "" : $arrDados[0]["endereco"],
				$id."nf_numero"=>(is_null($arrDados[0]["numeroendereco"])) ? "" : $arrDados[0]["numeroendereco"],
				$id."nf_complemento"=>(is_null($arrDados[0]["complemento"])) ? "" : str_replace("?", "-", $arrDados[0]["complemento"]),
				$id."nf_cep"=>(is_null($arrDados[0]["cep"]))  ? ""  : $arrDados[0]["cep"],
				$id."nf_bairro"=>(is_null($arrDados[0]["bairro"])) ? ""  : $arrDados[0]["bairro"],
				$id."nf_cidade"=>(is_null($arrDados[0]["cidade"])) ? ""  : $arrDados[0]["cidade"],
				$id."nf_comboUF"=>(is_null($arrDados[0]["estado"])) ? "" : $arrDados[0]["estado"],
				$id."nf_email"=>$arrDados[0]["emailNF"],
				$id."nf_referencia"=>$arrDados[0]["enderecoNF"],
				$id."nf_obs"=>$arrDados[0]["obs"],
				//record abaixo referente a entrega
				$id."nf_contato"=>(is_null($arrDados[0]["contato"])) ? "" : $arrDados[0]["contato"],
				$id."nf_telefone"=>(is_null($arrDados[0]["fone"]))   ? "" : $arrDados[0]["fone"],  
				$id."nf_fax"=>(is_null($arrDados[0]["fax"]))		 ? "" : $arrDados[0]["fax"],
				$id."nf_email2"=>(is_null($arrDados[0]["email"]))	 ? "" : $arrDados[0]["email"],
				$id."nf_endereco2"=>(is_null($arrDados[0]["enderecoEntrega"])) ? "" : $arrDados[0]["enderecoEntrega"],
				$id."nf_bairro2"=>(is_null($arrDados[0]["bairroEntrega"])) ? "" : $arrDados[0]["bairroEntrega"],
				$id."nf_cep2"=>(is_null($arrDados[0]["cepEntrega"])) ? "" : $arrDados[0]["cepEntrega"],
				$id."nf_cidade2"=>(is_null($arrDados[0]["cidadeEntrega"])) ? "" : $arrDados[0]["cidadeEntrega"],
				$id."nf_comboUF2"=>(is_null($arrDados[0]["estadoEntrega"])) ? "" : $arrDados[0]["estadoEntrega"],
				$id."nf_combo"=>$arrDados2[0]["notafiscal"],
			)
		));
	}

?>