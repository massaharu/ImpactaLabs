SELECT * FROM tb_usuario_alterados where IdUsuario = 508

SELECT * FROm Vendas..tb_descontositemtipos
SELECT * FROm Vendas..tb_descontositens

SELECT * FROm Vendas..tb_descontositens
SELECT * FROM SONATA.SOPHIA.SOPHIA.NATUREZA_DESC
SELECT * FROM SONATA.SOPHIA.SOPHIA.jurIDICA

SELECT * FROM tb_produtos_sophiacursos
SELECT * FROM tb_descontos
SELECT * FROM tb_tipoacademicos
SELECT * FROM tb_oportunidadefit
SELECT * FROM tb_transferidofaculdade
SELECT * FROM tb_descontos
SELECT * FROm tb_descontostipos 
SELECT * FROM tb_descontositens where iddesconto = 27
SELECT * FROm tb_descontositemtipos
SELECT * FROM tb_descontos_produtos
SELECT * FROM tb_descontos_tipoacademicos
SELECT * FROM tb_oportunidadefit_descontos
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS where nome like '%Marketing%Digital%'
SELECT * FROM tb_produtos_sophiacursos WHERE produto = 71
SELECT * FROM tb_naturezadescontos
SELECT * FROM tb_produtos where idproduto
SELECT * FROM tb_descontoscampanhasfit  where iddesconto = 22
SELECT * FROM tb_descontosbolsasfit

select * from tb_oportunidadepagamentos where idoportunidade = 567

SELECT * FROM tb_descontositens


DELETE tb_descontositens
WHERE iddescontoitem NOT IN(
	SELECT MIN(iddescontoitem) as iddescontoitem FROM tb_descontositens
	GROUP BY iddesconto, iditemtipo, nrdia, nrporc,inutil
)

--INSERT INTO tb_produtos(idprodutotipo, desproduto)
--VALUES
--(16, 'Sistema de Informação - Manhã'),
--(16, 'Análise e Desenvolvimento de Sistemas - Manhã'),
--(16, 'Redes de Computadores - Manhã'),
--(16, 'Mecatrônica - Manhã'),
--(16, 'Telecomunicações - Manhã')

--INSERT INTO tb_naturezadescontos (desnaturezadesconto, nrordem, nrvalidadetipo, invisivel)
--VALUES
--('Outros',	8,	2,	1),
--('Filho de funcionário',	1,	2,	0),
--('Filho de professor',	2,	2,	0),
--('PROUNI',	3,	0,	1),
--('Financiamento',	4,	0,	1),
--('Desconto Coletivo',	5,	0,	0),
--('Bolsa / estágio acadêmico',	6,	2,	0),
--('Bolsa Diversa',	7,	2,	0)


--INSERT Vendas..tb_descontostipos (desdescontotipo)
--VALUES('Bolsa'),('Campanha Interna'),('Empresa Conveniada'),('Desconto')

--insert  Vendas..tb_descontositemtipos(destipoitem)
--values('Matrícula'), ('Mensalidade');

--INSERT tb_descontos (iddescontotipo, desdesconto)
--VALUES(2, 'WTC MBA Marketing Digital - 30%')

--INSERT tb_descontoscampanhasfit (iddesconto, dtinicio, dttermino, desobservacao, nrparcelas)
--VALUES(1, '2014-08-11', '2014-12-30', 'Observação Teste', 24)

--INSERT tb_descontositens (iddesconto, iditemtipo, nrdia, nrporc, inutil)
--VALUES
--(1, 2, 1, 40, 1),
--(1, 2, 5, 30, 0),
--(1, 2, 10, 20, 0)

--INSERT tb_descontos_produtos
--VALUEs (1, 71)


--INSERT Vendas..tb_descontostipos (desdescontotipo)
--VALUES('Bolsa'),('Campanha Interna'),('Empresa Conveniada'),('Desconto')

--insert  Vendas..tb_descontositemtipos(destipoitem)
--values('Matrícula'), ('Mensalidade');

--INSERT tb_descontos (iddescontotipo, desdesconto)
--VALUES(2, 'WTC MBA Marketing Digital - 30%')

