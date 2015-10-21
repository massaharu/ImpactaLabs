<?php
require_once("class.RetornoCNAB400Base.php");

/**Classe para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643 com convênio de 7 posições.<br/>
* Layout Padrão CNAB/Febraban 400 posições<br/>.
* Baseado na documentação para "Layout de Arquivo Retorno para convênios na faixa numérica entre 1.000.000 a 9.999.999
* (Convênios de 7 posições). Versão Set/09" do Banco do Brasil (arquivo Doc8826BR643Pos6.pdf) adaptado para o Itaú por @AUTHOR = Massaharu,
* disponível em http://www.bb.com.br/docs/pub/emp/empl/dwn/Doc8826BR643Pos6.pdf
* @AUTHOR MASSA
*/
class RetornoCNAB400ItauV7 extends RetornoCNAB400Base {
  	/**@property int DETALHE Define o valor que identifica uma coluna do tipo DETALHE*/
	const DETALHE = 4;
  	/**@property int TRANSACAO Define o valor que identifica uma coluna do tipo TRANSACAO*/		
	const TRANSACAO = 1;
	/**@property int CHEQUE_DEVOLVIDO Define o valor que identifica uma ocorrência do tipo CHEQUE_DEVOLVIDO*/		
	const CHEQUE_DEVOLVIDO = 69;

	public function __construct($nomeArquivo=NULL, $aoProcessarLinhaFunctionName=""){
		parent::__construct($nomeArquivo, $aoProcessarLinhaFunctionName);
	}

	/**Processa a linha header do arquivo
	* @param string $linha Linha do header de arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos do header do arquivo.*/
	protected function processarHeaderArquivo($linha) {
		$vlinha = parent::processarHeaderArquivo($linha);
		
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["tipo_servico"]      = substr($linha, 12,    15); //LITERAL DE SERVIÇO - X Identificação por Extenso do Tipo de Serviço: "COBRANCA"
		unset($vlinha["complemento1"]);
		unset($vlinha["dv_agencia_cedente"]);
		$vlinha["complemento_registro"] = substr($linha, 31, 2);//ZEROS - 9 COMPLEMENTO DE REGISTRO
		$vlinha["conta_cedente"]        = substr($linha, 33, 5); //CONTA - 9 Número da Conta Corrente onde está cadastrado o Convênio Líder do Cedente
		$vlinha["dac"]                  = substr($linha, 38, 1); //DAC - 9 DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA
		unset($vlinha["dv_conta _cedente"]);
		$vlinha["cod_banco"]            = substr($linha, 77, 3); //CÓDIGO DO BANCO - 9 NÚMERO DO BANCO NA CÂMARA DE COMPENSAÇÃO
		$vlinha["banco"]                = substr($linha, 80, 15); //NOME DO BANCO - X NOME POR EXTENSO DO BANCO COBRADOR
		$vlinha["densidade"]            = substr($linha, 101, 5); //DENSIDADE - 9 UNIDADE DA DENSIDADE 	
		$vlinha["uni_densidade"]        = substr($linha, 106, 3); //UNIDADE DE DENSID. - X DENSIDADE DE GRAVAÇÃO DO ARQUIVO 
		$vlinha["num_seq_arquivo"]      = substr($linha, 109, 5); //Nº SEQ. ARQUIVO RET. - 9 NÚMERO SEQÜENCIAL DO ARQUIVO RETORNO 
		$vlinha["data_credito"]         = $this->formataData(substr($linha, 114, 6)); //DATA DE CRÉDITO - 9 DATA DE CRÉDITO DOS LANÇAMENTOS
		$vlinha["uni_densidade"]        = substr($linha, 106, 3); //UNIDADE DE DENSID. - 9 DENSIDADE DE GRAVAÇÃO DO ARQUIVO 
		
		return $vlinha;
	}

	/**Processa uma linha transacao do arquivo.
	* @param string $linha Linha detalhe do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe.*/
	protected function processarTransacao($linha) {
		$vlinha = parent::processarTransacao($linha);	                                                          
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		
		return $vlinha;
	}
	
