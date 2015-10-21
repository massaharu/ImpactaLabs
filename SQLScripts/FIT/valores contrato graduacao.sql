--------------------------------------------------------------
---------------------- FUNCTION ------------------------------
--------------------------------------------------------------
ALTER FUNCTION dbo.fn_periodoDatas
(@desperiodo varchar(10))
RETURNS @periodoDatas TABLE(
	ano int,
	nrperiodo int,
	datade datetime,
	dataate datetime	
)
AS 
BEGIN

	DECLARE
		@ano int,
		@nrperiodo int,
		@datade datetime,
		@dataate datetime	
		
	-- GRADUAÇÃO OU COLÉGIO --
	IF (SELECT CHARINDEX('/', @desperiodo)) > 0
	BEGIN
		-----------------------------------------------------
		WITH tb_table1(
			row,
			id
		)AS(
			SELECT
				ROW_NUMBER() OVER( order by CAST(id AS int)) as row,
				CAST(id AS int)
			FROM dbo.fnSplit(@desperiodo,'/')
		)		
		SELECT @nrperiodo = id FROM tb_table1 WHERE row = 1;
		-----------------------------------------------------		
		WITH tb_table2(
			row,
			id
		)AS(
			SELECT
				ROW_NUMBER() OVER( order by CAST(id AS int)) as row,
				CAST(id AS int)
			FROM dbo.fnSplit(@desperiodo,'/' )
		)		
		SELECT @ano = id FROM tb_table2 WHERE row = 2;
		-----------------------------------------------------
		IF @nrperiodo = 1
		BEGIN
			
			SET @datade = CAST(@ano AS VARCHAR(4)) + '-01-01'
			SET @dataate = CAST(@ano AS VARCHAR(4)) + '-06-30'
			-----------------------------------------------------
			INSERT INTO @periodoDatas
			SELECT @ano, @nrperiodo, @datade, @dataate
			-----------------------------------------------------
			RETURN
		END
		ELSE IF @nrperiodo = 2
		BEGIN
		
			SET @datade = CAST(@ano AS VARCHAR(4)) + '-07-01'
			SET @dataate = CAST(@ano AS VARCHAR(4)) + '-12-31'
			-----------------------------------------------------
			INSERT INTO @periodoDatas
			SELECT @ano, @nrperiodo, @datade, @dataate
			-----------------------------------------------------	
			RETURN 
			
		END
	END
	-- PÓS-GRADUAÇÃO --
	ELSE
	BEGIN
		-----------------------------------------------------
		SET @datade = CAST(@desperiodo AS VARCHAR(4)) + '-01-01'
		SET @dataate = CAST(@desperiodo AS VARCHAR(4)) + '-12-31'
		-----------------------------------------------------
		INSERT INTO @periodoDatas
		SELECT CAST(@desperiodo AS VARCHAR(4)), NULL ,@datade, @dataate
		-----------------------------------------------------
		RETURN
	END
	
	RETURN
END
 
SELECT * FROM  dbo.fn_periodoDatas('2015/2')
--------------------------------------------------------------
---------------------- PROCEDURES ----------------------------
--------------------------------------------------------------
CREATE PROC sp_plano_pgto_cond_by_matricula_get
(@matricula int)
AS
BEGIN
	SELECT TOP 1
		c.CODIGO as CODPLANOS_PGTO, 
		c.DESCRICAO as DESPLANOS_PGTO, 
		d.COD_CONDICAO as CODPLANOS_PGTO_COND,
		d.DESCRICAO as DESPLANOS_PGTO_COND,
		d.DATA_FORMA_PGTO_INI,
		d.DATA_FORMA_PGTO_FIM,
		d.PADRAO,
		b.DATA as DATAVENDA,
		b.TITULAR,
		b.RESPONSAVEL
	FROM SOPHIA.MATRICULA a
	INNER JOIN sophia.VENDAS b ON b.CODIGO = a.VENDA
	INNER JOIN sophia.PLANOS_PGTO c ON c.CODIGO = b.PLANO_PGTO
	INNER JOIN sophia.PLANOS_PGTO_COND d ON d.PLANO_PGTO = c.CODIGO
	INNER JOIN sophia.ITENS e ON e.VENDA = a.VENDA
	WHERE a.CODIGO =  @matricula
	ORDER BY d.PADRAO DESC
END
--
sp_plano_pgto_cond_by_matricula_get 40278
--------------------------------------------------------------
CREATE PROC sp_planos_pgto_parcelas_by_planospgtocond_list
(@codplanospgtocond int)
AS
BEGIN
	SELECT
		COD_PARCELA,
		PLANO_PGTO_COND,
		NUMERO,
		VALOR,
		VALOR_DP,
		INCIDE_DESC_ANTECIP,
		VALOR_ADAPTACAO
	FROM sophia.PLANOS_PGTO_PARCELAS
	WHERE PLANO_PGTO_COND = @codplanospgtocond
	