--INSERT tb_descontoscampanhasfit (iddesconto, dtinicio, dttermino, desobservacao, nrparcelas)
--VALUES(1, '2014-08-11', '2014-12-30', 'Observação Teste', 24)

--INSERT tb_descontositens (iddesconto, iditemtipo, nrdia, nrporc, inutil)
--VALUES
--(1, 2, 1, 40, 1),
--(1, 2, 5, 30, 0),
--(1, 2, 10, 20, 0)

--INSERT tb_descontos_produtos
--VALUEs (1, 1003677)

--DELETE FROM tb_oportunidadesfitdescontos
--DELETE FROM tb_descontos
--DELETE FROM tb_descontos_produtos
--DELETE FROM tb_descontositens
--DELETE FROM tb_descontoscampanhasfit
--DELETE FROM tb_descontosbolsasfit
--DELETE FROM tb_descontos
--------------------------------------------------------------
SELECT * FROM  tb_descontos
UPDATE tb_descontos
SET incartadesconto = 0

ALTER TABLE tb_descontos
ADD incartadesconto bit CONSTRAINT DF_descontos_incartadesconto DEFAULT(0)

SELECT * FROM tb_oportunidadesfit
SELECT * FROM tb_oportunidadesfitdescontos 
--------------------------------------------------------------
UPDATE tb_oportunidadesfitdescontos
SET incartadescontoapresentado = 0

ALTER TABLE tb_oportunidadesfitdescontos
ADD incartadescontoapresentado bit CONSTRAINT DF_oportunidadesfitdescontos_incartadescontoapresentado DEFAULT(0)
--------------------------------------------------------------

SELE

SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS WHERE PRODUTO = 71
SELECT * FROM tb_produto_
SELECT * FROM tb_descontositens
SELECT * FROM tb_descontos_produtos

sp_oportunidadedescontos_list 82



/*****************************************************************/
/************* TABLE ***************************************/
/***************************************************************/
CREATE TABLE tb_naturezadescontos(
      idnaturezadesconto int identity CONSTRAINT PK_naturezadescontos PRIMARY KEY,
      desnaturezadesconto varchar(100) not null,
      nrordem smallint,
      nrvalidadetipo smallint,
      invisivel bit CONSTRAINT DF_naturezadescontos_invisivel DEFAULT 1,
    dtcadastro datetime CONSTRAINT DF_naturezadescontos_dtcadastro DEFAULT getdate()
);
--INSERT Vendas..tb_naturezadescontos (desnaturezadesconto, nrordem, nrvalidadetipo)
--SELECT descricao, ORDEM, tipovalidade FROM SONATA.SOPHIA.SOPHIA.NATUREZA_DESC

SELECT * FROM tb_naturezadescontos
-------------------------------------------------------------------------
-------------------------------------------------------------------------

CREATE TABLE tb_naturezadescontos_natureza(
      idnaturezadesconto int,
      idcodigo int,

      CONSTRAINT PK_naturezadescontos_natureza_iddescontonatureza_idcodigo PRIMARY KEY (idnaturezadesconto, idcodigo),
      CONSTRAINT FK_naturezadescontos_natureza_naturezadescontos_idnaturezadesconto FOREIGN KEY(idnaturezadesconto)
      REFERENCES tb_naturezadescontos(idnaturezadesconto)
)

--INSERT tb_naturezadescontos_natureza
--SELECT a.idnaturezadesconto, b.CODIGO FROM tb_naturezadescontos a
--INNER JOIN SONATA.SOPHIA.SOPHIA.NATUREZA_DESC b ON b.DESCRICAO COLLATE Latin1_General_CI_AI = a.desnaturezadesconto

SELECT * FROM tb_naturezadescontos_natureza
DELETE tb_naturezadescontos
-------------------------------------------------------------------------
-------------------------------------------------------------------------
CREATE TABLE tb_pessoas_sophiaempresas(
      idpessoa int,
      idcodigo int,

      CONSTRAINT FK_pessoas_sophiaempresas_idpessoa_idcodigo PRIMARY KEY (idpessoa, idcodigo),
      CONSTRAINT FK_pessoas_sophiaempresas_pessoas_idpessoa FOREIGN KEY (idpessoa)
      REFERENCES tb_pessoas (idpessoa)
);

