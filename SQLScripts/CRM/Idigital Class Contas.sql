
-------------------------------------------------------------------------
-------------------------- TABELAS --------------------------------------
-------------------------------------------------------------------------
USE VENDAS
GO
CREATE TABLE tb_pessoasidigitalclasscontas(
	idpessoa int CONSTRAINT PK_pessoasidigitalclasscontas_idpessoa PRIMARY KEY,
	idatendente int,
	dessenha varchar(50) not null,
	dtiniciovalidade datetime,
	dtterminovalidade datetime,
	instatus int CONSTRAINT DF_pessoasidigitalclasscontas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_pessoasidigitalclasscontas_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_pessoasidigitalclasscontas_idpessoa FOREIGN KEY (idpessoa)
	REFERENCES tb_pessoas(idpessoa),
	CONSTRAINT FK_pessoasidigitalclasscontas_idatendente FOREIGN KEY(idatendente)
	REFERENCES tb_pessoas(idpessoa)
) 

USE VENDAS
ALTER TABLE tb_pessoasidigitalclasscontas ADD idperfilacesso int 

USE VENDAS
ALTER TABLE tb_pessoasidigitalclasscontas ADD idempresa int 

SELECT * FROM vendas..tb_pessoasidigitalclasscontas
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_perfilacessos(
	idperfilacesso int IDENTITY CONSTRAINT PK_perfilacessos PRIMARY KEY,
	desperfilacesso VARCHAR(100) NOT NULL,
	deslinkdefault varchar(200),
	instatus bit CONSTRAINT DF_perfilacessos_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_perfilacessos_dtcadastro DEFAULT getdate()
)

USE IDIGITALCLASS
GO
INSERT INTO tb_perfilacessos
(desperfilacesso)
VALUES
('Candidato'),
('Administrador Geral'),
('Administrador'),
('Professor'),
('Aluno'),
('Monitor')

SELECT * FROM tb_perfilacessos

-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_menus(
	idmenu int IDENTITY CONSTRAINT PK_menus PRIMARY KEY,
	idmenupai int,
	desmenu varchar(200),
	deslink varchar(200),
	instatus bit CONSTRAINT DF_menus_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_menus_dtcadastro DEFAULT getdate()	
)

INSERT INTO tb_menus 
(idmenupai, desmenu, deslink)
VALUES
(1, 'Empresas', 'empresas.php'),
(9, 'Aulas Gravadas', 'aulas-gravadas.php'),
--(0, 'Consultas', ''),
--(0, 'Cadastros', ''),
(1, 'Períodos de Curso', 'periodo-de-curso.php'),
(1, 'Disciplinas', 'disciplinas.php'),
(1, 'Cursos', 'cursos.php'),
(1, 'Turmas', 'turmas.php'),
(1, 'Programas de Aula', 'programas-de-aula.php'),
(1, 'Salas', 'salas.php'),
(1, 'Usuários', 'usuarios.php')

SELECT * FROM tb_menus
-------------------------------------------------------------------------
CREATE TABLE tb_perfilacessosmenus(
	idperfilacesso int,
	idmenu int
	
	CONSTRAINT PK_perfilacessosmenus_idperfilacesso_idmenu PRIMARY KEY(idperfilacesso, idmenu),
	CONSTRAINT FK_perfilacessosmenus_perfilacessos_idperfilacesso FOREIGN KEY(idperfilacesso)
	REFERENCES tb_perfilacessos(idperfilacesso) ON DELETE CASCADE,
	CONSTRAINT FK_perfilacessosmenus_menus_idmenu FOREIGN KEY(idmenu)
	REFERENCES tb_menus (idmenu) ON DELETE CASCADE
)


INSERT INTO tb_perfilacessosmenus
VALUES
(2, 11),
(2, 9),
(2, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8)

SELECT * FROM tb_perfilacessosmenus
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_empresas(
	idempresa int IDENTITY CONSTRAINT PK_empresa PRIMARY KEY,
	desempresa VARCHAR(200),
	instatus bit CONSTRAINT DF_empresas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_empresas_dtcadastro DEFAULT getdate()
)

INSERT INTO tb_empresas
(desempresa)
VALUES
('Impacta'),
('Daryus')


SELECT * FROM tb_empresas
-------------------------------------------------------------------------
USE IDIGITALCLASS 
GO
CREATE TABLE tb_periodossemestres(
	idperiodosemestre int IDENTITY CONSTRAINT PK_periodossemestres PRIMARY KEY,
	desperiodosemestre varchar(200) NOT NULL,
	instatus bit CONSTRAINT DF_periodossemestres_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_periodossemestres_dtcadastro DEFAULT getdate()
)

--INSERT INTO tb_periodossemestres (desperiodosemestre) VALUES 
--('1º'),('2º'),('Anual')

SELECT * FROM tb_periodossemestres
-------------------------------------------------------------------------
USE IDIGITALCLASS 
GO
CREATE TABLE tb_periodos(
	idperiodo int IDENTITY CONSTRAINT PK_periodos PRIMARY KEY,
	desperiodo varchar(200) NOT NULL,
	idperiodosemestre int NOT NULL, 
	idempresa int NOT NULL,
	instatus bit CONSTRAINT DF_periodos_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_periodos_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_periodos_periodossemestres_idperiodosemestre FOREIGN KEY(idperiodosemestre)
	REFERENCES tb_periodossemestres(idperiodosemestre),
	CONSTRAINT FK_periodos_empresas_idempresa FOREIGN KEY(idempresa)
	REFERENCES tb_empresas (idempresa)
)

INSERT INTO tb_periodos (desperiodo, idperiodosemestre, idempresa)
VALUES('2015', 1, 1)

SELECT * FROM tb_periodos
-------------------------------------------------------------------------
CREATE TABLE tb_disciplinas(
	iddisciplina int IDENTITY CONSTRAINT PK_disciplinas PRIMARY KEY,
	desdisciplina varchar(300),
	idempresa int,
	instatus bit CONSTRAINT DF_disciplinas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_disciplinas_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_disciplinas_empresas_idempresa FOREIGN KEY(idempresa)
	REFERENCES tb_empresas(idempresa)
)

INSERT INTO tb_disciplinas
(desdisciplina, idempresa)
VALUES
('Pesquisa Operacional', 1),
('Introdução à Lógica de Programação', 1)

SELECT * FROM tb_disciplinas
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_salas(
	idsala int IDENTITY CONSTRAINT PK_salas PRIMARY KEY,
	dessala varchar(100),
	desdescricao varchar(1000),
	idempresa int,
	instatus bit CONSTRAINT DF_salas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_salas_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_salas_empresas_idempresa FOREIGN KEY(idempresa)
	REFERENCES tb_empresas(idempresa)
)

INSERT INTO tb_salas (dessala, desdescricao, idempresa)
VALUES
('A100', 'A100 Professor', 1),
('A200', 'A200 Professor', 2)

SELECt * FROM tb_salas
-------------------------------------------------------------------------
USE IDIGITALCLASS 
GO
CREATE TABLE tb_turnos(
	idturno int IDENTITY CONSTRAINT PK_turnos PRIMARY KEY,
	desturno varchar(200) NOT NULL,
	instatus bit CONSTRAINT DF_turnos_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_turnos_dtcadastro DEFAULT getdate()
)

INSERT INTO tb_turnos (desturno)
VALUES
('Manhã'),
('Noturno'),
('Vespertino'),
('Integral')

SELECT * FROM tb_turnos
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_turmas(
	idturma int IDENTITY CONSTRAINT PK_turmas PRIMARY KEY,
	desturma varchar(100),
	desdescricao varchar(1000),
	idturno int,
	idempresa int,
	instatus bit CONSTRAINT DF_turmas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_turmas_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_turmas_empresas_idempresa FOREIGN KEY(idempresa)
	REFERENCES tb_empresas(idempresa),
	CONSTRAINT FK_turmas_turnos_idturno FOREIGN KEY(idturno)
	REFERENCES tb_turnos(idturno)
)

INSERT INTO tb_turmas (desturma, desdescricao, idturno, idempresa)
VALUES
('ADM 1A', 'ADM 1', 1, 1),
('ADS 2B', 'ADS 1', 1, 2)

SELECt * FROM tb_turmas
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_cursos(
	idcurso int IDENTITY CONSTRAINT PK_cursos PRIMARY KEY,
	descurso varchar(200) NOT NULL,
	desdescricao varchar(1000),
	idempresa int,
	instatus bit CONSTRAINT DF_cursos_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_cursos_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_cursos_empresas_idempresa FOREIGN KEY(idempresa)
	REFERENCES tb_empresas(idempresa)
)

INSERT INTO tb_cursos (descurso, desdescricao, idempresa)
VALUES
('Produção Multimídia', 'Produção Multimídia', 2),
('Redes de Computadores', 'Redes de Computadores', 8),
('Sistemas de Informação', 'Sistemas de Informação', 1),
('Administração', 'Sistemas de Informação', 1)

SELECT * FROM tb_cursos
SELECT * FROM tb_empresas
-------------------------------------------------------------------------
USE IDIGITALCLASS
GO
CREATE TABLE tb_cursosdisciplinas(
	idcurso int,
	iddisciplina int
	
	CONSTRAINT PK_cursosdisciplinas_idcurso_iddisciplina PRIMARY KEY (idcurso, iddisciplina),
	CONSTRAINT FK_cursosdisciplinas_idcurso FOREIGN KEY(idcurso)
	REFERENCES tb_cursos (idcurso),
	CONSTRAINT FK_cursosdisciplinas_iddisciplina FOREIGN KEY (iddisciplina)
	REFERENCES tb_disciplinas (iddisciplina)
)

