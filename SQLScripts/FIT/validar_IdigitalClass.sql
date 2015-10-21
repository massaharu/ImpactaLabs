SERVIDOR = SATURN
BANCO = IDIGITALCLASS

USE IDIGITALCLASS
-----------------------------------------------------------
--------------- TABELAS -----------------------------------
-----------------------------------------------------------
CREATE TABLE tb_arquivosidigitalclasstipo(
	idarquivotipo int IDENTITY CONSTRAINT PK_arquivosidigitalclasstipo PRIMARY KEY,
	desarquivotipo varchar(200) not null,
	instatus bit CONSTRAINT DF_arquivosidigitalclasstipo_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_arquivosidigitalclasstipo_dtcadastro DEFAULT(getdate())
)

INSERT INTO tb_arquivosidigitalclasstipo
VALUES ('Pré-Aula'), ('Vídeos')

SELECT * FROM tb_arquivosidigitalclasstipo
------------------------------------------------
CREATE TABLE tb_arquivosidigitalclass(
	idarquivo int IDENTITY CONSTRAINT PK_arquivosidigitalclass PRIMARY KEY,
	desarquivo varchar(300) not null,
	nrtamanho int,
	idarquivotipo int,
	descaminho varchar(300),
	instatus bit CONSTRAINT DF_arquivosidigitalclass_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_arquivosidigitalclass_dtcadastro DEFAULT(getdate())
	
	CONSTRAINT FK_arquivosidigitalclass_idarquivotipo FOREIGN KEY(idarquivotipo)
	REFERENCES tb_arquivosidigitalclasstipo(idarquivotipo)
)

SELECT * FROM tb_arquivosidigitalclass
------------------------------------------------
CREATE TABLE tb_idigitalclassaulas(
	idaula int identity CONSTRAINT PK_idigitalclassaulas PRIMARY KEY,
	idcodfisica int,
	idcodturma int,
	idcoddisciplina int,
	desdescricao varchar(5000),
	dtaula datetime not null,
	instatus bit CONSTRAINT DF_idigitalclassaulas_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_idigitalclassaulas_dtcadastro DEFAULT(getdate())
)

SELECT * FROM tb_idigitalclassaulas
-----------------------------------------------------------
CREATE TABLE tb_idigitalclassaulas_arquivos(
	idaula int,
	idarquivo int
	
	CONSTRAINT PK_idigitalclassaulas_arquivos_idaula_idarquivo PRIMARY KEY(idaula, idarquivo),
	CONSTRAINT FK_idigitalclassaulas_arquivos_idaula FOREIGN KEY(idaula)
	REFERENCES tb_idigitalclassaulas(idaula),
	CONSTRAINT FK_idigitalclassaulas_arquivos_idarquivo FOREIGN KEY(idarquivo)
	REFERENCES tb_arquivosidigitalclass(idarquivo)
)

SELECT * FROM tb_idigitalclassaulas_arquivos
-----------------------------------------------------------
CREATE TABLE tb_idigitalclassaulas_avaliacao(
	idavaliacao int IDENTITY,
	idaula int,
	idaluno int,
	nrnota int,
	instatus bit CONSTRAINT DF_idigitalclassaulas_avaliacao_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_idigitalclassaulas_avaliacao_dtcadastro DEFAULT(getdate()) 
	
	CONSTRAINT PK_idigitalclassaulas_avaliacao_idavaliacao_idaula_idaluno PRIMARY KEY(idavaliacao, idaula, idaluno),
	CONSTRAINT FK_idigitalclassaulas_avaliacao_idaula FOREIGN KEY(idaula)
	REFERENCES tb_idigitalclassaulas(idaula)
)

SELECT * FROM tb_idigitalclassaulas_avaliacao
-----------------------------------------------------------
-- Tabela para salvar os ranges de execução de cada aula por turno
CREATE TABLE tb_idigitalclass_timeexecution(
	idtimeexecution int identity CONSTRAINT PK_idigitalclass_timeexecution PRIMARY KEY,	
	idturno int,
	nraula int,
	dtinicio time,
	dttermino time
)

