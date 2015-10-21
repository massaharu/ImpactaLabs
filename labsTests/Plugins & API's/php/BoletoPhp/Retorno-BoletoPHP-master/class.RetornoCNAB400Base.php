<?php
/**@AUTHOR massa*/
require_once("class.RetornoBase.php");

/**Classe abstrata para leitura de arquivos de retorno de cobranças no padrão CNAB400/CBR643.<br/>
* Layout Padrão CNAB/Febraban 400 posições<br/>.
* Baseado na documentação para "Layout de Arquivo Retorno para Convênios
* na faixa numérica entre 000.001 a 999.999 (Convênios de até 6 posições). Versão Set/09" e
* "Layout de Arquivo Retorno para convênios na faixa numérica entre 1.000.000 a 9.999.999
* (Convênios de 7 posições). Versão Set/09" do Banco do Brasil adaptado para o Itaú por @Massaharu
* (arquivos Doc8826BR643Pos6.pdf e Doc2628CBR643Pos7.pdf)
*/
abstract class RetornoCNAB400Base extends RetornoBase {
	/**@property int HEADER_ARQUIVO Define o valor que identifica uma coluna do tipo HEADER DE ARQUIVO*/
	const HEADER_ARQUIVO = 0;
	const TRANSACAO = "";
  	/**@property int TRAILER_ARQUIVO Define o valor que identifica uma coluna do tipo TRAILER DE ARQUIVO*/
	const TRAILER_ARQUIVO = 9;

  public function __construct($nomeArquivo=NULL, $aoProcessarLinhaFunctionName=""){
       parent::__construct($nomeArquivo, $aoProcessarLinhaFunctionName);
  } 

	/**Processa a linha header do arquivo
	* @param string $linha Linha do header de arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos do header do arquivo.*/
  protected function processarHeaderArquivo($linha) {
    	$vlinha = array();	
		
	    //X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["id_tipo_registro"]      = substr($linha, 1,     1); //TIPO DE REGISTRO - 9 Identificação do Registro Header: “0”
		$vlinha["id_tipo_operacao"]      = substr($linha, 2,     1); //CÓDIGO DE RETORNO - 9 Tipo de Operação: “2”
		$vlinha["tipo_operacao"]   = substr($linha, 3,     7); //LITERAL DE RETORNO - X IDENTIFICAÇÃO. POR EXTENSO DO TIPO DE MOVIMENTO
		$vlinha["id_tipo_servico"]       = substr($linha, 10,    2); //CÓDIGO DO SERVIÇO - 9 Identificação do Tipo de Serviço: “01”
		$vlinha["tipo_servico"]    = substr($linha, 12,    8); //LITERAL DE SERVIÇO - X Identificação por Extenso do Tipo de Serviço: “COBRANCA”
		$vlinha["complemento1"]       = substr($linha, 20,    7); //X Complemento do Registro: “Brancos”
		$vlinha["agencia_cedente"]    = substr($linha, 27,    4); //AGÊNCIA - 9 Prefixo da Agência: AGÊNCIA MANTENEDORA DA CONTA
		$vlinha["dv_agencia_cedente"] = substr($linha, 31,    1); //X Dígito Verificador - D.V. - do Prefixo da Agência
		$vlinha["conta_cedente"]      = substr($linha, 32,    8); //CONTA - 9 Número da Conta Corrente onde está cadastrado o Convênio Líder do Cedente
		$vlinha["dv_conta _cedente"]  = substr($linha, 40,    1); //X Dígito Verificador - D.V. - da Conta Corrente do Cedente
		$vlinha["nome_cedente"]       = substr($linha, 47,   30); //NOME DA EMPRESA - X NOME POR EXTENSO DA "EMPRESA MÃE"
		$vlinha["banco"]     		  = substr($linha, 77,   18); //X 001BANCODOBRASIL
		$vlinha["data_geracao"]      = $this->formataData(substr($linha, 95,    6)); //DATA DE GERAÇÃO - 9 DATA DE GERAÇÃO DO ARQUIVO 
		$vlinha["num_sequencial"]     = substr($linha, 395,   6); //NÚMERO SEQÜENCIAL - 9 NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO 
		
	  return $vlinha;
	}
	