SELECT * FROM tb_cursosdisciplinas
-------------------------------------------------------------------------
CREATE TABLE tb_programadeaulas(
	idprogramadeaula int IDENTITY CONSTRAINT PK_programadeaulas PRIMARY KEY,
	idcurso int,
	idperiodo int,
	iddisciplina int,
	idturma int,
	idempresa int,
	instatus bit CONSTRAINT DF_programadeaulas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_programadeaulas_dtcadastro DEFAULT getdate()
	
	CONSTRAINT FK_programadeaulas_cursos_idcurso FOREIGN KEY (idcurso)
	REFERENCES tb_cursos (idcurso),
	CONSTRAINT FK_programadeaulas_periodos_idperiodo FOREIGN KEY (idperiodo)
	REFERENCES tb_periodos (idperiodo),
	CONSTRAINT FK_programadeaulas_disciplinas_iddisciplina FOREIGN KEY (iddisciplina)
	REFERENCES tb_disciplinas (iddisciplina),
	CONSTRAINT FK_programadeaulas_turmas_idturma FOREIGN KEY (idturma)
	REFERENCES tb_turmas (idturma),
	CONSTRAINT FK_programadeaulas_empresas_idturma FOREIGN KEY (idempresa)
	REFERENCES tb_empresas (idempresa)
)

SELECT * FROM tb_programadeaulas
-------------------------------------------------------------------------
CREATE TABLE tb_programadeaulasprofessores(
	idprogramadeaula int,
	idpessoa int,
	
	CONSTRAINT PK_programadeaulasprofessores_idprogramadeaula_idpessoa PRIMARY KEY(idprogramadeaula, idpessoa),
	CONSTRAINT FK_programadeaulasprofessores_programadeaulas_idprogramadeaula FOREIGN KEY(idprogramadeaula)
	REFERENCES tb_programadeaulas(idprogramadeaula)

)

SELECT * FROM tb_programadeaulasprofessores
SELECT * FROM vendas..tb_pessoas
-------------------------------------------------------------------------
CREATE SCHEMA IDC
GO
CREATE TABLE IDC.tb_aulas(
	idaula int IDENTITY CONSTRAINT PK_aulas PRIMARY KEY,
	idprogramadeaula int,
	idsala int,
	desdescricao varchar(5000),
	dtaula datetime,
	instatus bit CONSTRAINT DF_aulas_instatus DEFAULT 1,
	dtcadastro datetime CONSTRAINT DF_aulas_dtcadastro DEFAULT getdate()
)

SELECT * FROM IDC.tb_aulas
-------------------------------------------------------------------------
CREATE TABLE IDC.tb_aulasarquivos(
	idaula int,
	idarquivo int
	
	CONSTRAINT PK_aulasarquivos_idaula_idarquivo PRIMARY KEY(idaula, idarquivo),
	CONSTRAINT FK_aulasarquivos_aulas_idaula FOREIGN KEY(idaula)
	REFERENCES IDC.tb_aulas(idaula) ON DELETE CASCADE,
	CONSTRAINT FK_aulasarquivos_arquivos_idarquivo FOREIGN KEY(idarquivo)
	REFERENCES tb_arquivos(idarquivo) ON DELETE CASCADE
)

SELECT * FROM IDC.tb_aulasarquivos

-------------------------------------------------------------------------
USE IDIGITALCLASS
CREATE TABLE IDC.tb_aulasmigradas(
	idarquivo int,
	desmigrado varchar(1000),
	inmigrado bit,
	dtalterado datetime CONSTRAINT DF_aulasmigradas_dtcadastro DEFAULT getdate()
)

SELECT * FROM IDC.tb_aulasmigradas
-------------------------------------------------------------------------
-------------------------- PROCEDURES -----------------------------------
-------------------------------------------------------------------------
USE VENDAS
GO
ALTER PROC sp_pessoasidigitalclasscontas_save
(
	@idpessoa int,
	@idatendente int,
	@dessenha varchar(10),
	@dtiniciovalidade datetime,
	@dtterminovalidade datetime,
	@idperfilacesso int,
	@idempresa int,
	@instatus bit
)
AS
/*
app: CRM
url: 
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SET NOCOUNT ON

	IF EXISTS (
		SELECT idpessoa FROM tb_pessoasidigitalclasscontas
		WHERE idpessoa = @idpessoa 
	)
	BEGIN
	
		UPDATE tb_pessoasidigitalclasscontas
		SET 
			idatendente = @idatendente,
			dessenha = @dessenha,
			dtiniciovalidade = @dtiniciovalidade,
			dtterminovalidade = @dtterminovalidade,
			idperfilacesso = @idperfilacesso,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE idpessoa = @idpessoa
		
		SET NOCOUNT OFF
		
		SELECT TOP 1 * FROM tb_pessoasidigitalclasscontas a
		INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
		WHERE a.idpessoa = @idpessoa
	END
	ELSE
	BEGIN
		INSERT INTO tb_pessoasidigitalclasscontas
		(
			idpessoa,
			idatendente,
			dessenha,
			dtiniciovalidade,
			dtterminovalidade,
			idperfilacesso,
			idempresa,
			instatus
		)VALUES(
			@idpessoa,
			@idatendente,
			@dessenha,
			@dtiniciovalidade,
			@dtterminovalidade,
			@idperfilacesso,
			@idempresa,
			@instatus
		) 
		
		SET NOCOUNT OFF
		
		SELECT TOP 1 * FROM tb_pessoasidigitalclasscontas a
		INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
		WHERE a.idpessoa = @idpessoa
	END
END
--
--SELECT * from VENDAS..tb_pessoas where despessoa like 'Administrador Geral Idc'
SELECT * FROM Vendas..tb_contatos where idpessoa = 1015037
SELECt * FROM Vendas..tb_pessoasidigitalclasscontas
SELECT * FROM IDIGITALCLASS..tb_perfilacessos

exec VENDAS.dbo.sp_pessoasidigitalclasscontas_save 
	@idpessoa = 1336296,
	@idatendente = NULL,
	@dessenha = 'q1a2s3',
	@dtiniciovalidade = NULL,
	@dtterminovalidade = NULL,
	@idperfilacesso = 1,
	@idempresa = 1,
	@instatus = 1
---------------------------------------------------------------
USE VENDAS
GO
ALTER PROC sp_pessoasidigitalclasscontas_delete
(@idpessoa int)
AS
/*
app: CRM
url: 
data: 01/10/2015
author: Massaharu
*/
BEGIN

	DELETE FROM tb_pessoasidigitalclasscontas
	WHERE idpessoa = @idpessoa
