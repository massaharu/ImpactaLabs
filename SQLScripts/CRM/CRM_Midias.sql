------------------------------------------------------------------
---------------------- MIDIAS ------------------------------------
----------------------------------------------------------------------
/******************************************************************/
/*****************************************************************/
/********************* TABELAS **********************************/
/***************************************************************/
/**************************************************************/
CREATE TABLE tb_midiatipos(
	idmidiatipo	int not null identity CONSTRAINT PK_tb_midiatipos PRIMARY KEY(idmidiatipo),
	desmidiatipo	varchar(50) not null,
	instatus	bit CONSTRAINT DF_midiatipos_instatus DEFAULT(1),
	dtcadastro	datetime CONSTRAINT DF_midiatipos_dtcadastro DEFAULT(getdate())
)
CREATE TABLE tb_midias(
	idmidia int not null IDENTITY,
	idmidiatipo int not null,
	desmidia varchar(50),
	instatus	bit CONSTRAINT DF_tb_midias_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_tb_midias_dtcadastro DEFAULT(getdate())
	CONSTRAINT PK_midias_idmidia_idmidiatipo PRIMARY KEY(idmidia, idmidiatipo)
	CONSTRAINT FK_midias_midiatipos_idmidiatipo FOREIGN KEY (idmidiatipo)
	REFERENCES tb_midiatipos(idmidiatipo) ON DELETE CASCADE
)
CREATE TABLE tb_midiapessoas(
	idmidia int not null,
	idmidiatipo int not null,
	idpessoa int not null,
	dtcadastro	datetime CONSTRAINT DF_midiapessoas_dtcadastro DEFAULT(getdate())
	CONSTRAINT PK_midiapessoas_idmidia_idmidiatipo_idpessoa PRIMARY KEY(idmidia, idmidiatipo, idpessoa)	
	CONSTRAINT FK_midiapessoas_pessoas_idpessoa FOREIGN KEY(idpessoa)
	REFERENCES tb_pessoas(idpessoa)
)-- !Deve-se utilizar o ALTER TABLE para referenciar uma chave estrangeira composta
ALTER TABLE tb_midiapessoas ADD
CONSTRAINT FK_midiapessoas_midias_idmidia_idmidiatipo FOREIGN KEY(idmidia, idmidiatipo)
REFERENCES tb_midias(idmidia, idmidiatipo)
/******************************************************************/
/*****************************************************************/
/********************* INSERTS **********************************/
/***************************************************************/
/**************************************************************/

INSERT INTO tb_midiatipos (desmidiatipo)
VALUES ('E-mail'),('Eventos'),('Folheto'),('Indicação'),('Internet'),('Jornal'),('Revista'),
('Rádio'),('Tv'),('Outros'), ('Metrô'), ('ônibus')

INSERT INTO tb_midias (idmidiatipo, desmidia)
VALUES (1,'E-mail'),(2,'Eventos'),(3,'Folheto'),
(4,'Ex-Alunos'),(4,'Funcionários'),(4,'Indicação de Amigos'),(5,'APADI'),(5,'Apóes'),
(5,'ASSESPRO'),(5,'Blog da Impacta'),(5,'Ceviu'),(5,'Clima Tempo0'),(5,'Facebook'),
(5,'Google'),(5,'House Games'),(5,'IAB'),(5,'iMasters'),(5,'Linux Media'),
(5,'Outros'),(5,'Twitter'),(5,'Voit'),(6,'Folha de São Paulo'),(6,'Propaganda e Marketing'),
(7,'Aclimação'),(7,'Chácara Klabim'),(7,'Computer Arts'),(7,'Escola Particular'),
(7,'Java Magazine'),(7,'Outros'),(7,'Mac Mais'),(7,'Linux Magazine'),(7,'IT Forum'),
(8,'Metropolitana'),(9,'Canal TB Aberta'),(9,'Gazeta'),(10,'Outros'),(10,'Clientes Cadastrados'),
(11,'Painel'),(11,'TV MInuto')


SELECT *FROM Atendimento.dbo.tb_Midia2009
SELECT *FROM tb_midias
SELECT *FROM tb_midiatipos
SELECT *FROM tb_midiapessoas
/******************************************************************/
/*****************************************************************/
/********************* PROCEDURES *******************************/
/***************************************************************/
/**************************************************************/
---------------------------------------------------------------
------------------- MIDIASTIPOS -------------------------------
-------------------------------------------------------------
------------midiatipos_get------------------------------------
CREATE PROC sp_midiatipos_save
(@idmidiatipo int, @desmidiatipo varchar(50))
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	IF(@idmidiatipo <> 0)
		BEGIN
			UPDATE tb_midiatipos
			SET desmidiatipo = @desmidiatipo
			WHERE idmidiatipo = @idmidiatipo
			
			SET NOCOUNT OFF
			
			SELECT @idmidiatipo as idmidiatipo
		END
	ELSE
		BEGIN
			INSERT INTO tb_midiatipos (desmidiatipo)
			VALUES(@desmidiatipo)
			
			SET NOCOUNT OFF
			
			SELECT SCOPE_IDENTITY() AS idmidiatipo
		
		END
END
-------------------------------------------------------------
------------midiatipos_get------------------------------------
ALTER PROC sp_midiatipos_get
(@idmidiatipo int)
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT idmidiatipo, desmidiatipo, instatus, dtcadastro FROM tb_midiatipos
	WHERE idmidiatipo = @idmidiatipo
END

sp_midiatipos_get 2
------------------------------------------------------------------
----------------------midiatipos_list---------------------------------
ALTER PROC sp_midiatipos_list
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT idmidiatipo, desmidiatipo, instatus, dtcadastro FROM tb_midiatipos
END

