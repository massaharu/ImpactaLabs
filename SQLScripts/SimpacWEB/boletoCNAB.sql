USE Financeiro
select * from tb_debitoautomatico

select * from tb_debitoautomaticodebitadoxocorrencia
select * from tb_debitoautomaticoocorrencias
select * from tb_debitoautomaticoperiodo
select * from tb_debitoautomaticoretorno
--------------------------------------------------------------------------
--DROP TABLE tb_shoplineocorrencia
--DROP TABLE tb_shoplineregistrotipo
--DROP TABLE tb_shoplineretorno_transacao
--DROP TABLE tb_shoplineretorno

CREATE TABLE tb_shoplineocorrencia(
	idocorrencia int not null identity CONSTRAINT PK_shoplineocorrencia PRIMARY KEY(idocorrencia),
	cod_ocorrencia	int not null CONSTRAINT UQ_shoplineocorrencia_cod_ocorrencia UNIQUE,
	desocorrencia varchar(100) not null,
	instatus bit CONSTRAINT DF_shoplineocorrencia_instatus DEFAULT (1),
	dtcadastro datetime CONSTRAINT DF_shoplineocorrencia_dtcadastro DEFAULT(getdate())
)

INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(2,'Entrada confirmada')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(3,'Entrada rejeitada (NOTA 20 - Tabela 1)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(4,'Alteração de dados - Nova entrada')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(5,'Alteração de dados – Baixa')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(6,'Liquidação normal')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(7,'LIQUIDAÇÃO PARCIAL – COBRANÇA INTELIGENTE (B2B)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(8,'Liquidação em cartório')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(9,'Baixa simples')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(10,'Baixa por ter sido liquidado')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(11,'Em ser (Só no retorno mensal)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(12,'Abatimento concedido ')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(13,'Abatimento cancelado')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(14,'Vencimento alterado ')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(15,'Baixas rejeitadas (NOTA 20 - Tabela 4)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(16,'Instruções rejeitadas (NOTA 20 - Tabela 3)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(17,'Alteração de dados rejeitados (NOTA 20 - Tabela 2)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(18,'Cobrança contratual - Abatimento e Baixa bloqueados (NOTA 20 - Tabela 5)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(19,'Confirma recebimento de instrução de protesto ')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(20,'Confirma recebimento de instrução de Sustação de Protesto /TARIFA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(21,'Confirma recebimento de instrução de não protestar')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(23,'TÍTULO enviado a cartório/TARIFA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(24,'INSTRUÇÃO DE protesto REJEITADA / sustada / pendente (NOTA 20 - tabela 7)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(25,'Alegações do sacado (NOTA 20 - tabela 6)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(26,'Tarifa de aviso de cobrança')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(27,'Tarifa de extrato posição (B40X)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(28,'Tarifa de relação das liquidações')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(29,'Tarifa de Manutenção de Títulos vencidos')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(30,'Débito mensal de tarifas (para entradas e baixas)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(32,'Baixa por ter sido protestado')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(33,'Custas de protesto')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(34,'Custas de sustação')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(35,'Custas de Cartório Distribuidor')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(36,'Custas de Edital')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(37,'Tarifa de emissão de BOLETO/tarifa de envio de duplicata')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(38,'Tarifa de instrução')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(39,'Tarifa de ocorrências')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(40,'tarifa mensal de emissão de BOLETO/tarifa mensal de envio de duplicata')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(41,'DÉBITO MENSAL DE TARIFAS – EXTRATO DE POSIÇÃO (B4EP/B4OX)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(42,'DÉBITO MENSAL DE TARIFAS – OUTRAS INSTRUÇÕES')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(43,'DÉBITO MENSAL DE TARIFAS – MANUTENÇÃO DE TÍTULOS VENCIDOS')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(44,'DÉBITO MENSAL DE TARIFAS – OUTRAS OCORRÊNCIAS')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(45,'DÉBITO MENSAL DE TARIFAS – PROTESTO')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(46,'DÉBITO MENSAL DE TARIFAS – SUSTAÇÃO DE PROTESTO')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(47,'baixa com transferência para desconto')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(48,'CUSTAS DE SUSTAÇÃO JUDICIAL')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(51,'TARIFA MENSAL REF A ENTRADAS BANCOS CORRESPONDENTES NA CARTEIRA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(52,'TARIFA MENSAL BAIXAS NA CARTEIRA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(53,'TARIFA MENSAL BAIXAS EM BANCOS CORRESPONDENTES NA CARTEIRA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(54,'TARIFA MENSAL DE LIQUIDAÇÕES NA CARTEIRA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(55,'TARIFA MENSAL DE LIQUIDAÇÕES EM BANCOS CORRESPONDENTES NA CARTEIRA')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(56,'custas de irregularidade')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(57,'instrução cancelada (NOTA 20 – TABELA 8)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(59,'BAIXA POR CRÉDITO EM C/C ATRAVÉS DO SISPAG')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(60,'ENTRADA REJEITADA CARNÊ (NOTA 20 – TABELA 1)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(61,'TARIFA EMISSÃO AVISO DE MOVIMENTAÇÃO DE TÍTULOS (2154)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(62,'DÉBITO MENSAL DE TARIFA - AVISO DE MOVIMENTAÇÃO DE TÍTULOS (2154)')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(63,'TÍTULO SUSTADO JUDICIALMENTE')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(64,'ENTRADA CONFIRMADA COM RATEIO DE CRÉDITO')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(69,'cheque devolvido')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(71,'ENTRADA REGISTRADA, AGUARDANDO AVALIAÇÃO')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(72,'BAIXA POR CRÉDITO EM C/C ATRAVÉS DO SISPAG sem  título correspondente')
INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia) VALUES(73,'CONFIRMAÇÃO DE ENTRADA NA COBRANÇA SIMPLES – ENTRADA NÃO ACEITA NA COBRANÇA CONTRATUAL')

SELECT *FROM tb_shoplineocorrencia
--------------------------------------------------------------------------
CREATE TABLE tb_shoplineregistrotipo(
	idregistrotipo	int not null identity CONSTRAINT PK_shoplineregistrotipo PRIMARY KEY(idregistrotipo),
	cod_registrotipo int not null CONSTRAINT UQ_shoplineregistrotipo_cod_registrotipo UNIQUE,
	desregistrotipo varchar(50) not null,
	instatus		bit CONSTRAINT DF_shoplineregistrotipo_instatus DEFAULT(1),
	dtcadastro		datetime CONSTRAINT DF_shoplineregistrotipo_dtcadastro DEFAULT(getdate())	
)
INSERT INTO tb_shoplineregistrotipo (cod_registrotipo, desregistrotipo) VALUES(0, 'HEADER')
INSERT INTO tb_shoplineregistrotipo (cod_registrotipo, desregistrotipo) VALUES(1, 'TRANSAÇÃO')
INSERT INTO tb_shoplineregistrotipo (cod_registrotipo, desregistrotipo) VALUES(4, 'DETALHE')
INSERT INTO tb_shoplineregistrotipo (cod_registrotipo, desregistrotipo) VALUES(9, 'TRAILER')

SELECT *FROM tb_shoplineregistrotipo
--------------------------------------------------------------------------

CREATE TABLE tb_shoplineretorno(
	idarquivo	int not null identity CONSTRAINT PK_shoplineretorno PRIMARY KEY(idarquivo),
--	HEADER	
	cod_registrotipo	int not null,
	servicotipo		varchar(20),
	agencia			char(4),
	conta			char(5),
	dac				char(1),
	desempresa		varchar(30),
	cod_banco		char(3),
	desbanco		varchar(15),
	dtgeracao		datetime,
	nrseq_arq_retorno char(5),
	dtcredito		datetime,
--	TRAILER
	cob_direta_num_aviso	char(8),
	cob_direta_qtd_titulos	char(8),
	cob_direta_vlr_total	decimal(14,2),
	cob_simples_num_aviso	char(8),
	cob_simples_qtd_titulos	char(8),
	cob_simples_vlr_total	decimal(14,2),
	cob_vinc_num_aviso		char(8),	
	cob_vinc_qtd_titulos	char(8),
	cob_vinc_valor_total	decimal(14,2),	
	nrparcela				int,
	vlr_total_arquivo		decimal(14,2),	
	instatus		bit CONSTRAINT DF_shoplineretorno_instatus DEFAULT(1),
	dtcadastro		datetime CONSTRAINT DF_shoplineretorno_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT FK_shoplineretorno_shoplineregistrotipo_cod_registrotipo FOREIGN KEY(cod_registrotipo)
	REFERENCES tb_shoplineregistrotipo(cod_registrotipo)
)
idarquivo,, instatus, dtcadastro

SELECT * FROm tb_shoplineretorno

SELECT dtgeracao FROM (SELECT 
cod_registrotipo, servicotipo, agencia, conta, dac, desempresa, cod_banco, desbanco, dtgeracao, 
nrseq_arq_retorno, dtcredito, cob_direta_num_aviso, cob_direta_qtd_titulos, cob_direta_vlr_total, cob_simples_num_aviso, 
cob_simples_qtd_titulos, cob_simples_vlr_total, cob_vinc_num_aviso, cob_vinc_qtd_titulos, cob_vinc_valor_total, 
nrparcela, vlr_total_arquivo, count(*)
FROM tb_shoplineretorno
group by  cod_registrotipo, servicotipo, agencia, conta, dac, desempresa, cod_banco, desbanco, dtgeracao, 
nrseq_arq_retorno, dtcredito, cob_direta_num_aviso, cob_direta_qtd_titulos, cob_direta_vlr_total, cob_simples_num_aviso, 
cob_simples_qtd_titulos, cob_simples_vlr_total, cob_vinc_num_aviso, cob_vinc_qtd_titulos, cob_vinc_valor_total, nrparcela, vlr_total_arquivo) 

--------------------------------------------------------------------------
CREATE TABLE tb_shoplineretorno_transacao(
	idarquivotransacao	int not null identity CONSTRAINT PK_shoplineretorno_transacao PRIMARY KEY(idarquivotransacao),
	idarquivo			int not null,
	cod_registrotipo	int not null,
	agencia_cobradora	char(4),
	cod_carteira		char(1),
	num_carteira		varchar(3),
	cod_inscricao		char(2),
	num_inscricao		varchar(14), 
	cod_instr_cancelada	varchar(4),
	cod_liquidacao		char(2),
	cod_ocorrencia		int,
	dac_agencia_cobradora	char(1),
	dac_nosso_numero		char(1),
	data_credito		datetime,
	data_ocorrencia		datetime,
	data_vencimento		datetime,
	erros				varchar(8),
	especie				char(2),
	nome_sacado			varchar(30),
	nosso_numero		varchar(8),
	num_documento		varchar(10),
	tarifa_cobranca		decimal(13,2),
	uso_empresa			varchar(25),
	valor_abatimento	decimal(13,2),
	valor_desconto		decimal(13,2),
	valor_iof			decimal(13,2),
	valor_juros_mora	decimal(13,2),
	valor_outros_creditos	decimal(13,2),
	valor_principal		decimal(13,2),
	valor_titulo		decimal(13,2),
	instatus			bit CONSTRAINT DF_shoplineretorno_transacao_instatus DEFAULT(1),
	dtcadastro			datetime CONSTRAINT DF_shoplineretorno_transacao_dtcadastro DEFAULT(getdate())	
	
	CONSTRAINT FK_shoplineretorno_transacao_shoplineretorno_idarquivo FOREIGN KEY(idarquivo)
	REFERENCES tb_shoplineretorno(idarquivo),
	CONSTRAINT FK_shoplineretorno_transacao_shoplineregistrotipo_cod_registrotipo FOREIGN KEY(cod_registrotipo)
	REFERENCES tb_shoplineregistrotipo(cod_registrotipo),
	CONSTRAINT FK_shoplineretorno_transacao_shoplineocorrencia_cod_ocorrencia FOREIGN KEY(cod_ocorrencia)
	REFERENCES tb_shoplineocorrencia(cod_ocorrencia)
)
 
SELECT *FROM tb_shoplineretorno_transacao

UPDATE tb_shoplineretorno_transacao
SET data_credito = NULL
WHERE YEAR(data_credito) = 1969
----------------------------------------------------------------
---------- PROCEDURES ------------------------------------------
----------------------------------------------------------------
CREATE PROC sp_shoplineretorno_save
(
	@cod_registrotipo	int,
	@servicotipo		varchar(20),
	@agencia			char(4),
	@conta			char(5),
	@dac				char(1),
	@desempresa		varchar(30),
	@cod_banco		char(3),
	@desbanco		varchar(15),
	@dtgeracao		datetime,
	@nrseq_arq_retorno char(5),
	@dtcredito		datetime,
--	TRAILER
	@cob_direta_num_aviso	char(8),
	@cob_direta_qtd_titulos	char(8),
	@cob_direta_vlr_total	decimal(14,2),
	@cob_simples_num_aviso	char(8),
	@cob_simples_qtd_titulos	char(8),
	@cob_simples_vlr_total	decimal(14,2),
	@cob_vinc_num_aviso		char(8),	
	@cob_vinc_qtd_titulos	char(8),
	@cob_vinc_valor_total	decimal(14,2),	
	@nrparcela				int,
	@vlr_total_arquivo		decimal(14,2)
)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	SET NOCOUNT ON
		INSERT INTO tb_shoplineretorno 
		(
			cod_registrotipo,
			servicotipo,
			agencia,
			conta,
			dac,
			desempresa,
			cod_banco,
			desbanco,
			dtgeracao,
			nrseq_arq_retorno,
			dtcredito,
		--	TRAILER
			cob_direta_num_aviso,
			cob_direta_qtd_titulos,
			cob_direta_vlr_total,
			cob_simples_num_aviso,
			cob_simples_qtd_titulos,
			cob_simples_vlr_total,
			cob_vinc_num_aviso,	
			cob_vinc_qtd_titulos,
			cob_vinc_valor_total,	
			nrparcela,
			vlr_total_arquivo	
		)VALUES(
			@cod_registrotipo,
			@servicotipo,
			@agencia,
			@conta,
			@dac,
			@desempresa,
			@cod_banco,
			@desbanco,
			@dtgeracao,
			@nrseq_arq_retorno,
			@dtcredito,
		--	TRAILER
			@cob_direta_num_aviso,
			@cob_direta_qtd_titulos,
			@cob_direta_vlr_total,
			@cob_simples_num_aviso,
			@cob_simples_qtd_titulos,
			@cob_simples_vlr_total,
			@cob_vinc_num_aviso,	
			@cob_vinc_qtd_titulos,
			@cob_vinc_valor_total,	
			@nrparcela,
			@vlr_total_arquivo
		)
	SET NOCOUNT OFF
	SELECT SCOPE_IDENTITY() AS idarquivo
END
----------------------------------------------------------------
CREATE PROC sp_shoplineretorno_transacao_save
(
	@idarquivo			int,
	@cod_registrotipo	int,
	@agencia_cobradora	char(4),
	@cod_carteira		char(1),
	@num_carteira		varchar(3),
	@cod_inscricao		char(2),
	@num_inscricao		varchar(14),
	@cod_instr_cancelada	varchar(4),
	@cod_liquidacao		char(2),
	@cod_ocorrencia		int,
	@dac_agencia_cobradora	char(1),
	@dac_nosso_numero		char(1),
	@data_credito		datetime,
	@data_ocorrencia		datetime,
	@data_vencimento		datetime,
	@erros				varchar(8),
	@especie				char(2),
	@nome_sacado			varchar(30),
	@nosso_numero		varchar(8),
	@num_documento		varchar(10),
	@tarifa_cobranca		decimal(13,2),
	@uso_empresa			varchar(25),
	@valor_abatimento	decimal(13,2),
	@valor_desconto		decimal(13,2),
	@valor_iof			decimal(13,2),
	@valor_juros_mora	decimal(13,2),
	@valor_outros_creditos	decimal(13,2),
	@valor_principal		decimal(13,2),
	@valor_titulo		decimal(13,2)
)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	INSERT INTO tb_shoplineretorno_transacao
	(
		idarquivo,
		cod_registrotipo,
		agencia_cobradora,
		cod_carteira,
		num_carteira,
		cod_inscricao,
		num_inscricao,
		cod_instr_cancelada,
		cod_liquidacao,
		cod_ocorrencia,
		dac_agencia_cobradora,
		dac_nosso_numero,
		data_credito,
		data_ocorrencia,
		data_vencimento,
		erros,
		especie,
		nome_sacado,
		nosso_numero,
		num_documento,
		tarifa_cobranca,
		uso_empresa,
		valor_abatimento,
		valor_desconto,
		valor_iof,
		valor_juros_mora,
		valor_outros_creditos,
		valor_principal,
		valor_titulo
	)VALUES(
		@idarquivo,
		@cod_registrotipo,
		@agencia_cobradora,
		@cod_carteira,
		@num_carteira,
		@cod_inscricao,
		@num_inscricao,
		@cod_instr_cancelada,
		@cod_liquidacao,
		@cod_ocorrencia,
		@dac_agencia_cobradora,
		@dac_nosso_numero,
		@data_credito,
		@data_ocorrencia,
		@data_vencimento,
		@erros,
		@especie,
		@nome_sacado,
		@nosso_numero,
		@num_documento,
		@tarifa_cobranca,
		@uso_empresa,
		@valor_abatimento,
		@valor_desconto,
		@valor_iof,
		@valor_juros_mora,
		@valor_outros_creditos,
		@valor_principal,
		@valor_titulo
	)
END
----------------------------------------------------------------
CREATE PROC sp_shoplineretorno_list '1970-01-01','3000-01-01'
(@dtinicio date, @dtfinal date)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	SELECT idarquivo,
	--	HEADER	
	a.cod_registrotipo,
	b.desregistrotipo,
	servicotipo,
	agencia,
	conta,
	dac,
	desempresa,
	cod_banco,
	desbanco,
	dtgeracao,
	nrseq_arq_retorno,
	dtcredito,
--	TRAILER
	cob_direta_num_aviso,
	cob_direta_qtd_titulos,
	cob_direta_vlr_total,
	cob_simples_num_aviso,
	cob_simples_qtd_titulos,
	cob_simples_vlr_total,
	cob_vinc_num_aviso,	
	cob_vinc_qtd_titulos,
	cob_vinc_valor_total,	
	nrparcela,
	vlr_total_arquivo,	
	a.instatus,
	a.dtcadastro	
	FROM tb_shoplineretorno a
	INNER JOIN tb_shoplineregistrotipo b
	ON b.cod_registrotipo = a.cod_registrotipo
	WHERE a.dtcadastro between @dtinicio and DATEADD(day,1,@dtfinal)
	ORDER BY dtcadastro DESC
END
-----------------------------------------------------------
CREATE PROC sp_shoplineretorno_transacaobyarquivo_list --223
(@idarquivo int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	SELECT
		idarquivotransacao,
		idarquivo,
		a.cod_registrotipo,
		b.desregistrotipo,
		agencia_cobradora,
		cod_carteira,
		num_carteira,
		cod_inscricao,
		num_inscricao,
		cod_instr_cancelada,
		cod_liquidacao,
		a.cod_ocorrencia,
		c.desocorrencia,
		dac_agencia_cobradora,
		dac_nosso_numero,
		data_credito,
		data_ocorrencia,
		data_vencimento,
		erros,
		especie,
		nome_sacado,
		nosso_numero,
		num_documento,
		tarifa_cobranca,
		uso_empresa,
		valor_abatimento,
		valor_desconto,
		valor_iof,
		valor_juros_mora,
		valor_outros_creditos,
		valor_principal,
		valor_titulo,
		a.instatus,
		a.dtcadastro	
	FROM tb_shoplineretorno_transacao a 
	INNER JOIN tb_shoplineregistrotipo b
	ON b.cod_registrotipo = a.cod_registrotipo
	INNER JOIN tb_shoplineocorrencia c
	ON c.cod_ocorrencia = a.cod_ocorrencia
	WHERE idarquivo = @idarquivo
END
---------------------------------------------------------------------
CREATE PROC sp_shoplineocorrencia_list
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	SELECT idocorrencia,
		   cod_ocorrencia,
		   desocorrencia,
		   instatus,
		   dtcadastro	
	FROM tb_shoplineocorrencia
	ORDER BY cod_ocorrencia 
END
---------------------------------------------------------------------
CREATE PROC sp_shoplineocorrencia_save
(
	@idocorrencia int,
	@cod_ocorrencia int,
	@desocorrencia varchar(100)
)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	IF(@idocorrencia <> 0)
		BEGIN
			UPDATE tb_shoplineocorrencia
			SET cod_ocorrencia = @cod_ocorrencia,
				desocorrencia = @desocorrencia
			WHERE idocorrencia = @idocorrencia
			
			SET NOCOUNT OFF
			SELECT @idocorrencia as idocorrencia
		END
	ELSE
		BEGIN
			INSERT INTO tb_shoplineocorrencia (cod_ocorrencia, desocorrencia)
			VALUES(@cod_ocorrencia, @desocorrencia)
			
			SET NOCOUNT OFF
			SELECT SCOPE_IDENTITY() as idocorrencia
		END
END
---------------------------------------------------------------------
CREATE PROC sp_shoplineocorrencia_delete
(@idocorrencia int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-03-21
author: Massa
*/
BEGIN
	DELETE tb_shoplineocorrencia
	WHERE idocorrencia = @idocorrencia
END
--------------------------------------------------------------------------
CREATE PROC sp_shoplineretorno_removeduplicidade
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-05-21
author: Massa
description: Remove duplicidade de dados das tabelas (tb_shoplineretorno, tb_shoplineretorno_transacao) pela dtgeracao
*/
BEGIN
	BEGIN TRAN
	
	DELETE tb_shoplineretorno_transacao
	FROM tb_shoplineretorno_transacao a
	INNER JOIN tb_shoplineretorno b
	on a.idarquivo = b.idarquivo
	WHERE b.dtgeracao in (
		SELECT dtgeracao FROM tb_shoplineretorno
		GROUP by dtgeracao
		HAVING COUNT(*) > 1
	) AND b.idarquivo NOT IN(
		SELECT MAX(idarquivo) FROM tb_shoplineretorno
		GROUP by dtgeracao
		HAVING COUNT(*) > 1
	)

	IF @@ERROR = 0
	BEGIN
		DELETE tb_shoplineretorno
		WHERE dtgeracao in (
			SELECT dtgeracao FROM tb_shoplineretorno
			GROUP by dtgeracao
			HAVING COUNT(*) > 1
		) AND idarquivo NOT IN(
			SELECT MAX(idarquivo) FROM tb_shoplineretorno
			GROUP by dtgeracao
			HAVING COUNT(*) > 1
		)
		
		COMMIT
	END
	ELSE
	BEGIN
		ROLLBACK
	END
END
------------------JÁ CRIADOS --------------------------------------------------------
CREATE PROC sp_baixaPagamentoItau_get 3316
(@idpagamento BIGINT)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-05-21
author: Massa
*/
BEGIN
	select 
		c.nome_cli, 
		b.idpagamento, 
		b.sessionid, 
		b.cod_cli, 
		b.idformapagto, 
		b.idservico, 
		b.idpedido, 
		b.nrparcelas, 
		b.vltotal, 
		b.idstatus, 
		b.dtcadastro, 
		b.idusuario, 
		d.despagto
	from Ecommerce..tb_pagamentoItau a
	inner join Ecommerce..tb_pagamento b on a.sessionid = b.sessionid
	inner join impacta4.dbo.tb_ecommercecliente c on b.cod_cli = c.cod_cli
	inner join Ecommerce..tb_formaPagamento d on b.idformapagto = d.idformapagto
	where a.idpagamento = @idpagamento
END
--------------------------------------------------------------------------------
CREATE PROC sp_baixaPagamentoNrParcelas_get 972884089, 100216
(@sessionid int, @cod_cli int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-05-21
author: Massa
*/
BEGIN
	select 
		count(*) as nrparcelas, 
		matricula 
	from tb_pagamentodematricula 
	where sessionid = @sessionid AND 
		cod_cli = @cod_cli
	GROUP BY matricula
END
--------------------------------------------------------------------------
CREATE PROC sp_baixaPagamentoLojaVirtualBaixaRecibo_delete
(@idrecibo int)
AS
/*
app: SimpacWeb
url: /simpacweb/modulos/Financeiro/..
data: 2013-05-21
author: Massa
*/
BEGIN
	IF((select count(*) as total 
		from simpac..tb_LojaVirtualBaixaRecibo 
		where idrecibo = @idrecibo) > 0)
		BEGIN
			DELETE FROM simpac..tb_LojaVirtualBaixaRecibo
			WHERE idrecibo = @idrecibo
		END
END

sp_text_object_show sp_baixaPagamentoReciboBySessionid_get 1048597836

--------------------------------------------------------------------------
--------------------------------------------------------------------------
--------------------------------------------------------------------------
USE Ecommerce
SELECT * FROM tb_pagamento
SELECT * FROM tb_pagamentoItau
SELECT * FROM tb_LojaVirtualRecibo
SELECT * FROM tb_status
SELECT * FROM tb_LojaVirtualBoletoBaixa
SELECT * FROM Vendas..tb_transacoes
SELECT * FROM vendas..tb_pessoasaccounts where sessionid = '323604070'
SELECT * FROM simpac..tb_controlefinanceiro where IdPedido = 577651
SELECT * FROM ecommerce..tb_pagamentopedidoparcela where sessionid = 974803668
SELECT * FROM tb_LojaVirtualBoletoBaixa
-----------------------------------------------

Select a.* from vendas..tb_pessoasaccounts a 
inner join tb_pagamento b 
on a.cod_cli = b.cod_cli 
where sessionid = '974803668'

select * from tb_formaPagamento
select * from tb_servico

select a.*, b.* 
from Ecommerce..tb_LojaVirtualRecibo a 
	inner join Simpac..tb_RelacaoReciboMatricula b 
	on a.idrecibo = b.idrecibo
---where matricula = '1513060957'
--where a.idrecibo = 368178
where nmCliente like '%lourival%'

SELECT nrparcelas, a.idformapagto, c.nome_cli, c.cod_cli, c.email_cli, c.cpf_cli, c.telefone_cli, idstatus, vltotal, idpedido FROM tb_pagamento a 
inner join tb_formapagamento b 
ON a.idformapagto = b.idformapagto 
inner join impacta4.dbo.tb_ecommercecliente c 
ON a.cod_cli = c.cod_cli 
WHERE sessionid = '323618928'

print @idpessoa 
		

SELECT tb_pagamento INNER tb_pagamentoItau
INSERT tb_LojaVirtualRecibo => sp_text_object_show sp_SalvaReciboEcommerce
UPDATE tb_pagamentoItau
update tb_status set idtipostatus = 1 where idstatus = 
INSERT tb_LojaVirtualBoletoBaixa

sp_text_object_show  sp_SalvaReciboEcommerce
sp_text_object_show sp_pagamentopedidoparcela_save
sp_text_object_show sp_transacoes_add
sp_text_object_show sp_baixaPagamentoLojaVirtualBaixaRecibo_delete
sp_text_object_show sp_baixaPagamentoMatriculaBySessionid_get
sp_text_object_show simpac..sp_orcamentototaltreinamentos_list 577651

select c.nome_cli, b.*, d.despagto
from Ecommerce..tb_pagamentoItau a
inner join Ecommerce..tb_pagamento b on a.sessionid = b.sessionid
inner join impacta4.dbo.tb_ecommercecliente c on b.cod_cli = c.cod_cli
inner join Ecommerce..tb_formaPagamento d on b.idformapagto = d.idformapagto
where a.idpagamento = 2992

USE Ecommerce sp_baixaPagamentoMatriculaBySessionid_get 974803668

select 
	count(*) as nrparcelas, 
	matricula 
from tb_pagamentodematricula 
where sessionid = 419579999 AND 
	cod_cli = 99299
GROUP BY matricula

select * from tb_pagamentodematricula where matricula = '1513060957'
select * from simpac..tb_matriculas 

select count(*) as total 
from simpac..tb_LojaVirtualBaixaRecibo 
where idrecibo = 367472

select idrecibo from ecommerce..tb_LojaVirtualRecibo where sessionid = '190022962'

select * from tb_pagamentodematricula 
--WHERE Matricula = '4513040878'
GROUP BY matricula,  sessionid, cod_cli 


select * from ecommerce..tb_servico
select * from impacta4.dbo.tb_ecommercecliente
select * from simpac..tb_LojaVirtualBaixaRecibo

sp_baixaPagamentoItau_get 3014


------------------------------------------------
USE FINANCEIRO

SELECT MAX(idarquivo) as idarquivo, COUNT(*) as count, dtgeracao FROM tb_shoplineretorno
GROUP by dtgeracao
HAVING COUNT(*) = 1

SELECT a.*, b.* FROM tb_shoplineretorno a
INNER JOIN tb_shoplineretorno_transacao b
on a.idarquivo = b.idarquivo
WHERE a.idarquivo in (147, 106)

SELECT * FROM tb_shoplineretorno
SELECT * FROM tb_shoplineretorno_transacao

USE Ecommerce

select * from tb_pagamento where sessionid = 459326750

select idrecibo from tb_LojaVirtualRecibo where sessionid = 459326750

SELECT * FROM tb_pagamentoItau where sessionid = 459326750
SELECT * FROM tb_pagamentoItau where idpagamento = 80567

SELECT nrparcelas, a.idformapagto, c.nome_cli, c.cod_cli, c.email_cli, c.cpf_cli, c.telefone_cli, idstatus, vltotal, idpedido 
FROM tb_pagamento a 
inner join tb_formapagamento b ON a.idformapagto = b.idformapagto 
inner join impacta4.dbo.tb_ecommercecliente c ON a.cod_cli = c.cod_cli 
WHERE sessionid = 459326750

sp_baixaPagamentoItau_get 7765

SELECT * FROM financeiro..tb_shoplineretorno_transacao where nosso_numero like '%7764%'
------------------------------------------------