END

	
---------------------------------------------------------------
USE VENDAS
GO
ALTER PROC sp_pessoasidigitalclasscontas_login
(@email varchar(200), @dessenha varchar(10), @data date)
AS
/*
app: SiteFIT
url: /idigitalclass/account/enter-idigitalclass.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	DECLARE 
		@DTINICIOVALIDADE datetime,
		@IDPERFILACESSO int
		
	SELECT
		@DTINICIOVALIDADE = a.dtiniciovalidade,
		@IDPERFILACESSO = a.idperfilacesso
	FROM tb_pessoasidigitalclasscontas a
		INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
		LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
		LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
	WHERE 
		a.instatus = 1 AND
		a.dessenha = @dessenha AND
		(
			c.descontato = @email OR
			e.email LIKE '%'+@email+'%'
		)

	-- SE a data de inicio estiver NULL e for um Candidato, setar a data atual para definir a data do primeiro login
	IF @DTINICIOVALIDADE IS NULL AND @IDPERFILACESSO = 6 
	BEGIN
	
		SET NOCOUNT ON
	
		UPDATE tb_pessoasidigitalclasscontas
		SET 
			dtiniciovalidade = GETDATE(),
			dtterminovalidade = GETDATE()+5
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
		WHERE 
			a.instatus = 1 AND
			a.dessenha = @dessenha AND
			(
				c.descontato = @email OR
				e.email LIKE '%'+@email+'%'
			)
		
		SET NOCOUNT OFF
	END
	
	-- Se o perfil do login for de Candidato, verificar os periodos de acesso
	IF @IDPERFILACESSO = 6 
	BEGIN
		
		SELECT
			a.idpessoa,
			b.despessoa as nome,
			a.idatendente,
			CASE 
				WHEN c.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, ' ', '') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(e.email,';')
					)
				ELSE
					c.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.idperfilacesso,
			f.desperfilacesso,
			a.idempresa,
			g.desempresa,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus, 
			a.dtcadastro
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
			LEFT JOIN IDIGITALCLASS..tb_perfilacessos f ON f.idperfilacesso = a.idperfilacesso
			LEFT JOIN IDIGITALCLASS..tb_empresas g ON g.idempresa = a.idempresa
		WHERE 
			a.instatus = 1 AND
			a.dessenha = @dessenha AND
			(
				c.descontato = @email OR
				e.email LIKE '%'+@email+'%'
			) AND
			@data BETWEEN CAST(a.dtiniciovalidade AS DATE) AND CAST(a.dtterminovalidade AS DATE)
	END
	-- Demais perfis de acesso
	ELSE
	BEGIN
		
		SELECT
			a.idpessoa,
			b.despessoa as nome,
			a.idatendente,
			CASE 
				WHEN c.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, ' ', '') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(e.email,';')
					)
				ELSE
					c.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.idperfilacesso,
			f.desperfilacesso,
			a.idempresa,
			g.desempresa,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus, 
			a.dtcadastro
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontatotipo = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
			LEFT JOIN IDIGITALCLASS..tb_perfilacessos f ON f.idperfilacesso = a.idperfilacesso
			LEFT JOIN IDIGITALCLASS..tb_empresas g ON g.idempresa = a.idempresa
		WHERE 
			a.instatus = 1 AND
			a.dessenha = @dessenha AND
			(
				c.descontato = @email OR
				e.email LIKE '%'+@email+'%'
			) 
	END
END
--

SELECT
			a.idpessoa,
			b.despessoa as nome,
			a.idatendente,
			CASE 
				WHEN c.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, ' ', '') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(e.email,';')
					)
				ELSE
					c.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.idperfilacesso,
			f.desperfilacesso,
			a.idempresa,
			g.desempresa,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus, 
			c.descontato,
			e.email,
			a.dtcadastro
		FROM Vendas..tb_pessoasidigitalclasscontas a
			INNER JOIN Vendas..tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN Vendas..tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontato = 1
			LEFT JOIN Vendas..tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
			LEFT JOIN IDIGITALCLASS..tb_perfilacessos f ON f.idperfilacesso = a.idperfilacesso
			LEFT JOIN IDIGITALCLASS..tb_empresas g ON g.idempresa = a.idempresa
		WHERE 
			a.instatus = 1 AND
			a.dessenha = 'vot2z70d' AND
			(
				c.descontato = 'lneto@impacta.com.br' OR
				e.email LIKE '%'+'lneto@impacta.com.br'+'%'
			) 

SELECT * FROM Vendas..tb_pessoasidigitalclasscontas

SELECT * FROM Vendas..tb_contatos where idpessoa = 1015037
SElect GETDATE() + 5
sp_pessoasidigitalclasscontas_login 'jvalezzi@impacta.com.br', '123456', '2015-06-24'
---------------------------------------------------------------
USE VENDAS 
GO
ALTER PROC sp_pessoasidigitalclasscontas_list
(@idpessoa int = NULL)
AS
/*
app: SiteFIT
url: /idigitalclass/account/enter-idigitalclass.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	IF @idpessoa IS NULL
	BEGIN 
		SELECT
			a.idpessoa,
			b.despessoa as nome,
			a.idatendente,
			CASE 
				WHEN c.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, ' ', '') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(e.email,';')
					)
				ELSE
					c.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.idperfilacesso,
			f.desperfilacesso,
			a.idempresa,
			g.desempresa,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus, 
			a.dtcadastro
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontato = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
			LEFT JOIN IDIGITALCLASS..tb_perfilacessos f ON f.idperfilacesso = a.idperfilacesso
			LEFT JOIN IDIGITALCLASS..tb_empresas g ON g.idempresa = a.idempresa
		WHERE 
			a.idpessoa = @idpessoa AND
		a.instatus = 1
	END
	ELSE
	BEGIN
		SELECT
			a.idpessoa,
			b.despessoa as nome,
			a.idatendente,
			CASE 
				WHEN c.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, ' ', '') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(e.email,';')
					)
				ELSE
					c.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.idperfilacesso,
			f.desperfilacesso,
			a.idempresa,
			g.desempresa,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus, 
			a.dtcadastro
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = a.idpessoa AND c.idcontato = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
			LEFT JOIN IDIGITALCLASS..tb_perfilacessos f ON f.idperfilacesso = a.idperfilacesso
			LEFT JOIN IDIGITALCLASS..tb_empresas g ON g.idempresa = a.idempresa
		WHERE a.instatus = 1
	END
END
--
USE Vendas 
SELECT * FROM tb_pessoasidigitalclasscontas
---------------------------------------------------------------
USE VENDAS
GO
ALTER PROC sp_pessoasidigitalclasscontasvencidos_list
AS
/*
app: SiteFIT
url: /idigitalclass/account/enter-idigitalclass.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	SELECT
		idpessoa,
		idatendente,
		dessenha,
		dtiniciovalidade,
		dtterminovalidade,
		idperfilacesso,
		idempresa,
		instatus,
		dtcadastro
	FROM
		tb_pessoasidigitalclasscontas
	WHERE 
		CAST(GETDATE() as DATE) > CAST(dtterminovalidade AS DATE)
END
---------------------------------------------------------------
USE VENDAS
GO
CREATE PROC sp_pessoasidigitalclasscontasbyidempresa_list
(@idempresa int)
AS
/*
app: IDIGITALCLASS
url: /idigitalclass/account/enter-idigitalclass.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SELECT 
		idpessoa,
		idatendente,
		dessenha,
		dtiniciovalidade,
		dtterminovalidade,
		instatus,
		dtcadastro,
		idperfilacesso,
		idempresa
	FROM tb_pessoasidigitalclasscontas
	WHERE
		idempresa = @idempresa
END
--
sp_pessoasidigitalclasscontasbyidempresa_list 3

---------------------------------------------------------------
CREATE PROC sp_menusbyperfilacesso_list
(@idperfilacesso int)
AS
/*
app: SiteFIT
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SELECT 
		a.idmenu,
		a.idmenupai,
		a.desmenu,
		a.deslink,
		a.instatus,
		a.dtcadastro
	FROM tb_menus a 
	INNER JOIN tb_perfilacessosmenus b ON b.idmenu = a.idmenu
	WHERE b.idperfilacesso = @idperfilacesso
END
--
sp_menusbyperfilacesso_list 1

SELECT * FROM tb_perfilacessos
---------------------------------------------------------------
CREATE PROC sp_menusbyidmenupai_list
(@idmenupai int)
AS
/*
app: SiteFIT
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN


	SELECT 
		a.idmenu,
		a.idmenupai,
		a.desmenu,
		a.deslink,
		a.instatus,
		a.dtcadastro
	FROM tb_menus a 
	INNER JOIN tb_perfilacessosmenus b ON b.idmenu = a.idmenu
	WHERE b.idperfilacesso = @idperfilacesso
END
---------------------------------------------------------------
ALTER PROC sp_perfilacessos_get
(@idperfilacesso int)
AS
/*
app: SiteFIT
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SELECT 
		idperfilacesso,
		desperfilacesso,
		instatus,
		dtcadastro,
		deslinkdefault
	FROM tb_perfilacessos
	WHERE idperfilacesso = @idperfilacesso
END
--
sp_perfilacessos_get 1
---------------------------------------------------------------
ALTER PROC sp_empresas_list
(@instatus int = NULL)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIn

	IF @instatus IS NULL
	BEGIN
		SELECT
			idempresa,
			desempresa,
			instatus,
			dtcadastro
		FROM tb_empresas
	END
	ELSE
	BEGIN
		SELECT
			idempresa,
			desempresa,
			instatus,
			dtcadastro
		FROM tb_empresas
		WHERE instatus = @instatus
	END
END
---------------------------------------------------------------
ALTER PROC sp_empresasbytipopesquisa_list
(@despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @destipopesquisa = 'id'
		SET @WHERE = 'WHERE idempresa = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE = 'WHERE desempresa like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE = 'WHERE instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE = 'WHERE 1 = 1'
	ELSE
		SET @WHERE = 'WHERE 1 = 0'
		
	SET @sqlStatement = 
		'SELECT
			idempresa,
			desempresa,
			instatus,
			dtcadastro
		FROM tb_empresas
		'+@WHERE+'
		ORDER BY dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@despesquisa varchar(1000), @destipopesquisa varchar(100)', @despesquisa, @destipopesquisa
END
--
sp_empresasbytipopesquisa_list 'da', 'nome'

	
---------------------------------------------------------------
CREATE PROC sp_empresas_save
(@idempresa int, @desempresa varchar(200), @instatus bit)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SET NOCOUNT ON

	IF EXISTS(
		SELECT idempresa FROM tb_empresas WHERE idempresa = @idempresa
	)
	BEGIN
		UPDATE tb_empresas
		SET
			desempresa = @desempresa,
			instatus = @instatus
		WHERE
			idempresa = @idempresa
		
		SET NOCOUNT OFF
		
		SELECT 
			idempresa,
			desempresa,
			instatus,
			dtcadastro
		FROM tb_empresas
		WHERE
			idempresa = @idempresa
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_empresas
		(desempresa, instatus)
		VALUES
		(@desempresa, @instatus)
		
		SET NOCOUNT OFF
		
		SELECT 
			idempresa,
			desempresa,
			instatus,
			dtcadastro
		FROM tb_empresas
		WHERE
			idempresa = SCOPE_IDENTITY()
	
	END
END
---------------------------------------------------------------
CREATE PROC sp_empresas_delete
(@idempresa int)
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
AS
BEGIN
	
	DELETE tb_empresas
	WHERE
		idempresa = @idempresa
END
---------------------------------------------------------------
ALTER PROC sp_perfilacessosbytipopesquisa_list
(@despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @destipopesquisa = 'id'
		SET @WHERE = 'WHERE idperfilacesso = @despesquisa'
	ELSE IF @destipopesquisa = 'descricao'
		SET @WHERE = 'WHERE desperfilacesso like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'link'
		SET @WHERE = 'WHERE deslinkdefault like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE = 'WHERE instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE = 'WHERE 1 = 1'
	ELSE
		SET @WHERE = 'WHERE 1 = 0'
		
	SET @sqlStatement = 
		'SELECT
			idperfilacesso,
			desperfilacesso,
			instatus,
			dtcadastro,
			deslinkdefault
		FROM tb_perfilacessos
		'+@WHERE+'
		ORDER BY dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@despesquisa varchar(1000), @destipopesquisa varchar(100)', @despesquisa, @destipopesquisa
END
--
sp_perfilacessosbytipopesquisa_list 'da', 'nome'

SELECT * FROM tb_perfilacessos
---------------------------------------------------------------
CREATE PROC sp_perfilacessos_list
(@instatus int = NULL)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIn

	IF @instatus IS NULL
	BEGIn
		SELECT
			idperfilacesso,
			desperfilacesso,
			instatus,
			dtcadastro,
			deslinkdefault
		FROM tb_perfilacessos
	END
	ELSE
	BEGIN
		SELECT
			idperfilacesso,
			desperfilacesso,
			instatus,
			dtcadastro,
			deslinkdefault
		FROM tb_perfilacessos
		WHERE instatus = @instatus
	END
END
---------------------------------------------------------------
USE VENDAS
GO
CREATE PROC sp_pessoasidigitalclasscontasbyidperfilacesso_list
(@idperfilacesso int)
AS
/*
app: IDIGITALCLASS
url: /idigitalclass/account/enter-idigitalclass.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SELECT 
		idpessoa,
		idatendente,
		dessenha,
		dtiniciovalidade,
		dtterminovalidade,
		instatus,
		dtcadastro,
		idperfilacesso,
		idempresa
	FROM tb_pessoasidigitalclasscontas
	WHERE
		idperfilacesso = @idperfilacesso
END
--
sp_pessoasidigitalclasscontasbyidperfilacesso_list 1
---------------------------------------------------------------
CREATE PROC sp_perfilacessos_delete
(@idperfilacesso int)
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
AS
BEGIN
	
	DELETE tb_perfilacessos
	WHERE
		idperfilacesso = @idperfilacesso
END
---------------------------------------------------------------
USE IDIGITALCLASS
GO
ALTER PROC sp_perfilacessos_save
(@idperfilacesso int, @desperfilacesso varchar(200), @deslinkdefault varchar(200), @instatus bit)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SET NOCOUNT ON

	IF EXISTS(
		SELECT idperfilacesso FROM tb_perfilacessos WHERE idperfilacesso = @idperfilacesso
	)
	BEGIN
		UPDATE tb_perfilacessos
		SET
			desperfilacesso = @desperfilacesso,
			deslinkdefault = @deslinkdefault,
			instatus = @instatus
		WHERE
			idperfilacesso = @idperfilacesso
		
		SET NOCOUNT OFF
		
		SELECT 
			idperfilacesso,
			desperfilacesso,
			instatus,
			dtcadastro,
			deslinkdefault
		FROM tb_perfilacessos
		WHERE
			idperfilacesso = @idperfilacesso
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_perfilacessos
		(desperfilacesso, deslinkdefault, instatus)
		VALUES
		(@desperfilacesso, @deslinkdefault, @instatus)
		
		SET NOCOUNT OFF
		
		SELECT 
			idperfilacesso,
			desperfilacesso,
			instatus,
			dtcadastro,
			deslinkdefault
		FROM tb_perfilacessos
		WHERE
			idperfilacesso = SCOPE_IDENTITY()
	
	END
END
--
SELECT *FROM tb_perfilacessos
---------------------------------------------------------------
USE IDIGITALCLASS
GO
ALTER PROC sp_pessoasidigitalclasscontas_list
(@idempresa int, @idperfilacesso int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS NOT NULL AND @idperfilacesso IS NOT NULL
		SET @WHERE = 'WHERE a.idempresa = @idempresa AND a.idperfilacesso = @idperfilacesso'
	ELSE IF @idempresa IS NOT NULL
		SET @WHERE = 'WHERE a.idempresa = @idempresa'	
	ELSE IF @idperfilacesso IS NOT NULL
		SET @WHERE = 'WHERE a.idperfilacesso = @idperfilacesso'	
	ELSE 
		SET @WHERE = 'WHERE 1 = 1'
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idpessoa = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND b.despessoa like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'login'
		SET @WHERE += ' AND (d.descontato like ''%'+@despesquisa+'%'' OR h.email like ''%'+@despesquisa+'%'')'
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND  a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND  1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
	SET @sqlStatement = 
		'SELECT
			a.idpessoa,
			b.despessoa,
			a.idatendente,
			CASE 
				WHEN d.descontato IS NULL THEN 
					(
						SELECT TOP 1 
							replace(id, '' '', '''') COLLATE SQL_Latin1_General_CP850_CI_AI
						FROM Simpac.dbo.fnSplit(h.email,'';'')
					)
				ELSE
					d.descontato COLLATE SQL_Latin1_General_CP850_CI_AI
			END as desemail,
			a.dessenha,
			a.dtiniciovalidade,
			a.dtterminovalidade,
			a.instatus,
			a.dtcadastro,
			a.idperfilacesso,
			e.desperfilacesso,
			a.idempresa,
			f.desempresa
		FROM Vendas..tb_pessoasidigitalclasscontas a
		INNER JOIN Vendas..tb_pessoas b ON b.idpessoa = a.idpessoa
		LEFT JOIN Simpac..tb_usuario c ON c.idusuario = a.idatendente
		INNER JOIN Vendas..tb_contatos d ON d.idpessoa = a.idpessoa AND d.idcontatotipo = 1
		INNER JOIN tb_perfilacessos e ON e.idperfilacesso = a.idperfilacesso
		INNER JOIN tb_empresas f ON f.idempresa = a.idempresa
		LEFT JOIN Vendas..tb_pessoassophia g ON g.idpessoa = a.idpessoa
		LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA h ON h.CODIGO = g.codigo
		'+@WHERE+'
		ORDER BY b.dtcadastro DESC'
	
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @idperfilacesso int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @idperfilacesso, @despesquisa, @destipopesquisa
END

sp_pessoasidigitalclasscontas_list 6, NULL, '', ''

SELECT * FROM vendas..tb_pessoas where idpessoa = 1066508
SELECT * FROM simpac..tb_usuario where IdUsuario = 1847
SELECt * FROM vendas..tb_contatos where idpessoa = 1021843
Vendas..sp_contatobydescontato_get 'admgeralidc@gmail.com'

SELECT * FROM Vendas..tb_pessoassophia WHERE idpessoa = 1021843
---------------------------------------------------------------
ALTER PROC sp_periodossemestres_list
(@instatus bit = NULL)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	IF @instatus IS NULL
	
		SELECT 
			idperiodosemestre,
			desperiodosemestre,
			instatus,
			dtcadastro
		FROM tb_periodossemestres
		
	ELSE
		
		SELECT 
			idperiodosemestre,
			desperiodosemestre,
			instatus,
			dtcadastro
		FROM tb_periodossemestres
		WHERE 
			instatus = @instatus
END
--
sp_periodossemestres_list 0


SELECT * FROM tb_periodossemestres
---------------------------------------------------------------
ALTER PROC sp_periodosbytipopesquisa_list
(@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS not NULL
	BEGIN
		SET @WHERE = 'WHERE a.idempresa = @idempresa'
	END
	ELSE
	BEGIN
		SET @WHERE = 'WHERE 1 = 1'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idperiodo = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND a.desperiodo like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'periodosemestre'
		SET @WHERE += ' AND a.idperiodosemestre = @despesquisa'
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
		
		
	SET @sqlStatement = 
		'SELECT
			a.idperiodo,
			a.desperiodo,
			a.idperiodosemestre,
			b.desperiodosemestre,
			a.idempresa,
			c.desempresa,
			a.instatus,
			a.dtcadastro
		FROM tb_periodos a
		INNER JOIN tb_periodossemestres b ON b.idperiodosemestre = a.idperiodosemestre
		INNER JOIN tb_empresas c ON c.idempresa = a.idempresa
		'+@WHERE+'
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @despesquisa, @destipopesquisa
END
--
sp_periodosbytipopesquisa_list NULL, '',  ''
 
SELECT * FROM tb_perfilacessos 
SELECT * FROM tb_periodos
SELECT * FROM tb_periodossemestres
SELECT * FROM tb_aulas

---------------------------------------------------------------
CREATE PROC sp_periodos_save
(
	@idperiodo int,
	@desperiodo varchar(200),
	@idperiodosemestre int,
	@idempresa int,
	@instatus bit
)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idperiodo FROM tb_periodos WHERE idperiodo = @idperiodo
	)
	BEGIN
		
		UPDATE tb_periodos
		SET
			desperiodo = @desperiodo,
			idperiodosemestre = @idperiodosemestre,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE idperiodo = @idperiodo
		
		SET NOCOUNT OFF
		
		SELECT
			idperiodo,
			desperiodo,
			idperiodosemestre,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_periodos
		WHERE idperiodo = @idperiodo
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_periodos
		(
			desperiodo,
			idperiodosemestre,
			idempresa,
			instatus
		)VALUES(
			@desperiodo,
			@idperiodosemestre,
			@idempresa,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT
			idperiodo,
			desperiodo,
			idperiodosemestre,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_periodos
		WHERE idperiodo = SCOPE_IDENTITY()
	END
END

---------------------------------------------------------------
ALTER PROC sp_disciplinasbytipopesquisa_list
(@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS not NULL
	BEGIN
		SET @WHERE = 'WHERE a.idempresa = @idempresa'
	END
	ELSE
	BEGIN
		SET @WHERE = 'WHERE 1 = 1'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.iddisciplina = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND a.desdisciplina like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
		
		
	SET @sqlStatement = 
		'SELECT
			a.iddisciplina,
			a.desdisciplina,
			a.idempresa,
			c.desempresa,
			a.instatus,
			a.dtcadastro
		FROM tb_disciplinas a
		INNER JOIN tb_empresas c ON c.idempresa = a.idempresa
		'+@WHERE+'
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @despesquisa, @destipopesquisa
END
--
sp_disciplinasbytipopesquisa_list NULL, '', ''
---------------------------------------------------------------
CREATE PROC sp_disciplinas_save
(
	@iddisciplina int,
	@desdisciplina varchar(300),
	@idempresa int,
	@instatus bit
)
AS
BEGIN
	
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT iddisciplina FROM tb_disciplinas WHERE iddisciplina = @iddisciplina
	)
	BEGIN
		
		UPDATE tb_disciplinas
		SET
			desdisciplina = @desdisciplina,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE
			iddisciplina = @iddisciplina
			
		SET NOCOUNT OFF
		
		SELECT
			iddisciplina,
			desdisciplina,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_disciplinas
		WHERE
			iddisciplina = @iddisciplina
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_disciplinas
		(
			desdisciplina,
			idempresa,
			instatus
		)VALUES(
			@desdisciplina,
			@idempresa,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT
			iddisciplina,
			desdisciplina,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_disciplinas
		WHERE
			iddisciplina = SCOPE_IDENTITY()
	END
END
---------------------------------------------------------------
ALTER PROC sp_salasbytipopesquisa_list
(@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS not NULL
	BEGIN
		SET @WHERE = 'WHERE a.idempresa = @idempresa'
	END
	ELSE
	BEGIN
		SET @WHERE = 'WHERE 1 = 1'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idsala = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND a.dessala like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'descricao'
		SET @WHERE += ' AND a.desdescricao like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
		
		
	SET @sqlStatement = 
		'SELECT
			a.idsala,
			a.dessala,
			a.desdescricao,
			a.idempresa,
			c.desempresa,
			a.instatus,
			a.dtcadastro
		FROM tb_salas a
		INNER JOIN tb_empresas c ON c.idempresa = a.idempresa
		'+@WHERE+'
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @despesquisa, @destipopesquisa
END
--
sp_salasbytipopesquisa_list NULL, '1', 'status'
---------------------------------------------------------------
CREATE PROC sp_salas_save
(
	@idsala int,
	@dessala varchar(100),
	@desdescricao varchar(1000),
	@idempresa int,
	@instatus bit
)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idsala FROM tb_salas WHERE idsala = @idsala
	)
	BEGIN
		
		UPDATE tb_salas
		SET
			dessala = @dessala,
			desdescricao = @desdescricao,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE 
			idsala = @idsala
		
		SET NOCOUNT OFF
		
		SELECT
			idsala,
			dessala,
			desdescricao,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_salas
		WHERE	
			idsala = @idsala
		
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_salas
		(
			dessala,
			desdescricao,
			idempresa,
			instatus
		)VALUES(
			@dessala,
			@desdescricao,
			@idempresa,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT
			idsala,
			dessala,
			desdescricao,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_salas
		WHERE	
			idsala = SCOPE_IDENTITY()
	
	END
END
---------------------------------------------------------------
ALTER PROC sp_turmasbytipopesquisa_list
(@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS not NULL
	BEGIN
		SET @WHERE = 'WHERE a.idempresa = @idempresa'
	END
	ELSE
	BEGIN
		SET @WHERE = 'WHERE 1 = 1'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idturma = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND a.desturma like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'turno'
		SET @WHERE += ' AND a.idturno = @despesquisa'
	ELSE IF @destipopesquisa = 'descricao'
		SET @WHERE += ' AND a.desdescricao like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
		
		
	SET @sqlStatement = 
		'SELECT
			a.idturma,
			a.desturma,
			a.desdescricao,
			a.idturno,
			d.desturno,
			a.idempresa,
			c.desempresa,
			a.instatus,
			a.dtcadastro
		FROM tb_turmas a
		INNER JOIN tb_empresas c ON c.idempresa = a.idempresa
		INNER JOIN tb_turnos d ON d.idturno = a.idturno
		'+@WHERE+'
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @despesquisa, @destipopesquisa
END
--
sp_turmasbytipopesquisa_list NULL, '1', 'status'
---------------------------------------------------------------
CREATE PROC sp_turmas_save
(
	@idturma int,
	@desturma varchar(100),
	@desdescricao varchar(1000),
	@idturno int, 
	@idempresa int,
	@instatus bit
)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idturma FROM tb_turmas WHERE idturma = @idturma
	)
	BEGIN
		
		UPDATE tb_turmas
		SET 
			desturma = @desturma,
			desdescricao = @desdescricao,
			idturno = @idturno,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE
			idturma = @idturma
			
		SET NOCOUNT OFF
		
		SELECT
			idturma,
			desturma,
			desdescricao,
			idturno,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_turmas
		WHERE 
			idturma = @idturma
		
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_turmas
		(
			desturma,
			desdescricao,
			idturno,
			idempresa,
			instatus
		)VALUES(
			@desturma,
			@desdescricao,
			@idturno,
			@idempresa,
			@instatus
		)	
		
		SET NOCOUNT OFF
		
		SELECT
			idturma,
			desturma,
			desdescricao,
			idturno,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_turmas
		WHERE 
			idturma = SCOPE_IDENTITY()
			
	END
END
---------------------------------------------------------------
ALTEr PROC sp_turnosbytipopesquisa_list
(@despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @destipopesquisa = 'id'
		SET @WHERE = 'WHERE idturno = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE = 'WHERE desturno like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE = 'WHERE instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE = 'WHERE 1 = 1'
	ELSE
		SET @WHERE = 'WHERE 1 = 0'
		
	SET @sqlStatement = 
		'SELECT
			idturno,
			desturno,
			instatus,
			dtcadastro
		FROM tb_turnos 
		'+@WHERE+'
		ORDER BY dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@despesquisa varchar(1000), @destipopesquisa varchar(100)', @despesquisa, @destipopesquisa
END
--
sp_turnosbytipopesquisa_list '1', 'status'
---------------------------------------------------------------
CREATE PROC sp_turnos_save
(
	@idturno int,
	@desturno varchar(200),
	@instatus bit
)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT * FROM tb_turnos WHERE idturno = @idturno
	)
	BEGIN
		
		UPDATE tb_turnos
		SET
			desturno = @desturno,
			instatus = @instatus
		WHERE 
			idturno = @idturno
		
		SET NOCOUNT OFF
		
		SELECT 
			idturno,
			desturno,
			instatus,
			dtcadastro
		FROM tb_turnos
		WHERE idturno = @idturno
		
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_turnos
		(
			desturno,
			instatus
		)VALUES(
			@desturno,
			@instatus
		)
		
		SELECT 
			idturno,
			desturno,
			instatus,
			dtcadastro
		FROM tb_turnos
		WHERE idturno = SCOPE_IDENTITY()
	END	
END
---------------------------------------------------------------
CREATE PROC sp_cursosbytipopesquisa_list
(@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = ''	
		
	IF @idempresa IS not NULL
	BEGIN
		SET @WHERE = 'WHERE a.idempresa = @idempresa'
	END
	ELSE
	BEGIN
		SET @WHERE = 'WHERE 1 = 1'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idcurso = @despesquisa'
	ELSE IF @destipopesquisa = 'nome'
		SET @WHERE += ' AND a.descurso like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'descricao'
		SET @WHERE += ' AND a.desdescricao like ''%'+@despesquisa+'%'''
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND  1 = 0'
		
	SET @sqlStatement = 
		'SELECT
			a.idcurso,
			a.descurso,
			a.desdescricao,
			a.idempresa,
			c.desempresa,
			a.instatus,
			a.dtcadastro
		FROM tb_cursos a
		INNER JOIN tb_empresas c ON c.idempresa = a.idempresa
		'+@WHERE+'
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @despesquisa, @destipopesquisa
END
---------------------------------------------------------------
ALTEr PROC sp_disciplinasbycurso_list
(@idcurso int)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SELECT
		a.iddisciplina,
		a.desdisciplina,
		c.idcurso,
		c.idcurso,	
		a.idempresa,
		a.instatus,
		a.dtcadastro
	FROM tb_disciplinas a
	INNER JOIN tb_cursosdisciplinas b ON b.iddisciplina = a.iddisciplina
	INNER JOIN tb_cursos c ON c.idcurso = b.idcurso
	WHERE
		c.idcurso = @idcurso 
	
END
---------------------------------------------------------------
CREATE PROC sp_cursos_save
(
	@idcurso int,
	@descurso varchar(200),
	@desdescricao varchar(1000),
	@idempresa int,
	@instatus bit
)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idcurso FROM tb_cursos WHERE idcurso = @idcurso
	)
	BEGIN
		
		UPDATE tb_cursos
		SET
			descurso = @descurso,
			desdescricao = @desdescricao,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE 
			idcurso = @idcurso
			
		SET NOCOUNT OFF
		
		SELECT
			idcurso,
			descurso,
			desdescricao,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_cursos
		WHERE idcurso = @idcurso
			
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_cursos
		(
			descurso,
			desdescricao,
			idempresa,
			instatus
		)VALUES(
			@descurso,
			@desdescricao,
			@idempresa,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT
			idcurso,
			descurso,
			desdescricao,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_cursos
		WHERE idcurso = SCOPE_IDENTITY()
	
	END
END
---------------------------------------------------------------
ALTER PROC sp_cursosdisciplinas_add
(@idcurso int, @idsdisciplinas varchar(500))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	DELETE FROM tb_cursosdisciplinas
	WHERE
		idcurso = @idcurso AND
		iddisciplina IN(
			
			SELECT 
				iddisciplina 
			FROM tb_cursosdisciplinas a
			LEFT JOIN Simpac..fnSplit(@idsdisciplinas,',') b ON b.Id = a.iddisciplina
			WHERE 
				idcurso = @idcurso AND
				b.Id IS NULL
		)
		
	INSERT INTO tb_cursosdisciplinas
	SELECT 
		@idcurso,
		Id 
	FROM Simpac..fnSplit(@idsdisciplinas,',') a
	LEFT JOIN tb_cursosdisciplinas b ON b.iddisciplina = a.Id AND b.idcurso = @idcurso
	WHERE 
		b.iddisciplina IS NULL

END
--
SELECT * FROM tb_cursosdisciplinas
sp_disciplinasbycurso_list 1
---------------------------------------------------------------
ALTER PROC sp_programadeaulasbytipopesquisa_list
(@idempresa int, @idcurso int, @idperiodo int, @despesquisa varchar(1000), @destipopesquisa varchar(100))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN
	
	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = 'WHERE 1 = 1 '	
		
	IF @idempresa IS NOT NULL
	BEGIN
		SET @WHERE += ' AND a.idempresa = @idempresa'
	END
	
	IF @idcurso IS NOT NULL
	BEGIN
		SET @WHERE += ' AND a.idcurso = @idcurso'
	END
	
	IF @idperiodo IS NOT NULL
	BEGIN
		SET @WHERE += ' AND a.idperiodo = @idperiodo'
	END
		
	IF @destipopesquisa = 'id'
		SET @WHERE += ' AND a.idprogramadeaula = @despesquisa'
	ELSE IF @destipopesquisa = 'turma'
		SET @WHERE += ' AND a.idturma = @despesquisa'
	ELSE IF @destipopesquisa = 'disciplina'
		SET @WHERE += ' AND a.iddisciplina = @despesquisa'
	ELSE IF @destipopesquisa = 'turno'
		SET @WHERE += ' AND e.idturno = @despesquisa'
	ELSE IF @destipopesquisa = 'professor'
		SET @WHERE += ' AND g.idpessoa = @despesquisa'
	ELSE IF @destipopesquisa = 'status'
		SET @WHERE += ' AND a.instatus = @despesquisa'
	ELSE IF @destipopesquisa = ''
		SET @WHERE += ' AND 1 = 1'
	ELSE
		SET @WHERE += ' AND 1 = 0'
		
	SET @sqlStatement = 
		'SELECT 
			a.idprogramadeaula,
			a.idcurso,
			b.descurso,
			a.idperiodo,
			c.desperiodo,
			c.idperiodosemestre,
			f.desperiodosemestre,
			a.iddisciplina,
			d.desdisciplina,
			a.idturma,
			e.desturma,
			e.idturno,
			h.desturno,
			a.idempresa,
			i.desempresa,
			COUNT(*) nrprofessores,
			a.instatus,
			a.dtcadastro
		FROM tb_programadeaulas a
		INNER JOIN tb_cursos b ON b.idcurso = a.idcurso
		INNER JOIN tb_periodos c ON c.idperiodo = a.idperiodo
		INNER JOIN tb_disciplinas d ON d.iddisciplina = a.iddisciplina
		INNER JOIN tb_turmas e ON e.idturma = a.idturma
		INNER JOIN tb_periodossemestres f ON f.idperiodosemestre = c.idperiodosemestre
		LEFT JOIN tb_programadeaulasprofessores g ON g.idprogramadeaula = a.idprogramadeaula
		INNER JOIN tb_turnos h ON h.idturno = e.idturno
		INNER JOIN tb_empresas i ON i.idempresa = a.idempresa
		'+@WHERE+'
		GROUP BY
			a.idprogramadeaula,
			a.idcurso,
			b.descurso,
			a.idperiodo,
			c.desperiodo,
			c.idperiodosemestre,
			f.desperiodosemestre,
			a.iddisciplina,
			d.desdisciplina,
			a.idturma,
			e.desturma,
			e.idturno,
			h.desturno,
			a.idempresa,
			i.desempresa,
			a.instatus,
			a.dtcadastro
		ORDER BY a.dtcadastro'
		
	exec sp_ExecuteSQL @sqlStatement, N'@idempresa int, @idcurso int, @idperiodo int, @despesquisa varchar(1000), @destipopesquisa varchar(100)', @idempresa, @idcurso, @idperiodo, @despesquisa, @destipopesquisa
END
--
SELECT 
	a.idprogramadeaula,
	a.idcurso,
	b.descurso,
	a.idperiodo,
	c.desperiodo,
	c.idperiodosemestre,
	f.desperiodosemestre,
	a.iddisciplina,
	d.desdisciplina,
	a.idturma,
	e.desturma,
	e.idturno,
	h.desturno,
	a.idempresa,
	i.desempresa,
	COUNT(*) nrprofessores,
	a.instatus,
	a.dtcadastro
FROM tb_programadeaulas a
INNER JOIN tb_cursos b ON b.idcurso = a.idcurso
INNER JOIN tb_periodos c ON c.idperiodo = a.idperiodo
INNER JOIN tb_disciplinas d ON d.iddisciplina = a.iddisciplina
INNER JOIN tb_turmas e ON e.idturma = a.idturma
INNER JOIN tb_periodossemestres f ON f.idperiodosemestre = c.idperiodosemestre
LEFT JOIN tb_programadeaulasprofessores g ON g.idprogramadeaula = a.idprogramadeaula
INNER JOIN tb_turnos h ON h.idturno = e.idturno
INNER JOIN tb_empresas i ON i.idempresa = a.idempresa
GROUP BY
	a.idprogramadeaula,
	a.idcurso,
	b.descurso,
	a.idperiodo,
	c.desperiodo,
	c.idperiodosemestre,
	f.desperiodosemestre,
	a.iddisciplina,
	d.desdisciplina,
	a.idturma,
	e.desturma,
	e.idturno,
	a.idempresa,
	i.desempresa,
	h.desturno,
	a.instatus,
	a.dtcadastro
ORDER BY a.dtcadastro


sp_programadeaulasbytipopesquisa_list 1, NULL, NULL, '1', 'id'

SELECT * FROM tb_programadeaulasprofessores
SELECT * FROM tb_turmas
SELECT * FROM tb_empresas
---------------------------------------------------------------
CREATE PROC sp_programadeaulas_save
(
	@idprogramadeaula int,
	@idcurso int,
	@idperiodo int,
	@iddisciplina int,
	@idturma int,
	@idempresa int,
	@instatus bit
)
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
AS
BEGIN
	
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idprogramadeaula FROM tb_programadeaulas WHERE idprogramadeaula = @idprogramadeaula
	)
	BEGIN
	
		UPDATE tb_programadeaulas
		SET
			idcurso = @idcurso,
			idperiodo = @idperiodo,
			iddisciplina = @iddisciplina,
			idturma = @idturma,
			idempresa = @idempresa,
			instatus = @instatus
		WHERE
			idprogramadeaula = @idprogramadeaula
		
		SET NOCOUNT OFF
		
		SELECT
			idprogramadeaula,
			idcurso,
			idperiodo,
			iddisciplina,
			idturma,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_programadeaulas
		WHERE
			idprogramadeaula = @idprogramadeaula		
						
	END
	ELSE
	BEGIN
	
		INSERT INTO tb_programadeaulas
		(
			idcurso,
			idperiodo,
			iddisciplina,
			idturma,
			idempresa,
			instatus
		)VALUES(
			@idcurso,
			@idperiodo,
			@iddisciplina,
			@idturma,
			@idempresa,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT
			idprogramadeaula,
			idcurso,
			idperiodo,
			iddisciplina,
			idturma,
			idempresa,
			instatus,
			dtcadastro
		FROM tb_programadeaulas
		WHERE
			idprogramadeaula = SCOPE_IDENTITY()
	
	END
END


tb_programadeaulas
---------------------------------------------------------------
CREATE PROC sp_programadeaulasprofessores_add
(@idprogramadeaula int, @idspessoas varchar(500))
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	DELETE FROM tb_programadeaulasprofessores
	WHERE
		idprogramadeaula = @idprogramadeaula AND
		idpessoa IN(
			
			SELECT 
				idpessoa 
			FROM tb_programadeaulasprofessores a
			LEFT JOIN Simpac..fnSplit(@idspessoas,',') b ON b.Id = a.idpessoa
			WHERE 
				idprogramadeaula = @idprogramadeaula AND
				b.Id IS NULL
		)
		
	INSERT INTO tb_programadeaulasprofessores
	SELECT 
		@idprogramadeaula,
		Id 
	FROM Simpac..fnSplit(@idspessoas,',') a
	LEFT JOIN tb_programadeaulasprofessores b ON b.idpessoa = a.Id AND b.idprogramadeaula = @idprogramadeaula
	WHERE 
		b.idpessoa IS NULL

END
--
SELECT * FROM tb_programadeaulas
---------------------------------------------------------------
ALTER PROC sp_professoresbyprogramadeaula_list
(@idprogramadeaula int)
AS
/*
app: iDigitalClass
url: inc/class/IdigitalClassPage.php
data: 01/10/2015
author: Massaharu
*/
BEGIN

	SELECT
		a.idpessoa,
		d.despessoa
	FROM Vendas..tb_pessoasidigitalclasscontas a
	INNER JOIN tb_programadeaulasprofessores b ON b.idpessoa  = a.idpessoa
	INNER JOIN tb_programadeaulas c ON c.idprogramadeaula = b.idprogramadeaula
	INNER JOIN Vendas..tb_pessoas d ON d.idpessoa = a.idpessoa
	WHERE c.idprogramadeaula = @idprogramadeaula
	
