Select * from sonata.SophiA.sophia.CONTAS
Select * from sonata.sophia.sophia.TITULOS
Select * from sonata.sophia.sophia.CHEQUES
Select * from sonata.sophia.sophia.CHEQUES_MOV
Select * from sonata.sophia.sophia.MOT_DEV_CHEQUE
Select * from sonata.sophia.sophia.TIT_PGTO WHERE TITULO = 862926
SELECT * FROM SONATA.SOPHIA.SOPHIA.MOVFIN

-- 2 compensado

SELECT * FROM SONATA.SOPHIA.SOPHIA.TITULOS
WHERE CODIGO IN(850263, 866295,866296,866297)

Select * from sonata.sophia.sophia.CHEQUES 
WHERE TITULO IN(863787)

SELECT * FROM sonata.sophia.sophia.CHEQUES_MOV
WHERE CHEQUE in(3234)

Select * from sonata.sophia.sophia.TIT_PGTO 
WHERE TITULO IN(863787)

SELECT * FROM SONATA.SOPHIA.SOPHIA.MOVFIN
WHERE TITULO IN(863787)

SELECT * FROM SONATA.SOPHIA.SOPHIA.VENDAS
WHERE CODIGO = 26083

SELECT * FROM SONATA.SOPHIA.SOPHIA.PLANOS_PGTO
WHERE CODIGO = 224

Select * from sonata.sophia.sophia.MOT_DEV_CHEQUE

SELECT TOP 100 * FROM SATURN.simpac.dbo.tb_cheque_custodia_baixa
SELECT TOP 100 * FROM SATURN.simpac.dbo.tb_cheque
SELECT TOP 100 * FROM SATURN.simpac.dbo.tb_pedidocheque
SELECT TOP 100* FROM SATURN.financeiro.dbo.tb_chequeretorno

SELECT * FROM Simpac..tb_pedidorecepcao

SELECt TOP 100 * FROM Simpac..tb_pedidoparcela a
INNER JOIN Simpac..tb_pedidorecepcao b ON b.idpedido = a.IdPedido
WHERE idtipopagto = 23 
ORDEr BY b.dtCadastro desc

SELECT * FROM SONATA.SOPHIA.SOPHIA.TITULOS WHERE CODPF = 27067

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODEXT = '1510179'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 25579

SELECT * FROM SONATA.SOPHIA.SOPHIA.JURIDICA WHERE CODIGO = 6886
SELECT * FROM SONATA.SOPHIA.SOPHIA.JURIDICA WHERE NOMEFANTAsiA like '%CITI%'

--UPDATE SONATA.SOPHIA.SOPHIA.TITULOS
--SET TITULAR = 7737
--WHERE CODIGO IN (

--	SELECT a.CODIGO, e.NOME, a.TITULAR, d.NOME, a.DATA_VCTO
--	FROM SONATA.SOPHIA.SOPHIA.TITULOS a
--	INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODPF
--	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = b.TURMA_REGULAR
--	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS d ON d.PRODUTO = c.CURSO
--	INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = b.FISICA
--	WHERE d.NIVEL = 4 AND b.STATUS = 0 AND a.DATA_VCTO >= '2015-07-01'
--)
--SELECT * FROM SONATA.SOPHIA.SOPHIA.NIVEl



---------------------------------------------------------------------------
--------------------- TABLES ----------------------------------------------
---------------------------------------------------------------------------
USE FIT_NEW

CREATE TABLE tb_titulocheques(
	idtitulocheque int IDENTITY CONSTRAINT pk_titulocheques PRIMARY KEY,
	idtitulo int,
	nrbanco int,
	nragencia varchar(8),
	nrconta varchar(17),
	nrcheque varchar(22),
	nrparcela tinyint,
	vlparcela numeric(15, 4),
	dtcheque datetime,
	dtvencimento datetime,
	idfisica int,
	qtdtotalparcelas tinyint,
	vltotalparcelas numeric(15, 4),
	idusuario int,
	nrcompensacao int CONSTRAINT DF_titulocheques_nrcompensacao DEFAULT 18,
	instatus bit CONSTRAINT DF_titulocheques_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_titulocheques_dtcadastro DEFAULT getdate()
)
	
SELECT * FROM tb_titulocheques
	
	