SELECT * FROM tb_pessoas_sophiaempresas
-------------------------------------------------------------------------
-------------------------------------------------------------------------
CREATE TABLE tb_descontosbolsasfit(
	iddescontobolsafit int IDENTITY CONSTRAINT PK_descontosbolsasfit PRiMARY KEY,
	iddesconto int,
	idpessoa int,
	nrporc tinyint,
	inmensalidade bit,
	inmatricula bit,
	ingerardebito bit,
	
	CONSTRAINT FK_descontosbolsasfit_descontos_iddesconto FOREIGN KEY(iddesconto)
	REFERENCES tb_descontos (iddesconto),
	CONSTRAINT FK_descontosbolsasfit_pessoas_idpessoa FOREIGN KEY(idpessoa)
	REFERENCES tb_pessoas (idpessoa)
)
SELECt * FROM tb_descontosbolsasfit
--DELETE tb_descontosbolsasfit
-------------------------------------------------------------------------
-------------------------------------------------------------------------
CREATE TABLE tb_descontosbolsasfit(
      iddescontobolsafit int IDENTITY CONSTRAINT PK_descontosbolsasfit PRIMARY KEY,
      iddesconto int,
      idpessoa int,
      idnaturezadesconto int,
      nrporc tinyint,
      inmensalidade bit,
      inmatricula bit,
      ingerardebito bit,
      
      CONSTRAINT FK_descontosbolsasfit_descontos_iddesconto FOREIGN KEY(iddesconto)
      REFERENCES tb_descontos (iddesconto),
      CONSTRAINT FK_descontosbolsasfit_pessoas_idpessoa FOREIGN KEY(idpessoa)
      REFERENCES tb_pessoas (idpessoa),
      CONSTRAINT FK_descontosbolsasfit_naturezadescontos_idnaturezadesconto FOREIGN KEY(idnaturezadesconto)
      REFERENCES tb_naturezadescontos(idnaturezadesconto)
)
/*****************************************************************/
/************* PROCEDURES ***************************************/
/***************************************************************/
ALTER PROC [dbo].[sp_produtos_sophiacursos_list]
(
	@idprodutotipo int = NULL, 
	@iddesconto int = NULL, 
	@idsprodutos varchar(200) = NULL
)
AS
/*
  app:CRM
  url:/simpacweb/modulos/fit/financeiro/admDescontos/actions/json/produtos_sophiacursos_list.php
  author: Massaharu
  date: 1/10/2013
*/
BEGIN
	IF @iddesconto IS NULL
	BEGIN
		IF @idprodutotipo IS NULL
		BEGIN
			SELECT  
				a.idproduto,
				a.idprodutotipo,
				a.desproduto,
				a.instatus,
				a.dtcadastro,
				a.idimagem,
				a.nrestoque,
				a.dtvalidade,
				a.nrparcelas,
				d.desprodutotipo
			FROM tb_produtos a
			INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
			INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
			WHERE a.instatus = 1
			ORDER BY d.desprodutotipo, a.desproduto
		END
		ELSE
		BEGIN
			SELECT  
				a.idproduto,
				a.idprodutotipo,
				a.desproduto,
				a.instatus,
				a.dtcadastro,
				a.idimagem,
				a.nrestoque,
				a.dtvalidade,
				a.nrparcelas,
				d.desprodutotipo
			FROM tb_produtos a
			INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
			INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
			WHERE 
				d.idprodutotipo = @idprodutotipo AND a.instatus = 1 AND a.idproduto NOT IN(
					SELECT id FROM Simpac.dbo.fnSplit(@idsprodutos, ',')
				)
			ORDER BY d.desprodutotipo, a.desproduto
		END
	END
	ELSE
	BEGIN
		IF @idprodutotipo IS NULL
		BEGIN
			SELECT  
				a.idproduto,
				a.idprodutotipo,
				a.desproduto,
				a.instatus,
				a.dtcadastro,
				a.idimagem,
				a.nrestoque,
				a.dtvalidade,
				a.nrparcelas,
				d.desprodutotipo
			FROM tb_produtos a
			INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
			INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
			WHERE a.instatus = 1 AND a.idproduto NOT IN(
				SELECT c.idproduto FROM tb_descontos a
				INNER JOIN tb_descontos_produtos b ON b.iddesconto = a.iddesconto
				INNER JOIN tb_produtos c ON c.idproduto = b.idproduto
				WHERE a.iddesconto = @iddesconto
			)
			ORDER BY d.desprodutotipo, a.desproduto
		END
		ELSE
		BEGIN
			SELECT  
				a.idproduto,
				a.idprodutotipo,
				a.desproduto,
				a.instatus,
				a.dtcadastro,
				a.idimagem,
				a.nrestoque,
				a.dtvalidade,
				a.nrparcelas,
				d.desprodutotipo
			FROM tb_produtos a
			INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
			INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
			WHERE d.idprodutotipo = @idprodutotipo AND a.instatus = 1 AND a.idproduto NOT IN(
				SELECT c.idproduto FROM tb_descontos a
				INNER JOIN tb_descontos_produtos b ON b.iddesconto = a.iddesconto
				INNER JOIN tb_produtos c ON c.idproduto = b.idproduto
				WHERE a.iddesconto = @iddesconto
			)  AND a.idproduto NOT IN(
				SELECT id FROM Simpac.dbo.fnSplit(@idsprodutos, ',')
			)
			ORDER BY d.desprodutotipo, a.desproduto
		END
	END
