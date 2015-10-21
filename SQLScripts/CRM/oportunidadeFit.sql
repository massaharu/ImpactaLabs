SELECT * FROM tb_oportunidadeusuarios
SELECT * FROM tb_oportunidades
SELECT * FROM tb_oportunidadesfit
SELECT * FROM tb_oportunidadesfitdescontos
SELECT * FROM tb_transferidofaculdades
SELECT * FROM tb_oportunidadefitpalestravestibulares
SELECT * FROM tb_oportunidadeusuariotipos
SELECT * FROM tb_oportunidadeetapas
SELECT * FROM tb_oportunidadeetapatipos
SELECT * FROM Simpac..tb_usuario where IdDepto = 19
SELECT * FROM Simpac..tb_depto order by DesDepartamento
select * from tb_documentos where iddocumentotipo = 8
select * from tb_documentotipos
SELECT * FROM vendas..tb_arquivos 
SELECt * FROM tb_oportunidadearquivos
SELECT * FROM tb_oportunidadeetapatipos where idoportunidade= 400
SELECT * FROM tb_pessoas where idpessoa = 1021843
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA where NOME like '%maruf%'
SELECT * FROM tb_pessoassophia

sp_oportunidadepagamentosbyidoportunidadepai_get 354

SELECT * FROM tb_pagamentos where idpagamento = 10012

SELECt * FROM tb_oportunidadesfitdescontos
SELECT * FROM tb_descontosbolsasfit
SELECT * FROM tb_oportunidadeetapatipos

INSERT INTO tb_oportunidadeetapatipos (desetapa)
values('Aprovado no Vestibular'),('Curriculum aprovado')

SELECT * FROM tb_pessoassophia
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 1252
SELECT * FROM SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%Lindsay Lohan%'
SELECT * FROM SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%Lindsay Lohan%'

SELECT d.NOME, * FROM 
tb_oportunidades a
INNER JOIN tb_oportunidadesfit b ON b.idoportunidade = a.idoportunidade
INNER JOIN tb_produtos_sophiacursos c ON c.idproduto = b.idproduto
INNER JOIN SOPHIA.SOPHIA.CURSOS d ON d.PRODUTO = c.produto

--  
select 
      c.CODIGO,
      c.NOME
from sophia.CONCURSOS a
inner join sophia.CONC_CLI b on a.CODIGO = b.CONCURSO
inner join sophia.FISICA c on b.FISICA = c.CODIGO
where a.CODIGO = 189
order by c.NOME, c.CODIGO


SELECT * FROM fit_new.dbo.tb_vestibular_aprovados
SELECT * FROM fit_new.dbo.tb_vestibular_reprovados

SELECT * FROM tb_pessoas where idpessoa = 1021843

SELECT d.despessoa, * FROM tb_oportunidadeusuarios a
INNER JOIN simpac..tb_usuario b ON b.idusuario = a.idusuario
INNER JOIN tb_oportunidades c ON c.idoportunidade = a.idoportunidade
INNER JOIN tb_pessoas d ON d.idpessoa = c.idpessoa

SELECT * FROM SONATA.SOPHIA.SOPHIA.NIVEL

SELECT * FROM tb_produtotipos

--------------------------------------------------------------------------------
------------------------ TABELAS -------------------------------------------
--------------------------------------------------------------------------------
CREATE TABLE tb_oportunidadesfitsophia(
	idoportunidadesfit_sophia int IDENTITY CONSTRAINT PK_oportunidadesfitsophia PRIMARY KEY ,
	idoportunidadefit int,
	idturma int not null,
	nrordem smallint
	
	CONSTRAINT FK_oportunidadesfitsophia_oportunidadefit_idoportunidadefit FOREIGN KEY(idoportunidadefit)
	REFERENCES tb_oportunidadesfit (idoportunidadefit)
)

SELECT * FROM tb_oportunidadesfitsophia
--------------------------------------------------------------------------------
CREATE TABLE tb_oportunidadesfitdocs(
  idoportunidadefitdoc int identity CONSTRAINT PK_oportunidadesfitdocs PRIMARY KEY,
  idoportunidadefit int,
  documento int,
  CONSTRAINT FK_oportunidadesfitdocs_oportunidadesfit_idoportunidadefit FOREIGN KEY(idoportunidadefit)
  REFERENCES tb_oportunidadesfit (idoportunidadefit)
)