END
--
sp_professoresbyprogramadeaula_list 1
SELECT * FROM  Vendas..tb_pessoasidigitalclasscontas
SELECT * FROM tb_programadeaulas
SELECT * FROM tb_programadeaulasprofessores
---------------------------------------------------------------
CREATE PROC IDC.sp_aulas_save
(
      @idaula int,
      @idprogramadeaula int,
      @idsala int,
      @desdescricao varchar(5000),
      @dtaula datetime,
      @instatus bit
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      SET NOCOUNT ON
      
      IF EXISTS(
            SELECT 
                  idaula
            FROM IDC.tb_aulas 
            WHERE 
                  idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                        AND
                        idprogramadeaula = @idprogramadeaula
                  )
      )
      BEGIN
			
            IF @desdescricao = ''
            BEGIN
                  SELECT 
                        @desdescricao = desdescricao
                  FROM IDC.tb_aulas 
                  WHERE 
                        idaula = @idaula OR 
                        (
                             (
                                   YEAR(dtaula) = YEAR(@dtaula) AND
                                   MONTH(dtaula) = MONTH(@dtaula) AND
                                   DAY(dtaula) = DAY(@dtaula) 
                             ) 
                              AND
							idprogramadeaula = @idprogramadeaula
                        )
            END
      
            UPDATE IDC.tb_aulas
            SET 
                  idprogramadeaula = @idprogramadeaula,
                  idsala = @idsala,
                  desdescricao = @desdescricao,
                  dtaula = @dtaula,
                  instatus = @instatus
            WHERE idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                         AND
						idprogramadeaula = @idprogramadeaula
                  )
            
            SET NOCOUNT OFF
            
            SELECT 
				idaula,
				idprogramadeaula,
				idsala,
				desdescricao,
				dtaula,
				instatus,
				dtcadastro
            FROM IDC.tb_aulas
            WHERE idaula = @idaula OR 
                  (
                        (
                             YEAR(dtaula) = YEAR(@dtaula) AND
                             MONTH(dtaula) = MONTH(@dtaula) AND
                             DAY(dtaula) = DAY(@dtaula) 
                        ) 
                         AND
						idprogramadeaula = @idprogramadeaula
                  )
      END
      ELSE
      BEGIN
            INSERT INTO IDC.tb_aulas
            (
                  idprogramadeaula,
                  idsala,
                  desdescricao,
                  dtaula,
                  instatus
            )VALUES(
                  @idprogramadeaula,
                  @idsala,
                  @desdescricao,
                  @dtaula,
                  @instatus
            )
            
            SET NOCOUNT OFF
            
            SELECT 
				idaula,
				idprogramadeaula,
				idsala,
				desdescricao,
				dtaula,
				instatus,
				dtcadastro
			FROM tb_aulas
			WHERE idaula = SCOPE_IDENTITY()
            
      END   