END
--
sp_produtos_sophiacursos_list NULL, 30





--------------------------------------------------------
ALTEr PROC sp_desconto_produtos_list
(@iddesconto int)
AS
BEGIN
	SELECT  
		a.idproduto,
		a.idprodutotipo,
		a.desproduto,
		a.instatus,
		a.dtcadastro,
		a.idimagem,
		a.nrestoque,
		a.dtvalidade,
		a.nrparcelas,
		d.desprodutotipo
	FROM tb_produtos a
	INNER JOIN tb_produtos_sophiacursos b ON b.idproduto = a.idproduto
	INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS c ON c.PRODUTO = b.produto
	INNER JOIN tb_produtotipos d ON d.idprodutotipo = a.idprodutotipo
	INNER JOIN tb_descontos_produtos e ON e.idproduto = a.idproduto 
	INNER JOIN tb_descontos f ON f.iddesconto = e.iddesconto
	WHERE a.instatus = 1 AND f.iddesconto = @iddesconto
	ORDER BY d.desprodutotipo, a.desproduto
END
--
SELECT * FROM tb_descontos_produtos
SELECT * FROM tb_produtos_sophiacursos

sp_desconto_produtos_list 32
--------------------------------------------------------
CREATE PROC sp_descontostipos_list
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Lista todos os tipos de descontos da FIT
*/
BEGIN
	SELECT iddescontotipo, desdescontotipo, instatus, dtcadastro
	FROM tb_descontostipos
	WHERE instatus = 1
	ORDER BY desdescontotipo
END
--------------------------------------------------------
CREATE PROC sp_descontositemtipos_list
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Lista todos os tipos de itens de descontos da FIT
*/
BEGIN
	SELECT iddescontoitemtipo, destipoitem, instatus, dtcadastro
	FROM tb_descontositemtipos
	WHERE instatus = 1
	ORDER BY destipoitem
END

sp_descontositemtipos_list
--------------------------------------------------------
ALTER PROC sp_pessoasjuridicasall_list
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Lista todos as pessoas juridicas
*/
BEGIN
	SELECT 
		a.idpessoa, a.idpessoatipo, a.despessoa, a.dtcadastro, a.idproprietario, 
		a.idpessoaimportancia, a.indeletado, a.idimagem, a.desresumo 
	FROM tb_pessoas a
	inner join tb_pessoaimportancias c on a.idpessoaimportancia = c.idpessoaimportancia
	inner join simpac.dbo.tb_usuario d on a.idproprietario = d.IdUsuario
	left join tb_pessoafavoritas e on a.idpessoa = e.idpessoa and a.idproprietario = e.idusuario
	left join tb_arquivos f on f.idarquivo = a.idimagem
	where 
		a.indeletado = 0 AND
		a.idpessoatipo = 2
	ORDER BY a.despessoa