INSERT INTO tb_idigitalclass_timeexecution(idturno, nraula, dtinicio, dttermino)VALUES
(1, 1, '19:00:00', '21:59:59'),
(1, 2, '19:50:00', '21:59:59'),
(1, 3, '21:50:00', '23:59:59'),
(1, 4, '21:50:00', '23:59:59'),
(2, 1, '08:00:00', '10:59:59'),
(2, 2, '08:50:00', '10:59:59'),
(2, 3, '10:50:00', '18:59:59'),
(2, 4, '10:50:00', '18:59:59'),
(6, 1, '08:00:00', '13:59:59'),
(6, 2, '11:00:00', '13:59:59'),
(6, 3, '14:00:00', '23:59:59'),
(6, 4, '14:00:00', '23:59:59'),
(7, 1, '08:00:00', '13:59:59'),
(7, 2, '11:00:00', '13:59:59'),
(7, 3, '14:00:00', '23:59:59'),
(7, 4, '14:00:00', '23:59:59')

SELECT * FROM saturn.idigitalclass.dbo.tb_idigitalclass_timeexecution
----------------------------------------------------------
CREATE TABLE tb_xmlteam_idigitalclass(
	CODTURMASOPHIA int,
	CODTURMAIDIGITALCLASS int
)

SELECT * FROM tb_xmlteam_idigitalclass
----------------------------------------------------------
CREATE TABLE tb_xmldiscipline_idigitalclass(
	CODDISCIPLINASOPHIA int,
	CODDISCIPLINAIDIGITALCLASS int
)

SELECT * FROM tb_xmldiscipline_idigitalclass
----------------------------------------------------------
CREATE TABLE tb_periododecurso_idigitalclass(
	CODPERIODOSOPHIA int,
	CODPERIODOIDIGITALCLASS int
)

INSERT INTO tb_periododecurso_idigitalclass VALUES
(93, 3),
(95, 4),
(114, 2),
(117, 1),
(120, 8),
(125, 9),
(127, 10)