	/**Processa uma linha transacao do arquivo.
	* @param string $linha Linha detalhe do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe.*/
	protected function processarTransacaoChequeDevolvido($linha) {
		$vlinha = parent::processarTransacao($linha);	            
		                                              
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA		
		unset($vlinha["data_vencimento"]); 
		$vlinha["valor_titulo"]          = $this->formataNumero(substr($linha, 153,  13)); //VALOR DO TÍTULO - 9  v99 VALOR NOMINAL DO TÍTULO 
		$vlinha["cod_banco"]             = substr($linha, 166,  3); //CÓDIGO DO BANCO - 9 NÚMERO DO BANCO NA CÂMARA DE COMPENSAÇÃO 
		$vlinha["agencia_cobradora"]     = substr($linha, 169,  4); //AGÊNCIA COBRADORA - 9 AG. COBRADORA, AG. DE LIQUIDAÇÃO OU BAIXA
		$vlinha["dac_agencia_cobradora"] = substr($linha, 173,  1); //DAC AG. COBRADORA - 9 DAC DA AGÊNCIA COBRADORA 
		unset($vlinha["especie"]);
		unset($vlinha["tarifa_cobranca"]);
		unset($vlinha["valor_iof"]);
		unset($vlinha["valor_abatimento"]);
		unset($vlinha["valor_desconto"]);
		unset($vlinha["valor_principal"]);
		unset($vlinha["valor_juros_mora"]);
		unset($vlinha["valor_outros_creditos"]);
		unset($vlinha["data_credito"]);
		unset($vlinha["cod_instr_cancelada"]);
		unset($vlinha["nome_sacado"]);
		unset($vlinha["erros"]);
		unset($vlinha["cod_liquidacao"]);
		$vlinha["valor_cheque"]         = $this->formataNumero(substr($linha, 254,  13)); //VALOR DO CHEQUE  - 9v99 VALOR DO CHEQUE 
		$vlinha["banda_magnetica"]      = substr($linha, 325,  30); //BANDA MAGNÉTICA - X BANDA MAGNÉTICA DO CHEQUE (CMC-7)
		$vlinha["motivo"] 				= substr($linha, 378,  2); //MOTIVO - X MOTIVO DE DEVOLUÇÃO DO CHEQUE
		$vlinha["num_sequencial"]       = substr($linha, 395,   6); //NÚMERO SEQÜENCIAL - 9 NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO 
		
		return $vlinha;
	}
	