END
--
SELECT * FROM IDC.tb_aulas
SELECT * FROM IDC.tb_aulasarquivos
SELECT * FROM tb_arquivos



 IDC.sp_aulas_save
      @idaula = 0,
      @idprogramadeaula = 4,
      @idsala = NULL,
      @desdescricao = 'Descrição da aula',
      @dtaula = '2015-06-28',
      @instatus = 1 
---------------------------------------------------------------
CREATE PROC IDC.sp_aulasarquivos_add
(@idaula int, @idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF NOT EXISTS(
		SELECT idaula 
		FROM IDC.tb_aulasarquivos
		WHERE idaula = @idaula AND idarquivo = @idarquivo
	)
	BEGIN
	
	
      INSERT INTO IDC.tb_aulasarquivos
      VALUES (@idaula, @idarquivo)
    END
END
--
SELECT * FROM IDC.tb_aulasarquivos
SELECT * FROM tb_arquivos

sp_arquivos_save
	@idarquivo = 0 ,
	@desarquivo = 'arquivo-teste.pdf',
	@nrtamanho = 1000000,
	@idarquivotipo = 1,
	@descaminho = '1/1/2015-06-24',
	@instatus = 1

IDC.sp_aulasarquivos_add 1, 1373
---------------------------------------------------------------
ALTER PROC IDC.sp_aulas_list
(
	@idperiodo int = NULL,
	@idturma int = NULL,
	@iddisciplina int = NULL,
	@idprogramadeaula int = NULL,
	@idpessoa int = NULL,
	@data_de datetime,
	@data_ate datetime
)
AS
BEGIN

	DECLARE
		@sqlStatement nvarchar(max),
		@WHERE nvarchar(300) = 'WHERE 1 = 1 '
	
	IF @idperiodo IS NOT NULL
	BEGIN
		SET @WHERE += ' AND b.idperiodo = @idperiodo'
	END
	
	IF @idturma IS NOT NULL 
	BEGIN
		SET @WHERE += ' AND b.idturma = @idturma'
	END
	
	IF @iddisciplina IS NOT NULL 
	BEGIN
		SET @WHERE += ' AND b.iddisciplina = @iddisciplina'
	END
	
	IF @idprogramadeaula IS NOT NULL 
	BEGIN
		SET @WHERE += ' AND b.idprogramadeaula = @idprogramadeaula'
	END
	
	IF @idpessoa IS NOT NULL 
	BEGIN
		SET @WHERE += ' AND c.idpessoa = @idpessoa'
	END
	
	SET @sqlStatement = 
	'SELECT 
		a.idaula,
		a.idprogramadeaula,
		a.idsala,
		j.dessala,
		b.idcurso,
		f.descurso,
		b.idturma,
		g.desturma,
		g.idturno,
		h.desturno,
		b.iddisciplina,
		i.desdisciplina,
		a.desdescricao,
		a.dtaula,
		a.instatus,
		a.dtcadastro
	FROM IDC.tb_aulas a
	INNER JOIN tb_programadeaulas b ON b.idprogramadeaula = a.idprogramadeaula
	LEFT JOIN tb_programadeaulasprofessores c ON c.idprogramadeaula = b.idprogramadeaula
	LEFT JOIN Vendas..tb_pessoasidigitalclasscontas d ON d.idpessoa = c.idpessoa
	LEFT JOIN Vendas..tb_pessoas e ON e.idpessoa = d.idpessoa
	INNER JOIN tb_cursos f ON f.idcurso = b.idcurso
	INNER JOIN tb_turmas g ON g.idturma = b.idturma
	INNER JOIN tb_turnos h ON h.idturno = g.idturno
	INNER JOIN tb_disciplinas i ON i.iddisciplina = b.iddisciplina
	LEFT JOIN tb_salas j ON j.idsala = a.idsala
	'+@WHERE+' AND
		a.dtaula BETWEEN @data_de AND @data_ate AND
        a.instatus = 1 
    GROUP BY
		a.idaula,
		a.idprogramadeaula,
		a.idsala,
		j.dessala,
		b.idcurso,
		f.descurso,
		b.idturma,
		g.desturma,
		g.idturno,
		h.desturno,
		b.iddisciplina,
		i.desdisciplina,
		a.desdescricao,
		a.dtaula,
		a.instatus,
		a.dtcadastro
	ORDER BY a.dtaula DESC'
		
	
	exec sp_ExecuteSQL @sqlStatement, N'@idperiodo int = NULL, @idturma int = NULL, @iddisciplina int = NULL, @idprogramadeaula int = NULL, @idpessoa int = NULL, @data_de datetime, @data_ate datetime', @idperiodo, @idturma, @iddisciplina, @idprogramadeaula, @idpessoa, @data_de, @data_ate
END
--

IDC.sp_aulas_list
	@idperiodo = NULL,
	@idturma = NULL,
	@iddisciplina = NULL,
	@idprogramadeaula = NULL,
	@idpessoa = NULL,
	@data_de = '2015-01-01',
	@data_ate = '2015-12-01'


SELECT 
	c.idpessoa,
	e.despessoa,
	b.idcurso,
	f.descurso,
	b.idturma,
	g.desturma,
	g.idturno,
	h.desturno,
	b.iddisciplina,
	i.desdisciplina,
	a.desdescricao,
	a.dtaula,
    a.instatus,
    a.dtcadastro
FROM IDC.tb_aulas a
INNER JOIN tb_programadeaulas b ON b.idprogramadeaula = a.idprogramadeaula
LEFT JOIN tb_programadeaulasprofessores c ON c.idprogramadeaula = b.idprogramadeaula
LEFT JOIN Vendas..tb_pessoasidigitalclasscontas d ON d.idpessoa = c.idpessoa
LEFT JOIN Vendas..tb_pessoas e ON e.idpessoa = d.idpessoa
INNER JOIN tb_cursos f ON f.idcurso = b.idcurso
INNER JOIN tb_turmas g ON g.idturma = b.idturma
INNER JOIN tb_turnos h ON h.idturno = g.idturno
INNER JOIN tb_disciplinas i ON i.iddisciplina = b.iddisciplina

DELETE FROM tb_perfilacessosmenus
WHERE
	idperfilacesso = 1 AND idmenu in (9,10)
---------------------------------------------------------------
CREATE PROC IDC.sp_arquivos_list
(
      @idaula int,
      @idturma int = null,
      @iddisciplina int = null,
      @dtaula datetime = null,
	  @idarquivotipo int = null
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
      IF @idaula = 0
      BEGIN
      
            SELECT 
                  a.idarquivo,
                  a.desarquivo, 
                  a.nrtamanho,
                  a.idarquivotipo,
                  b.desarquivotipo,
                  a.descaminho,
                  a.instatus,
				  a.incopiado,
                  a.dtcadastro
            FROM tb_arquivos a
            INNER JOIN tb_arquivostipos b ON b.idarquivotipo = a.idarquivotipo
            INNER JOIN IDC.tb_aulasarquivos c ON c.idarquivo = a.idarquivo
            INNER JOIN IDC.tb_aulas d ON d.idaula = c.idaula
            INNER JOIN tb_programadeaula e ON e.idprogramadeaula = d.idprogramadeaula
            WHERE
                  e.idturma = @idturma AND
                  e.iddisciplina = @iddisciplina AND
                  d.dtaula = @dtaula AND
                  a.idarquivotipo = @idarquivotipo AND 
                  a.instatus = 1
            ORDER BY a.dtcadastro
      
      END
      ELSE
      BEGIN
      
            SELECT 
                  a.idarquivo,
                  a.desarquivo, 
                  a.nrtamanho,
                  a.idarquivotipo,
                  b.desarquivotipo,
                  a.descaminho,
                  a.instatus,
				  a.incopiado,
                  a.dtcadastro
            FROM tb_arquivos a
            INNER JOIN tb_arquivostipos b ON b.idarquivotipo = a.idarquivotipo
            INNER JOIN IDC.tb_aulasarquivos c ON c.idarquivo = a.idarquivo
            INNER JOIN IDC.tb_aulas d ON d.idaula = c.idaula
            WHERE
                  c.idaula = @idaula AND
                  a.idarquivotipo = @idarquivotipo AND 
                  a.instatus = 1
            ORDER BY a.dtcadastro
      END
END 

 

---------------------------------------------------------------
CREATE PROC sp_disciplinasbyperiodoturma_list
(
	@idperiodo int = NULL,
	@idturma int = NULL
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF @idperiodo IS NOT NULL AND @idturma IS NOT NULL
	BEGIN
	
		SELECT 
			a.iddisciplina,
			a.desdisciplina,
			a.idempresa,
			a.instatus,
			a.dtcadastro 
		FROM tb_disciplinas a
		INNER JOIN tb_programadeaulas b ON b.iddisciplina = a.iddisciplina
		WHERE a.instatus = 1 AND b.idperiodo = @idperiodo AND idturma = @idturma 
		
	END
	ELSE IF @idperiodo IS NOT NULL
	BEGIN
	
		SELECT 
			a.iddisciplina,
			a.desdisciplina,
			a.idempresa,
			a.instatus,
			a.dtcadastro 
		FROM tb_disciplinas a
		INNER JOIN tb_programadeaulas b ON b.iddisciplina = a.iddisciplina
		WHERE a.instatus = 1 AND b.idperiodo = @idperiodo 
		
	END
	ELSE IF @idturma IS NOT NULL
	BEGIN
	
		SELECT 
			a.iddisciplina,
			a.desdisciplina,
			a.idempresa,
			a.instatus,
			a.dtcadastro 
		FROM tb_disciplinas a
		INNER JOIN tb_programadeaulas b ON b.iddisciplina = a.iddisciplina
		WHERE a.instatus = 1 AND b.idturma = @idturma 
		 
	END
	ELSE
	BEGIN
		SELECT 
			a.iddisciplina,
			a.desdisciplina,
			a.idempresa,
			a.instatus,
			a.dtcadastro 
		FROM tb_disciplinas a
		INNER JOIN tb_programadeaulas b ON b.iddisciplina = a.iddisciplina
		WHERE a.instatus = 1
	END
END
---------------------------------------------------------------
ALTER PROC sp_videotoconverttomp4_list
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	SELECT TOP 1
		a.idarquivo,
		c.inmigrado,
		a.desarquivo,
		a.nrtamanho,
		a.idarquivotipo,
		a.descaminho,
		a.instatus,
		a.incopiado
	FROM tb_arquivos a
	INNER JOIN IDC.tb_aulasarquivos b ON b.idarquivo = a.idarquivo AND a.idarquivotipo = 2
	LEFT JOIN IDC.tb_aulasmigradas c ON c.idarquivo = b.idarquivo
	WHERE 
		(
			c.idarquivo IS NULL OR
			(
				c.inmigrado = 0 OR c.inmigrado IS NULL
			)
		)
		 AND (
			a.desarquivo LIKE '%.avi' OR a.desarquivo LIKE '%.wmv'
		) AND
		a.instatus = 1 
	ORDER BY c.inmigrado DESC, c.dtalterado, a.idarquivo
END
---------------------------------------------------------------
CREATE PROC sp_videotoconverttomp4_save
(
	@idarquivo int,
	@desmigrado varchar(1000),
	@inmigrado bit
)
AS 
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idarquivo FROM IDC.tb_aulasmigradas WHERE idarquivo = @idarquivo
	)
	BEGIN
		
		UPDATE IDC.tb_aulasmigradas
		SET
			inmigrado = @inmigrado,
			desmigrado = @desmigrado,
			dtalterado = GETDATE()
		WHERE
			idarquivo = @idarquivo
			
		SET NOCOUNT OFF
		
		SELECT
			idarquivo,
			desmigrado,
			inmigrado,
			dtalterado
		FROM IDC.tb_aulasmigradas
		WHERE 
			idarquivo = @idarquivo
	END
	ELSE
	BEGIN
	
		INSERT INTO IDC.tb_aulasmigradas
		(
			idarquivo,
			desmigrado,
			inmigrado,
			dtalterado
		)VALUES(
			@idarquivo,
			@desmigrado,
			@inmigrado,
			GETDATE()
		)
		
		SET NOCOUNT OFF
		
		SELECT
			idarquivo,
			desmigrado,
			inmigrado,
			dtalterado
		FROM IDC.tb_aulasmigradas
		WHERE 
			idarquivo = @idarquivo
	END
END
---------------------------------------------------------------
-------------------- POSTGRE QUERY ----------------------------
---------------------------------------------------------------

"INSERT INTO tblusuario
(id, nome, login, password, email, ativo, perfil, coordenador, fk_coordenador)
VALUES
(
	nextval('tblaulabase_id_seq'), 
	'".$idcaccount['nome']."', 
	'".$idpessoa."', 
	'".$idcaccount['dessenha']."', 
	'".$idcaccount['desemail']."', 
	't',
	'Aluno',
	'f',
	NULL
);"
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------
---------------------------------------------------------------

UPDATE tb_pessoasidigitalclasscontas
SET dtiniciovalidade = NULL, instatus = 1
WHERE idpessoa = 1021843

SELECT * FROM tb_pessoasidigitalclasscontas
SELECT * FROM tb_pessoassophia WHERE idpessoa = 1021843
SELECT * FROM tb_pessoas where despessoa like '%varazzi%'
SELECT * FROM tb_pessoas
SELECt * FROM tb_contatos where idcontatotipo = 1 order by idpessoa
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 23744

SELECT b.nome, b.email FROM tb_pessoassophia a
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO  = a.codigo
INNER JOIN tb_contatos
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE codext = '37832815809'
SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE COD_FUNC = 20086

SELECT * FROM SONATA.SOPHIA.SOPHIA.DISCIPLINAS WHERE  NOME LIKE '%SQL%'

SELECT CAST((RAND() * 1000000) AS CHAR(6))

SELECT * FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS WHERE COD_FUNC = 27351
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE NOME LIKE '%MD%'


SELECT
			a.dtiniciovalidade, *
		FROM tb_pessoasidigitalclasscontas a
			INNER JOIN tb_pessoas b ON b.idpessoa = a.idpessoa
			LEFT JOIN tb_contatos c ON c.idpessoa = b.idpessoa AND c.idcontatotipo = 1
			LEFT JOIN tb_pessoassophia d ON d.idpessoa = a.idpessoa
			LEFT JOIN SONATA.SOPHIA.SOPHIA.FISICA e ON e.CODIGO = d.codigo
		WHERE 
			a.instatus = 1 AND
			a.dessenha = 'r08kf324234iex' AND
			(
				c.descontato = 'Lneto@impacta.com.br' --OR
				--e.email LIKE '%Lneto@impacta.com.br%'
			)
			
SELECT * FROM Vendas..tb_pessoas where idpessoa = 1015037			

SELECT * FROM Vendas..tb_contatos where idpessoa = 1015037		

SELECT * FROM tb_menus	

SELECT * FROM SONATA.SOPHIA.SOPHIA.PERIODOS