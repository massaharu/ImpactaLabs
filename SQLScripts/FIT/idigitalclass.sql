USE FIT_NEW

Videos 
SELECT * FROM tb_arquivosidigitalclass
SELECT * FROM tb_idigitalclassaulas
SELECT * FROM tb_idigitalclassaulas_arquivos
SELECT * FROM tb_idigitalclassaulas_avaliacao
SELECT * FROM tb_arquivosidigitalclass_temp
SELECT * FROM tb_arquivosidigitalclass_temp_caminho



--DELETE FROM tb_arquivosidigitalclasstipo 
--DELETE FROM tb_idigitalclassaulas_arquivos
--DELETE FROM tb_arquivosidigitalclass
--DELETE FROM tb_idigitalclassaulas 

INSERT INTO tb_arquivosidigitalclass (desarquivo, nrtamanho, idarquivotipo, descaminho)
VALUES('echo-hereweare6.mp4', 5360, 2, '2014-2/CDT - 3A/6/2014-12-17')

INSErT INTO tb_idigitalclassaulas_arquivos(idarquivo, idaula)
VALUES (97, 32),(98, 32),(99, 32),(100, 32),(101, 32),(102, 32)


-----------------------------------------------------------
------------------- TABLES --------------------------------
-----------------------------------------------------------
CREATE TABLE tb_arquivosidigitalclasstipo(
	idarquivotipo int IDENTITY CONSTRAINT PK_arquivosidigitalclasstipo PRIMARY KEY,
	desarquivotipo varchar(200) not null,
	instatus bit CONSTRAINT DF_arquivosidigitalclasstipo_instatus DEFAULT(1),
	dtcadastro datetime CONSTRAINT DF_arquivosidigitalclasstipo_dtcadastro DEFAULT(getdate())
)

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

ALTER TABLE tb_arquivosidigitalclass ADD
incopiado bit CONSTRAINT DF_arquivosidigitalclass_incopiado DEFAULT 0



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
 INSERT INTO tb_idigitalclassaulas (idcodfisica, idcodturma, idcoddisciplina, desdescricao, dtaula)
 VALUES (18777, 2608, 6, 'Descrição pré-aula', '2014-12-05')

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
-----------------------------------------------------------