	/**Processa uma linha detalhe do arquivo.
	* @param string $linha Linha detalhe do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe.*/
	protected function processarDetalhe($linha) {
		$vlinha = parent::processarDetalhe($linha);
		
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["cod_inscricao"]        = substr($linha, 2, 2); //CÓDIGO DE INSCRIÇÃO - 9 TIPO DE INSCRIÇÃO DA EMPRESA
		$vlinha["num_inscricao"]        = substr($linha, 4, 14); //NÚMERO DE INSCRIÇÃO - 9 Nº DE INSCRIÇÃO DA EMPRESA (CPF/CNPJ)
		$vlinha["complemento_zeros"]    = substr($linha,  22, 2); //ZEROS - 9 COMPLEMENTO DE REGISTRO
		$vlinha["cc_cedente"]           = substr($linha,  24,  5); //CONTA - 9  NÚMERO DA CONTA CORRENTE DA EMPRESA
		$vlinha["dac"]                  = substr($linha,  29,  1); //DAC - 9  DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA
		unset($vlinha["cc_cedente"]);
		unset($vlinha["dv_cc_cedente"]);
		unset($vlinha["taxa_desconto"]);
		unset($vlinha["taxa_iof"]);
		unset($vlinha["dv_cc_cedente"]);
		$vlinha["empresa"]              = substr($linha,  38, 25); //USO DA EMPRESA - X  IDENTIFICAÇÃO DO TÍTULO NA EMPRESA  
		$vlinha["nosso_numero"]         = substr($linha,  63, 8); //NOSSO NÚMERO  - 9  IDENTIFICAÇÃO DO TÍTULO NO BANCO   
		$vlinha["num_carteira"]         = substr($linha, 83, 3); //Nº DA CARTEIRA - 9 NÚMERO DA CARTEIRA
		$vlinha["nosso_numero2"]        = substr($linha,  86, 8); //NOSSO NÚMERO  - 9  IDENTIFICAÇÃO DO TÍTULO NO BANCO   
		$vlinha["dac_nosso_numero2"]    = substr($linha,  94, 1); //DAC NOSSO NÚMERO  - 9  DAC DO NOSSO NÚMERO   
		$vlinha["cod_carteira"]         = substr($linha, 108, 1); //CARTEIRA - 9 CÓDIGO DA CARTEIRA 
		$vlinha["cod_ocorrencia"]       = substr($linha, 109, 2); //CÓD. DE OCORRÊNCIA  - 9 IDENTIFICAÇÃO DA OCORRÊNCIA 
		$vlinha["num_seq_tipo4"]        = substr($linha, 111, 2); //SEQÜÊNCIA  - 9 NÚMERO SEQÜENCIAL DOS REGISTROS TIPO 4 DO TÍTULO 		
		$vlinha["valor_titulo"]         = $this->formataNumero(substr($linha, 113, 13)); //VALOR DO TITULO - 9 VALOR TOTAL RECEBIDO LÍQUIDO
		unset($vlinha["comando"]);
		unset($vlinha["data_ocorrencia"]);
		unset($vlinha["num_titulo"]); 
		unset($vlinha["data_vencimento"]);
		unset($vlinha["valor"]);
		unset($vlinha["cod_banco"]);
		unset($vlinha["agencia"]);
		unset($vlinha["dv_agencia"]);
		unset($vlinha["especie"]);
		unset($vlinha["data_credito"]);
		unset($vlinha["valor_tarifa"]);
		unset($vlinha["outras_despesas"]);     
		unset($vlinha["juros_desconto"]);     
		unset($vlinha["iof_desconto"]);        
		unset($vlinha["valor_abatimento"]);   
		unset($vlinha["desconto_concedido"]);  
		unset($vlinha["valor_recebido"]);     
		unset($vlinha["juros_mora"]);         
		unset($vlinha["outros_recebimentos"]);
		unset($vlinha["abatimento_nao_aprov"]);
		unset($vlinha["valor_lancamento"]);    
		unset($vlinha["indicativo_dc"]);       
		unset($vlinha["indicador_valor"]);     
		unset($vlinha["valor_ajuste"]);        
		unset($vlinha["canal_pag_titulo"]);    
		$vlinha["num_agencia_1"]     = substr($linha, 126, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_1"]       = substr($linha, 130, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_1"]             = substr($linha, 137, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_1"]   = $this->formataNumero(substr($linha, 138, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_1"]  = $this->formataNumero(substr($linha, 151, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["num_agencia_2"]     = substr($linha, 161, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_2"]       = substr($linha, 165, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_2"]             = substr($linha, 172, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_2"]   = $this->formataNumero(substr($linha, 173, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_2"]  = $this->formataNumero(substr($linha, 186, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEAD 
		$vlinha["num_agencia_3"]     = substr($linha, 196,4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_3"]       = substr($linha, 200, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_3"]             = substr($linha, 207, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_3"]   = $this->formataNumero(substr($linha, 208, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_3"]  = $this->formataNumero(substr($linha, 221, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["num_agencia_4"]     = substr($linha, 231, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_4"]       = substr($linha, 235, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_4"]             = substr($linha, 242, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_4"]   = $this->formataNumero(substr($linha, 243, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_4"]  = $this->formataNumero(substr($linha, 256, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["num_agencia_5"]     = substr($linha, 266, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_5"]       = substr($linha, 270, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_5"]             = substr($linha, 277, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_5"]   = $this->formataNumero(substr($linha, 278, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_5"]  = $this->formataNumero(substr($linha, 291, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["num_agencia_6"]     = substr($linha, 301, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_6"]       = substr($linha, 305, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_6"]             = substr($linha, 312, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_6"]   = $this->formataNumero(substr($linha, 313, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_6"]  = $this->formataNumero(substr($linha, 326, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["num_agencia_7"]     = substr($linha, 336, 4); //AGENCIA - 9 NÚMERO DA AGÊNCIA DA CONTA DE CRÉDITO
		$vlinha["num_conta_7"]       = substr($linha, 340, 7); //CONTA - 9v99 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["dac_7"]             = substr($linha, 347, 1); //CONTA - 9 NÚMERO DA CONTA DE CRÉDITO
		$vlinha["valor_credito_7"]   = $this->formataNumero(substr($linha, 348, 13)); //VALOR - 9v99 VALOR DE CRÉDITO
		$vlinha["valor_encargos_7"]  = $this->formataNumero(substr($linha, 361, 10)); //VALOR ENCARGOS - 9v99 VALOR ENCARGOS DO RATEADO
		$vlinha["tipo_valor"]        = substr($linha, 394, 1); //TIPO DE VALOR - X NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO  		
		
		return $vlinha;
	}
	
	protected function processarTrailerArquivo($linha) {
		$vlinha = parent::processarTrailerArquivo($linha);
		
		unset($vlinha["cob_cauc_qtd_titulos"]);
		unset($vlinha["cob_cauc_vlr_total"]);    
		unset($vlinha["cob_cauc_num_aviso"]); 
		unset($vlinha["cob_desc_qtd_titulos"]); 
		unset($vlinha["cob_desc_vlr_total"]);   
		unset($vlinha["cob_desc_num_aviso"]);
		unset($vlinha["cob_desc_qtd_titulos"]);
		unset($vlinha["cob_desc_vlr_total"]);
		unset($vlinha["cob_desc_num_aviso"]);
		unset($vlinha["cob_vendor_qtd_titulos"]);
		unset($vlinha["cob_vendor_vlr_total"]);
		unset($vlinha["cob_vendor_num_aviso"]);
		$vlinha["cob_direta_qtd_titulos"] = substr($linha, 178, 8); //QTDE. DE TÍTULOS - 9 QTDE. DE TÍTULOS EM COBR. DIRETA./ESCRITURAL
		$vlinha["cob_direta_vlr_total"]   = $this->formataNumero(substr($linha, 186, 14)); //VALOR TOTAL - 9v99 VR TOTAL DOS TÍTULOS EM COBR. DIRETA/ESCRIT.
		$vlinha["cob_direta_num_aviso"]   = substr($linha, 200, 8); //AVISO BANCÁRIO - X REFERÊNCIA DO AVISO BANCÁRIO 
		$vlinha["controle_arquivo"]       = substr($linha, 208, 5); //CONTROLE DO ARQUIVO - 9 NÚMERO SEQÜENCIAL DO ARQUIVO RETORNO 
		$vlinha["qtd_detalhes"] 		  = $this->formataNumero(substr($linha, 213, 8),0); //QTDE DE DETALHES - 9 QUANTIDADE DE REGISTROS DE TRANSAÇÃO
		$vlinha["vlr_total_arquivo"] 	  = $this->formataNumero(substr($linha, 221, 14)); //VLR TOTAL INFORMADO - 9v99 VALOR DOS TÍTULOS INFORMADOS NO ARQUIVO
		
		return $vlinha;
	}

	/**Processa uma linha do arquivo de retorno.
  * @param int $numLn Número_linha a ser processada
	* @param string $linha String contendo a linha a ser processada
	* @return array Retorna um vetor associativo contendo os valores_linha processada.*/
	public function processarLinha($numLn, $linha) {
		$tamLinha = 400; //total de caracteres das linhas do arquivo
		//o +2 é utilizado para contar o \r\n no final da linha
		if(strlen($linha) != $tamLinha and strlen($linha) != $tamLinha+2)
			die("A linha $numLn não tem $tamLinha posições. Possui " . strlen($linha));
		if(trim($linha)=="")
			die("A linha $numLn está vazia.");
		
		//é adicionado um espaço vazio no início_linha para que
		//possamos trabalhar com índices iniciando_1, no lugar_zero,
		//e assim, ter os valores_posição_campos exatamente
		//como no manual CNAB400
		$linha = " $linha";
		$tipoLn = substr($linha,  1,  1);
		
		if($tipoLn == $this::HEADER_ARQUIVO){ 
			$vlinha = $this->processarHeaderArquivo($linha);
		}else if($tipoLn == $this::TRANSACAO){
			$cod_ocorrencia = substr($linha, 109, 2);
			if($cod_ocorrencia == $this::CHEQUE_DEVOLVIDO){
				$vlinha =  $this->processarTransacaoChequeDevolvido($linha);
			}else{
				$vlinha =  $this->processarTransacao($linha);
			}
		}else if($tipoLn == $this::DETALHE){
			$vlinha =  $this->processarDetalhe($linha);			 
		}else if($tipoLn == $this::TRAILER_ARQUIVO){
		    $vlinha = $this->processarTrailerArquivo($linha); 
		}else{ 
			$vlinha = NULL;
		}
			
		return $vlinha;
	}
}

?>