SELECT * FROM tb_periododecurso_idigitalclass
-----------------------------------------------------------
--------------- PROCEDURES --------------------------------
-----------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_get]
(@idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	SELECT
		idarquivo,
		desarquivo,
		nrtamanho,
		idarquivotipo,
		descaminho,
		instatus,
		dtcadastro
	FROM tb_arquivosidigitalclass
	WHERE idarquivo = @idarquivo
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclasspreaula_list]
(
	@idaula int,
	@idturma int = null,
	@iddisciplina int = null,
	@dtaula datetime = null
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
			a.dtcadastro,
			'new' as desorigem
		FROM tb_arquivosidigitalclass a
		INNER JOIN tb_arquivosidigitalclasstipo b ON b.idarquivotipo = a.idarquivotipo
		INNER JOIN tb_idigitalclassaulas_arquivos c ON c.idarquivo = a.idarquivo
		INNER JOIN tb_idigitalclassaulas d ON d.idaula = c.idaula
		WHERE
			d.idcodturma = @idturma AND
			d.idcoddisciplina = @iddisciplina AND
			d.dtaula = @dtaula AND
			a.idarquivotipo = 1 AND -- PRE-AULA
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
			a.dtcadastro,
			'new' as desorigem
		FROM tb_arquivosidigitalclass a
		INNER JOIN tb_arquivosidigitalclasstipo b ON b.idarquivotipo = a.idarquivotipo
		INNER JOIN tb_idigitalclassaulas_arquivos c ON c.idarquivo = a.idarquivo
		INNER JOIN tb_idigitalclassaulas d ON d.idaula = c.idaula
		WHERE
			c.idaula = @idaula AND
			a.idarquivotipo = 1 AND -- PRE-AULA
			a.instatus = 1
		ORDER BY a.dtcadastro
	END
END 
----------------------------------------------------------- 
CREATE PROC [dbo].[sp_arquivosidigitalclassvideo_list]
(
	@idaula int,
	@idturma int = null,
	@iddisciplina int = null,
	@dtaula datetime = null
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
			a.dtcadastro,
			'new' as desorigem
		FROM tb_arquivosidigitalclass a
		INNER JOIN tb_arquivosidigitalclasstipo b ON b.idarquivotipo = a.idarquivotipo
		INNER JOIN tb_idigitalclassaulas_arquivos c ON c.idarquivo = a.idarquivo
		INNER JOIN tb_idigitalclassaulas d ON d.idaula = c.idaula
		WHERE
			d.idcodturma = @idturma AND
			d.idcoddisciplina = @iddisciplina AND
			d.dtaula = @dtaula AND
			a.idarquivotipo = 2 AND -- VIDEO
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
			a.dtcadastro,
			'new' as desorigem
		FROM tb_arquivosidigitalclass a
		INNER JOIN tb_arquivosidigitalclasstipo b ON b.idarquivotipo = a.idarquivotipo
		INNER JOIN tb_idigitalclassaulas_arquivos c ON c.idarquivo = a.idarquivo
		INNER JOIN tb_idigitalclassaulas d ON d.idaula = c.idaula
		WHERE
			c.idaula = @idaula AND
			a.idarquivotipo = 2 AND -- VIDEO
			a.instatus = 1
		ORDER BY a.dtcadastro
	END
END 
-----------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_save]
(
	@idarquivo int,
	@desarquivo varchar(300),
	@nrtamanho int,
	@idarquivotipo int,
	@descaminho varchar(300),
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
		SELECT idarquivo FROM tb_arquivosidigitalclass
		WHERE idarquivo = @idarquivo
	)
	BEGIN
		UPDATE tb_arquivosidigitalclass
		SET
			desarquivo = @desarquivo,
			nrtamanho = @nrtamanho,
			idarquivotipo = @idarquivotipo,
			descaminho = @descaminho,
			instatus = @instatus
		WHERE idarquivo = @idarquivo
		
		SET NOCOUNT OFF
		
		SELECT @idarquivo as idarquivo
	
	END
	ELSE
	BEGIN
		INSERT INTO tb_arquivosidigitalclass
		(
			desarquivo,
			nrtamanho,
			idarquivotipo,
			descaminho,
			instatus
		)VALUES(
			@desarquivo,
			@nrtamanho,
			@idarquivotipo,
			@descaminho,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as idarquivo
	
	END
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_remove]
(@idaula int, @idsarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	DELETE tb_idigitalclassaulas_arquivos
	WHERE 
		idaula = @idaula AND 
		idarquivo in(
			SELECT id FROM Simpac..fnSplit(REPLACE(@idsarquivo, ' ', ''), ',')
		)
		
	DELETE tb_arquivosidigitalclass
	WHERE 
		idarquivo in(
			SELECT id FROM Simpac..fnSplit(REPLACE(@idsarquivo, ' ', ''), ',')
		)
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaula_get]
(@idaula int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	SELECT 
		idaula,
		idcodfisica,
		idcodturma,
		idcoddisciplina,
		desdescricao,
		dtaula,
		instatus,
		dtcadastro
	FROM tb_idigitalclassaulas
	WHERE idaula = @idaula
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_periodoidigitalclassbysophia_get]
(@idperiodosophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	SELECT DISTINCT
		CODPERIODOIDIGITALCLASS 
	FROM tb_periododecurso_idigitalclass
	WHERE 
		CODPERIODOSOPHIA = @idperiodosophia
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_turmaidigitalclassbysophia_get]
(@idturmasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT DISTINCT
		CODTURMAIDIGITALCLASS 
	FROM tb_xmlteam_idigitalclass
	WHERE
		CODTURMASOPHIA = @idturmasophia
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_disciplinaidigitalclassbysophia_get]
(@iddisciplinasophia int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT DISTINCT
		CODDISCIPLINAIDIGITALCLASS
	FROM tb_xmldiscipline_idigitalclass 
	WHERE
		CODDISCIPLINASOPHIA = @iddisciplinasophia
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_periodosophiabyidigitalclass_get]
(@idperiodoidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	SELECT DISTINCT
		CODPERIODOSOPHIA 
	FROM tb_periododecurso_idigitalclass
	WHERE 
		CODPERIODOIDIGITALCLASS = @idperiodoidigitalclass
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_turmasophiabyidigitalclass_get]
(@idturmaidigitalclass int, @idperiodoidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	DECLARE @IDPERIODOSOPHIA int
	
	-- RECUPERA O IDPERIODO SOPHIA PELO IDPERIODO IDIGITALCLASS
	SET @IDPERIODOSOPHIA = (
		SELECT 
			CODPERIODOSOPHIA 
		FROM tb_periododecurso_idigitalclass 
		WHERE
			CODPERIODOIDIGITALCLASS = @idperiodoidigitalclass
	)
	
	SELECT DISTINCT
		CODTURMASOPHIA
	FROM tb_xmlteam_idigitalclass a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS b ON b.CODIGO = a.CODTURMASOPHIA
	WHERE
		CODTURMAIDIGITALCLASS = @idturmaidigitalclass AND
		b.PERIODO = @IDPERIODOSOPHIA
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_disciplinasophiabyidigitalclass_get]
(@iddisciplinaidigitalclass int)
AS
/*
  app: FIT
  url: inc/_class/idigitalClassAula.class.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT DISTINCT
		CODDISCIPLINASOPHIA
	FROM tb_xmldiscipline_idigitalclass 
	WHERE
		CODDISCIPLINAIDIGITALCLASS = @iddisciplinaidigitalclass
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassbyperiodo_list]
(
	@idcodperiodo int = NULL,
	@data_de datetime,
	@data_ate datetime,
	@idarquivotipo int,
	@idcodprofessor int = NULL
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	-- QUERY PARA AREA DO PROFESSOR ------------------------
	IF @idcodprofessor IS NOT NULL AND @idcodprofessor <> 0
	BEGIN
		-- BUSCA PELO PERIODO
		IF @idcodperiodo IS NOT NULL AND @idcodperiodo <> 0
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				c.PERIODO = @idcodperiodo AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.idcodfisica = @idcodprofessor AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
		-- BUSCA PELAS DATAS
		ELSE
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.idcodfisica = @idcodprofessor AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
	END
	-- QUERY PARA AREA DO ALUNO
	ELSE
	BEGIN
		-- BUSCA PELO PERIODO
		IF @idcodperiodo IS NOT NULL AND @idcodperiodo <> 0
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				c.PERIODO = @idcodperiodo AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
		-- BUSCA PELAS DATAS
		ELSE
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
	END
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaulasbydisciplina_list]
(
	@idcoddisciplina int = NULL,
	@idcodturma int,
	@data_de datetime,
	@data_ate datetime,
	@idarquivotipo int,
	@idcodprofessor int = NULL
)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	-- QUERY PARA AREA DO PROFESSOR ------------------------------
	IF @idcodprofessor IS NOT NULL AND @idcodprofessor <> 0
	BEGIN
		-- BUSCA PELA DISCIPLINA 
		IF @idcoddisciplina IS NOT NULL AND @idcoddisciplina <> 0
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.idcoddisciplina = @idcoddisciplina AND
				a.idcodturma = @idcodturma AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.idcodfisica = @idcodprofessor AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
		-- BUSCA PELA TURMA
		ELSE
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.idcodturma = @idcodturma AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.idcodfisica = @idcodprofessor AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
	END
	-- QUERY PARA AREA DO ALUNO ------------------------------
	ELSE
	BEGIN
		-- BUSCA PELA DISCIPLINA 
		IF @idcoddisciplina IS NOT NULL AND @idcoddisciplina <> 0
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.idcoddisciplina = @idcoddisciplina AND
				a.idcodturma = @idcodturma AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
		-- BUSCA PELA TURMA
		ELSE
		BEGIN
			SELECT DISTINCT
				a.idaula,
				a.idcodfisica,
				b.NOME as desprofessor,
				c.CURSO as idcurso,
				e.NOME as descurso,
				a.idcodturma,
				c.NOME as desturma,
				a.idcoddisciplina,
				d.NOME as desdisciplina,
				a.desdescricao,
				a.dtaula,
				a.instatus,
				a.dtcadastro,
				'new' as desorigem
			FROM tb_idigitalclassaulas a
			INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA b ON b.CODIGO = a.idcodfisica
			INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idcodturma
			INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.idcoddisciplina
			INNER JOIN SONATA.SOPHIA.SOPHIA.CURSOS e ON e.PRODUTO = c.CURSO
			INNER JOIN tb_idigitalclassaulas_arquivos f ON f.idaula = a.idaula
			INNER JOIN tb_arquivosidigitalclass g ON g.idarquivo = f.idarquivo
			WHERE	
				a.idcodturma = @idcodturma AND
				a.dtaula BETWEEN @data_de AND @data_ate AND
				a.instatus = 1 AND
				g.idarquivotipo = @idarquivotipo
			ORDER BY a.dtaula DESC
		END
	END
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaulas_avaliacao_save]
(@idaula int, @idaluno int, @nrnota int)
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
		SELECT idavaliacao FROM tb_idigitalclassaulas_avaliacao
		WHERE idaula = @idaula AND idaluno = @idaluno
	)
	BEGIN
		UPDATE tb_idigitalclassaulas_avaliacao
		SET nrnota = @nrnota
		WHERE idaula = @idaula AND idaluno = @idaluno
		
		SET NOCOUNT OFF
		
		SELECT idavaliacao, '0' as innovo FROM tb_idigitalclassaulas_avaliacao
		WHERE idaula = @idaula AND idaluno = @idaluno 
		
	END
	ELSE
	BEGIN
		INSERT INTO tb_idigitalclassaulas_avaliacao
		(idaula, idaluno, nrnota)
		VALUES
		(@idaula, @idaluno, @nrnota)
		
		SET NOCOUNT OFF
		
		SELECT idavaliacao, '1' as innovo FROM tb_idigitalclassaulas_avaliacao
		WHERE idavaliacao = SCOPE_IDENTITY()
		
	END
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaulas_avaliacao_get]
(@idaula int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	SELECT AVG(nrnota) media, COUNT(*) nrrates FROM tb_idigitalclassaulas_avaliacao
	WHERE idaula = @idaula
	GROUP BY idaula
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaulaarquivo_add]
(@idaula int, @idarquivo int)
AS
/*
  app: IDIGITALCLASS
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	INSERT INTO tb_idigitalclassaulas_arquivos
	VALUES (@idaula, @idarquivo)
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclassaula_save]
(
	@idaula int,
	@idcodfisica int,
	@idcodturma int,
	@idcoddisciplina int,
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
		FROM tb_idigitalclassaulas 
		WHERE 
			idaula = @idaula OR 
			(
				(
					YEAR(dtaula) = YEAR(@dtaula) AND
					MONTH(dtaula) = MONTH(@dtaula) AND
					DAY(dtaula) = DAY(@dtaula) 
				) 
				AND
				idcodturma = @idcodturma AND
				idcoddisciplina = @idcoddisciplina
			)
	)
	BEGIN
	
		IF @desdescricao = ''
		BEGIN
			SELECT 
				@desdescricao = desdescricao
			FROM tb_idigitalclassaulas 
			WHERE 
				idaula = @idaula OR 
				(
					(
						YEAR(dtaula) = YEAR(@dtaula) AND
						MONTH(dtaula) = MONTH(@dtaula) AND
						DAY(dtaula) = DAY(@dtaula) 
					) 
					AND
					idcodturma = @idcodturma AND
					idcoddisciplina = @idcoddisciplina
				)
		END
	
		UPDATE tb_idigitalclassaulas
		SET 
			idcodfisica = @idcodfisica,
			idcodturma = @idcodturma,
			idcoddisciplina = @idcoddisciplina,
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
				idcodturma = @idcodturma AND
				idcoddisciplina = @idcoddisciplina
			)
		
		SET NOCOUNT OFF
		 
		SELECT idaula FROM tb_idigitalclassaulas
		WHERE idaula = @idaula OR 
			(
				(
					YEAR(dtaula) = YEAR(@dtaula) AND
					MONTH(dtaula) = MONTH(@dtaula) AND
					DAY(dtaula) = DAY(@dtaula) 
				) 
				AND
				idcodturma = @idcodturma AND
				idcoddisciplina = @idcoddisciplina
			)
	END
	ELSE
	BEGIN
		INSERT INTO tb_idigitalclassaulas
		(
			idcodfisica,
			idcodturma,
			idcoddisciplina,
			desdescricao,
			dtaula,
			instatus
		)VALUES(
			@idcodfisica,
			@idcodturma,
			@idcoddisciplina,
			@desdescricao,
			@dtaula,
			@instatus
		)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as idaula
		
	END	
END
--------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclass_timeexecution_list]
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	SELECT 
		idtimeexecution,	
		idturno,
		b.descricao as desturno,
		nraula,
		dtinicio,
		dttermino
	FROM tb_idigitalclass_timeexecution a
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURNOS b ON b.CODIGO = a.idturno
	ORDER BY a.idturno, a.nraula
END
--------------------------------------------------------
CREATE PROC [dbo].[sp_idigitalclass_timeexecution_edit]
(@idtimeexecution int, @dtinicio time, @dttermino time )
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN

	UPDATE tb_idigitalclass_timeexecution
	SET
		dtinicio = @dtinicio,
		dttermino = @dttermino
	WHERE idtimeexecution = @idtimeexecution
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_save]
(
	@idarquivotemp int,
	@desprofessor varchar(300),
	@dessala varchar(50),
	@dtaula datetime,
	@instatus bit,
	@destemp varchar(256)
)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/save_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SET NOCOUNT ON
	
	IF EXISTS(
		SELECT idarquivotemp FROM tb_arquivosidigitalclass_temp
		WHERE idarquivotemp = @idarquivotemp
	)
	BEGIN
	
		UPDATE tb_arquivosidigitalclass_temp
		SET
			desprofessor = @desprofessor,
			dessala = @dessala,
			dtaula = @dtaula,
			instatus = @instatus,
			dtalterado = GETDATE(),
			destemp = @destemp
		WHERE idarquivotemp = @idarquivotemp
		
		SET NOCOUNT OFF
		
		SELECT @idarquivotemp as idarquivotemp
	END
	ELSE
	BEGIN
		
		INSERT INTO tb_arquivosidigitalclass_temp
		(
			desprofessor,
			dessala,
			dtaula,
			instatus,
			destemp
		)VALUES(
			@desprofessor,
			@dessala,
			@dtaula,
			@instatus,
			@destemp
		)
		
		SET NOCOUNT OFF
		
		SELECT SCOPE_IDENTITY() as idarquivotemp
		
	END
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_aula_arquivosidigitalclass_temp_list] 
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_aula_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		a.idarquivotempcaminho,
		a.idarquivotemp,
		a.idprofessor,
		b.apelido as desprofessor,
		e.CODIGO as idperiodo,
		e.DESCRICAO as desperiodo,
		a.idturma,
		c.NOME as desturma,
		a.iddisciplina,
		d.NOME as desdisciplina,
		a.dtaula,
		a.descaminho
	FROM 
	tb_arquivosidigitalclass_temp_caminho a
	INNER JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.idprofessor
	INNER JOIN SONATA.SOPHIA.SOPHIA.TURMAS c ON c.CODIGO = a.idturma
	INNER JOIN SONATA.SOPHIA.SOPHIA.DISCIPLINAS d ON d.CODIGO = a.iddisciplina
	INNER JOIN SONATA.SOPHIA.SOPHIA.PERIODOS e ON e.CODIGO = c.PERIODO
	WHERE idarquivotemp = @idarquivotemp
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_reprocessar]
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/reprocessar_arquivotemp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	UPDATE tb_arquivosidigitalclass_temp
	SET
		instatus = 0
	WHERE idarquivotemp = @idarquivotemp
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_list]
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/list_arquivos_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SELECT 
		a.idarquivotemp,
		a.desprofessor,
		a.dessala,
		a.dtaula,
		a.instatus,
		a.dtalterado,
		a.destemp,
		a.dtcadastro,
		(	
			SELECT ISNULL(COUNT(idarquivotemp), 0) 
			FROM tb_arquivosidigitalclass_temp_caminho b
			WHERE
				b.idarquivotemp = a.idarquivotemp
		) as nrauladestino
	FROM tb_arquivosidigitalclass_temp a
	ORDER BY 
		instatus, dtaula desc, dessala, desprofessor
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_activate]
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	SET NOCOUNT ON
	
	UPDATE tb_arquivosidigitalclass_temp
	SET
		dtalterado = GETDATE()
	WHERE idarquivotemp = @idarquivotemp
	
	SET NOCOUNT OFF
	
	SELECT @idarquivotemp as idarquivotemp
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_remove]
(@idarquivotemp int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	DELETE tb_arquivosidigitalclass_temp_caminho
	WHERE idarquivotemp = @idarquivotemp
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_arquivosidigitalclass_temp_add]
(@idarquivotemp int, @codprofessor int, @codperiodo int, @codturma int, @coddisciplina int, @dtaula varchar(10))
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/edit_arquivosidigitalclass_temp.php
  author: Massaharu
  date: 01/01/2015
*/
BEGIN
	
	DECLARE @descaminho varchar(300)
	
	SET @descaminho = 
		CAST(REPLACE((SELECT DESCRICAO FROM SONATA.SOPHIA.SOPHIA.PERIODOS WHERE CODIGO = @codperiodo), '/', '-') AS VARCHAR(10))+'/'+
		CAST((SELECT NOME FROM SONATA.SOPHIA.SOPHIA.TURMAS WHERE CODIGO = @codturma) AS VARCHAR(20))+'/'+
		CAST(@coddisciplina AS VARCHAR(10))+'/'+
		@dtaula
	
	INSERT INTO tb_arquivosidigitalclass_temp_caminho 
	(idarquivotemp, descaminho, idprofessor, idturma, iddisciplina, dtaula)
	VALUES
	(@idarquivotemp, @descaminho, @codprofessor, @codturma, @coddisciplina, @dtaula)
END
------------------------------------------------------------------------
CREATE PROC [dbo].[sp_xmlteam_idigitalclass_table_update]
(@CODTURMASOPHIA int, @CODTURMAIDIGITALCLASS int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/update_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
  desc: Procedure que recebe as informações do XML do Idigital Class e salva na tabela que vincula 
		os dados do Idigital Class antigo com o novo
*/
BEGIN
	
	IF NOT EXISTS(
		SELECT * FROM tb_xmlteam_idigitalclass
		WHERE CODTURMASOPHIA = @CODTURMASOPHIA AND CODTURMAIDIGITALCLASS = @CODTURMAIDIGITALCLASS
	)
	BEGIN
		
		INSERT INTO tb_xmlteam_idigitalclass 
		(CODTURMASOPHIA, CODTURMAIDIGITALCLASS)
		VALUES
		(@CODTURMASOPHIA, @CODTURMAIDIGITALCLASS)

	END
END
-----------------------------------------------------------
CREATE PROC [dbo].[sp_xmldiscipline_idigitalclass_table_update]
(@CODDISCIPLINASOPHIA int, @CODDISCIPLINAIDIGITALCLASS int)
AS
/*
  app: simpacweb
  url: /simpacweb/modulos/fit/idigitalclass/actions/json/update_robot_time_execution.php
  author: Massaharu
  date: 01/01/2015
  desc: Procedure que recebe as informações do XML do Idigital Class e salva na tabela que vincula 
		os dados do Idigital Class antigo com o novo
*/
BEGIN
	
	IF NOT EXISTS(
		SELECT * FROM tb_xmldiscipline_idigitalclass
		WHERE CODDISCIPLINASOPHIA = @CODDISCIPLINASOPHIA AND CODDISCIPLINAIDIGITALCLASS = @CODDISCIPLINAIDIGITALCLASS
	)
	BEGIN
	
		INSERT INTO tb_xmldiscipline_idigitalclass
		(CODDISCIPLINASOPHIA, CODDISCIPLINAIDIGITALCLASS)
		VALUES
		(@CODDISCIPLINASOPHIA, @CODDISCIPLINAIDIGITALCLASS)
	END

END
-----------------------------------------------------------