END
--
SELECT * FROM tb_pessoatipos
SELECT * FROM tb_pessoaimportancias
SELECT * FROM tb_pessoafavoritas
SELECT * FROM tb_arquivos
SELECT * FROM tb_descontofit
--------------------------------------------------------
CREATE PROC sp_naturezasdescontos_list
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Lista todas as naturezas do desconto
*/
BEGIN
	SELECT a.idnaturezadesconto, a.desnaturezadesconto, a.nrordem, a.nrvalidadetipo, a.invisivel, a.dtcadastro
	FROM tb_naturezadescontos a
	INNER JOIN tb_naturezadescontos_natureza b ON b.idnaturezadesconto = a.idnaturezadesconto
	--INNER JOIN SOPHIA.NATUREZA_DESC c ON c.CODIGO = b.idcodigo
	INNER JOIN SONATA.SOPHIA.SOPHIA.NATUREZA_DESC c ON c.CODIGO = b.idcodigo
	WHERE a.invisivel = 1
	ORDER BY a.nrordem, a.desnaturezadesconto
END
--
SELECT * FROM tb_naturezadescontos_natureza
SELECT * FROM tb_naturezadescontos

SELECT * FROM tb_descontos
--------------------------------------------------------
CREATE PROC sp_descontofit_get 
(@iddesconto int)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/10/2014
  desc: retorna um descontofit pelo id
*/
BEGIN
	SELECT
		iddesconto, iddescontotipo, desdesconto, instatus, dtcadastro, incartadesconto
	FROM tb_descontos
	WHERE iddesconto = @iddesconto
END
--
SELECT * FROM tb_descontos
sp_descontofit_get 1
--------------------------------------------------------
ALTER PROC sp_descontofit_list
(@iddescontotipo int = null)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/10/2014
  desc: lista de descontofit (opcional por tipo)
*/
BEGIN 
	IF @iddescontotipo IS NOT NULL
		SELECT 
			a.iddesconto, a.iddescontotipo, a.desdesconto, b.desdescontotipo, a.instatus, a.dtcadastro, a.incartadesconto
		FROM tb_descontos a
		INNER JOIN tb_descontostipos b ON b.iddescontotipo = a.iddescontotipo
		WHERE a.iddescontotipo = @iddescontotipo
		ORDER BY a.desdesconto
	ELSE
		SELECT 
			a.iddesconto, a.iddescontotipo, a.desdesconto, b.desdescontotipo, a.instatus, a.dtcadastro, a.incartadesconto
		FROM tb_descontos a
		INNER JOIN tb_descontostipos b ON b.iddescontotipo = a.iddescontotipo
		ORDER BY a.desdesconto
END
--
SELECT * FROM tb_descontos
SELECT * FROM tb_descontostipos
--------------------------------------------------------
ALTER PROC sp_descontofit_save
(
	@iddesconto int,
	@iddescontotipo int,
	@desdesconto varchar(100),
	@instatus bit,
	@incartadesconto bit
)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Salva e altera a tabela de descontos da fit
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT iddesconto FROM tb_descontos WHERE iddesconto = @iddesconto
	)
	BEGIN
		UPDATE tb_descontos
		SET 
			iddescontotipo = @iddescontotipo,
			desdesconto = @desdesconto,
			instatus = @instatus,
			incartadesconto = @incartadesconto
		WHERE 
			iddesconto = @iddesconto
			
		SET NOCOUNT OFF
		
		SELECT @iddesconto as iddesconto
	END
	ELSE
	BEGIN
		INSERT INTO tb_descontos (iddescontotipo, desdesconto, instatus, incartadesconto)
		VALUES (@iddescontotipo, @desdesconto, @instatus, @incartadesconto)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as iddesconto
	END
END

