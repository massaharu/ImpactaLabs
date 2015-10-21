<? 
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php"); 

$idarquivo = post('idarquivo');
//$idarquivo = 100;
$myData = array();
$pagtoNaoBaixado = array();
$pagtoNaoEncontrado = array();

$idarquivo = $idarquivo? $idarquivo : "''";

$transacao = Sql::arrays("SATURN", "FINANCEIRO", "sp_shoplineretorno_transacaobyarquivo_list ".$idarquivo);

//Para cada linha de transação encontrada do arquivo
foreach($transacao as $key=>$value){
	
	$num_documento = (int)trim($value['num_documento']);
	
	//Se o número do documento da transação do arquivo não for vazio ou nulo
	if(!($num_documento == "" || $num_documento == NULL)){
		
		$data = Sql::arrays("SATURN", "Ecommerce", "sp_baixaPagamentoItau_get ".$num_documento);
		
		//Se o número do documento da transação do arquivo NÃO for encontrado
		if($data[0] == NULL){
			array_push($pagtoNaoEncontrado,(
				array(
					'num_documento'=>$value['num_documento'],
					'nome_sacado'=>$value['nome_sacado']
				)
			));
			$pagtonaoencontrado_count++;
		//Se o número do documento da transação do arquivo FOR encontrado
		}else{
		
			$data[0]['semMatricula'] = false;
			
			if($data[0]["idservico"] == 5){ // 5 = Pagamento de Matricula
				$nrparcelas = Sql::select("SATURN", "Ecommerce", "sp_baixaPagamentoNrParcelas_get ".$data[0]["sessionid"].",".$data[0]["cod_cli"]);
			
				$data[0]["matricula"] = $nrparcelas["matricula"];
				
				//Se não tiver parcelas
				if((int)$nrparcelas["matricula"] == 0){
					$data[0]['semMatricula'] = true;						
				}
			}
			
			
			if($data > 0){
				$data[0]['desformapagto'] = $data[0]['despagto'].' em '.$data[0]['nrparcelas'].'x';
			}
			
			//Se não tiver matrícula
			if(!$data[0]['matricula']){
				
				if($data[0]['sessionid'] == "" || $data[0]['sessionid'] == NULL){
					$data[0]['sessionid'] = "''";
				}
				
				$matricula = Sql::select('SATURN','Ecommerce',"sp_baixaPagamentoMatriculaBySessionid_get ".$data[0]['sessionid']);
				
				$data[0]['matricula'] = $matricula['matricula'];
			}
			
			if($matricula || $data[0]['matricula']){
				
				$baixa = Sql::select("SATURN","Ecommerce","sp_baixaPagamentoVltotalbyMatricula_get '".$data[0]['matricula']."'");
				
				if($baixa){
					$data[0]['vlbaixa'] = (float)$baixa['vlparcela'];
				}
			}
			
			$recibo = Sql::select('SATURN','Ecommerce',"sp_baixaPagamentoReciboBySessionid_get ".$data[0]['sessionid']);
			
			//Se encontrar o idrecibo o pagamento já teve baixa
			if($recibo != NULL && $recibo != ""){
				$data[0]['idrecibo'] = $recibo['idrecibo'];
				
				if($data[0]['idrecibo'] > 0 && !$data[0]['matricula'] && !$data[0]['vlbaixa']){
		
					//Se existir um registro em tb_LojaVirtualBaixaRecibo, deletar o mesmo.
					Sql::query('SATURN','Simpac',"sp_baixaPagamentoLojaVirtualBaixaRecibo_delete ".$recibo['idrecibo']);
						
				}
			//Se NÃO encontrar o idrecibo	
			}else{
				/*
					SCRIPT PARA DAR A BAIXA DO PAGAMENTO
				*/
				//$data[0]['sessionid'];
				//$data[0]['dtcadastro'];
			}
			
			array_push($myData, $data[0]);
		}
	}else{
		
		array_push($pagtoNaoBaixado,(
			array(
				'nosso_numero'=>(int)trim($value['nosso_numero']),
				'dac_nosso_numero'=>(int)trim($value['dac_nosso_numero'])
			)
		));
		
		$pagtonaobaixado_count++;
		
	}
}

echo json_encode(array(
		"success"=>true, 
		"myData"=>$myData,
		"pagtoNaoBaixado"=>$pagtoNaoBaixado,
		"pagtoNaoEncontrado"=>$pagtoNaoEncontrado,
		"details"=>array(
			"pagtonaobaixado_count"=>$pagtonaobaixado_count,
			"pagtonaoencontrado_count"=>$pagtonaoencontrado_count
		)
	));

?>