	/**Processa uma linha detalhe do arquivo.
	* @param string $linha Linha detalhe do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe.*/
	protected function processarTransacao($linha) {
		$vlinha = array();
		
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["tipo_registro"]         = substr($linha,   1,   1); //TIPO DE REGISTRO - 9  IDENTIFICAÇÃO DO REGISTRO TRANSAÇÃO 
		$vlinha["cod_inscricao"]         = substr($linha,  2,   2); //CÓDIGO DE INSCRIÇÃO - 9  IDENTIFICAÇÃO DO TIPO DE INSCRIÇÃO/EMPRESA
		$vlinha["num_inscricao"]         = substr($linha,  4,   14); //NÚMERO DE INSCRIÇÃO - 9  NÚMERO DE INSCRIÇÃO DA EMPRESA (CPF/CNPJ)
		$vlinha["agencia"]               = substr($linha,  18,  4); //AGÊNCIA - 9  AGÊNCIA MANTENEDORA DA CONTA
		$vlinha["complemento_zeros"]     = substr($linha,  22,   2); //ZEROS - 9 COMPLEMENTO DE REGISTRO
		$vlinha["conta"]                 = substr($linha,  24,   5); //CONTA - 9  NÚMERO DA CONTA CORRENTE DA EMPRESA
		$vlinha["dac"]                   = substr($linha, 29,   1); //DAC - 9  DÍGITO DE AUTO CONFERÊNCIA AG/CONTA EMPRESA
		$vlinha["uso_empresa"]           = substr($linha, 38,   25); //USO DA EMPRESA - X IDENTIFICAÇÃO DO TÍTULO NA EMPRESA
		$vlinha["nosso_numero1"]         = substr($linha, 63,   8); //NOSSO NÚMERO - 9 IDENTIFICAÇÃO DO TÍTULO NO BANCO 
		$vlinha["num_carteira"]          = substr($linha, 83,   3); //CARTEIRA - 9 NUMERO DA CARTEIRA
		$vlinha["nosso_numero2"]         = substr($linha, 86,  8); //NOSSO NÚMERO - X IDENTIFICAÇÃO DO TÍTULO NO BANCO 
		$vlinha["dac_nosso_numero"]      = substr($linha, 94,   1); //DAC NOSSO NÚMERO - 9 DAC DO NOSSO NÚMERO
		$vlinha["cod_carteira"]          = substr($linha, 108,  1); //CARTEIRA - X CÓDIGO DA CARTEIRA 
		$vlinha["cod_ocorrencia"]        = substr($linha, 109,   2); //CÓD. DE OCORRÊNCIA - 9 IDENTIFICAÇÃO DA OCORRÊNCIA 
		$vlinha["data_ocorrencia"]       = $this->formataData(substr($linha, 111,   6)); //DATA DE OCORRÊNCIA - 9 DATA DE OCORRÊNCIA NO BANCO 
		$vlinha["num_documento"]         = substr($linha, 117,   10); //Nº DO DOCUMENTO - X Nº DO DOCUMENTO DE COBRANÇA (DUPL, NP ETC)
		$vlinha["nosso_numero3"]         = substr($linha, 127,   8); //NOSSO NÚMERO - 9 CONFIRMAÇÃO DO NÚMERO DO TÍTULO NO BANCO 
		$vlinha["data_vencimento"]       = $this->formataData(substr($linha, 147,   6)); //VENCIMENTO - 9 DATA DE VENCIMENTO DO TÍTULO 
		$vlinha["valor_titulo"]          = $this->formataNumero(substr($linha, 153,  13)); //VALOR DO TÍTULO - 9  v99 VALOR NOMINAL DO TÍTULO 
		$vlinha["cod_banco"]             = substr($linha, 166,  3); //CÓDIGO DO BANCO - 9 NÚMERO DO BANCO NA CÂMARA DE COMPENSAÇÃO 
		$vlinha["agencia_cobradora"]     = substr($linha, 169,  4); //AGÊNCIA COBRADORA - 9 AG. COBRADORA, AG. DE LIQUIDAÇÃO OU BAIXA
		$vlinha["dac_agencia_cobradora"] = substr($linha, 173,  1); //DAC AG. COBRADORA - 9 DAC DA AGÊNCIA COBRADORA 
		$vlinha["especie"]               = substr($linha, 174,  2); //ESPÉCIE - 9 ESPÉCIE DO TÍTULO  
		$vlinha["tarifa_cobranca"]       = $this->formataNumero(substr($linha, 176,  13)); //TARIFA DE COBRANÇA - 9  v99 VALOR DA DESPESA DE COBRANÇA
		$vlinha["valor_iof"]             = $this->formataNumero(substr($linha, 215,  13)); //VALOR DO IOF  - 9  v99 VALOR DO IOF A SER RECOLHIDO (NOTAS SEGURO)
		$vlinha["valor_abatimento"]      = $this->formataNumero(substr($linha, 228,  13)); //VALOR ABATIMENTO - 9  v99 VALOR DO ABATIMENTO CONCEDIDO 
		$vlinha["valor_desconto"]        = $this->formataNumero(substr($linha, 241,  13)); //DESCONTOS - 9  v99 VALOR DO DESCONTO CONCEDIDO 
		$vlinha["valor_principal"]       = $this->formataNumero(substr($linha, 254,  13)); //VALOR PRINCIPAL - 9  v99 VALOR LANÇADO EM CONTA CORRENTE
		$vlinha["valor_juros_mora"]      = $this->formataNumero( substr($linha, 267,   13)); //JUROS DE MORA/MULTA - 9v99  VALOR DE MORA E MULTA PAGOS PELO SACADO
		$vlinha["valor_outros_creditos"] = $this->formataNumero(substr($linha, 280,   13)); //OUTROS CRÉDITOS - 9v99  VALOR DE OUTROS CRÉDITOS
		$vlinha["data_credito"]          = $this->formataData(substr($linha, 296,  6)); //DATA CRÉDITO - X DATA DE CRÉDITO DESTA LIQUIDAÇÃO
		$vlinha["cod_instr_cancelada"]   = substr($linha, 302,   4); //INSTR.CANCELADA - 9 CÓDIGO DA INSTRUÇÃO CANCELADA
		$vlinha["nome_sacado"]           = substr($linha, 325,   30); //NOME DO SACADO - X NOME DO SACADO
		$vlinha["erros"]                 = substr($linha, 378,   8); //ERROS - X REGISTROS REJEITADOS OU ALEGAÇÃO DO SACADO
		$vlinha["cod_liquidacao"]        = substr($linha, 394,   2); //CÓD. DE LIQUIDAÇÃO - X MEIO PELO QUAL O TÍTULO FOI LIQUIDADO
		$vlinha["num_sequencial"]        = substr($linha, 395,   6); //NÚMERO SEQÜENCIAL - 9 NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO 

		return $vlinha;
	}

