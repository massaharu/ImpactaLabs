<?
$GLOBALS["JSON"] = true;	
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");
	

$fileName = $_FILES['picture'];

$reading = fopen($fileName['tmp_name'],'r');

if (!$reading){
	echo json_encode(array(
		"success"=>false,
		"msg"=>"Erro na leitura do arquivo. Favor tentar novamente. Caso o erro persista solicitar ajuda"
	));
	exit();
}

if(move_uploaded_file($fileName["tmp_name"], utf8_decode( "//opel/corporate/Simpac Web Site/simpacweb/labs/Massaharu/extjsTelas/19.baixaBoletoAutomatico/uploaded/").$fileName['name'])){

}else{
	echo json_encode(array('success'=>false, 'msg'=>'Sem permissão de escrita.'));	
	exit();	
}
/**Exemplo de uso da classe para processamento de arquivo de retorno de cobranças em formato FEBRABAN/CNAB400,
* testado com arquivo de retorno do Banco do Brasil com convênio de 7 posições.<br/>
*/

//Adiciona a classe strategy RetornoBanco que vincula um objeto de uma sub-classe
//de RetornoBase, e assim, executa o processamento do arquivo de uma determinada
//carteira de um banco específico.
require_once("../inc/class/class.RetornoBanco.php");
require_once("../inc/class/class.RetornoFactory.php");

/**Função handler a ser associada ao evento aoProcessarLinha de um objeto da classe
* RetornoBase. A função será chamada cada vez que o evento for disparado.
* @param RetornoBase $self Objeto da classe RetornoBase que está processando o arquivo de retorno
* @param $numLn Número da linha processada.
* @param $vlinha Vetor contendo a linha processada, contendo os valores da armazenados
* nas colunas deste vetor. Nesta função o usuário pode fazer o que desejar,
* como setar um campo em uma tabela do banco de dados, para indicar
* o pagamento de um boleto de um determinado cliente.
* @see linhaProcessada1
*/
$_SESSION["header_content"] = array();
$_SESSION["transacao_content"] = array();
$_SESSION["detalhe_content"] = array();
$_SESSION["trailer_content"] = array();

global $vetor;
$vetor = array();

function linhaProcessada($self, $numLn, $vlinha) {
	global $header_content;
	global $trailer_content;
	global $header_count;
	global $transacao_count;
	global $lotes_count;
	global $trailer_count;
	global $total_count;
	//$detalhe_content = array(array());
	if($vlinha) {
		
		
		if($vlinha["tipo_registro"] == $self::HEADER_ARQUIVO) {
			array_push($_SESSION["header_content"], $vlinha);
			$header_count +=1;
		}
		if($vlinha["tipo_registro"] == $self::TRANSACAO) {
			array_push($_SESSION["transacao_content"], $vlinha);
			$lotes_count +=1;
		}
		if($vlinha["tipo_registro"] == $self::DETALHE) {
						
			array_push($_SESSION["detalhe_content"], $vlinha);
				
			$lotes_count +=1;
		}
		if($vlinha["tipo_registro"] == $self::TRAILER_ARQUIVO) {
			array_push($_SESSION["trailer_content"], $vlinha);
			$trailer_count +=1;
		}
		
		
	} else echo "Tipo da linha n&atilde;o identificado<br/>\n";
	$total_count +=1;
}


/**Outro exemplo de função handler, a ser associada ao evento
* aoProcessarLinha de um objeto da classe RetornoBase.
* Neste exemplo, é utilizado um laço foreach para percorrer
* o vetor associativo $vlinha, mostrando os nomes das chaves
* e os valores obtidos da linha processada.
* @see linhaProcessada */
//$archive_content = array();

//function linhaProcessada1($self, $numLn, $vlinha) {
//	//printf("%08d) ", $numLn);
//	$archive_content = $vlinha;
//	if($vlinha) {
//		echo "<table border='1'>";
//		foreach($vlinha as $nome_indice => $valor){
//			
//			echo "<tr>";
//			echo "<td>$nome_indice: </td><td><b>$valor</b></td>";
//			echo "</tr>";
//		} 
//		echo "</table><br />";
//	}else{ 
//		//echo "Tipo da linha n&atilde;o identificado<br/>\n";
//	}
//	
//	
//}