END
--
sp_planos_pgto_parcelas_by_planospgtocond_list 1862

SELECT * FROM SOPHIA.VENDAS WHERE PLANO_PGTO = 1118
SELECT * FROM SOPHIA.PLANOS_PGTO WHERE CODIGO = 1118
SELECT * FROM SOPHIA.PLANOS_PGTO_COND WHERE PLANO_PGTO = 1118
SELECT * FROM sophia.PLANOS_PGTO_PARCELAS WHERE PLANO_PGTO_COND = 1862

--------------------------------------------------------------
ALTER PROC sp_titulos_dependencia_by_matricula
(@matricula int)
AS
BEGIN
	SELECT 
		a.NOME,
		c.CODIGO,
		SUM(d.VALOR) as VALOR,
		d.PARCELA,
		d.DESCRICAO,
		d.VENDA
	FROM SOPHIA.FISICA a 
	INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
	INNER JOIN SOPHIA.TITULOS c ON c.CODPF = a.CODIGO
	INNER JOIN SophiA.MOVFIN d ON d.TITULO = c.CODIGO
	INNER JOIN SOPHIA.TURMAS e ON e.CODIGO = b.TURMA_REGULAR
	INNER JOIN SOPHIA.PERIODOS f ON f.CODIGO = e.PERIODO
	WHERE 
		d.DESCRICAO LIKE 'DEPEND%' AND 
		c.RECEBIDO <> 2  
		AND b.CODIGO = @matricula AND
		(
			c.DATA_VCTO >= (SELECT datade FROM dbo.fn_periodoDatas(f.DESCRICAO)) AND
			c.DATA_VCTO <= (SELECT dataate FROM dbo.fn_periodoDatas(f.DESCRICAO))
		)
	GROUP BY
		a.NOME,
		c.CODIGO,
		d.PARCELA,
		d.DESCRICAO,
		d.VENDA 
END	
--
sp_titulos_dependencia_by_matricula 39474
SELECT datade FROM dbo.fn_periodoDatas('2015/1')

SELECT * FROM SOPHIA.CURSOS

SELECT dbo.fn_qtdsemestrecurso_get(43) as qtd

sp_info_matricula_get 39474

SELECT dbo.fn_qtdsemestrecurso_get(43) as qtd
--------------------------------------------------------------
ALTER PROC sp_matriculabyfisica_list
(@codfisica int, @data_matricula datetime)
AS
BEGIN
	
	SELECT 
		a.CODIGO,
		a.STATUS,
		b.ORDEM,
		b.DESCRICAO,
		c.CURSO AS IDCURSO
	FROM SOPHIA.MATRICULA a
	INNEr JOIN SOPHIA.SERIE b ON b.CODIGO = a.SERIE
	INNER JOIN SOPHIA.TURMAS c ON c.CODIGO = a.TURMA_REGULAR
	WHERE a.STATUS in (0,5) AND a.FISICA = @codfisica AND a.DATA_MATRICULA <= @data_matricula
	ORDER BY a.DATA_MATRICULA DESC
	
	
END
--
sp_matriculabyfisica_list 10080
--------------------------------------------------------------
--------------------------------------------------------------

sp_plano_pgto_cond_by_matricula_get 35555
sp_planos_pgto_parcelas_by_planospgtocond_list 1862
sp_titulos_dependencia_by_matricula 39474

SELECT * FROM sophia.FISICA where NOME like '%Danilo Soares Alho%'
SELECT * FROM sophia.FISICA WHERE CODIGO = 23557
SELECT * FROM sophia.MATRICULA WHERE FISICA = 23557
SELECT * FROM sophia.PLANOS_PGTO WHERE DESCRICAO like 'DEPendencia'
SELECT * FROM sophia.PLANOS_PGTO WHERE CODIGO in(1390)
SELECT * FROM sophia.VENDAS WHERE CLIENTE = 40021
SELECT * FROM sophia.VENDAS WHERE PLANO_PGTO = 1409
SELECT * FROM sophia.VENDAS WHERE CODIGO = 36280
SELECT * FROM sophia.ITENS
SELECT * FROM sophia.TITULOS WHERE CODPF = 25679

SELECT * FROM SOPHIA.SERIE
SELECT dbo.fn_qtdsemestrecurso_get(43)

SELECT * FROM sophia.PLANOS_PGTO_COND WHERE PLANO_PGTO in(1409)
SELECT * FROM sophia.PLANOS_PGTO_PARCELAS WHERE PLANO_PGTO_COND in (2202)

-- Valor da mensalidade = (valor da mensalidade x 6) + 3,76%
-- Se a turma atual for somente de DP, pegar o valor do titulo
-- turma de dp tem valor do plano zerado, pegar o valor da turma anterior à de somente dp somando as porcentages 3,76 a cada turma retrocedida

SELECT * FROM SOPHIA.MATRICULA
GROUP 