	/**Processa uma linha detalhe do arquivo.
	* @param string $linha Linha detalhe do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha detalhe.*/
	protected function processarDetalhe($linha) {
		$vlinha = array();
		
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["tipo_registro"]         = substr($linha,   1,   1); //TIPO DE REGISTRO - 9 IDENTIFICAÇÃO DO REGISTRO TRANSAÇÃO 		
		$vlinha["agencia"]             = substr($linha,  18,   4); //AGÊNCIA - 9 AGÊNCIA MANTENEDORA DA CONTA		
		$vlinha["dv_agencia"]          = substr($linha,  22,   1); //X  Dígito Verificador - D.V. - do Prefixo da Agência		
		$vlinha["cc_cedente"]          = substr($linha,  23,   8); //CONTA - 9  NÚMERO DA CONTA CORRENTE DA EMPRESA
		$vlinha["dv_cc_cedente"]       = substr($linha,  31,   1); //X  Dígito Verificador - D.V. - do Número da Conta Corrente do Cedente
		$vlinha["taxa_desconto"]       = $this->formataNumero(substr($linha,  96,   5)); //9  v99 Taxa de desconto
		$vlinha["taxa_iof"]            = substr($linha, 101,   5); //9  Taxa de IOF		
		$vlinha["cod_carteira"]        = substr($linha, 107,   2); //CARTEIRA - 9 CÓDIGO DA CARTEIRA 
		$vlinha["comando"]             = substr($linha, 109,   2); //9  Comando - nota 07
		$vlinha["data_ocorrencia"]     = $this->formataData(substr($linha, 111,   6)); //X  Data da Entrada/Liquidação (DDMMAA)
		$vlinha["num_titulo"]          = substr($linha, 117,  10); //X  Número título dado pelo cedente - (ver nota 06 para convênio de 6 dígitos)
		$vlinha["data_vencimento"]     = substr($linha, 147,   6); //9  Data de vencimento (DDMMAA) (ver nota 6 para convênios de 7 dígitos)
		$vlinha["valor"]               = $this->formataNumero(substr($linha, 153,  13)); //9  v99 Valor do título
		$vlinha["cod_banco"]           = substr($linha, 166,   3); //9  Código do banco recebedor - ver nota 08
		$vlinha["agencia"]             = substr($linha, 169,   4); //9  Prefixo da agência recebedora - ver nota 08
		$vlinha["dv_agencia"]          = substr($linha, 173,   1); //X  DV prefixo recebedora
		$vlinha["especie"]             = substr($linha, 174,   2); //9  Espécie do título - ver nota 09
		$vlinha["data_credito"]        = substr($linha, 176,   6); //9  Data do crédito (DDMMAA) - ver nota 10
		$vlinha["valor_tarifa"]        = $this->formataNumero(substr($linha, 182,   7)); //9  v99 Valor da tarifa - ver nota 06
		$vlinha["outras_despesas"]     = $this->formataNumero(substr($linha, 189,  13)); //9  v99 Outras despesas
		$vlinha["juros_desconto"]      = $this->formataNumero(substr($linha, 202,  13)); //9  v99 Juros do desconto
		$vlinha["iof_desconto"]        = $this->formataNumero(substr($linha, 215,  13)); //9  v99 IOF do desconto
		$vlinha["valor_abatimento"]    = $this->formataNumero(substr($linha, 228,  13)); //9  v99 Valor do abatimento
		$vlinha["desconto_concedido"]  = $this->formataNumero(substr($linha, 241,  13)); //9  v99 Desconto concedido 
		$vlinha["valor_recebido"]      = $this->formataNumero(substr($linha, 254,  13)); //9  v99 Valor recebido (valor recebido parcial)
		$vlinha["juros_mora"]          = $this->formataNumero(substr($linha, 267,  13)); //9  v99 Juros de mora
		$vlinha["outros_recebimentos"] = $this->formataNumero(substr($linha, 280,  13)); //9  v99 Outros recebimentos
		$vlinha["abatimento_nao_aprov"]= $this->formataNumero(substr($linha, 293,  13)); //9  v99 Abatimento não aproveitado pelo sacado
		$vlinha["valor_lancamento"]    = $this->formataNumero(substr($linha, 306,  13)); //9  v99 Valor do lançamento
		$vlinha["indicativo_dc"]       = substr($linha, 319,   1); //9  Indicativo de débito/crédito - ver nota 11
		$vlinha["indicador_valor"]     = substr($linha, 320,   1); //9  Indicador de valor -ver  nota 12
		$vlinha["valor_ajuste"]        = $this->formataNumero(substr($linha, 321,  12)); //9  v99 Valor do ajuste - ver nota 13
		$vlinha["canal_pag_titulo"]    = substr($linha, 393,   2); //9 Canal de pagamento do título utilizado pelo sacado - ver nota 15
		$vlinha["num_sequencial"]          = substr($linha, 395,   6); //NÚMERO SEQÜENCIAL - 9 NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO 

		return $vlinha;
	}