//--------------------------------------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------
//$fileName_b = "returned/retorno_cnab400conv7.ret";
//$fileName = "returned/CN11033A.ret";

//Use uma das duas instrucões abaixo (comente uma e descomente a outra)
try{
	$cnab400 = RetornoFactory::getRetorno("../uploaded/".$fileName['name'], "linhaProcessada");
}catch(Exception $e){
	echo json_encode(array(
		"success"=>false,
		"exception"=>$e->getMessage()
	));
	exit();
}
//$cnab400_b = RetornoFactory::getRetorno($fileName_b, "linhaProcessada1");
//$cnab400 = RetornoFactory::getRetorno($fileName, "linhaProcessada");

$retorno = new RetornoBanco($cnab400);
$retorno->processar();

$arquivo = array();

function emptyNumber($n){
	if($n == "" || $n == NULL){
		return "''";
	}
	return $n;
}
function emptyDate($n){
	if($n == "" || $n == NULL || $n == "1969-12-31"){
		return "NULL";
	}
	return "'".$n."'";
}

foreach($_SESSION["header_content"] as $key=>$value){
	$data_geracao = explode("/", $value['data_geracao']);
	$data_geracao = date("Y-m-d", strtotime($data_geracao[2]."-".$data_geracao[1]."-".$data_geracao[0]));
	$data_credito = explode("/", $value['data_credito']);
	$data_credito = date("Y-m-d", strtotime($data_credito[2]."-".$data_credito[1]."-".$data_credito[0]));
	
	foreach($_SESSION["trailer_content"] as $key=>$value2){
	
		array_push($arquivo, array(
			'id_tipo_registro'=>$value['id_tipo_registro'],
			'tipo_servico'=>$value['tipo_servico'],
			'agencia_cedente'=>$value['agencia_cedente'],
			'conta_cedente'=>$value['conta_cedente'],
			'dac'=>$value['dac'],
			'nome_cedente'=>$value['nome_cedente'],
			'cod_banco'=>$value['cod_banco'],
			'banco'=>$value['banco'],
			'data_geracao'=>$data_geracao,
			'num_seq_arquivo'=>$value['num_seq_arquivo'],
			'data_credito'=>$data_credito,
			'cob_direta_num_aviso'=>$value2['cob_direta_num_aviso'],
			'cob_direta_qtd_titulos'=>$value2['cob_direta_qtd_titulos'],
			'cob_direta_vlr_total'=>$value2['cob_direta_vlr_total'],
			'cob_simples_num_aviso'=>$value2['cob_simples_num_aviso'],
			'cob_simples_qtd_titulos'=>$value2['cob_simples_qtd_titulos'],
			'cob_simples_vlr_total'=>$value2['cob_simples_vlr_total'],
			'cob_simples_num_aviso'=>$value2['cob_simples_num_aviso'],
			'cob_simples_qtd_titulos'=>$value2['cob_simples_qtd_titulos'],
			'cob_simples_vlr_total'=>$value2['cob_simples_vlr_total'],
			'cob_vinc_num_aviso'=>$value2['cob_vinc_num_aviso'],
			'cob_vinc_qtd_titulos'=>$value2['cob_vinc_qtd_titulos'],
			'cob_vinc_valor_total'=>$value2['cob_vinc_valor_total'],
			'qtd_detalhes'=>$value2['qtd_detalhes'],
			'vlr_total_arquivo'=>$value2['vlr_total_arquivo']
		));
	}
}