SELECT * FROM sophia.PLANOS_PGTO_COND
WHERE PLANO_PGTO in(
	SELECT PLANO_PGTO FROM sophia.PLANOS_PGTO_COND
	GROUP BY PLANO_PGTO
	HAVING COUNT(*) > 1
)
ORDER BY PLANO_PGTO

SELECT * FROM sophia.PLANOS_PGTO_COND
ORDER BY PLANO_PGTO

SELECT COUNT(*), CLIENTE FROM sophia.VENDAS
GROUP BY CLIENTE
HAVING COUNT(*) > 1

SELECT COUNT(*), PLANO_PGTO FROM sophia.VENDAS
GROUP BY PLANO_PGTO
HAVING COUNT(*) > 1


SELECT b.* FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO AND b.STATUS = 0
WHERE a.CODEXT = '1510630'



SELECT * FROM sophia.PLANOS_PGTO_PARCELAS WHERE PLANO_PGTO_COND = 2450

SELECT * FROM SOPHIA.MATRICULA

SELECT * FROM SOPHIA.ITENS WHERE VENDA = 35733

SELECT * FROM SOPHIA.ITENS
ORDER BY VENDA

-- retorna alunos com plano de pagamento de DP
SELECT b.CODIGO, b.NOME, a.* FROM SophiA.TITULOS a
INNER JOIN sophia.FISICA b ON b.CODIGO = a.CODPF
WHERE CODPF in(
	SELECT a.CLIENTE 
	FROM sophia.VENDAS a
	INNER JOIN sophia.MATRICULA b ON b.VENDA = a.CODIGO
	WHERE b.STATUS = 0 AND a.PLANO_PGTO = 1409 --DP
) AND DATA_VCTO > '2015-07-01'

SELECT * FROM SophiA.TITULOS
WHERE CODIGO in(757890, 866117)

SELECT * FROM sophia.VAL_TIT(866357, '2016-08-04')

SELECT * FROM SophiA.TITULOS
WHERE CODPF = 20767 

[SophiA.TITULOS]
[sophia.PLANOS_PGTO_PARCELAS]

SELECT * FROM SOPHIA.CONC_CLI
SELECT * FROM SOPHIA.MOVFIN WHERE TITULO = 866359
SELECT * FROM SOPHIA.MOVFIN WHERE DESCRICAO LIKE '%DEPEND%'
SELECT * FROM SOPHIA.MODALCOBR
SELECT * FROM SOPHIA.TIT_PGTO
SELECT * FROM SophiA.INFO_TIT(757890, '2015-05-01')
SELECT * FROM Sophia.PLANOCONTAS
SELECT * FROM Sophia.PLANOS_PGTO



--SELECT a.CODEXT, a.SENHA, b.IDENTIFICACAO, b.SENHA , a.NOME FROM SOPHIA.FISICA a
--INNER JOIN SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.CODIGO
--WHERE b.LECIONA = 1 AND a.CODEXT in 
--(
--	'05609864836',
--	'09378598854',
--	'900',
--	'280',
--	'1002',
--	'Rodolfo da Silva Avelino'
--)

--COMMIT TRAN
----------------------------------------------------------------
----------------------------------------------------------------
----------------------------------------------------------------
-- ALUNOS MATRICULADOS EM 2015/2 COM PLANO DEPENDENCIA EM 2015-1

SELECT e.CODEXT, e.SENHA, e.NOME, b.CODIGO, d.* 
FROM SOPHIA.MATRICULA a
INNER JOIN sophia.VENDAS b ON b.CODIGO = a.VENDA
INNER JOIN sophia.PLANOS_PGTO c ON c.CODIGO = b.PLANO_PGTO
INNER JOIN sophia.PLANOS_PGTO_COND d ON d.PLANO_PGTO = c.CODIGO
INNEr JOIN SophiA.FISICA e ON e.CODIGO = a.FISICA
INNER JOIN sophia.TURMAS f ON f.CODIGO = a.TURMA_REGULAR
WHERE 
	d.PLANO_PGTO = 1409 AND f.PERIODO = 127 AND a.STATUS in (0,5) AND (
	
		SELECT COUNT(aa.CODIGO) FROM SOPHIA.MATRICULA aa
		INNER JOIN SOPHIA.TURMAS bb ON bb.CODIGO = aa.TURMA_REGULAR
		WHERE bb.PERIODO = 128 AND aa.FISICA = e.CODIGO AND aa.STATUS = 0
		GROUP BY aa.CODIGO
	) > 0
----------------------------------------------------------------
-- 

SELECT d.*
FROM SOPHIA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
INNER JOIN SOPHIA.VENDAS c ON c.CODIGO = b.VENDA
LEFT JOIN SOPHIA.PLANOS_PGTO d ON d.CODIGO =c.PLANO_PGTO
INNER JOIN SOPHIA.TURMAS e ON e.CODIGO = b.TURMA_REGULAR
WHERE b.STATUS = 0 AND e.PERIODO = 128 AND d.CODIGO IS NULL



----------------------------------------------------------------