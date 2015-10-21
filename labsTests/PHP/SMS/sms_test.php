<?php
#@AUTOR = massaharu
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
$GLOBALS["JSON"] = true;
require_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/inc/configuration.php");

/////// GLOBALS ////////////////////////////////////////

if(strtolower($_SERVER['HTTP_HOST']) == "localhost"){
	$SERVER = "C:/Sistemas";
}else if (strtolower($_SERVER['HTTP_HOST']) == "simpac.impacta.com.br"){
	$SERVER = "\\\\opel\\corporate\\Simpac Web Site";
}

///////////// FUNCTIONS ///////////////////////////////////

function desconto($vl, $desconto){	
	return $vl-(($vl*$desconto)/100);
}

///////////////////////////////////////////////////////////

$arr_Inadimplentes = Sql::arrays("SONATA", "SOPHIA",
	"SELECT DISTINCT TOP 1
		a.NOME,
		a.CODEXT,
		a.EMAIL,
		CASE
		
			WHEN a.FORMACONTATO1 = 2 THEN -- SE CONTATO 1 FOR CELULAR
				CASE 
					WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN -- SE TIVER O CELULAR 
						replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
					ELSE
						CASE 
							WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN
								replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
							ELSE
								replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
						END
				END
				
			ELSE 
			
				CASE
					
					WHEN a.FORMACONTATO2 = 2 THEN -- SE CONATATO 2 FOR CELULAR
						CASE 
							WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN -- SE TIVER O CELULAR 
								replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
							ELSE
								CASE 
									WHEN a.CONTATO3 IS NOT NULL AND a.CONTATO3 <> '' THEN
										replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
									ELSE
										replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
								END
						END
					
					ELSE
						
						CASE
					
							WHEN a.FORMACONTATO3 = 2 THEN -- SE FOR CELULAR
								CASE 
									WHEN a.CONTATO3 IS NOT NULL AND a.CONTATO3 <> '' THEN -- SE TIVER O CELULAR 
										replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
									ELSE
										CASE 
											WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN
												replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
											ELSE
												replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
										END
								END
							
							ELSE
							
								CASE
								
									WHEN a.CONTATO1 IS NOT NULL AND a.CONTATO1 <> '' THEN -- SE TIVER O CONTATO 
										replace(replace(replace(replace(a.CONTATO1, '-', ''), '(', ''), ')', ''), ' ', '')
									ELSE
										CASE 
											WHEN a.CONTATO2 IS NOT NULL AND a.CONTATO2 <> '' THEN
												replace(replace(replace(replace(a.CONTATO2, '-', ''), '(', ''), ')', ''), ' ', '')
											ELSE
												replace(replace(replace(replace(a.CONTATO3, '-', ''), '(', ''), ')', ''), ' ', '')
										END	
								END
						END
				END
		END AS CELULAR,
		e.DATA_VCTO,
		g.descricao,
		curso.NOME AS CURSO,
		e.CODIGO AS CODTITULO,
		e.* 
	FROM SOPHIA.FISICA a
	INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO AND b.STATUS = 0
	INNER JOIN SOPHIA.CURSOS curso ON curso.PRODUTO = b.CURSO AND (curso.NIVEL = 1 OR curso.NIVEL = 2 OR curso.NIVEL = 4)
	INNER JOIN SophiA.VENDAS c ON c.CODIGO = b.VENDA
	INNER JOIN SOPHIA.TITULOS e ON e.CODPF = a.CODIGO
	INNER JOIN SOPHIA.MOVFIN f ON f.TITULO = e.CODIGO
	INNER JOIN SOPHIA.PLANOCONTAS g ON g.CODIGO = f.CLASSIFICACAO
	WHERE 
		YEAR(e.DATA_VCTO) = 2015 AND
		MONTH(e.DATA_VCTO) = 5 AND
		g.DESCRICAO like '%mens%' AND
		e.RECEBIDO = 0 AND
		e.RECEBIDO <> 2 AND
		e.CODIGO NOT IN (
			SELECT TITULO FROM SOPHIA.TIT_RENEG
		)
	ORDER BY a.NOME"
);