-----------------------------------------------------------
----------------- PROCEDURES ------------------------------
-----------------------------------------------------------
ALTER PROC sp_idigitalclassaula_get
(@idaula int)
AS
/*
  app: FIT_NEW
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

sp_idigitalclassaula_get 1
-----------------------------------------------------------
ALTER PROC sp_idigitalclassaula_save
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
  app: FIT_NEW
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

sp_idigitalclassaula_save 
	@idaula = 0,
	@idcodfisica  = 18777,
	@idcodturma = 2579,
	@idcoddisciplina  = 470,
	@desdescricao = 'João',
	@dtaula  = '2014-10-23',
	@instatus = 1
	
sp_arquivosidigitalclass_save 0, 'original.mp4', 5588, 2, '2014-2/RC 3A/470/2014/10/23', 1	

sp_idigitalclassaulaarquivo_add 80, 120
	
SELECT * FROM SONATA.SOPHIA.SOPHIA.TURMAS
WHERE PERIODO = 125
ORDER BY NOME 
-----------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_get
(@idarquivo int)
AS
/*
  app: FIT_NEW
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

SELECT * FROM tb_arquivosidigitalclass
-----------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_save
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
  app: FIT_NEW
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
CREATE PROC sp_idigitalclassaulaarquivo_add
(@idaula int, @idarquivo int)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	INSERT INTO tb_idigitalclassaulas_arquivos
	VALUES (@idaula, @idarquivo)
END
-----------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_remove
(@idaula int, @idsarquivo int)
AS
/*
  app: FIT_NEW
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

tb_arquivosidigitalclass tb_idigitalclassaulas_arquivos
-----------------------------------------------------------
ALTER PROC sp_idigitalclassaulasbydisciplina_list
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
  app: FIT_NEW
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
				a.idaula,-
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
ALTER PROC sp_idigitalclassbyperiodo_list
(
	@idcodperiodo int = NULL,
	@data_de datetime,
	@data_ate datetime,
	@idarquivotipo int,
	@idcodprofessor int = NULL
)
AS
/*
  app: FIT_NEW
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

SELECT * FROM tb_idigitalclassaulas
sp_idigitalclassbyperiodo_list 125, '2014-08-11 00:00:00', '2015-03-13 23:59:59', 1, 18777
-----------------------------------------------------------
ALTER PROC sp_arquivosidigitalclasspreaula_list
(
	@idaula int,
	@idturma int = null,
	@iddisciplina int = null,
	@dtaula datetime = null
)
AS
/*
  app: FIT_NEW
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
--
SELECT * FROM tb_idigitalclassaulas

sp_arquivosidigitalclasspreaula_list 0, 24, 1, '2014-10-08'
-----------------------------------------------------------
ALTER PROC sp_arquivosidigitalclassvideo_list
(
	@idaula int,
	@idturma int = null,
	@iddisciplina int = null,
	@dtaula datetime = null
)
AS
/*
  app: FIT_NEW
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
ALTER PROC sp_idigitalclassaulas_avaliacao_save
(@idaula int, @idaluno int, @nrnota int)
AS
/*
  app: FIT_NEW
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
CREATE PROC sp_idigitalclassaulas_avaliacao_get
(@idaula int)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	SELECT AVG(nrnota) media, COUNT(*) nrrates FROM tb_idigitalclassaulas_avaliacao
	WHERE idaula = @idaula
	GROUP BY idaula
END

sp_idigitalclassaulas_avaliacao_get 36
-----------------------------------------------------------
CREATE PROC sp_arquivosidigitalclass_list 
(@incopiado int = NULL)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN

	IF @incopiado IS NULL
	BEGIN
		SELECT
			idarquivo,
			desarquivo,
			nrtamanho,
			idarquivotipo,
			descaminho,
			instatus,
			dtcadastro,
			incopiado
		FROM tb_arquivosidigitalclass
	END
	ELSE
	BEGIN
		SELECT
			idarquivo,
			desarquivo,
			nrtamanho,
			idarquivotipo,
			descaminho,
			instatus,
			dtcadastro,
			incopiado
		FROM tb_arquivosidigitalclass
		WHERE incopiado = @incopiado
	END
END

sp_arquivosidigitalclass_list 0 
-----------------------------------------------------------
CREATE PROC sp_arquivosidigitalclassincopiado
(@idarquivo int, @incopiado int)
AS
/*
  app: FIT_NEW
  url: inc/_class/idigitalclassAula.php
  author: Massaharu
  date: 01/12/2014
*/
BEGIN
	
	UPDATE tb_arquivosidigitalclass
	SET
		incopiado = @incopiado
	WHERE 
		idarquivo = @idarquivo
END
-----------------------------------------------------------
-----------------------------------------------------------
SELECT * FROM SONATA.SOPHIA.SOPHIA.CURSOS
SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA WHERE CODIGO = 25695
SELECT * FROM SONATA.SOPHIA.SOPHIA.MATRICULA WHERE CODIGO = 37096
SELECT * FROM Vendas..tb_arquivos
SELECT * FROM Vendas..tb_arquivotipos
SELECT * FROM Vendas..tb_arquivo
SELECT * FROM tb_arquivosidigitalclasstipo 
SELECT * FROM tb_arquivosidigitalclass
SELECT * FROM tb_idigitalclassaulas
SELECT * FROM tb_idigitalclassaulas_arquivos
SELECT * FROM tb_idigitalclassaulas_avaliacao