SELECT * FROM tb_descontos
SELECT * FROM tb_descontositens
SELECT * FROM tb_descontosbolsasfit
SELECT * FROM tb_descontoscampanhasfit
--------------------------------------------------------
CREATE PROC sp_descontoitensfit_save
(
	@iddescontoitem int,
	@iddesconto int,
	@iditemtipo int,
	@nrdia smallint,
	@nrporc tinyint,
	@inutil bit
)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Salva e altera a tabela de itens de descontos da fit
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT iddescontoitem FROM tb_descontositens 
		WHERE iddescontoitem = @iddescontoitem
	)
	BEGIN
		UPDATE tb_descontositens
		SET
			iddesconto = @iddesconto,
			iditemtipo = @iditemtipo,
			nrdia = @nrdia,
			nrporc = @nrporc,
			inutil = @inutil
		WHERE iddescontoitem = @iddescontoitem
		
		SET NOCOUNT OFF
		
		SELECT @iddescontoitem as iddescontoitem
	END
	ELSE
	BEGIN
		INSERT INTO tb_descontositens (iddesconto, iditemtipo, nrdia, nrporc, inutil)
		VALUES(@iddesconto, @iditemtipo, @nrdia, @nrporc, @inutil)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as iddescontoitem
	END
END
--
SELECT * FROM tb_descontositens

--------------------------------------------------------
CREATE PROC sp_descontoitensfit_remove
(@iddesconto int)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: remove todos os itens do desconto
*/
BEGIN
	DELETE tb_descontositens
	WHERE iddesconto = @iddesconto
END

---------------------------------------------------
CREATE PROC sp_descontositens_list
(@iddesconto int, @iditemtipo int  = null)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/11/2014
  desc: Lista os itens de um desconto
*/
BEGIN

	IF @iditemtipo IS NULL
	BEGIN
		SELECT iddescontoitem, iddesconto, iditemtipo, nrdia, nrporc, inutil
		FROM tb_descontositens
		WHERE iddesconto = @iddesconto
	END
	ELSE
	BEGIN
		SELECT iddescontoitem, iddesconto, iditemtipo, nrdia, nrporc, inutil
		FROM tb_descontositens
		WHERE iddesconto = @iddesconto AND iditemtipo = @iditemtipo
	END
END
---------------------------------------------------
CREATE PROC sp_descontoprodutosfit_add
(
	@iddesconto int, 
	@idproduto int
)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: Adiciona produtos ao desconto
*/
BEGIN
	INSERT INTO tb_descontos_produtos VALUES(@iddesconto, @idproduto)
END

SELECT * FROM tb_descontos_produtos
SELECT * FROM tb_descontos
---------------------------------------------------------------------------------
CREATE PROC sp_descontoprodutosfit_remove
(@iddesconto int)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: remove TODOS os produtos daquele desconto
*/
BEGIN
	DELETE tb_descontos_produtos
	WHERE iddesconto = @iddesconto
END
---------------------------------------------------------------------------------
CREATE PROC sp_descontofitbolsa_get
(@iddesconto int)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: busca a bolsa pertencente ao desconto (relação 1 para 1)
*/
BEGIN
	SELECT 
		iddescontobolsafit, iddesconto, idpessoa, idnaturezadesconto, nrporc, inmensalidade, inmatricula, ingerardebito
	FROM tb_descontosbolsasfit
	WHERE iddesconto = @iddesconto
END
--
sp_descontofitbolsa_get 33
---------------------------------------------------------------------------------
CREATE PROC sp_descontofitbolsa_save
(
	@iddescontobolsafit int, 
	@iddesconto int, 
	@idpessoa int, 
	@idnaturezadesconto int,  
	@ingerardebito bit,
	@inmatricula bit, 
	@inmensalidade bit, 
	@nrporc smallint
)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: salva e altera os descontos da bolsa [FIT]
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT iddesconto FROM tb_descontosbolsasfit
		WHERE iddesconto = @iddesconto AND iddescontobolsafit = @iddescontobolsafit
	)
	BEGIN
		UPDATE tb_descontosbolsasfit
		SET
			idpessoa = @idpessoa, 
			idnaturezadesconto = @idnaturezadesconto, 
			nrporc = @nrporc, 
			inmensalidade = @inmensalidade, 
			inmatricula = @inmatricula, 
			ingerardebito = @ingerardebito 
		WHERE	
			iddesconto = @iddesconto AND iddescontobolsafit = @iddescontobolsafit
			
		SET NOCOUNT OFF
		
		SELECT @iddesconto as iddesconto, @iddescontobolsafit as iddescontobolsafit
	END
	ELSE
	BEGIN
		INSERT INTO tb_descontosbolsasfit 
		(
			idpessoa, 
			iddesconto,
			idnaturezadesconto, 
			nrporc, 
			inmensalidade, 
			inmatricula, 
			ingerardebito
		)VALUES(
			@idpessoa, 
			@iddesconto,
			@idnaturezadesconto, 
			@nrporc, 
			@inmensalidade, 
			@inmatricula, 
			@ingerardebito
		)
		
		SET NOCOUNT OFF
		
		SELECT @iddesconto as iddesconto, SCOPE_IDENTITY() as iddescontobolsafit 
	END	