	/**Processa a linha trailer do arquivo.
	* @param string $linha Linha trailer do arquivo processado
	* @return array<mixed> Retorna um vetor contendo os dados dos campos da linha trailer do arquivo.*/
	protected function processarTrailerArquivo($linha) {
		$vlinha = array();
		
		//X = ALFANUMÉRICO 9 = NUMÉRICO V = VÍRGULA DECIMAL ASSUMIDA
		$vlinha["tipo_registro"]           = substr($linha,   1,   1); //TIPO DE REGISTRO - 9 IDENTIFICAÇÃO DO REGISTRO TRAILER 
		$vlinha["cod_retorno"]             = substr($linha,   2,   1); //CÓDIGO DE RETORNO - 9  “2”
		$vlinha["tipo_servico"]            = substr($linha,   3,   2); //CÓDIGO DE SERVIÇO  - 9 IDENTIFICAÇÃO DO TIPO DE SERVIÇO 
		$vlinha["cod_banco"]               = substr($linha,   5,   3); //CÓDIGO DO BANCO - 9 IDENTIFICAÇÃO DO BANCO NA COMPENSAÇÃO 
		$vlinha["cob_simples_qtd_titulos"] = substr($linha,  18,   8); //QTDE. DE TÍTULOS  - 9  QTDE. DE TÍTULOS EM COBR. SIMPLES
		$vlinha["cob_simples_vlr_total"]   = $this->formataNumero(substr($linha,  26,  14)); //VALOR TOTAL - 9  VR TOTAL DOS TÍTULOS EM COBRANÇA SIMPLES
		$vlinha["cob_simples_num_aviso"]   = substr($linha,  40,   8); //AVISO BANCÁRIO - 9  REFERÊNCIA DO AVISO BANCÁRIO 
		$vlinha["cob_vinc_qtd_titulos"]    = substr($linha,  58,   8); //QTDE. DE TÍTULOS - 9  QTDE DE TÍTULOS EM COBRANÇA/VINCULADA
		$vlinha["cob_vinc_valor_total"]    = $this->formataNumero(substr($linha,  66,  14)); //VALOR TOTAL - 9  v99 VR TOTAL DOS TÍTULOS EM COBRANÇA/VINCULADA
		$vlinha["cob_vinc_num_aviso"]      = substr($linha,  80,   8); //AVISO BANCÁRIO - 9 REFERÊNCIA DO AVISO BANCÁRIO
		$vlinha["cob_cauc_qtd_titulos"]    = substr($linha,  98,   8); //9  Cobrança Caucionada - quantidade de títulos
		$vlinha["cob_cauc_vlr_total"]      = $this->formataNumero(substr($linha, 106,  14)); //9  v99 Cobrança Caucionada - valor total
		$vlinha["cob_cauc_num_aviso"]      = substr($linha, 120,   8); //9  Cobrança Caucionada - Número do aviso
		$vlinha["cob_desc_qtd_titulos"]    = substr($linha, 138,   8); //9  Cobrança Descontada - quantidade de títulos
		$vlinha["cob_desc_vlr_total"]      = $this->formataNumero(substr($linha, 146,  14)); //9  v99 Cobrança Descontada - valor total
		$vlinha["cob_desc_num_aviso"]      = substr($linha, 160,   8); //9  Cobrança Descontada - Número do aviso
		$vlinha["cob_vendor_qtd_titulos"]  = substr($linha, 218,   8); //9  Cobrança Vendor - quantidade de títulos
		$vlinha["cob_vendor_vlr_total"]    = $this->formataNumero(substr($linha, 221,  14)); //9  v99 Cobrança Vendor - valor total
		$vlinha["cob_vendor_num_aviso"]    = substr($linha, 240,   8); //9  Cobrança Vendor - Número do aviso
		$vlinha["num_sequencial"]          = substr($linha, 395,   6); //NÚMERO SEQÜENCIAL - 9 NÚMERO SEQÜENCIAL DO REGISTRO NO ARQUIVO

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
			//Se a quantidade de de caracteres na linha não coincidir com $tamLinha
			die("A linha $numLn não tem $tamLinha posições. Possui " . strlen($linha));
		if(trim($linha) == "")
			die("A linha $numLn está vazia.");
		
		//é adicionado um espaço vazio no início_linha para que
		//possamos trabalhar com índices iniciando_1, no lugar_zero,
		//e assim, ter os valores_posição_campos exatamente
		//como no manual CNAB400
		$linha = " $linha";
		$tipoLn = substr($linha,  1, 1);
		if($tipoLn == RetornoCNAB400::HEADER_ARQUIVO) 
			$vlinha = $this->processarHeaderArquivo($linha);		
		else if($tipoLn == RetornoCNAB400::DETALHE)
			$vlinha = $this->processarDetalhe($linha);
		else if($tipoLn == RetornoCNAB400::TRAILER_ARQUIVO)
			$vlinha = $this->processarTrailerArquivo($linha); 
		else 
			$vlinha = NULL;
			
		return $vlinha;
  	}
}

?>