---------------------------------------------------------------------------
--------------------- PROCEDURES ------------------------------------------
---------------------------------------------------------------------------
ALTER PROC sp_alunosbysearchby_list
(@value VARCHAR(200), @searchby VARCHAR(100))
AS
/*
  app: SimpacWeb
  url: class/ChequeFIT.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF @searchby = 'ra'
	BEGIN
	
		SELECT DISTINCT
			a.CODIGO,
			a.CODEXT,
			a.NOME,
			a.CPF
		FROM
			SONATA.SOPHIA.SOPHIA.FISICA a
			INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
		WHERE 
			a.CODEXT = @value
		ORDER BY a.NOME
	END
	ELSE IF @searchby = 'cpf'
	BEGIN
	
		SELECT DISTINCT
			a.CODIGO,
			a.CODEXT,
			a.NOME,
			a.CPF
		FROM
			SONATA.SOPHIA.SOPHIA.FISICA a
			INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
		WHERE 
			REPLACE(REPLACE(a.CPF, '.', ''), '-', '') = REPLACE(REPLACE(@value, '.', ''), '-', '')	
		ORDER BY a.NOME
	
	END
	ELSE IF @searchby = 'nome'
	BEGIN
	
		SELECT DISTINCT
			a.CODIGO,
			a.CODEXT,
			a.NOME,
			a.CPF
		FROM
			SONATA.SOPHIA.SOPHIA.FISICA a
			INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
			
		WHERE 
			a.NOME LIKE '%'+@value+'%'
		ORDER BY a.NOME
	
	END

END

--
sp_alunosbysearchby_list 'a', 'nome'

SELECT REPLACE('116.874.398-26', '.', '')
---------------------------------------------------------------------------
ALTER PROC sp_alunosbysearchby_pagination
(
	@value VARCHAR(200), 
	@searchby VARCHAR(100),
	@inicio INT,
    @fim INT
)
AS
/*
  app: SimpacWeb
  url: class/ChequeFIT.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF @searchby = 'ra'
	BEGIN
	
		SELECT  
			* 
		FROM (
		
			SELECT DISTINCT
				ROW_NUMBER() OVER (ORDER BY a.NOME) AS row,
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
			FROM
				SONATA.SOPHIA.SOPHIA.FISICA a
				INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
			WHERE 
				a.CODEXT = @value
			GROUP BY
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
		
		) AS ALUNOS 
		WHERE 
			row BETWEEN @inicio AND @fim
		ORDER BY 
			row; 
	
	
	END
	ELSE IF @searchby = 'cpf'
	BEGIN
	
		SELECT
			* 
		FROM (
		
			SELECT DISTINCT
				ROW_NUMBER() OVER (ORDER BY a.NOME) AS row,
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
			FROM
				SONATA.SOPHIA.SOPHIA.FISICA a
				INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
			WHERE 
				REPLACE(REPLACE(a.CPF, '.', ''), '-', '') = REPLACE(REPLACE(@value, '.', ''), '-', '')	
			GROUP BY
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
		
		) AS ALUNOS 
		WHERE 
			row BETWEEN @inicio AND @fim
		ORDER BY 
			row; 
	
	END
	ELSE IF @searchby = 'nome'
	BEGIN
	
		SELECT
			* 
		FROM (
		
			SELECT
				ROW_NUMBER() OVER (ORDER BY a.NOME) AS row,
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
			FROM
				SONATA.SOPHIA.SOPHIA.FISICA a
				INNER JOIN SONATA.SOPHIA.SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
			WHERE 
				a.NOME LIKE '%'+@value+'%'
			GROUP BY
				a.CODIGO,
				a.CODEXT,
				a.NOME,
				a.CPF
		
		) AS ALUNOS 
		WHERE 
			row BETWEEN @inicio AND @fim
		ORDER BY 
			row; 
	END
END
--             

sp_alunosbysearchby_pagination '34784785884', 'cpf', 1, 50
sp_alunosbysearchby_list 'a', 'nome'

---------------------------------------------------------------------------
CREATE PROC sp_titulocheques_save
(
	@idtitulocheque int,
	@idtitulo int,
	@nrbanco int,
	@nragencia varchar(8),
	@nrconta varchar(17),
	@nrcheque varchar(22),
	@nrparcela tinyint,
	@vlparcela numeric(15, 4),
	@dtcheque datetime,
	@dtvencimento datetime,
	@idfisica int,
	@qtdtotalparcelas tinyint,
	@vltotalparcelas numeric(15, 4),
	@idusuario int,
	@nrcompensacao int = 18,
	@instatus bit = 1
)
AS
/*
  app: SimpacWeb
  url: inc/_class/chequefit.class.php
  author: Massaharu
  date: 01/08/2015
*/
BEGIN

	SET NOCOUNT ON
	
	IF EXISTS (
		SELECT idtitulocheque FROM tb_titulocheques 
		WHERE idtitulocheque = @idtitulocheque
	)
	BEGIN
	
		UPDATE tb_titulocheques
		SET
			idtitulo			= @idtitulo,
			nrbanco				= @nrbanco,
			nragencia			= @nragencia,
			nrconta				= @nrconta,
			nrcheque			= @nrcheque,
			nrparcela			= @nrparcela,
			vlparcela			= @vlparcela,
			dtcheque			= @dtcheque,
			dtvencimento		= @dtvencimento,
			idfisica			= @idfisica,
			qtdtotalparcelas	= @qtdtotalparcelas,
			vltotalparcelas		= @vltotalparcelas,
			idusuario			= @idusuario,
			nrcompensacao		= @nrcompensacao,
			instatus			= @instatus
		WHERE
			idtitulocheque = @idtitulocheque
			
		SET NOCOUNT OFF
		
		SELECT @idtitulocheque as idtitulocheque 
		
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_titulocheques
		(
			idtitulo,
			nrbanco,
			nragencia,
			nrconta,
			nrcheque,
			nrparcela,
			vlparcela,
			dtcheque,
			dtvencimento,
			idfisica,
			qtdtotalparcelas,
			vltotalparcelas,
			idusuario,
			nrcompensacao,
			instatus
		)VALUES(
			@idtitulo,
			@nrbanco,
			@nragencia,
			@nrconta,
			@nrcheque,
			@nrparcela,
			@vlparcela,
			@dtcheque,
			@dtvencimento,
			@idfisica,
			@qtdtotalparcelas,
			@vltotalparcelas,
			@idusuario,
			@nrcompensacao,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as idtitulocheque
	
	END
END
--
---------------------------------------------------------------------------
USE FIT_NEW
GO
CREATE PROC sp_titulocheques_get
(@idtitulocheque int)
AS
/*
  app: SimpacWeb
  url: inc/_class/chequefit.class.php
  author: Massaharu
  date: 01/08/2015
*/
BEGIN
	
	SELECT
		idtitulocheque,
		idtitulo,
		nrbanco,
		nragencia,
		nrconta,
		nrcheque,
		nrparcela,
		vlparcela,
		dtcheque,
		dtvencimento,
		idfisica,
		qtdtotalparcelas,
		vltotalparcelas,
		idusuario,
		nrcompensacao,
		instatus,
		dtcadastro	
	FROM tb_titulocheques
	WHERE 
		idtitulocheque = @idtitulocheque
END
---------------------------------------------------------------------------
USE SOPHIA
GO
CREATE PROC sp_chequemovfin_add
(
	@cod_titulo int,
	@valor numeric(15,4),
	@classificacao int,
	@parcela int,
	@plano int,
	@dt_vcto_desc datetime,
	@descricao varchar(52) = NULL
)
AS
BEGIN

	insert into sophia.MOVFIN
	(
		tipo,
		titulo,
		valor,
		classificacao,
		parcela,
		plano,
		descricao,
		data_reg,
		data,
		tipo_movfin
	)values(
		0,
		@cod_titulo,
		@valor,
		@classificacao,
		@parcela,
		@plano,
		@descricao,
		GETDATE(),
		@dt_vcto_desc,
		1
	)
END

--		

PROXCOD_TITULOS 
sp_sophia_titulo_add

SELECT IDENT_CURRENT('GEN_TITULOS')


---------------------------------------------------------------------------
---------------------------------------------------------------------------
---------------------------------------------------------------------------

USE SOPHIA

SELECT * FROM SophiA.FISICA a
INNER JOIN SOPHIA.MATRICULA b ON b.FISICA = a.CODIGO
WHERE LEN(CODEXT) > 9