END
---------------------------------------------------------------------------------
CREATE PROC sp_descontoscampanhasfit_get
(@iddesconto int)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: busca a campanha de desconto pertencente ao descono (relação 1 para 1)
*/
BEGIN
	SELECT 
		iddescontocampanhafit, iddesconto, dtinicio, dttermino, desobservacao, nrparcelas, instatus, dtcadastro
	FROM tb_descontoscampanhasfit
	WHERE iddesconto = @iddesconto
END
---------------------------------------------------------------------------------
CREATE PROC sp_descontoscampanhasfit_save
(
	@iddescontocampanhafit int,
	@iddesconto int,
	@dtinicio datetime,
	@dttermino datetime,
	@desobservacao varchar(1000),
	@nrparcelas int
)
AS
/*
  app:SimpacWeb
  url:/simpacweb/class/class.descontoFit.php
  author: Massaharu
  date: 01/09/2014
  desc: salva e altera os descontos da campanha [FIT]
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT iddesconto FROM tb_descontoscampanhasfit
		WHERE iddesconto = @iddesconto AND iddescontocampanhafit = @iddescontocampanhafit
	)
	BEGIN
		
		UPDATE tb_descontoscampanhasfit
		SET
			dtinicio = @dtinicio,
			dttermino = @dttermino,
			desobservacao = @desobservacao,
			nrparcelas = @nrparcelas
		WHERE iddesconto = @iddesconto AND iddescontocampanhafit = @iddescontocampanhafit
		
		SET NOCOUNT OFF
		
		SELECT @iddesconto as iddesconto, @iddescontocampanhafit as iddescontocampanhafit
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_descontoscampanhasfit (
			iddesconto,
			dtinicio,
			dttermino,
			desobservacao,
			nrparcelas
		)VALUES(
			@iddesconto,
			@dtinicio,
			@dttermino,
			@desobservacao,
			@nrparcelas
		)
		
		SET NOCOUNT OFF
		
		SELECT @iddesconto as iddesconto, SCOPE_IDENTITY() as iddescontocampanhafit
	END
END
---------------------------------------------------------------------------------
CREATE PROC sp_desconto_change_instatus
(@iddesconto int, @instatus int)
AS
BEGIN
	IF(SELECT instatus FROM tb_descontos WHERE iddesconto = @iddesconto)
END
---------------------------------------------------------------------------------
---------------------------------------------------------------------------------
SELECT * FROM tb_descontos
SELECT * FROM tb_descontositens where iddesconto = 11
SELECt * FROM tb_descontos_produtos
SELECt * FROM tb_descontos_produtos
SELECt * FROM tb_descontoscampanhasfit
SELECT * FROM tb_naturezadescontos
SELECT * FROM tb_pessoas where idpessoa = 1022670
sp_descontositensbydesconto_list 23

SELECT * FROM tb_oportunidadeetapatipos


SELECT NOME, CPF, CONVERT(VARCHAR(24),DATANASC,103) as DATA_NASC 
FROM SONATA.SOPHIA.SOPHIA.FISICA 
WHERE CPF IS NOT NULL AND DATANASC IS NOT NULL AND CODEXT IS NULL AND Simpac.dbo.fn_ValidaCpfCnpj(CPF) = 1
GRoUP by CODIGO, NOME, CPF, DATANASC
HAVING COUNT(*) = 1
ORDER BY CODIGO 

Select * from SONATA.SOPHIA.SOPHIA.FISICA 