foreach($arr_Inadimplentes as $key=>$inadimplente){
	
	$titulo = Sql::arrays("SONATA", "SOPHIA", "sp_info_titulo_get ".$inadimplente['CODTITULO'], false);

	//caso não tiver cadastrado um cedente no título
	if(count($titulo) <= 0){
		$titulo =  Sql::arrays("SONATA", "SOPHIA", "sp_info_titulo_sem_cedente_get ".$inadimplente['CODTITULO'], false);
	}
	
	$valortitulo =  Sql::arrays("SONATA", "SOPHIA", "sp_valor_titulo_get ".$inadimplente['CODTITULO'], false);
	
	if(count($valortitulo) <= 0){
		send_email(array(
			'body'=>'Erro na Emiss&atilde;o do boleto '.$inadimplente['CODTITULO'].' <br><br>Aluno: '.$inadimplente['NOME'].' <br><br>RA: '.$inadimplente['CODEXT'],
			'to'=>'bbarbosa@impacta.com.br;jvalezzi@impacta.com.br',
			'subject'=>utf8_decode('[Site Faculdade] Erro: Emissão de Boleto')
		));
		
		continue;
	}
	
	// DADOS DO BOLETO PARA O SEU CLIENTE
	$taxa_boleto = 0;
	$data_venc = date("d/m/Y", $valortitulo['VENCIMENTO']);//->format("d/m/Y");  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = str_replace(".","",number_format($valortitulo['BRUTO'],2,',','.')); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	
	
	$valor_cobrado = str_replace(".", "",$valor_cobrado);
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '.');
	$valor_boleto = str_replace(".", "",$valor_boleto);
	
	
	$dadosboleto["nosso_numero"] = $inadimplente['CODTITULO'];
	$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
	
	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = utf8_encode($titulo['NOME']);
	$dadosboleto["endereco1"] = utf8_encode($titulo['LOGRADOURO']).' '.$titulo['BAIRRO'];
	$dadosboleto["endereco2"] = utf8_encode($titulo['CIDADE'])." -  CEP: ".$titulo['CEP'];
	
	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "";
	$dadosboleto["demonstrativo2"] = "";
	$dadosboleto["demonstrativo3"] = "";
	
	$dadosboleto["instrucoes"] = array();
	
	$g =  Sql::arrays("SONATA", "SOPHIA", 
		"select 
			VALOR, convert(char(10),data,121) as data 
		from sophia.MOVFIN a 
		where 
			titulo = ".$inadimplente['CODTITULO']." and VALOR < 0
		order by 
			data desc"
	);	
	
	$arrValor = array((float)str_replace(",",".",$valor_cobrado));
	
	foreach($g as $val2){
		if(!$val2["data"]){
			$vlabatimento += $val2['VALOR'];
		}
	}
	
	foreach($g as $val){
		$valor = (float)$val['VALOR']+$arrValor[count($arrValor)-1];
		if($val["data"]){
			array_push($arrValor,$valor);
			array_push($dadosboleto["instrucoes"], "Até o dia ".date("d/m/Y",strtotime($val['data']))." do mês de vencimento cobrar R$ ".number_format(($valor+$vlabatimento),2,",","."));
		} else {
			$dadosboleto["vlabatimento"] = number_format($valortitulo['DESCONTO'],2,",",".");
			
		}
	}
	
	$dadosboleto["instrucoes"]=array_reverse($dadosboleto["instrucoes"]);
	
	$msgboleto = explode('.',$titulo['MSGBOLETO']);
	
	if(gettype($msgboleto) == 'array'){
		$msgboleto1 = utf8_encode($msgboleto[0]);
		$msgboleto2 = utf8_encode($msgboleto[1]);
	}else{
		$msgboleto1 = utf8_encode($titulo['MSGBOLETO']);
		$msgboleto2 = '';
	}
	
	$dadosboleto["instrucoes4"] = "Aluno(a): ".utf8_encode($titulo['NOME'])." - Código: ".$titulo['RA'];
	$dadosboleto["instrucoes7"] = $reajuste;
	$dadosboleto["instrucoes8"] = $reajuste1;
	$dadosboleto["instrucoes5"] = $msgboleto1;//"Atenção: Após o vencimento cobrar multa de 2% e mora diária de 0,033%.";
	$dadosboleto["instrucoes6"] = $msgboleto2;//"Não receber após o ultimo dia do mês";
	
	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = $valor_boleto;
	$dadosboleto["aceite"] = "N";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "RC";	
	
	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
	
	$conta = explode('-',$titulo["NUMERO"]);
	$agencia = explode('-',$titulo["AGENCIA"]);
	
	// DADOS DA SUA CONTA - Bradesco
	//$dadosboleto["agencia"] = $agencia[0]; // Num da agencia, sem digito
	//$dadosboleto["agencia_dv"] = "2"; // Digito do Num da agencia
	$dadosboleto["conta"] = $conta[0]; 	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = $conta[1]; 	// Digito do Num da conta
	
	// SEUS DADOS
	$dadosboleto["identificacao"] = utf8_encode($titulo['NOMEFANTASIA']);//"União Educacional e Tecnológica Impacta - UNI IMPACTA LTDA";
	$dadosboleto["cpf_cnpj"] = $titulo['CNPJ'];//"59069914000151";
	$dadosboleto["endereco"] = "Avenida Rudge, 315 - Bom Retiro";
	$dadosboleto["cidade_uf"] = "São Paulo / SP";
	$dadosboleto["cedente"] = utf8_encode($titulo['NOMEFANTASIA']);//"União Educacional e Tecnológica Impacta - UNI IMPACTA LTDA";
	
	$dadosboleto["pagamento_local"] = utf8_encode($titulo['LOCALPGTO']);//"Pagável preferencialmente em qualquer agência Bradesco.";
	
	$GLOBALS['boletoPDF'] = true;
	
	// DADOS PARA CRIAR O NOME DO PDF
	$dadospdf["name_pdf"] = '';
	$dadospdf["name_pdf"] = "boleto-matricula-".$inadimplente['CODEXT'].'-'.date("d-m-Y-h-i-s");
	
	$dadosboleto["pdf_acao"] = "pdf_email";
	
	$dadosboleto["pdf_caminho"] = $SERVER."/simpacweb/modulos/fit/secretaria/oportunidade_aluno/pdf_boleto/".$dadospdf["name_pdf"].".pdf";
	
	switch((int)$titulo['BANCO']){
		
		case 237://Bradesco
		
			if($vlabatimento){
				
				$dadosboleto["vlabatimento"] = number_format(-$vlabatimento,2,',','.');
				$vlcobrado = $dadosboleto["valor_boleto"] - $dadosboleto["vlabatimento"];
				$dadosboleto["vlcobrado"] = number_format($vlcobrado,2,',','.');
			}
			
			$dadosboleto["agencia"] = "3381"; // Num da agencia, sem digito
			$dadosboleto["agencia_dv"] = "2";
			$dadosboleto["conta_cedente"] = $dadosboleto["conta"]; // ContaCedente do Cliente, sem digito (Somente Números)
			$dadosboleto["conta_cedente_dv"] = $dadosboleto["conta_dv"]; // Digito da ContaCedente do Cliente
			$dadosboleto["carteira"] = "09";  // Código da Carteira: pode ser 06 ou 03
			
			include_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/fit/secretaria/oportunidade_aluno/boletophp/include/funcoes_bradesco_pdf.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/fit/secretaria/oportunidade_aluno/boletophp/include/layout_bradesco_pdf.php");
			
			break;
			
		case 341://Itaú
		
			$dadosboleto["valor_boleto"] = str_replace(".", "",$dadosboleto["valor_boleto"]);
			
			if($vlabatimento){
				
				$vlcobrado = $dadosboleto["valor_boleto"] - $dadosboleto["vlabatimento"];
				$dadosboleto["vlcobrado"] = number_format($vlcobrado,2,',','.');
			}
			
			$dadosboleto["agencia"] = $agencia[0]; // Num da agencia, sem digito
			$dadosboleto["carteira"] = "109";  // Código da Carteira: pode ser 06 ou 03
			
			include_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/fit/secretaria/oportunidade_aluno/boletophp/include/funcoes_itau_pdf.php");
			include_once($_SERVER["DOCUMENT_ROOT"]."/simpacweb/modulos/fit/secretaria/oportunidade_aluno/boletophp/include/layout_itau_pdf.php");
			
			break;
	}
	
	//enviar email com boleto anexado
	$assunto = "Pagamento de Boleto da Matrícula";
	$mensagem = emailpadrao(adjust('<style type="text/css">p{font-size:11.0pt;font-family:Calibri}</style>
<p><b>Prezado '.$aluno["NOME"].',</b></p><p>Prezado(a) aluno(a), o boleto do próximo mês está disponível on-line. Pague até o dia 1o. e usufrua do desconto de antecipação e vouchers para treinamentos. Cordialmente, Faculdade Impacta.'));
	
	$email_aluno = "massaharu@impacta.com.br;"/*.$inadimplente['EMAIL']*/;
	
	if($email_aluno != '' && $email_aluno != NULL){
		
		envia_email_attach_new($assunto, $mensagem, $email_aluno, $from = "Site Grupo Impacta Tecnologia", $priority = 3, $replyTo = '', $username="servweb",$password="q1a2s3", array($dadosboleto["pdf_caminho"]));
		
		//mandar sms
		$cel_aluno = '11968496933';//$inadimplente['CELULAR'];
		
		if($cel_aluno != '' && $cel_aluno != NULL){
			$sms = utf8_decode("Prezado(a) aluno(a), o boleto do próximo mês está disponível on-line. Pague até o dia 1o. e usufrua do desconto de antecipação e vouchers para treinamentos. Cordialmente, Faculdade Impacta.");
			sendSms($cel_aluno, $sms, $email_aluno, TRUE);
		}
	}	
	
	unlink($dadosboleto["pdf_caminho"]);
	
	/*if($key % 10 == 0) sleep(10);
	echo
		"<p>
			Nome: ".$inadimplente['NOME']."<br />
			E-mail: ".$inadimplente['EMAIL']."<br />
			Nrº Título: ".$inadimplente['CODTITULO']." |
			Celular: ".$inadimplente['CELULAR']."<br />
			".$inadimplente['CURSO']."<br /> 
			Data de Vencimento: ".date("d/m/Y", $inadimplente['DATA_VCTO'])."<br /> 
			--------------------------------------------------------------
		</p>";*/
	
}

?>