foreach($arquivo as $key=>$value){
	
	$idarquivo = Sql::select("SATURN", "FINANCEIRO", "sp_shoplineretorno_save ".emptyNumber($value['id_tipo_registro']).", '".$value['tipo_servico']."', '".$value['agencia_cedente']."', '".$value['conta_cedente']."', '".$value['dac']."', '".$value['nome_cedente']."', '".$value['cod_banco']."', '".$value['banco']."', ".emptyDate($data_geracao).", '".$value['num_seq_arquivo']."', ".emptyDate($data_credito).", '".$value['cob_direta_num_aviso']."', '".$value['cob_direta_qtd_titulos']."', ".emptyNumber($value['cob_direta_vlr_total']).", '".$value['cob_simples_num_aviso']."', '".$value['cob_simples_qtd_titulos']."', ".emptyNumber($value['cob_simples_vlr_total']).", '".$value['cob_vinc_num_aviso']."', '".$value['cob_vinc_qtd_titulos']."', ".emptyNumber($value['cob_vinc_valor_total']).", ".$value['qtd_detalhes'].", ".emptyNumber($value['vlr_total_arquivo']));
	
	if($_SESSION["transacao_content"] != "" && $_SESSION["transacao_content"] != NULL && $idarquivo['idarquivo'] != ""){
		foreach($_SESSION["transacao_content"] as $key=>$value2){
			$data_credito = explode("/", $value2['data_credito']);
			$data_credito = date("Y-m-d", strtotime($data_credito[2]."-".$data_credito[1]."-".$data_credito[0]));
			$data_ocorrencia = explode("/", $value2['data_ocorrencia']);
			$data_ocorrencia = date("Y-m-d", strtotime($data_ocorrencia[2]."-".$data_ocorrencia[1]."-".$data_ocorrencia[0]));
			$data_vencimento = explode("/", $value2['data_vencimento']);
			$data_vencimento = date("Y-m-d", strtotime($data_vencimento[2]."-".$data_vencimento[1]."-".$data_vencimento[0]));
			
			
			Sql::insert("SATURN", "FINANCEIRO", "sp_shoplineretorno_transacao_save ".emptyNumber($idarquivo['idarquivo']).", ".emptyNumber($value2['tipo_registro']).", '".$value2['agencia_cobradora']."', '".$value2['cod_carteira']."', '".$value2['num_carteira']."', '".$value2['cod_inscricao']."', '".$value2['num_inscricao']."', '".$value2['cod_instr_cancelada']."', '".$value2['cod_liquidacao']."', ".emptyNumber($value2['cod_ocorrencia']).", '".$value2['dac_agencia_cobradora']."', '".$value2['dac_nosso_numero']."', ".emptyDate($data_credito).", ".emptyDate($data_ocorrencia).", ".emptyDate($data_vencimento).", '".$value2['erros']."', '".$value2['especie']."', '".$value2['nome_sacado']."', '".$value2['nosso_numero1']."', '".$value2['num_documento']."', ".emptyNumber($value2['tarifa_cobranca']).", '".$value2['uso_empresa']."', ".emptyNumber($value2['valor_abatimento']).", ".emptyNumber($value2['valor_desconto']).", ".emptyNumber($value2['valor_iof']).", ".emptyNumber($value2['valor_juros_mora']).", ".emptyNumber($value2['valor_outros_creditos']).", ".emptyNumber($value2['valor_principal']).", ".emptyNumber($value2['valor_titulo']));
		}
	}
}

$archive_details = array();
array_push($archive_details, array(
		"filename"=>$fileName['name'],
		"type"=>$fileName['type'],
		"size"=>$fileName['size'],
		"nr_lotes"=>$lotes_count,
		"nr_registros"=>$total_count,
		"idarquivo"=>$idarquivo['idarquivo']
	));

echo json_encode(array(
		"success"=>true,
		"archive_details"=>$archive_details,
		"header_content"=>$_SESSION["header_content"],
		"transacao_content"=>$_SESSION["transacao_content"],
		"detalhe_content"=>$_SESSION["detalhe_content"],
		"trailer_content"=>$_SESSION["trailer_content"],
	));
	
unset($_SESSION["detalhe_content"]);
unset($_SESSION["transacao_content"]);	
unset($_SESSION["header_content"]);
unset($_SESSION["trailer_content"]);
?>  