SELECT * FROM tb_oportunidadesfitdocs
--------------------------------------------------------------------------------
------------------------ PROCEDURES -------------------------------------------
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadealuno_list
(
	@nrcpf varchar(11) = null,
	@idoportunidade int = null
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadealuno_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todos as oportunidades 
*/
BEGIN
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	

	IF (@nrcpf IS NULL) AND (@idoportunidade IS NULL)
		SET @WHERE = ''
	ELSE IF @nrcpf IS NULL
		SET @WHERE = 'WHERE e.idoportunidade = @idoportunidade AND f.idoportunidadeusuariotipo = 1'
	ELSE IF @idoportunidade IS NULL
		SET @WHERE = 'WHERE b.desdocumento = @nrcpf AND f.idoportunidadeusuariotipo = 1'
	ELSE	
		SET @WHERE = 'WHERE b.desdocumento = @nrcpf AND e.idoportunidade = @idoportunidade AND f.idoportunidadeusuariotipo = 1'

	SET @sqlStatement = 
		'SELECT
			d.idoportunidade,
			e.idoportunidadefit, 
			e.idproduto,
			e.idprodutotipo,
			g.idusuario as idvendedor,
			g.NmCompleto as desvendedor,
			p.codigo as fisica,
			a.idpessoa,
			a.despessoa,
			b.iddocumento as iddocnrcpf,
			b.desdocumento as nrcpf,
			c.iddocumento as iddocnrrg,
			c.desdocumento as nrrg,
			h.idcontato as idcontatodesemail,
			h.descontato as desemail,
			i.idcontato as idcontatodesfone,
			i.descontato as desfone,
			j.idcontato as idcontatodescelular,
			j.descontato as descelular, 	
			e.dtcadastro as dtoportunidadefit,
			e.indocumentoliberado,
			d.idoportunidadepai,
			l.desetapa,
			l.idoportunidadeetapatipo,
			n.nome as descurso
		FROM tb_pessoas a 
		LEFT JOIN tb_documentos b ON b.idpessoa = a.idpessoa AND b.iddocumentotipo = 1
		LEFT JOIN tb_documentos c ON b.idpessoa = c.idpessoa AND c.iddocumentotipo = 5
		INNER JOIN tb_oportunidades d ON d.idpessoa = a.idpessoa
		INNER JOIN tb_oportunidadesfit e ON e.idoportunidade = d.idoportunidade
		LEFT JOIN tb_oportunidadeusuarios f ON f.idoportunidade = d.idoportunidade
		LEFT JOIN Simpac..tb_usuario g ON g.idusuario = f.idusuario
		LEFT JOIN tb_contatos h ON a.idpessoa = h.idpessoa AND h.idcontatotipo = 1
		LEFT JOIN tb_contatos i ON a.idpessoa = i.idpessoa AND i.idcontatotipo = 2
		LEFT JOIN tb_contatos j ON a.idpessoa = j.idpessoa AND j.idcontatotipo = 3
		LEFT JOIN tb_oportunidadeetapas k ON k.idoportunidade = d.idoportunidade AND k.instatus = 1
		LEFT JOIN tb_oportunidadeetapatipos l ON l.idoportunidadeetapatipo = k.idoportunidadeetapatipo
		LEFT JOIN tb_produtos_sophiacursos m ON m.idproduto = e.idproduto 
		LEFT JOIN SONATA.SOPHIA.SOPHIA.CURSOS n ON n.PRODUTO = m.produto
		LEFT JOIN tb_pessoassophia o ON o.idpessoa = a.idpessoa
		LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA p ON p.CODIGO = o.codigo		
		'+@WHERE+'
		ORDER BY e.dtcadastro DESC'
		
		exec sp_ExecuteSQL @sqlStatement, N'@nrcpf varchar(11), @idoportunidade int', @nrcpf, @idoportunidade
END

sp_oportunidadealuno_list '34784785884', 328
--
sp_oportunidadealuno_list null, 385
sp_oportunidadealuno_list 34784785884, NULL

SELECT * FROM tb_oportunidades a 
LEFT JOIN tb_oportunidadeetapas b ON b.idoportunidade = a.idoportunidade AND b.instatus = 1
LEFT JOIN tb_oportunidadeetapatipos c ON c.idoportunidadeetapatipo = b.idoportunidadeetapatipo
WHERE a.idoportunidade = 564

SELECT * FROM tb_oportunidadeetapas
SELECT * FROM tb_oportunidadeetapatipos
SELECT * FROM tb_oportunidadesfit where idoportunidade = 329
SELECT * FROM tb_oportunidadevalidades where idoportunidade = 329
SELECT * FROM tb_oportunidades
SELECT * FROM tb_produtos
SELECt * FROM tb_produtos_sophiacursos
SELECT * FROM tb_pessoassophia
SELECT * FROM tb_pessoas where idpessoa = 1021843
SELECt * FROM SONATA.SOPHIA.SOPHIA.FISICA where NOME LIKE '%maruf%'
SELECT * FROM tb_contatos
SELECT * FROM tb_contatotipos

SELECt * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 26622

INSERT INTO tb_produtos(idprodutotipo, desproduto)
VALUES(6, 'Taxa de Matrícula')


1004775	6	Taxa de Matrícula	1	2014-09-12 13:11:44.983	NULL	0	NULL	NULL
--------------------------------------------------------------------------------s
CREATE PROC sp_oportunidadefitpalestravestibulares_list
(@idoportunidadefit int)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadefitpalestravestibulares_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todos os vestibulares de uma oportunidades
*/
BEGIN
	SELECT 
		a.idoportunidadefitpalestravestibular, 
		a.idoportunidadefit, 
		a.idpalestra, 
		c.cadastrotitulo as despalestra,
		a.idvestibular, 
		b.descricao as desvestibular,
		a.dtcadastro, 
		a.instatus
	FROM tb_oportunidadefitpalestravestibulares a
	INNER JOIN SONATA.SOPHIA.SOPHIA.CONCURSOS b ON b.CODIGO = a.idvestibular
	LEFT JOIN saturn.fit_new.dbo.cadcadastro c ON c.cadastroId = a.idpalestra
	WHERE idoportunidadefit = @idoportunidadefit and a.instatus = 1
END

SELECT * FROM tb_oportunidadefitpalestravestibulares

sp_oportunidadefitpalestravestibulares_list 33
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadesfit_get 
(@idoportunidadefit int)
AS
BEGIN
	SELECT
		a.idoportunidadefit, a.idoportunidade, b.idprodutotipo, c.desprodutotipo, a.idproduto, b.desproduto, a.intransferido, a.infies, a.inprouni, a.dtcadastro, a.instatus, a.nrparcelas as nrparcelasoportunidadefit, a.dtvencimentomatricula, a.inboletomatriculagerado, a.indocumentoliberado, a.inboletovestibulargerado, d.idpessoa, a.inenem, a.nrnotaenem
	FROM tb_oportunidadesfit a
	INNER JOIN tb_produtos b ON b.idproduto = a.idproduto
	INNER JOIN tb_produtotipos c ON c.idprodutotipo = b.idprodutotipo
	INNER JOIN tb_oportunidades d ON d.idoportunidade = a.idoportunidade
	WHERE a.idoportunidadefit = @idoportunidadefit
END
--
SELECt * FROM tb_produtos where idproduto = 1003658
SELECT * FROM tb_oportunidadesfit where idoportunidade = 385
SELECT * FROM tb_oportunidades where idoportunidade = 385
SELECT * FROM tb_pessoas
SELECt * FROM tb_documentos
UPDATE tb_oportunidadesfit
set dtvencimentomatricula = '2014-09-19'
where idoportunidadefit = 14

sp_oportunidadesfit_get 14




sp_produtovalores_list 1003665

SELECt * FROM tb_valores where idproduto = 1003658

SELECT * FROM tb_prio
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadedescontos_list
(
	@idoportunidadefit int,
	@iddescontoitemtipo int
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadedescontos_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todos os descontos de uma oportunidade e de um tipo do item do desconto
*/
BEGIN
	SELECT 
		a.idoportunidadefit,
		a.iddescontoitemtipo,
		b.destipoitem,
		a.iddesconto,
		c.desdesconto,
		c.iddescontotipo,
		d.desdescontotipo,
		a.dtcadastro,
		a.instatus
	FROM tb_oportunidadesfitdescontos a
	INNER JOIN tb_descontositemtipos b ON b.iddescontoitemtipo = a.iddescontoitemtipo
	INNER JOIN tb_descontos c ON c.iddesconto = a.iddesconto
	INNER JOIN tb_descontostipos d ON d.iddescontotipo = c.iddescontotipo
	WHERE idoportunidadefit = @idoportunidadefit AND a.iddescontoitemtipo = @iddescontoitemtipo
END
--
sp_oportunidadedescontos_list 82, 2

SELECT * FROM tb_oportunidadesfit WHERE idoportunidade = 400
SELECT * FROM  tb_oportunidadesfitdescontos
SELECt * FROM tb_descontositemtipos
SELECt * FROM tb_descontositens
SELECT * FROM tb_pessoassophia
SELECT * FROM tb_pessoas
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA where CODIGO = 26332

INSERT tb_pessoassophia (idpessoa, codigo)
VALUES (1027239, 26341)
1027236
26338

sp_oportunidadepagamentosbyidoportunidadepai_get 366
--------------------------------------------------------------------------------
ALTER PROC sp_turmasbyperiodoprodutos_list
(
	@idproduto int,
	@idperiodo int
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/turmasbyperiodoprodutos_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Lista todas as turmas por um periodo e produto
*/
BEGIN
	SELECT 
		a.CODIGO, a.NOME, a.SERIE 
	FROM SONATA.SOPHIA.SOPHIA.TURMAS a
	INNER JOIN Vendas..tb_produtos_sophiacursos b ON b.produto = a.CURSO
	WHERE b.idproduto = @idproduto AND a.PERIODO = @idperiodo
END
--
sp_turmasbyperiodoprodutos_list 1003663, 125
--------------------------------------------------------------------------------
CREATE PROC sp_oportunidadesfitsophia_save
(
      @idoportunidadefit int,
      @idturma int, 
      @nrordem smallint
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/ajax/oportunidadesfit_sophia_save.php
  author: Massaharu
  date: 1/10/2013
  desc: Vincula uma turma e periodo a uma oportunidade da fit
*/
BEGIN
      IF EXISTS(
            SELECT * FROM tb_oportunidadesfitsophia 
            WHERE idoportunidadefit = @idoportunidadefit
      )
      BEGIN
            UPDATE tb_oportunidadesfitsophia
            SET 
                  idturma = @idturma,
                  nrordem = @nrordem
            WHERE idoportunidadefit = @idoportunidadefit
      END 
      ELSE
      BEGIN
            INSERT INTO tb_oportunidadesfitsophia (idoportunidadefit, idturma, nrordem)
            VALUES(@idoportunidadefit, @idturma, @nrordem) 
      END
END
--
SELECt * FROM tb_oportunidadesfit_sophia

--------------------------------------------------------------------------------
ALTER PROC sp_descontositensbydesconto_list
(@iddesconto int, @idoportunidadefit int, @iditemtipo int = null)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/ajax/descontositensbydesconto_list.php
  author: Massaharu
  date: 1/10/2013
  desc: Vincula uma turma e periodo a uma oportunidade da fit
*/
BEGIN
	IF @iditemtipo IS NULL
	
		SELECT iddescontoitem, a.iddesconto, iditemtipo, nrdia, nrporc, inutil, c.incartadesconto
		FROM tb_descontositens a
		INNER JOIN tb_oportunidadesfitdescontos b ON b.iddesconto = a.iddesconto AND b.iddescontoitemtipo = a.iditemtipo
		INNER JOIN tb_descontos c ON c.iddesconto = a.iddesconto
		WHERE a.iddesconto = @iddesconto AND b.idoportunidadefit = @idoportunidadefit
		ORDER BY iditemtipo, nrdia
	ELSE
		SELECT iddescontoitem, a.iddesconto, iditemtipo, nrdia, nrporc, inutil, c.incartadesconto
		FROM tb_descontositens a
		INNER JOIN tb_oportunidadesfitdescontos b ON b.iddesconto = a.iddesconto AND b.iddescontoitemtipo = a.iditemtipo
		INNER JOIN tb_descontos c ON c.iddesconto = a.iddesconto
		WHERE a.iddesconto = @iddesconto AND b.idoportunidadefit = @idoportunidadefit AND iditemtipo = @iditemtipo
		ORDER BY iditemtipo, nrdia
END
--
SELECt * FROM tb_descontositens where iddesconto = 21
SELECT * FROM tb_oportunidadesfitdescontos
sp_descontositensbydesconto_list 23, 82, 2

--------------------------------------------------------------------------------
CREATE PROC sp_valoresbyproduto_list
(
@idproduto int
)
AS
BEGIN
	select TOP 1
		idvalor,
		idproduto,
		nrvalor,
		dtinicio,
		dttermino,
		dtcadastro
	from tb_valores
	where idproduto = @idproduto
	order by dtcadastro desc
END

sp_valoresbyproduto_list 1003665
--------------------------------------------------------------------------------
CREATE PROC sp_semestrescursobyproduto_get --1003665
(@idproduto int)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/semestrescursobyproduto_get.php
  author: Massaharu
  date: 1/10/2013
  desc: Retorna o numero de semestres de um produto
*/
BEGIN
	SET NOCOUNT ON
	
	DECLARE @TEMP table  (
		codigo int,
		curso int
	)
	insert into @TEMP (codigo, curso)
	select MAX(codigo)as codigo, curso from SONATA.SOPHIA.SOPHIA.CURRICULO
	group by curso
	order by curso

	SET NOCOUNT OFF 
	
	select count(c.codigo) semestres 
	from tb_produtos_sophiacursos a 
	inner join @TEMP b on b.CURSO = a.produto
	inner join SONATA.SOPHIA.SOPHIA.SERIE c on c.curriculo = b.codigo
	where a.idproduto = @idproduto
END
--------------------------------------------------------------------------------
CREATE PROC sp_oportunidadesfitsophia_get --56
(@idoportunidadefit int)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/oportunidadesfit_sophia_get.php
  author: Massaharu
  date: 1/10/2013
  desc: Retorna a turma e o periodo de uma oportunidade da fit
*/
BEGIN
      SELECT 
            idoportunidadesfitsophia, idoportunidadefit, idturma, 
            b.NOME as desturma, b.PERIODO as idperiodo, c.DESCRICAO as desperiodo, nrordem
      FROM tb_oportunidadesfitsophia a
      INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.idturma
      INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS c ON c.CODIGO = b.PERIODO
      WHERE idoportunidadefit = @idoportunidadefit
END

--------------------------------------------------------------------------------
CREATE PROC sp_classificacaobyproduto_get
(@idcurso int)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/atendimento/acompanhamento_oportunidade/actions/json/classificacaobyproduto_get.php
  author: Massaharu
  date: 1/10/2014
  desc: Retorna a classificacao de um curso
*/
BEGIN
	SELECT 
		A.CLASSIFIC_MATR AS COD_CLASSIF_MATRICULA,
		B.DESCRICAO AS MATRICULA,
		A.CLASSIFICACAO AS COD_CLASSIF_MENSALIDADE,
		B.DESCRICAO AS MENSALIDADE
	FROM SONATA.SOPHIA.SOPHIA.PRODUTOS A
	INNER JOIN SONATA.SOPHIA.SOPHIA.PLANOCONTAS B ON A.CLASSIFIC_MATR = B.CODIGO 
	INNER JOIN SONATA.SOPHIA.SOPHIA.PLANOCONTAS C ON A.CLASSIFICACAO = C.CODIGO
	WHERE A.DESCRICAO IN(SELECT NOME_RESUM FROM SONATA.SOPHIA.SOPHIA.CURSOS WHERE PRODUTO = @idcurso)
END	
--------------------------------------------------------------------------------
ALTER PROC sp_alunosophiabypessoa_get
(@idpessoa int)
AS
BEGIN
	SELECT c.* FROM tb_pessoas a
	INNER JOIN tb_pessoassophia b ON a.idpessoa = b.idpessoa
	INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA c ON c.CODIGO = b.codigo
	WHERE a.idpessoa = @idpessoa
END


SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 26283
SELECT * FROM tb_pessoassophia 
--------------------------------------------------------------------------------
ALTER PROC sp_cursossophiabyproduto_get
(@idproduto int)
AS
BEGIN
	SELECT c.* FROM tb_produtos a
	INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
	WHERE a.idproduto = @idproduto
END
--
SELECT * FROM tb_produtos_sophiacursos where produto = 57
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS
sp_cursossophiabyproduto_get 1003663
--------------------------------------------------------------------------------
CREATE PROC sp_oportunidadepagamentosbyidoportunidadepai_get
(@idoportunidadepai int)
As
BEGIN
	SELECT top 
		1 a.idoportunidade, a.idpessoa, a.inuniversidade, a.idendereco, a.instatus, a.desemail, 
		a.dtnotafiscal, a.dtcadastro, a.idoportunidadetipo, a.idoportunidadepai, b.idpagamento 
		FRom tb_oportunidades a
	INNER JOIN tb_oportunidadepagamentos b ON b.idoportunidade = a.idoportunidade
	where a.idoportunidadepai = @idoportunidadepai
	ORDER BY a.dtcadastro desc
END

sp_oportunidadepagamentosbyidoportunidadepai_get 379
--------------------------------------------------------------------------------
CREATE PROC sp_cursoscoordenador_list  
(@prof_responsavel int)
AS
BEGIN
	SELECt CURSO FROM SONATA.SOPHIA.SOPHIA.TURMAS a
	WHERE PROF_RESPONSAVEL = @prof_responsavel
	GROUP BY CURSO
END
--
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE EMAIL  =  'anacris.santos@gmail.com'

sp_cursoscoordenador_list  3566
--------------------------------------------------------------------------------
CREATE PROC sp_documentos_pessoas_save
(
	@idpessoa int, 
	@iddocumento int,
	@iddocumentotipo int,
	@desdocumento varchar(100)
)
AS
BEGIN
	SET NOCOUNT ON
	IF EXISTS(
		SELECT * FROM tb_pessoas a
		INNER JOIN tb_documentos b ON b.idpessoa = a.idpessoa
		WHERE b.iddocumentotipo = @iddocumentotipo AND a.idpessoa = @idpessoa 
	)
	BEGIN
		
		UPDATE tb_documentos
		SET	desdocumento = @desdocumento
		WHERE iddocumento = @iddocumento
		
		SET NOCOUNT OFF
		
		SELECT @iddocumento as iddocumento
	END
	ELSE
	BEGIN
		INSERT INTO tb_documentos (iddocumentotipo, idpessoa, desdocumento)
		VALUES (@iddocumentotipo, @idpessoa, @desdocumento)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as iddocumento
	END	
END
--
sp_documentos_pessoas_save 1027227, 0, 1, '395.390.638-09'
SELECT * FROM tb_pessoas
SELECT * FROM tb_documentos
SELECT * FROM tb_documentotipos
SELECT * FROM tb_pessoassophia where idpessoa =1027227

SELECT * FROM tb_pessoas a
INNER JOIN tb_documentos b ON b.idpessoa = a.idpessoa
WHERE a.idpessoa = 1027227 
--------------------------------------------------------------------------------
ALTER PROC sp_documentos_sophia_save
(@idpessoa int, @desdocumento varchar(100), @iddocumentotipo int)
AS
BEGIN

	-- ALTERA O CPF
	IF @iddocumentotipo = 1 
		UPDATE SONATA.SOPHIA.SOPHIA.FISICA
		SET CPF = @desdocumento
		WHERE CODIGO = (
			SELECT TOP 1 codigo FROM tb_pessoassophia 
			WHERE idpessoa = @idpessoa
			ORDER BY dtcadastro DESC
		)
	-- ALTERA O RG
	ELSE IF @iddocumentotipo = 5 
		UPDATE SONATA.SOPHIA.SOPHIA.FISICA
		SET RG = @desdocumento
		WHERE CODIGO = (
			SELECT TOP 1 codigo FROM tb_pessoassophia 
			WHERE idpessoa = @idpessoa
			ORDER BY dtcadastro DESC
		)
END
--
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA where CODIGO = 26332
sp_documentos_sophia_save 1027227, '395.390.638-09', 1
sp_documentos_sophia_save 1027227, '467147206', 5
--------------------------------------------------------------------------------
CREATE PROC sp_contatos_pessoas_save
(
	@idpessoa int,
	@idcontato int,
	@idcontatotipo int,
	@descontato varchar(100)
)
AS
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT * FROM tb_pessoas a
		INNER JOIN tb_contatos b ON b.idpessoa = a.idpessoa
		WHERE b.idcontatotipo = @idcontatotipo AND a.idpessoa = @idpessoa 
	)
	BEGIN
		
		UPDATE tb_contatos
		SET	descontato = @descontato
		WHERE idcontato = @idcontato
		
		SET NOCOUNT OFF
		
		SELECT @idcontato as iddocumento
	END
	ELSE
	BEGIN
		INSERT INTO tb_contatos (idcontatotipo, idpessoa, descontato, idcontatotipocategoria)
		VALUES (@idcontatotipo, @idpessoa, @descontato, 1)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as iddocumento
	END	
END
--
SELECT * FROM tb_contatos where descontato = 'julio@impacta.com.br'
SELECT * FROM tb_contatos where idcontato =1406542 
sp_contatos_pessoas_save 1027227, 0, 1, 'jvalezzi@impacta.com.br'
sp_contatos_pessoas_save 1027227, 0, 2, '(22)2222-2222'

SELECT * FROM tb_pessoas a
INNER JOIN tb_contatos b ON b.idpessoa = a.idpessoa
WHERE b.idcontatotipo = 2 AND a.idpessoa = 1027227 

SELECT * FROM tb_pessoassophia where idpessoa = 1027227
--------------------------------------------------------------------------------
ALTER PROC sp_contatos_sophia_save
(@idpessoa int, @descontato varchar(100), @idcontatotipo int )
AS
BEGIN

	DECLARE @FORMACONTATO1 int, @FORMACONTATO2 int, @FORMACONTATO3 int
	
	-- EMAIL
	IF @idcontatotipo = 1
		UPDATE SONATA.SOPHIA.SOPHIA.FISICA
		SET EMAIL = @descontato
		WHERE CODIGO = (
			SELECT TOP 1CODIGO FROM tb_pessoassophia
			WHERE idpessoa = @idpessoa
			ORDER BY dtcadastro DESC
		)
		
	SELECT 
		@FORMACONTATO1 = FORMACONTATO1, 
		@FORMACONTATO2 = FORMACONTATO2, 
		@FORMACONTATO3 = FORMACONTATO3
	FROM SONATA.SOPHIA.SOPHIA.FISICA 
		WHERE CODIGO = (
			SELECT TOP 1 CODIGO FROM tb_pessoassophia
			WHERE idpessoa = @idpessoa
			ORDER BY dtcadastro DESC
		)
	
	-- TELEFONE = 2 [CRM]
	IF @idcontatotipo = 2
	BEGIN
		
		--TELEFONE = 6 [SOPHIA]			
		IF @FORMACONTATO1 = 6
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO1 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO2 = 6
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO2 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO3 = 6
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO3 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO1 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO1 = @descontato,
				FORMACONTATO1 = 6
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO2 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO2 = @descontato,
				FORMACONTATO2 = 6
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO3 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO3 = @descontato,
				FORMACONTATO3 = 6
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE 
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO3 = @descontato,
				FORMACONTATO3 = 6
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		
	END
	-- CELULAR = 3 [CRM]
	ELSE IF @idcontatotipo = 3
	BEGIN
		
		--CELULAR = 2 [SOPHIA]			
		IF @FORMACONTATO1 = 2
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO1 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO2 = 2
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO2 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO3 = 2
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET CONTATO3 = @descontato
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO1 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO1 = @descontato,
				FORMACONTATO1 = 2
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO2 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO2 = @descontato,
				FORMACONTATO2 = 2
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE IF @FORMACONTATO3 IS NULL
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO3 = @descontato,
				FORMACONTATO3 = 2
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
		ELSE 
			UPDATE SONATA.SOPHIA.SOPHIA.FISICA
			SET 
				CONTATO3 = @descontato,
				FORMACONTATO3 = 2
			WHERE CODIGO = (
				SELECT TOP 1 CODIGO FROM tb_pessoassophia
				WHERE idpessoa = @idpessoa
				ORDER BY dtcadastro DESC
			)
	END
END
--
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 26332
sp_contatos_sophia_save 1027227, 'julio@impacta.com.br', 1
--------------------------------------------------------------------------------
ALTER PROC sp_documentos_sophia_list
(@codigo int = null)
AS
BEGIN
	IF @codigo IS NULL
		SELECT CODIGO, DESCRICAO FROM SONATA.SOPHIA.SOPHIA.DOCUMENTOS
		ORDER BY DESCRICAO
	ELSE
		SELECT CODIGO, DESCRICAO FROM SONATA.SOPHIA.SOPHIA.DOCUMENTOS
		WHERE CODIGO = @codigo
		ORDER BY DESCRICAO
END

--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadesfitdocs_list
(@idoportunidadefit int)
AS
BEGIN
	SELECT
		idoportunidadefitdoc,
		idoportunidadefit,
		documento
	FROM tb_oportunidadesfitdocs
	WHERE idoportunidadefit = @idoportunidadefit
	
END
--
sp_oportunidadesfitdocs_list 111
SELECT * FROM tb_oportunidadesfit
SELECT * FROM tb_oportunidadesfitdocs
--------------------------------------------------------------------------------
CREATE PROC sp_oportunidadesfitarquivos_list
(@idoportunidadefit int, @searchfor varchar(100) = NULL)
AS
BEGIN
	IF @searchfor IS NULL
	BEGIN
		SELECT 
			a.idoportunidadefit, a.idoportunidade, d.idarquivo, d.desarquivo, d.nrtamanho, d.idproprietario, d.idtipo, d.indeletado, d.descaminho, d.dtcadastro,
			e.destipo, e.desextensao, e.destipousuario, c.idoportunidadearquivo, c.inprivado, c.instatus
		FROM tb_oportunidadesfit a
		INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
		INNER JOIN tb_oportunidadearquivos c ON c.idoportunidade = b.idoportunidade
		INNER JOIN tb_arquivos d ON d.idarquivo = c.idarquivo
		INNER JOIN tb_arquivotipos e ON e.idtipo = d.idtipo
		WHERE a.idoportunidadefit = @idoportunidadefit
	END
	ELSE
	BEGIN
		SELECT 
			a.idoportunidadefit, a.idoportunidade, d.idarquivo, d.desarquivo, d.nrtamanho, d.idproprietario, d.idtipo, d.indeletado, d.descaminho, d.dtcadastro,
			e.destipo, e.desextensao, e.destipousuario, c.idoportunidadearquivo, c.inprivado, c.instatus
		FROM tb_oportunidadesfit a
		INNER JOIN tb_oportunidades b ON b.idoportunidade = a.idoportunidade
		INNER JOIN tb_oportunidadearquivos c ON c.idoportunidade = b.idoportunidade
		INNER JOIN tb_arquivos d ON d.idarquivo = c.idarquivo
		INNER JOIN tb_arquivotipos e ON e.idtipo = d.idtipo
		WHERE a.idoportunidadefit = @idoportunidadefit AND desarquivo LIKE '%'+@searchfor+'%'
	END
END
--
SELECT * FROM tb_arquivos where idarquivo in (1379862, 1379863)
SELECT * FROM tb_arquivotipos
SELECT * FROM tb_oportunidadearquivos where idoportunidade = 427
--------------------------------------------------------------------------------
ALTER PROC [dbo].[sp_oportunidadesfitdocs_save]
(
	@idoportunidadefit int,
	@documentos varchar(500)
)
AS
BEGIN
	DELETE tb_oportunidadesfitdocs
	WHERE idoportunidadefit = @idoportunidadefit
	
	INSERT INTO tb_oportunidadesfitdocs (idoportunidadefit, documento)
	SELECT @idoportunidadefit, id FROM Simpac.dbo.fnSplit(@documentos, ',')
END
--------------------------------------------------------------------------------
ALTER PROC sp_oportunidadebyvestibularpessoa_get
(@cod_fisica int, @idvestibular int)
AS
BEGIN
	select
		  c.idoportunidade,
		  a.idpessoa,
		  a.despessoa,
		  b.descontato as desemail,
		  j.nmcompleto,
		  j.cdemail,
		  k.NOME as descurso,
		  e.idvestibular,
		  g.produto,
		  f.codigo,
		  g.codturno,
		  c.idoportunidade
	from tb_pessoas a
	left join tb_contatos b on a.idpessoa = b.idpessoa and b.idcontatotipo = 1
	inner join tb_oportunidades c on b.idpessoa = c.idpessoa
	inner join tb_oportunidadesfit d on c.idoportunidade = d.idoportunidade
	inner join tb_oportunidadefitpalestravestibulares e on d.idoportunidadefit = e.idoportunidadefit
	inner join tb_pessoassophia f on b.idpessoa = f.idpessoa
	inner join tb_produtos_sophiacursos g on d.idproduto = g.idproduto
	inner join tb_oportunidadeusuarios h on h.idoportunidade = c.idoportunidade
	inner join tb_oportunidadeusuariotipos i ON i.idoportunidadeusuariotipo = h.idoportunidadeusuariotipo and i.idoportunidadeusuariotipo = 1
	inner join Simpac..tb_usuario j ON j.idusuario = h.idusuario
	inner join sophia.sophia.CURSOS k ON k.PRODUTO = g.produto
	where 
			f.codigo = @cod_fisica and
			e.idvestibular = @idvestibular  and
			d.instatus = 1 and
			e.instatus = 1
END
--
sp_oportunidadebyvestibularpessoa_get 26361, 196

SELECT * FROM tb_contatos
SELECT * FROM tb_oportunidadeusuarios
SELECT * FROM tb_oportunidades
SELECT * FROM tb_oportunidadeusuariotipos
SELECT * FROM SOPHIA.SOPHIA.CONCURSOS where CODIGO = 196
--------------------------------------------------------------------------------
SELECt * FROM tb_contatos where idpessoa = 1021843
SELECT * FROM tb_contatotipos
SELECT * FROM tb_contatotipocategorias
SELECT * FROM tb_oportunidadeetapas
SELECT * FROM tb_oportunidadefitpalestravestibulares
SELECT * FROM saturn.fit_new.dbo.tb_vestibular_sophia_concurso
SELECT * FROM tb_documentotipos
SELECT * FROM tb_oportunidadeusuarios
select * from tb_pessoas WHERE idpessoa = 1021843
SELECT * FROM tb_documentos where desdocumento = '34784785884'
SELECT * FROM tb_oportunidadearquivos
SELECt * FROM tb_arquivos WHERE idarquivo = 1379767
SELECT * FROM fit_new..Cadcadastro
SELECT * FROM saturn.fit_new.dbo.tb_vestibular_sophia
SELECT * FROM SOPHIA.SOPHIA.CONCURSOS
SELECT * FROM tb_produtotipos
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS WHERE NOME LIKE '%arquitetura%'
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CURSO = 75
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 7939

SELECT * FROM tb_oportunidadesfit
SELECT * FROM tb_oportunidadeetapatipos
SELECT * FROM tb_descontos
SELECT * FROM tb_descontostipos
SELECT * FROM tb_oportunidadesfitdescontos
SELECT * FROm tb_descontositemtipos
SELECT * FROM tb_descontoscampanhasfit
SELECT * FROM tb_descontositens
SELECT * FROM tb_valores
SELECT * FROM tb_oportunidadepagamentos
SELECT * FROM tb_pessoassophia

INSERT tb_pessoassophia (idpessoa, codigo)
VALUES(1027227, 26332)

26332

SELECT * FROM tb_pessoas where despessoa = 'Julio Maluf Crm'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE NOME LIKE '%Julio Maluf Crm%'

SELECT  * FRom tb_oportunidades a
INNER JOIN tb_oportunidadepagamentos b ON b.idoportunidade = a.idoportunidade
where a.idoportunidadepai = 564
ORDER BY a.dtcadastro desc

INSERT INTO tb_documentos (iddocumentotipo, idpessoa, desdocumento)
VALUES(1, 1021843, '34784785884'),(5, 1021843, '467147206')

SELECT * FROM tb_produtotipos 

SELE