INSERT INTO tb_idigitalclassaulas (idcodfisica, idcodturma, idcoddisciplina, desdescricao, dtaula)
VALUES
(18777, 2608, 6, 'descrição', '2015-01-01'),
(18777, 2608, 6, 'descrição', '2015-01-02'),
(18777, 2608, 6, 'descrição', '2015-01-03'),
(18777, 2608, 6, 'descrição', '2015-01-04'),
(18777, 2608, 6, 'descrição', '2015-01-05'),
(18777, 2608, 6, 'descrição', '2015-01-06'),
(18777, 2608, 6, 'descrição', '2015-01-07'),
(18777, 2608, 6, 'descrição', '2015-01-08'),
(18777, 2608, 6, 'descrição', '2015-01-09'),
(18777, 2608, 6, 'descrição', '2015-01-10'),
(18777, 2608, 6, 'descrição', '2015-01-11'),
(18777, 2608, 6, 'descrição', '2015-01-12'),
(18777, 2608, 6, 'descrição', '2015-01-13'),
(18777, 2608, 6, 'descrição', '2015-01-15'),
(18777, 2608, 6, 'descrição', '2015-01-16'),
(18777, 2608, 6, 'descrição', '2015-01-17'),
(18777, 2608, 6, 'descrição', '2015-01-18'),
(18777, 2608, 6, 'descrição', '2015-01-19'),
(18777, 2608, 6, 'descrição', '2015-01-20'),
(18777, 2608, 6, 'descrição', '2015-01-21'),
(18777, 2608, 6, 'descrição', '2015-01-22'),
(18777, 2608, 6, 'descrição', '2015-01-23'),
(18777, 2608, 6, 'descrição', '2015-01-24'),
(18777, 2608, 6, 'descrição', '2015-01-25'),
(18777, 2608, 6, 'descrição', '2015-01-26'),
(18777, 2608, 6, 'descrição', '2015-01-27'),
(18777, 2608, 6, 'descrição', '2015-01-28'),
(18777, 2608, 6, 'descrição', '2015-01-29'),
(18777, 2608, 6, 'descrição', '2015-01-30')
---------------------------------------------------

SELECT * FROM SONATA.SOPHIA.SOPHIA.

SELECT c.CODEXT, c.NOME, a.apelido, a.identificacao, b.desprofessor, b.deslogin FROM SONATA.SOPHIA.SOPHIA.FUNCIONARIOS a
INNER JOIN SONATA.SOPHIA.SOPHIA.FISICA c ON c.CODIGO = a.COD_FUNC
RIGHT JOIN (
	SELECT desprofessor, deslogin FROM tb_loginsfit
) b ON b.deslogin COLLATE Latin1_General_CI_AI = a.apelido COLLATE Latin1_General_CI_AI 
ORDER BY b.desprofessor

SELECT * FROM SONATA.SOPHIA.SOPHIA.FISICA a
LEFT JOIN SONATA.SOPHIA.SOPHIA.FUNCIONARIOS b ON b.COD_FUNC = a.CODIGO
WHERE a.nome like '%padilha%'

SELECT '%'+REPLACE('Alexandre de Alcântara', ' ', '%')+'%'