sp_midiatipos_list
------------------------------------------------------------------
----------------------midiatiposbyinstatus_list-------------------
CREATE PROC sp_midiatiposbyinstatus_list
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT idmidiatipo, desmidiatipo, instatus, dtcadastro FROM tb_midiatipos
	WHERE instatus = 1
END

sp_midiatiposbyinstatus_list
--------------------------------------------------------------------------------
----------------------midiatipos_delete-----------------------------------------
------(Desabilita e Habilita (toggle) o status(instatus) de um tipo de midia)---
ALTER PROC sp_midiatipos_delete
(@idmidiatipo int)
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	
	IF((SELECT instatus FROM tb_midiatipos WHERE idmidiatipo = @idmidiatipo) = 1)
		BEGIN
			UPDATE tb_midiatipos
			SET instatus = 0
			WHERE idmidiatipo = @idmidiatipo
		END
	ELSE
		BEGIN
			UPDATE tb_midiatipos
			SET instatus = 1
			WHERE idmidiatipo = @idmidiatipo
		END
END

sp_midiatipos_delete 2
---------------------------------------------------------------
------------------- MIDIAS -----------------------------------
-------------------------------------------------------------
------------------midias_save--------------------------------
-------------------------------------------------------------
CREATE PROC sp_midias_save
(@idmidiatipo int, @idmidia int, @desmidia varchar(50))
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SET NOCOUNT ON
	IF(@idmidia <> 0)
		BEGIN
			UPDATE tb_midias
			SET desmidia = @desmidia
			WHERE idmidiatipo = @idmidiatipo AND
				  idmidia = @idmidia
			
			SET NOCOUNT OFF
			
			SELECT @idmidia as idmidia
		END
	ELSE
		BEGIN
			INSERT INTO tb_midias (idmidiatipo, desmidia)
			VALUES(@idmidiatipo, @desmidia)
			
			SET NOCOUNT OFF
			
			SELECT SCOPE_IDENTITY() AS idmidia
		
		END
END

-------------------------------------------------------------
------------------midias_list--------------------------------
ALTER PROC sp_midias_list
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT idmidia, idmidiatipo, desmidia, instatus, dtcadastro FROM tb_midias
END
-----------------------------------------------------------------------
------------------midiasbyinstatus_list--------------------------------
CREATE PROC sp_midiasbyinstatus_list
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT idmidia, idmidiatipo, desmidia, instatus, dtcadastro FROM tb_midias
	WHERE instatus = 1
END
-------------------------------------------------------------
----------midiasbytipo_list----------------------------------------
ALTER PROC sp_midiasbytipo_list
(@idmidiatipo int)
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	SELECT b.idmidia, a.idmidiatipo, a.desmidiatipo, a.instatus as inmediatipo, a.dtcadastro as midiatipocadastro,
	b.desmidia, b.instatus as inmidia, b.dtcadastro as midiacadastro
	FROM tb_midiatipos a
	LEFT JOIN tb_midias b
	ON b.idmidiatipo = a.idmidiatipo
	WHERE a.idmidiatipo = @idmidiatipo AND
	a.instatus = 1 AND b.instatus = 1
END

sp_midiasbytipo_list 3
--------------------------------------------------------------------------------
----------------------midia_delete-----------------------------------------
------(Desabilita e Habilita (toggle) o status(instatus) de um tipo de midia)---
CREATE PROC sp_midias_delete
(@idmidia int)
AS
/*
app: CRM
url: /CRM/inc/class/objects/midia.class.php
data: 2012-12-06
author: Massa
*/
BEGIN
	
	IF((SELECT instatus FROM tb_midias WHERE idmidia = @idmidia) = 1)
		BEGIN
			UPDATE tb_midias
			SET instatus = 0
			WHERE idmidia = @idmidia
		END
	ELSE
		BEGIN
			UPDATE tb_midias
			SET instatus = 1
			WHERE idmidia = @idmidia
		END
END
--------------------------------------------------------------------
--------------------------------------------------------------------
SELECT b.idmidia, a.idmidiatipo, a.desmidiatipo, a.instatus as inmediatipo, a.dtcadastro as midiatipocadastro,
b.desmidia, b.instatus as inmidia, b.dtcadastro as midiacadastro
FROM tb_midiatipos a
LEFT JOIN tb_midias b
ON b.idmidiatipo = a.idmidiatipo

SELECT *FROM tb_pessoas
---------------------------------------------------------------
------------------- MIDIAS-PESSOAS-----------------------------
---------------------------------------------------------------
------------midiaspessoas_save---------------------------------
ALTER PROC sp_midiaspessoas_save
(@idmidia int, @idmidiatipo int, @idpessoa int)
AS
/*
app: SimpacCRM
url: /CRM/inc/class/objects/pessoa.class.php
data: 2012-12-07 
author: Massa
*/
BEGIN
	DELETE tb_midiapessoas WHERE idpessoa = @idpessoa
	INSERT INTO tb_midiapessoas(idmidia, idmidiatipo, idpessoa)VALUES(@idmidia, @idmidiatipo, @idpessoa)
END
---------------------------------------------------------------
------------pessoasmidia_get-----------------------------------
------(Procedure usada para carregar a combo na página)--------
ALTER PROC sp_pessoasmidias_get
(@idpessoa int)
/*
app: SimpacCRM
url: /CRM/inc/class/objects/pessoa.class.php
data: 2012-12-07 
author: Massa
*/
AS
BEGIN
	SELECT idmidia, idmidiatipo, idpessoa FROM tb_midiapessoas
	WHERE idpessoa = @idpessoa
END

sp_pessoasmidias_get 227
------------------------------------------------------------------------
------------------------------------------------------------------------