CREATE TABLE tb_loginsfit(
	desprofessor varchar(200),
	deslogin varchar(100)
)
INSERT INTO tb_loginsfit VALUES
('Adilson Ferreira da Silva','Adilson.Silva'),
('Adilson Taub Junior','adilson'),
('Adriano Augusto Fonte','Adriano'),
('Adriano Augusto FonteAdriano Augusto Fonte','apadilha'),
('Alberto de Medeiros Junior','amedeiros'),
('Alessandra Faria','afaria'),
('Alex Florian Heilmair','Alex.Heilmair'),
('Alexandra Souza','Asouza'),
('Alexandre de Alcântara','aalcantara'),
('Alexandre Miranda','alexandre.miranda'),
('Alexandre Morais de Souza','Alexandre'),
('Alexandre Oliveira','oliveira'),
('Alexandre Salvador','asalvador'),
('Alexandre Tomoyose','atomoyose'),
('Alvaro Toshio Takei','alvaro'),
('Amyris Fernandez','afernandez'),
('Ana Cristina dos Santos','asantos'),
('Ana Laura','ana.laura'),
('Ana Lucia da Silva','alsilva'),
('Anchesi Moraes','anchesi'),
('Andre Koide da Silva','asilva'),
('André Luiz Alves dos Santos','Andre.Santos'),
('André Regazzini','ARegazzini'),
('André Ricardi','Aricardi'),
('André Telles','atelles'),
('Andrea Paiva','Andrea'),
('Angelo Palmisano','apalmisano'),
('Anna Cristina Barbosa ','abarbosa'),
('Anselmo de Araujo Couto','acouto'),
('Antonia Joana Vieira','avieira'),
('Antonio Carlos Amorim','acamorim'),
('Antonio Mafra','amafra'),
('Araken Leão','araken'),
('Audilene Guirau','Audilene'),
('Aurélio Paixão','apaixão'),
('Ayao Okamoto','aokamoto'),
('Benjamin Rosenthal','brosenthal'),
('Bruno Canato','Bruno.Canato'),
('Bruno Kalkevicius','bkalkevicius'),
('Bruno Luis Soares de Lima','blima'),
('Bruno Melo','bmelo'),
('Cacilda Costha','ccostha'),
('Calil Farra','cmfarra'),
('Cândida Almeida','calmeida'),
('Carlos Coelho','ccoelho'),
('Carlos Eduardo Chaves','Cchaves'),
('Carlos Eduardo Falcão Lima','clima'),
('Carlos Henrique Verissímo','cverissimo'),
('Carlos Henrique Veríssimo Pereira','Carlos.Pereira'),
('Carlos Silva','cacsilva'),
('Carmem Ozores','carmem'),
('Cássia Tokoy','ctokoy'),
('Celso Marini','Celso'),
('Claudia Jorqueira','cjorqueira'),
('Claudio Dalmolim','cdalmolim'),
('Claudio Nascimento Filho','cnascimento'),
('Clayton Barbosa','clayton'),
('Clayton Barbosa','cbarbosa'),
('Clovis Costa','ccosta'),
('Cristiane Gatti','Cristiane.Gatti'),
('Cristiane Lindner','clindner'),
('Cristina Sleiman','csleiman'),
('Daiana Haddad','dhaddad'),
('Danilo Cruz','Danilo.Cruz'),
('David de Oliveira Lemes','David'),
('David de Prado','dprado'),
('David Kato','dkato'),
('Denis Andrade','Denis.Andrade'),
('Denise Pithan','dpithan'),
('Diego Corazza','dcorazza'),
('Edilson Ferreira da Silva','esilva'),
('Edson Predolin','epredolin'),
('Edson Tiharu Tsukimoto','etsukimoto'),
('Eduardo Ribeiro Gonçalves Affonso','Eduardo.Affonso'),
('Egon Hannes','ehannes'),
('Eliana M. de Melo','emelo'),
('Elisa Muniz','emuniz'),
('Eliseu Santiago','eliseu'),
('Emerson Ferreira','EFer'),
('Enock Godoy','Enock'),
('Erick Formaggio','eformaggio'),
('Erick Herdy','eherdy'),
('Euripedes Magalhães','emagalhaes'),
('Fabiano Madeira','fmadeira'),
('Fabio Furia Silva','ffuria'),
('Fabio Macedo','FMacedo'),
('Fabio Nogueira de Campos','FCampos'),
('Fabio Oliveira Teixeira','fteixeira'),
('Fabio Pereira Espíndola','fespindola'),
('Fabricio Simao','fsimao'),
('Felipe Morais','fmorais'),
('Fernado Mello','fmello'),
('Fernanda Carolina Armando Duarte','Fernanda.Duarte'),
('Fernanda de Lima Alcantara','falcantara'),
('Fernando Carbone','fcarbone'),
('Fernando Fonseca','Ffonseca'),
('Fernando Sequeira Sousa','fsequeira'),
('Flavia Penido','fpenido'),
('Flavia Tavares Gasi','Flavia.Gasi'),
('Flavio Pavanelli','FPavanelli'),
('Flávio Sousa Silva','fsilva'),
('Francesca Romanelli','Francesca'),
('Francisco Diniz','FDiniz'),
('Gabriel Aguilar','gaguilar'),
('Gabriella Marques','Gabriella.Marques'),
('Gil Giardelli','ggiardelli'),
('Gilberto Alves Pereira','gpereira'),
('Gilberto Perez','gperez'),
('Gilson Gonçalves','ggoncalves'),
('Giselda Fernanda Pereira','Giselda'),
('Giuliano Giova','ggiova'),
('Glaucia Jacuk Herman','gherman'),
('Glauco Reis','Glauco'),
('Guilherme Buissa','gbuissa'),
('Guilhermo Reis','greis'),
('Gustavo Biembengut Santade','gsantade'),
('Gustavo Borges','gborges'),
('Gustavo Hollatz','hollatz'),
('Gustavo Maia','gmaia'),
('Gustavo Santos','gsantos'),
('Gustavo Zanotto','gzanotto'),
('Gutenberg Silveira','gsilveira'),
('Hélio Cordeiro','hcordeiro'),
('Helvio Pereira Camargo','hcamargo'),
('Hermínio Magalhaes','hmagalhaes'),
('Higor Vinicius Nogueira Jorge','higor'),
('Humberto Lotito','HLotito'),
('Igor Magrini','IMagrini'),
('Irene Gentili','igentilli'),
('Islane Lucena','ilucena'),
('Israel Florentino dos Santos','Israel'),
('Ivair Lima','Ivair.Lima'),
('Iza Melão','imelao'),
('Iza Melão','Iza'),
('Jaakko Tamela','JTamela'),
('Janaina Veneziani','jveneziani'),
('Jankel Fuks','jfuks'),
('Jeferson Barros','Jeferson.Barros'),
('Jeferson Pereira - Instrutor','JPereira'),
('Jefferson D´addario','Jefferson'),
('João Cerqueira','João.Cerqueira'),
('Jorge Inafuco','Jorge'),
('José Edmir Pininga Duque','jduque'),
('José Mariano de Araujo Filho','jmariano'),
('Jose Severino da Silva','jsilva'),
('Juan Caetano','jcaetano'),
('Julia Alves de Farias','Julia'),
('Julio Avero','javero'),
('Jussara Pimentel Matos','Jussara'),
('Juvenal Santana','JSantana'),
('Karl Klauser','karl'),
('Laura Ramos Pimentel Pinho','LPinho'),
('Leandro Bissoli','lbissoli'),
('Leon Kulikowski','leon'),
('Leonardo Massayuki Takuno','ltakuno'),
('Leonardo Naressi','lnaressi'),
('Leonardo Xavier','lxavier'),
('Liliane Bíscaro Nogueira','lnogueira'),
('Luciano Pontes','Lpontes'),
('Luciano Rodrigues','lrodrigues'),
('Luis Ruivo','lruivo'),
('Luiz Brigatti','lbrigatti'),
('Luiz Rabelo','lrabelo'),
('Luiz Wagner Russo','lrusso'),
('Maikon Demacq','maikon'),
('Marcel Ginotti Pires','Marcel'),
('Marcelo Aoki','Marcelo.Aoki'),
('Marcelo Boaratti','mboaratti'),
('Marcelo Lovizzaro','mlovizzaro'),
('Marcelo Machado','Marcelo'),
('Marcelo Oliveira','moliveira'),
('Marcelo Trevisani','mtrevisani'),
('Marcio Almeida Mendes','Marcio.Mendes'),
('Márcio Rogério de Oliveira','mroliveira'),
('Marco Araujo','maraujo'),
('Marcos Assis','massis'),
('Marcos Hiller','hiller'),
('Maria Alice Ferreira','MFerreira'),
('Marinei Sassi','Marinei'),
('Maritsa Carvalho','mcarvalho'),
('Maritza Maura','mmaura'),
('Mark Alexandre Breno','Mark'),
('Marlise Almeida da Silveira Costa','mcosta'),
('Marta Fuzioka','mfuzioka'),
('Matheus Haddad','matheus'),
('Mauricio dos Santos Casagrande','Casagrande'),
('Maurício Miyasaki','mmiyasaki'),
('Maurício Salvador','msalvador'),
('Mauricio Soares Capela','msoares'),
('Mauricio Weilwe Orellana','morellana'),
('Mauro Lemos','mlemos'),
('Melania Vaz','mvaz'),
('Melina Alves','melina'),
('Mercy Escalante Ludeña','mercy'),
('Michely Vogel','Michely'),
('Nádia Guimarães','nguimaraes'),
('Nanete','Nanete'),
('Newton Donadio Junior','njunior'),
('Newton Molon','nmolon'),
('Nicolau Andre Campaner Centol - Professor','nicolau'),
('Nilson Salvetti','NSalvetti'),
('Onofrio Notarnicola Filho','ofilho'),
('Osvaldo Kotaro Takai','otakai'),
('Oswaldo Kotaro Takai','Okotaro'),
('Patricia Barcelos','pbarcelos'),
('Patricia Mourthé','PMourthe'),
('Patricia Sodre','Psodre'),
('Paula Marsilli','paula'),
('Paulo Floriano','Paulo.Floriano'),
('Paulo Pinho','ppinho'),
('Paulo Schiavon','Pschiavon'),
('Paulo Sérgio Marin','Paulo.Marin'),
('Pedro Kiszka','Pedro.Kiszka'),
('Pedro Kiszka','pkiszka'),
('Pedro Kiszka Junior','Pedro.Junior'),
('Pedro Paulo Mendes Alves','palves'),
('Plinio Barbieri Filho','Plinio'),
('Rafael Quaresma','rquaresma'),
('Rafael Soares Ferreira','rferreira'),
('Raquel da Silva Oliveira','roliveira'),
('Reinaldo Boesso','Reinaldo'),
('Reinaldo Stirbolov','rstirbolov'),
('Reinaldo Zampieri','rzampieri'),
('Renan Cristiano Rocha Rodrigues','renan'),
('Renan Rodrigues','rrodrigues'),
('Renata Ramos Jacuk','Rjacuk'),
('Renata Wada','rwada'),
('Renato Gosling','rgosling'),
('Renato Richter','rrichter'),
('Ricardo Barbosa','rbarbosa'),
('Ricardo Castro','rcastro'),
('Ricardo Gedra','RGedra'),
('Ricardo Gouvêa','rgouvea'),
('Ricardo Longo','RLongo'),
('Ricardo Ribeiro Tavares','rtavares'),
('Ricardo Rodrigues','Ricardo.Rodrigues'),
('Robert Willians','robert'),
('Roberta Cesar','rcesar'),
('Roberto Angelo','rangelo'),
('Roberto Oliveira Wajnsztok','Wajnsztok'),
('Roberto Pereira','rpereira'),
('Roberval França','Roberval'),
('Robson Santos','rsantos'),
('Robson Tavares','Robson'),
('Rodolfo da Silva Avelino','ravelino'),
('Rodrigo Antão','rantao'),
('Rodrigo Cunha da Silva','Rodrigo'),
('Rodrigo de Oliveira Mourão','rmourao'),
('Rodrigo Escudeiro','rescudeiro'),
('Rogério Takimoto','Rtakimoto'),
('Ronaldo Marques da Silva','rsilva'),
('Ronie Miguel Uliana','ronie'),
('Rony Vainzof','rony'),
('Rubens Ifraim','Rubens'),
('Rui Sergio Dias Alão','ralao'),
('Samuel Menezes','Samuel'),
('Samyra Ribeiro','Samyra.Ribeiro'),
('Sand Jaques Onofre','Sand'),
('Sandro Jose Cajé da Paixão','spaixao'),
('Sebastian David O. Galvao','sgalvao'),
('Seizo Soares','Seizo'),
('Sergio Arabage','sarabage'),
('Sergio Costa Lage','slage'),
('Sergio Jose Meurer','smeurer'),
('Sergio Lage Teixeira Carvalho','scarvalho'),
('Sergio Schiratto','SSchiratto'),
('Sergio Seloti','sseloti'),
('Silvia Dotta','sdotta'),
('Silvio Mota','smota'),
('Solange Oliveira','soliveira'),
('Sthefan Gabriel','sgabriel'),
('Sueli Fernandes Ferreira Bernardi','sbernardi'),
('Tatiana Ferraz Lagana','tlagana'),
('Teo Panella','tpanella'),
('Thais Campas','tcampas'),
('Thiago Castilho Marcoantonio','TCastilho'),
('Thiago Gringon','tgringon'),
('Thiago Sarraf','Tsarraf'),
('Thomas Preto Gonçalves','thomas'),
('Tiago Barcelos','tbarcelos'),
('Tiago Rafael Sales de Souza','Tiago.Souza'),
('Tiburcio Ramos dos Santos','tsantos'),
('Urbano Nosoja Nobre','urbano'),
('Valderes','Valderes'),
('Valeria Costa','vacosta'),
('Valter Lacerda de Andrade Junior','vjunior'),
('Vanderson Gomes Bossi','vbossi'),
('Vanessa Melo','vmelo'),
('Vanessa Santos Lessa','Vanessa'),
('Vera Monteiro','vmonteiro'),
('Vicente Goes','vgoes'),
('Victor Vieira','vvieira'),
('Vinicius Laranja','vlaranja'),
('Vinicius Menezes','vinicius'),
('Viviane Teixeira Bezerra','viviane'),
('Wagner Elias','welias'),
('Waldir Mucci','wmucci'),
('Walmir Freitas','wfreitas'),
('Walter Vieira','wvieira'),
('Wander Gomes','wgomes'),
('Welerson Kanup','Wkanup'),
('Yoshimassa Oki','yoki')



SELECT * FROM tb_loginsfit